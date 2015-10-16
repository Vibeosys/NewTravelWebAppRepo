<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;

/**
 * Description of Stat_ConfController
 *
 * @author niteen
 */
define('STATCONF_INS_QRY', "INSERT INTO stat_conf (Key,Value) VALUES (\"@key\",\"@Values\");");

class Stat_ConfController extends AppController {

    public function getTableObj() {
        return new Table\Stat_ConfTable();
    }

    private function getstatConfig() {
        return $this->getTableObj()->getConfig();
    }

    public function prepareInsertStatement() {
        $allConfig = $this->getstatConfig();
        $preparedstatements = '';
        foreach ($allConfig as $config) {
            $preparedstatements.=STATCONF_INS_QRY;
            $preparedstatements = str_replace('@key', $config->Key, $preparedstatements);
            $preparedstatements = str_replace('@Value', $config->Value, $preparedstatements);
        }
        return $preparedstatements;
    }

}
