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
            //\Cake\Log\Log::debug("Admin credential from config table : ".$credential['username']);
            
            if($data['username'] == $credential['username'] and $data['password'] == $credential['password']){
                session_start();
                 $_SESSION['login'] = 'logedin';
                setcookie('Id',$credential['username'], time()+(60*60),"/");
                $pass = md5($credential['password']);
                setcookie('pass',$pass, time()+(60*60),"/");
               // \Cake\Log\Log::info("Cookie varible after created: ".$_SESSION['login']);
               // \Cake\Log\Log::debug("redirect to destiationform controller");
             $this->redirect(['controller' => 'HomeForm','action' => 'adminPanel']);
            }else{
                session_start();
                $_SESSION['message'] = 'Username and Password wrong !!';
               $this->redirect(['controller' => 'LoginForm','action' => 'index']); 
            }
        } else {
            die('Request error occured');
        }
    }
   
    
}
