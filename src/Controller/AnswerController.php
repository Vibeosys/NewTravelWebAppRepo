<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnswerController
 *
 * @author niteen
 */
use Cake\Network;
use App\Model\Table;
class AnswerController extends AppController{
   
    public function getTablObj() {
        return new Table\AnswerTable();
    }
    public function allAnswer() {
        return $this->getTablObj()->getAll();
    }
    public function newAnswer($Id) {
        return $this->getTablObj()->getNew($Id);
    }
    public function putNewAnswer() {
        $querydata = $this->request->input('json_decode');
        echo $querydata->UserId.$querydata->DestId.$querydata->OptionId;
       $AnswerId = $this->getTablObj()->Insert($querydata->UserId,$querydata->DestId,$querydata->OptionId);
        $syn = new SyncController();
        $syn->answerEntry($AnserId,$querydata->UserId);
    }
    public function test() {
         $querydata = $this->request->input('json_decode');
        $this->getTablObj()->SqliteInsert($querydata->UserId,$querydata->DestId,$querydata->OptionId);
    }
}
