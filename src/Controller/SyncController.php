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

    public function connect() {
        return TableRegistry::get('sync');
    }

    public function getTableObj() {
        return new Table\SyncTable();
    }

    public function userEntry($newUser) {
        $userController = new UserController();
        $allUser = $userController->getAllUser();
        foreach ($allUser as $user) {
            if ($user->userId) {
                $this->getTableObj()->Insert($user->userId, json_encode($newUser), $this->userTable);
            }
        }
    }

    public function destEntry($json,$opration) {
       
        $UserObj = new UserController;
       
        $allUser = $UserObj->getAllUser();
       
        foreach ($allUser as $user) {
       
                $this->getTableObj()->Insert($user->userId, $json, $this->destTable,$opration);
            
        }
    }

    public function questionEntry($json,$opration) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser();
        $i = 0;
        foreach ($allUser as $user) {
          
                $this->getTableObj()->Insert($user->userId, $json, $this->queTable,$opration);
          
        }
    }
    
    

    public function answerEntry($userId,$json, $opration) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser();
        foreach ($allUser as $user) {
            if($user->userId != $userId){
                $this->getTableObj()->Insert($user->userId,$json, $this->answerTable,$opration);
            
        }}
    }

    public function likeEntry($userId, $json, $opration) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser($userId);
        foreach ($allUser as $user) {
            if($user->userId != $userId){
                $this->getTableObj()->Insert($user->userId, $json, $this->likeTable, $opration);
            }
        }
    }

    public function commentEntry($userId, $json, $opration) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser($userId);
        foreach ($allUser as $user) {
            if($user->userId != $userId){
            try{
                $this->getTableObj()->Insert($user->userId, $json, $this->commentTable, $opration);
            }  catch (Excption $ex){
                throw  new Exception($ex);
            }
        }}
    }
    
     public function imagesEntry($userId, $json,$opration) {
        $UserObj = new UserController;
        $allUser = $UserObj->getAllUser();
        \Cake\Log\Log::debug("New image enrty in sync table json : ".$json);
        foreach ($allUser as $user) {
          if($user->userId != $userId){
                $this->getTableObj()->Insert($user->userId, $json, $this->imageTable, $opration = 'Insert');
          }
        }
    }

    public function download($userid) {
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
