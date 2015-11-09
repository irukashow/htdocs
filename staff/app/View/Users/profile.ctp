<?php
    echo $this->Html->script('https://ajaxzip3.github.io/ajaxzip3.js');
    echo $this->Html->script('jquery.validate.min.js');
?>
<script type='text/javascript'>
function chkPasswd(pwd1, pwd2) {
    if (pwd1.value != pwd2.value) {
        alert("パスワードが異なります。");
        return false;
    } else {
        return true;
    }
}
</script> 

<div id="page4" data-role="page">
    <div data-role="header" data-theme="c">
            <h1>プロフィール</h1>
            <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
    </div>
    <div data-role="content">
    <?php 
        if ($flag == 1) {
            echo '<p><span style="color:red;">【情報】登録を完了しました。</span></p>';
        }
    ?>
        <b>プロフィールの変更</b>
        <p>以下の変更ができます。</p>
        <input type="button" value="１．住所変更" data-icon="arrow-r" data-iconpos="right" onclick='location.href="#address"'>
        <input type="button" value="２．連絡先変更" data-icon="arrow-r" data-iconpos="right" onclick='location.href="#contact"'>
        <input type="button" value="３．パスワード変更" data-icon="arrow-r" data-iconpos="right" onclick='location.href="#password"'>
        <input type="button" value="４．銀行口座変更" data-icon="arrow-r" data-iconpos="right" onclick='location.href="#bank"'>
        <div style='float:left;'>       
            <input type="button" value="ホーム" data-theme="b" data-icon="home" onclick='location.href="<?=ROOTDIR ?>/users/index#home"'>
        </div> 
    </div>
    <div class="pagetop">
            <a href="#page4">
                <?php echo $this->Html->image('pagetop.png'); ?>
            </a>
    </div>			
    <div id="footer">
        <?=FOOTER ?>
    </div>
</div>


<div id="address" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>プロフィール</h1>
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>
    <?php echo $this->Form->create('StaffMaster', array('name' => 'form')); ?>
    <?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $id)); ?>
    <?php echo $this->Form->input('status', array('type'=>'hidden', 'value' => 1)); ?> 
        <div data-role="content">
            <p><a href="#page4">プロフィール</a> ⇒ 住所変更</p>             
                <table border="1" cellspacing="0" cellpadding="5" width="100%">
                    <tr>
                        <!-- 住所 Start -->
                        <td style='background-color: #e8ffff;width:80%;'>郵便番号</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="yoko">
                    <?php echo $this->Form->input('zipcode1',
                            array('label'=>false,'div'=>false,'maxlength'=>'3','style'=>'',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'data[StaffMaster][zipcode2]','data[StaffMaster][address1]','data[StaffMaster][address2]','data[StaffMaster][address3]','data[StaffMaster][address4]');")); ?>
                    <?php echo $this->Form->input('zipcode2',
                            array('label'=>false,'div'=>false,'maxlength'=>'4','style'=>'',
                                'onKeyUp'=>"AjaxZip3.zip2addr('data[StaffMaster][zipcode1]',this,'data[StaffMaster][address1]','data[StaffMaster][address2]','data[StaffMaster][address3]','data[StaffMaster][address4]');")); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style='background-color: #e8ffff;width:20%;'>都道府県</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('address1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'（都道府県）', 'options'=>$pref_arr)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style='background-color: #e8ffff;width:20%;'>市区郡（町村）</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('address2',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style='background-color: #e8ffff;width:20%;'>町村名</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('address3',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style='background-color: #e8ffff;width:20%;'>番地</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('address4',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style='background-color: #e8ffff;width:20%;'>その他（建物名）</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('address5',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'')); ?>
                        </td>
                    </tr>
                    <!-- 住所 End -->
                </table>
            <div style='float:left;'>
                <input type="submit" value="更　新" data-theme="e" data-icon="check" data-inline="true" onclick=''>                
                <input type="button" value="戻　る" data-inline="true" onclick='location.href="#page4"'>
            </div>  
        </div>
    <?php echo $this->Form->end(); ?>
        <div class="pagetop">
                <a href="#address">
                    <?php echo $this->Html->image('pagetop.png'); ?>
                </a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div>

<div id="contact" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>プロフィール</h1>
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>	
        <div data-role="content">
            <p><a href="#page4">プロフィール</a> ⇒ 連絡先変更</p>
    <?php echo $this->Form->create('StaffMaster', array('name' => 'form2')); ?>
    <?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $id)); ?>
    <?php echo $this->Form->input('status', array('type'=>'hidden', 'value' => 2)); ?> 
                <table border="1" cellspacing="0" cellpadding="5" width="100%">
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>電話番号１（携帯）</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $this->Form->input('telno1',array('label'=>false,'div'=>false,'style'=>'')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>電話番号２</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $this->Form->input('telno2',array('label'=>false,'div'=>false,'style'=>'')); ?>
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>メールアドレス１（携帯）</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $this->Form->input('email1',array('label'=>false,'div'=>false,'style'=>'')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>メールアドレス２</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $this->Form->input('email2',array('label'=>false,'div'=>false,'style'=>'')); ?>
                        </td>
                    </tr>
                </table>
            <div style='float:left;'>
                <input type="submit" value="更　新" data-theme="e" data-icon="check" data-inline="true" onclick=''>                
                <input type="button" value="戻　る" data-inline="true" onclick='location.href="#page4"'>
            </div>  
                <?php echo $this->Form->end(); ?>
        </div>
        <div class="pagetop">
                <a href="#contact">
                    <?php echo $this->Html->image('pagetop.png'); ?>
                </a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div>
<!-- パスワード変更 -->
<div id="password" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>プロフィール</h1>
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>			
        <div data-role="content">
            <p><a href="#page4">プロフィール</a> ⇒ パスワード変更</p>
    <?php echo $this->Form->create('StaffMaster', 
            array('name' => 'form3', 'method' => 'post')); ?>
    <?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $id)); ?>   
    <?php echo $this->Form->input('status', array('type'=>'hidden', 'value' => 3)); ?> 
                <table border="1" cellspacing="0" cellpadding="5" width="100%">
                    <tr>
                        <td style='background-color: #e8ffff;width:20%;'>パスワード（２回入力）</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('password',array('label'=>false,'div'=>false,'value'=>'','class'=>'required')); ?>
                            <?php echo $this->Form->input('password2',array('type'=>'password', 'label'=>false,'div'=>false,'value'=>'','class'=>'required')); ?>
                        </td>
                    </tr>
                </table>
            <div style='float:left;'>
                <input type="submit" value="更　新" data-theme="e" data-icon="check" data-inline="true" onclick='return chkPasswd(document.getElementById("StaffMasterPassword"), document.getElementById("StaffMasterPassword2"));'>                
                <input type="button" value="戻　る" data-inline="true" onclick='location.href="#page4"'>
            </div>    
                <?php echo $this->Form->end(); ?>
        </div>
        <div class="pagetop">
                <a href="#password">
                    <?php echo $this->Html->image('pagetop.png'); ?>
                </a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div>
