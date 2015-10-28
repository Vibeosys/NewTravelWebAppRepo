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
            $credential = $this->getAdminCredential();
            \Cake\Log\Log::debug("Admin credential from config table : ".$credential->adminUsername);
            if($data['username'] == $credential->adminUsername and $data['password'] == $credential->adminPassword){
                
                \Cake\Log\Log::debug("redirect to destiationform controller");
          $this->redirect(['controller' => 'DestinationForm','action' => 'index']);
            }else{
               $this->redirect(['action' => 'index']); 
            }
        } else {
            die('Request error occured');
        }
    }

    private function getAdminCredential() {
        $statconftable = new Table\StatConfTable();
        return $statconftable->getCredential();
    }

}
