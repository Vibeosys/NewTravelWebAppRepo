<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cake\Network;
use Cake\ORM\TableRegistry;
use App\Model\Table;

/**
 * Description of DemoController
 *
 * @author niteen
 */
define('USER_INS_QRY', "INSERT INTO user (UserId,UserName,PhotoUrl)VALUES (@UserId,\"@UserName\",\"@PhotoUrl\");");

class UserController extends AppController {

    public function connect() {

        return TableRegistry::get('user');
    }

    public function getTableObj() {
        return new Table\UserTable();
    }

    public function show() {

        $path = func_get_args();
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));
        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    //to activate user

    public function userCreation() {
        $querydata = $this->request->input('json_decode');
        $config = new Stat_ConfController;
        //New User Activation
        if (!$data = $this->getTableObj()->checkUser($querydata->MobileNo) and strlen($querydata->MobileNo) == 10) {
            $OTP = $this->getOtp();
            if ($this->sendSms($querydata->MobileNo, $OTP)) {
                if ($this->getTableObj()->create($querydata->UserName, $querydata->MobileNo, $OTP)) {
                    $this->response->type('application/json');
                    $this->response->body('{"Error":"FALSE", Message":"OTP send on your number","UserId":"' . $this->getTableObj()->checkUser($querydata->MobileNo)->UserId . '"}');
                    $this->response->send();
                } else {
                    $this->response->type('application/json');
                    $this->response->body('{"Error":"TRUE","Message":"Plase Validate Your Number"}');
                }
            }
            //Resend OTP To Registered And Autorised User
        } else if ($this->getTableObj()->getTrial($querydata->MobileNo) <= $config->NoOfRetry()) {
            $OTP = $this->getOtp();
            if ($this->sendSms($querydata->MobileNo, $OTP)) {
                if ($this->getTableObj()->update($querydata->MobileNo, $OTP)) {
                    $this->response->type('application/json');
                    $this->response->body('{"Error":"FALSE", "Message":"OTP Resend on your number","NoOfRetry":' . $this->getTableObj()->checkUser($querydata->MobileNo)->NoOfRetry . '');
                    $this->response->send();

                    //Failed
                } else {
                    $this->response->type('application/json');
                    $this->response->body('{"Error":"TRUE", "Messege":"Sorry Your OTP Retry Crossed Limit"}');
                    $this->response->send();
                }
            }
        }
    }

    public function userActivation() {
        $querydata = $this->request->input('json_decode');

        if ($this->getTableObj()->getStoredOTP($querydata->UserId) == $querydata->OTP) {
            $this->getTableObj()->activate($querydata->UserId);
            $this->response->body('{"Error":"FALSE", "Message":"Your Successfully Activated","active":"1"}');

            $this->makeEntry($querydata->UserId);
            //$file = $this->Attachments->getFile();
            $path = 'D:\GitPhpWebsites\TravelWebSiteForMobile\MobileTravelWeb\webroot\converted.sqlite';
            $this->response->download('converted.sqlite');
            $this->response->send();
        } else {
            $this->response->type('application/json');
            $this->response->body('{"Error":"TRUE", "Messege":"Please check OTP", "Active":"0"}');
            $this->response->send();
        }
    }


    public function makeEntry($Id) {
        $syn = new SyncController;
        $mysql2sqliteObj = new Mysql2SqliteController;
        $mysql2sqliteObj->createSqlite($Id);
        $syn->userEntry($this->getTableObj()->getAll($Id), $this->getTableObj()->getNew($Id));
    }

    private function getAllUser() {
        return $this->getTableObj()->getAll(1);
    }

    public function prepareInsertStatement() {
        $allUser = $this->getAllUser();
        $preparedStatement = '';
        foreach ($allUser as $user){
            $preparedStatement.= USER_INS_QRY;
            $preparedStatement = str_replace('@UserId', $user->UserId, $preparedStatement);
            $preparedStatement = str_replace('@UserName', $user->UserName, $preparedStatement);
            $preparedStatement = str_replace('@PhotoUrl', $user->PhotoUrl, $preparedStatement);
        }
        return $preparedStatement;
    }

}
