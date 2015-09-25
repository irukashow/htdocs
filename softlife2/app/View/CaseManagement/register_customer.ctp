<?php
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->css('staffmaster');
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
<script>
/**
 * カタカナをひらがなに変換
 */
function setHiraKana(element) {
    element.value = element.value.replace(/[ァ-ン]/g, function(s) {
       return String.fromCharCode(s.charCodeAt(0) - 0x60);
    });    
}
</script>

<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>

<div style="width:80%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 5px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('取引先登録'); ?></legend>

<?php echo $this->Form->create('Customer'); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $customer_id)); ?>
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>
<?php echo $this->Form->input('kaijo_flag', array('type'=>'hidden', 'value' => $flag)); ?>
<?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $selected_class)); ?>

        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;margin-bottom: 10px;border-spacing: 0px;">
            <tr>
                <th style='background:#99ccff;text-align: center;' colspan='4'>取引先情報</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>企業名</td>
                <td colspan="2">
                    <?php echo $this->Form->input('corp_name',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:70%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>企業名（かな）</td>
                <td colspan="2">
                    <?php echo $this->Form->input('corp_name_kana',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:70%;', 'onchange'=>'setHiraKana(this)')); ?>
                    （『株式会社』を除く）
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' rowspan="6">会社住所</td>
                <!-- 住所 Start -->
                <td style='background-color: #e8ffff;width:20%;'>郵便番号</td>
                <td>
                    <?php echo $this->Form->input('zipcode1',
                            array('label'=>false,'div'=>false,'maxlength'=>'3','style'=>'width:9%;',
                                'onKeyUp'=>"AjaxZip3.zip2addr(this,'data[Customer][zipcode2]','data[Customer][address1]','data[Customer][address2]','data[Customer][address3]','data[Customer][address4]');")); ?>&nbsp;-
                    <?php echo $this->Form->input('zipcode2',
                            array('label'=>false,'div'=>false,'maxlength'=>'4','style'=>'width:12%;',
                                'onKeyUp'=>"AjaxZip3.zip2addr('data[Customer][zipcode1]',this,'data[Customer][address1]','data[Customer][address2]','data[Customer][address3]','data[Customer][address4]');")); ?>
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
                <td style='background-color: #e8ffff;width:20%;'>部署／担当者</td>
                <td colspan="2">
                    <?php echo $this->Form->input('busho',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:40%;')); ?>
                    ／
                    <?php echo $this->Form->input('tantou',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>電話番号</td>
                <td colspan="2">
                    <?php echo $this->Form->input('telno',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:40%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>FAX</td>
                <td colspan="2">
                    <?php echo $this->Form->input('faxno',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:40%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メールアドレス</td>
                <td colspan="2">
                    <?php echo $this->Form->input('email',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:70%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>弊社担当者</td>
                <td colspan="2">
                    <?php echo $this->Form->input('contact',array('type'=>'select', 'label'=>false,'div'=>false,'empty'=>'','style'=>'width:20%;', 'options'=>$name_arr)); ?>
                </td>
            </tr>
            
            <tr>
                <th style='background:#99ccff;text-align: center;' colspan='4'>請求先の場合は記入</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>請求書の締日</td>
                <td colspan="2">
                    <?php echo $this->Form->input('bill_cutoff',array('type'=>'text', 'label'=>false,'div'=>false, 'style'=>'width:50%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>請求書の到着期限</td>
                <td colspan="2">
                    <?php echo $this->Form->input('bill_arrival',array('type'=>'text', 'label'=>false,'div'=>false,'style'=>'width:50%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>請求書の送付先</td>
                <td colspan="2">
                    <?php echo $this->Form->input('bill_destination',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:95%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;' rowspan="3">振込口座情報</td>
                <td style='background-color: #e8ffff;width:20%;'>銀行名・支店</td>
                <td>
                    <?php echo $this->Form->input('kouza_bank',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:60%;')); ?>&nbsp;
                    <?php echo $this->Form->input('kouza_shiten',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:35%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>口座番号</td>
                <td>
                    <?php
                        $list = array('1'=>'普通', '2'=>'当座');
                        echo $this->Form->input('kouza_type',array('type'=>'radio', 'legend'=>false,'div'=>false,'options'=>$list));
                    ?>&nbsp;&nbsp;
                    <?php echo $this->Form->input('kouza_num',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:30%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>口座名義</td>
                <td>
                    <?php echo $this->Form->input('kouza_meigi',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:60%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>備考</td>
                <td colspan="2">
                    <?php echo $this->Form->input('remarks',array('label'=>false,'div'=>false,'maxlength'=>'50','style'=>'width:95%;')); ?>
                </td>
            </tr>
        </table>
    </fieldset>  
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
&nbsp;&nbsp;
<?php $comment = __('本当に登録解除してよろしいですか？', true); ?>
<?php echo $this->Form->submit('登録解除', array('name' => 'release', 'id' => 'button-release', 'div' => false, 'onclick' => 'return confirm("'.$comment.'");')); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('閉 じ る', 'javascript:void(0);', array('id'=>'button-delete', 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>