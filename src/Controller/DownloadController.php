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
        
        $userId = $this->request->param("userid");
        if(!$userId){
            $this->response->body(DTO\ClsErrorDto::prepareError(101));
        }
        \Cake\Log\Log::debug("In download controller first step");
        \Cake\Log\Log::debug("Decoded json");
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
