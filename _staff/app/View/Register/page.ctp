<?php
    echo $this->Html->script('jquery-1.9.1');
?>
<script type="text/javascript">
onload = function() {
    calculateAge();
}
        
function calculateAge() {
    Y = document.getElementById('StaffMasterBirthdayYear').options[document.getElementById('StaffMasterBirthdayYear').selectedIndex].value;
    M = document.getElementById('StaffMasterBirthdayMonth').options[document.getElementById('StaffMasterBirthdayMonth').selectedIndex].value;
    D = document.getElementById('StaffMasterBirthdayDay').options[document.getElementById('StaffMasterBirthdayDay').selectedIndex].value;
    //parseInt(document.getElementById('StaffMasterBirthdayMonth').options.value + affixZero(document.getElementById('StaffMasterBirthdayDay').options.value));
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

<?php echo $this->Form->create('StaffMaster'); ?>
<div data-role="page" id="page1">
    <div data-role="header">
            <h1>スタッフ登録 （その１）</h1>
    </div> 
    <div role="main" class="ui-content">
            <label>メールアドレス<font color="red">*</font> <br>※ログインIDとなります。</label>
            <?php echo $this->Form->input('email1',array('label'=> false,'div'=>false,'style'=>'')); ?>

            <label>ログインパスワード<font color="red">*</font></label>
            <?php echo $this->Form->input('email1',array('type'=>'password', 'label'=>false,'div'=>false,'style'=>'width:100px;')); ?>
            <?php echo $this->Form->input('email1',array('type'=>'password', 'label'=>false,'div'=>false,'style'=>'width:100px;')); ?>

            <label>その他のメールアドレス（任意）</label>
            <?php echo $this->Form->input('email2',array('label'=>false,'div'=>false,'style'=>'width:40%;')); ?>

            <label>雇用形態<font color="red">*</font></label>
            <?php  
                $select2=array(''=>'','1'=>'正社員','2'=>'契約社員','3'=>'人材派遣スタッフ');
                echo $this->Form->input( 'employment_status', array( 'label'=>false,'type' => 'select', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select2));
            ?>

            <label>氏名<font color="red">*</font></label>
            <?php echo $this->Form->input('name_sei',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:10%;')); ?>
            <?php echo $this->Form->input('name_mei',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:10%;')); ?>

            <label>氏名（フリガナ）<font color="red">*</font></label>
            <?php echo $this->Form->input('name_sei2',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:20%;')); ?>
            <?php echo $this->Form->input('name_mei2',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:20%;')); ?>

            <label>性別<font color="red">*</font></label>
            <?php  
                $select3=array('1'=>'女性','2'=>'男性');
                echo $this->Form->input('gender', array('label'=>false,'type' => 'radio', 'legend'=>false, 'options' => $select3));
            ?>

            <label>生年月日<font color="red">*</font></label>
            <?php echo $this->Form->input('birthday',array('label'=>false,'div'=>false,'dateFormat' => 'YMD', 'maxYear' => date('Y'), 'minYear' => date('Y')-100, 'monthNames' => false)); ?>
    
            <a href="#page2" class="ui-btn ui-icon-carat-r">次へ</a>
    </div>        
    <div data-role="footer">
        <h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
    </div>
</div>
        
<div data-role="page" id="page2">
    <div data-role="header">
            <h1>スタッフ登録 （その２）</h1>
    </div>
    <div role="main" class="ui-content">
        <label>郵便番号<font color="red">*</font></label>
        <?php echo $this->Form->input('zipcode1',
                array('label'=>false,'div'=>false,'maxlength'=>'3','style'=>'width:6%;')); ?>
        <?php echo $this->Form->input('zipcode2',
                array('label'=>false,'div'=>false,'maxlength'=>'4','style'=>'width:8%;',
                    'onKeyUp'=>"AjaxZip3.zip2addr('data[StaffMaster][zipcode1]',this,'data[StaffMaster][address1]','data[StaffMaster][address2]','data[StaffMaster][address3]','data[StaffMaster][address4]');")); ?>

        <label>都道府県<font color="red">*</font></label>
        <?php echo $this->Form->input('address1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'（都道府県）', 'options'=>$pref_arr)); ?>

        <label>市区郡（町村）<font color="red">*</font></label>
        <?php echo $this->Form->input('address2',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:60%;')); ?>

        <label>町村名<font color="red">*</font></label>
        <?php echo $this->Form->input('address3',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:60%;')); ?>

        <label>番地<font color="red">*</font></label>
        <?php echo $this->Form->input('address4',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:60%;')); ?>

        <label>その他（建物名）</label>
        <?php echo $this->Form->input('address5',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:80%;')); ?>

        <label>電話番号１<font color="red">*</font></label>
        <?php echo $this->Form->input('telno1',array('label'=>false,'div'=>false,'style'=>'width:20%;')); ?>

        <label>電話番号２（任意）</label>
        <?php echo $this->Form->input('telno2',array('label'=>false,'div'=>false,'style'=>'width:20%;')); ?>

        <a href="#page3" class="ui-btn ui-icon-carat-r">次へ</a>
    </div>
    <div data-role="footer">
        <h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
    </div>
</div>
<?php echo $this->Form->end(); ?>
    