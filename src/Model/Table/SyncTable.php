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
class SyncTable extends Table{
    


    public function initialize(array $config) {
        
    }
     public function connect() {
        return TableRegistry::get('sync');
    }
    public function Insert($UserId,$Update,$Table) {
        
        $query = $this->connect()->newEntity();
        $query->UserId = $UserId;
        $query->JsonSync = $Update;
        $query->TableName = $Table;
        $query->UpdatedDate = date("Y-m-d H:i:sa");
        $this->connect()->save($query);
        
    }
    public function getUpdate($UserId) {
        $Update[][] = null;
        $rows = $this->connect()->find()->where(['UserId = ' => $UserId]);
        $i = 0;
        $this->AutoNo = array();
        foreach ($rows as $row){
            $Update[$i]['Table'] = $row->TableName;
            $Update[$i]['Json'] =$row->JsonSync;
            $Update[$i]['UpdatedDate'] = $row->UpdatedDate;
            $i = $i + 1;
        }
        return $Update;
    }
    public function deleteUpdate($UserId) {
        $rows = $this->connect()->find()->where(['UserId = ' => $UserId]);
      
        foreach ($rows as $row)
        {
           $entity = $this->connect()->get($row->SyncAutoNo);
           $result = $this->connect()->delete($entity);
        }
        
    }
}
