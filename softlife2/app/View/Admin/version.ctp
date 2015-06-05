<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('station');

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

<div style="width:50%;margin-top: 20px;margin-left: auto; margin-right: auto;">
<?php echo $this->Form->create('Admin'); ?>
    <fieldset style="border:none;margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('バージョン情報入力ページ'); ?></legend>

        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
            <tr>
                <th style='background:#99ccff;text-align: center;'>項目</th>
                <th style='background:#99ccff;text-align: center;'>入力内容</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>バージョン</td>
                <td>
                    <?php echo $this->Form->input('version_no',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:20%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>種別</td>
                <td>
                    <?php  
                        $select1=array(''=>'','1'=>'緊急','2'=>'通常更新','3'=>'マイナー更新');
                        echo $this->Form->input( 'status', array( 'label'=>false,'type' => 'select', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select1));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>更新タイトル</td>
                <td>
                    <?php echo $this->Form->input('title',array('label'=>false,'div'=>false,'style'=>'width:70%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>リリース日付</td>
                <td>
                    <?php echo $this->Form->input('release_date',array('type'=>'text','div'=>false,'label'=>false, 'class'=>'date', 'style'=>'width:20%;text-align: left;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>バージョン更新内容<br />（詳細）</td>
                <td>
                    <?php echo $this->Form->input('remarks',array('type' => 'textarea','label'=>false,'div'=>false,'style'=>'width:90%;', 'rows' => '10')); ?>
                </td>
            </tr> 
        </table>


    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('キャンセル', './index', array('id'=>'button-delete'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>
