<?php
namespace App\Model\Table;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\Controller;
use App\DTO;
/**
 * Description of QuestionTable
 *
 * @author niteen
 */
class QuestionTable extends Table{
    public function connect() {
        return TableRegistry::get('question');
    }
    
    public function getAll() {
        if(!$this->connect()->find()->count()){
            return NOT_FOUND;
        }
        $rows = $this->connect()->find();
        $i = 0;
        foreach($rows as $row)
        {
            if($row->Active == 1){
            $QuestionDto = new DTO\ClsQuestionDto($row->QuestionId, $row->QuestionText);
            $allQuestion[$i] = $QuestionDto;
            $i++;
            }
        }
        return $allQuestion;
    }
    public function getNew($Id) {
        $rows = $this->connect()->find()->where(['QuestionId = ' => $Id]);
        foreach($rows as $row)
        {
            if($row->Active == 1){
              $newQuestion['QuestionId'] =  $row->QuestionId;
              $newQuestion['QuestionText'] =$row->QuestionText;
              $newQuestion['UpdatedDate'] =$row->UpdatedDate;
            }
        }
        return $newQuestion;
    }
}
