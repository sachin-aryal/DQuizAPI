<?php

/** Set default timezone (will throw a notice otherwise) */
date_default_timezone_set('Asia/Kathmandu');
require('../PHPExcel.php');
require('../SampleMapping.php');

$objPHPExcel = new PHPExcel;
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
$objPHPExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
$numberFormat = '#,#0.##;[Red]-#,#0.##';

$objHeaderSheet = $objPHPExcel->getActiveSheet();
$objValueWriter = $objPHPExcel->getActiveSheet();
$objHeaderSheet->getStyle()->getFont()->setBold(true)->setSize(12);
$objValueWriter->getStyle()->getFont()->setBold(false)->setSize(10);

$title = "";
if(isset($_GET["w"])){
    $title = $_GET["w"];
    $data = SampleMapping::getSampleData($title);
    if($data == ""){
        header("Location:../index.php");
    }
    $objHeaderSheet->setTitle($title);
    $colIndex = 0;
    foreach ($data as $key=>$val){
        $rowIndex = 1;
        $objHeaderSheet->getCellByColumnAndRow($colIndex,$rowIndex++)->setValue($key);
        foreach ($val as $sampleData) {
            $objValueWriter->getCellByColumnAndRow($colIndex,$rowIndex++)->setValue($sampleData);
        }
        $objValueWriter->getColumnDimensionByColumn($colIndex)->setAutoSize(true);
        $colIndex++;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$title.'".xlsx');
    header('Cache-Control: max-age=0');
    $objWriter->save('php://output');

}else{
    header("Location:../index.php");
}

?>
