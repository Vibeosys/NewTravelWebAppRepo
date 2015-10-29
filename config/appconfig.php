<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of appconfig
 *
 * @author anand
 */
class appconfig {

   /**
     * @var array production values default
     */
    private static $awsLocalDefaults = [
        'profile' => 'default',
        'region' => 'ap-southeast-1',
        'version' => '2006-03-01',
        'scheme' => 'http'
    ];

    /**
     * @var array production values default
     */
    private static $awsProductionDefaults = [
        'profile' => 'production',
        'region' => 'ap-southeast-1',
        'version' => '2006-03-01',
        'scheme' => 'http'
    ];
    
    private static $adminCredential = [
        'username' => 'Admin',
        'password' => 'Admin123'
    ];

    /**
     * 
     * @param local $local  if true will load the default array of arguments
     * @return array            if the local is true will return the arguments as per the switch
     */
    public static function getAwsDefaults($local = false)
    {
        if ($local) {
            return static::$awsLocalDefaults;
        }
        return static::$awsProductionDefaults;
    }
    
    /**
     * 
     * @param local $local  if true will load the default array of arguments
     * @return array            if the local is true will return the arguments as per the switch
     */
    public static function getAwsDefaultBucket($local = false)
    {
        if ($local) {
            return "dev.vibeosys.com";
        }
        return "imagedata";
    }
    
    public static function getAdminCredential() {
        return static::$adminCredential;
    }
    
}
