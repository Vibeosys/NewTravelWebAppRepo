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
define('LIKE', 1);
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

    public function getLike() {
        
    }

    public function getComment() {
        $rows = $this->connect()->find();
        $i = 0;
        foreach ($rows as $row) {
            $Comment[$i]['UserId'] = $row->UserId;
            $Comment[$i]['DestId'] = $row->DestId;
            $Comment[$i]['Comment'] = $row->Comment;
            $i = $i + 1;
        }
        return $Comment;
    }

    public function insertLike($userid, $destid) {
        $check = $this->ispresent($userid, $destid);
        if ($check) {
            $count = ++$check->LikeCount;
            $query = $this->connect()->query();
            $query->update();
            $query->set(['LikeCount' => $count, 'LikeUpdatedDate' => date('Y-m-d H:i:sa')]);
            $query->where(['UserId =' => $userid, 'DestId =' => $destid]);
            if ($query->execute()) {
                return SUCCESS;
            } else {
                return FAIL;
            }
        } else {
            $query = $this->connect()->newEntity();
            $query->UserId = $userid;
            $query->DestId = $destid;
            $query->LikeCount = LIKE;
            $query->LikeUpdatedDate = date('Y-m-d H:i:sa');
            if ($this->connect()->save($query)) {
                return SUCCESS;
            } else {
                return FAIL;
            }
        }
    }

    public function insertComment($userid, $destid, $comment) {
        $check = $this->ispresent($userid, $destid);
        if ($check) {
            $query = $this->connect()->query();
            $query->update();
            $query->set(['CommentText' => $comment, 'CommentUpdatedDate' => date('Y-m-d H:i:sa')]);
            $query->where(['UserId ='=> $userid ,'DestId =' => $destid]);
            if ($query->execute()) {
                return SUCCESS;
            } else {
                return FAIL;
            }
        } else {
            $query = $this->connect()->newEntity();
            $query->UserId = $userid;
            $query->DestId = $destid;
            $query->CommentText = $comment;
            $query->CommentUpdatedDate = date('Y-m-d H:i:sa');
            if ($this->connect()->save($query)) {
                return SUCCESS;
            } else {
                return FAIL;
            }
        }
    }

    private function ispresent($userid, $destid) {
        $checks = $this->connect()->find()->where(['UserId =' => $userid, 'DestId =' => $destid]);
        $check = null;
        foreach ($checks as $check) {
            return $check;
        }
        return FAIL;
    }

}
