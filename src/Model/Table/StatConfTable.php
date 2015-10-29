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
 * Description of Stat_ConfTable
 *
 * @author niteen
 */
class StatConfTable extends Table {
    
    public function connect() {
        return TableRegistry::get('stat_conf');
    }
    public function getConfig() {
       if(!$this->connect()->find()->count()){
           return NOT_FOUND;
       }
        $rows = $this->connect()->find();
       $i = 0;
        foreach ($rows as $row){
            if($row->Active){
            $statconfDto = new DTO\ClsStatConfigDto($row->ConfigKey, $row->ConfigValue);
            $config[$i] = $statconfDto;
            $i++;
        }}
        return $config;
    }
    
    public function addConfig($key,$value) {
       try{
           $entity = $this->connect()->newEntity();
           $entity->ConfigKey = $key;
           $entity->ConfigValue = $value;
           $entity->Updateddate = date('Y-m-d H:i:s');
           if($this->connect()->save($entity)){
               
               return SUCCESS;
           }
           return FAIL;
       } catch (Exception $ex) {
           echo 'Database Error Occured'.$ex->getMessage();
       }
        
    }
    
    public function deleteConfig($key) {
      $zero = 0;
        try{
           $query = $this->connect()->query();
           $update = $query->update();
           $update->set(['Active' => $zero]);
           $update->where(['ConfigKey =' => $key]);
           if($update->execute()){
                 \Cake\Log\Log::debug("config deleted key : ".$key);
               return SUCCESS;
           }
           return FAIL;
       } catch (Exception $ex) {
           echo 'Database Error Occured'.$ex->getMessage();
       }
    }
    
  
    
}
