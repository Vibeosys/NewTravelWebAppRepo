<?php

namespace App\DTO;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsCommentAndLikeDto
 *
 * @author niteen
 */
class ClsCommentAndLikeDto extends JsonDeserializer{

    public $userId;
    public $destId;
    public $likeCount;
    public $commentText;
    public $createdDate;

    public function __construct($userId = null, $destId = null, $likeCount = null, $commentText = null, $createdDate = null) {

        $this->userId = $userId;
        $this->destId = $destId;
        $this->likeCount = $likeCount;
        $this->commentText = $commentText;
        $this->createdDate = $createdDate;
    }

}
