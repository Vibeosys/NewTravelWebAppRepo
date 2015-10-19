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
 * Description of OptionTable
 *
 * @author niteen
 */
class OptionsTable extends Table {

    public function connect() {
        return TableRegistry::get('options');
    }

    public function getAll() {
        if (!$this->connect()->find()->count()) {
            return NOT_FOUND;
        }
        $rows = $this->connect()->find();
        $i = 0;
        foreach ($rows as $row) {
            $optionDto = new DTO\ClsOptionsDto($row->OptionId, $row->OptionText, $row->QuestionId);
            $allOption[$i] = $optionDto;
            $i++;
        }
        return $allOption;
    }

}
