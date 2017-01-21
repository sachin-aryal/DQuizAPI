<?php
/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/21/17
 * Time: 4:54 PM
 */

require 'uploader/ExcelDatabase.php';

if(isset($_POST["formType"])){
    $formType = $_POST["formType"];

    if($formType == "questions"){
        $question_id = $_POST["question_id"];
        $topic_id = $_POST["topic_id"];
        $question_val = $_POST["question_val"];
        $question_augment = $_POST["question_augment"];
        $hint = $_POST["hint"];
        $difficulty = $_POST["difficulty"];
        $row = array($topic_id,$question_id,$question_val,$question_augment,$hint,$difficulty);
        $excelDatabase = new ExcelDatabase($formType,null);
        $doNoUpdate = "question_id";
        $result = $excelDatabase->update($doNoUpdate,$row);
        displayMessage($result);
    }else if ($formType == "topics"){

        $topic_id = $_POST["topic_id"];
        $topic_val = $_POST["topic_val"];
        $super_topic_val = $_POST["super_topic_val"];
        $description = $_POST["description"];

        $row = array($topic_id,$topic_val,$super_topic_val,$description);
        $excelDatabase = new ExcelDatabase($formType,null);
        $doNoUpdate = "topic_id";
        $result = $excelDatabase->update($doNoUpdate,$row);
        displayMessage($result);
    }


}else{
    echo "<p style='color: red'>Unknown form type received.</p>";
}

function displayMessage($result){
    if($result["success"]){
        echo '<p>'.$result['message'].'</p>';
    }else{
        echo '<p style="color:red;">'.$result['message'].'</p>';
    }
}