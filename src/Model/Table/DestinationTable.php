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
                        $row->Lat, $row->Long, $row->Active, $row->CraetedDate, $row->UpdatedDate);
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
                $newDest['Lat'] = $row->Lat;
                $newDest['Long'] = $row->Long;
                $newDest['UpdatedDate'] = $row->UpdatedDate;
            }
        }
        return $newDest;
    }

    //Insert New destination (call only from admin)
    public function InsertDest($name, $lat, $long, $active) {
        try {
            $query = $this->connect()->newEntity();
            $query->DestName = $name;
            $query->Lat = $lat;
            $query->Long = $long;
            $query->Active = $active;
            $query->CreatedDate = date('Y-m-d H:i:sa');
            $query->CreatedDate = date('Y-m-d H:i:sa');
            if ($this->connect()->save($query)) {
                
            }
        } catch (Exception $ex) {
            echo 'message:' . $ex->getMessage();
            return FALSE;
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
