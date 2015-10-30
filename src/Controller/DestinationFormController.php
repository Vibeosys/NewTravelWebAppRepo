<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use Cake\Network;

/**
 * Description of DestinationFormController
 *
 * @author niteen
 */
class DestinationFormController extends FormController {

    public function index() {
                
        $destinationTable = new Table\DestinationTable();
        $destinationList = $destinationTable->getDest();
        $this->set(['dest' => $destinationList]);
    }

    public function edit() {
        //$this->autoRender = false;
        $destinationtable = new Table\DestinationTable();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if(key_exists('title', $data)){
                $status = $this->getActive($data['status']);
              $result =  $destinationtable->updateDestination($data['destId'], $data['title'], $data['latitude'], $data['longitude'], $status);
               $this->redirect(['controller' => 'DestinationForm', 'action' => 'index']);
            }
                
            
        }
        if ($this->request->is('get')) {
            $action = $this->request->query('delete');
            if($action){
                $destId = $this->request->query('destId');
                $destinationtable->deleteDestination($destId);
                $this->redirect(['controller' => 'DestinationForm', 'action' => 'index']);
                return ;
            }
            
            $destId = $this->request->query('destId');
            
            \Cake\Log\Log::debug("selected destination id: " . $destId ."and action : ".$action);
            $destination = $destinationtable->getSingleDestination($destId);
            $this->set(['destinationEntity' => $destination]);
        }
    }

    public function add() {

        \Cake\Log\Log::debug("you are in destination add method");
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $destinationTable = new Table\DestinationTable();
            $status = parent::getActive($data['status']);
            if ($destinationTable->addNewDestiantion($data['tilte'], $data['latitude'], $data['longitude'], $status)) {
                
                $this->redirect(['controller' => 'DestinationForm', 'action' => 'index']);
            } else {
                echo '<script>alert("Unknown Error occured !")</script>';
            }
        }
    }

    

}
