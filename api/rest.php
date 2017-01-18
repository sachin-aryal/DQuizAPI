<?php
/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/18/17
 * Time: 3:18 PM
 */

require_once 'Database.php';
require_once 'RestURI.php';
require_once 'RestResult.php';
require_once 'ApiFunction.php';


$database = new Database;
$restResult = new RestResult;
$method = $_SERVER["REQUEST_METHOD"];
$actionName = "";

switch ($method){
    case "GET":
        $actionName = isset($_GET["actionName"])?$_GET["actionName"]:"";
        break;
    case "POST":
        $actionName = isset($_POST["actionName"])?$_POST["actionName"]:"";
        break;
    default:
        $actionName = "";
        break;
}

if($actionName == ""){
    echo $restResult->getMessage(false,"Required parameter actionName not found.");
    return;
}
$actionName = strtoupper($actionName);
$requiredMethod = RestURI::getRequiredMethod($actionName);

if($requiredMethod != $method){

    echo $restResult->getMessage(false,"The requested method is not allowed");
    return;
}
else{

    $apiFunction = new ApiFunction;
    switch ($actionName){
        case "REGISTER":
            $functionName = RestURI::getApiMethod($actionName);
            $fResult = call_user_func(array($apiFunction,$functionName));
            echo $fResult;
            break;
        default:
            break;
    }
}