<?php
    echo $this->Html->script('fixed_midashi');
?>
<script>
onload = function() {
    FixedMidashi.create();
    document.getElementById('StaffMasterSearchName').focus();
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
                <?=$data1['StaffMaster']['name_sei'].' '.$data1['StaffMaster']['name_mei']; ?>
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

    <!-- 選択済みスタッフ -->
    <table border='1' cellspacing="0" cellpadding="2" style='width: 100%;margin-top: 10px;border-spacing: 0px;'>
        <tr>
            <th colspan="3" style='background:#99ccff;text-align: center;'>追加済みスタッフ</th>
        </tr>
        <?php if (!empty($datas2)) { ?>
        <?php foreach ($datas2 as $key=>$data2) { ?>
        <tr>
            <td align="center" style="width:15%;">
            <?=$data2['StaffMaster']['id']; ?>
                <input type="hidden" name="staff_id<?=$key ?>" value="<?=$data2['StaffMaster']['id']; ?>">
            </td>
            <td align="left" style="padding:0px 10px 0px 10px;"><?=$data2['StaffMaster']['name']; ?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr align="center">
            <td colspan="2">選択済みのデータはありません</td>
        </tr>
        <?php } ?>
    </table>
        
    <div style='margin-top: 10px;margin-left: 10px;'>
<?php print($this->Html->link('追　加', 'javascript:void(0);', array('id'=>'button-create', 'style'=>'padding:12px;' , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    &nbsp;&nbsp;
<?php echo $this->Form->submit('消　去', array('id'=>'button-delete', 'name' => 'erasure','div' => false, 'onclick' => 'return confirm("消去してもよろしいですか？");')); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('閉じる', 'javascript:void(0);', array('id'=>'button-delete', 'style'=>'' , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>        
    </fieldset>

</div>
        