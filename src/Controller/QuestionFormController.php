<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use App\DTO\DownloadDto;
use App\DTO;

/**
 * Description of QuestionFormController
 *
 * @author niteen
 */
class QuestionFormController extends FormController {

    public function initialize() {
        session_start();
        parent::initialize();
        if (!isset($_SESSION['login']) or ! isset($_COOKIE['Id'])) {
            $this->redirect(['controller' => 'LoginForm', 'action' => 'index']);
        }
    }

    public function index() {
        
        $questions = $this->questionPagination();
        $i = 0;
        if(!$questions){
            $showData = $questions;
        }else{
        foreach ($questions as $question) {
            $optionTable = new Table\OptionsTable();
            $options = $optionTable->getOptions($question->questionId);
            if (empty($options)) {
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
        }}
        $this->set(['questions' => $showData]);
    }
    private function questionPagination($page = 1) {
         $questionTable = new Table\QuestionTable();
        if (!$questionTable->connect()->find()->count()) {
            return NOT_FOUND;
        }

        $allquestions = array();
        $i = 0;
        $limit = \appconfig::getPageSize();
        $questions = $this->Paginator->paginate($questionTable->connect()->find(), ['limit' => $limit, 'page' => $page]);
        foreach ($questions as $question) {
            $questionDto = new DTO\ClsQuestionDto($question->QuestionId, $question->QuestionText, $question->Active);
            $allquestions[$i] = $questionDto;
            $i++;
        }
        return $allquestions;
    }

    public function add() {
       // $this->autoRender = false;
        $data = $this->request->data;

        if ($this->request->is('post') and $data['questiontext'] and $data['options']) {
            $this->autoRender = false;
            $status = 0;
            $option = explode(",", $data['options']);
           
            if (key_exists('status', $data)) {
                //\Cake\Log\Log::debug("question added : ".$data)
                $status = parent::getActive($data['status']);
                $questionId = $this->addQuestion($data['questiontext'], $status);
                if ($questionId) {
                    $this->addOption($this->filterOption($option), $questionId);
                    $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
                } else {
                    $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
                }
//            } else {
//                $questionId = $this->addQuestion($data['questiontext'], $status);
//                $this->addOption($option, $questionId);
//                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
            }
        }
    }

    public function edit() {
         //$this->autoRender = false;
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
                $questionText = base64_encode($data['questionText']);
                //print_r($data);

                $this->set(['questionId' => $data['questionId'], 'questionText' => $questionText, 'options' => $data['options'], 'status' => $data['status']]);
              // print_r($data);
               //return;
                } elseif (key_exists('delete', $data)) {

                $questionTable->deleteQuestion($data['questionId']);
                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
            } elseif (key_exists('save', $data)) {
                //$this->autoRender = false;
                $updatedOption = explode(',', $data['options']);
                $status = parent::getActive($data['status']);
                $update = $questionTable->update($data['questionId'], $data['questiontext'], $status);
                if ($update) {
                    $questionDto = new DownloadDto\QuestionDto($data['questionId'], $data['questiontext']);
                    $syncController = new SyncController();
                    $syncController->questionEntry(json_encode($questionDto), UPDATE);
                    $optionsTable->update($data['questionId'], $this->filterOption($updatedOption));
                }

                $this->redirect(['controller' => 'QuestionForm', 'action' => 'index']);
            }
        }
    }

    public function delete() {
        
    }

    private function addQuestion($questionText, $status) {
        $questionTable = new Table\QuestionTable();
        $id = $questionTable->add($questionText, $status);
        if ($id) {
            $questionDto = new DownloadDto\QuestionDto($id, $questionText);
            $syncController = new SyncController();
            $syncController->questionEntry(json_encode($questionDto), INSERT);
            return $id;
        } else {
            
        }
    }

    private function addOption($option, $questionId) {
        $optionsTable = new Table\OptionsTable();
        foreach ($option as $key => $value) {
            $optionsTable->add($value, $questionId);
        }
    }

    private function filterOption($option) {
        foreach ($option as $k => $v) {
            $filteredOption[$k] = ucfirst($v);
        }
        return $filteredOption;
    }

}
