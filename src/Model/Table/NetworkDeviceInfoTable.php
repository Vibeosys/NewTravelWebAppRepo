<?php
namespace App\Model\Table;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use App\DTO;

/**
 * Description of NetworkDeviceInfoTable
 *
 * @author niteen
 */
class NetworkDeviceInfoTable extends Table{
    public function connect() {
        return TableRegistry::get('network_device_info');
    }
    
    public function saveNetworkDeviceInfo(DTO\ClsNetworkDeviceInfoDto $infoDto) {
        
        if($infoDto and !$this->isPresent($infoDto->userId)){
            $entity = $this->connect()->newEntity();
            $entity->UserId = $infoDto->userId;
            $entity->Board = $infoDto->board;
            $entity->Brand = $infoDto->brand;
            $entity->Manufacturer = $infoDto->manufacturer;
            $entity->Model = $infoDto->model;
            $entity->Product = $infoDto->product;
            $entity->FmVersion = $infoDto->fmVersion;
            $entity->IpAddress = $infoDto->ip;
            $entity->City = $infoDto->city;
            $entity->Region = $infoDto->region;
            $entity->Country = $infoDto->country;
            if($this->connect()->save($entity)){
                \Cake\Log\Log::debug("User Network Device Info save in database for userid : ".$infoDto->userId);
                return SUCCESS;
            }
            
            \Cake\Log\Log::error("User Network Device Info not save in database for userid : ".$infoDto->userId);
            return FAIL;
        }
        \Cake\Log\Log::error(" userid : ".$infoDto->userId . " record exist in database");
        return FAIL;
    }
    
    private function isPresent($userId) {
        return $this->connect()->find()->where(['UserId =' => $userId])->count();
    }
}
