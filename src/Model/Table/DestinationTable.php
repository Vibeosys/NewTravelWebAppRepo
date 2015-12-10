<?php

namespace App\Model\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\DTO;
use App\Controller;
use App\DTO\DownloadDto;

/**
 * Description of DestTable
 *
 * @author niteen
 */
class DestinationTable extends Table {

    public function initialize(array $config) {
       
    }

    public function connect() {
        return TableRegistry::get('destination');
    }

    //to retrive all destination and return in array
    public function getDest() {
        if (!$this->connect()->find()->count()) {
            return NOT_FOUND;
        }
        $rows = $this->connect()->find();
        $allDest[] = null;
        $i = 0;
        foreach ($rows as $row) {
            if (1) {
                $destDto = new DTO\ClsDestinationDto($row->DestId, $row->DestName, $row->Latitude, $row->Longitude, $row->Active);
                $allDest[$i] = $destDto;
                $i++;
            }
        }
        return $allDest;
    }
    

    //to get new destination for sync table entry
    public function getSingleDestination($destId) {
        $rows = $this->connect()->find()->where(['DestId = ' => $destId]);
        foreach ($rows as $row) {
            $destinationDto = new DTO\ClsDestinationDto($row->DestId, $row->DestName, $row->Latitude, $row->Longitude, $row->Active);
        }
        return $destinationDto;
    }

    //Insert New destination (call only from admin)
    public function addNewDestiantion($name, $lat, $long, $active) {
        \Cake\Log\Log::debug("New destination added in list : " . $name . $lat . $long . $active);
        $dest = $this->connect();
        $query = $dest->newEntity();
        $query->DestName = $name;
        $query->Latitude = $lat;
        $query->Longitude = $long;
        $query->Active = $active;
        $query->CreatedDate = date('Y-m-d H:i:s');
        $query->UpdatedDate = date('Y-m-d H:i:s');
        if ($dest->save($query)) {
            $destinationDto = new DownloadDto\DestinationDto($query->DestId, $name, $lat, $long);
            $this->makeSyncUpdate($active, json_encode($destinationDto), INSERT);
            return SUCCESS;
        }
        return FAIL;
    }

    public function getName($destId) {
        try {
            $rows = $this->connect()->find()->where(['DestId = ' => $destId]);
            foreach ($rows as $row) {
                return $row->DestName;
            }
        } catch (Exception $ex) {
            echo 'message:' . $ex->getMessage();
        }
    }
    
    public function getSearch($key) {
        $rows = $this->connect()->find()->where(['DestName =' =>  $key]);
        $i = 0;
        $allDest = [];
        foreach ($rows as $row) {
            
            $destinationDto = new DTO\ClsDestinationDto($row->DestId, $row->DestName, $row->Latitude, $row->Longitude, $row->Active);
            $allDest[$i] = $destinationDto;
            $i++;
        }
        \Cake\Log\Log::debug("search object created and send to controller from table ");
        return $allDest;
    }

    public function updateDestination($destId, $destName, $lat, $long, $active) {
        try {
            $update = $this->connect()->query();
            $update->update();
            $update->set(['DestName' => $destName, 'Latitude' => $lat, 'Longitude' => $long, 'Active' => $active, 'UpdatedDate' => date('Y-m-d H:i:s')]);
            $update->where(['DestId = ' => $destId]);
            if ($update->execute()) {
                \Cake\Log\Log::debug("Destination Updated Title : " . $destName);
                $destinationDto = new DownloadDto\DestinationDto($destId, $destName, $lat, $long);
                $this->makeSyncUpdate($active, json_encode($destinationDto),UPDATE);
                return SUCCESS;
            }
            return FAIL;
        } catch (Exception $ex) {
            echo 'Database error occurd ' . $ex->getMessage();
        }
    }

    public function deleteDestination($destId) {
        try {
            $update = $this->connect()->query();
            $update->update();
            $update->set(['Active' => FAIL, 'UpdatedDate' => date('Y-m-d H:i:s')]);
            $update->where(['DestId = ' => $destId]);
            if ($update->execute()) {
                \Cake\Log\Log::debug("Destination Deleted DestId : " . $destId);
                //$destinationDto = $this->getSingleDestination($destId);
                //$this->makeSyncUpdate($active = null, json_encode($destinationDto), UPDATE);
                return SUCCESS;
            }
            return FAIL;
        } catch (Exception $ex) {
            echo 'Database error occurd ' . $ex->getMessage();
        }
    }
    public function getTotalNumberOfDest() {
        $count =  $this->connect()->find()->count();
        \Cake\Log\Log::debug("total destiantion count : ".$count);
        return $count;
    }

    private function makeSyncUpdate($active, $json, $operation) {
        if ($active or $operation == 'Update') {
            $syncController = new Controller\SyncController();
            $syncController->destEntry($json, $operation);
        }
    }

}
