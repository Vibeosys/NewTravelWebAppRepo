<?php

namespace App\Model\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\DTO;

/**
 * Description of CommentAndLikeTable
 *
 * @author niteen
 */
class CommentAndLikeTable extends Table {

    // to get object of table registry for database operation
    public function connect() {
        return TableRegistry::get('comment_and_like');
    }

    // to get all users like count
    public function getCommentAndLike() {
        if (!$this->connect()->find()->count()) {
            return NOT_FOUND;
        }
        $rows = $this->connect()->find();
        $i = 0;
        foreach ($rows as $row) {
            $commentAndLikeDto = new DTO\ClsCommentAndLikeDto($row->UserId, $row->DestId, $row->LikeCount, $row->CommentText, $row->CommentUpdatedDate);
            $allCommentAndLike[$i] = $commentAndLikeDto;
            $i++;
        }
        return $allCommentAndLike;
    }

    public function insertLike($userid, $destid) {
        $query = $this->connect()->newEntity();
        $query->UserId = $userid;
        $query->DestId = $destid;
        $query->LikeCount = LIKE;
        $query->LikeUpdatedDate = date('Y-m-d H:i:s');
        if ($this->connect()->save($query)) {
            return SUCCESS;
        } else {
            return FAIL;
        }
    }

    public function updateLike($count, $userid, $destid) {
        $count++;
        $query = $this->connect()->query();
        $query->update();
        $query->set(['LikeCount' => $count, 'LikeUpdatedDate' => date('Y-m-d H:i:s')]);
        $query->where(['UserId =' => $userid, 'DestId =' => $destid]);
        if ($query->execute()) {
            return $count;
        }
        return FAIL;
    }

    public function insertComment($userid, $destid, $comment) {
            $query = $this->connect()->newEntity();
            $query->UserId = $userid;
            $query->DestId = $destid;
            $query->CommentText = $comment;
            $query->CommentUpdatedDate = $current = date('Y-m-d H:i:s');
            if ($this->connect()->save($query)) {
                return $current;
            } else {
                return FAIL;
            }
    }

    public function updateComment($userId, $destId, $comment) {

        $query = $this->connect()->query()->update();
        $query->set(['CommentText' => $comment, 'CommentUpdatedDate' => $current = date('Y-m-d H:i:s')]);
        $query->where(['UserId =' => $userId, 'DestId =' => $destId]);
        if ($query->execute()) {
            return $current;
        }
        return FAIL;
    }

    public function ispresent($userid, $destid) {
        $checks = $this->connect()->find()->where(['UserId =' => $userid, 'DestId =' => $destid]);
        $check = null;
        foreach ($checks as $check) {
            return $check;
        }
        \Cake\Log\Log::info("user count for like insert : " . $check);
        return FAIL;
    }

}
