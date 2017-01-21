<?php

/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/18/17
 * Time: 3:15 PM
 */
require "config.php";
class Database
{

    public function selectQuery($sql,$params = array()){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
        try{
            if(sizeof($params) == 0){
                $res = $conn->query($sql);
                return $res;
            }
        }catch (Exception $ex){}
        finally{
            $conn->close();
        }
        $conn->close();
    }

    public function insert($tableInfo,$data){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
        if($conn == false){}

        $queryParam = $this->mainInsetQuery($tableInfo);
        $sql = $queryParam[0];
        $dataTypes = $queryParam[1];
        $dataQuery = $this->valueInsertQuery($data,$dataTypes);
        $completeQuery = $sql.$dataQuery;
        try{
            if(!mysqli_query($conn,$completeQuery)){
                $message = array("success"=>false,"message"=>mysqli_error($conn));
            }else{
                $message = array("success"=>true,"message"=>"Data Inserted Successfully.");
            }
        }catch (Exception $ex){
            $message = array("success"=>false,"message"=>$ex->getMessage());
        }
        finally{
            $conn->close();
        }
        return $message;
    }

    private function mainInsetQuery($tableInfo){
        reset($tableInfo);
        $tableName = key($tableInfo);
        $sql = "INSERT INTO ".$tableName." (";

        $colIndex = 0;
        $dataTypes=array();
        foreach ($tableInfo[$tableName] as $colName=>$dataType){
            $sql.=$colName.",";
            $dataTypes[$colIndex] = $dataType;
            $colIndex++;
        }
        $sql = rtrim($sql, ',');
        $sql.=") VALUES ";
        return array($sql,$dataTypes);
    }

    private function valueInsertQuery($data,$dataTypes){
        $valueSize = sizeof($data[0]);
        $queryIndex = 0;
        $dataQuery ="";
        foreach ($data as $key=>$val){
            $dataQuery.= "(";
            for($i=0;$i<$valueSize;$i++){
                if($i!=0)
                    $dataQuery.=",";
                switch ($dataTypes[$i]){
                    case "i":
                        $dataQuery.=$val[$i];
                        break;
                    case "s":
                        $dataQuery.="'$val[$i]'";
                        break;
                    case "d":
                        $dataQuery.=$val[$i];
                        break;
                }
            }
            $dataQuery.="),";
            $queryIndex++;
        }
        $dataQuery = rtrim($dataQuery, ',');
        return $dataQuery;
    }

    public function update($tableInfo,$data,$doNotUpdate){
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
        $updateQuery = $this->getUpdateQuery($tableInfo,$data,$doNotUpdate);
        try{
            if(!mysqli_query($conn,$updateQuery)){
                $message = array("success"=>false,"message"=>mysqli_error($conn));
            }else{
                $message = array("success"=>true,"message"=>"Data Updated Successfully.");
            }
        }catch (Exception $ex){
            $message = array("success"=>false,"message"=>$ex->getMessage());
        }
        finally{
            $conn->close();
        }
        return $message;
    }

    private function getUpdateQuery($tableInfo,$data,$doNotUpdate){
        reset($tableInfo);
        $tableName = key($tableInfo);
        $sql = "UPDATE ".$tableName." SET ";
        $colIndex = 0;
        foreach ($tableInfo[$tableName] as $colName=>$dataType){
            if($colName == $doNotUpdate){
                $whereValue = $data[$colIndex];
            }else{
                $sql.= $colName."=";
                switch ($dataType){
                    case "i":
                        $sql.=$data[$colIndex];
                        break;
                    case "s":
                        $sql.="'$data[$colIndex]'";
                        break;
                    case "d":
                        $sql.=$data[$colIndex];
                        break;
                }
                $sql.=",";
            }
            $colIndex++;
        }
        $sql = rtrim($sql,",")." ";
        $sql.=" WHERE ".$doNotUpdate." = ".$whereValue;
        return $sql;
    }

}