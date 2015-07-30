<?php
//パス
$fpath = STAFF_URL.'/files/message/member/'.sprintf("%07d", $username).'/'.$filename;
//ファイル名
//$fname = '画像名.jpg';

header('Content-Type: application/force-download');
header('Content-Length: '.filesize($fpath));
header('Content-disposition: attachment; filename="'.$filename.'"');
readfile($fpath);