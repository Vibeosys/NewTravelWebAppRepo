<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cake\Network;
use Cake\ORM\TableRegistry;
use App\Model\Table;


/**
 * Description of DemoController
 *
 * @author niteen
 */
define('USER_INS_QRY', "INSERT INTO user (UserId,UserName,PhotoUrl)VALUES (\"@UserId\",\"@UserName\",\"@PhotoUrl\");");

class UserController extends AppController {

    public function getTableObj() {
        return new Table\UserTable();
    }

    public function show() {

        $path = func_get_args();
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));
        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    //to activate user
    public function userSignUp($userId) {
        if($this->getTableObj()->insertUser($userId)){
            \Cake\Log\Log::debug('temp Userid inserted');
            return SUCCESS;
            
        }     
        return FAIL;
    }
  
    public function makeEntry($Id) {
        $syn = new SyncController;
        $sqliteController = new SqliteController;
        $sqliteController->getDB($Id);
        $syn->userEntry($this->getTableObj()->getAll($Id), $this->getTableObj()->getNew($Id));
    }

    public function getAllUser() {
        return $this->getTableObj()->getAll();
    }

    public function prepareInsertStatement() {
        $allUser = $this->getAllUser();
        if(!$allUser){
                return NOT_FOUND;
            }
        $preparedStatement = '';
        foreach ($allUser as $user){
            $preparedStatement.= USER_INS_QRY;
            $preparedStatement = str_replace('@UserId', $user->UserId, $preparedStatement);
            $preparedStatement = str_replace('@UserName', $user->UserName, $preparedStatement);
            $preparedStatement = str_replace('@PhotoUrl', $user->PhotoUrl, $preparedStatement);
        }
        return $preparedStatement;
    }
    public function validate($userid,$usermail) {
          \Cake\Log\Log::debug("in user controller method");
        if($this->getTableObj()->userCkeck($userid,$usermail)){
            return SUCCESS;
        }
        return FAIL;
    }

}
