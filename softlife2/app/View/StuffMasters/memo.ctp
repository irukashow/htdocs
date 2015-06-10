<?php
    echo $this->Html->css('stuffmaster');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="<?=ROOTDIR ?>/css/main.css" />
</head>
    <body style="width:535px;background-color: white;margin-top: 0px;margin-left: 0px;">
<?php echo $this->Form->create('StuffMemo'); ?>
<div style="">
<table border='1' cellspacing="0" cellpadding="2" style="width:100%;margin: 0px 0px 10px 0px;border-spacing: 0px;">
    <tr>
        <td colspan="2" style='background-color: #e8ffff;color:black;'>メモ一覧</td>
    </tr>
    <tr>
        <td align="center" style="width:80%;">
            <?php echo $this->Form->input('memo',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:97%;padding:3px;')); ?>
            <?php echo $this->Form->input('username',array('type'=>'hidden', 'value' => $username)); ?>
            <?php echo $this->Form->input('class',array('type'=>'hidden', 'value' => $class)); ?>
            <?php echo $this->Form->input('stuff_id',array('type'=>'hidden', 'value' => $id)); ?>
        </td>
        <td align="center"><?php echo $this->Form->submit('書き込み', array('name' => 'comment','div' => false, 'id' => 'button-create')); ?></td>
    </tr>
    <?php foreach ($memo_datas as $mdata) { ?>
    <tr>
        <td align="left" style='color:black;padding: 0 10px 0 10px;'>
            <?=$mdata['StuffMemo']['memo'] ?>
        </td>
        <td align="center"><?php echo $this->Form->submit('削　除', array('name' => 'delete['.$mdata['StuffMemo']['id'].']', 'div' => false, 'id' => 'button-delete')); ?></td>
    </tr>
    <?php } ?>
</table>
</div>
<?php echo $this->Form->end(); ?>
</body>
</html>