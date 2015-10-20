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
 * Description of DownloadDbController
 *
 * @author niteen
 */
class DownloadDbController extends AppController {
   
    
     public function index() {
        $this->autoRender = false;
        $tempUserId = $this->request->query("tempid");
        if(!$tempUserId){
            $this->response->body(DTO\ClsErrorDto::prepareError(101));
        }
        $userDto = new DTO\ClsUserDto($tempUserId);
        \Cake\Log\Log::debug('TempUserID is send to Validate'.$tempUserId);
        if($this->isValied($userDto->UserId)) {
            \Cake\Log\Log::debug("User validate");
                $sqliteController = new SqliteController();
                $sqliteController->getDB($userDto->UserId);
                \Cake\Log\Log::debug("sqlite file sended to to user");
        } else {
            $userController = new UserController();
            $userController->userSignUp($userDto->UserId);
            
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
