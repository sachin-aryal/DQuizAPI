<?php

/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/18/17
 * Time: 3:46 PM
 */
class RestResult
{

    public function formatResults($res){
        $results = array("success"=>true);
        foreach($res as $r){
            array_push($results, $r);
        }
        return json_encode($results);
    }

    public function getMessage($success,$errorMessage){
        return json_encode(array("success"=>$success,"message"=>$errorMessage));
    }

    public function getMethodNotFound(){
        return json_encode(array("success"=>false,"message"=>"No mapping found for this api call."));
    }

}