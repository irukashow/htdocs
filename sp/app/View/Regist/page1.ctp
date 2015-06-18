<?php
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('https://ajaxzip3.github.io/ajaxzip3.js');
?>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 10px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('スタッフ登録 （その１）'); ?></legend>
        <div style="font-size: 110%;">
            <font color=blue>登録情報</font>&nbsp;>>&nbsp;基本情報
        </div>
<?php echo $this->Form->create('StaffPreregist'); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden')); ?> 
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th style='background:#99ccff;text-align: center;' colspan="2">項目</th>
                <th style='background:#99ccff;text-align: center;' colspan='3'>入力内容</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">メールアドレス<font color="red">*</font><br>※ログインIDとして使用します。</td>
                <td colspan="2">
                    <?php echo $this->Form->input('email1',array('label'=>false,'div'=>false,'style'=>'width:80%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">パスワード<font color="red">*</font><br>※２回入力</td>
                <td colspan="2">
                    <?php echo $this->Form->input('password',array('type' => 'password', 'label'=>false,'div'=>false, 'value' => '', 'style'=>'width:60%;margin-bottom:5px;')); ?><br>
                    <?php echo $this->Form->input('password2',array('type' => 'password', 'label'=>false,'div'=>false, 'value' => '', 'style'=>'width:60%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">その他のメールアドレス（任意）</td>
                <td colspan="2">
                    <?php echo $this->Form->input('email2',array('label'=>false,'div'=>false,'style'=>'width:80%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">登録場所<font color="red">*</font></td>
                <td colspan="2">
                    <?php  
                        $select2=array(''=>'','1'=>'大阪','2'=>'東京','3'=>'名古屋');
                        echo $this->Form->input( 'area', array( 'label'=>false,'type' => 'select', 
                            'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select2));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">雇用形態</td>
                <td colspan="2">
                    <?php  
                        $select2=array(''=>'','1'=>'正社員','2'=>'契約社員','3'=>'人材派遣スタッフ');
                        echo $this->Form->input( 'employment_status', array( 'label'=>false,'type' => 'select', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select2));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">氏名（漢字）<font color="red">*</font></td>
                <td colspan="2">
                    <?php echo $this->Form->input('name_sei',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                    <?php echo $this->Form->input('name_mei',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">氏名（フリガナ）<font color="red">*</font></td>
                <td colspan="2">
                    <?php echo $this->Form->input('name_sei2',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                    <?php echo $this->Form->input('name_mei2',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">性別<font color="red">*</font></td>
                <td colspan="2">
                    <?php  
                        $select3=array('1'=>'女性','2'=>'男性');
                        echo $this->Form->input( 'gender', array( 'label'=>false,'type' => 'radio', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select3));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">生年月日<font color="red">*</font></td>
                <td colspan="2">
                    <?php echo $this->Form->input('birthday',array('label'=>false,'div'=>false,'dateFormat' => 'YMD', 'maxYear' => date('Y'), 'minYear' => date('Y')-100, 'monthNames' => false, 'onchange'=>'calculateAge();')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="6">住所</td>
                <!-- 住所 Start -->
                <td style='background-color: #e8ffff;width:20%;'>郵便番号<font color="red">*</font></td>
                <td>
                    <?php echo $this->Form->input('zipcode1',
                            array('label'=>false,'div'=>false,'maxlength'=>'3','style'=>'width:12%;')); ?>&nbsp;-
                    <?php echo $this->Form->input('zipcode2',
                            array('label'=>false,'div'=>false,'maxlength'=>'4','style'=>'width:16%;',
                                'onKeyUp'=>"AjaxZip3.zip2addr('data[StaffPreregist][zipcode1]',this,'data[StaffPreregist][address1]','data[StaffPreregist][address2]','data[StaffPreregist][address3]','data[StaffPreregist][address4]');")); ?>
                            <br><font size="2">※住所を町村名まで自動で入力します。</font>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>都道府県<font color="red">*</font></td>
                <td>
                    <?php echo $this->Form->input('address1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'（都道府県）', 'options'=>$pref_arr)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>市区郡（町村）<font color="red">*</font></td>
                <td>
                    <?php echo $this->Form->input('address2',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:90%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>町村名<font color="red">*</font></td>
                <td>
                    <?php echo $this->Form->input('address3',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:90%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>番地<font color="red">*</font></td>
                <td>
                    <?php echo $this->Form->input('address4',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:90%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>その他（建物名）</td>
                <td>
                    <?php echo $this->Form->input('address5',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:90%;')); ?>
                </td>
            </tr>
            <!-- 住所 End -->
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">電話番号（メイン）<font color="red">*</font></td>
                <td colspan="2">
                    <?php echo $this->Form->input('telno1',array('label'=>false,'div'=>false,'style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' colspan="2">電話番号（その他）</td>
                <td colspan="2">
                    <?php echo $this->Form->input('telno2',array('label'=>false,'div'=>false,'style'=>'width:30%;')); ?>
                </td>
            </tr>   
        </table>
    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('次 へ 進む ', array('name' => 'submit','div' => false)); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>
