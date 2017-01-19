<?php

/** Set default timezone (will throw a notice otherwise) */
date_default_timezone_set('Asia/Kathmandu');
require('../PHPExcel.php');
require('SampleMapping.php');

$objPHPExcel = new PHPExcel;
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
$numberFormat = '#,#0.##;[Red]-#,#0.##';

$objSheet = $objPHPExcel->getActiveSheet();


$title = "";
if(isset($_GET["w"])){
    $title = $_GET["w"];
    $data = SampleMapping::getSampleData($title);
    if($data == ""){
        header("Location:../index.php");
    }
    $objSheet->setTitle($title);
    $colIndex = 0;
    foreach ($data as $key=>$val){
        $rowIndex = 1;
        $objSheet->getCellByColumnAndRow($colIndex,$rowIndex++)->setValue($key)->getStyle()->getFont()->setBold(true)->setSize(12);
        foreach ($val as $sampleData) {
            $objSheet->getCellByColumnAndRow($colIndex,$rowIndex++)->setValue($sampleData)->getStyle()->getFont()->setBold(false)->setSize(10);
            $objSheet->getCellByColumnAndRow($colIndex,$rowIndex++)->getStyle()->getAlignment()->setWrapText(true);
        }
        $colIndex++;
    }

    /*$objSheet->getColumnDimension('A')->setAutoSize(true);
    $objSheet->getColumnDimension('B')->setAutoSize(true);
    $objSheet->getColumnDimension('C')->setAutoSize(true);
    $objSheet->getColumnDimension('D')->setAutoSize(true);*/


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="file.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter->save('php://output');

}else{
    header("Location:../index.php");
}

?>
