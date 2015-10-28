<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
//        $this->loadComponent('Flash');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
  
    public function backupMysqldump($tables = '*') {
       $return = '';
        $connection = ConnectionManager::get('default');

        //$modelName = $this->modelClass;
        //echo $modelName;
        //$dataSource = $this->{$modelName}->getDataSource();
        $databaseName = 'TravelDB';//$dataSource->getSchemaName();
        $connection->connect();
        // Do a short header
        $return .= '-- Database: `' . $databaseName . '`' . "\n";
        $return .= '-- Generation time: ' . date('D jS M Y H:i:s') . "\n\n\n";


        if ($tables == '*') {
            $tables = array();
            $results = $connection->execute('SHOW TABLES')->fetchAll('assoc');
            foreach($results as $result){
               
                $tables[] = $result['Tables_in_traveldb'];
               
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        // Run through all the tables
        foreach ($tables as $table) {
            $tableData =$connection->execute('SELECT * FROM ' . $table)->fetchAll('assoc');
          
            $return .= 'DROP TABLE IF EXIST ' . $table . ';';
            $createTableResult = $connection->execute('SHOW CREATE TABLE '.$table.'')->fetchAll('assoc');
          
            $createTableEntry = (current($createTableResult));
           // print_r($createTableEntry);
            $return .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";
            // Output the table data
            foreach($tableData as $tableDataIndex => $tableDataDetails) {

                $return .= 'INSERT INTO ' . $table . ' VALUES(';

                foreach($tableDataDetails as $dataKey => $dataValue) {
                    //echo $datavalue;
                    if(is_null($dataValue)){
                    $escapedDataValue = 'NULL';
                    }
                    else {
                    // Convert the encoding
                        $escapedDataValue = mb_convert_encoding( $dataValue, "UTF-8", "ISO-8859-1" );

                    // Escape any apostrophes using the datasource of the model.
                        //$escapedDataValue = $this->{$modelName}->getDataSource()->value($escapedDataValue);
                    }

                    $tableDataDetails[$table][$dataKey] = $escapedDataValue;
                }
                $return .= implode(',', $tableDataDetails[$table]);

                $return .= ");\n";
            }

            $return .= "\n\n\n";
        }

        // Set the default file name
        $fileName = $databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';
        $myfile = fopen("D:/GitPhpWebsites/TravelWebSiteForMobile/MobileTravelWeb/".$fileName."", "w") or die("Unable to open file!");
        fwrite($myfile, $return);
        fclose($myfile);
        // Serve the file as a download
        //return $fileName;
        $this->autoRender = false;
        $this->response->type('Content-Type: text/x-sql');
        $this->response->download($fileName);
        $this->response->body($return);
    }

}

