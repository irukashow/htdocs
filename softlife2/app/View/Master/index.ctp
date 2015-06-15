<div style="padding: 15px;height: 700px;">
    
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
    <th width="15%"><?php echo $this->Paginator->sort('item',"Item");?></th>
    <th width="15%"><?php echo $this->Paginator->sort('id',"ID");?></th>
    <th width="60%"><?php echo $this->Paginator->sort('value','値');?></th>
    <th width="20%"> </th>
  </tr>
  <tr class="col">
    <?php echo $this->Form->create('Item0', array('name' => 'form')); ?>
      <td colspan="4">
        <?php echo $this->Form->input('item',array('type' => 'select', 'label'=>false,'div'=>false,'style'=>'width:30%;padding:3px;', 
            'onchange' => 'form.submit();', 'options' => $list_item)); ?>
    </td>
    <?php echo $this->Form->end(); ?>
  </tr>
  <tr>
    <?php echo $this->Form->create('Item'); ?>
    <td><?php echo $this->Form->input('item',array('label'=>false,'div'=>false,'maxlength'=>'5','style'=>'width:90%;padding:3px;')); ?></td>
    <td><?php echo $this->Form->input('id',array('label'=>false,'div'=>false,'maxlength'=>'5','style'=>'width:90%;padding:3px;')); ?></td>
    <td>
        <?php echo $this->Form->input('value',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:97%;padding:3px;')); ?>
    </td>
    <td align="center">
        <?php echo $this->Form->submit('追　加', array('name' => 'insert','div' => false, 'id' => 'button-create')); ?>
    </td>
    <?php echo $this->Form->end(); ?>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <?php echo $this->Form->create('Item2'); ?>
    <td><?php echo $data['Item']['item']; ?></td>
    <td><?php echo $data['Item']['id']; ?></td>
    <td><?php echo $data['Item']['value']; ?></td>
    <td align="center">
        <?php echo $this->Form->input('item', array('type'=>'hidden', 'value' => $data['Item']['item'])); ?>
        <?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $data['Item']['id'])); ?>
        <?php echo $this->Form->submit('削　除', array('name' => 'delete','div' => false, 'id' => 'button-delete')); ?>
    </td>
    <?php echo $this->Form->end(); ?>
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
</div>