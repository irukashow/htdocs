<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    //echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
?>
<?php
//JQueryのコントロールを使ったりして2000-12-23等の形式の文字列が渡すように限定するかんじ
function convGtJDate($src) {
    list($year, $month, $day) = explode("-", $src);
    if (!@checkdate($month, $day, $year) || $year < 1869 || strlen($year) !== 4
            || strlen($month) !== 2 || strlen($day) !== 2) return false;
    $date = str_replace("-", "", $src);
    $gengo = "";
    $wayear = 0;
    if ($date >= 19890108) {
        $gengo = "平成";
        $wayear = $year - 1988;
    } elseif ($date >= 19261225) {
        $gengo = "昭和";
        $wayear = $year - 1925;
    } elseif ($date >= 19120730) {
        $gengo = "大正";
        $wayear = $year - 1911;
    } else {
        $gengo = "明治";
        $wayear = $year - 1868;
    }
    switch ($wayear) {
        case 1:
            $wadate = $gengo."元年".$month."月".$day."日";
            break;
        default:
            $wadate = $gengo.sprintf("%02d", $wayear)."年".$month."月".$day."日";
    }
    return $wadate;
}
?>
<!-- for Datepicker -->
<link type="text/css" rel="stylesheet"
  href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
<script type="text/javascript"
  src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript"
  src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<!--1国際化対応のライブラリをインポート-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript">
$(function() {
  // 2日本語を有効化
  $.datepicker.setDefaults($.datepicker.regional['ja']);
  // 3日付選択ボックスを生成
  $('.date').datepicker({ dateFormat: 'yy/mm/dd' });
});
</script>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 5px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('案件登録<font color=gray> （オーダー情報）</font>'); ?></legend>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
        <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;&gt;&gt;&nbsp;
            オーダー情報&nbsp;&gt;&gt;&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <a href="<?=ROOTDIR ?>/CaseManagement/reg1/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【基本情報】</a>&nbsp;&gt;&gt;&nbsp;
            <font color=blue style="background-color: yellow;">オーダー情報</font>&nbsp;&gt;&gt;&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg3/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="alert('制作前');return false;">契約書情報</a>&nbsp;
<?php } ?>
        </font>
        <!-- ページ選択 END -->
        
<?php echo $this->Form->create('OrderInfo', array('name' => 'form','enctype' => 'multipart/form-data','id' => 'regist')); ?>
        <?php echo $this->Form->input('id', array('type'=>'hidden')); ?>  
