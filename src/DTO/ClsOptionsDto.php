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
    
    public  $optionId;
    public  $optionText;
    public  $questionId;
    public  $active;




    public function __construct($optionId,$optiontext,$questionId = null,$active = null) {
        
        $this->optionId = $optionId;
        $this->optionText = $optiontext;
        $this->questionId = $questionId;
        $this->active = $active;
    }
    
}
