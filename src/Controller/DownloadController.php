<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\DTO;
use App\Model\Table;
use Cake\Network;


/**
 * Description of DownloadController
 *
 * @author niteen
 */
class DownloadController extends AppController {

    public function index() {
        $this->autoRender = false;
        /*
        $this->autoRender = false;
        \Cake\Log\Log::debug("In download controller first step");
       $query = $this->request->param('pass');
        if(!count($query)){
            $this->response->body('{"Error":"True", "Message":"UserId missing"}');
            return ;
        }
        \Cake\Log\Log::debug("Decoded json");
        $userDto = new DTO\ClsUserDto($query[0]);
        if ($this->isValied($userDto->UserId)) {
            \Cake\Log\Log::debug("User validate");
            if ($this->databaseCheck($userDto->UserId)) {
                $syncController = new SyncController();
                $syncController->download($userDto->UserId);
                \Cake\Log\Log::debug("User Having sqlite file so call to download method");
            } else {
                $sqliteController = new SqliteController();
                $sqliteController->getDB($userDto->UserId);
                \Cake\Log\Log::debug("sqlite file sended to to user");
            }
        } else {
            $this->response->body('{"Error":"True","Message":"Invalide user"}');
        }
         * 
         */
 
        $sqliteController = new SqliteController();
                $sqliteController->getDB(2);
    }

    private function isValied($userid) {
        $userTable = new Table\UserTable();
        if ($userTable->validate($userid)) {
            return SUCCESS;
        } else {
            return FAIL;
        }
    }

    private function databaseCheck($userid) {
        $userController = new UserController();
        if ($userController->isDatabaseTake($userid)) {
            return SUCCESS;
        } else {
            return FAIL;
        }
    }

    private function functionName($param) {
        
    }

}
