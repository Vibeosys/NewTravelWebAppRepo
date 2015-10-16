<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionController
 *
 * @author niteen
 */
use App\Model\Table;
class QuestionController extends AppController{
   
    public function getTableObj() {
        return new Table\QuestionTable();
    }
    public function getAllQuestion() {
        return $this->getTableObj()->getAll();
    }
    public function getNewQuestion($Id) {
        return $this->getTableObj()->getNew($Id);
    }
}
