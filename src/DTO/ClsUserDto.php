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
class ClsUserDto {
   
    public  $UserId;
    public  $UserName;
    public  $Password;
    public  $EmailId;
    public  $Active;
    public  $PhotoUrl;
    public  $CreatedDate;
    
    public function __construct($userId,$userName = null,$password = null,$emailId = null,$photoUrl = null,$active = null,$createdDate = null) {
        
        $this->UserId = $userId;
        $this->UserName = $userName;
        $this->Password =$password;
        $this->EmailId = $emailId;
        $this->PhotoUrl = $photoUrl;
        $this->Active = $active;
        $this->CreatedDate = $createdDate;
        
    }
    
}
