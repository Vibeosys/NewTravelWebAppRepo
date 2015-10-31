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
            if(empty($options)){
                continue;
            }
            $count = count($options);
            $str = '';
            foreach ($options as $option) {
                $str .= $option->optionText;
                if (--$count) {
                    $str .= ',';
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

        if ($this->request->is('post') and $data['questiontext'] and $data['options']) {
            $this->autoRender = false;
            $status = 0;
            $option = explode(",", $data['options']);
            if (key_exists('status', $data)) {
                //\Cake\Log\Log::debug("question added : ".$data)
                $status = parent::getActive($data['status']);
                $questionId = $this->addQuestion($data['questiontext'], $status);
                $this->addOption($this->filterOption($option), $questionId);
                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
//            } else {
//                $questionId = $this->addQuestion($data['questiontext'], $status);
//                $this->addOption($option, $questionId);
//                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
            }
        }
    }

    public function edit() {
        // $this->autoRender = false;
//        if ($this->request->is('get')) {
//            $query = $this->request->query;
//            if (key_exists('edit', $query)) {
//                $this->set(['questionId' => $query['questionId'],'questionText' => $query['questionText'],'options' => $query['options'], 'status' => $query['status']]);
//            }  else {
//                $questionTable = new Table\QuestionTable();
//                $questionTable->deleteQuestion($query['questionId']);
//                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
//            }
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $questionTable = new Table\QuestionTable();
            $optionsTable = new Table\OptionsTable();
            if (key_exists('edit', $data)) {
                $text = base64_encode($data['questionText']);
                //print_r($data);

                $this->set(['questionId' => $data['questionId'], 'questionText' => $text, 'options' => $data['options'], 'status' => $data['status']]);
            } elseif (key_exists('delete', $data)) {

                $questionTable->deleteQuestion($query['questionId']);
                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
            } elseif (key_exists('save', $data)) {
                //$this->autoRender = false;
                $updatedOption = explode(',', $data['options']);
                $status = parent::getActive($data['status']);
                $questionTable->update($data['questionId'], $data['questiontext'], $status);
                $optionsTable->update($data['questionId'], $this->filterOption($updatedOption));
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

    private function addOption($option, $questionId) {
        $optionsTable = new Table\OptionsTable();
        foreach ($option as $key => $value) {
            $optionsTable->add($value, $questionId);
        }
    }
    
    private function filterOption($option) {
        foreach ($option as $k => $v){
            $filteredOption[$k] = ucfirst($v);
        }
        return $filteredOption;
    }

}
