<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsStatConfig
 *
 * @author niteen
 */

class ClsStatConfigDto {

    
  public $Key;
  public  $Value;
  
  public function __construct($key,$value) {
      
      $this->Key = $key;
      $this->Value = $value;
  }
}
