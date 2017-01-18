<?php

/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/18/17
 * Time: 3:15 PM
 */
class Database
{

    public function selectQuery($sql,$params){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
        $res = $conn->query($sql);
        $conn->close();
        return $res;
    }



}