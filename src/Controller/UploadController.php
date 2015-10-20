<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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
        $senderId = $queryData->SenderId;
        $senderEmail = $queryData->SenserEmail;
        if(1)
        foreach ($queryData->data as $index => $record) {
            foreach ($record as $key => $value) {
                switch ($key) {
                    case $this->table['TC']:
                        $this->comment($value,$senderId,$senderEmail);
                        break;
                    case $this->table['TL']:
                        $this->like($value,$senderId,$senderEmail);
                        break;
                    case $this->table['TA']:
                        $this->answer($value,$senderId,$senderEmail);
                        break;
                    case $this->table['TU']:
                        $this->user($value,$senderId,$senderEmail);
                        break;
                    case $this->table['TI']:
                        $this->image($value,$senderId,$senderEmail);
                }
            }
        }
    }

    private function comment($comment) {
     $commentDto = new DTO\ClsCommentAndLikeDto($comment->UserId, $comment->DestId, $likeCount = null, $comment->CommentText);
     $commentAndLikeController = new CommentAndLikeController();
      \Cake\Log\Log::info('Comment DTO object send to submit');
     if($commentAndLikeController->submitComment($commentDto)){
         $syncController = new SyncController();
         $json = '{"UserId":"'.$commentDto->UserId.'","DestID":"'.$commentDto->DestId.'","CommentText":"'.$commentDto->CommentText.'"}';
         $syncController->commentEntry($commentDto->UserId, $json);
     }
    
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
        if($answercontroller->submit($answerDto)){
            $syncController = new SyncController();
            $json = '{"UserId":"'.$answerDto->UserId.'","DestId":"'.$answerDto->DestId.'","OptionId":"'.$answerDto->OptionId.'"}';
            $syncController->answerEntry($AnswerId, $UserId);
        }
    }

    private function user($user) {
        
    }
    private function image($image) {
        
    }
    private function userValidation($userID,$userEmail) {
        
    }

}
