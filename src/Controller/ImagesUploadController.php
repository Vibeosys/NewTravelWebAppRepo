<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\DTO;
use App\Model\Table;

/**
 * Description of ImagesUploadController
 *
 * @author niteen
 */
class ImagesUploadController extends ApiController {

    public function index() {
        $this->autoRender = false;
        $data = $this->request->data;
      
        if (empty($data)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(106));
            \Cake\Log\Log::debug("Image data empty");
            return;
        }
         if (!array_key_exists('userId', $data) or !array_key_exists('emailId', $data) or !array_key_exists('userName', $data)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(107));
            \Cake\Log\Log::debug("Image data empty");
            return;
        }

        $userTable = new Table\UserTable();
        if (!$userTable->userCkeck($data['userId'], $data['emailId'], $data['userName'])) {
            $this->response->body(DTO\ClsErrorDto::prepareError(112));
            return ;
        }
       
            if (array_key_exists('destId', $data)) {
                $imagesController = new ImagesController();
                $result = $imagesController->uploadDestinationImage($data);
                if ($result) {
                    \Cake\Log\Log::debug("Destination image uploaded successfully");
                } else {
                    \Cake\Log\Log::error("Invalid image extension");
                }
            } else {
                $imagesController = new ImagesController();
                $result = $imagesController->uploadProfileImage($data);
                if ($result) {
                    \Cake\Log\Log::debug("profile image uploaded successfully");
                } else {
                    \Cake\Log\Log::error("Invalid image extension");
                }
            }
      
    }

}
