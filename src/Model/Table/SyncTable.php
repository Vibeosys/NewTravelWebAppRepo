<?php

namespace App\Model\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\DTO;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * Description of SyncTable
 *
 * @author niteen
 */
class SyncTable extends Table {

    public function initialize() {
        
    }

    public function connect() {
        return TableRegistry::get('sync');
    }

    public function Insert($userId, $update, $table, $opration) {
       try{
        $query = $this->connect()->newEntity();
        $query->UserId = $userId;
        $query->JsonSync = $update;
        $query->TableName = $table;
        $query->Opration = $opration;
        $query->UpdatedDate = date("Y-m-d H:i:s");
        $this->connect()->save($query);
       }  catch (Excetion $e){
           \Cake\Log\Log::error("Database exception : ".$ex);
       }
    }

    public function getUpdate($userId) {
        $rows = $this->connect()->find()->where(['UserId = ' => $userId]);
        $updateCount = $rows->count();
        if ($updateCount) {
            $i = 0;
            foreach ($rows as $row) {
                $downloadSerielizer = new DTO\ClsDownloadSerializerDto($row->TableName, $row->JsonSync, $row->Opration);
                $update[$i] = $downloadSerielizer;
                $i++;
            }
            \Cake\Log\Log::debug("Sending update to sync controller");
            $data['data'] = $update;
            return $data;
        } else {
            \Cake\Log\Log::debug('Update not created');
            return NOT_FOUND;
        }
    }

    public function deleteUpdate($UserId) {
        $rows = $this->connect()->find()->where(['UserId = ' => $UserId]);

        foreach ($rows as $row) {
            $entity = $this->connect()->get($row->SyncAutoNo);
            $result = $this->connect()->delete($entity);
        }
    }

}
