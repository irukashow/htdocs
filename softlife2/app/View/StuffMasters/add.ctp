<?php
echo $this->Html->script('jquery-1.9.1');
echo $this->Html->script('ajaxzip2/ajaxzip2');
?>

<div style="width:80%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('スタッフ登録 （その１）'); ?></legend>
<?php echo $this->Form->create('StuffMaster'); ?>

        <table style="width:100%;">
            <tr>
                <th>項目名</th>
                <th>入力内容</th>
            </tr>
            <tr>
                <td>登録担当者</td>
                <td>
                    <?php  
                        $select1=array(''=>'','1'=>'担当者A','2'=>'担当者B','3'=>'担当者C');
                        echo $this->Form->input( 'tantou', array( 'label'=>false,'type' => 'select', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select1));
                    ?>
                </td>
            </tr>
            <tr>
                <td>雇用形態</td>
                <td>
                    <?php  
                        $select2=array(''=>'','1'=>'派遣','2'=>'業務委託','3'=>'紹介');
                        echo $this->Form->input( 'employment_status', array( 'label'=>false,'type' => 'select', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select2));
                    ?>
                </td>
            </tr>
            <tr>
                <td>氏名</td>
                <td>
                    <?php echo $this->Form->input('name_sei',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                    <?php echo $this->Form->input('name_mei',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td>氏名（フリガナ）</td>
                <td>
                    <?php echo $this->Form->input('name_sei2',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                    <?php echo $this->Form->input('name_mei2',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td>性別</td>
                <td>
                    <?php  
                        $select3=array('1'=>'女性','2'=>'男性');
                        echo $this->Form->input( 'gender', array( 'label'=>false,'type' => 'radio', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select3));
                    ?>
                </td>
            </tr>
            <tr>
                <td>生年月日</td>
                <td><?php echo $this->Form->input('birthday',array('label'=>false,'div'=>false,'dateFormat' => 'YMD', 'maxYear' => date('Y'), 'minYear' => date('Y')-100, 'monthNames' => false)); ?></td>
            </tr>
            <tr>
                <td>住所</td>
                <td>
                    <!-- 住所 Start -->
                    <table>
                        <tr>
                            <td>郵便番号</td>
                            <td>
                                <?php echo $this->Form->input('zipcode',
                                        array('label'=>false,'div'=>false,'maxlength'=>'7','style'=>'width:40%;',
                                            'onKeyUp'=>"AjaxZip2.zip2addr(this,'data[StuffMaster][address1]','data[StuffMaster][address2]',null,'strt');")); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>都道府県</td>
                            <td>
                                <?php echo $this->Form->input('address1',array('type'=>'select','label'=>false,'div'=>false, 'options'=>$pref_arr)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>市区郡（町村）</td>
                            <td>
                                <?php echo $this->Form->input('address2',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:80%;')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>町村名</td>
                            <td>
                                <?php echo $this->Form->input('address3',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:80%;')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>番地</td>
                            <td>
                                <?php echo $this->Form->input('address4',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:80%;')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>その他（建物名）</td>
                            <td>
                                <?php echo $this->Form->input('address5',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:100%;')); ?>
                            </td>
                        </tr>
                    </table>
                    <!-- 住所 End -->
                </td>
            </tr>
            <tr>
                <td>電話番号１</td>
                <td>
                    <?php echo $this->Form->input('telno1',array('label'=>false,'div'=>false,'style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td>電話番号２</td>
                <td>
                    <?php echo $this->Form->input('telno2',array('label'=>false,'div'=>false,'style'=>'width:30%;')); ?>
                </td>
            </tr> 
            <tr>
                <td>メールアドレス１</td>
                <td>
                    <?php echo $this->Form->input('email1',array('label'=>false,'div'=>false,'style'=>'width:50%;')); ?>
                </td>
            </tr>
            <tr>
                <td>メールアドレス２</td>
                <td>
                    <?php echo $this->Form->input('email2',array('label'=>false,'div'=>false,'style'=>'width:50%;')); ?>
                </td>
            </tr>  
        </table>


    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('次へ進む', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('キャンセル', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>