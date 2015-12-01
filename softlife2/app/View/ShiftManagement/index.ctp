<?php
    echo $this->Html->css('staffmaster');
?>
<?php require('holiday.ctp'); ?>
<?php
	// 初期値
    $y = date('Y', strtotime('+1 month'));
    $m = date('n', strtotime('+1 month'));
		
    // 日付の指定がある場合
    if(!empty($_GET['date'])){
        $arr_date = explode('-', $_GET['date']);

        if(count($arr_date) == 2 and is_numeric($arr_date[0]) and is_numeric($arr_date[1]))
        {
                $y = (int)$arr_date[0];
                $m = (int)$arr_date[1];
        }
    } elseif (!empty($month)) {
        $y = substr($month, 0, 4);
        $m = substr($month, 4, 2);
        $m = ltrim($m, '0');
    }
    // 祝日取得
    $national_holiday = japan_holiday($y);
?>
<?php
// 職種を表示する
function setShokushu($id, $shokushu_arr, $list_shokushu) {
    if (strstr($id, 'u')) {
        return '受付';
    } else {
        $shokushu_ids = explode(',', $shokushu_arr[$id]);
        $ret = '';
        foreach ($shokushu_ids as $shokushu_id) {
            if (empty($shokushu_id)) {
                continue;
            }
            if (empty($ret)) {
                $ret = trim(mb_convert_kana($list_shokushu[$shokushu_id], 's'));
            } else {
                $ret = $ret.', '.trim(mb_convert_kana($list_shokushu[$shokushu_id], 's'));
            }
        }
        return $ret;
    }
}
// IDを表示関数
function setID($id) {
    if (strstr($id, 'u')) {
        return '社員';
    } else {
        return $id; 
    }
}
// スタッフか社員かで氏名を取得する関数
function setName($id, $staff_arr, $user_arr) {
    if (strstr($id, 'u')) {
        return $user_arr[ltrim($id, 'u')];
    } else {
        return $staff_arr[$id]; 
    }
}
?>
<style>
#loading{
    position:absolute;
    left:50%;
    top:60%;
    margin-left:-30px;
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script type="text/javascript">
  <!--
//コンテンツの非表示
$(function(){
    $('#staff_master').css('display', 'none');
});
//ページの読み込み完了後に実行
window.onload = function(){
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        $("#staff_master").fadeIn();
    });
}
  //-->
</script>

<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ シフト管理
    &nbsp;&nbsp;
    <b><font Style="font-size:95%;color: yellow;">[スタッフシフト希望]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" class="load"><font Style="font-size:95%;">シフト作成</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/schedule3?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" class="load"><font Style="font-size:95%;">確定シフト</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/setting"><font Style="font-size:95%;">詳細設定</font></a>
    &nbsp;

</div>
<!-- 見出し１ END -->

<!-- 月の指定 -->
<?php echo $this->Form->create('StaffSchedule', array('name' => 'form')); ?>
<?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'display: none;')); ?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td><a href="<?=ROOTDIR ?>/ShiftManagement/index?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                <td style='background-color: #006699;color: white;cursor: pointer;'>
                    <a style='font-size: 110%;color:white;' onclick="location.href = '<?=ROOTDIR ?>/ShiftManagement/index?date=<?=$y?>-<?=sprintf("%02d", $m)?>';">
                        【<?php echo $y ?>年<?php echo $m ?>月】
                    </a>
                </td>
                <td><a href="<?=ROOTDIR ?>/ShiftManagement/index?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
        </tr>
</table>
<!-- ページネーション -->
<div class="pageNav03" style="margin-top:5px; margin-bottom: 0px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
    &nbsp;&nbsp;
    <span style="padding-top: 0px;border-style: none;">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/ShiftManagement/input_schedule?date=<?=$date2 ?>','シフト希望','width=1200,height=800,scrollbars=yes');" id='button-create'>スタッフシフト</a>
    </span>
    <span style="padding-top: 0px;border-style: none;">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/ShiftManagement/input_schedule2?date=<?=$date2 ?>','シフト希望','width=1200,height=800,scrollbars=yes');" id='button-create'>社員シフト</a>
    </span>
    <div style="float:right;margin-top: 5px;">
        <?php echo $this->Paginator->counter(array('format' => __('合計  <b>{:count}</b> 名')));?>
        &nbsp;&nbsp;&nbsp;
        表示数：
        <?php
            $list = array('5'=>'5','10'=>'10','20'=>'20','50'=>'50','100'=>'100');
            echo $this->Form->input('limit', array('name' => 'limit', 'type' => 'select','label' => false,'div' => false, 'options' => $list, 'selected' => $limit,
                'onchange' => 'form.submit();'));
        ?>
    </div>
 </div>
