<div style="padding: 15px;">
    <div style="float:left;">
        <font style="font-size: 150%;color: red;"><?= $headline ?></font>
    </div>
    <div style="float:right;">
        <a href='<?=ROOTDIR ?>/admin/'>管理者ページへ戻る</a>
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

<!--- スタッフマスタ更新履歴 START --->
<table id="staff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr class="col">
    <th width="5%"><?php echo $this->Paginator->sort('id',"ID");?></th>
    <th width="10%"><?php echo $this->Paginator->sort('username','更新ユーザーID');?></th>
    <th><?php echo $this->Paginator->sort('name_sei','更新者');?></th>
    <th><?php echo $this->Paginator->sort('class','所属');?></th>
    <th><?php echo $this->Paginator->sort('staff_id','スタッフID');?></th>
    <th><?php echo $this->Paginator->sort('staff_name','スタッフ氏名');?></th>
    <th><?php echo $this->Paginator->sort('status','ステータス');?></th>
    <th><?php echo $this->Paginator->sort('ip_address','IPアドレス');?></th>
    <th><?php echo $this->Paginator->sort('created','記録日時');?></th>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <td align="center"><?php echo $data['LoginLogs']['id']; ?></td>
    <td><?php echo $data['LoginLogs']['username']; ?></td>
    <td><?php echo $data['Users']['name_sei'].' '.$data['Users']['name_mei']; ?></td>
    <?php $class = $data['LoginLogs']['class']; ?>
    <td><?php echo $data_item[2][$class]; ?></td>
    <td><?php echo $data['LoginLogs']['staff_id']; ?></td>
    <td><?php echo $data['LoginLogs']['staff_name']; ?></td>
    <?php $status = $data['LoginLogs']['status']; ?>
    <td><?php echo $data_item[20][$status]; ?></td>
    <td><?php echo $data['LoginLogs']['ip_address']; ?></td>
    <td><?php echo $data['LoginLogs']['created']; ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<!--- スタッフマスタ更新履歴 END --->

<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>
<br>
<a href='<?=ROOTDIR ?>/admin/'>管理者ページへ戻る</a>

</div>