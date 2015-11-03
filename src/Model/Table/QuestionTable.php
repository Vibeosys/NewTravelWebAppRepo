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
class QuestionTable extends Table {

    public function connect() {
        return TableRegistry::get('question');
    }

    public function getAll() {
        if (!$this->connect()->find()->count()) {
            return NOT_FOUND;
        }
        $rows = $this->connect()->find();
        $i = 0;
        foreach ($rows as $row) {
            $questionDto = new DTO\ClsQuestionDto($row->QuestionId, $row->QuestionText, $row->Active);
            $allQuestion[$i] = $questionDto;
            $i++;
        }
        return $allQuestion;
    }

    public function getNew($Id) {
        $rows = $this->connect()->find()->where(['QuestionId = ' => $Id]);
        foreach ($rows as $row) {
            if ($row->Active == 1) {
                $newQuestion['QuestionId'] = $row->QuestionId;
                $newQuestion['QuestionText'] = $row->QuestionText;
                $newQuestion['UpdatedDate'] = $row->UpdatedDate;
            }
        }
        return $newQuestion;
    }

    public function add($questionText, $status) {
        try {
            \Cake\Log\Log::debug("question added with active : " . $status);
            $entity = $this->connect()->newEntity();
            $entity->QuestionText = $questionText;
            $entity->Active = $status;
            $entity->CreatedDate = date('Y-n-d H:i:s');
            $entity->UpdatedDate = date('Y-n-d H:i:s');
            if ($this->connect()->save($entity)) {
                $questionDto = new DTO\ClsQuestionDto($entity->QuestionId, $questionText);
                $syncController = new Controller\SyncController();
                $syncController->questionEntry(json_encode($questionDto), INSERT);
                return $entity->QuestionId;
            }
            return FAIL;
        } catch (Exception $ex) {
            echo 'Database error occured' . $ex->getMessage();
        }
    }

    public function update($questionId, $questionText, $status) {
        try {
            $update = $this->connect()->query()->update();
            $update->set(['QuestionText ' => $questionText, 'Active' => $status]);
            $update->where(['QuestionId =' => $questionId]);
            if ($update->execute()) {
                $questionDto = new DTO\ClsQuestionDto($entity->QuestionId, $questionText);
                $syncController = new Controller\SyncController();
                $syncController->questionEntry(json_encode($questionDto), UPDATE);
                return SUCCESS;
            }
            return FAIL;
        } catch (Exception $ex) {
            echo 'Database error occured' . $ex->getMessage();
        }
    }

    public function deleteQuestion($questionId) {

        try {
            $update = $this->connect()->query()->update();
            $update->set(['Active ' => 0]);
            $update->where(['QuestionId =' => $questionId]);
            if ($update->execute()) {
                return SUCCESS;
            }
            return FAIL;
        } catch (Exception $ex) {
            echo 'Database error occured' . $ex->getMessage();
        }
    }

}
