<?php

namespace App\Model\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SyncTable
 *
 * @author niteen
 */
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class SyncTable extends Table {

    public function initialize(array $config) {
        
    }

    public function connect() {
        return TableRegistry::get('sync');
    }

    public function Insert($UserId, $Update, $Table) {

        $query = $this->connect()->newEntity();
        $query->UserId = $UserId;
        $query->JsonSync = $Update;
        $query->TableName = $Table;
        $query->UpdatedDate = date("Y-m-d H:i:sa");
        $this->connect()->save($query);
    }

    public function getUpdate($userId) {
        $rows = $this->connect()->find()->where(['UserId = ' => $userId]);
        $updateCount = $rows->count();
        if ($updateCount) {
            
            $update = '{"data":[';
            foreach ($rows as $row) {
                $updateCount--;
                $update .= '{"' . $row->TableName . '":' . $row->JsonSync . '}';
                if($updateCount){
                    $update .= ',';
                }
            }
            $update .=']}'; 
            return $update;
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
