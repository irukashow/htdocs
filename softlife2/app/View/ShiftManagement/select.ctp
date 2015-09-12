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
      height: 200px;
<?php } ?>
      width: 100%;
      margin-top: 5px;
  }
</style>
<style type="text/css" media="screen">
    table {
        font-size: 90%;
        padding: 1px;
    }
    table th {
        font-size: 110%;
    }
</style>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 0px;">

<div style="font-size: 90%;margin-bottom: 0px;">
<?php echo $this->Form->create('StaffMaster', array('name'=>'form')); ?>
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>
<?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $selected_class)); ?>
<?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'display:none;')); ?>
    <!-- 推奨スタッフ -->
    <table border='1' cellspacing="0" cellpadding="1" style='width: 100%;margin-top: 10px;border-spacing: 0px;'>
        <tr>
            <th colspan="3" style='background:#99ccff;text-align: center;'>（１）推奨スタッフ</th>
        </tr>
        <?php if (!empty($recommend_staff2)) { ?>
        <?php foreach ($recommend_staff2 as $key=>$data2) { ?>
        <tr style="background:#ffccff;">
            <td align="center" style="width:15%;">
            <?=$data2['StaffMaster']['id']; ?>
                <input type="hidden" name="staff_id1<?=$key ?>" value="<?=$data2['StaffMaster']['id']; ?>">
            </td>
            <td align="left" style="width:75%;padding:0px 10px 0px 10px;"><?=$data2['StaffMaster']['name']; ?></td>
            <td align="center" style="width:20%;">
                <?php echo $this->Form->submit('選択', 
                        array('name' => 'select['.$data2['StaffMaster']['id'].']', 'id' => 'button-create', 'div' => false, 'style'=>'font-size:110%;padding:2px 15px 2px 15px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr align="center" style="background:#ffccff;">
            <td colspan="3">該当するデータはありません。</td>
        </tr>
        <?php } ?>
    <!-- 前月スタッフ -->
        <tr>
            <th colspan="3" style='background:#99ccff;text-align: center;'>（２）前月スタッフ</th>
        </tr>
        <?php $flag = 0; ?>
        <?php if (!empty($premonth_staff2)) { ?>
        <?php foreach ($premonth_staff2 as $key=>$data) { ?>
        <?php
            if (empty($data)) {
                $flag = 1;
                continue;
            }
        ?>
        <tr style="background:#ffffcc;">
            <td align="center" style="width:15%;">
            <?=$data['StaffMaster']['id']; ?>
                <input type="hidden" name="staff_id2<?=$key ?>" value="<?=$data['StaffMaster']['id']; ?>">
            </td>
            <td align="left" style="width:75%;padding:0px 10px 0px 10px;"><?=$data['StaffMaster']['name']; ?></td>
            <td align="center" style="">
                <?php echo $this->Form->submit('選択', 
                        array('name' => 'select['.$data['StaffMaster']['id'].']', 'id' => 'button-create', 'div' => false, 'style'=>'font-size:110%;padding:2px 15px 2px 15px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php if($flag == 1) { ?>
        <tr align="center" style="background:#ffffcc;">
            <td colspan="3">該当するデータはありません。</td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr align="center" style="background:#ffffcc;">
            <td colspan="3">該当するデータはありません。</td>
        </tr>
        <?php } ?>
    <!-- その他スタッフ -->
        <tr>
            <th colspan="3" style='background:#99ccff;text-align: center;'>（３）シフト希望スタッフ</th>
        </tr>
        <?php $flag = 0; ?>
        <?php if (!empty($data_staff)) { ?>
        <?php foreach ($data_staff as $key=>$data) { ?>
        <?php
            if (empty($data)) {
                $flag = 1;
                continue;
            }
        ?>
        <tr style="background:white;">
            <td align="center" style="width:15%;">
            <?=$data['StaffMaster']['id']; ?>
                <input type="hidden" name="staff_id3<?=$key ?>" value="<?=$data['StaffMaster']['id']; ?>">
            </td>
            <td align="left" style="width:75%;padding:0px 10px 0px 10px;"><?=$data['StaffMaster']['name']; ?></td>
            <td align="center" style="">
                <?php echo $this->Form->submit('選択', 
                        array('name' => 'select['.$data['StaffMaster']['id'].']', 'id' => 'button-create', 'div' => false, 'style'=>'font-size:110%;padding:2px 15px 2px 15px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php if($flag == 1) { ?>
        <tr align="center" style="background:white;">
            <td colspan="3">該当するデータはありません。</td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr align="center" style="background:white;">
            <td colspan="3">該当するデータはありません。</td>
        </tr>
        <?php } ?>
    </table>
    
    <!-- スタッフ検索 -->
    <div class="scroll_div">
    <table border='1' cellspacing="0" cellpadding="1" style='width: 100%;margin-top: 10px;border-spacing: 0px;' _fixedhead="rows:2; cols:1">
        <tr>
            <th colspan="3" style='background:#ccffff;text-align: center;'>追加スタッフ検索</th>
        </tr>
        <tr style="background-color: #ccffff;">
            <td style='text-align: center;' style="width:15%;">氏　名</td>
            <td align="center" style="width:75%;">
                <?php echo $this->Form->input('search_name',array('label'=>false,'div'=>false,'maxlength'=>'30', 'placeholder'=>'漢字、もしくは、ひらがな', 'style'=>'width:95%;padding:3px;')); ?>
            </td>
            <td align="center" style="width:10%;">
                <?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'font-size:110%;padding: 5px 10px;')); ?>
            </td>
        </tr>
        <?php if (!empty($datas1)) { ?>
        <?php foreach ($datas1 as $data1) { ?>
        <tr>
            <td align="center"><?=$data1['StaffMaster']['id']; ?></td>
            <td align="left" style="padding: 0 10px 0 10px;">
                <?=$data1['StaffMaster']['name_sei'].' '.$data1['StaffMaster']['name_mei']; ?>
            </td>
            <td align="center">
                <?php echo $this->Form->submit('選択', 
                        array('name' => 'select['.$data1['StaffMaster']['id'].']', 'id' => 'button-create', 'div' => false, 'style'=>'font-size:110%;padding:3px 15px 3px 15px;')); ?>
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

    <!-- 選択中スタッフ -->
    <table border='1' cellspacing="0" cellpadding="1" style='width: 100%;margin-top: 10px;border-spacing: 0px;'>
        <tr>
            <th colspan="3" style='background:#99ccff;text-align: center;'>選択中スタッフ</th>
        </tr>
        <?php if (!empty($datas2)) { ?>
        <?php foreach ($datas2 as $key=>$data2) { ?>
        <tr>
            <td align="center" style="width:15%;">
            <?=$data2['StaffMaster']['id']; ?>
                <input type="hidden" name="staff_id4<?=$key ?>" value="<?=$data2['StaffMaster']['id']; ?>">
            </td>
            <td align="left" style="width:75%;padding:0px 10px 0px 10px;"><?=$data2['StaffMaster']['name']; ?></td>
            <td align="center">
                <?php echo $this->Form->submit('削除', array('id'=>'button-delete', 
                    'name' => 'erasure['.$data2['StaffMaster']['id'].']', 'div' => false, 'style'=>'font-size:110%;padding:2px 15px 2px 15px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr align="center">
            <td colspan="3">選択済みのデータはありません</td>
        </tr>
        <?php } ?>
    </table>
    
    <div style='margin-top: 10px;margin-left: 10px;'>
<?php print($this->Form->submit('完　了', array('id'=>'button-create', 'div'=>false, 'style'=>'' , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>        
    </fieldset>

</div>