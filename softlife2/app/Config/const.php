<?php
//ユーザ定義定数
//呼び出し方:    echo HEADER;
define("HEADER","派遣管理システム <font color=#ffff99>SLNext 0.1.1</font>");
define("FOOTER","SLNext Version 0.1.1 20150629 Copyright (C) 2015 SOFTLIFE Co., Ltd.");
define("ROOTDIR","/softlife2");
 
//配列
//呼び出し方:    $fuga = Configure::read("fuga");
$config['fuga'] = array("a","b","c");
 
//連想配列
//呼び出し方:    $list_shokushu = Configure::read("shokushu");
$config['shokushu'] = array(
  "1"=>"内覧会受付",
  "2"=>"受付",
  "3"=>"内覧会スタッフ",
  "4"=>"ナレーター",
  "5"=>"MC",
  "6"=>"説明",
  "7"=>"事務",
  "8"=>"誘導案内",
  "9"=>"保育",
  "10"=>"イベント",
  "11"=>"DH",
  "12"=>"看板持ち",
);

