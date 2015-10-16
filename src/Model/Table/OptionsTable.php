<?php
namespace App\Model\Table;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OptionTable
 *
 * @author niteen
 */
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
class OptionsTable extends Table{
    public function connect() {
        return TableRegistry::get('options');
    }
    public function getAll($Id) {
        $rows = $this->connect()->find()->where(['QuestionId =' => $Id]);
        $i = 0;
        foreach ($rows as $row){
            $Option[$i]['OptionId'] = $row->OptionId;
            $Option[$i]['OptionText'] = $row->OptionText;
            $i = $i + 1;
        }
        return $Option;
    }
}
