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
class ClsCommentAndLikeDto {

    public $UserId;
    public $DestId;
    public $LikeCount;
    public $CommentText;
    public $CreatedDate;

    public function __construct($userId, $destId, $likeCount = null, $commentText = null, $createdDate = null) {

        $this->UserId = $userId;
        $this->DestId = $destId;
        $this->LikeCount = $likeCount;
        $this->CommentText = $commentText;
        $this->CreatedDate = $createdDate;
    }

}
