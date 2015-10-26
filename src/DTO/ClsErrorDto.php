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
    
     public static function prepareSuccessMessage($message) {
        
        $errorDto = new ClsErrorDto();
        $errorDto->errorCode = 0;
        $errorDto->message = $message;
        return json_encode($errorDto);
    }
    
    
    protected $errorDictionary = array(
        100 => 'User is not authenticated',
        101 => 'UserId is blank',
        102 => 'Unknown error occured',
        103 => 'Update not found',
        104 => 'Invalid request',
        105 => 'Invalid image',
        106 => 'Please select image',
        107 => 'UserId and Email fields empty',
        108 => 'User info not updated successfully into database',
        109 => 'Not Saved Try again',
        110 => 'Database Exception occured',
        111 => 'problem in image uploading',
        112 => 'update your email and username before uploading profile photo OR check your userId and emailId'
    );
    
    
}
