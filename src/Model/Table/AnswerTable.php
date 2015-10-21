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
        if(!$this->connect()->find()->count()){
            return NOT_FOUND;
        }
        $rows = $this->connect()->find();
        $i = 0;
            foreach ($rows as $row) {
                $answerDto = new DTO\ClsAnswerDto($row->UserId, $row->DestId, $row->OptionId,$row->AnswerId, $row->CreatedDate);
                $all[$i] = $answerDto;
                $i++;
            }
            return $all;
    }

    public function Insert($userid, $destid, $optionid) {
        $query = $this->connect()->newEntity();

        $query->UserId = $userid;
        $query->DestId = $destid;
        $query->OptionId = $optionid;
        $query->CreatedDate = date('Y-m-d H-i-sa');
        $query->UpdatedDate = date('Y-m-d H-i-sa');
        if ($this->connect()->save($query)) {
             $json = '{"AnswerId":"'.$query->AnswerId.'","UserId":"'.$userid.'","DestId":"'.$destid.'","OptionId":"'.$optionid.'"}';
                $syncController = new \App\Controller\SyncController();
                $syncController->answerEntry($userid, $json, INSERT);
                \Cake\Log\Log::debug("Sync Entry for Answer");
            return $query->AnswerId;
        }
    }


}
