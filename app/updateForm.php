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
    else if ($formType == "contents"){

        $id = $_POST["cId"];
        $topic_id = $_POST["topic_id"];
        $content_id = $_POST["content_id"];
        $slide_no = $_POST["slide_no"];
        $content_type = $_POST["content_type"];
        $content_desc = $_POST["content_desc"];

        $row = array($id,$content_id,$topic_id,$slide_no,$content_type,$content_desc);
        $excelDatabase = new ExcelDatabase($formType,null);
        $doNoUpdate = "id";
        $result = $excelDatabase->update($doNoUpdate,$row);
        displayMessage($result);
    }else if ($formType == "answers"){

        $answer_id = $_POST["answer_id"];
        $question_id = $_POST["question_id"];
        $answer_val = $_POST["answer_val"];
        echo $_POST["is_correct"];
        $is_correct = $_POST["is_correct"] == "on"?1:0;

        $row = array($answer_id,$question_id,$answer_val,$is_correct);
        $excelDatabase = new ExcelDatabase($formType,null);
        $doNoUpdate = "answer_id";
        $result = $excelDatabase->update($doNoUpdate,$row);
        displayMessage($result);
    }else{
        echo "<p style='color: red'>Unknown form type received.</p>";
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