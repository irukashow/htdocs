<?php
    echo $this->Html->css('staffmaster');
?>
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
<!-- 計算 -->
<script>
    function NZ(value) {
        if (!value) {
            ret = 0;
        } else {
            ret = Number(value);
        }
        return ret;
    }
    function sum1() {
        // 売上金額合計
        value1 = NZ(document.getElementById("SalesSalarySales").value);
        value2 = NZ(document.getElementById("SalesSalaryOffhours1").value);
        value3 = NZ(document.getElementById("SalesSalaryAdjustment1").value);
        value4 = NZ(document.getElementById("SalesSalaryEtc1").value);
        value5 = NZ(document.getElementById("SalesSalaryTransportation1").value);
        document.getElementById("SalesSalaryTotal1").value = value1+value2+value3+value4+value5;
    }
    function sum2() {
        // 給与金額小計
        value1 = NZ(document.getElementById("SalesSalarySalary").value);
        value2 = NZ(document.getElementById("SalesSalaryOffhours2").value);
        value3 = NZ(document.getElementById("SalesSalaryAdjustment2").value);
        value4 = NZ(document.getElementById("SalesSalaryEtc2").value);
        document.getElementById("SalesSalarySum").value = value1+value2+value3+value4;
        // 給与金額合計
        value5 = NZ(document.getElementById("SalesSalaryTransportation2").value);
        document.getElementById("SalesSalaryTotal2").value = value1+value2+value3+value4+value5;
    }
</script>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 5px;">
        <?php
            if (empty($id) || $id == 0) {
                $status = '新規';
            } else {
                $status = '更新';
            }
        ?>
        <legend style="font-size: 150%;color: red;"><?php echo __('売上給与登録<font color=gray> （'.$status.'）</font>'); ?></legend>
