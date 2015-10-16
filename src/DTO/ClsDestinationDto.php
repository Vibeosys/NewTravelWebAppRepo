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
    public $Destid;
    public $DestName;
    public $Lat;
    public $Long;
    public $Active;
    public $CreatedDate;
    public $UpdatedDate;

    public function __construct($destId,$destName,$lat,$long,$active,$createdDate,$updatedDate) {
        $this->Destid = $destId;
        $this->DestName = $destName;
        $this->Lat = $lat;
        $this->Long = $long;
        $this->Active = $active;
        $this->CreatedDate = $createdDate;
        $this->UpdatedDate = $updatedDate;
        
    }
    
    
}
