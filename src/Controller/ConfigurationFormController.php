<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use App\DTO;

/**
 * Description of ConfigurationFormController
 *
 * @author niteen
 */
class ConfigurationFormController extends FormController {

    public function initialize() {
        parent::initialize();
        session_start();
        \Cake\Log\Log::info("Cookie varible : " . $_SESSION['login']);
        if (!isset($_SESSION['login']) or ! isset($_COOKIE['Id'])) {
            $this->redirect(['controller' => 'LoginForm', 'action' => 'index']);
        }
    }

    public function index() {
       $page = $this->request->param('page');
        if($page){
            $config = $this->configurationPagination($page);
        }else{
            $config = $this->configurationPagination();
        }
        $this->set(['configs' => $config]);
    }
    
    private function configurationPagination($page = 1) {
          $statconfTable = new Table\StatConfTable();
        if (!$statconfTable->connect()->find()->count()) {
            return NOT_FOUND;
        }

        $allConfig = array();
        $i = 0;
        $limit = \appconfig::getPageSize();
        $configurations = $this->Paginator->paginate($statconfTable->connect()->find(), ['limit' => $limit, 'page' => $page]);
        foreach ($configurations as $configuration) {
            $statConfDto = new DTO\ClsStatConfigDto($configuration->ConfigKey, $configuration->ConfigValue);
            $allConfig[$i] = $statConfDto;
            $i++;
        }
        return $allConfig;
        
    }

    public function add() {
        $statconfTable = new Table\StatConfTable();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->autoRender = false;
            $key = $data['key'];
            $value = $data['value'];
            $addConfig = $statconfTable->addConfig($key, $value);
            /* @var $addConfig type */
            if ($addConfig) {
                $statConfDto = new DTO\ClsStatConfigDto($key, $value);
                $syncController = new SyncController();
                $syncController->statConfEntry(json_encode($statConfDto), INSERT);
            }
            $this->redirect(['controller' => 'ConfigurationForm', 'action' => 'index']);
        }
    }

    public function edit() {
        $statconfTable = new Table\StatConfTable();
        if ($this->request->is('get')) {
            $query = $this->request->query;
            //$this->autoRender = false;
            $this->set(['config' => $query]);
        } elseif ($this->request->is('post')) {
            $data = $this->request->data;
            $key = $data['key'];
            $value = $data['value'];
            $updateConfig = $statconfTable->updateConfig($key, $value);
             if ($updateConfig) {
                $statConfDto = new DTO\ClsStatConfigDto($key, $value);
                $syncController = new  SyncController();
                $syncController->statConfEntry(json_encode($statConfDto), UPDATE);
            }
            $this->redirect(['controller' => 'ConfigurationForm', 'action' => 'index']);
        } else {
            die('Request Error Occured !! please try later');
        }
    }

}
