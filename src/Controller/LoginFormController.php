<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;

/**
 * Description of LoginFormController
 *
 * @author niteen
 */
class LoginFormController extends FormController {

    public function index() {
        
    }

    public function validate() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $credential = \appconfig::getAdminCredential();
            \Cake\Log\Log::debug("Admin credential from config table : ".$credential['username']);
            if($data['username'] == $credential['username'] and $data['password'] == $credential['password']){
                
                \Cake\Log\Log::debug("redirect to destiationform controller");
          $this->redirect(['controller' => 'LoginForm','action' => 'home']);
            }else{
               $this->redirect(['action' => 'index']); 
            }
        } else {
            die('Request error occured');
        }
    }
    
    public function home() {
        
    }
}