<!-- 銀行口座変更 -->
<div id="bank" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>プロフィール</h1>
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>			
        <div data-role="content">
            <p><a href="#page4">プロフィール</a> ⇒ 銀行口座変更</p>
    <?php echo $this->Form->create('StaffMaster', 
            array('name' => 'form3', 'method' => 'post')); ?>
    <?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $id)); ?>   
    <?php echo $this->Form->input('status', array('type'=>'hidden', 'value' => 3)); ?> 
                <table border="1" cellspacing="0" cellpadding="5" width="100%">
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>銀行名</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $this->Form->input('bank_name',array('label'=>false,'div'=>false,'style'=>'')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>店番号</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $this->Form->input('bank_branch_code',array('label'=>false,'div'=>false,'style'=>'')); ?>
                        </td>
                    </tr> 
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>支店名</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $this->Form->input('bank_shiten',array('label'=>false,'div'=>false,'style'=>'')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>種別</td>
                    </tr>
                    <tr>
                        <?php
                            if ($data['StaffMaster']['bank_type'] == 1) {
                                $checked1 = 'checked="checked"'; 
                                $checked2 = '';
                            } else {
                                $checked1 = ''; 
                                $checked2 = 'checked="checked"'; 
                            }
                        ?>
                        <td colspan="2">
                            <label>
                                <input type="radio" name="data[StaffMaster][bank_type]" id="StaffMasterbank_type1" style="float:none;" value="1" <?=$checked1 ?>>普通
                            </label>
                            <label>
                                <input type="radio" name="data[StaffMaster][bank_type]" id="StaffMasterbank_type2" style="float:none;" value="2" <?=$checked2 ?>>当座
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>口座番号</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $this->Form->input('bank_kouza_num',array('label'=>false,'div'=>false,'style'=>'')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style='background-color: #e8ffff;width:20%;'>口座名義</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $this->Form->input('bank_kouza_meigi',array('label'=>false,'div'=>false,'style'=>'')); ?>
                        </td>
                    </tr>
                </table>
            <div style='float:left;'>
                <input type="submit" value="更　新" data-theme="e" data-icon="check" data-inline="true" onclick='return chkPasswd(document.getElementById("StaffMasterPassword"), document.getElementById("StaffMasterPassword2"));'>                
                <input type="button" value="戻　る" data-inline="true" onclick='location.href="#page4"'>
            </div>    
                <?php echo $this->Form->end(); ?>
        </div>
        <div class="pagetop">
                <a href="#password">
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