<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsUploadDeserializerDto
 *
 * @author niteen
 */

class ClsUploadDeserializerDto extends JsonDeserializer {
   
        public  $user;
        public  $data;
        public function __construct($user = null,$data = null) {
            $this->user = $user;
            $this->data = $data;
        }
}
