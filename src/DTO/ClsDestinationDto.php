<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsDestinationDto
 *
 * @author niteen
 */
class ClsDestinationDto {
    public $destId;
    public $destName;
    public $lat;
    public $long;
    public $active;

    public function __construct($destId,$destName,$lat,$long,$active= null) {
        $this->destId = $destId;
        $this->destName = $destName;
        $this->lat = $lat;
        $this->long = $long;
        $this->active = $active;
       
        
    }
    
    
}
