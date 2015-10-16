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
class Stat_ConfTable extends Table {
    
    public function connect() {
        return TableRegistry::get('stat_conf');
    }
    public function getConfig() {
        $rows = $this->connect()->find();
       $i = 0;
        foreach ($rows as $row){
            $statconfDto = new DTO\ClsStatConfigDto($row->Key, $row->Value);
            $config[$i] = $statconfDto;
            $i++;
        }
        return $config;
    }
    
}
