<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DownloadController
 *
 * @author niteen
 */
class DownloadController extends AppController{
    
    
    public function down() {
         $this->autoRender = false;
         $queryData = $this->request->input('json_decode');
        
         
       
    }
    private function database($userid) {
        $userController = new UserController();
        if($userController->isDatabaseTake($userid))
    }
}
