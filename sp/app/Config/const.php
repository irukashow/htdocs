<?php
//ユーザ定義定数
//呼び出し方:    echo HEADER;
define("HEADER","スタッフ専用サイト");
define("FOOTER","Version 0.0.6 20150610 Copyright (C) 2015 SOFTLIFE Co., Ltd.");
define("ROOTDIR","/sp");
 
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

