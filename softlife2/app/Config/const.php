<?php
//ユーザ定義定数
//呼び出し方:    echo HEADER;
define("HEADER","派遣管理システム <font color=#ffff99>SLNext 0.1.8</font>");
define("FOOTER","SLNext Version 0.1.8 20150914 Copyright &copy; 2015 softlife co., ltd.");
define("ROOTDIR","/softlife2");
define("MEMBER_URL","http://softlife.biz");
define("STAFF_URL","http://staff.softlife.biz");
 
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

