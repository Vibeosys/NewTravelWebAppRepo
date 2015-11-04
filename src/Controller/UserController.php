<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;

/**
 * Description of DemoController
 *
 * @author niteen
 */
define('USER_INS_QRY', "INSERT INTO user (UserId,UserName,PhotoUrl)VALUES (\"@UserId\",\"@UserName\",\"@PhotoUrl\");");

class UserController extends ApiController {

    public function getTableObj() {
        return new Table\UserTable();
    }

    //give temp access to user by providing temp userid
    public function userSignUp($userId) {
        if ($this->getTableObj()->insertUser($userId)) {
            \Cake\Log\Log::debug('temp Userid inserted');
            return SUCCESS;
        }
        return FAIL;
    }

   
    public function getAllUser() {
        return $this->getTableObj()->getAll();
    }

    public function prepareInsertStatement() {
        $allUser = $this->getAllUser();
        if (!$allUser) {
            return NOT_FOUND;
        }
        $preparedStatement = '';
        foreach ($allUser as $user) {
           // \Cake\Log\Log::debug("active field value from user table : ".var_dump($user->active));
            if($user->active){
            $preparedStatement.= USER_INS_QRY;
            $preparedStatement = str_replace('@UserId', $user->userId, $preparedStatement);
            $preparedStatement = str_replace('@UserName', $user->userName, $preparedStatement);
            $preparedStatement = str_replace('@PhotoUrl', $user->photoUrl, $preparedStatement);
        }}
        return $preparedStatement;
    }

}
