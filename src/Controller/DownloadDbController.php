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
class DownloadDbController extends ApiController {
   
    
     public function index() {
        $this->autoRender = false;
        \Cake\Log\Log::info('first step in DownloadDb');
        //$tempUserId = null;
        $tempUserId = $this->request->query("tempid");
        if(!$tempUserId){
            //$this->response->type('json');
            $this->response->body(DTO\ClsErrorDto::prepareError(101));
            return ;
        }
        $userDto = new DTO\ClsUserDto($tempUserId);
        \Cake\Log\Log::debug('TempUserID is send to Validate'.$tempUserId);
        if($this->isValid($userDto->UserId)) {
            \Cake\Log\Log::debug("User validate");
                $sqliteController = new SqliteController();
                $sqliteController->getDB($userDto->UserId);
                \Cake\Log\Log::debug("sqlite file sended to user");
        } else {
            $userController = new UserController();
            \Cake\Log\Log::debug('UserId send to save in database');
            if($userController->userSignUp($userDto->UserId)){
                $sqliteController = new SqliteController();
                $sqliteController->getDB($userDto->UserId);
                \Cake\Log\Log::debug("sqlite file sended  to user after userid saving");
    
            }
        }
     }
     private function isValid($userid) {
        $userTable = new Table\UserTable();
        if ($userTable->validate($userid)) {
            return SUCCESS;
        } else {
            return FAIL;
        }
    }
}
