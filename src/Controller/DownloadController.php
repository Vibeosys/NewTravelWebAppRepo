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

        $userId = $this->request->query("userid");
          \Cake\Log\Log::debug("Download request input querystring userId is : ".$userId);
        if (empty($userId)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(101));
            \Cake\Log\Log::error("userId is blank ".$userId);
            return ;
        }
        
        $userDto = new DTO\ClsUserDto($userId);
        if ($this->isValied($userDto->userId)) {
            \Cake\Log\Log::debug("User validate");
            $syncController = new SyncController();
            $syncController->download($userDto->userId);
            
        } else {
            $this->response->body(DTO\ClsErrorDto::prepareError(102));
            \Cake\Log\Log::error("User requested with invalid userid : ".$userId);
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

}
