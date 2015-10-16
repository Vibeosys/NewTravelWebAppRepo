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

    public function addLike() {
        $querydata = $this->request->input('json_decode');
        if ($this->getTableObj()->putLikeCount($querydata->UserId, $querydata->DestId)) {
            $syn = new SyncController;
            $json = '{"UserId":"' . $querydata->UserId . '", "DestId":"' . $querydata->DestId . '"}';
            $syn->likeEntry($querydata->UserId, $json);
            $this->response->body('{"ERROR":"FALSE","MESSAGE":"Your Like For UserId : ' . $querydata->UserId . ' Saved Successfully"}');
            $this->response->send();
        } else {
            $this->response->body('{"ERROR":"TRUE","MESSAGE":"Your Like Not Recieved"}');
            $this->response->send();
        }
    }

    public function addComment() {
        $querydata = $this->request->input('json_decode');
        if ($this->getTableObj()->putComment($querydata->UserId, $querydata->DestId, $querydata->CommentText)) {
            $syn = new SyncController;
            $json = '{"UserId":"' . $querydata->UserId . '", "DestId":"' . $querydata->DestId . '","CommentText":"' . $querydata->CommentText . '"}';
            $syn->likeEntry($querydata->UserId, $json);
            $this->response->body('{"ERROR":"FALSE","MESSAGE":"Your Comment For DestId : ' . $querydata->DestId . ' Saved Successfully"}');
            $this->response->send();
        } else {
            $this->response->body('{"ERROR":"TRUE","MESSAGE":"Your Comment Not Recieved"}');
            $this->response->send();
        }
    }

    public function prepareInsertStatement() {
        $allCommentAndLike = $this->getAll();
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
