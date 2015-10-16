<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentAndLikeController
 *
 * @author niteen
 */
use App\Model\Table;
class CommentAndLikeController extends AppController{
    
    //to get its own table object
    public function getTableObj() {
        return new Table\CommentAndLikeTable();
    }
    
    public function get() {
        
    }
    public function addLike() {
        $querydata = $this->request->input('json_decode');
        if($this->getTableObj()->putLikeCount($querydata->UserId, $querydata->DestId)){
            $syn = new SyncController;
            $json = '{"UserId":"'.$querydata->UserId.'", "DestId":"'.$querydata->DestId.'"}';
            $syn->likeEntry($querydata->UserId,$json);
            $this->response->body('{"ERROR":"FALSE","MESSAGE":"Your Like For UserId : '.$querydata->UserId.' Saved Successfully"}');
            $this->response->send();
        }else{
            $this->response->body('{"ERROR":"TRUE","MESSAGE":"Your Like Not Recieved"}');
            $this->response->send();
        }
        
    }
    public function addComment() {
        $querydata = $this->request->input('json_decode');
        if($this->getTableObj()->putComment($querydata->UserId, $querydata->DestId, $querydata->CommentText)){
            $syn = new SyncController;
        $json = '{"UserId":"'.$querydata->UserId.'", "DestId":"'.$querydata->DestId.'","CommentText":"'.$querydata->CommentText.'"}';
        $syn->likeEntry($querydata->UserId,$json);
         $this->response->body('{"ERROR":"FALSE","MESSAGE":"Your Comment For DestId : '.$querydata->DestId.' Saved Successfully"}');
         $this->response->send();
        }else{
            $this->response->body('{"ERROR":"TRUE","MESSAGE":"Your Comment Not Recieved"}');
            $this->response->send();
            
        }
        
    }
}
