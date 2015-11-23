<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClsNetworkDeviceInfoDto
 *
 * @author niteen
 */
class ClsNetworkDeviceInfoDto extends JsonDeserializer{
    public $userId;
    public $brand;
    public $board;
    public $manufacturer;
    public $model;
    public $product;
    public $fmVersion;
    public $ip;
    public $city;
    public $region;
    public $country;
}
