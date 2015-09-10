<?php
    echo $this->Html->css('log');
?>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ 案件管理
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/CaseManagement/index" target=""><font Style="font-size:95%;">案件一覧</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/CaseManagement/customer" target="" onclick=''><font Style="font-size:95%;">取引先一覧</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <b><font Style="font-size:95%;color: yellow;">[職種マスタ]</font></b>
</div>
<!-- 見出し１ END -->

<div style="height: 900px;">
<?php echo $this->Form->create('Item'); ?>
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
<table border="1" width="60%" cellspacing="0" cellpadding="2" bordercolor="#333333" align="left">
  <tr class="col">
    <th width="20%"><font style="color:white;font-weight: normal;">表示順</font></th>
    <th width="10%"><?php echo $this->Paginator->sort('id',"ID");?></th>
    <th width="70%"><?php echo $this->Paginator->sort('value','値');?></th>
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
<?php echo $this->Form->end(); ?>
</div>