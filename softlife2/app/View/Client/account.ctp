<?php
    echo $this->Html->script('jquery-1.9.1');
?>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 0px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('アカウント登録（現場責任者）'); ?></legend>
<?php echo $this->Form->create('Client'); ?>
        <?php echo $this->Form->input('id', array('type'=>'hidden')); ?>
        <?php echo $this->Form->input('member_id', array('type'=>'hidden', 'value' => $username)); ?>

        <table border='1' cellspacing="0" cellpadding="5" style="width:90%;margin-top: 10px;margin-bottom: 10px;border-spacing: 0px;">
            <tr>
                <th style='background:#99ccff;text-align: center;'>項目</th>
                <th style='background:#99ccff;text-align: center;' colspan='3'>入力内容</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>アカウント</td>
                <td colspan="2">
                    <?php echo $this->Form->input('username',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>所属</td>
                <td colspan="2">
                    <?php echo $this->Form->input('class',array('type'=>'select', 'label'=>false,'div'=>false,
                        'style'=>'width:20%;', 'empty'=>array(''=>'所属を選択してください'), 'options'=>$class_arr)); ?>
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
                <td style='background-color: #e8ffff;width:20%;'>会社名</td>
                <td colspan="2">
                    <?php  
                        echo $this->Form->input( 'corp_name', array( 'label'=>false,'type' => 'text', 'div'=>false, 'style' =>'width:40%;'));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>所属部署</td>
                <td colspan="2">
                    <?php  
                        echo $this->Form->input( 'busho_name', array( 'label'=>false,'type' => 'text', 'div'=>false, 'style' =>'width:40%;'));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>役職</td>
                <td colspan="2">
                    <?php  
                        echo $this->Form->input( 'position', array( 'label'=>false,'type' => 'text', 'div'=>false, 'style' =>'width:40%;'));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' rowspan="6">住所</td>
                <!-- 住所 Start -->
                <td style='background-color: #e8ffff;width:20%;'>郵便番号</td>
                <td>
                    <?php echo $this->Form->input('zipcode1',
                            array('label'=>false,'div'=>false,'maxlength'=>'3','style'=>'width:6%;',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'data[Client][zipcode2]','data[Client][address1]','data[Client][address2]','data[Client][address3]','data[Client][address4]');")); ?>-
                    <?php echo $this->Form->input('zipcode2',
                            array('label'=>false,'div'=>false,'maxlength'=>'4','style'=>'width:8%;',
                                'onKeyUp'=>"AjaxZip3.zip2addr('data[Client][zipcode1]',this,'data[Client][address1]','data[Client][address2]','data[Client][address3]','data[Client][address4]');")); ?>
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
                    <?php echo $this->Form->input('email1',array('label'=>false,'div'=>false,'style'=>'width:60%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メールアドレス２</td>
                <td colspan="2">
                    <?php echo $this->Form->input('email2',array('label'=>false,'div'=>false,'style'=>'width:60%;')); ?>
                </td>
            </tr>
        </table>
    </fieldset>  
    <div style='margin-left: 0px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('キャンセル', 'index', array('id'=>'button-delete'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>