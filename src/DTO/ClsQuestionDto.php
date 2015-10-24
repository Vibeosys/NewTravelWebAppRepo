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
class ClsQuestionDto {
    
    public $questionId;
    public $questionText;
    
    public function __construct($questionId,$questionText) {
        
        $this->questionId = $questionId;
        $this->questionText = $questionText;
    }
    
}