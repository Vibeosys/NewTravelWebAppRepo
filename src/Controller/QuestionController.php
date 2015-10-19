<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Table;
/**
 * Description of QuestionController
 *
 * @author niteen
 */
define('QUES_INS_QRY', "INSERT INTO question (QuestionId,QuestionText) VALUES (@QuestionId,\"@QuestionText\");");
class QuestionController extends AppController{
   
    public function getTableObj() {
        return new Table\QuestionTable();
    }
    private function getAllQuestion() {
        return $this->getTableObj()->getAll();
    }
    public function getNewQuestion($Id) {
        return $this->getTableObj()->getNew($Id);
    }
    public function prepareInsertStatement() {
        $allQuestion = $this->getAllQuestion();
        if(!$allQuestion){
                return NOT_FOUND;
            }
        $preparedStatement = '';
        foreach ($allQuestion as $question){
            $preparedStatement.= QUES_INS_QRY;
            $preparedStatement = str_replace('@QuestionId', $question->QuestionId, $preparedStatement);
            $preparedStatement = str_replace('@QuestionText', $question->QuestionText, $preparedStatement);
        }
        return $preparedStatement;
    }
}
