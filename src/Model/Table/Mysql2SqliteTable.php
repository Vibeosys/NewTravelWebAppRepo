<?php

namespace App\Model\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Cake\ORM\Table;
use Cake\Filesystem\Folder;
/**
 * Description of Mysql2SqliteTable
 *
 * @author niteen
 */


class Mysql2SqliteTable extends Table {

    private $sqliteFile;

    public function Create($id) {
        $returnValue = false;
        $dbDir = new Folder(TMP.DS.'SqliteDBFiles',true);
        \Cake\Log\Log::debug('folder created');
        
        $this->sqliteFile = TMP.DS.'SqliteDBFiles'.DS.'TravelDb' . $id . '.sqlite';
        $db = new \SQLite3($this->sqliteFile);
        if ($db != NULL) {

            $fileContents = file_get_contents(__DIR__ . '\CreateTableScripts.sql');
            $db->exec($fileContents);
            $db->close();

            $returnValue = true;
        }
        return $returnValue;
    }

    public function excutePreparedStatement($Text) {
        $db = new \SQLite3($this->sqliteFile);
        $success = $db->exec($Text);
        $db->close();
        return $success;
    }

}
