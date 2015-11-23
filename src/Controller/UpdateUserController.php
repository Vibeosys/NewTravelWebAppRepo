<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\DTO;
use App\Controller\ApiController;
use App\Model\Table;
use App\DTO\DownloadDto;

/**
 * Description of UpdateUserController
 *
 * @author niteen
 */
class UpdateUserController extends ApiController {

    private function getTableObj() {
        return new Table\UserTable();
    }

    public function update() {
        $this->autoRender = false;
        $userInfo = $this->request->input();
        \Cake\Log\Log::debug("User information request input json for update : ".$userInfo);
        if (empty($userInfo)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(107));
            \Cake\Log\Log::error("User information is empty");
            return FAIL;
        }
        \Cake\Log\Log::debug("Update user json : " . $userInfo);
        $userDto = DTO\ClsUserDto::Deserialize($userInfo);
        if (isset($userDto->password)) {
            $this->updateWithOtp($userDto);
        } else {
            $this->updateUserInfo($userDto);
        }
    }

    private function updateWithOtp($userOtpInfo) {
        if ($this->getTableObj()->verifyOtp($userOtpInfo->userId, $userOtpInfo->password)) {
            $this->updateUserInfo($userOtpInfo);
        } else {
            $this->response->body(DTO\ClsErrorDto::prepareError(119));
        }
    }

    private function updateUserInfo($userDto) {
        if (is_null($userDto->userId) or is_null($userDto->emailId) or is_null($userDto->userName)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(114));
            \Cake\Log\Log::error("User information is empty");
            return FAIL;
        }
        if ($this->getTableObj()->update($userDto)) {
            $this->response->body(DTO\ClsErrorDto::prepareSuccessMessage("User updated successfully for userid " . $userDto->userId));
            $syncController = new SyncController;
            $downloadUserDto = new DownloadDto\UserDto($userDto->userId, $userDto->userName, $userDto->photoUrl);
            $syncController->userEntry($userDto->userId, json_encode($downloadUserDto), INSERT);
        } else {
            $this->response->body(DTO\ClsErrorDto::prepareError(108));
        }
    }

}