<?php echo $this->Form->input('case_id', array('type'=>'hidden', 'value' => $case_id)); ?>   
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>
        
        <!-- 基本情報 -->
        <table border='1' cellspacing="0" cellpadding="5" style='width: 100%;margin-top: 10px;border-spacing: 0px;'>
            <tr>
                <th colspan="4" style='background:#99ccff;text-align: center;'>基本情報</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>保存名</td>
                <td colspan="3">
                    <?php echo $this->Form->input('order_name',array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:500px;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>契約期間</td>
                <td>
                    自&nbsp;<?php echo $this->Form->input('period_from',array('type'=>'text','div'=>false,'class'=>'date','label'=>false,'style'=>'width:150px;')); ?>
                    ～
                    至&nbsp;<?php echo $this->Form->input('period_to',array('type'=>'text','div'=>false,'class'=>'date','label'=>false,'style'=>'width:150px;')); ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;'>登録職種数</td>
                <td style='width:20%;'>
                    <?php $list = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20'); ?>
                    <?php echo $this->Form->input('shokushu_num',array('type'=>'select','div'=>false,'options'=>$list,'empty'=>array(''=>''),'label'=>false,'style'=>'width:50px;')); ?>
                </td>
            </tr>
        </table>
        <!-- 入力へボタン -->
        <center>
        <?php echo $this->Form->input('▼ 次　へ ▼',array('type'=>'submit','div'=>false,'label'=>false,'name'=>'forward','style'=>'font-size:80%;')); ?>
        </center>
        <!-- 入力へボタン END -->
        <!-- 勤務について -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;margin-bottom: 10px;border-spacing: 0px;">
            <tr>
                <th colspan="10" style='background:#99ccff;text-align: center;'>
                <?php echo '自 '.convGtJDate($data['OrderInfo']['period_from']).'～至 '.convGtJDate($data['OrderInfo']['period_to']).'　'.$data['OrderInfo']['order_name'] ?>
                </th>
            </tr>
            <tr>
                <td rowspan="2" colspan="1" align="center" style='background-color: #e8ffff;'>【1】</td>
                <td rowspan="1" colspan="1" style='background-color: #e8ffff;width:10%;'>職種</td>
                <td rowspan="1" colspan="3" style='width:10%;'>
                    <?php echo $this->Form->input('job_startdate_kibou',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90%;text-align: left;')); ?>
                </td>
                <td rowspan="2" style='background-color: #e8ffff;width:5%;'>受注</td>
                <td rowspan="2" style='width:20%;'>
                    <?php $list1 = array('1'=>'日払', '2'=>'月払'); ?>
                    <?php $list2 = array('1'=>'有', '0'=>'無'); ?>
                    時間：<?php echo $this->Form->input('training_date_kibou',array('type'=>'radio','div'=>false,'legend'=>false,'options'=>$list1,'style'=>'text-align: left;')); ?><br>
                    金額：<?php echo $this->Form->input('training_date_kibou',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:70%;text-align: left;')); ?><br>
                    交通費：<?php echo $this->Form->input('training_date_kibou',array('type'=>'radio','div'=>false,'legend'=>false,'options'=>$list2,'style'=>'text-align: left;')); ?><br>
                    計算方法：<?php echo $this->Form->input('training_date_kibou',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:55%;text-align: left;')); ?>
                </td>
                <td rowspan="2" style='background-color: #e8ffff;width:5%;'>給与</td>
                <td rowspan="2" style='width:20%;'>
                    <?php $list1 = array('1'=>'日払', '2'=>'月払'); ?>
                    <?php $list2 = array('1'=>'有', '0'=>'無'); ?>
                    時間：<?php echo $this->Form->input('training_date_kibou',array('type'=>'radio','div'=>false,'legend'=>false,'options'=>$list1,'style'=>'text-align: left;')); ?><br>
                    金額：<?php echo $this->Form->input('training_date_kibou',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:70%;text-align: left;')); ?><br>
                    交通費：<?php echo $this->Form->input('training_date_kibou',array('type'=>'radio','div'=>false,'legend'=>false,'options'=>$list2,'style'=>'text-align: left;')); ?><br>
                    計算方法：<?php echo $this->Form->input('training_date_kibou',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:55%;text-align: left;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:10%;'>基本就業時間</td>
                <td style='width:15%;'>
                    <?php echo $this->Form->input('training_date_kibou',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:35%;text-align: left;')); ?>&nbsp;～
                    <?php echo $this->Form->input('training_date_kibou',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:35%;text-align: left;')); ?>
                </td>
                <td style='background-color: #e8ffff;width:10%;'>休憩時間</td>
                <td style='width:10%;'>
                    <?php echo $this->Form->input('job_startdate_kibou',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90%;text-align: left;')); ?>
                </td>
            </tr>
 
        </table>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
        <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;&gt;&gt;&nbsp;
            オーダー情報&nbsp;&gt;&gt;&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <a href="<?=ROOTDIR ?>/CaseManagement/reg1/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【基本情報】</a>&nbsp;&gt;&gt;&nbsp;
            <font color=blue style="background-color: yellow;">オーダー情報</font>&nbsp;&gt;&gt;&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg3/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="alert('制作前');return false;">契約書情報</a>&nbsp;
<?php } ?>
        </font>
        <!-- ページ選択 END -->

    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('閉 じ る', 'javascript:void(0);', array('id'=>'button-delete', 'onclick'=>'window.opener.location.reload();window.close();'))); ?> 
    </div>
<?php echo $this->Form->end(); ?>
</div>