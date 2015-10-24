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
define('ANS_INS_QRY', "INSERT INTO answer (AnswerId,UserId,DestId,OptionId,CreatedDate) VALUES (\"@AnswerId\",\"@UserId\",@DestId,@OptionId,\"@CreatedDate\");");

class AnswerController extends ApiController{
   
    public function getTablObj() {
        return new Table\AnswerTable();
    }
    private function allAnswer() {
        return $this->getTablObj()->getAll();
    }
    public function submit(DTO\ClsAnswerDto $answer) {
        
            $temp = $this->getTablObj()->Insert($answer->userId, $answer->destId, $answer->optionId);
            if($temp){
                \Cake\Log\Log::debug('answer submited');
                $this->response->body(DTO\ClsErrorDto::prepareSuccessMessage("Answer Saved"));
                return SUCCESS;
            }else{\Cake\Log\Log::error('answer not submited');$this->response->body(DTO\ClsErrorDto::prepareError(109));}
        
        $this->autoRender = false;
        
    }
    
    
    public function prepareInsertStatement() {
            $allAnswer = $this->allAnswer();
            if(!$allAnswer){
                return NOT_FOUND;
            }
            $preparedStatements = '';
         
            foreach ($allAnswer as $answer){
                $preparedStatements .= ANS_INS_QRY;
                $preparedStatements = str_replace('@AnswerId', $answer->answerId, $preparedStatements);
                $preparedStatements = str_replace('@UserId', $answer->userId, $preparedStatements);
                $preparedStatements = str_replace('@DestId', $answer->destId, $preparedStatements);
                $preparedStatements = str_replace('@OptionId', $answer->optionId, $preparedStatements);
                $preparedStatements = str_replace('@CreatedDate', $answer->createdDate, $preparedStatements);
            }
            return $preparedStatements;
         
    }
}
