<?php
namespace App\Model\Table;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionTable
 *
 * @author niteen
 */
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\Controller;
class QuestionTable extends Table{
    public function connect() {
        return TableRegistry::get('question');
    }
    
    public function getAll() {
        $rows = $this->connect()->find();
        $option = new Controller\OptionsController;
        $i = 0;
        foreach($rows as $row)
        {
            if($row->Active == 1){
              $allQuestion[$i]['QuestionId']    =  $row->QuestionId;
              $allQuestion[$i]['QuestionText']  =  $row->QuestionText;
              $allQuestion[$i]['Active']        =  $row->Active;
              $allQuestion[$i]['CreatedDate']   =  $row->CreatedDate;
              $allQuestion[$i]['UpdatedDate']   =  $row->UpdatedDate;
            }
            $i = $i + 1;
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
