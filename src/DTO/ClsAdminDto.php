<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsAdminDto
 *
 * @author niteen
 */
class ClsAdminDto {
    
    
    public  $adminUsername;
    public  $adminPassword;
    
    public function __construct($userName = null, $password = null) {
        
        $this->adminUsername = $userName;
        $this->adminPassword = $password;
    }
}
