<?php
namespace App\DTO\DownloadDto;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OptionsDto
 *
 * @author niteen
 */
class OptionsDto {
    public  $optionId;
    public  $optionText;
    public  $questionId;
    




    public function __construct($optionId,$optiontext,$questionId = null) {
        
        $this->optionId = $optionId;
        $this->optionText = $optiontext;
        $this->questionId = $questionId;
        
    }
    
    
}
