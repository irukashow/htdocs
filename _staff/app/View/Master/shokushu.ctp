<div style="padding: 15px;height: 900px;">
<?php echo $this->Form->create('Item'); ?>
    
    <div style="float:left;">
        <font style="font-size: 150%;color: red;"><?= $headline ?></font>
    </div>
    <div style="float:right;">
        <a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>
    </div>
    <div style="clear:both;"></div>
<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>
<div style="clear:both;"></div>
<!--- 職種マスタ管理 START --->
<table border="1" width="50%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="left">
  <tr class="col">
    <th width="25%"><font style="color:white;font-weight: normal;">表示順</font></th>
    <th width="10%"><?php echo $this->Paginator->sort('id',"ID");?></th>
    <th width="60%"><?php echo $this->Paginator->sort('value','値');?></th>
    <th width="10%"> </th>
  </tr>
  <tr>
    <td>
        <?php echo $this->Form->input('sequence',array('label'=>false,'div'=>false,'maxlength'=>'3','style'=>'width:30%;padding:3px;')); ?>
    </td>
    <td><?php echo $this->Form->input('id',array('label'=>false,'div'=>false,'maxlength'=>'5','style'=>'width:80%;padding:3px;')); ?></td>
    <td>
        <?php echo $this->Form->input('value',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:97%;padding:3px;')); ?>
        <?php echo $this->Form->input('item',array('type'=>'hidden', 'value' => '16')); ?>
    </td>
    <td align="center">
        <?php echo $this->Form->submit('追　加', array('name' => 'insert','div' => false, 'id' => 'button-create')); ?>
    </td>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <td align="left">
        【<?php echo $data['Item']['sequence']; ?>】
        &nbsp;
        <?php print($this->Html->link('▲', 'shokushu/'.$data['Item']['id'].'/'.$data['Item']['sequence'].'/up', array('style' => 'font-size: 120%;', 'title' => '上へ'))); ?>
        &nbsp;
        <?php print($this->Html->link('▼', 'shokushu/'.$data['Item']['id'].'/'.$data['Item']['sequence'].'/down', array('style' => 'font-size: 120%;', 'title' => '下へ'))); ?>
    </td>  
    <td align="center"><?php echo $data['Item']['id']; ?></td>
    <td><?php echo $data['Item']['value']; ?></td>
    <td align="center">
        <?php echo $this->Form->submit('削　除', array('name' => 'delete['.$data['Item']['id'].']','div' => false, 'id' => 'button-delete')); ?>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<!--- 職種マスタ管理 END --->
<div style="clear:both;"></div>
<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>
    <div style="margin-top: 10px;">
        <a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>
    </div>
<?php echo $this->Form->end(); ?>
</div>