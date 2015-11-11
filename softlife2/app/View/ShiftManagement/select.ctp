<?php
    echo $this->Html->script('fixed_midashi');
?>
<?php
// 優先順位で色分け
function setBgcolor($point) {
    if (empty($point)) {
        $ret = 'white';
        return $ret;
    }
    if ($point == 3) {
        $ret = '#ff99cc';
    } elseif ($point == 2) {
        $ret = '#ffcccc';
    } elseif ($point == 1) {
        $ret = '#ffffcc';
    } else {
        $ret = 'white';
    }
    return $ret;
}
// 紹介可能職種コード（カンマ区切り）から職種名称
function setShokushu($shokushu_ids, $list_arr) {
    $ret = '';
    if (empty($shokushu_ids)) {
        return $ret;
    }
    $shokushu_arr = explode(',', $shokushu_ids);
    foreach($shokushu_arr as $key=>$value) {
        if (empty($value)) {
            continue;
        }
        if (empty($ret)) {
            $ret = trim(mb_convert_kana($list_arr[$value], "s", 'UTF-8'));
        } else {
            $ret = $ret.', '.trim(mb_convert_kana($list_arr[$value], "s", 'UTF-8'));
        }
    }
    return $ret;
}
?>
<script>
onload = function() {
    FixedMidashi.create();
    document.getElementById('content').style.padding = '20px 10px';
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
  div.scroll_div2 { 
      overflow: auto;
<?php if (empty($datas)) { ?>
      height: auto;
<?php } else { ?>
      height: 400px;
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
        <div style="font-size: 150%;color: red;float: left;">スタッフ選択 ～ <?=$month ?>月<?=$day ?>日 (<?=$week ?>) ～</div>
        <div style='float:right;'>
        <?php print($this->Form->submit('完　了', array('id'=>'button-create', 'div'=>false, 'style'=>'' , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
        </div>
        <div style="clear:both;"></div>

<div style="font-size: 90%;margin-bottom: 0px;margin-top: 5px;">
<?php echo $this->Form->create('StaffMaster', array('name'=>'form')); ?>
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>
<?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $selected_class)); ?>
<?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'display:none;')); ?>
    
   <!-- 選択中スタッフ -->
    <table border='1' cellspacing="0" cellpadding="1" style='width: 100%;margin-top: 0px;border-spacing: 0px;'>
        <tr>
            <th colspan="3" style='background:#99ccff;text-align: center;'>保存済スタッフ</th>
        </tr>
        <?php if (!empty($datas2)) { ?>
        <?php foreach ($datas2 as $key=>$data2) { ?>
        <tr style="background-color: #ddffff;">
            <td align="center" style="width:20%;">
            <?=$data2['StaffMaster']['id']; ?>
                <input type="hidden" name="staff_id4<?=$key ?>" value="<?=$data2['StaffMaster']['id']; ?>">
            </td>
            <td align="left" style="width:70%;padding:0px 10px 0px 10px;">
            <?php
                echo '<span style="font-size:120%;">'.$data2['StaffMaster']['name'].'</span>'; 
                if (!empty($datas22[$key]['StaffSchedule']['conditions'])) {
                    echo '<span style="color:red;margin-left:10px;">【条件あり】'.$datas22[$key]['StaffSchedule']['conditions'].'</span>';
                }
            ?>
            </td>
            <td align="center">
                <?php echo $this->Form->submit('削除', array('id'=>'button-delete', 
                    'name' => 'erasure['.$data2['StaffMaster']['id'].']', 'div' => false, 'style'=>'font-size:110%;padding:2px 15px 2px 15px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <?php
                if (empty($data_ap)) {
                    $checked = '';
                    $bgcolor = '';
                } elseif (empty($data_ap['WorkTable']['ap'.$day])) {
                    $checked = '';
                    $bgcolor = '';
                } else{
                    $checked = 'checked';
                    $bgcolor = 'background-color:rgb(255, 204, 102);';
                }
            ?>
            <td align="center" style="padding-top:5px;<?=$bgcolor ?>">
                <input type="checkbox" name="data[StaffMaster][appointment]" value="1" style="margin-left: 20px;vertical-align: -5px;" <?=$checked ?>>
                <font style="margin-left:-30px;">待ち合わせ</font>
            </td>
            <td align="center">
                <?php
                    if (empty($data_ap['WorkTable']['ap'.$day])) {
                        $memo = '';
                    } elseif ($data_ap['WorkTable']['ap'.$day] == 1) {
                        $memo = '';
                    } else {
                        $memo = $data_ap['WorkTable']['ap'.$day];
                    }
                    echo $this->Form->input('appointment_memo',
                        array('label'=>false,'div'=>false,'maxlength'=>'30', 'placeholder'=>'待ち合わせメモ', 
                            'style'=>'width:95%;padding:3px;', 'value'=>$memo)); 
                ?>
            </td>
            <td align="center">
                <?php echo $this->Form->submit('登録', array('id'=>'button-create', 
                    'name' => 'register['.$data2['StaffMaster']['id'].']', 'div' => false, 'style'=>'font-size:110%;padding:4px 15px;')); ?>
            </td>
        </tr>
        <?php } else { ?>
        <tr align="center">
            <td colspan="3">保存済スタッフのデータはありません。</td>
        </tr>
        <?php } ?>
    </table>
   <span style="font-size: 90%;">※待ち合わせは、シフトの保存を行ってから入力してください。</span>
   
    <!-- シフト希望スタッフ -->
    <div class="scroll_div2" style="height: 300px;">
    <table border='1' cellspacing="0" cellpadding="1" style='width: 100%;margin-top: 10px;border-spacing: 0px;' _fixedhead="rows:1;">
        <tr>
            <th colspan="4" style='background:#99ccff;text-align: center;'>シフト希望スタッフ</th>
        </tr>
        <?php $flag = 0; ?>
        <?php if (!empty($request_staffs)) { ?>
        <?php foreach ($request_staffs as $key=>$data) { ?>
        <?php
            if (empty($data)) {
                $flag = 1;
                continue;
            }
        ?>
        <?php $point_arr = explode(',', $data['StaffSchedule']['point']); ?>
        <tr style="background:<?=setBgcolor($point_arr[$col-1]) ?>;">
            <td align="center" style="width:20%;">
            <?=$data['StaffSchedule']['staff_id']; ?>
                <input type="hidden" name="staff_id3<?=$key ?>" value="<?=$data['StaffSchedule']['staff_id']; ?>">
            </td>
            <td align="left" style="padding: 0 10px 0 10px;width: 35%;">
            <?=$data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei']; ?> (<?=$point_arr[$col-1]; ?>)
            </td>
            <td align="left" style="padding: 0 10px 0 10px;width: 35%;">
                <?=setShokushu($data['StaffMaster']['shokushu_shoukai'], $shokushu_arr); ?>
            </td>
            <td align="center" style="width: 10%;">
                <?php echo $this->Form->submit('選択', 
                        array('name' => 'select['.$data['StaffSchedule']['staff_id'].']', 'id' => 'button-create', 'div' => false, 'style'=>'font-size:110%;padding:2px 15px 2px 15px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
        <!-- シフト希望スタッフ（条件付き） -->
        <?php if (!empty($request_staffs2)) { ?>
        <?php foreach ($request_staffs2 as $key=>$data) { ?>
        <?php
            if (empty($data)) {
                $flag = 1;
                continue;
            }
        ?>
        <?php $point_arr = explode(',', $data['StaffSchedule']['point']); ?>
        <tr style="background:<?=setBgcolor($point_arr[$col-1]) ?>;">
            <td align="center" style="width:20%;">
            <?=$data['StaffSchedule']['staff_id']; ?>
                <input type="hidden" name="staff_id3<?=$key ?>" value="<?=$data['StaffSchedule']['staff_id']; ?>">
            </td>
            <td align="left" style="width:35%;padding:0px 10px 0px 10px;">
                <?=$data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei']; ?> (<?=$point_arr[$col-1]; ?>)<br>
                <span style="color:red;font-weight: bold;text-shadow: 1px 1px 3px white,-1px 1px 3px white,1px -1px 3px white,-1px -1px 3px white;">【条件あり】<?=$data['StaffSchedule']['conditions']; ?></span>
            </td>
            <td align="left" style="padding: 0 10px 0 10px;width: 35%;">
                <?=setShokushu($data['StaffMaster']['shokushu_shoukai'], $shokushu_arr); ?>
            </td>
            <td align="center" style="">
                <?php echo $this->Form->submit('選択', 
                        array('name' => 'select['.$data['StaffSchedule']['staff_id'].']', 'id' => 'button-create', 'div' => false, 'style'=>'font-size:110%;padding:2px 15px 2px 15px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>
        <?php if($flag == 2) { ?>
        <tr align="center" style="background:white;">
            <td colspan="4">該当するデータはありません。</td>
        </tr>
        <?php } ?>
    </table>
    </div>

    <!-- スタッフ検索 -->
    <div class="scroll_div">
    <table border='1' cellspacing="0" cellpadding="1" style='width: 100%;margin-top: 10px;border-spacing: 0px;' _fixedhead="rows:2; cols:1">
        <tr>
            <th colspan="4" style='background:#ccffff;text-align: center;'>追加スタッフ検索</th>
        </tr>
        <tr style="background-color: #ccffff;">
            <td style='text-align: center;' style="width:20%;">氏　名</td>
            <td align="center" colspan="2" style="width:70%;">
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
            <td align="left" style="padding: 0 10px 0 10px;width: 50%;">
                <?=setShokushu($data1['StaffMaster']['shokushu_shoukai'], $shokushu_arr); ?>
            </td>
            <td align="center">
                <?php echo $this->Form->submit('選択', 
                        array('name' => 'select['.$data1['StaffMaster']['id'].']', 'id' => 'button-create', 'div' => false, 'style'=>'font-size:110%;padding:3px 15px 3px 15px;')); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td colspan="4" align="center">該当するデータはありません。</td>
        </tr>
        <?php } ?>
    </table>
    </div>
    
    <div style='margin-top: 10px;margin-left: 10px;'>
<?php print($this->Form->submit('完　了', array('id'=>'button-create', 'div'=>false, 'style'=>'' , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>        
    </fieldset>
</div>
        