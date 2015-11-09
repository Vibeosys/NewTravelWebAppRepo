<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use App\DTO;

/**
 * Description of UploadController
 *
 * @author niteen
 */
class UploadController extends ApiController {

    private $table = array("TC" => "comment", "TL" => "like", "TA" => "answer", "TU" => "user", "TI" => "image");

    public function up() {
        $this->autoRender = false;

       // $json = null;
        $json = $this->request->input();
      
        \Cake\Log\Log::debug("Checking is request empty or not");
        if (empty($json)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(104));
            \Cake\Log\Log::error("User requested with invalid data");
            return;
        }

        $arr = DTO\ClsUploadDeserializerDto::Deserialize($json);
        if(empty($arr->user) or empty($arr->data)){
            $this->response->body(DTO\ClsErrorDto::prepareError(117));
             return ;
        }
       
        $user = DTO\ClsUserDto::Deserialize($arr->user);
        if ($this->userValidation($user->userId, $user->emailId, $user->userName)) {
            $senderUserId = $user->userId;
            foreach ($arr->data as $index => $record) {
                \Cake\Log\Log::info('Index : '.$index.'Record :'.$record->tableName);
                switch ($record->tableName) {
                    case $this->table['TC']:
                        \Cake\Log\Log::info("Comment section");
                        $commentDto = DTO\ClsCommentAndLikeDto::Deserialize($record->tableData);
                        $this->comment($senderUserId, $commentDto);
                        break;
                    case $this->table['TL']:
                        $likeDto = DTO\ClsCommentAndLikeDto::Deserialize($record->tableData);
                        $this->like($user->userId,$likeDto);
                        break;
                    case $this->table['TA']:
                        $answerDto = DTO\ClsAnswerDto::Deserialize($record->tableData);
                        \Cake\Log\Log::debug("Accepted Answer data");
                        $this->answer($user->userId,$answerDto);
                        break;
                    case $this->table['TU']:
                        $userDto = DTO\ClsUserDto::Deserialize($record->tableData);
                        $this->user($user->userId,$userDto);
                        break;
                    case $this->table['TI']:
                        $imageDto = DTO\ClsImagesDto::Deserialize($record->tableData);
                        $this->image($imageDto);
                        break;
                }
            }
        } else {
            $this->response->body(DTO\ClsErrorDto::prepareError(100));
        }
    }

    private function comment($senderUserId, $commentDto) {
        $commentAndLikeController = new CommentAndLikeController();
        \Cake\Log\Log::info('Comment DTO object send to submit');
        if ($commentAndLikeController->submitComment($senderUserId,$commentDto)) {
            \Cake\Log\Log::debug("Comment stored in database");
        }
    }

    private function like($senderUserId,$likeDto) {
        $likeController = new CommentAndLikeController();
        \Cake\Log\Log::info('Like DTO object send to submit');
        $likeController->submitLike($senderUserId,$likeDto);
    }

    private function answer($senderUserId,$answerDto) {

        $answercontroller = new AnswerController();
        \Cake\Log\Log::info('Answer DTO object send to submit');
        if ($answercontroller->submit($senderUserId,$answerDto)) {
            $this->response->body(DTO\ClsErrorDto::prepareSuccessMessage("Answer Saved"));
            \Cake\Log\Log::debug("Answer stored in database");
        }
    }

    private function images($imageDto) {
      
        $imagecontroller = new ImagesController();
        if ($imagecontroller->saveImages($imageDto)) {
            \Cake\Log\Log::debug("Images saved in local Database");
        }
    }

    public function userValidation($userid, $usermail, $userName) {
        $userTable = new Table\UserTable();
        if ($userTable->userCkeck($userid, $usermail, $userName)) {
            return SUCCESS;
        }
        return FAIL;
    }

}
