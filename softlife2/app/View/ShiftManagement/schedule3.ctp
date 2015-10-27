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
<div id='headline' style="padding:4px 10px 4px 10px;">
    <div style="float: left;padding-top: 5px;">
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
    <div style="float:right;padding-top: 1px;">
        <input type="text" value="<?=displayCommit($flag); ?>" 
               style="text-align: center;width: 100px;font-size: 110%;margin-right:30px;font-family: メイリオ;<?=commitStyle($flag); ?>" disabled="disabled">
    </div>
    <div style="clear: both;"></div>
</div>
<!-- 見出し１ END -->

<!-- 月の指定 -->
<?php echo $this->Form->create('WkSchedule', array('name' => 'form')); ?>
<?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'display: none;')); ?>
<?php
    if ($flag == 1) {
        $css = 'font-weight:bold; color:#FFFFCC;';
    } else {
        $css = 'color:white;';
    }
?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td><a href="<?=ROOTDIR ?>/ShiftManagement/schedule3?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                <td style='background-color: #006699;cursor: pointer;'>
                    <a style='font-size: 110%;<?=$css?>' onclick="location.href = '<?=ROOTDIR ?>/ShiftManagement/schedule3?date=<?=$y?>-<?=sprintf("%02d", $m)?>';">
                        【<?php echo $y ?>年<?php echo $m ?>月】
                    </a>
                </td>
                <td><a href="<?=ROOTDIR ?>/ShiftManagement/schedule3?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
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
        <?php echo $this->Paginator->counter(array('format' => __('全  <b>{:count}</b> 職種')));?>
        &nbsp;&nbsp;&nbsp;
        <!--
        表示件数：
        <?php
            $list = array('5'=>'5','10'=>'10','20'=>'20','50'=>'50','100'=>'100');
            echo $this->Form->input('limit', array('name' => 'limit', 'type' => 'select','label' => false,'div' => false, 'options' => $list, 'selected' => $limit,
                'onchange' => 'form.submit();'));
        ?>
        -->
    </div>
 </div>
<div style="clear:both;"></div>
<!-- シフト希望表本体 -->
    <table border='1' cellspacing="0" cellpadding="5" class="data" 
           style="margin-top: 5px;margin-bottom: 5px;border-spacing: 0px;table-layout: fixed;font-size: 100%;">
        <tr>
            <td style="background-color: #99ccff;width:10px;"></td>
            <th style="padding: 5px 20px;background-color: #FFFFEE;">
                <?php echo $this->Form->input('select_case', 
                        array('type'=>'select', 'label' => false, 'style' => 'width:100%;font-size:110%;', 
                            'empty' => array('' => '案件を選んでください'), 'options' =>$case_arr, 'selected'=>$case_id,
                            'onchange' => 'location.href="'.ROOTDIR.'/ShiftManagement/schedule3/"+this.value+"?date='.$date2.'";')); ?>
            </th>
        </tr>
    </table>
        
    <!-- 横スクロール部分 -->
    <div> 
    <table border='1' cellspacing="0" cellpadding="1"
           style="width:<?=$col*150+150 ?>px;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;font-size:90%;">
        <colgroup> 
            <col style='width:150px;'>
          <?php for ($count=0; $count<$col; $count++){ ?>
          <col style='width:150px;'>
          <?php } ?>
        </colgroup>
        <tbody>
            <!-- 職種 -->
            <tr style="background-color: #EEEEEE;">
                <td style="height:30px;text-align: center;background-color: #EEEEEE;">
                    職種<div id="message" style="display: none;"></div>
                </td>
                <?php for ($count=0; $count<$col; $count++){ ?>
                <th style='height:30px;text-align: center;color:#666666;'>
                    <?php echo $list_shokushu[$datas[$count]['WorkTable']['shokushu_id']]; ?>
                    <?php echo setKakko($datas[$count]['OrderInfoDetail']['shokushu_memo']); ?>
                </th>
                <?php } ?>
            </tr>
            <!-- 勤務時間 -->
            <tr id="OrderDetail17">
                <td style='background-color: #e8ffff;height:30px;text-align: center;'>勤務時間</td>
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: #e8ffff;height:30px;text-align: center;'>
                    <?php echo $datas[$count]['OrderInfoDetail']['worktime_from'].'～'.$datas[$count]['OrderInfoDetail']['worktime_to']; ?>
                </td>
                <?php } ?>
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
                echo '<tr style="">';
                /** カレンダー部分 **/
                echo '<td align="center" style="color:'.$style.';background-color: #e8ffff;height:30px;">'.$m.'/'.$d.'('.$weekday[$i].')';
                if ($i==0 || $i==6 || !empty($national_holiday[date("Ymd", mktime(0, 0, 0, $m, $d, $y))])) {
                    echo '<input type="hidden" id="HolidayD'.$d.'" value="1">';
                } else {
                    echo '<input type="hidden" id="HolidayD'.$d.'" value="0">';
                }
                echo '</td>';
                /** カレンダー部分 END **/
                for ($count=0; $count<$col; $count++) {
                    if (empty($datas[$count]['WorkTable']['d'.$d])) {
                        $bgcolor = 'white';
                    } else {
                        $bgcolor = '#CCFFCC';
                    }
        ?>
            <td id="Cell<?=$count ?>D<?=$d ?>" class="" style="height:30px;background-color: <?=$bgcolor ?>;text-align:center;font-size:110%;">
            <?php
                if (empty($datas[$count]['WorkTable']['d'.$d])) {
                    echo '';
                } else {
                    echo $staff_arr[$datas[$count]['WorkTable']['d'.$d]];
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

    <div style="clear:both;"></div>
<script type="text/javascript">
function $E(name){ return document.getElementById(name); }
function scroll(){
   $E("header_h3").scrollLeft= $E("data3").scrollLeft;// データ部のスクロールをヘッダに反映
   $E("header_v3").scrollTop = $E("data3").scrollTop;// データ部のスクロールをヘッダに反映
   }
$E("data3").onscroll=scroll;
</script>

<?php echo $this->Form->end(); ?>  