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

class ClsStatConfigDto extends AjaxDeserializer{

    
  public $key;
  public  $value;
  
  public function __construct($key = null,$value = null) {
      
      $this->key = $key;
      $this->value = $value;
  }
}
