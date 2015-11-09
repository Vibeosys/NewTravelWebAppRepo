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
use App\DTO\DownloadDto;

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
            $optionDto = new DTO\ClsOptionsDto($row->OptionId, $row->OptionText, $row->QuestionId, $row->Active);
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
            if($row->Active){
            $optionDto = new DownloadDto\OptionsDto($row->OptionId, $row->OptionText, $questionId);
            $allOption[$i] = $optionDto;
            $i++;
            }
        }
        if(!empty($allOption)){
            return $allOption;
        }
        return 0;
    }

    public function add($optionText, $questionId) {
        if (empty($optionText)) {
            echo 'Empty Option';
            return;
        }
        try {
            $entity = $this->connect()->newEntity();
            $entity->OptionText = $optionText;
            $entity->QuestionId = $questionId;
            if ($this->connect()->save($entity)) {
                $optionDto = new DownloadDto\OptionsDto($entity->OptionId, $optionText, $questionId);
                $syncController = new Controller\SyncController();
                $syncController->questionEntry(json_encode($optionDto), INSERT);
                return $entity->optionId;
            }
            return FAIL;
        } catch (Exception $ex) {
            echo 'Database error occured' . $ex->getMessage();
        }
    }

    public function update($questionId, $updatedOption) {
        try {
            
            $rows = $this->connect()->find()->where(['QuestionId =' => $questionId]);
            foreach ($rows as $row) {
                if (in_array($row->OptionText, $updatedOption)) {
                    $k = array_search($row->OptionText, $updatedOption);
                    unset($updatedOption[$k]);
                } else {
                    $update = $this->connect()->query()->update();
                    $update->set(['Active' => 0]);
                    $update->where(['OptionId = ' => $row->OptionId]);
                    $update->execute();
                }
            }
            if (!empty($updatedOption)) {
                foreach ($updatedOption as $k => $v) {
                    $this->add($v, $questionId);
                }
            }
        } catch (Exception $ex) {
            echo 'Database error occured' . $ex->getMessage();
        }
    }

}
