<?php
namespace App\DTO;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Deserializer;
/**
 * Description of ClsJsonDeserializeDto
 *
 * @author niteen
 */
class ClsJsonDeserializerDto extends JsonDeserializer{
  
    public  $User;
    public  $data;
    public  $tableName;
    public  $tableData;




    public function __construct() {
        //$this->TableName = $tableName;
        //$this->TableData = $tableData;
        
    }
    
}
