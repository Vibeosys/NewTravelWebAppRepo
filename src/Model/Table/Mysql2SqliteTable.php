<?php

namespace App\Model\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mysql2SqliteTable
 *
 * @author niteen
 */
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;

class Mysql2SqliteTable extends Table {

    private $sqliteFile;

    public function Create($id) {
        $returnValue = false;
        
        $this->sqliteFile = 'TravelDb' . $id . '.sqlite';
        $db = new \SQLite3($this->sqliteFile);
        if ($db != NULL) {

            $fileContents = file_get_contents(__DIR__ . '\CreateTableScripts.sql');
            $db->exec($fileContents);
            $db->close();

            $returnValue = true;
        }
        return $returnValue;
    }

    public function excutePreparedStatement($destText) {
        $db = new \SQLite3($this->sqliteFile);
        $success = $db->exec($destText);
        $db->close();
        return $success;
    }

}
