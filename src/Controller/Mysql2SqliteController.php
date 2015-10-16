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

define('PATH', 'D:\GitPhpWebsites\TravelWebSiteForMobile\MobileTravelWeb\webroot');

class Mysql2SqliteController extends AppController {

    private $tableInstance;
    
    public function getTableObj() {
        if (!isset($tableInstance))
        {   
            $tableInstance = new Table\Mysql2SqliteTable();        
        }
        
        return $tableInstance;
    }

    public function createSqlite() {
        $id = 1;
        $tableObject = new Table\Mysql2SqliteTable();
        if ($tableObject->Create($id)) {


            $DestObj = new DestinationController;
            $destinationPreparedStatement = $DestObj->prepareInsertStatement();
            if ($tableObject->excutePreparedStatement($destinationPreparedStatement)) {
                \Cake\Log\Log::info('Record is inserted into Destination SQLite table for id ' . $id);
            } else {
                \Cake\Log\Log::error('Record is not inserted into Destination SQLite table');
            }
            

            

        $this->response->type('class');
        $this->response->file(PATH.'/TravelDb'.$id.'.sqlite',['download' => true,'name' => 'myfile'.$id.'.sqlite']);
        $this->response->send();
        }
    }

}
