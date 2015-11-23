<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Controller\AppController;
/**
 * Description of FormController
 *
 * @author niteen
 */
class FormController extends AppController{
     public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->response->type('html');
        
       
    }
    
    public static function getActive($status) {
        if ($status == 'on') {
            return SUCCESS;
        }
        return FAIL;
    }
    
    public function logout() {
        $this->autoRender = false;
        session_start();
        if(isset($_SESSION['login'])){
            //echo $_SESSION['login'];
            unset($_SESSION['login']);
            session_destroy();
            $this->redirect(['controller' => 'LoginForm', 'action' => 'index']);
        }
        
         //$this->redirect(['controller' => 'LoginForm', 'action' => 'index']);
    }
    

    
}
