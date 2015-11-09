<?php
namespace App\DTO\DownloadDto;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserDto
 *
 * @author niteen
 */
class UserDto {

    public  $userId;
    public  $userName;
    public  $photoUrl;
    
    public function __construct($userId = null,$userName = null,$photoUrl = null) {
        
        $this->userId = $userId;
        $this->userName = $userName;
        $this->photoUrl = $photoUrl;
    }
}
