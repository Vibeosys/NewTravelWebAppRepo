<?php

namespace App\DTO;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsImagesDto
 *
 * @author niteen
 */
class ClsImagesDto {

    public $ImageId;
    public $ImagePath;
    public $UserId;
    public $DestId;
    public $ImageSeen;

    public function __construct($imagePath, $userId, $destId, $imageId = null) {
        $this->ImageId = $imageId;
        $this->ImagePath = $imagePath;
        $this->UserId = $userId;
        $this->DestId = $destId;
        $this->ImageSeen = "false";
    }

}