<div style="clear:both;"></div>
<!-- シフト希望表本体 -->
<div style="width:100%;overflow-x:scroll;">
<table border='1' cellspacing="0" cellpadding="3" 
       style="margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;background-color: white;table-layout: fixed;">
    <tr style="background-color: #cccccc;">
        <td align="center" colspan="4">スタッフ</td>
<?php
    // 1日の曜日を取得
    $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
    $week = array("日", "月", "火", "水", "木", "金", "土");
    $d = 1;
    while (checkdate($m, $d, $y)) {
        $wd2 = date("w", mktime(0, 0, 0, $m, $d, $y));
        echo '<td align="center" style="width:10px;">'.$week[$wd2].'</td>';
        $d++;
    }
?>
        <td align="center" rowspan="2"><?php echo $this->Paginator->sort('StaffSchedule.created','登録日時', array('escape' => false));?></td>
    </tr>
    <tr>
        <td align="center" style="background-color: #cccccc;"><?php echo $this->Paginator->sort('StaffSchedule.staff_id','ID', array('escape' => false));?></td>
        <td align="center" style="background-color: #cccccc;" colspan="2">氏名</td>
        <td align="center" style="background-color: #cccccc;">職種</td>
<?php
    $d = 1;
    while (checkdate($m, $d, $y)) {
        // 日付出力（土日祝には色付け）
        if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 0 || !empty($national_holiday[date("Y-m-d", mktime(0, 0, 0, $m, $d, $y))])) {
                $style = 'color:red;';
        } elseif(date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
                $style = 'color:blue;';
        /**
        } elseif(!empty($national_holiday[date("Y-m-d", mktime(0, 0, 0, $m, $d, $y))])) {
                $style = 'color:red;';
        * 
        */
        } else {
                $style = '';
        }
        // 本日
        if ($m == date("n") && $d == date("j") && $y == date("Y")) {
            $style = $style.'font-weight: bold;background-color: #ffffcc;color:green;';
        }
        // 出力
        echo "<td align=\"center\" style='".$style."'>".$d."</td>";
        $d++;
    }
?>
    </tr>
    <tr style="background-color: #ffffcc;">
        <td align="center"></td>
        <td align="left" colspan="2">
            <?php echo $this->Form->input('search_name', array('type'=>'text', 'label' => false, 'placeholder'=>'氏名（漢字 or かな）', 'style' => 'width:95%;font-size:90%;')); ?>
        </td>
        <td align="left">
          <?php echo $this->Form->input('search_shokushu', 
                  array('type'=>'select', 'label' => false, 'style' => 'width:95%;font-size:90%;', 
                      'empty' => array('' => '職種を選んでください'), 'options' => $list_shokushu, 'onchange' => 'form.submit();')); ?>
        </td>
<?php
    $d = 1;
    while (checkdate($m, $d, $y)) {
        echo '<td></td>';
        $d++;
    } 
