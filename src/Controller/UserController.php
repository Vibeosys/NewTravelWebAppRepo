<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use App\DTO;

/**
 * Description of DemoController
 *
 * @author niteen
 */
define('USER_INS_QRY', "INSERT INTO user (UserId,UserName,PhotoUrl)VALUES (\"@UserId\",\"@UserName\",\"@PhotoUrl\");");

class UserController extends ApiController {

    public function getTableObj() {
        return new Table\UserTable();
    }

    //give temp access to user by providing temp userid
    public function userSignUp($userId) {
        if ($this->getTableObj()->insertUser($userId)) {
            \Cake\Log\Log::debug('temp Userid inserted');
            return SUCCESS;
        }
        return FAIL;
    }

    public function getAllUser() {
        return $this->getTableObj()->getAll();
    }

    public function prepareInsertStatement() {
        $allUser = $this->getAllUser();
        if (!$allUser) {
            return NOT_FOUND;
        }
        $preparedStatement = '';
        foreach ($allUser as $user) {
            // \Cake\Log\Log::debug("active field value from user table : ".var_dump($user->active));
            if ($user->active) {
                $preparedStatement.= USER_INS_QRY;
                $preparedStatement = str_replace('@UserId', $user->userId, $preparedStatement);
                $preparedStatement = str_replace('@UserName', $user->userName, $preparedStatement);
                $preparedStatement = str_replace('@PhotoUrl', $user->photoUrl, $preparedStatement);
            }
        }
        return $preparedStatement;
    }

    public function sendOtp() {
        $this->autoRender = false;
        $json = $this->request->input();

        $userOtp = DTO\ClsUserDto::Deserialize($json);
        $userToEmailid = $userOtp->emailId;

        if (empty($userToEmailid)) {
            $this->response->body(\App\DTO\ClsErrorDto::prepareError(118));
            //$this->response->send();
            return;
        }
        
        $otp = rand(1000, 999999);
        $subject = OTP_EMAIL_SUBJECT;
        $message = sprintf(OTP_EMAIL_BODY, $otp);
        //Update the OTP in database
        $result = $this->getTableObj()->updateOtp($userOtp -> userId, $otp);
        
        $emailClient = new \Cake\Mailer\Email('default');
        $emailClient ->addBcc('anand@vibeosys.com','Anand Kulkarni');
        $emailClient ->subject($subject);
        $emailClient ->to($userToEmailid);
        $emailClient ->send($message);
        
        if ($result) {
            $this->response->body(\App\DTO\ClsErrorDto::prepareSuccessMessage("verification email was sent to email : " . $userToEmailid));
            //$this->response->send();
            return;
        } else {
            $this->response->body(\App\DTO\ClsErrorDto::prepareError(115));
            //$this->response->send();
            return;
        }
    }

}
