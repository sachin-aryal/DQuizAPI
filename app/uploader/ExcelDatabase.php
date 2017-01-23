<?php

/**
 * Created by PhpStorm.
 * User: iam
 * Date: 1/20/17
 * Time: 9:12 AM
 */

class ExcelDatabase
{
    private $fileType = "";
    private $objPHPExcel;

    public static $topicTableInfo = array(
        "topics"=>array("topic_id"=>"i","topic_val"=>"s","super_topic_val"=>"s","description"=>"s")
    );
    public static $contentTableInfo = array(
        "contents"=>array("content_id"=>"i","topic_id"=>"i","slide_no"=>"i", "content_type"=>"s","content_desc"=>"s")
    );
    public static $questionTableInfo = array(
        "questions"=>array("topic_id"=>"i","question_id"=>"i","question_val"=>"s","question_augment"=>"s","hint"=>"s",
            "difficulty"=>"s")
    );
    public static $answerTableInfo = array(
        "answers"=>array("question_id"=>"i","answer_val"=>"s","is_correct"=>"i")
    );

    public static $userTableInfo = array(
        "user"=>array("user_id"=>"s","user_name"=>"s","login_type"=>"s","topic_id"=>"i","slide_no"=>"i")
    );


    function __construct($fileType,$objPHPExcel)
    {
        $this->fileType = $fileType;
        $this->objPHPExcel = $objPHPExcel;
    }

    public function addToDatabase($tableInfo){
        require '../../common/Database.php';
        $sheet = $this->objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $data = array();
        $mainIndex = 0;
        for ($row = 2; $row <= $highestRow; $row++) {
            $eachRow = array();
            $i = 0;
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                NULL, TRUE, FALSE);
            foreach($rowData[0] as $k=>$v){
                if(!is_null($v))
                    $eachRow[$i++] = $v;
            }
            $data[$mainIndex++] = $eachRow;
        }

        if(sizeof($data[0]) < 3){
            return array("success"=>false,"message"=>"Incomplete Data Received.");
        }
        $database = new Database();
        return $database->insert($tableInfo,$data);
    }

    public function saveTopic(){
        return $this->addToDatabase(ExcelDatabase::$topicTableInfo);
    }

    public function saveQuestion(){
        return $this->addToDatabase(ExcelDatabase::$questionTableInfo);
    }

    public function saveAnswer(){
        return $this->addToDatabase(ExcelDatabase::$answerTableInfo);
    }

    public function saveContent(){
        return $this->addToDatabase(ExcelDatabase::$contentTableInfo);
    }

    public function update($doNoUpdate,$row){
        require '../common/Database.php';
        $database = new Database();
        switch ($this->fileType){
            case "questions":
                return $database->update(ExcelDatabase::$questionTableInfo,$row,$doNoUpdate);
                break;
            case "topics":
                return $database->update(ExcelDatabase::$topicTableInfo,$row,$doNoUpdate);
                break;
            case "answers":
                return $database->update(ExcelDatabase::$answerTableInfo,$row,$doNoUpdate);
                break;
            case "contents":
                return $database->update(ExcelDatabase::$contentTableInfo,$row,$doNoUpdate);
                break;
        }
    }

}