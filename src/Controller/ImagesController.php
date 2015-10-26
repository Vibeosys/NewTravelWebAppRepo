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
        $file = fopen(DESTINATION_IMAGE_DIR . $filename, 'wb');
        fwrite($file, $binary);
        fclose($file);
        if (file_exists(DESTINATION_IMAGE_DIR . $filename)) {
            $imageDto = new DTO\ClsImagesDto($data['imageId'], DESTINATION_IMAGE_DIR . $filename, $data['userId'], $data['destId']);
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
        $file = fopen(PROFILE_IMAGE_DIR . $filename, 'wb');
        fwrite($file, $binary);
        fclose($file);
        if (file_exists(PROFILE_IMAGE_DIR . $filename)) {
            $userDto = new DTO\ClsUserDto($data['userId'], $userName = null, $password = null, $data['emailId'], PROFILE_IMAGE_DIR . $filename);
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

    public function upload() {
        
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

    private function saveImage($imageDto) {
        if ($this->getTableObj()->insertImage($imageDto->imageId, $imageDto->userId, $imageDto->destId, $imageDto->imagePath)) {
            return SUCCESS;
        }
        return FAIL;
    }

    private function updateProfile(DTO\ClsUserDto $userDto) {
        $userTable = new Table\UserTable();
        $result = $userTable->updateProfileImage($userDto->userId, $userDto->emailId, $userDto->photoUrl);
        if ($result) {
            return SUCCESS;
        } else {
            $this->response->body(DTO\ClsErrorDto::prepareError(112));
            $this->response->send();
        }
    }

    public function amazonUpload() {
        $this->autoRender = false;
        $data = $this->request->data;
        $bucket = "dev.vibeosys.com";
       // $key = $data['key'];
        //$body = $data['body'];
        $s3Client = new S3Client([
            'version' => '2006-03-01',
            'region' => 'ap-southeast-1',
            'credentials' => [
                'key' => 'AKIAIKZ5UROAPNSQJZNA',
                'secret' => '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',
            ],
        ]);
         curl_setopt(curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        //$s3 = S3Client::factory();
//            'version' => '2006-03-01',
//            'region' => 'ap-southeast-1',
//            'credentials' => [
//                'key' => 'AKIAIKZ5UROAPNSQJZNA',
//                'secret' => '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',
//            ],
//        ]);
        \Cake\Log\Log::info("S3Client instantiation completed");
        try {
            // Upload data.
           $upload = $s3Client -> upload($bucket, 'new.txt', 'hello world', 'public-read');
//        $result = $s3Client -> putObject(array(
//                'Bucket' => $bucket,
//                'Key' => 'er.png',
//                'SourceFile' => 'D:\GitPhpWebsites\NewTravelWebAppRepo\tmp\ProfileImages\er.png',
//                'ContentType' => 'application/octet-stream',
//                'ACL' => 'public-read'
//            ));
//            \Cake\Log\Log::info("file uploaded");
            //$uploadResult = $s3Client->upload($bucket, $key, $body,$Acl = 'public');
            
            
//            $info = openssl_get_cert_locations();
           
            // Print the URL to the object.
           
            $this->response->body($result['ObjectURL'].$upload->get('name'));
            $this->response->send();
        } catch (S3Exception $e) {
            $this->response->body($e->getMessage());
        }
    }

}
