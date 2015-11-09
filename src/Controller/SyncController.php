<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


use Cake\ORM\TableRegistry;
use App\Model\Table;
use App\DTO;

/**
 * Description of SyncController
 *
 * @author niteen
 */
class SyncController extends ApiController {

    public $userTable = "user";
    public $destTable = "destination";
    public $queTable = "question";
    public $answerTable = "answer";
    public $likeTable = "like";
    public $commentTable = "comment";
    public $imageTable = "images";
    public $optionTable = "options";
    public $statConfTable = "stat_conf";

    public function connect() {
        return TableRegistry::get('sync');
    }

    public function getTableObj() {
        return new Table\SyncTable();
    }

    public function userEntry($senderUserId, $json,$operation) {
        $userController = new UserController();
        $allUser = $userController->getAllUser();
        foreach ($allUser as $user) {
            if ($user->userId != $senderUserId) {
                $this->getTableObj()->Insert($user->userId, $json, $this->userTable,$operation);
            }
        }
    }

    public function destEntry($json,$operation) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser();
        foreach ($allUser as $user) {
       
                $this->getTableObj()->Insert($user->userId, $json, $this->destTable,$operation);
            
        }
    }

    public function questionEntry($json,$operation) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser();
       
        foreach ($allUser as $user) {
          
                $this->getTableObj()->Insert($user->userId, $json, $this->queTable,$operation);
          
        }
    }
    
    public function optionEntry($json,$operation) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser();
        $i = 0;
        foreach ($allUser as $user) {
          
                $this->getTableObj()->Insert($user->userId, $json, $this->optionTable,$operation);
          
        }
    }
    public function statConfEntry($json,$operation) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser();
        $i = 0;
        foreach ($allUser as $user) {
          
                $this->getTableObj()->Insert($user->userId, $json, $this->statConfTable,$operation);
          
        }
    }
    

    public function answerEntry($senderUserId,$userId,$json, $operation) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser();
        foreach ($allUser as $user) {
            if($user->userId != $userId and $user->userId != $senderUserId){
                $this->getTableObj()->Insert($user->userId,$json, $this->answerTable,$operation);
            
        }}
    }

    public function likeEntry($senderUserId,$userId, $json, $operation) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser($userId);
        foreach ($allUser as $user) {
            if($user->userId != $userId and $user->userId != $senderUserId){
                $this->getTableObj()->Insert($user->userId, $json, $this->likeTable, $operation);
            }
        }
    }

    public function commentEntry($senderUserId,$userId, $json, $operation) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser($userId);
        foreach ($allUser as $user) {
            if($user->userId != $userId and $user->userId != $senderUserId){
            try{
                $this->getTableObj()->Insert($user->userId, $json, $this->commentTable, $operation);
            }  catch (Excption $ex){
                throw  new Exception($ex);
            }
        }}
    }
    
     public function imagesEntry($userId, $json,$operation) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser();
        \Cake\Log\Log::debug("New image enrty in sync table json : ".$json);
        foreach ($allUser as $user) {
          if($user->userId != $userId){
                $this->getTableObj()->Insert($user->userId, $json, $this->imageTable, $operation);
          }
        }
    }

    public function download($userid) {
        $this->autoRender = false;
        \Cake\Log\Log::info("in Sync controller download method");
        $Update = $this->getTableObj()->getUpdate($userid);
        if ($Update) {
           
            $this->response->body(json_encode($Update));
            $this->response->send();
            \Cake\Log\Log::debug("Update send to User : ".$userid);
            $this->getTableObj()->deleteUpdate($userid);
        } else {
            $this->response->body(DTO\ClsErrorDto::prepareError(103));
            $this->response->send();
        }
    }

}
