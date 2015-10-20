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

    public $userTable = "user";
    public $destTable = "destination";
    public $queTable = "question";
    public $answerTable = "answer";
    public $LikeTable = "like";
    public $CommentTable = "comment";

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
          $allUser = $UserObj->getAllUser($UserId);
           foreach ($allUser as $user) {
                if ($user->Active) {
                    $this->getTableObj()->Insert($user->UserId, $json, $this->LikeTable);
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

    public function download($userid) {
        \Cake\Log\Log::info("in Sync controller download method");
        $Update = $this->getTableObj()->getUpdate($userid);
        if($Update){
        $this->response->type('application/json');
        $this->response->body($Update);
        $this->response->send();
        $this->getTableObj()->deleteUpdate($userid);
        }  else {
        $this->response->body('{"Error":"false", "Message":"Update not found"}');
        $this->response->send();
        }
    }

}
