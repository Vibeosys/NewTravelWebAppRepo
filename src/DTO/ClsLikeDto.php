<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsLikeDto
 *
 * @author niteen
 */
class ClsLikeDto {
    public $userId;
    public $destId;
    public $likeCount;
   

    public function __construct($userId = null, $destId = null, $likeCount = null) {

        $this->userId = $userId;
        $this->destId = $destId;
        $this->likeCount = $likeCount;
    }
}
