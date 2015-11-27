<?php
namespace App\DTO;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AjaxDeserializer
 *
 * @author niteen
 */
abstract class AjaxDeserializer {

    public static function ajaxDeserialize($data) {
        if ($data) {
            $className = get_called_class();
            $classInstance = new $className();
            $rows = explode('&', $data);
            foreach ($rows as $row) {
                $row = explode('=', $row);
                if (!property_exists($classInstance, $row[0])) {
                    continue;
                }
                $classInstance->{$row[0]} = $row[1];
            }
            return $classInstance;
        } else {
            return NOT_FOUND;
        }
    }

}
