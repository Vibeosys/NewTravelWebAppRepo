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

/**
 * Description of ImageTable
 *
 * @author niteen
 */
class ImagesTable extends Table {

    public function connect() {
        return TableRegistry::get('images');
    }

    public function insertImage($userid, $destid, $path) {
        $query = $this->newEntity();
        $query->ImagePath = $path;
        $query->CreatedDate = date('Y-M-d H:i:sa');
        $query->UserId = $userid;
        $query->DestId = $destid;
        if($this->save($query)){
            return SUCCESS;
        }
        return FAIL;
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
