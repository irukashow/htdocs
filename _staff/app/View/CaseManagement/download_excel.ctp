<?php
// Excel出力用ライブラリ
App::import( 'Vendor', 'PHPExcel', array('file'=>'phpexcel' . DS . 'PHPExcel.php') );
App::import( 'Vendor', 'PHPExcel_IOFactory', array('file'=>'phpexcel' . DS . 'PHPExcel' . DS . 'IOFactory.php') );
App::import( 'Vendor', 'PHPExcel_Cell_AdvancedValueBinder', array('file'=>'phpexcel' . DS . 'PHPExcel' . DS . 'Cell' . DS . 'AdvancedValueBinder.php') );
// Excel95用ライブラリ
App::import( 'Vendor', 'PHPExcel_Writer_Excel5', array('file'=>'phpexcel' . DS . 'PHPExcel' . DS . 'Writer' . DS . 'Excel5.php') );
App::import( 'Vendor', 'PHPExcel_Reader_Excel5', array('file'=>'phpexcel' . DS . 'PHPExcel' . DS . 'Reader' . DS . 'Excel5.php') );
 
// ファイルはxls形式を使用
// テンプレートファイルの読み込み
$tmp_excel_path = realpath(TMP) . DS . 'excel' . DS;
 
$objReader = PHPExcel_IOFactory::createReader("Excel5");
 
$template_path = $tmp_excel_path .  "sample.xls";
$PHPExcel = $objReader->load($template_path);

//シートの設定
$PHPExcel->setActiveSheetIndex(0);  //0はsheet1(一番左のシート)
$sheet = $PHPExcel->getActiveSheet();

// Controllerで取得したUserデータを書き出し
$sheet->setCellValue( 'A1', '氏名：');
$sheet->setCellValue( 'B1', $data['User']['name_sei'].' '.$data['User']['name_mei']);
$sheet->setCellValue( 'A2', '権限：');
$sheet->setCellValue( 'B2', $data['User']['auth']);
 
//保存ファイル名
$filename = 'ユーザー情報_'.date('YmdHis').'.xls';
 
//文字コード変換
$filename = mb_convert_encoding($filename, 'sjis', 'utf-8');
// 保存ファイルパス
$path = $tmp_excel_path . DS . $filename;
 
$objWriter = new PHPExcel_Writer_Excel5( $PHPExcel );   //2003形式で保存
$objWriter->save( $path );

// Excelファイルをクライアントに出力 ----------------------------
//保存をしてから出力
Configure::write('debug', 0);       // debugコードを非表示
header("Content-disposition: attachment; filename={$filename}");    //ダウンロードさせるため
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name={$filename}");
 
$result = file_get_contents( $path );   // ダウンロードするデータの取得
print( $result );           // 出力

