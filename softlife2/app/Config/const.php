<?php
//ユーザ定義定数
//呼び出し方:    echo HEADER;
define("HEADER","派遣管理システム SLUP");
define("FOOTER","SLUP Version 0.0.2 20150526 Copyright (C) 2015 SOFTLIFE Co., Ltd.");
 
//配列
//呼び出し方:    $fuga = Configure::read("fuga");
$config['fuga'] = array("a","b","c");
 
//連想配列
//呼び出し方:    $hoge = Configure::read("hoge");
$config['hoge'] = array(
  "A"=>"あ",
  "B"=>"い",
  "C"=>"う",
);

