<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Model\Table;
use Cake\ORM\TableRegistry;

/**
 * Description of DestController
 *
 * @author niteen
 */
define('DEST_INS_QRY', "INSERT INTO destination (DestId,DestName,Lat,Long)VALUES (@DestId,\"@DestName\",@Lat, @Long);");

class DestinationController extends AppController{
    
       public function connect() {
        return TableRegistry::get('destination');
    }
    public function getTableObj() {
        return new Table\DestinationTable();
    }
    private function getAllDest() {
        return $this->getTableObj()->getDest();
        
    }
    public function getNewDest($DestId) {
        return $this->getTableObj()->newDest($DestId);
    }
    public function putNewDest() {
        $querydata = $this->request->input('json_decode');
        if($this->getTableObj()->InsertDest($querydata->DestName,$querydata->lat, $querydata->long,$querydata->Active)){
            $this->getTableObj()->SqliteInsert($querydata->DestName,$querydata->lat, $querydata->long,$querydata->Active);
        }
    }
    public function prepareInsertStatement() {
        $allDestinations = $this->getAllDest();
         if(!$allDestinations){
                return NOT_FOUND;
            }
        $preparedStatement = '';
        foreach ($allDestinations as $destination)
        {
            $preparedStatement.= DEST_INS_QRY;

            $preparedStatement = str_replace('@DestId', $destination->Destid, $preparedStatement);
            $preparedStatement = str_replace('@DestName', $destination->DestName, $preparedStatement);
            $preparedStatement = str_replace('@Lat', $destination->Lat, $preparedStatement);
            $preparedStatement = str_replace('@Long', $destination->Long, $preparedStatement);
            
        }
        return $preparedStatement;
    }
}
