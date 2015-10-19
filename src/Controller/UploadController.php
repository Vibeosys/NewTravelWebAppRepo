<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cake\Network;
use App\DTO;

/**
 * Description of UploadController
 *
 * @author niteen
 */
class UploadController extends AppController {

    private $table = array("TC" => "Comment", "TL" => "Like", "TA" => "Answer", "TU" => "User","TI"=>"Image");

    public function up() {
        $this->autoRender = false;
        $queryData = $this->request->input('json_decode');
        foreach ($queryData->data as $index => $record) {
            foreach ($record as $key => $value) {
                switch ($key) {
                    case $this->table['TC']:
                        $this->comment($value);
                        break;
                    case $this->table['TL']:
                        $this->like($value);
                        break;
                    case $this->table['TA']:
                        $this->answer($value);
                        break;
                    case $this->table['TU']:
                        $this->user($value);
                        break;
                    case $this->table['TI']:
                        $this->image($value);
                }
            }
        }
    }

    private function comment($comment) {
     $commentDto = new DTO\ClsCommentAndLikeDto($comment->UserId, $comment->DestId, $likeCount = null, $comment->CommentText);
     $commentAndLikeController = new CommentAndLikeController();
      \Cake\Log\Log::info('Comment DTO object send to submit');
     $commentAndLikeController->submitComment($commentDto);
    
    }

    private function like($like) {
        $likeDto = new DTO\ClsCommentAndLikeDto($like->UserId, $like->DestId);
        $likeController = new CommentAndLikeController();
         \Cake\Log\Log::info('Like DTO object send to submit');
        $likeController->submitLike($likeDto);
    }

    private function answer($answer) {
        $answerDto = new DTO\ClsAnswerDto($answer->UserId, $answer->DestId, $answer->OptionId);
        $answercontroller = new AnswerController();
         \Cake\Log\Log::info('Answer DTO object send to submit');
        $answercontroller->submit($answerDto);
    }

    private function user($user) {
        
    }
    private function image($image) {
        
    }

}
