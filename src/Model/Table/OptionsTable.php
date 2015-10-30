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
use App\Controller;

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
    
    public function getOptions($questionId) {
        if (!$this->connect()->find()->where(['QuestionId =' => $questionId])->count()) {
            return NOT_FOUND;
        }
        $rows = $this->connect()->find()->where(['QuestionId =' => $questionId]);
        $i = 0;
        foreach ($rows as $row) {
            $optionDto = new DTO\ClsOptionsDto($row->OptionId, $row->OptionText);
            $allOption[$i] = $optionDto;
            $i++;
        }
        return $allOption;

        
    }
    
    public function add($optionText,$questionId) {
        if(empty($optionText)){
            echo 'Empty Option';
            return ;
        }
          try{
            $entity = $this->connect()->newEntity();
            $entity->OptionText = $optionText;
            $entity->QuestionId  = $questionId;
            if($this->connect()->save($entity)){
                $optionDto = new DTO\ClsOptionsDto($entity->optionId, $optionText, $questionId);
                $syncController = new Controller\SyncController();
               $syncController->questionEntry(json_encode($optionDto), 'Insert');
                return $entity->optionId;
            }
            return FAIL;
        } catch (Exception $ex) {
                echo 'Database error occured'.$ex->getMessage();
        }
    }
}
