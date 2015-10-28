<?php

namespace App\Controller;

require '../vendor/autoload.php';



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use App\DTO;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Cake\Filesystem\Folder;

/**
 * Description of ImageController
 *
 * @author niteen
 * 
 */
//require 'vendor/autoload.php';
define('IMG_INS_QRY', "INSERT INTO images (ImageId,ImagePath,UserId,DestId,ImageSeen) VALUES (\"@ImageId\",\"@ImagePath\",\"@UserId\",@DestId,\"@ImageSeen\");");

class ImagesController extends ApiController {

    public $extension = array("jpeg", "jpg", "png", "gif", "bmp", "JPEG", "JPG", "PNG", "GIF", "BMP");

    public function getTableObj() {
        return new Table\ImagesTable();
    }

    public function uploadDestinationImage($data) {

        $this->autoRender = false;
        //$data = $this->request->data;
        if (empty($data)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(106));
            \Cake\Log\Log::debug("Image data empty");
            return;
        }
        $binary = base64_decode($data['upload']);
        $filename = $data['imagename'];
        $ext = $this->getExtension($filename);
        if (!in_array($ext, $this->extension)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(105));
            \Cake\Log\Log::error("invalid image extension : " . $ext);
            return FAIL;
        }
        $dir = new Folder(DESTINATION_IMAGE_DIR, true);
        $image = DESTINATION_IMAGE_DIR . $filename;
        $file = fopen($image, 'wb');
        fwrite($file, $binary);
        fclose($file);
        if (file_exists($image)) {
            $awsDir = AWS_DESTINATION_IMAGES_DIR . $this->getDestinationName($data['destId']);
            \Cake\Log\Log::debug("image uploading on destination : " . $awsDir);
            $imageUrl = $this->awsImageUpload($awsDir, $filename, $image);
            \Cake\Log\Log::debug("imageUrl return from aws server : " . $imageUrl);
            $imageDto = new DTO\ClsImagesDto($data['imageId'], $imageUrl, $data['userId'], $data['destId']);
            $this->saveImage($imageDto);
            $this->response->body(DTO\ClsErrorDto::prepareSuccessMessage($filename . ' image uploaded '));
            $this->response->send();
            \Cake\Log\Log::debug('image upload successful filename : ' . $filename);
            return SUCCESS;
        }
        $this->response->body(DTO\ClsErrorDto::prepareError(111));
        return FAIL;
    }

    public function uploadProfileImage($data) {
        $binary = base64_decode($data['upload']);
        $filename = $data['imagename'];
        $ext = $this->getExtension($filename);
        \Cake\Log\Log::info("image extension : " . $ext);
        if (!in_array($ext, $this->extension)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(105));
            $this->response->send();
            return FAIL;
        }
        $dir = new Folder(PROFILE_IMAGE_DIR, true);
        $imagePath = PROFILE_IMAGE_DIR . $filename;
        $file = fopen($imagePath, 'wb');
        fwrite($file, $binary);
        fclose($file);
        if (file_exists($imagePath)) {
            $awsDir = AWS_USER_PROFILE_IMAGES_DIR . $data['userId'];
            $imageUrl = $this->awsImageUpload($awsDir, $filename, $imagePath);
            $userDto = new DTO\ClsUserDto($data['userId'], $userName = null, $password = null, $data['emailId'], $imageUrl);
            if ($this->updateProfile($userDto)) {
                $this->response->body(DTO\ClsErrorDto::prepareSuccessMessage("profile image uploaded"));
                $this->response->send();
                \Cake\Log\Log::debug('profile image upload successful imagename : ' . $filename);
                return SUCCESS;
            }
        }
        $this->response->body(DTO\ClsErrorDto::prepareError(111));
        $this->response->send();
        return FAIL;
    }

    private function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    private function getAll() {
        return $this->getTableObj()->getAllImages();
    }

    public function prepareInsertStatement() {
        $allImages = $this->getAll();
        if (!$allImages) {
            return NOT_FOUND;
        }
        $preparedStatements = '';
        foreach ($allImages as $image) {
            $preparedStatements .= IMG_INS_QRY;
            $preparedStatements = str_replace('@ImageId', $image->imageId, $preparedStatements);
            $preparedStatements = str_replace('@ImagePath', $image->imagePath, $preparedStatements);
            $preparedStatements = str_replace('@UserId', $image->userId, $preparedStatements);
            $preparedStatements = str_replace('@DestId', $image->destId, $preparedStatements);
            $preparedStatements = str_replace('@ImageSeen', $image->imageSeen, $preparedStatements);
        }

        return $preparedStatements;
    }

    private function saveImage(DTO\ClsImagesDto $imageDto) {
        if ($this->getTableObj()->insertImage($imageDto->imageId, $imageDto->userId, $imageDto->destId, $imageDto->imagePath)) {
            $syncController = new SyncController();
            $syncController->imagesEntry($imageDto->userId, json_encode($imageDto));
            return SUCCESS;
        }
        return FAIL;
    }

    private function updateProfile(DTO\ClsUserDto $userDto) {
        $userTable = new Table\UserTable();
        $result = $userTable->updateProfileImage($userDto->userId, $userDto->photoUrl);
        if ($result) {
            return SUCCESS;
        } else {
            return FAIL;
        }
    }

    private function awsImageUpload($dir, $fileName, $filePath) {
        $this->autoRender = false;
        $bucket = \appconfig::getAwsDefaultBucket(LOCAL_ENV);
        $s3Client = $this->createS3Client();
        $date = date('Y-M-d_H:i:s');
        try {
            $upload = $s3Client->upload($bucket, $dir .$date.'_'.$fileName, fopen($filePath, 'rb'), 'public-read-write');
            \Cake\Log\Log::debug("Aws url of uploaded image  : " . $upload['ObjectURL']);
            return $upload['ObjectURL'];
        } catch (S3Exception $e) {
            \Cake\Log\Log::error($e->getMessage());
            $this->response->body($e->getMessage());
        }
    }

    private function createS3Client() {
        $this->autoRender = false;
        $s3FactoryArgs = \appconfig::getAwsDefaults(LOCAL_ENV);
        $s3Client = S3Client::factory($s3FactoryArgs);
        \Cake\Log\Log::info("S3Client instantiation completed");
        return $s3Client;
    }

    private function getDestinationName($destId) {
        $destinationTable = new Table\DestinationTable();
        return $destinationTable->getName($destId);
    }

}
