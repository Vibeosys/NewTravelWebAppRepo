<?php
namespace App\Model\Table;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentAndLikeTable
 *
 * @author niteen
 */
Use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
class CommentAndLikeTable extends Table{
    
   
   // to get object of table registry for database operation
    public function connect() {
        return TableRegistry::get('comment_and_like');
    }
    // to get all users like count
    public function getLikeCount() {
        $rows = $this->connect()->find();
        $i = 0;
        foreach ($rows as $row){
            $likeCount[$i]['UserId'] = $row->UserId;
            $likeCount[$i]['DestId'] = $row->DestId;
            $likeCount[$i]['LikeCount'] = $row->LikeCount;
            $i = $i + 1;
        }
        return $likeCount;
    }
    public function getLike() {
        
    }
    public function getComment() {
        $rows = $this->connect()->find();
        $i = 0;
        foreach($rows as $row){
          $Comment[$i]['UserId'] = $row->UserId;
          $Comment[$i]['DestId'] = $row->DestId;
          $Comment[$i]['Comment'] = $row->Comment;
          $i = $i + 1;
        }
        return $Comment;
    }
    public function putLikeCount($userid,$destid) {
        $checks = $this->connect()->find()->where(['UserId =' => $userid,'DestId =' => $destid]);
       $check = null;
        foreach ($checks as $check)
       {
           
       }
       if($check){ 
            $count = $check->LikeCount + 1;
            $query = $this->connect()->query();
             $query->update();
             $query->set(['LikeCount' => $count,'LikeUpdatedDate' => date('Y-m-d H:i:sa')]);
             $query->where(['UserId =' => $userid,'DestId =' => $destid]);
             if($query->execute()){
                 return TRUE;
             }else{
                 return FALSE;
             }
             
            //$query->LikeUpdatedDate = date('Y-m-d H:i:sa');
            //$this->connect()->save($query);
        } else{
            $query = $this->connect()->newEntity();
            $query->UserId = $userid;
            $query->DestId = $destid;
            $query->LikeCount = 1;
            $query->LikeUpdatedDate = date('Y-m-d H:i:sa');
            if($this->connect()->save($query)){
                return TRUE;
             }else{
                 return FALSE;
             }
        }
        
    }
    public function putComment($userid, $destid, $comment) {
       $checks = $this->connect()->find()->where(['UserId =' => $userid]);
       foreach ($checks as $check)
       {
           
       }
       if($check->DestId == $destid){ 
            
            $query = $this->connect()->query();
             $query->update();
             $query->set(['CommentText' => $comment,'CommentUpdatedDate' => date('Y-m-d H:i:sa')]);
             if($query->execute()){
                 return TRUE;
             }else{
                 return FALSE;
             }
        } else{
            $query = $this->connect()->newEntity();
            $query->UserId = $userid;
            $query->DestId = $destid;
            $query->CommentText = $comment;
            $query->CommentUpdatedDate = date('Y-m-d H:i:sa');
            if($this->connect()->save($query)){
                return TRUE;
             }else{
                 return FALSE;
             }
        }
        
    }
}
