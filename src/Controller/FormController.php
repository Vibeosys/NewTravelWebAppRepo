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
        $this->response->type('html');
    }
    
    public function login($userName = null,$password = null) {
      
        
      
    }
    
}
