<div style="padding: 15px;">
    <font style="font-size: 150%;color: red;"><?= $headline ?></font><br>

<?php
    echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
?>

<!--- ログイン履歴 START --->
<table id="stuff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr>
    <th><?php echo $this->Paginator->sort('id',"ID");?></th>
    <th><?php echo $this->Paginator->sort('imgdat','ユーザーID');?></th>
    <th><?php echo $this->Paginator->sort('name_sei','氏名');?></th>
    <th><?php echo $this->Paginator->sort('age','ステータス');?></th>
    <th><?php echo $this->Paginator->sort('tantou','IPアドレス');?></th>
    <th><?php echo $this->Paginator->sort('ojt_date','記録日時');?></th>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <td align="center"><?php echo $data['LoginLogs']['id']; ?></td>
    <td><?php echo $data['LoginLogs']['username']; ?></td>
    <td><?php echo $data['Users']['name_sei'].' '.$data['Users']['name_mei']; ?></td>
    <td><?php echo $data['LoginLogs']['status']; ?></td>
    <td><?php echo $data['LoginLogs']['ip_address']; ?></td>
    <td><?php echo $data['LoginLogs']['created']; ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<!--- ログイン履歴 END --->

<?php
    echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
?>

</div>