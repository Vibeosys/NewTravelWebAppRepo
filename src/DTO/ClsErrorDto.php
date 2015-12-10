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
    
    
    protected $errorDictionary = [
        100 => 'User is not authenticated',
        101 => 'UserId is blank or device information is empty',
        102 => 'Unknown error occured',
        103 => 'Update not found',
        104 => 'Invalid request',
        105 => 'Invalid image extension',
        106 => 'Please select image',
        107 => 'UserId and Email fields empty',
        108 => 'User information not updated successfully into database',
        109 => 'Not Saved Try again',
        110 => 'Database Exception occured',
        111 => 'Problem in image uploading',
        112 => 'Update your email and username before uploading profile photo OR check your userId and emailId',
        113 => 'Error to save user profile image. please try again.',
        114 => 'Invalid user details',
        115 => 'Mail was not send. try again',
        116 => 'Please choose valid input',
        117 => 'Invalid data',
        118 => 'Invalid to email address',
        119 => 'OTP verification failed',
        120 => 'Answer Not Saved'
       ];
    
    
}
