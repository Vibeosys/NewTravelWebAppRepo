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

    public function submitComment($senderUserId, \App\DTO\ClsCommentAndLikeDto $commentDto) {
        $result = $this->getTableObj()->ispresent($commentDto->userId, $commentDto->destId);
        if ($result) {
            $this->updateComment($senderUserId, $commentDto);
        } else {
            $result = $this->getTableObj()->insertComment($commentDto->userId, $commentDto->destId, $commentDto->commentText);
            if ($result) {
                $json = json_encode(new DTO\ClsCommentDto($commentDto->userId, $commentDto->destId, $commentDto->commentText, $result));
                $syncController = new \App\Controller\SyncController();
                $syncController->commentEntry($senderUserId, $commentDto->userId, $json, INSERT);
                $this->response->body(\App\DTO\ClsErrorDto::prepareSuccessMessage("Comment Saved"));
                \Cake\Log\Log::debug("comment insert in db for user : " . $commentDto->userId);
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

    private function updateComment($senderUserId, $commentDto) {
        $result = $this->getTableObj()->updateComment($commentDto->userId, $commentDto->destId, $commentDto->commentText);
        if ($result) {
             $json = json_encode(new DTO\ClsCommentDto($commentDto->userId, $commentDto->destId, $commentDto->commentText, $result));
            $syncController = new \App\Controller\SyncController();
            $syncController->commentEntry($senderUserId, $commentDto->userId, $json, UPDATE);
            $this->response->body(\App\DTO\ClsErrorDto::prepareSuccessMessage("Comment Updated"));
            \Cake\Log\Log::debug("comment insert in db for user : " . $commentDto->userId);
            $this->response->send();
        } else {
            \Cake\Log\Log::error("error in comment insertion");
            $this->response->body(\App\DTO\ClsErrorDto::prepareError(109));
            $this->response->send();
        }
    }

    public function submitLike($senderUserId, \App\DTO\ClsCommentAndLikeDto $likeDto) {
        $result = $this->getTableObj()->ispresent($likeDto->userId, $likeDto->destId);
        if ($result) {
            $this->updateLike($senderUserId, $result->LikeCount, $likeDto);
        } else {
            if ($this->getTableObj()->insertLike($senderUserId, $likeDto->userId, $likeDto->destId)) {
                $json = json_encode(new DTO\ClsLikeDto($likeDto->userId, $likeDto->destId, LIKE));
                $syncController = new \App\Controller\SyncController();
                $syncController->likeEntry($senderUserId, $likeDto->userId, $json, INSERT);
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

    private function updateLike($senderUserId, $count, DTO\ClsCommentAndLikeDto $likeDto) {
        $result = $this->getTableObj()->updateLike($count, $likeDto->userId, $likeDto->destId);
        if ($result) {
            $json = json_encode(new DTO\ClsLikeDto($likeDto->userId, $likeDto->destId, $result));
            $syncController = new \App\Controller\SyncController();
            $syncController->likeEntry($senderUserId, $likeDto->userId, $json, UPDATE);
            \Cake\Log\Log::debug('Like succefully stored');
            $this->response->body(DTO\ClsErrorDto::prepareSuccessMessage("Like Saved"));
            $this->response->send();
        } else {
            \Cake\Log\Log::error('Like not saved');
            $this->response->body(\App\DTO\ClsErrorDto::prepareError(109));
            $this->response->send();
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
