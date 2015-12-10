<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use Cake\Network;
use App\DTO;

/**
 * Description of DestinationFormController
 *
 * @author niteen
 */
class DestinationFormController extends FormController {

    public function initialize() {
        parent::initialize();

        session_start();
        if (!isset($_SESSION['login']) or ! isset($_COOKIE['Id'])) {
            $this->redirect(['controller' => 'LoginForm', 'action' => 'index']);
        }
    }

    public function index() {
        //$this->autoRender = false; 
        $page = 1;
        $destinationList = 0;
        $destinationTable = new Table\DestinationTable();
        $totalNumberOfDest = $destinationTable->getTotalNumberOfDest();
        $parameter = $this->request->param('page');
        if ($parameter) {
            $page = $parameter;
            $destinationList = $this->destinationPagination($page);
            if (empty($destinationList)) {
                $this->set(['message' => DESTINATION_EMPTY_MESSAGE]);
            } else {
                $this->set(['dest' => $destinationList, 'totalNumberOfDest' => $totalNumberOfDest]);
            }
        } else if ($this->request->is('ajax')) {
            $this->autoRender = false;
            // $searchData = $_GET['v'];
            //print_r($searchData);
            \Cake\Log\Log::debug("ajax request catch in destinationform controller index method with search data : ");

            $destinationList = $destinationTable->getDest();
            foreach ($destinationList as $destination) {
                $response[$destination->destId] = $destination->destName;
            }
            $json = json_encode($response);
            \Cake\Log\Log::debug("ajax response" . $json);
            $this->response->body($json);
        } elseif ($this->request->is('post')) {
            $data = $this->request->data;
            $this->destinationPagination();
            \Cake\Log\Log::debug("search request catch in destinationform controller index method with search data  ");
            if (array_key_exists('dest', $data)) {
                $destinationList = $destinationTable->getSearch($data['dest']);
                if (empty($destinationList)) {
                    $this->set(['message' => DESTINATION_NOT_FOUND_MESSAGE]);
                } else {
                    $this->set(['dest' => $destinationList,'status' => 1, 'totalNumberOfDest' => $totalNumberOfDest]);
                }
            }
        } else {
            $destinationList = $this->destinationPagination();
            if (empty($destinationList)) {
                $this->set(['message' => DESTINATION_EMPTY_MESSAGE]);
            } else {
                $this->set(['dest' => $destinationList, 'totalNumberOfDest' => $totalNumberOfDest]);
            }
        }
    }

    private function destinationPagination($page = 1) {
        $destinationTable = new Table\DestinationTable();
        if (!$destinationTable->connect()->find()->count()) {
            return NOT_FOUND;
        }

        $allDest = array();
        $i = 0;
        $limit = \appconfig::getPageSize();
        $destination = $this->Paginator->paginate($destinationTable->connect()->find(), ['limit' => $limit, 'page' => $page]);
        foreach ($destination as $row) {
            $destDto = new DTO\ClsDestinationDto($row->DestId, $row->DestName, $row->Latitude, $row->Longitude, $row->Active);
            $allDest[$i] = $destDto;
            $i++;
        }
        return $allDest;
    }

    public function edit() {
        //$this->autoRender = false;
        $destinationtable = new Table\DestinationTable();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (key_exists('title', $data)) {
                $status = $this->getActive($data['status']);
                $result = $destinationtable->updateDestination($data['destId'], $data['title'], $data['latitude'], $data['longitude'], $status);
                $this->redirect(['controller' => 'DestinationForm', 'action' => 'index']);
            }
        }
        if ($this->request->is('get')) {
            $action = $this->request->query('delete');
            if ($action) {
                $destId = $this->request->query('destId');
                $destinationtable->deleteDestination($destId);
                $this->redirect(['controller' => 'DestinationForm', 'action' => 'index']);
                return;
            }

            $destId = $this->request->query('destId');

            \Cake\Log\Log::debug("selected destination id: " . $destId . "and action : " . $action);
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
                echo '<script>alert("Destination added !")</script>';
                $this->redirect(['controller' => 'DestinationForm', 'action' => 'index']);
            } else {
                echo '<script>alert("Unknown Error occured !")</script>';
            }
        }
    }

}
