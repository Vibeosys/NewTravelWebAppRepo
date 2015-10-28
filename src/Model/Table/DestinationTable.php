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
            if ($row->Active) {
                $destDto = new DTO\ClsDestinationDto($row->DestId, $row->DestName, 
                        $row->Latitude, $row->Longitude, $row->Active);
                $allDest[$i] = $destDto;
                $i++;
            }
        }
        return $allDest;
    }

    //to get new destination for sync table entry
    public function newDest($DestId) {
        $rows = $this->connect()->find()->where(['DestId = ' => $DestId]);
        $newDest[] = null;

        foreach ($rows as $row) {
            if ($row->Active == 1) {
                $newDest['DestId'] = $row->DestId;
                $newDest['DestName'] = $row->DestName;
                $newDest['Lat'] = $row->Latitude;
                $newDest['Long'] = $row->Longitude;
                $newDest['UpdatedDate'] = $row->UpdatedDate;
            }
        }
        return $newDest;
    }

    //Insert New destination (call only from admin)
    public function addNewDestiantion($name, $lat, $long, $active) {
        \Cake\Log\Log::debug("New destination added in list : ". $name . $lat.$long.$active);
        $dest = $this->connect();
        $query = $dest->newEntity();
        $query->DestName = $name;
        $query->Latitude = $lat;
        $query->Longitude = $long;
        $query->Active = $active;
        if($dest->save($query)){
            SUCCESS;
        }
    }
    public function getName($destId) {
        try{
            $rows = $this->connect()->find()->where(['DestId = ' => $destId]);
            foreach ($rows as $row)return $row->DestName;
        } catch (Exception $ex) {
            echo 'message:' . $ex->getMessage();
        }
        
    }

}
