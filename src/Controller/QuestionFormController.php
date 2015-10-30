<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;

/**
 * Description of QuestionFormController
 *
 * @author niteen
 */
class QuestionFormController extends FormController {

    public function index() {
        $questionTable = new Table\QuestionTable();
        $questions = $questionTable->getAll();
        $i = 0;
        foreach ($questions as $question) {
            $optionTable = new Table\OptionsTable();
            $options = $optionTable->getOptions($question->questionId);
            $count = count($options);
            $str = '';
            foreach ($options as $option) {
                $str .= $option->optionText;
                if (--$count) {
                    $str .= ' ,';
                }
            }
            $questionFormDto = new \App\DTO\ClsQuestionFormDto($question->questionId, $question->questionText, $str, $question->active);
            $showData[$i] = $questionFormDto;
            $i++;
        }
        $this->set(['questions' => $showData]);
    }

    public function add() {
        $data = $this->request->data;
        if ($this->request->is('post') and $data['questiontext'] and $data['option1']) {
            $status = 0;
            $this->autoRender = false;
            $count = count($data);

            if (key_exists('status', $data)) {
                //\Cake\Log\Log::debug("question added : ".$data)
                $questionId = $this->addQuestion($data['questiontext'], $status);
                $status = parent::getActive($data['status']);
                $optionCount = $count - 2;
                $this->addOption($optionCount, $data, $questionId);
                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
            } else {
                $questionId = $this->addQuestion($data['questiontext'], $status);
                $optionCount = $count - 1;
                $this->addOption($optionCount, $data, $questionId);
                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
            }
        }
    }

    public function edit() {
        //$this->autoRender = false;
        if ($this->request->is('get')) {
            $query = $this->request->query;
            if (key_exists('edit', $query)) {
                $optionTable = new Table\OptionsTable();
                $options = $optionTable->getOptions($query['questionId']);
                $this->set(['questionId' => $query['questionText'],'questionText' => $query['questionText'],'options' => $options, 'status' => $query['status']]);
            }  else {
                $questionTable = new Table\QuestionTable();
                $questionTable->deleteQuestion($query['questionId']);
                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
            }
        }
    }

    public function delete() {
        
    }

    private function addQuestion($questionText, $status) {
        $questionTable = new Table\QuestionTable();
        return $questionTable->add($questionText, $status);
    }

    private function addOption($count, $data, $questionId) {
        $optionsTable = new Table\OptionsTable();
        $id = 1;
        while ($count) {
            $key = 'option' . $id;
            $optionsTable->add($data[$key], $questionId);
            $count--;
            $id++;
        }
    }

}
