<?php
    echo $this->Html->script('fixed_midashi');
?>
<script>
onload = function() {
    FixedMidashi.create();
    document.getElementById('StaffMasterSearchName').focus();
}
// 閉じる時の親画面の制御
function doSubmit() {
window.opener.doReload();
//window.opener.location = "<?=ROOTDIR ?>/ShiftManagement/schedule_new2/limit:<?=$limit ?>/page:<?=$page ?>/hidden:<?=$hidden ?>?date=<?=$date ?>&point=true";
window.close();
}
</script>
<style type="text/css" media="screen">
  div.scroll_div { 
      overflow: auto;
<?php if (empty($datas1)) { ?>
      height: auto;
<?php } else { ?>
      height: 250px;
<?php } ?>
      width: 100%;
      margin-top: 5px;
  }
</style>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 5px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('スタッフ選択'); ?></legend>

<div style="font-size: 90%;margin-bottom: 0px;">
<?php echo $this->Form->create('StaffMaster', array('name'=>'form')); ?>
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>
<?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $selected_class)); ?>
<?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'display:none;')); ?>
    
    <!-- 選択済みスタッフ -->
    <table border='1' cellspacing="0" cellpadding="2" style='width: 100%;margin-top: 0px;border-spacing: 0px;'>
        <tr>
            <th colspan="3" style='background:#99ccff;text-align: center;'>選択済みスタッフ</th>
        </tr>
        <?php if (!empty($datas2)) { ?>
        <?php foreach ($datas2 as $key=>$data2) { ?>
        <tr style="background-color: #ddffff;">
            <td align="center" style="width:15%;">
                <?php
                    $id = $data2['id'];
                    if (strstr($id, 'u')) {
                        echo '社員 ('.$id.')';
                    } else {
                        echo $id;
                    }
                ?>
                <input type="hidden" name="staff_id<?=$key ?>" value="<?=$data2['id']; ?>">
            </td>
            <td align="left" style="width:75%;padding:0px 10px 0px 10px;"><?=$data2['name']; ?></td>
            <td align="center">
                <?php echo $this->Form->submit('削除', array('id'=>'button-delete', 
                    'name' => 'erasure['.$data2['id'].']','div' => false, 'style'=>'padding: 3px 15px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr align="center">
            <td colspan="3">選択済みのスタッフはいません</td>
        </tr>
        <?php } ?>
    </table>
    
    <!-- スタッフ検索 -->
    <div class="scroll_div">
    <table border='1' cellspacing="0" cellpadding="2" style='width: 100%;margin-top: 0px;border-spacing: 0px;' _fixedhead="rows:2; cols:1">
        <tr>
            <th colspan="3" style='background:#99ccff;text-align: center;'>スタッフ検索</th>
        </tr>
        <tr style="background-color: #ffffcc;">
            <td style='text-align: center;' style="width:15%;">氏　名</td>
            <td align="center" style="width:75%;">
                <?php echo $this->Form->input('search_name',array('label'=>false,'div'=>false,'maxlength'=>'30', 'placeholder'=>'漢字、もしくは、ひらがな', 'style'=>'width:95%;padding:3px;')); ?>
            </td>
            <td align="center" style="width:10%;"><?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'id' => '')); ?></td>
        </tr>
        <?php if (!empty($datas1)) { ?>
        <?php foreach ($datas1 as $data1) { ?>
        <tr>
            <td align="center"><?=$data1['StaffMaster']['id']; ?></td>
            <td align="left" style="padding: 0 10px 0 10px;">
                <?=$data1['StaffMaster']['name']; ?>
            </td>
            <td align="center">
                <?php echo $this->Form->submit('選　択', 
                        array('name' => 'select['.$data1['StaffMaster']['id'].']', 'id' => 'button-create', 'div' => false, 'style'=>'padding:5px 10px 5px 10px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td colspan="3" align="center">該当するデータはありません。</td>
        </tr>
        <?php } ?>
    </table>
    </div>
    
    <!-- 社員選択 -->
    <table border='1' cellspacing="0" cellpadding="2" style='width: 100%;margin-top: 10px;border-spacing: 0px;'>
        <tr>
            <th colspan="3" style='background:#99ccff;text-align: center;'>社員から選択</th>
        </tr>
        <tr style="background-color: #ffffcc;">
            <td style='text-align: center;' style="width:15%;">氏　名</td>
            <td align="center" style="width:75%;">
                <?php echo $this->Form->input('select_user',array('label'=>false,
                    'div'=>false,'options'=>$user_arr, 'empty'=>array(''=>'選択してください'), 'style'=>'width:95%;padding:3px;')); ?>
            </td>
            <td align="center" style="width:10%;"><?php echo $this->Form->submit('選　択', array('name' => 'select2', 'div' => false, 'id' => 'button-create')); ?></td>
        </tr>
    </table>
        
    <div style='margin-top: 10px;margin-left: 10px;' class="check">
<?php echo $this->Form->submit('決定する', array('name' => 'decision','div' => false, 'onclick' => '')); ?>
    &nbsp;&nbsp;
<?php print($this->Form->input('閉 じ る', array('type'=>'button', 'label'=>false,
    'id'=>'button-delete', 'name' => 'close', 'div' => false, 'onclick'=>'doSubmit();', 'style' => 'cursor:pointer;'))); ?>
    </div>
<?php echo $this->Form->end(); ?>        
    </fieldset>

</div>
        