<?php echo $this->Form->create('SalesSalary', array('name'=>'form')); ?>
<?php echo $this->Form->submit('検索', array('name' => 'search','style' => 'display:none;')); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $id)); ?>
<?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $selected_class)); ?>
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>

        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: -10px;margin-bottom: 0px;border-spacing: 0px;font-size: 90%;">
            <tr>
                <th style='background:#99ccff;text-align: center;' colspan="2">項目</th>
                <th style='background:#99ccff;text-align: center;'>入力内容</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">№</td>
                <td>
                    <?php
                        if ($id == 0) {
                            echo '新規';
                        } else {
                            echo $id;
                        }                     
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">勤務日付</td>
                <td>
                    <?php echo $this->Form->input('work_date',array('type'=>'text', 'label'=>false, 'class'=>'date', 'div'=>false, 'style'=>'width:100px;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="2">勤務者</td>
                <td style='background-color: #e8ffff;width:20%;'>所属</td>
                <td>
                    <?php $division_arr = array('1'=>'スタッフ', '2'=>'社員', '3'=>'ベルサンテ'); ?>
                    <?php echo $this->Form->input('division',array('type'=>'select', 'label'=>false, 'div'=>false, 
                        'options'=>$division_arr, 'onchange'=>'form.submit();')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>氏名</td>
                <td>
                    <?php echo $this->Form->input('staff_id',array('type'=>'select', 'label'=>false, 'div'=>'', 'options'=>$name_arr, 'empty'=>'氏名を選択してください', 'style'=>'')); ?>
                    or
                    <?php echo $this->Form->input('name', array('type'=>'text', 'label' => false, 'div'=>false, 'placeholder'=>'氏名（直接入力）', 'style' => 'width:200px;')); ?><br>
                    ↑ｽﾀｯﾌ絞込
                    <?php echo $this->Form->input('search_name', array('type'=>'text', 'label' => false, 
                        'div'=>false, 'placeholder'=>'氏名（漢字 or かな）', 'style' => 'width:200px;margin-top:5px;background-color:#FFFFDD;')); ?>
                    <span style="font-size: 90%;">※入力後、Enterキー</span>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">
                    物件・現場①
                    <button type="button" style="cursor: pointer;" 
                            onclick="window.open('<?=ROOTDIR ?>/SalesSalary/property_info','物件情報','width=800,height=700,scrollbars=yes');">物件情報</button>
                </td>
                <td>
                    <?php echo $this->Form->input('case_id',array('type'=>'select', 
                        'label'=>false, 'div'=>false, 'options' => $list_case3, 'empty' => '現場を選択してください', 'style'=>'width:85%;')); ?>
                    <button name="select_case" onchange="form.submit();">選択</button><br>
                    ↑現場絞込
                    <?php echo $this->Form->input('search_case', array('type'=>'text', 
                        'label' => false, 'div'=>false, 'placeholder'=>'現場', 'style' => 'width:200px;margin-top:5px;background-color:#FFFFDD;')); ?>
                    <span style="font-size: 90%;">※入力後、Enterキー</span>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">勤務時間</td>
                <td>
                    <?php echo $this->Form->input('work_time_from',array('type'=>'text', 'label'=>false, 'div'=>false, 'value'=>$datas2['PropertyList']['work_time_from'], 'style'=>'width:50px;')); ?>
                    ～
                    <?php echo $this->Form->input('work_time_to',array('type'=>'text', 'label'=>false, 'div'=>false, 'value'=>$datas2['PropertyList']['work_time_to'], 'style'=>'width:50px;')); ?>
                    <span>※入力例）9:00</span>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="7">売上金額<br><button type="button" onclick="sum1();">計算</button></td>
                <td style='background-color: #e8ffff;width:20%;'>売上</td>
                <td>
                    <?php echo $this->Form->input('sales',array('type'=>'text', 'label'=>false, 'div'=>false, 'value'=>$datas2['PropertyList']['sales'], 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>時間外費</td>
                <td>
                    <?php echo $this->Form->input('offhours_1',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>遅刻早退</td>
                <td>
                    <?php echo $this->Form->input('adjustment_1',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>その他</td>
                <td>
                    <?php echo $this->Form->input('etc_1',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>交通費</td>
                <td>
                    <?php echo $this->Form->input('transportation_1',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>合計</td>
                <td>
                    <?php echo $this->Form->input('total_1',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>備考</td>
                <td>
                    <?php echo $this->Form->input('remarks_1',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:95%;text-align:left;')); ?>
                </td>
            </tr>
            <!-- 給与金額 -->
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="8">給与金額<br><button type="button" onclick="sum2();">計算</button></td>
                <td style='background-color: #e8ffff;width:20%;'>給与</td>
                <td>
                    <?php echo $this->Form->input('salary',array('type'=>'text', 'label'=>false, 'div'=>false, 'value'=>$datas2['PropertyList']['salary'], 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>時間外費</td>
                <td>
                    <?php echo $this->Form->input('offhours_2',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>遅刻早退</td>
                <td>
                    <?php echo $this->Form->input('adjustment_2',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>その他</td>
                <td>
                    <?php echo $this->Form->input('etc_2',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>小計</td>
                <td>
                    <?php echo $this->Form->input('sum',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>交通費</td>
                <td>
                    <?php echo $this->Form->input('transportation_2',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>合計</td>
                <td>
                    <?php echo $this->Form->input('total_2',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:100px;text-align:right;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>備考</td>
                <td>
                    <?php echo $this->Form->input('remarks_2',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:95%;text-align:left;')); ?>
                </td>
            </tr>
        </table>
    </fieldset>  
    <div style='margin-left: 10px;'>
        <input name="register" type="submit" value="登録する">
<?php echo $this->Form->submit('削　除', array('name' => 'delete','div' => false, 'id'=>'button-delete', 'style'=>'margin-left:10px;', 'onclick'=>'return confirm("登録を削除しますか？")')); ?>
<?php print($this->Html->link('閉 じ る', 'javascript:void(0);', array('id'=>'button-delete', 'style'=>'margin-left:10px;', 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
<?php print($this->Form->submit('入力クリア', array('name' => 'clear', 'id'=>'clear', 'div'=>false, 'style'=>'margin-left:10px;', 'onclick'=>'window.location.reload();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>
