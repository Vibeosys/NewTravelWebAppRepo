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
class DownloadController extends ApiController {

    public function index() {
        $this->autoRender = false;

        $userId = $this->request->query("tempid");
        if (!$userId) {
            $this->response->type('json');
            $this->response->body(DTO\ClsErrorDto::prepareError(101));
            return ;
        }
        
        $userDto = new DTO\ClsUserDto($userId);
        if ($this->isValied($userDto->UserId)) {
            \Cake\Log\Log::debug("User validate");
            $syncController = new SyncController();
            $syncController->download($userDto->UserId);
            \Cake\Log\Log::debug("User Having sqlite file so call to download method");
        } else {
            $this->response->body(DTO\ClsErrorDto::prepareError(102));
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
