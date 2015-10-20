<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cake\Network;
use App\Model\Table;
use App\DTO;

/**
 * Description of AnswerController
 *
 * @author niteen
 */
define('ANS_INS_QRY', "INSERT INTO answer (AnswerId,UserId,DestId,OptionId,CreatedDate) VALUES (@AnswerId,@UserId,@DestId,@OptionId,\"@CreatedDate\");");

class AnswerController extends AppController{
   
    public function getTablObj() {
        return new Table\AnswerTable();
    }
    private function allAnswer() {
        return $this->getTablObj()->getAll();
    }
    public function submit(DTO\ClsAnswerDto $answer) {
        if($answer){
            $temp = $this->getTablObj()->Insert($answer->UserId,$answer->DestId,$answer->OptionId);
            if($temp){
                \Cake\Log\Log::info('answer submited');
                $this->response->body('{"ERROR":"False","Message":"Saved"}');
                return SUCCESS;
            }else{\Cake\Log\Log::info('answer not submited');$this->response->body('{"ERROR":"true","Message":"Not Saved Try again "}');}
        }
        $this->autoRender = false;
        
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
    public function prepareInsertStatement() {
            $allAnswer = $this->allAnswer();
            if(!$allAnswer){
                return NOT_FOUND;
            }
            $preparedStatements = '';
         
            foreach ($allAnswer as $answer){
                $preparedStatements .= ANS_INS_QRY;
                $preparedStatements = str_replace('@AnswerId', $answer->AnswerId, $preparedStatements);
                $preparedStatements = str_replace('@UserId', $answer->UserId, $preparedStatements);
                $preparedStatements = str_replace('@DestId', $answer->DestId, $preparedStatements);
                $preparedStatements = str_replace('@OptionId', $answer->OptionId, $preparedStatements);
                $preparedStatements = str_replace('@CreatedDate', $answer->CreatedDate, $preparedStatements);
            }
            return $preparedStatements;
         
    }
}
