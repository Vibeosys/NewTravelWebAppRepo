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
class DownloadController extends AppController{
    
    
    public function down() {
         $this->autoRender = false;
         $queryData = $this->request->input('json_decode');
         $userDto = new DTO\ClsUserDto($queryData->UserId);
       if($this->isValied($userDto->UserId)){
           if($this->databaseCheck($userDto->UserId)){
            $syncController = new SyncController();
            $syncController->download($userDto->UserId);
           }else{
               $sqliteController = new SqliteController();
               $sqliteController->getDB($userDto->UserId);
           }
       }else{
           $this->response->body('{"Error":"True","Message":"Invalide request"}');
           $this->response->send();
       }
    }
    
    private function isValied($userid) {
        $userTable = new Table\UserTable();
        if($userTable->validate($userid)){
            return SUCCESS;
        }else{
            return FAIL;
        }
        
    }
    private function databaseCheck($userid) {
        $userController = new UserController();
        if($userController->isDatabaseTake($userid)){
            return SUCCESS;
        }else{
            return FAIL;
        }
    }
    
    private function functionName($param) {
        
    }
    
}
