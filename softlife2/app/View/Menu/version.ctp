<?php
    // ステータス
    function getStatus($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '緊急';
        } elseif ($value == 2) {
            $ret = '通常更新';
        } elseif ($value == 3) {
            $ret = 'マイナー更新';
        }
        return $ret;
    }

?>
<?php echo $this->Form->create('Menu'); ?>

<!-- ページネーション -->
<div class="pageNav03" style="margin: 10px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
 </div>

<!--- スタッフマスタ本体 START --->
<table id="stuff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr>
      <th><?php echo $this->Paginator->sort('id',"No.");?></th>
      <th><?php echo $this->Paginator->sort('version_no','バージョン番号');?></th>
      <th><?php echo $this->Paginator->sort('status','ステータス');?></th>
      <th><?php echo $this->Paginator->sort('title','更新タイトル');?></th>
    <th><?php echo $this->Paginator->sort('remarks','更新内容');?></th>
    <th><?php echo $this->Paginator->sort('release_date','リリース日');?></th>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <td><?php echo $data['Menu']['id'];?></td>
    <td><?php echo $data['Menu']['version_no']; ?></td>
    <td><?php echo getStatus($data['Menu']['status']); ?></td>
    <td><?php echo $data['Menu']['title']; ?></td>
    <td><?php echo str_replace("\n","<br />",$data['Menu']['remarks']); ?></td>
    <td><?php echo $data['Menu']['release_date']; ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<!-- ページネーション -->
<div class="pageNav03" style="margin: 10px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
 </div>
<!--- スタッフマスタ本体 END --->

<?php echo $this->Form->end(); ?>

<a href="/softlife2/users/index">ホームへ戻る</a>
