<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Table;
/**
 * Description of OptionController
 *
 * @author niteen
 */

define('OPTION_INS_QRY', "INSERT INTO options (OptionId,OptionText,QuestionId) VALUES(@OptionId,\"@OptionText\",@QuestionId);");
class OptionsController extends AppController{
    public function getTableObj() {
        return new Table\OptionsTable();
    }
    private function getOptions() {
        return $this->getTableObj()->getAll();
    }
    public function prepareInsertStatement() {
        $allOptions = $this->getOptions();
        if(!$allOptions){
                return NOT_FOUND;
            }
        $preparedStatements = '';
        foreach ($allOptions as $options){
            $preparedStatements .= OPTION_INS_QRY;
            $preparedStatements = str_replace('@OptionId', $options->optionId, $preparedStatements);
            $preparedStatements = str_replace('@OptionText', $options->optionText, $preparedStatements);
            $preparedStatements = str_replace('@QuestionId', $options->questionId, $preparedStatements);
            
        }
        return $preparedStatements;
    }
}
