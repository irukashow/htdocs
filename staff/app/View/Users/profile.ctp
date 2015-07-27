<?php
    echo $this->Html->script('https://ajaxzip3.github.io/ajaxzip3.js');
?>
<div id="page4" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>プロフィール</h1>
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>			
        <div data-role="content">
            <h3>プロフィールの変更</h3>
            <p>以下の変更ができます。</p>
            <p><a href="#address">１．住所変更</a></p>
            <p><a href="#contact">２．連絡先変更</a></p>
            <p><a href="#password">３．パスワード変更</a></p>
        </div>
        <div class="pagetop">
                <a href="#page4"><img src="img/pagetop.png"></a>
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
        <div data-role="content">
            <p><a href="#page4">プロフィール</a> ⇒ 住所変更</p>
            <?php echo $this->Form->create('StaffMaster'); ?>                
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
        </div>
    <?php echo $this->Form->end(); ?>
        <div class="pagetop">
                <a href="#page4"><img src="img/pagetop.png"></a>
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
            <?php echo $this->Form->create('StaffMaster'); ?>                
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
        </div>
    <?php echo $this->Form->end(); ?>
        <div class="pagetop">
                <a href="#page4"><img src="img/pagetop.png"></a>
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
            <?php echo $this->Form->create('StaffMaster'); ?>                
                <table border="1" cellspacing="0" cellpadding="5" width="100%">
                    <tr>
                        <td style='background-color: #e8ffff;width:20%;'>パスワード（２回入力）</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $this->Form->input('password',array('label'=>false,'div'=>false,'value'=>'')); ?>
                            <?php echo $this->Form->input('password2',array('label'=>false,'div'=>false,'value'=>'')); ?>
                        </td>
                    </tr>
                </table>
        </div>
    <?php echo $this->Form->end(); ?>
        <div class="pagetop">
                <a href="#page4"><img src="img/pagetop.png"></a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div>