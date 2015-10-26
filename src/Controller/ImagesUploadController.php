<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\DTO;

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
        try {
            if (array_key_exists('emailId', $data)) {
                $imagesController = new ImagesController();
                $result = $imagesController->uploadProfileImage($data);
                if($result) {
                    \Cake\Log\Log::debug("profile image uploaded successfully");
                } else {
                    \Cake\Log\Log::error("Invalid image extension");
                }
            } else {
                $imagesController = new ImagesController();
                $result = $imagesController->uploadDestinationImage($data);
                if ($result) {
                    \Cake\Log\Log::debug("Destination image uploaded successfully");
                } else {
                    \Cake\Log\Log::error("Invalid image extension");
                }
            }
        } catch (Exception $ex) {

            \Cake\Log\Log::error("Exception found in image upload : " . $ex);
        }
    }

}
