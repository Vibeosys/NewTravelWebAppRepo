<?php

namespace App\Controller;

//require ROOT . DS . 'vendor\autoload.php';



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
use Cake\Network;

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

    public function upload1() {

        $this->autoRender = false;
        $data = $this->request->data;
         if (empty($data)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(106));
            \Cake\Log\Log::debug("Image data empty");
            return;
        }
        $binary = base64_decode($data['upload']);
        $filename = $data['imagename'];
        
        //$ext = $this->getExtension($filename);
        /*
        if (!in_array($ext, $this->extension)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(105));
            \Cake\Log\Log::error("invalid image extension : ".$ext);
            return FAIL;
        }
         * 
         */
        $dir = new Folder(DESTINATION_IMAGE_DIR, true);
        $file = fopen(DESTINATION_IMAGE_DIR.$filename, 'wb');
        fwrite($file, $binary);
        fclose($file);
        if (file_exists(DESTINATION_IMAGE_DIR.$filename)) {
            $imageDto = new DTO\ClsImagesDto($imageId = null, $dir->path.$filename, $data['userId'], $data['destId']);
            $this->saveImage($imageDto);
            $this->response->body(DTO\ClsErrorDto::prepareSuccessMessage($filename .'Uploaded Successfully'));
            \Cake\Log\Log::debug('file upload successful filename : ' . $filename);
            return SUCCESS;
        }
        $this->response->body(DTO\ClsErrorDto::prepareError(111));
        return FAIL;
    }
    public function uploadProfileImage($data) {
        $binary = base64_decode($data['upload']);
        $filename = $data['imagename'];
        $ext = $this->getExtension($filename);
        if (!in_array($ext, $this->extension)) {
            $this->response->body(DTO\ClsErrorDto::prepareError(105));
            return FAIL;
        }
         $dir = new Folder(PROFILE_IMAGE_DIR, true);
        $file = fopen($dir->path. $filename, 'wb');
        fwrite($file, $binary);
        fclose($file);
        if (file_exists($file)) {
            $userDto = new DTO\ClsUserDto($data['userId'], $userName = null, $password = null, $data['emailId'], $dir->path.$filename);
            $this->updateProfile($imageDto);
            $this->response->body('{"message":"' . $filename . 'upload successful"}');
            \Cake\Log\Log::debug('profile image upload successful filename : ' . $filename);
            return SUCCESS;
        }
        $this->response->body(DTO\ClsErrorDto::prepareError(111));
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

    private function saveImage(DTO\ClsImagesDto $imageDto) {
        if ($this->getTableObj()->insertImage($imageDto->userId, $imageDto->destId, $imageDto->imagePath)) {
            return SUCCESS;
        }
        return FAIL;
    }
    private function updateProfile($param) {
        
    }

    public function amazonUpload() {
        $this->autoRender = false;
        $bucket = 'tempdir';
        $filename = $keyname = 'data.txt';
        $s3client = S3Client::factory(array(
        'includes' => array('_aws'),
        'services' => array(
        'default_settings' => array(
        'params' => array(
        'profile' => 'anand',
        'region' => 'ap-southeast-1'
      )))));
        try {
            // Upload data.
            $upload = $s3->upload($bucket, $filename, 'hello world', 'public-read');
            $result = $s3client->putObject(array(
                'Bucket' => $bucket,
                'Key' => $keyname,
                'Body' => 'Hello, world!',
                'ACL' => 'public-read'
            ));

            // Print the URL to the object.
            echo $result['ObjectURL'] . "\n";
        } catch (S3Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

}
