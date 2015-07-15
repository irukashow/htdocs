<?php
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('station4');
?>
<?php require('reg1_element.ctp'); ?>

<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
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
        <legend style="font-size: 150%;color: red;"><?php echo __('案件登録<font color=gray> （基本情報）</font>'); ?></legend>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
        <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;>>&nbsp;
            オーダー情報&nbsp;>>&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;>>&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>">オーダー情報</a>&nbsp;>>&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg3/<?=$case_id ?>/<?=$koushin_flag ?>">契約書情報</a>&nbsp;
        </font>
        
<?php } ?>
        <!-- ページ選択 END -->
<?php echo $this->Form->create('CaseManagement', array('name'=>'form')); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $case_id)); ?>
<?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $selected_class)); ?>
<?php echo $this->Form->input('update_user', array('type'=>'hidden', 'value' => $username)); ?>

        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;margin-bottom: 10px;border-spacing: 0px;">
            <tr>
                <th style='background:#99ccff;text-align: center;' colspan="2">項目</th>
                <th style='background:#99ccff;text-align: center;'>入力内容</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">案件名称</td>
                <td>
                    <?php echo $this->Form->input('case_name',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:95%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">新規登録日</td>
                <td>
                    <?php
                        if (!empty($data)) {
                            echo date('Y-m-d', strtotime($data['CaseManagement']['created']));
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">更新登録日</td>
                <td>
                    <?php
                        if (!empty($data)) {
                            echo date('Y-m-d', strtotime($data['CaseManagement']['modified']));
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">担当者（所属・氏名）</td>
                <td>
                <?php echo $this->Form->input('username',array('type'=>'select', 'label'=>false,'div'=>false,'empty'=>'担当者を選択してください', 
                                        'options'=>$name_arr, 'style'=>'width:70%;padding:5px;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">契約形態</td>
                <td>
                    <?php $list0 = array('1'=>'派遣契約　', '2'=>'請負契約　'); ?>
                    <?php echo $this->Form->input('contract_type',array('type'=>'radio', 'legend'=>false, 'div'=>false, 'options'=>$list0)); ?> 
                </td>
            </tr>
            <!-- 依頼主 -->
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="5">依頼主</td>
                <td style='background-color: #e8ffff;width:20%;'>企業名<br>部署・担当者</td>
                <td>
                    <table>
                        <tr>
                            <td width="95%">
                    <?php echo $this->Form->input('client',array('type'=>'select', 'label'=>false,'div'=>'display: inline; ','empty'=>'依頼主を選択してください', 
                        'options'=>$customer_arr, 'style'=>'width:100%;padding:5px;')); ?>
                            </td>
                            <td>
                    <?php echo $this->Form->submit('選 択',array('div'=>'display: inline; ', 'name'=>'select_client','id'=>'button-create', 'label'=>false)); ?>
                            </td>
                        </tr>
                    </table>
                    <?php $list = array('1'=>'事業主　', '2'=>'請求先　', '0' => 'その他　'); ?>
                    <?php echo $this->Form->input('kubun1',array('type'=>'radio', 'legend'=>false, 'div'=>false, 'options'=>$list)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>郵便番号<br>住所</td>
                <td>
                    <?php
                        if (!empty($data_client)) {
                            echo '〒'.$data_client['Customer']['zipcode1'].'-'.$data_client['Customer']['zipcode2'];
                            echo '<br>';
                            echo $data_client['Customer']['address1_2'].$data_client['Customer']['address2']
                                    .$data_client['Customer']['address3'].$data_client['Customer']['address4'].'&nbsp;'.$data_client['Customer']['address5'];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>TEL</td>
                <td>
                    <?php
                        if (!empty($data_client)) {
                            echo $data_client['Customer']['telno'];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>FAX</td>
                <td>
                    <?php
                        if (!empty($data_client)) {
                            echo $data_client['Customer']['faxno'];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メールアドレス</td>
                <td>
                    <?php
                        if (!empty($data_client)) {
                            echo $data_client['Customer']['email'];
                        }
                    ?>
                </td>
            </tr>
            <!-- 依頼主 END -->
            <tr>
                <td colspan="2" style='background-color: #e8ffff;width:20%;'>事業主</td>
                <td>
                    <table width="100%">
                        <tr>
                            <td>
                    <?php echo $this->Form->input('entrepreneur1',array('type'=>'select', 'label'=>false,'div'=>'display: inline; ','empty'=>'事業主を選択してください', 
                        'options'=>$customer_arr, 'style'=>'width:100%;padding:5px;')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                    <?php echo $this->Form->input('entrepreneur2',array('type'=>'select', 'label'=>false,'div'=>'display: inline; ','empty'=>'事業主を選択してください', 
                        'options'=>$customer_arr, 'style'=>'width:100%;padding:5px;')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                    <?php echo $this->Form->input('entrepreneur3',array('type'=>'select', 'label'=>false,'div'=>'display: inline; ','empty'=>'事業主を選択してください', 
                        'options'=>$customer_arr, 'style'=>'width:100%;padding:5px;')); ?>
                            </td>
                            <td>

                            </td>
                        </tr>
                    </table>
                    <?php echo $this->Form->input('kubun2',array('type'=>'checkbox', 'label'=>'請求先', 'style'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style='background-color: #e8ffff;width:20%;'>開始日</td>
                <td>
                    <?php echo $this->Form->input('start_date',array('type'=>'text', 'label'=>false,'div'=>false, 'class'=>'date', 'style'=>'width:20%;')); ?>
                </td>
            </tr>
            <!-- 就業場所 -->
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="9">就業場所</td>
                <td style='background-color: #e8ffff;width:20%;'>名称</td>
                <td><?php echo $this->Form->input('work_place',array('type'=>'textarea', 'label'=>false,'div'=>false, 'rows'=>3, 'style'=>'width:95%;')); ?></td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>部署</td>
                <td><?php echo $this->Form->input('busho',array('type'=>'text', 'label'=>false,'div'=>false, 'style'=>'width:95%;')); ?></td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>
                    郵便番号<br>住所
                </td>
                <td>
                    〒<?php echo $this->Form->input('zipcode1',
                            array('label'=>false,'div'=>false,'maxlength'=>'3','style'=>'width:6%;',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'data[CaseManagement][zipcode2]','data[CaseManagement][address]','data[CaseManagement][address]');")); ?>&nbsp;-
                    <?php echo $this->Form->input('zipcode2',
                            array('label'=>false,'div'=>false,'maxlength'=>'4','style'=>'width:8%;',
                                'onKeyUp'=>"AjaxZip3.zip2addr('data[CaseManagement][zipcode1]',this,'data[CaseManagement][address]','data[CaseManagement][address]');")); ?>
                            &nbsp;&nbsp;<font size="2">※住所を町村名まで自動で入力します。</font><br>
                    <?php echo $this->Form->input('address',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:95%;margin-top:5px;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>TEL・FAX</td>
                <td>
                    <?php echo $this->Form->input('telno',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:30%;')); ?>
                    <?php echo $this->Form->input('faxno',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>指揮命令者・役職</td>
                <td>
                    <?php echo $this->Form->input('director',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:30%;')); ?>
                    <?php echo $this->Form->input('position',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>最寄駅①</td>
                <td colspan="6">
                    <?php echo $this->Form->input('pref1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
                        'onChange'=>'setMenuItem1(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
                    →              
                    <?php echo $this->Form->input('s0_1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'路線を選択してください', 'style' => 'width: 200px;', 
                        'onChange'=>'setMenuItem1(1,this[this.selectedIndex].value)', 'options' => $line1)); ?>
                                        →               
                    <?php echo $this->Form->input('s1_1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;', 'options' => $station1)); ?>
                                        駅
                    <?php echo $this->Form->input('s2_1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;display:none;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>最寄駅②</td>
                <td colspan="6">
                    <?php echo $this->Form->input('pref2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
                        'onChange'=>'setMenuItem2(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
                    →
                    <?php echo $this->Form->input('s0_2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'路線を選択してください', 'style' => 'width: 200px;', 
                        'onChange'=>'setMenuItem2(1,this[this.selectedIndex].value)', 'options' => $line2)); ?>
                                        →
                    <?php echo $this->Form->input('s1_2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;', 'options' => $station2)); ?>
                                        駅
                    <?php echo $this->Form->input('s2_2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;display:none;')); ?>
                    </select> 
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>最寄駅③</td>
                <td colspan="6">
                    <?php echo $this->Form->input('pref3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
                        'onChange'=>'setMenuItem3(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
                    →
                    <?php echo $this->Form->input('s0_3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'路線を選択してください', 'style' => 'width: 200px;', 
                        'onChange'=>'setMenuItem3(1,this[this.selectedIndex].value)', 'options' => $line3)); ?>
                                        →
                    <?php echo $this->Form->input('s1_3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;', 'options' => $station3)); ?>
                                        駅
                    <?php echo $this->Form->input('s2_3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;display:none;')); ?>
                    </select> 
                </td>
            </tr
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>現場長<br>携帯・メールアドレス</td>
                <td>
                    <?php echo $this->Form->input('leader',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:50%;')); ?><br>
                    <?php echo $this->Form->input('mobile',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:30%;margin-top:5px;')); ?>
                    <?php echo $this->Form->input('email',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:50%;')); ?>
                </td>
            </tr>
            <!-- 就業場所 END -->
            <!-- 請求先① -->
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="6">請求先①</td>
                <td style='background-color: #e8ffff;width:20%;'>企業名<br>部署・担当者</td>
                <td>
                    <table>
                        <tr>
                            <td width="95%">
                    <?php echo $this->Form->input('billing_destination',array('type'=>'select', 'label'=>false,'div'=>'display: inline; ','empty'=>'請求先を選択してください', 
                        'options'=>$customer_arr, 'style'=>'width:100%;padding:5px;')); ?>
                            </td>
                            <td>
                    <?php echo $this->Form->submit('選 択',array('div'=>'display: inline; ', 'name'=>'select_billing', 'id'=>'button-create', 'label'=>false)); ?>
                            </td>
                        </tr>
                    </table>
                    <?php $list = array('1'=>'事業主　', '2'=>'請求先　', '0' => 'その他　'); ?>
                    <?php echo $this->Form->input('kubun3',array('type'=>'radio', 'legend'=>false, 'div'=>false, 'options'=>$list)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>郵便番号<br>住所</td>
                <td>
                    <?php
                        if (!empty($data_billing)) {
                            echo '〒'.$data_billing['Customer']['zipcode1'].'-'.$data_billing['Customer']['zipcode2'];
                            echo '<br>';
                            echo $data_billing['Customer']['address1_2'].$data_billing['Customer']['address2']
                                    .$data_billing['Customer']['address3'].$data_billing['Customer']['address4'].'&nbsp;'.$data_billing['Customer']['address5'];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>TEL</td>
                <td>
                    <?php
                        if (!empty($data_billing)) {
                            echo $data_billing['Customer']['telno'];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>FAX</td>
                <td>
                    <?php
                        if (!empty($data_billing)) {
                            echo $data_billing['Customer']['faxno'];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メールアドレス</td>
                <td>
                    <?php
                        if (!empty($data_billing)) {
                            echo $data_billing['Customer']['email'];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>振込口座情報</td>
                <td>
                    <?php
                        if (!empty($data_billing)) {
                            echo $data_billing['Customer']['kouza_bank'].'&nbsp;&nbsp;'.$data_billing['Customer']['kouza_shiten'].'<br>';
                            echo '名義：'.$data_billing['Customer']['kouza_meigi'].'<br>';
                            echo '締日：'.$data_billing['Customer']['bill_cutoff'].'&nbsp;&nbsp;&nbsp;&nbsp;請求書到着日：'.$data_billing['Customer']['bill_arrival'].'<br>';
                            echo '備考：'.$data_billing['Customer']['remarks'];
                        }
                    ?>
                </td>
            </tr>
            <!-- 請求先① END -->
        </table>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
            <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;>>&nbsp;
            オーダー情報&nbsp;>>&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;>>&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>">オーダー情報</a>&nbsp;>>&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg3/<?=$case_id ?>/<?=$koushin_flag ?>">契約書情報</a>&nbsp;
        </font>
        
<?php } ?>
        <!-- ページ選択 END -->
    </fieldset>  
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('閉 じ る', 'javascript:void(0);', array('id'=>'button-delete', 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>