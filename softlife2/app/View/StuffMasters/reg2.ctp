<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('station');
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
    <fieldset style="border:none;margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('スタッフ登録 （基本情報）'); ?></legend>
<?php echo $this->Form->create('StuffMaster', array('name' => 'form','enctype' => 'multipart/form-data','id' => 'regist')); ?>
        
        <!-- スタッフ情報 -->
        <table border='1' cellspacing="0" cellpadding="5" style='width: 100%;margin-top: 10px;border-spacing: 1px;'>
            <tr>
                <th colspan="2" style='background:#99ccff;text-align: center;'>スタッフ情報</th>
            </tr>
            <tr>
                <td colspan="2">
                    No.<?='0001' ?>&nbsp;&nbsp;登録番号：<?='0001' ?>&nbsp;&nbsp;
                    作成日：<?='2015-06-01' ?>&nbsp;&nbsp;更新日：<?='2015-06-01' ?>&nbsp;&nbsp;所属：<?='大阪-人材派遣' ?>
                </td>
            </tr>
        </table>
        <!-- 個人情報付則 -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
            <tr>
                <th colspan="10" style='background:#99ccff;text-align: center;'>個人情報付則</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:100px;'>証明写真</td>
                <td colspan="4">
                    <!-- 証明写真ドラッグ＆ドロップ -->
                    <input type="file" name="upfile[]" size="30" onchange=""  style="
                        border: 2px dotted #000000;
                        font-size: 100%;
                        width:300px;
                        height: 25px;
                        padding-top: 50px;
                        padding-bottom: 50px;
                        background-color: #ffffcc;
                        border-radius: 10px;        /* CSS3草案 */  
                        -webkit-border-radius: 10px;    /* Safari,Google Chrome用 */  
                        -moz-border-radius: 10px;   /* Firefox用 */
                        vertical-align: middle;
                       ">
                </td>
                <td style='background-color: #e8ffff;width:100px;'>履歴書<br><font style='color: red;'>PDFファイル</font></td>
                <td colspan="2">
                    <!-- 履歴書ドラッグ＆ドロップ -->
                    <input type="file" name="upfile[]" size="30" onchange="fileCheck(this, 'pdf');"  style="
                        border: 2px dotted #000000;
                        font-size: 100%;
                        width:300px;
                        height: 25px;
                        padding-top: 50px;
                        padding-bottom: 50px;
                        background-color: #ffffcc;
                        border-radius: 10px;        /* CSS3草案 */  
                        -webkit-border-radius: 10px;    /* Safari,Google Chrome用 */  
                        -moz-border-radius: 10px;   /* Firefox用 */
                        vertical-align: middle;
                       ">
                    
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>身長</td>
                <td style='width:150px;'><?php echo $this->Form->input('height',array('label'=>false,'style'=>'width:100px;')); ?>&nbsp;cm</td>
                <td style='background-color: #e8ffff;'>制服サイズ</td>
                <td style='width:30px;'>上</td>
                <td colspan='2' style='width:200px;'>
                <?php
                    $list=array('5'=>'5号','7'=>'7号','9'=>'9号','11'=>'11号','13'=>'13号');
                    echo $this->Form->input( 'size_1', array('label' => false, 'type' => 'radio','options' => $list));
                ?>
                </td>
                <td style='width:30px;'>下</td>
                <td style='width:200px;'>号</td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>最寄駅①</td>
                <td colspan="7">
                    <?php echo $this->Form->input('',array('name'=>'pref','type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
                        'onChange'=>'setMenuItem1(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
                    &nbsp;→
                    <select name="s0_1" onChange="setMenuItem1(1,this[this.selectedIndex].value)" style="width: 200px;">
                        <option selected>路線を選択してください</option>
                    </select>
                    →
                    <select name="s1_1" style="width: 150px;">
                        <option selected>駅を選択してください</option>
                    </select> 
                    駅
                    <select name="s2_1" style="width: 150px;display: none;">
                        <option selected>駅を選択してください</option>
                    </select> 
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>最寄駅②</td>
                <td colspan="7">
                    <?php echo $this->Form->input('',array('name'=>'pref','type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
                        'onChange'=>'setMenuItem2(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
                    &nbsp;→
                    <select name="s0_2" onChange="setMenuItem2(1,this[this.selectedIndex].value)" style="width: 200px;">
                        <option selected>路線を選択してください</option>
                    </select>
                    →
                    <select name="s1_2" style="width: 150px;">
                        <option selected>駅を選択してください</option>
                    </select> 
                    駅
                    <select name="s2_2" style="width: 150px;display: none;">
                        <option selected>駅を選択してください</option>
                    </select> 
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>最寄駅③</td>
                <td colspan="7">
                    <?php echo $this->Form->input('',array('name'=>'pref','type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
                        'onChange'=>'setMenuItem3(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
                    &nbsp;→
                    <select name="s0_3" onChange="setMenuItem3(1,this[this.selectedIndex].value)" style="width: 200px;">
                        <option selected>路線を選択してください</option>
                    </select>
                    →
                    <select name="s1_3" style="width: 150px;">
                        <option selected>駅を選択してください</option>
                    </select> 
                    駅
                    <select name="s2_3" style="width: 150px;display: none;">
                        <option selected>駅を選択してください</option>
                    </select> 
                </td>
            </tr>
        </table>
        
        <!-- 勤務について -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
            <tr>
                <th colspan="4" style='background:#99ccff;text-align: center;'>勤務について</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>勤務開始希望日</td>
                <td style='width:30%;'><input type="text" class="date" size="10" style='width:50%;text-align: left;'></td>
                <td style='background-color: #e8ffff;width:20%;'>研修希望日</td>
                <td style='width:30%;'><input type="text" class="date" size="10" style='width:50%;text-align: left;'></td>
            </tr>
        </table>
         
        <!-- 経理関係 -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
            <tr>
                <th colspan="4" style='background:#99ccff;text-align: center;'>経理関係</th>
            </tr>
        </table>
         
        <!-- その他 -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
            <tr>
                <th colspan="4" style='background:#99ccff;text-align: center;'>その他</th>
            </tr>
        </table>


    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録完了', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('戻　る', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'javascript:window.history.back(-1);return false;'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>