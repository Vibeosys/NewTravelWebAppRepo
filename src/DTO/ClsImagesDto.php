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
class ClsImagesDto extends JsonDeserializer{

    public $imageId;
    public $imagePath;
    public $userId;
    public $destId;
    public $imageSeen;

    public function __construct($imageId = null,$imagePath = null, $userId = null, $destId = null) {
        $this->imageId = $imageId;
        $this->imagePath = $imagePath;
        $this->userId = $userId;
        $this->destId = $destId;
        $this->imageSeen = "false";
    }

}
