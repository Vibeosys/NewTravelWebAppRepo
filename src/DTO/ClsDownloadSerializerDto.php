<?php
namespace App\DTO;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsJsonDeserializeDto
 *
 * @author niteen
 */
class ClsDownloadSerializerDto{
  
    public  $tableName;
    public  $tableData;
    public  $opration;
    public function __construct($tableName, $tableData ,$operation) {
       $this->tableName = $tableName;
       $this->tableData = $tableData;
       $this->opration = $operation;
        
    }
    
}
