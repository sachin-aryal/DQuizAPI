<?php

/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/18/17
 * Time: 3:51 PM
 */
class ApiFunction
{
    public function register(){
        $restResult = new RestResult();
        $errorMessage = "";
        if(!isset($_POST["userId"])){
            $errorMessage = "userId is required parameter.";
            return $restResult->getMessage(false,$errorMessage);
        }
        if(!isset($_POST["name"])){
            $errorMessage = "name is required parameter.";
            return $restResult->getMessage(false,$errorMessage);
        }
        if(!isset($_POST["loginType"])){
            $errorMessage = "loginType is required parameter.";
            return $restResult->getMessage(false,$errorMessage);
        }

    }
}