<?php

/** Set default timezone (will throw a notice otherwise) */
date_default_timezone_set('Asia/Kathmandu');

include '../PHPExcel/IOFactory.php';
require '../SampleMapping.php';
require 'ExcelDatabase.php';

if(isset($_POST["fileType"])){

    $fileType = $_POST["fileType"];

    $functionName = SampleMapping::getSaveFunction($fileType);
    if($functionName == ""){
        echo "Unknown file type detected.";
    }else{
        if(isset($_FILES['file']['name'])){

            $file_name = $_FILES['file']['name'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            if($ext == "xlsx"){

                $file_name = $_FILES['file']['tmp_name'];
                $inputFileName = $file_name;

                //  Read your Excel workbook
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $excelToDatabase = new ExcelDatabase($fileType,$objPHPExcel);
                    $result = call_user_func(array($excelToDatabase,$functionName));
                    if($result["success"]){
                        echo '<p>'.$result['message'].'</p>';
                    }else{
                        echo '<p style="color:red;">'.$result['message'].'</p>';
                    }
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
                }

            }

            else{
                echo '<p style="color:red;">Please upload file with xlsx extension only</p>';
            }
        }
        else{
            echo '<p style="color:red;">Please upload file.</p>';
        }
    }

}else{
    echo '<p style="color:red;">Server knows that you changed the value with inspect element.( Your IP is recorded.)</p>';
}
?>