<?php
namespace App\Model\Table;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageTable
 *
 * @author niteen
 */
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
class ImagesTable extends Table{
    
    public function connect() {
        return TableRegistry::get('images');
    }
    public function insertImage($userid,$destid,$path) {
        $query =$this->newEntity();
        $query->ImagePath = $path;
        $query->CreatedDate = date('Y-M-d H:i:sa');
        $query->UserId = $userid;
        $query->DestinationId = $destid;
        $this->save($query);
    }
    public function getAllImages() {
        
    }
}
