<?php
    echo $this->Html->css('staffmaster');
?>
<?php require 'schedule_element.ctp'; ?>
<?php
function setShokushu($shokushu_ids, $list_shokushu) {
    $shokushu_id = explode(',', $shokushu_ids);
    $ret = '';
    foreach ($shokushu_id as $id) {
        if (empty($id)) {
            continue;
        }
        if (empty($ret)) {
            $ret = trim(mb_convert_kana($list_shokushu[$id], 's'));
        } else {
            $ret = $ret.', '.trim(mb_convert_kana($list_shokushu[$id], 's'));
        }
    }
    return $ret;
}
// 案件
function setCase($case_ids, $list_case2) {
    $case_id = explode(',', $case_ids);
    $ret = '';
    foreach ($case_id as $id) {
        if (empty($id)) {
            continue;
        }
        if (empty($ret)) {
            $ret = mb_strimwidth(trim(mb_convert_kana($list_case2[$id], 's')), 0, 20, '…');
        } else {
            $ret = $ret.'<br>'.mb_strimwidth(trim(mb_convert_kana($list_case2[$id], 's')), 0, 20, '…');
        }
    }
    return $ret;
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
    <a href="<?=ROOTDIR ?>/ShiftManagement/index?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target="" id="shift" class="load" onclick=''><font Style="font-size:95%;">スタッフシフト希望</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target="" id="shift" class="load" onclick=''><font Style="font-size:95%;">シフト作成</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <b><font Style="font-size:95%;color: yellow;">[確定シフト]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/uri9" target=""><font Style="font-size:95%;">勤務実績</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/setting" target="" onclick=''><font Style="font-size:95%;">詳細設定</font></a>
    &nbsp;

</div>
<!-- 見出し１ END -->

<!-- 月の指定 -->
<?php echo $this->Form->create('WkSchedule', array('name' => 'form')); ?>
<?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'display: none;')); ?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td><a href="<?=ROOTDIR ?>/ShiftManagement/schedule2?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                <td style='background-color: #006699;color: white;cursor: pointer;'>
                    <a style='font-size: 110%;color:white;' onclick="location.href = '<?=ROOTDIR ?>/ShiftManagement/schedule2?date=<?=$y?>-<?=sprintf("%02d", $m)?>';">
                        【<?php echo $y ?>年<?php echo $m ?>月】
                    </a>
                </td>
                <td><a href="<?=ROOTDIR ?>/ShiftManagement/schedule2?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
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
    <div style="float:left;margin-left: 15px;margin-top: 5px;">
        【表示】案件別 | <a href="<?=ROOTDIR ?>/ShiftManagement/schedule2?date=<?=$date2 ?>">スタッフ別</a>
    </div>
    
    <div style="float:right;margin-top: 5px;">
        <?php echo $this->Paginator->counter(array('format' => __('全  <b>{:count}</b> 名')));?>
        &nbsp;&nbsp;&nbsp;
        表示件数：
        <?php
            $list = array('5'=>'5','10'=>'10','20'=>'20','50'=>'50','100'=>'100');
            echo $this->Form->input('limit', array('name' => 'limit', 'type' => 'select','label' => false,'div' => false, 'options' => $list, 'selected' => $limit,
                'onchange' => 'form.submit();'));
        ?>
    </div>
 </div>
