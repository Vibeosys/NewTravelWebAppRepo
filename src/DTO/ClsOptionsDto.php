<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsOptionDto
 *
 * @author niteen
 */
class ClsOptionsDto {
    
    public  $OptionId;
    public  $OptionText;
    public  $QuestionId;
    
    public function __construct($optionId,$optiontext,$questionId) {
        
        $this->OptionId = $optionId;
        $this->OptionText = $optiontext;
        $this->QuestionId = $questionId;
    }
    
}
