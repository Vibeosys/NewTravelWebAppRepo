<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mysql2SqliteController
 *
 * @author niteen
 */
use App\Model\Table;
use Cake\Network;




class SqliteController extends AppController {

  

    public function getDB($userId) {
        $this->autoRender = false;
        $tableObject = new Table\SqliteTable();
        if ($tableObject->Create($userId)) {

            //Destination Table
            $destinationController = new DestinationController();
            $destinationPreparedStatement = $destinationController->prepareInsertStatement();
            if ($tableObject->excutePreparedStatement($destinationPreparedStatement)) {
                \Cake\Log\Log::info('Record is inserted into Destination SQLite table for id ' . $userId);
            } else {
                \Cake\Log\Log::error('Record is not inserted into Destination SQLite table');
            }
            
            //User Table
            $userController = new UserController();
            $userPreparedStatement = $userController->prepareInsertStatement();
            if($tableObject->excutePreparedStatement($userPreparedStatement)){
                \Cake\Log\Log::info('Record is inserted into User SQLite table for id ' . $userId);
            } else {
                \Cake\Log\Log::error('Record is not inserted into User  SQLite table');
            }
            
            //Question Table
            $questionController = new QuestionController();
            $questionPreparedStatement = $questionController->prepareInsertStatement();
            if($tableObject->excutePreparedStatement($questionPreparedStatement)){
                \Cake\Log\Log::debug('Record is inserted into Question sQLite table for id' . $userId);
            }else {
                \Cake\Log\Log::debug('Record is not inserted into Question sQLite table for id');
            }
            
             //Options Table
            $optionController = new OptionsController();
            $optionPreparedStatement = $optionController->prepareInsertStatement();
            if($tableObject->excutePreparedStatement($optionPreparedStatement)){
                \Cake\Log\Log::debug('Record is inserted into Options sQLite table for id' . $userId);
            }else {
                \Cake\Log\Log::debug('Record is not inserted into Options sQLite table for id');
            }
            
            //Answer Table
            $answerController = new AnswerController();
            $answerPreparedStatement = $answerController->prepareInsertStatement();
            if($tableObject->excutePreparedStatement($answerPreparedStatement)){
                \Cake\Log\Log::debug('Record is inserted into Answer sQLite table for id' . $userId);
            }else {
                \Cake\Log\Log::debug('Record is not inserted into Answer sQLite table for id');
            }
            
              //Comment And Like  Table
            $commentAndLikeController = new CommentAndLikeController();
            $commentAndLikePreparedStatement = $commentAndLikeController->prepareInsertStatement();
            if($tableObject->excutePreparedStatement($commentAndLikePreparedStatement)){
                \Cake\Log\Log::debug('Record is inserted into commentAndLike sQLite table for id' . $userId);
            }else {
                \Cake\Log\Log::debug('Record is not inserted into commentAndLike sQLite table for id');
            }
            
            //Images Table
            $imagesController = new ImagesController();
            $imagesPreparedStatement = $imagesController->prepareInsertStatement();
            if($tableObject->excutePreparedStatement($imagesPreparedStatement)){
                \Cake\Log\Log::debug('Record is inserted into Images sQLite table for id' . $userId);
            }else {
                \Cake\Log\Log::debug('Record is not inserted into Images sQLite table for id');
            }
            
             //Stat_Config Table
            $statconfController = new StatConfController();
            $statconfPreparedStatement = $statconfController->prepareInsertStatement();
            if($tableObject->excutePreparedStatement($statconfPreparedStatement)){
                \Cake\Log\Log::debug('Record is inserted into stat_conf sQLite table for id' . $userId);
            }else {
                \Cake\Log\Log::debug('Record is not inserted into stat_conf SQLite table for id');
            }
        $this->response->type('class');
        $this->response->file(SQLITE_DB_DIR.'TravelDb'.$userId.'.SQLITE',['download' => true]);
        $this->response->send();
       
        $retult = unlink(SQLITE_DB_DIR.'TravelDb'.$userId.'.SQLITE');
     
        $userTable = new Table\UserTable();
        $userTable->update($userId);
        
        }
    }

}
