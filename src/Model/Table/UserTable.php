<?php

namespace App\Model\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\DTO;

/**
 * Description of ActivateModel
 *
 * @author niteen
 */
class UserTable extends Table {

    public function initialize(array $config) {
        
    }

    //to get Object of table registry
    public function connect() {
        return TableRegistry::get('user');
    }

    public function insertUser($userId) {

        $user = $this->connect()->newEntity();
        $user->UserId = $userId;
        if ($this->connect()->save($user)) {

            \Cake\Log\Log::debug('User saved in database');
            return SUCCESS;
        }
        return FAIL;
    }

    public function update($userDto) {
        //$tableObject = $this->connect();
        $user = $this->connect()->get($userDto->userId);
        $user->UserName = $userDto->userName;
        $user->EmailId = $userDto->emailId;
        if($this->connect()->save($user)){
            \Cake\Log\Log::debug('User : ' .$userDto->userName. ' updated in user table');
            return SUCCESS;
        }
        return FAIL;
    }
    public function updateProfileImage($userid,$imageurl) {
        $user = $this->connect();
        $query = $user->get($userid);
        $query->PhotoUrl = $imageurl;
        if($user->save($query)){return SUCCESS;}
        $this->response->body(DTO\ClsErrorDto::prepareError(113));
        $this->response->send();
        return  FAIL;
    }

    public function activate($UserId) {

        $user = $this->connect()->get($UserId);
        $user->Active = 1;
        $this->connect()->save($user);
    }

    //to retive all 
    public function getAll() {
        $rows = $this->connect()->find()->where();
        $i = 0;
        $allUser = null;
        if ($this->connect()->find()->count()) {
            foreach ($rows as $row) {
               // \Cake\Log\Log::info("Valied User : " . $row->UserId . "Active : " . $row->Active);
                $userDto = new \App\DTO\ClsUserDto($row->UserId, $row->UserName, $row->Password, $row->EmailId, $row->PhotoUrl, $row->Active, $row->CreatedDate);
                $allUser[$i] = $userDto;
                $i++;
            }return $allUser;
        } else {
            return NOT_FOUND;
        }
    }

    public function getNew($Id) {
        $rows = $this->connect()->where(['UserId =' => $Id]);

        foreach ($rows as $row) {
            $newUser['UserId'] = $row->userId;
            $newUser['UserName'] = $row->userName;
        }

        return $newUser;
    }

    public function userCkeck($userid, $usermail) {
        $rows = $this->connect()->find()->where(['UserId =' => $userid]);
        foreach ($rows as $row) {
            if ($row->EmailId == $usermail) {
                \Cake\Log\Log::debug("user : ".$userid. " is authorised user");
                return SUCCESS;
            }
            \Cake\Log\Log::error("user : ".$userid. " is unauthorised user");
            return FAIL;
        }
        
    }

    public function validate($userId) {
        if ($this->connect()->find()->where(['UserId =' => $userId])->count()) {
            \Cake\Log\Log::debug("in user table validate method");
            return SUCCESS;
        }
        return FAIL;
    }

}