?>
        <td></td>
    </tr>
    <?php foreach($datas1 as $key => $data1) { ?>
    <tr>
        <td align="center" style="padding: 0px 10px;">
            <?=setID($data1['StaffSchedule']['staff_id']); ?>
        </td>
        <td align="left" style="padding: 0px 10px;">
        <?php
            if (strstr($data1['StaffSchedule']['staff_id'], 'u')) {
                echo $user_arr[ltrim($data1['StaffSchedule']['staff_id'], 'u')];
            } else {
        ?>
            <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/StaffMasters/index/0/<?php echo $data1['StaffSchedule']['staff_id']; ?>/profile','スタッフ登録','width=1200,height=900,scrollbars=yes');" class="link_prof">
                <?=$staff_arr[$data1['StaffSchedule']['staff_id']]; ?>
            </a>
        <?php  
            }
        ?>
        </td>
        <td align="center">
            <?php
                if (strstr($data1['StaffSchedule']['staff_id'], 'u')) {
            ?>
            <button onclick="window.open('<?=ROOTDIR ?>/ShiftManagement/input_schedule2/<?=ltrim($data1['StaffSchedule']['staff_id'], 'u'); ?>?date=<?=$date2 ?>','シフト希望','width=1200,height=800,scrollbars=yes');return false;">編集</button>
            <button name="delete[<?=$data1['StaffSchedule']['staff_id']; ?>]" onclick="return window.confirm('【確認】本当に削除いたしますか？');">削除</button>
            <?php
                } else {
            ?>
            <button onclick="window.open('<?=ROOTDIR ?>/ShiftManagement/input_schedule/<?=$data1['StaffSchedule']['staff_id']; ?>?date=<?=$date2 ?>','シフト希望','width=1200,height=800,scrollbars=yes');return false;">編集</button>
            <button name="delete[<?=$data1['StaffSchedule']['staff_id']; ?>]" onclick="return window.confirm('【確認】本当に削除いたしますか？');">削除</button>
            <?php } ?>
        </td>
        <td align="left" style="padding: 0px 10px;font-size: 90%;"><?=setShokushu($data1['StaffSchedule']['staff_id'], $staff_shokushu_arr, $list_shokushu); ?></td>
<?php
    $d = 1;
    while (checkdate($m, $d, $y)) {
        // 日付出力（土日祝には色付け）
        if(date("w", mktime(0, 0, 0, $m, $d, $y)) == 0 || !empty($national_holiday[date("Y-m-d", mktime(0, 0, 0, $m, $d, $y))])) {
                $style = 'color:red;';
        } elseif(date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
                $style = 'color:blue;';
        } else {
                $style = '';
        }
        // 本日
        if ($m == date("n") && $d == date("j") && $y == date("Y")) {
            $style = $style.'font-weight: bold;background-color: #ffffcc;color:green;';
        }
        //$style = $style.'font-weight: bold;';
        // 予定ありかどうか
        $nodata = true;
        foreach ($datas2[$key] as $data2) {
            if ($y.'-'.sprintf("%02d", $m).'-'.sprintf("%02d", $d) == $data2['StaffSchedule']['work_date']) {
                // 条件
                if (empty($data2['StaffSchedule']['conditions'])) {
                    $comment3 = '';
                    $style2 = '';
                } else {
                    $comment3 = 'alert("【シフト条件】\n'.$data2['StaffSchedule']['conditions'].'");';
                    $style2 = 'background-color:#E6FFE9;';
                }
                // 出力
                if ($data2['StaffSchedule']['work_flag'] == 0) {
                    if (empty($comment3)) {
                        echo "<td align=\"center\" style='".$style.$style2."'>－</td>";
                    } else {
                        echo "<td align=\"center\" style='".$style.$style2."'><a href='#' title='".$data2['StaffSchedule']['conditions']."' onclick='".$comment3."'>－</a></td>";
                    }
                } elseif ($data2['StaffSchedule']['work_flag'] == 1) {
                    if (empty($comment3)) {
                        echo "<td align=\"center\" style='".$style.$style2."'>○</td>";
                    } else {
                        echo "<td align=\"center\" style='".$style.$style2."'><b><a href='#' title='".$data2['StaffSchedule']['conditions']."' onclick='".$comment3."'>○</a></b></td>";
                    }
                } elseif($data2['StaffSchedule']['work_flag'] == 2) {
                    echo "<td align=\"center\" style='".$style.$style2."'><b><a href='#' title='".$data2['StaffSchedule']['conditions']."' onclick='".$comment3."'>△</a></b></td>";
                }
                $nodata = false;
            }
        }
       if ($nodata) {
            echo "<td align=\"center\" style='".$style."'>"."</td>";
        }

        $d++;
    }
?>
        <td style="font-size: 90%;"><?=$data2['StaffSchedule']['modified']; ?></td>
    </tr>        
    <?php } ?>
<?php if (count($datas1) == 0) { ?>
<tr>
    <td colspan="36" align="center" style="background-color: #fff9ff;">表示するデータはありません。</td>
</tr>
<?php } ?>
</table>
<!-- カレンダー END-->
</div>

<!--- スタッフマスタ本体 END --->
<?php echo $this->Form->end(); ?>

<!-- 機能紹介 -->
<script type="text/javascript">
    /**
$(function() {
    //alert('制作中です');
  // 2ダイアログ機能を適用
  $('#dialog').dialog({
    modal: true,
    buttons: {
　　　　"OK": function(){
　　　　$(this).dialog('close');
　　　　}
　　　}
  });
});
**/
</script>
<div id="dialog" title="シフト管理の紹介" style="display: none">
<p style="font-size: 90%;">
    この機能を使って、各案件のシフト決めや勤怠管理、給与管理が可能になります。<br>
    <br>
    ※ただいま<font color="red">制作中</font>です。</p>
</div>
