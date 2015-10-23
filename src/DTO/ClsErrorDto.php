<?php
namespace App\DTO;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsErrorDto
 *
 * @author niteen
 */
class ClsErrorDto {
    
    public $errorCode;
    public $message;
    
    
    
    //format {"errorCode":"100", "message":"User is not authenticated"}
    public static function prepareError($errorcode) {
        
        $errorDto = new ClsErrorDto();
        $errorDto->errorCode = $errorcode;
        $errorDto->message = $errorDto->errorDictionary[$errorcode];
        return json_encode($errorDto);
    }
    protected $errorDictionary = array(
        100 => 'User is not authenticated',
        101 => 'UserId is blank',
        102 => 'Unknown error occured',
        103 => 'Update not found',
        104 => 'Invalid request',
        105 => 'Invalid image'
    );
    
    
}
