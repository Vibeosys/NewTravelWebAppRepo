<?php
namespace App\Controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\DTO;
use App\Model\Table;

use App\Controller\Component;

/**
 * Description of DownloadDbController
 *
 * @author niteen
 */
class DownloadDbController extends ApiController {
   
    
     public function index() {
        $this->autoRender = false;
       
        //$tempUserId = null;
        $tempUserId = $this->request->query("userid");
        $info = base64_decode($this->request->query('info'));
        $ip = $this->request->clientIp();
         \Cake\Log\Log::debug('DownloadDb request input querystring info : '.$info);
        if(empty($tempUserId)){
            $this->response->body(DTO\ClsErrorDto::prepareError(101));
            \Cake\Log\Log::error("User requested with blank user id :".$tempUserId);
            return ;
        }
        $networkDeviceInfoDto = DTO\ClsNetworkDeviceInfoDto::Deserialize($info);
        $ipInfo = new Component\Ipinfo();
        $fullDetails = $ipInfo->getFullIpDetails($tempUserId,$networkDeviceInfoDto,$ip);
        $networkDeviceInfoTable = new Table\NetworkDeviceInfoTable();
        $networkDeviceInfoTable->saveNetworkDeviceInfo($fullDetails);
        $userDto = new DTO\ClsUserDto($tempUserId);
        \Cake\Log\Log::debug('TempUserId is send to Validate'.$tempUserId." userIP : ".$ip);
        if($this->isValid($userDto->userId)) {
            \Cake\Log\Log::debug("User validate");
                $sqliteController = new SqliteController();
                $sqliteController->getDB($userDto->userId);
                \Cake\Log\Log::debug("Sqlite database sended to user");
        } else {
            $userController = new UserController();
            \Cake\Log\Log::debug('UserId send to save in database');
            if($userController->userSignUp($userDto->userId)){
                $sqliteController = new SqliteController();
                $sqliteController->getDB($userDto->userId);
                \Cake\Log\Log::debug("sqlite file sended  to user after userid saving");
            }
        }
     }
     private function isValid($userid) {
        $userTable = new Table\UserTable();
        if ($userTable->validate($userid)) {
            return SUCCESS;
        } else {
            return FAIL;
        }
    }
}
