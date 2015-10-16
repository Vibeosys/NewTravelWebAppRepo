<?php
namespace App\Model\Table;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file(, choose Tools | Templates
 * and open the template in the editor.
 */
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Database\Connection;
use App\DTO;
/**
 * Description of AnswerTable
 *
 * @author niteen
 */
class AnswerTable extends Table{
    
    public function connect() {
        return TableRegistry::get('answer');
    }
    public function getAll() {
        $rows = $this->connect()->find();
        $i = 0;
        foreach ($rows as $row){
                $answerDto = new DTO\ClsAnswerDto($row->AnswerId, $row->UserId, 
                        $row->DestId, $row->OptionId, $row->CreatedDate);
                     $all[$i] = $answerDto;
                $i++;
        }        
        return $all;
    }
    public function getNew($Id) {
        $rows = $this->connect()->find()->where(['AnswerId = ' => $Id]);
        foreach ($rows as $row){
            $all['UserId'] = $row->UserId;
            $all['DestId'] = $row->DestId;
            $all['OptionId'] = $row->OptionId;
            $all['UpdatedDate'] = $row->UpdatedDate;
        }        
        return $all;
    }
    public function Insert($userid,$destid,$optionid) {
        $query = $this->connect()->newEntity();
     
        $query->UserId = $userid;
        $query->DestId = $destid;
        $query->OptionId = $optionid;
        $query->CreatedDate = date('Y-m-d H-i-sa');
        $query->UpdatedDate = date('Y-m-d H-i-sa');
        if($this->connect()->save($query)){
            return $query->AnswerId;
        }
    }
    public function SqliteInsert($userid,$destid,$optionid) {
        try{
            $database = new \SQLite3('converted.sqlite');
            $date = date('Y-m-d H-i-sa');
         $sql =
        'INSERT INTO answer (UserId,DestId,OptionId,CreatedDate,UpdatedDate)
        VALUES ('.$userid.','. $destid.','.$optionid.',"'.$date.'","'.$date.'" )';
        $database->exec($sql);
        }catch(Exception $e){
            echo $e->getMessage();
        }  
    }
    
}
