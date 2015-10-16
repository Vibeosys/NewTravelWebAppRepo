<?php
namespace App\Model\Table;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stat_ConfTable
 *
 * @author niteen
 */
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
class Stat_ConfTable extends Table {
    
    public function connect() {
        return TableRegistry::get('stat_conf');
    }
    public function getTime() {
        $SyncTime = $this->connect()->find()->select(['Value'])->where(['Key =' => 'SyncTime']);
    }
    public function getNoOfRetry() {
        $NoOfRetry = $this->connect()->find()->select(['Value'])->where(['Key =' => 'NoOfRetry']);
    }
}
