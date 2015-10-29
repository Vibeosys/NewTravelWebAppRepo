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

class DestinationController extends ApiController{
    
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
        if($this->getTableObj()->InsertDest($querydata->destName,$querydata->lat, $querydata->long,$querydata->active)){
            $this->getTableObj()->SqliteInsert($querydata->destName,$querydata->lat, $querydata->long,$querydata->active);
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

            $preparedStatement = str_replace('@DestId', $destination->destId, $preparedStatement);
            $preparedStatement = str_replace('@DestName', $destination->destName, $preparedStatement);
            $preparedStatement = str_replace('@Lat', $destination->lat, $preparedStatement);
            $preparedStatement = str_replace('@Long', $destination->long, $preparedStatement);
            
        }
        return $preparedStatement;
    }
}
