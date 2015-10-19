<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Model\Table;
use Cake\Network;

/**
 * Description of ImageController
 *
 * @author niteen
 */
define('IMG_INS_QRY', "INSERT INTO images (ImageId,ImagePath,UserId,DestId,ImageSeen) VALUES (@ImageId,\"@ImagePath\",@UserId,@DestId,\"@ImageSeen\");");

class ImagesController extends AppController {

    public function getTableObj() {
        return new Table\ImagesTable();
    }

    public function upload1() {
        $target_dir = "C:/Users/Niteen/Desktop/uploads/";
        $target_file = $target_dir . basename($_FILES["upload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if (isset($_POST["sub"])) {
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
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["upload"]["size"] > 500000) {
            $message = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
            $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $message1 = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
                $message = "The file " . basename($_FILES["upload"]["name"]) . " has been uploaded.";
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        }

        $this->set(['type' => $type, 'message' => $message, 'message1' => $message1]);
    }

    public function upload() {
        
    }

    private function getAll() {
        return $this->getTableObj()->getAllImages();
    }

    public function prepareInsertStatement() {
        $allImages = $this->getAll();
         if(!$allImages){
                return NOT_FOUND;
            }
        $preparedStatements = '';
        foreach ($allImages as $image) {
            $preparedStatements .= IMG_INS_QRY;
            $preparedStatements = str_replace('@ImageId', $image->ImageId, $preparedStatements);
            $preparedStatements = str_replace('@ImagePath', $image->ImagePath, $preparedStatements);
            $preparedStatements = str_replace('@UserId', $image->UserId, $preparedStatements);
            $preparedStatements = str_replace('@DestId', $image->DestId, $preparedStatements);
            $preparedStatements  = str_replace('@ImageSeen', $image->ImageSeen, $preparedStatements);
        }
        \Cake\Log\Log::info('insert statements for image Sqlite table created successfully ');
        return $preparedStatements;
    }

}