<?php
namespace App\Model\Table;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\DTO;
/**
 * Description of ActivateModel
 *
 * @author niteen
 */



class UserTable extends Table{

    public function initialize(array $config){}
     //to get Object of table registry
    public function connect() {
        return TableRegistry::get('user');
    }
    //to check user Instance present or not
    public function checkUser($MobileNo) {
        $rows = $this->connect()->find()->where(['MobileNo =' => $MobileNo]);
        foreach ($rows as $row) {
            return $row;
        }
    }
    //to get instance of all user record
  
    //to get otp of user for activation
    public function getStoredOTP($UserId) {
       $rows = $this->connect()->find()->where(['UserId =' => $UserId]);
       foreach ($rows as $row){
       return $row->OTP;
       } 
     }
     //get number of trial of user checking for user crossed limit or not
      public function getTrial($MobileNo) {
        $rows =  $this->connect()->find()->where(['MobileNo =' => $MobileNo]);
        foreach ($rows as $row){
        return $row->OTPRetryCount;
        }
    }
   
     public function insertUser($Name,$MobileNo,$OTP) {
        
        $user = $this->connect()->newEntity();
        $user->UserName = $Name;
        $user->MobileNo = $MobileNo;
        $user->OTP = $OTP;
        $user->OTPRetryCount = 1;
        $user->CreatedDate = date("Y-m-d H:i:sa");
        if($this->connect()->save($user))
        {
            return $this->checkUser($MobileNo)->UserId; 
        }
    }
     public function update($MobileNo,$OTP) {
        
        $user = $this->connect()->get($this->checkUser($MobileNo)->UserId);
        $user->OTP = $OTP;
        $user->OTPRetryCount = $this->getTrial($MobileNo) + 1;
        if($this->connect()->save($user)){
        return $user->OTPRetryCount;
        }
    }
    public function activate($UserId) {
     
         $user = $this->connect()->get($UserId);
         $user->Active = 1;
         $this->connect()->save($user);
         
    }
    //to retive all 
    public function getAll($Id) {
        $rows = $this->connect()->find()->where(['UserId !=' => $Id]);
        $i = 0;   
        foreach ($rows as $row)
        {       
            if ($row->Active) {
                $userDto = new \App\DTO\ClsUserDto($row->UserId, $row->UserName,
                                $row->Password, $row->EmailId, $row->PhotoUrl, 
                        $row->Active,$row->CreatedDate);
                $allUser[$i] = $userDto;
                $i++;
            }
            
        }
        return $allUser;
    }
    public function getNew($Id) {
         $rows = $this->connect()->where(['UserId =' => $Id]);
     
         foreach ($rows as $row)
        {
            $newUser['UserId'] = $row->UserId;
            $newUser['UserName'] = $row->UserName;
        }
       
        return $newUser;
    }
    
}
