<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SyncController
 *
 * @author niteen
 */
use Cake\Network;
use Cake\ORM\TableRegistry;
use App\Model\Table;

class SyncController extends AppController {

    public $userTable = "USER";
    public $destTable = "DESTINATION";
    public $queTable = "QUESTION";
    public $answerTable = "ANSWER";
    public $LikeTable = "LIKECOUNT";
    public $CommentTable = "COMMENT";

    public function connect() {
        return TableRegistry::get('sync');
    }

    public function getTableObj() {
        return new Table\SyncTable();
    }

    public function userEntry($allUser , $newUser) {
            foreach ($allUser as $user) {
                if($user['Active'] == 1){
               $this->getTableObj()->Insert($user['UserId'], json_encode($newUser), $this->userTable);
                }
            }
    }

    public function destEntry($Id) {
        $DestObj = new DestinationController;
        $UserObj = new UserController;
            $destList = $DestObj->getNewDest($Id);
            $allUser = $UserObj->getAllUser();
            $i = 0;
            foreach ($allUser as $user) {
                if ($user['Active'] == 1) {
                    $this->getTableObj()->Insert($user['UserId'], json_encode($destList), $this->destTable);
                }
            }
        
    }

    public function questionEntry($Id) {
        $QuestionObj = new QuestionController;
        $UserObj = new UserController;
            $Que = $QuestionObj->getNewQuestion($Id);
            $allUser = $UserObj->getAllUser();
            $i = 0;
            foreach ($allUser as $user) {
                if ($user['Active'] == 1) {
                    $this->getTableObj()->Insert($user['UserId'], json_encode($Que), $this->queTable);
                }
            }
        
        
    }
    public function answerEntry($AnswerId,$UserId) {
        $AnswerObj = new AnswerController;
        $UserObj = new UserController;
            $Review = $AnswerObj->newAnswer($AnswerId);
            $allUser = $UserObj->getAllUser();
            foreach ($allUser as $user) {
                if ($user['Active'] == 1 and $user['UserId'] != $UserId) {
                    $this->getTableObj()->Insert($user['UserId'], json_encode($Review), $this->answerTable);
                }
            }
        
    }
    public function likeEntry($UserId,$json) {
         $UserObj = new UserController;
          $allUser = $UserObj->getAllUser();
           foreach ($allUser as $user) {
                if ($user['Active'] == 1 and $user['UserId'] != $UserId) {
                    $this->getTableObj()->Insert($user['UserId'], $json, $this->LikeCommentTable);
                }
            }
    }
    public function commentEntry($UserId,$json) {
        $UserObj = new UserController;
          $allUser = $UserObj->getAllUser();
           foreach ($allUser as $user) {
                if ($user['Active'] == 1 and $user['UserId'] != $UserId) {
                    $this->getTableObj()->Insert($user['UserId'], $json, $this->CommentTable);
                }
            }
    }

    public function download() {
        $queryData = $this->request->input('json_decode');
        $UserId = $queryData->UserId;
        $Update = $this->getTableObj()->getUpdate($UserId);
        $this->response->type('application/json');
        $this->response->body(json_encode($Update));
        $this->response->send();
        $this->getTableObj()->deleteUpdate($UserId);
    }

}
