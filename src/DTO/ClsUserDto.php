<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsUserDto
 *
 * @author niteen
 */
class ClsUserDto extends JsonDeserializer{
   
    public  $userId;
    public  $userName;
    public  $password;
    public  $emailId;
    public  $active;
    public  $photoUrl;
    public  $createdDate;
    
    public function __construct($userId = null,$userName = null,$password = null,$emailId = null,$photoUrl = null,$active = null,$createdDate = null) {
        
        $this->userId = $userId;
        $this->userName = $userName;
        $this->password =$password;
        $this->emailId = $emailId;
        $this->photoUrl = $photoUrl;
        $this->active = $active;
        $this->createdDate = $createdDate;
        
    }
    
}
