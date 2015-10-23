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

    private $table = array("TC" => "Comment", "TL" => "Like", "TA" => "Answer", "TU" => "User", "TI" => "Image");

    public function up() {
        $this->autoRender = false;

       // $json = null;
        $json = $this->request->input();
      
        \Cake\Log\Log::debug("Checking is request empty or not");
        if (empty($json)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(104));
            return;
        }

        $arr = DTO\ClsUploadDeserializerDto::Deserialize($json);
        $user = DTO\ClsUserDto::Deserialize($arr->user);
      // $data = DTO\ClsUploadDeserializerDto::Deserialize($arr->data);
      // print_r($arr->data);
        /*
          foreach ($queryData->User as $key => $value){
          //   if($key == 'SenderId'){$this->senderId = $value;}else{$this->sendermail = $value;}
          }
         * 
         */
        if ($this->userValidation($user->UserId, $user->EmailId)) {
            foreach ($arr->data as $index => $record) {
                \Cake\Log\Log::info('Index : '.$index.'REcord :'.$record->tableName);
                switch ($record->tableName) {
                    case $this->table['TC']:
                        \Cake\Log\Log::info("Comment section");
                        $commentDto = DTO\ClsCommentAndLikeDto::Deserialize($record->tableData);
                        $this->comment($commentDto);
                        break;
                    case $this->table['TL']:
                        $likeDto = DTO\ClsCommentAndLikeDto::Deserialize($record->tableData);
                        $this->like($likeDto);
                        break;
                    case $this->table['TA']:
                        $answerDto = DTO\ClsAnswerDto::Deserialize($record->tableData);
                        $this->answer($answerDto);
                        break;
                    case $this->table['TU']:
                        $userDto = DTO\ClsUserDto::Deserialize($record->tableData);
                        $this->user($userDto);
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

    private function comment($commentDto) {
        $commentAndLikeController = new CommentAndLikeController();
        \Cake\Log\Log::info('Comment DTO object send to submit');
        if ($commentAndLikeController->submitComment($commentDto)) {
            \Cake\Log\Log::debug("Comment stored in database");
        }
    }

    private function like($likeDto) {
        $likeController = new CommentAndLikeController();
        \Cake\Log\Log::info('Like DTO object send to submit');
        $likeController->submitLike($likeDto);
    }

    private function answer($answerDto) {

        $answercontroller = new AnswerController();
        \Cake\Log\Log::info('Answer DTO object send to submit');
        if ($answercontroller->submit($answerDto)) {
            \Cake\Log\Log::debug("Answer stored in database");
        }
    }

    private function images($image) {
      
        $imagecontroller = new ImagesController();
        if ($imagecontroller->saveImages($imageDto)) {
            \Cake\Log\Log::debug("Images saved in local Database");
        }
    }

    public function userValidation($userid, $usermail) {
        $userController = new UserController;
        if ($userController->validate($userid, $usermail)) {
            return SUCCESS;
        }
        return FAIL;
    }

}
