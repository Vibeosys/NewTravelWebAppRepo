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
class SqliteTable extends Table {

    private $sqliteFile;

    public function Create($id) {
        $returnValue = false;
        $dbDir = new Folder(SQLITE_DB_DIR, true);
        \Cake\Log\Log::debug('folder created');
        $this->sqliteFile = $dbDir->path. 'TravelDb' . $id . '.SQLITE';
        $db = new \SQLite3($this->sqliteFile);
        if ($db != NULL) {
            $fileContents = file_get_contents(__DIR__ .DS.'CreateTableScripts.sql');
            $db->exec($fileContents);
            $db->close();
            $returnValue = true;
        }
        return $returnValue;
    }

    public function excutePreparedStatement($Text) {
        $db = new \SQLite3($this->sqliteFile);
        if ($Text) {
            $success = $db->exec($Text);
            $db->close();
            return $success;
        }
        return NOT_FOUND;
    }

}
