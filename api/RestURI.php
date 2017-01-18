<?php

/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/18/17
 * Time: 3:34 PM
 */
class RestURI
{
    public static $URI = array(
        "REGISTER" => 'GET',
        "LOGIN" => 'GET');


    private static $apiMethod = array(
      "REGISTER" => "register",
      "LOGIN" => "login"
    );


    public static function getRequiredMethod($actionName){
        return RestURI::$URI[$actionName];
    }

    public static function getApiMethod($actionName){
        return RestURI::$apiMethod[$actionName];
    }

}