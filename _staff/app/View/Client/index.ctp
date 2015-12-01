<?php
    // ユーザー区分
    function getRole($val) {
        if ($val == 'admin') {
            $ret = '管理者';
        } elseif ($val == 'user') {
            $ret = '一般ユーザー';
        }
        return $ret;
    }
    
?>

<?php echo $this->Form->create('Client', array('name' => 'form', 'onsubmit'=>'return confirm("本当に削除しますか？");')); ?>
<div style="padding: 15px;">
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
<div style="float:right;">
    ページ数：
    <?php
        echo $this->paginator->counter(array('format' => '<b>%page%</b> / <b>%pages%</b>'));
    ?>
    &nbsp;&nbsp;&nbsp;
    <?php echo $this->Paginator->counter(array('format' => __('総件数：  <b>{:count}</b> 件')));?>
</div>
<!--- ユーザー一覧 START --->
<table border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr class="col">
      <th width="3%"><?php echo $this->Paginator->sort('id',"ID");?></th>
    <th width="7%"><?php echo $this->Paginator->sort('username',"責任者<br>アカウント", array('escape' => false));?></th>
    <th width="13%"><?php echo $this->Paginator->sort('name','氏名');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('corp_name','会社名');?></th>
    <th><?php echo $this->Paginator->sort('busho_name','部署');?></th>
    <th><?php echo $this->Paginator->sort('position','役職');?></th>
    <th><?php echo $this->Paginator->sort('class','属性');?></th> 
    <th width="13%"><font style="color: white;font-weight: normal;">変更</font></th>
    <th width="15%"><?php echo $this->Paginator->sort('modified','登録日時<br>更新日時', array('escape' => false));?></th>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
      <td align="center"><?=$data['Client']['id'] ?></td>
    <td align="left">
        <?php echo '<a href="'.ROOTDIR.'/client/account/'.$data['Client']['id'].'" onclick="">'.$data['Client']['username']."</a>"; ?>
    </td>
    <td>
        <?php echo '<a href="'.ROOTDIR.'/client/account/'.$data['Client']['id'].'" onclick="">'.$data['Client']['name_sei'].' '.$data['Client']['name_mei']."</a>"; ?>
    </td>
    <td>
        <?php echo $data['Client']['corp_name']; ?>
    </td>
    <td>
        <?php echo $data['Client']['busho_name']; ?>
    </td>
    <td>
        <?php echo $data['Client']['position']; ?>
    </td>
    <td>
        <?php echo $getValue[$data['Client']['class']]; ?>
    </td>
    <td align="center">
        <?php echo $this->Html->link('氏名/ﾊﾟｽ','passwd2/'.$data['Client']['id'], array('target'=>'', 'id'=>'button-create')); ?>
        <?php echo $this->Form->submit('削除', array('name' => 'delete['.$data['Client']['id'].']', 'div' => false, 'style' => 'margin:0px; padding:5px 15px 5px 15px;')); ?>
    </td>
    <td>
        <?php echo $data['Client']['created']; ?><br>
        <?php echo $data['Client']['modified']; ?>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
<!--- ユーザー一覧 END --->

<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>
<br>
<div style="margin-top: 5px;">
    <a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>
</div>

</div>
<?php echo $this->Form->end(); ?>