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
                 $_SESSION['login'] = true;
                setcookie('Id',$credential['username'], time()+(60*20),"/");
                $pass = md5($credential['password']);
                setcookie('pass',$pass, time()+(60*20),"/");
               
               // \Cake\Log\Log::info("Cookie varible after created: ".$_SESSION['login']);
               // \Cake\Log\Log::debug("redirect to destiationform controller");
          $this->redirect(['controller' => 'LoginForm','action' => 'home']);
            }else{
               $this->redirect(['action' => 'index']); 
            }
        } else {
            die('Request error occured');
        }
    }
   
    
    public function home() {
       // $this->autoRender = false;
        session_start();
        if(!isset($_SESSION['login']) or !isset($_COOKIE['Id'])){
            
            $this->redirect(['controller' => 'LoginForm', 'action' => 'index']);
      }
      
      
    }
}
