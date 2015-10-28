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
            if($row->Key != 'AdminUserName' or $row->Key != 'AdminPassword'){
            $statconfDto = new DTO\ClsStatConfigDto($row->Key, $row->Value);
            $config[$i] = $statconfDto;
            $i++;
        }}
        return $config;
    }
    
    public function getCredential() {
        try{
            $rows = $this->connect()->find();
            foreach ($rows as $row){
                if($row->Key == 'AdminUserName' ){
                    $un = $row->Value;
                }elseif ($row->Key == 'AdminPassword') {
                    $pwd = $row->Value;
                }
            }
            return new DTO\ClsAdminDto($un, $pwd);
            
        } catch (Exception $ex) {
            echo 'Could not connect to database'.$ex->getMaessage();
        }
        
        
    }
    
}
