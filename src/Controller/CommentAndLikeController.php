<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;


/**
 * Description of CommentAndLikeController
 *
 * @author niteen
 */
define('CAL_INS_QRY', "INSERT INTO comment_and_like (UserId,DestId,LikeCount,CommentText,CreatedDate) VALUES (@UserId,@DestId,@LikeCount,\"@CommentText\",\"@CreatedDate\");");

class CommentAndLikeController extends AppController {

    //to get its own table object
    public function getTableObj() {
        return new Table\CommentAndLikeTable();
    }

    private function getAll() {
        return $this->getTableObj()->getCommentAndLike();
    }

    public function submitComment(\App\DTO\ClsCommentAndLikeDto $comment) {

        $this->autoRender = false;
        if ($comment) {
            
            if ($this->getTableObj()->insertComment($comment->UserId,$comment->DestId,$comment->CommentText)) {
                \Cake\Log\Log::info('Comment succefully stored');
                $this->response->body('{"ERROR":"false", "message":"Saved"}');
                $this->response->send();
                return SUCCESS;
            } else {
                \Cake\Log\Log::error('Comment not  stored');
                $this->response->body('{"ERROR":"true", "message":"Not Saved. Try again"}');
            }
        }
    }

    public function submitLike(\App\DTO\ClsCommentAndLikeDto $like) {
        $this->autoRender = false;
        if ($like) {
            
            if ($this->getTableObj()->insertLike($like->UserId, $like->DestId)) {
                
                \Cake\Log\Log::info('Like succefully stored');
                $this->response->body('{"ERROR":"false", "message":"Saved"}');
            } else {
                \Cake\Log\Log::error('Like not  stored');
                $this->response->body('{"ERROR":"true", "message":"Not Saved. Try again"}');
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
            $preparedStatements = str_replace('@UserId', $commentAndLike->UserId, $preparedStatements);
            $preparedStatements = str_replace('@DestId', $commentAndLike->DestId, $preparedStatements);
            $preparedStatements = str_replace('@LikeCount', $commentAndLike->LikeCount, $preparedStatements);
            $preparedStatements = str_replace('@CommentText', $commentAndLike->CommentText, $preparedStatements);
            $preparedStatements = str_replace('@CreatedDate', $commentAndLike->CreatedDate, $preparedStatements);
        }
        return $preparedStatements;
    }

}
