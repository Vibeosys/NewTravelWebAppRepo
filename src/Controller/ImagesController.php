<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use Cake\Network;
use App\DTO;
use Aws\S3\S3Client;
use Cake\Filesystem\File;

/**
 * Description of ImageController
 *
 * @author niteen
 */
define('IMG_INS_QRY', "INSERT INTO images (ImageId,ImagePath,UserId,DestId,ImageSeen) VALUES (@ImageId,\"@ImagePath\",@UserId,@DestId,\"@ImageSeen\");");

class ImagesController extends ApiController {

    public function getTableObj() {
        return new Table\ImagesTable();
    }

    public function upload1() {
        $this->autoRender = false;
        $data = $this->request->data();
        $binary = base64_decode($data['upload']);
        $filename = $data['imagename'];
        $ext = end(explode('.', $filename));
        $file = fopen(TMP .'/' . $filename, 'wb');
        fwrite($file, $binary);
        fclose($file);
       // if (file_exists($file)) {
         //   $imageDto = new DTO\ClsImagesDto($imageId = null, $file, $data['UserId'], $data['DestId']);
          // $this->saveImage($imageDto);
                $this->response->body('{"message":"' . $filename . 'Uploaded Successfully"}');
                
                \Cake\Log\Log::debug('file upload successful filename : ' . $filename . ' file_extension :' . $ext);
           
        //}
        //  move_uploaded_file($file, $target_file)
        //print_r($image);


        /*
          $target_dir = TMP;
          $target_file = $target_dir . basename($_FILES["upload"]["name"]);
          \Cake\Log\Log::debug("reading uploaded file");
          $uploadOk = 1;
          //   $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
          // Check if image file is a actual image or fake image
          if ($image) {
          \Cake\Log\Log::debug("Check file is image or not?");
          $check = getimagesize($_FILES["upload"]["tmp_name"]);
          if ($check !== false) {
          $type = "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
          } else {
          echo "File is not an image.";
          $uploadOk = 0;
          }
          }

          // Check if file already exists
          if (file_exists($target_file)) {
          $message = "Sorry, file already exists.";
          \Cake\Log\Log::debug($message);
          $uploadOk = 0;
          }
          // Check file size
          if ($_FILES["upload"]["size"] > 500000) {
          $message = "Sorry, your file is too large.";
          \Cake\Log\Log::debug($message);
          $uploadOk = 0;
          }
          /* Allow certain file formats
          if ($imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
          $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
          }
         * 

          // Check if $uploadOk is set to 0 by an error
          if ($uploadOk == 0) {
          $message1 = "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
          } else {
          if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
          // $s3Client = new S3Client();
          //$s3Client->upload('https://s3.amazonaws.com/dev.vibeosys.com/TempDir/', basename($_FILES["upload"]["name"]), $_FILES["upload"]["tmp_name"]);
          $message = "The file " . basename($_FILES["upload"]["name"]) . " has been uploaded.";
          \Cake\Log\Log::debug($message);
          } else {
          $message = "Sorry, there was an error uploading your file.";
          }
          }
         * 
         */
        //\Cake\Log\Log::debug('You are hitting correct endpoint' . $filename . 'extension' . $ext);
        //$this->response->body('You are hitting correct endpoint'.$filename);
        //$this->response->send();
        //$this->set(['type' => $type, 'message' => $message, 'message1' => $message1]);
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
            $preparedStatements = str_replace('@ImageId', $image->ImageId, $preparedStatements);
            $preparedStatements = str_replace('@ImagePath', $image->ImagePath, $preparedStatements);
            $preparedStatements = str_replace('@UserId', $image->UserId, $preparedStatements);
            $preparedStatements = str_replace('@DestId', $image->DestId, $preparedStatements);
            $preparedStatements = str_replace('@ImageSeen', $image->ImageSeen, $preparedStatements);
        }

        return $preparedStatements;
    }

    public function saveImage(DTO\ClsImagesDto $imageDto) {
        if ($this->getTableObj()->insertImage($imageDto->UserId, $imageDto->DestId, $imageDto->ImagePath)) {
            return SUCCESS;
        }
        return FAIL;
    }

}
