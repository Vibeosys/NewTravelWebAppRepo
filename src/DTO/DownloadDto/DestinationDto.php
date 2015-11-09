<?php
namespace App\DTO\DownloadDto;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DestinationDto
 *
 * @author niteen
 */
class DestinationDto {
  
    public $destId;
    public $destName;
    public $latitude;
    public $longitude;
    



    public function __construct($destId,$destName,$lat,$long) {
        $this->destId = $destId;
        $this->destName = $destName;
        $this->latitude = $lat;
        $this->longitude = $long;
    }
}
