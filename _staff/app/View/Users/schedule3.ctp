<?php require('holiday.ctp'); ?>
<?php
    // 初期値
    $y = date('Y', strtotime('+1 month'));
    $m = date('n', strtotime('+1 month'));

    // 日付の指定がある場合
    if(!empty($_GET['date']))
    {
            $arr_date = explode('-', $_GET['date']);

            if(count($arr_date) == 2 and is_numeric($arr_date[0]) and is_numeric($arr_date[1]))
            {
                    $y = (int)$arr_date[0];
                    $m = (int)$arr_date[1];
            }
    }

    // 祝日取得
    $national_holiday = japan_holiday($y);
?>
<?php
    function setFlag($val) {
        if ($val == 1) {
            $ret = '◎';
        } elseif ($val == 2) {
            $ret = '△';
        } else {
            $ret = '　';
        }
        return $ret;
    }
    // 値があれば括弧で囲む
    function setKakko($value) {
        if (!empty($value)) {
            $ret = '('.$value.')';
        } else {
            $ret = '';
        }
        return $ret;
    }
?>

<script type="text/javascript">
<!--
$(function() {
    // 全選択・全解除
    $('#SelectAll').on('change', function(){
        if($("#SelectAll:checked").val()) {
            for(i=0; i<31; i++) {
                $("#check"+(i+1)).prop({'checked':'checked'});
            }
        }
        else {
            for(i=0; i<31; i++) {
                $("#check"+(i+1)).prop({'checked':false});
            }
        } 
    });
});
-->
</script>  
<style>
input[type=checkbox] {
    width: 15px;
    height: 15px;
    margin-left: -15px;
    vertical-align: middle;
}
</style>

<div id="page1" data-role="page">
<?php
    if ($class == '11') {
        $area = '関西';
    } elseif ($class == '21') {
        $area = '関東';
    } elseif ($class == '31') {
        $area = '中部';
    } else {
        $area = '？';
    }
?>
        <div data-role="header" data-theme="c">
                <h1>スタッフシフト表<span style="font-size: 90%;margin-left: 5px;">（<?=$area ?>エリア）</span></h1>
                <!--
                <a href="#" data-role="button" data-icon="refresh" data-iconpos="notext" data-inline="true" onclick="location.reload();"></a>
                -->
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>
        <div data-role="content" style="font-size: 70%;">
            <!--- シフト希望表 --->
            <!-- カレンダー -->
        <?php echo $this->Form->create('StaffSchedule', array('name' => 'form')); ?>
        <?php
            if (empty($data2)) {
                $bgcolor = 'white';
            } else {
                $bgcolor = '#ffffcc';
            }
        ?>
            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
                    <tr align="center">
                            <td><a href="<?=ROOTDIR ?>/users/schedule3?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>" data-ajax="false">&lt; 前の月</a></td>
                            <td style="background-color: <?=$bgcolor ?>;"><div style="font-size:130%;">【<?php echo $y ?>年<?php echo $m ?>月】</div></td>
                            <td><a href="<?=ROOTDIR ?>/users/schedule3?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>" data-ajax="false">次の月 &gt;</a></td>
                    </tr>
            </table>
            
            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
                <tr align="center">
                    <td width="50px" style="background-color: #cccccc;color:black;">案件</td>
                    <td style="font-weight:bold;font-size: 110%;background-color: #FFFFDD;text-align: left;">
                        <?php
                            if ($case_num > 1) {
                                echo $this->Form->input('case_id', array('type'=>'select', 'legend'=>false,
                                    'label'=>false, 'div'=>false,'style'=>'font-size:90%;','data-mini'=>'true', 'options'=>$case_arr, 'selected'=>$case_id,
                                    'onchage'=>'location.href="'.ROOTDIR.'/users/schedule3/"+this.value+"?date='.$date1.'";'));
                            } elseif ($case_num == 1) {
                                foreach($case_arr as $value) {
                                    echo $value;
                                }
                            } else {
                                echo '';
                            }
                        ?>
                    </td>
                    <td style="width:10px;">
                        <?php
                            if ($case_num > 1) {
                        ?>
                        <input type="submit" name="changeCase" value="GO">
                        <?php
                            }
                        ?>
                    </td>
                </tr>
            </table>
            
            <table border='1' cellspacing="0" cellpadding="1" style="margin-top: 5px;margin-bottom: 10px;
                   border-spacing: 0px;background-color: white;table-layout: fixed;">
                <colgroup>
                    <col width="60px">
                    <?php
                        for($count=0;$count<$col;$count++) {
                    ?>
                    <col width="100px">
                    <?php
                        }
                    ?>
                </colgroup>
                <tr align="center" style="background-color: #cccccc;">
                    <th style="width:10px">日付</th>
                    <?php for ($count=0; $count<$col; $count++){ ?>
                    <td style='height:30px;text-align: center;color:black;'>
                        <?php echo $list_shokushu[$datas[$count]['WorkTable']['shokushu_id']]; ?><br>
                        <?php echo setKakko($datas[$count]['OrderInfoDetail']['shokushu_memo']); ?>
                    </td>
                    <?php } ?>
                </tr>
                <!-- 勤務時間 -->
                <tr id="OrderDetail17">
                    <td style='background-color: #e8ffff;height:20px;text-align: center;'>勤務時間</td>
                    <?php for ($count=0; $count<$col; $count++){ ?>
                    <td style='background-color: #e8ffff;height:20px;text-align: center;'>
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
                echo '<td align="center" style="color:'.$style.';background-color: #e8ffff;height:20px;">'.$m.'/'.$d.'('.$weekday[$i].')';
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
            <td id="Cell<?=$count ?>D<?=$d ?>" class="" style="height:20px;background-color: <?=$bgcolor ?>;text-align:center;font-size:110%;">
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

            <div style='float:left;'>
                <input type="button" value="戻　る" data-inline="true" onclick='location.href="<?=ROOTDIR ?>/users/schedule#page3";'>
            </div>  
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="pagetop">
                <a href="#page2">
                    <?php echo $this->Html->image('pagetop.png'); ?>
                </a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div>

<!--ダイアログメニュー-->
<?php require('dialog_menu.ctp'); ?>
<!--ダイアログメニュー end-->