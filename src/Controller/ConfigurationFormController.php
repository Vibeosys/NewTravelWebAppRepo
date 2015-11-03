<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Table;
/**
 * Description of ConfigurationFormController
 *
 * @author niteen
 */
class ConfigurationFormController extends FormController{

    
    public function initialize() {
        session_start();
        \Cake\Log\Log::info("Cookie varible : ".$_SESSION['login']);
        if(!isset($_SESSION['login']) or !isset($_COOKIE['Id'])){
            $this->redirect(['controller' => 'LoginForm', 'action' => 'index']);
      }
    }
    public function index() {
       $statconfTable = new Table\StatConfTable();
       $config = $statconfTable->getConfig();
       $this->set(['configs' => $config]);
    }
    
    public function add() {
        $statconfTable = new Table\StatConfTable();
        if($this->request->is('post')){
            $data = $this->request->data;
            $this->autoRender = false;
            $statconfTable->addConfig($data['key'], $data['value']);
            $this->redirect(['controller' => 'ConfigurationForm', 'action' => 'index']);
        }
        
    }
    
    public function edit() {
        $statconfTable = new Table\StatConfTable();
        if($this->request->is('get')){
            $query = $this->request->query;
            //$this->autoRender = false;
                $this->set(['config' => $query]);
                        
        }elseif ($this->request->is('post')) {
            $data = $this->request->data;
            $statconfTable->updateConfig($data['key'], $data['value']);
             $this->redirect(['controller' => 'ConfigurationForm', 'action' => 'index']);
        }  else {
            die('Unknown request');    
        }
    }
    
    
    
    
    
}
