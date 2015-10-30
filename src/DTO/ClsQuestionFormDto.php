<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsQuestionDto
 *
 * @author niteen
 */
class ClsQuestionFormDto {
    
    public $questionId;
    public $questionText;
    public $options;
    public $active;

    public function __construct($questionId,$questionText,$options,$active) {
        
        $this->questionId = $questionId;
        $this->questionText = $questionText;
        $this->options = $options;
        $this->active = $active;
        
    }
    
}