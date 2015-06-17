<?php
    //ファイル名
    $fname = $_GET["file"];
    //パス
    $fpath = './message/staff/'.sprintf("%010d", $_GET["id"]).'/'.$fname;

    header('Content-Type: application/force-download');
    header('Content-Length: '.filesize($fpath));
    header('Content-disposition: attachment; filename="'.$fname.'"');
    readfile($fpath);
?>