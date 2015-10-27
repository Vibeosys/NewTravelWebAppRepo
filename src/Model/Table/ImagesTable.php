<?php

namespace App\Model\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use App\DTO;
use Cake\Log\Log;


/**
 * Description of ImageTable
 *
 * @author niteen
 */
class ImagesTable extends Table {

    public function connect() {
        return TableRegistry::get('images');
    }

    public function insertImage($imageid,$userid, $destid, $path) {
        try{
            $image = $this->connect();
        $query = $image->newEntity();
        $query->ImageId = $imageid;
        $query->ImagePath = $path;
        $query->CreatedDate = date('Y-m-d H:i:s');
        $query->UserId = $userid;
        $query->DestId = $destid;
        $query->Visibility  = 1;
        if($image->save($query)){
            \Cake\Log\Log::debug("image saved in database : ".$path);
            return SUCCESS;
        }
        Log::error("image not saved in database ".$path);
        return FAIL;
        }  catch (Exception $e){
            throw  new \PDOException("database error");
        }
    }

    public function getAllImages() {
        if (!$this->connect()->find()->count()) {
            return NOT_FOUND;
        }
        $rows = $this->connect()->find();
        $i = 0;
        $allImages = NULL;
        foreach ($rows as $row) {
            if ($row->Visibility) {
                $imageDto = new DTO\ClsImagesDto($row->ImageId,$row->ImagePath, $row->UserId, $row->DestId);
                $allImages[$i] = $imageDto;
                $i++;
            }
        }
        return $allImages;
    }

}
