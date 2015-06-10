<?php
    echo $this->Html->script('jquery-1.9.1');
    
    // 年齢換算
    function getAge($str) {
        return floor ((date('Ymd') - $str)/10000).'歳';
    }
?>
<script type="text/javascript">
onload = function() {
    calculateAge();
}
        
function calculateAge() {
    Y = document.getElementById('StuffMasterBirthdayYear').options[document.getElementById('StuffMasterBirthdayYear').selectedIndex].value;
    M = document.getElementById('StuffMasterBirthdayMonth').options[document.getElementById('StuffMasterBirthdayMonth').selectedIndex].value;
    D = document.getElementById('StuffMasterBirthdayDay').options[document.getElementById('StuffMasterBirthdayDay').selectedIndex].value;
    //parseInt(document.getElementById('StuffMasterBirthdayMonth').options.value + affixZero(document.getElementById('StuffMasterBirthdayDay').options.value));
    _birth = parseInt("" + Y+M+D);// 文字列型に明示変換後にparseInt
    
    var today = new Date();
    var _today = parseInt("" + today.getFullYear() + affixZero(today.getMonth() + 1) + affixZero(today.getDate()));// 文字列型に明示変換後にparseInt
    //alert(parseInt((_today - _birth) / 10000));
    document.getElementById('age').value = parseInt((_today - _birth) / 10000);
    return parseInt((_today - _birth) / 10000);
}
/**
 * 1, 2 など 1桁の数値を 01, 02 などの文字列に変換（2桁以上の数字は単純に文字列型に変換）
 */
function affixZero(int) {
	if (int < 10) int = "0" + int;
	return "" + int;
}
</script>

<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 10px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('スタッフ登録 （登録情報）'); ?></legend>
<?php if ($stuff_id == 0) { ?>
        <font color=blue>登録情報</font>&nbsp;>>&nbsp;
        基本情報&nbsp;>>&nbsp;
        評価関連&nbsp;
<?php } else { ?>
        <font color=blue>登録情報</font>&nbsp;>>&nbsp;
        <a href="<?=ROOTDIR ?>/stuff_masters/reg2/<?=$stuff_id ?>/<?=$koushin_flag ?>">基本情報</a>&nbsp;>>&nbsp;
        <a href="<?=ROOTDIR ?>/stuff_masters/reg3/<?=$stuff_id ?>/<?=$koushin_flag ?>">評価関連</a>&nbsp;
<?php } ?>
<?php echo $this->Form->create('StuffMaster'); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $stuff_id)); ?>
        <?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>

        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th style='background:#99ccff;text-align: center;'>項目</th>
                <th style='background:#99ccff;text-align: center;' colspan='3'>入力内容</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>登録担当者</td>
                <td colspan="2">
                    <?php  
                        //$select1=array(''=>'','1'=>'担当者A','2'=>'担当者B','3'=>'担当者C');
                        echo $this->Form->input( 'tantou', array( 'label'=>false,'type' => 'select', 'div'=>false,'legend'=>false, 'empty' => array('0' => '選択してください'), 'style' => 'float:none;', 'options' => $name_arr));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>雇用形態</td>
                <td colspan="2">
                    <?php  
                        $select2=array(''=>'','1'=>'正社員','2'=>'契約社員','3'=>'人材派遣スタッフ');
                        echo $this->Form->input( 'employment_status', array( 'label'=>false,'type' => 'select', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select2));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>氏名</td>
                <td colspan="2">
                    <?php echo $this->Form->input('name_sei',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:20%;')); ?>
                    <?php echo $this->Form->input('name_mei',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:20%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>氏名（フリガナ）</td>
                <td colspan="2">
                    <?php echo $this->Form->input('name_sei2',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:20%;')); ?>
                    <?php echo $this->Form->input('name_mei2',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:20%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>性別</td>
                <td colspan="2">
                    <?php  
                        $select3=array('1'=>'女性','2'=>'男性');
                        echo $this->Form->input( 'gender', array( 'label'=>false,'type' => 'radio', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select3));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>生年月日</td>
                <td colspan="2">
                    <?php echo $this->Form->input('birthday',array('label'=>false,'div'=>false,'dateFormat' => 'YMD', 'maxYear' => date('Y'), 'minYear' => date('Y')-100, 'monthNames' => false, 'onchange'=>'calculateAge();')); ?>
                    &nbsp;&nbsp;&nbsp;<input id="age" style="width: 30px;text-align: right;border:none;">&nbsp;歳
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' rowspan="6">住所</td>
                <!-- 住所 Start -->
                <td style='background-color: #e8ffff;width:20%;'>郵便番号</td>
                <td>
                    <?php echo $this->Form->input('zipcode1',
                            array('label'=>false,'div'=>false,'maxlength'=>'3','style'=>'width:6%;')); ?>-
                    <?php echo $this->Form->input('zipcode2',
                            array('label'=>false,'div'=>false,'maxlength'=>'4','style'=>'width:8%;',
                                'onKeyUp'=>"AjaxZip3.zip2addr('data[StuffMaster][zipcode1]',this,'data[StuffMaster][address1]','data[StuffMaster][address2]','data[StuffMaster][address3]','data[StuffMaster][address4]');")); ?>
                            &nbsp;&nbsp;<font size="2">※住所を町村名まで自動で入力します。</font>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>都道府県</td>
                <td>
                    <?php echo $this->Form->input('address1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'（都道府県）', 'options'=>$pref_arr)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>市区郡（町村）</td>
                <td>
                    <?php echo $this->Form->input('address2',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:60%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>町村名</td>
                <td>
                    <?php echo $this->Form->input('address3',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:60%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>番地</td>
                <td>
                    <?php echo $this->Form->input('address4',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:60%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>その他（建物名）</td>
                <td>
                    <?php echo $this->Form->input('address5',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:80%;')); ?>
                </td>
            </tr>
            <!-- 住所 End -->
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>電話番号１</td>
                <td colspan="2">
                    <?php echo $this->Form->input('telno1',array('label'=>false,'div'=>false,'style'=>'width:20%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>電話番号２</td>
                <td colspan="2">
                    <?php echo $this->Form->input('telno2',array('label'=>false,'div'=>false,'style'=>'width:20%;')); ?>
                </td>
            </tr> 
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メールアドレス１</td>
                <td colspan="2">
                    <?php echo $this->Form->input('email1',array('label'=>false,'div'=>false,'style'=>'width:40%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メールアドレス２</td>
                <td colspan="2">
                    <?php echo $this->Form->input('email2',array('label'=>false,'div'=>false,'style'=>'width:40%;')); ?>
                </td>
            </tr>  
        </table>
    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('閉 じ る', 'javascript:void(0);', array('id'=>'button-delete', 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>