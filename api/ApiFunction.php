<?php

/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/18/17
 * Time: 3:51 PM
 */
require "../common/Database.php";
require "../app/uploader/ExcelDatabase.php";

class ApiFunction
{
    public function register(){
        $restResult = new RestResult();
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
        $userId = $_POST["userId"];
        $userName = $_POST["name"];
        $login_type = $_POST["loginType"];

        $database = new Database();
        $userExist = $this->userExist($database,$userId);
        if($userExist["exist"]){
            $minTopicId = $userExist["topicId"];
        }else{
            $minTopicId = $this->getMinTopicId($database);
            $minSlideNo = $this->getMinSlideNo($database,$minTopicId);
            $row = array($userId,$userName,$login_type,$minTopicId,$minSlideNo);
            $data = array($row);
            $insertResult = $database->insert(ExcelDatabase::$userTableInfo,$data);
            if(!$insertResult["success"]){
                return $insertResult;
            }
        }

        $topicList = $this->fetchNeighbourTopics($database,$minTopicId);
        $data = array("success"=>true);
        foreach ($topicList as $topicId){
            $topics = $this->fetchTopics($database,$topicId);
            $contents = $this->fetchTopicsContent($database,$topicId);
            $questions  = $this->fetchQuestions($database,$topicId);
            $answers = array();
            foreach($questions as $question){
                $question_id = $question['question_id'];
                $answers[$question_id] = $this->fetchAnswers($database,$question_id);
            }
            $topicContents = array(
                "topics"=>$topics,
                "contents"=>$contents,
                "questions"=>$questions,
                "answers"=>$answers
            );
            array_push($data, array($topicId =>$topicContents));
        }
        return $data;
    }

    public function fetchTopics($database,$topicId){
        $topicQuery = "SELECT *FROM topics where topic_id = ".$topicId;
        $res = $database->selectQuery($topicQuery);
        $results = array();
        foreach($res as $r){
            array_push($results, $r);
        }
        return $results;
    }

    public function fetchAnswers($database,$question_id){
        $answerQuery = "select *from answers where question_id = ".$question_id;
        $res = $database->selectQuery($answerQuery);
        $results = array();
        foreach($res as $r){
            array_push($results, $r);
        }
        return $results;
    }

    public function fetchNeighbourTopics($database,$topicId){
        $prevTopicQuery = "select topic_id from topics where topic_id < ".$topicId." ORDER BY  topic_id ASC LIMIT 1";
        $nextTopicQuery = "select topic_id from topics where topic_id > ".$topicId." ORDER BY  topic_id ASC LIMIT 1";
        $topicList = array();
        $prevResult = $database->selectQuery($prevTopicQuery);
        if($prevResult->num_rows > 0){
            array_push($topicList,mysqli_fetch_assoc($prevResult)["topic_id"]);
        }
        array_push($topicList,$topicId);
        $nextResult = $database->selectQuery($nextTopicQuery);
        if($nextResult->num_rows > 0){
            array_push($topicList,mysqli_fetch_assoc($nextResult)["topic_id"]);
        }
        return $topicList;
    }

    public function fetchTopicsContent($database,$topicId){
        $contentQuery = "SELECT *FROM contents where topic_id=".$topicId;
        $res = $database->selectQuery($contentQuery);
        $results = array();
        foreach($res as $r){
            array_push($results, $r);
        }
        return $results;
    }

    public function fetchQuestions($database,$topicId){
        $questionQuery = "SELECT *FROM questions where topic_id = ".$topicId;
        $res = $database->selectQuery($questionQuery);
        $results = array();
        foreach($res as $r){
            array_push($results, $r);
        }
        return $results;
    }

    public function getMinTopicId($database){
        return mysqli_fetch_assoc($database->selectQuery("SELECT MIN(topic_id) as minTopic FROM topics;"))["minTopic"];
    }

    public function getMinSlideNo($database,$topicId){
        return mysqli_fetch_assoc($database->selectQuery("SELECT MIN( slide_no ) as minSlide FROM contents WHERE topic_id = ".$topicId))["minSlide"];
    }

    public function userExist($database,$userId){
        $userQuery = "SELECT topic_id FROM user where user_id=".$userId;
        $result = $database->selectQuery($userQuery);
        if($result->num_rows >0 ){
            $row = mysqli_fetch_assoc($result);
            return array("exist"=>true,"topicId"=>$row["topic_id"]);
        }else{
            return array("success"=>false);
        }
    }
}