<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;

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
        if ($this->request->is('post')) {
            $data = $this->request->data;


        } else {
            die('Request error occured');
        }
    }

    public function add() {
         //$this->autoRender = false;
            \Cake\Log\Log::debug("you are in destination add method");
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $destinationTable = new Table\DestinationTable();
            $status = $this->getActive($data['status']);
            if($destinationTable->addNewDestiantion($data['tilte'], $data['latitude'], $data['longitude'],$status)){
             $this->redirect(['controller' => 'DestinationForm','action' => 'index']);   
            }else{
                    echo '<script>alert("Unknown Error occured !")</script>';
            }
        } else {
            die('Request error occured');
        }
    }
    
    private function getActive($status) {
        if($status == 'on'){
            return SUCCESS;
        }
        return FAIL;
    }

}
