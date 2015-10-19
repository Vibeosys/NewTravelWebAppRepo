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

    public function insertUser($Name, $MobileNo, $OTP) {

        $user = $this->connect()->newEntity();
        $user->UserName = $Name;
        $user->MobileNo = $MobileNo;
        $user->OTP = $OTP;
        $user->OTPRetryCount = 1;
        $user->CreatedDate = date("Y-m-d H:i:sa");
        if ($this->connect()->save($user)) {
            return $this->checkUser($MobileNo)->UserId;
        }
    }

    public function update($userId) {

        $user = $this->connect()->get($userId);
        $user->DatabaseCheck = 1;
        $this->connect()->save($user);
           
        
    }

    public function activate($UserId) {

        $user = $this->connect()->get($UserId);
        $user->Active = 1;
        $this->connect()->save($user);
    }

    //to retive all 
    public function getAll($Id) {
        $rows = $this->connect()->find()->where(['UserId !=' => $Id]);
        $i = 0;
        if ($this->connect()->find()->count()) {
            foreach ($rows as $row) {
                if ($row->Active) {
                    $userDto = new \App\DTO\ClsUserDto($row->UserId, $row->UserName, 
                            $row->Password, $row->EmailId, $row->PhotoUrl, 
                            $row->Active, $row->CreatedDate);
                    $allUser[$i] = $userDto;
                    $i++;
                }
            }return $allUser;
        } else {return NOT_FOUND;}}

    public function getNew($Id) {
        $rows = $this->connect()->where(['UserId =' => $Id]);

        foreach ($rows as $row) {
            $newUser['UserId'] = $row->UserId;
            $newUser['UserName'] = $row->UserName;
        }

        return $newUser;
    }
    public function userCkeck($userid) {
        $rows = $this->connect()->find()->where(['UserId = ' => $userid]);
        
        foreach ($rows as $row){
            return $row->DatabaseCheck;
        }
        return FAIL;
    }
    public function validate($userId) {
        if($this->connect()->find()->where(['UserId =' => $userId])->count()){
        \Cake\Log\Log::debug("in user table validate method");
            return SUCCESS;
        }
        return FAIL;
    }

}
