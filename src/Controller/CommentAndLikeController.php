<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use App\DTO;


/**
 * Description of CommentAndLikeController
 *
 * @author niteen
 */
define('CAL_INS_QRY', "INSERT INTO comment_and_like (UserId,DestId,LikeCount,CommentText,CreatedDate) VALUES (\"@UserId\",@DestId,@LikeCount,\"@CommentText\",\"@CreatedDate\");");

class CommentAndLikeController extends ApiController {

    //to get its own table object
    public function getTableObj() {
        return new Table\CommentAndLikeTable();
    }

    private function getAll() {
        return $this->getTableObj()->getCommentAndLike();
    }

    public function submitComment($senderUserId,\App\DTO\ClsCommentAndLikeDto $comment) {

        $this->autoRender = false;
        if ($comment) {
             $result = $this->getTableObj()->insertComment($senderUserId,$comment->userId,$comment->destId,$comment->commentText);
            if ($result) {
               
                $this->response->body(\App\DTO\ClsErrorDto::prepareSuccessMessage("Comment Saved"));
                \Cake\Log\Log::debug("comment insert in db for user : ".$comment->userId);
                $this->response->send();
                return SUCCESS;
            } else {
                $this->response->body(\App\DTO\ClsErrorDto::prepareError(109));
                   $this->response->send();
                \Cake\Log\Log::error("error in comment insertion");
                return FAIL;
            }
        }
    }

    public function submitLike($senderUserId,\App\DTO\ClsCommentAndLikeDto $like) {
        $this->autoRender = false;
        if ($like) {
            
            if ($this->getTableObj()->insertLike($senderUserId,$like->userId, $like->destId)) {
                
                \Cake\Log\Log::debug('Like succefully stored');
                $this->response->body(DTO\ClsErrorDto::prepareSuccessMessage("Like Saved"));
                $this->response->send();
            } else {
                \Cake\Log\Log::error('Like not saved');
                $this->response->body(\App\DTO\ClsErrorDto::prepareError(109));
                   $this->response->send();
                  
            }
        }
    }

    public function prepareInsertStatement() {
        $allCommentAndLike = $this->getAll();
        if (!$allCommentAndLike) {
            return NOT_FOUND;
        }
        $preparedStatements = '';
        foreach ($allCommentAndLike as $commentAndLike) {

            $preparedStatements.= CAL_INS_QRY;
            $preparedStatements = str_replace('@UserId', $commentAndLike->userId, $preparedStatements);
            $preparedStatements = str_replace('@DestId', $commentAndLike->destId, $preparedStatements);
            $preparedStatements = str_replace('@LikeCount', $commentAndLike->likeCount, $preparedStatements);
            $preparedStatements = str_replace('@CommentText', $commentAndLike->commentText, $preparedStatements);
            $preparedStatements = str_replace('@CreatedDate', $commentAndLike->createdDate, $preparedStatements);
        }
        return $preparedStatements;
    }

}