<div style="clear:both;"></div>
<!-- シフト希望表本体 -->
    <!-- 外枠 -->      
    <div id="redips-drag" class="x_data_area" style="position: relative;margin-top: 5px;margin-bottom: 10px;height: 90%;">
        <!-- ロック部分（左上） -->
        <table class=t  style="width:120px;height:51px;position:absolute;left:0px;top:0px;table-layout: fixed;text-align: center;">
            <tr>
                <th style='background:#99ccff;text-align: center;width:120px;height: 50px;font-size: 80%;' colspan="2">
                    <a href="#" onclick="setHidden();">
                        <span id="ActiveDisplay" onclick="">【表示切り替え】</span>
                    </a>
                </th>
            </tr>
        </table>
        <!-- ロック部分（上） -->
        <div id="header_h">
            <table border='1' cellspacing="0" cellpadding="5" id=""
                   style="width:<?=$col*150 ?>px;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;font-size: 90%;">
                <colgroup> 
                  <?php for ($count=0; $count<$col; $count++){ ?>
                  <col style='width:120px;'>
                  <?php } ?>
                </colgroup>
                <tr>
                    <th id="" 
                        style='background:#99ccff;text-align: center;height: 36px;' colspan="<?=$col ?>">
                    <?php echo $getCasename[$datas[0]['WorkTable']['case_id']]; ?>
                    </th>
                </tr>
            </table>
        </div>
        <!-- ロック部分（左） -->
        <div class="lock_box" id="header_v">
            <table border='1' cellspacing="0" cellpadding="5" class="data" 
                   style="background-color: #e8ffff;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;font-size: 90%;">
                <col style="width: 25px;" />
                <col style="width: 95px;" />
            <!-- 給与 END -->
                <tr>
                    <td colspan="2" style="height:30px;text-align: center;">
                        職種
                        <div id="message" style="display: none;"></div>
                    </td>
                </tr>
            <tr id="OrderDetail0_17">
                <td style='background-color: #e8ffff;height:70px;' colspan="2">勤務時間</td>
            </tr>
                <?php
                    // 曜日の配列作成
                    $weekday = array( "日", "月", "火", "水", "木", "金", "土" );
                    // 1日の曜日を数値で取得
                    $fir_weekday = date( "w", mktime( 0, 0, 0, $m, 1, $y ) );
                    // 1日の曜日設定
                    $i = $fir_weekday; // カウント値リセット
                ?>
                <!-- カレンダー部分 --> 
                <?php
                    // 今月の日付が存在している間ループする
                    for( $d=1; checkdate( $m, $d, $y ); $d++ ){
                        //曜日の最後まできたらカウント値（曜日カウンター）を戻して行を変える
                        if( $i > 6 ){
                            $i = 0;
                        }
                    //-------------スタイルシート設定-----------------------------------
                        if( $i == 0 || !empty($national_holiday[date("Ymd", mktime(0, 0, 0, $m, $d, $y))])){ //日曜日の文字色
                            $style = "#C30";
                        }
                        else if( $i == 6 ){ //土曜日の文字色
                            $style = "#03C";
                        } else{ //月曜～金曜日の文字色
                            $style = "black";
                        }
                        $style2 = '';
                    //-------------スタイルシート設定終わり-----------------------------

                        // 日付セル作成とスタイルシートの挿入
                        echo '<tr style="'.$style2.';">';
                        echo '<td align="center" style="color:'.$style.';background-color: #e8ffff;height:30px;" colspan="2">'.$m.'/'.$d.'('.$weekday[$i].')';
                        if ($i==0 || $i==6) {
                            echo '<input type="hidden" id="HolidayD'.$d.'" value="1">';
                        } else {
                            echo '<input type="hidden" id="HolidayD'.$d.'" value="0">';
                        }
                        for ($count=0; $count<$col; $count++){
                            if (empty($datas) || empty($datas[$count])) {
                                $class_name = 'redips-mark';
                            } elseif ($datas[$count]['WorkTable']['d'.$d] == 0) {
                                $class_name = 'redips-mark';
                            } elseif ($datas[$count]['WorkTable']['d'.$d] == 1) {
                                $class_name = '';
                            }
                        } 
                        echo '</td>';
                ?>
                    </tr>
                <?php
                            $i++; //カウント値（曜日カウンター）+1
                        } 
                ?>
                <!-- カレンダー部分 END -->
            </table>
        </div>
        <!-- /ロック部分 -->
        <!-- 横スクロール部分 -->
        <div class="x_scroll_box" id="data">  
        <!-- 職種入力 -->   
        <table border='1' cellspacing="0" cellpadding="5" id="table1"
               style="width:<?=$col*150 ?>px;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;">
            <colgroup> 
              <?php for ($count=0; $count<$col; $count++){ ?>
              <col style='width:150px;'>
              <?php } ?>
            </colgroup>
            <tbody>
            <!-- 職種 -->
            <tr>
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: #ffffcc;height:30px;'>
                    <?php echo $list_shokushu[$datas[$count]['WorkTable']['shokushu_id']]; ?>
                    <?php echo setKakko($datas[$count]['WorkTable']['shokushu_memo']); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 勤務時間 -->
            <tr id="OrderDetail17">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: #ffffcc;height:70px;'>
                    <?php echo $datas[$count]['WorkTable']['worktime_from'].'～'.$datas[$count]['WorkTable']['worktime_to'] ?>
                </td>
                <?php } ?>
            </tr>
            <!-- カレンダー部分 --> 
            <?php
                // 今月の日付が存在している間ループする
                for( $d=1; checkdate( $m, $d, $y ); $d++ ){
                    //曜日の最後まできたらカウント値（曜日カウンター）を戻して行を変える
                    if( $i > 6 ){
                        $i = 0;
                    }
                //-------------スタイルシート設定-----------------------------------
                    if( $i == 0 ){ //日曜日の文字色
                        $style = "#C30";
                    }
                    else if( $i == 6 ){ //土曜日の文字色
                        $style = "#03C";
                    }
                    else{ //月曜～金曜日の文字色
                        $style = "black";
                    }
                    $style2 = '';
                //-------------スタイルシート設定終わり-----------------------------

                    // 日付セル作成とスタイルシートの挿入
                    echo '<tr style="'.$style2.';">';
                    $kadou[] = NULL;
                    for ($count=0; $count<$col; $count++){
                        if (empty($datas2) || empty($datas2[$count])) {
                            $class_name = 'redips-mark';
                            if (empty($kadou[$count])) {
                                $kadou[$count] = 0;
                            }
                        } elseif ($datas2[$count]['WorkTable']['d'.$d] == 0) {
                            $class_name = 'redips-mark';
                            if (empty($kadou[$count])) {
                                $kadou[$count] = 0;
                            }
                        } elseif ($datas2[$count]['WorkTable']['d'.$d] == 1) {
                            $class_name = '';
                            if (empty($kadou[$count])) {
                                $kadou[$count] = 1;
                            } else {
                                $kadou[$count] += 1;
                            }
                        }
                    }
            ?>
                <td id="Cell<?=$count ?>D<?=$d ?>" class="<?=$class_name ?>" style="height:30px;">
                    <?php if (!empty($class_name)) { ?>
                    <?php echo ''; ?>
                    <?php } else { ?>
                    <?php //echo $datas2[$count]['WorkTable']['d'.$d]; ?>
                    <span id="<?=setData($datas2,'order_id',$count,$record) ?>"></span>
                    <span id="<?=setData($datas2,'shokushu_num',$count,$record) ?>"></span>
                    <?php
                        // 待ち合わせ
                        $order_id = setData($datas2,'order_id',$count,$record);
                        $shokushu_num = setData($datas2,'shokushu_num',$count,$record);
                        if (empty($data_aps[$order_id][$shokushu_num][$d])) {
                            $style = '';
                        } else {
                            $style = 'background-color:#ffcc66;';
                        }
                        if (!empty($staff_cell[$d][$count+1])) {
                            if (!empty($data_staffs[$d][$count+1])) {
                                //$this->log($data_staffs[$d][$count+1], LOG_DEBUG);
                                foreach($data_staffs[$d][$count+1] as $key=>$data_staff) {
                                    echo '<div id="'.$data_staff['StaffMaster']['id'].'" class="redips-drag t1" style="'.$style.'">';
                                    echo $data_staff['StaffMaster']['name_sei'].' '.$data_staff['StaffMaster']['name_mei'];
                                    echo '</div>';
                                }
                            }
                        }
                    ?>
                </td>
            <?php
                    }
                    echo '</tr>';
                    $i++; //カウント値（曜日カウンター）+1
                }
            ?>
            <!-- カレンダー部分 END -->
            </tbody>
        </table>
        </div>
<div id="Div" style="display: none;clear:both;"><p id="Mbox0">セルをクリックしたらここに書き出します。</p>
 <p id="Mbox1">インデックス値は '0'から始まります。</p>
</div>
    </div>
<script type="text/javascript">
function $E(name){ return document.getElementById(name); }
function scroll(){
   $E("header_h").scrollLeft= $E("data").scrollLeft;// データ部のスクロールをヘッダに反映
   $E("header_v").scrollTop = $E("data").scrollTop;// データ部のスクロールをヘッダに反映
   }
$E("data").onscroll=scroll;
</script>

<?php echo $this->Form->end(); ?>  