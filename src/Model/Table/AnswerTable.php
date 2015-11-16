<?php

namespace App\Model\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file(, choose Tools | Templates
 * and open the template in the editor.
 */

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Database\Connection;
use App\DTO;

/**
 * Description of AnswerTable
 *
 * @author niteen
 */
class AnswerTable extends Table {

    public function connect() {
        return TableRegistry::get('answer');
    }

    public function getAll() {
        if (!$this->connect()->find()->count()) {
            return NOT_FOUND;
        }
        $rows = $this->connect()->find();
        $i = 0;
        foreach ($rows as $row) {
            //\Cake\Log\Log::debug(print_r($row));
            $answerDto = new DTO\ClsAnswerDto($row->UserId, $row->DestId, $row->OptionId, $row->AnswerId, $row->CreatedDate);
            $all[$i] = $answerDto;
            $i++;
        }
        return $all;
    }

    public function Insert($userid, $destid, $optionid) {
        $answer = $this->connect();
        $query = $answer->newEntity();

        $query->UserId = $userid;
        $query->DestId = $destid;
        $query->OptionId = $optionid;
        $query->CreatedDate = date('Y-m-d H:i:s');
        $query->UpdatedDate = date('Y-m-d H:i:s');
        if ($answer->save($query)) {
           
            return $query->AnswerId;
        }
        return FAIL;
    }
    
    public function update($answerDto) {
        try{
            $answer = $this->connect()->query()->update();
            $answer->set(['OptionId' => $answerDto->optionId]);
            $answer->where(['UserId =' => $answerDto->userId,'DestId =' => $answerDto->destId]);
            if($answer->execute()){
                return SUCCESS;
            }
            return FAIL;
        } catch (Exception $ex) {
            return FAIL;
        }
    }
    
    public function isAnswerNew($answerDto) {
        try{
           $row = $this->connect()->find()->where(['UserId =' => $answerDto->userId,'DestId =' => $answerDto->destId,'OptionId =' => $answerDto->optionId]);
           $count = $row->count(); 
            if($count){
                return SUCCESS;
            }
            return FAIL;
        } catch (Exception $ex) {
            return FAIL;
        }
        
    }

}
