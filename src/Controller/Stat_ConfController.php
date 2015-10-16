<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stat_ConfController
 *
 * @author niteen
 */
use App\Model\Table;
class Stat_ConfController extends AppController{
    public function getTableObj() {
        return new Table\Stat_ConfTable();
    }
    public function syncTime() {
        return $this->getTableObj()->getTime();
    }
    public function NoOfRetry() {
        return $this->getTableObj()->getNoOfRetry();
    }
}
