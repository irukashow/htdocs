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

<div style="padding: 15px;">
    <div style="float:left;">
        <font style="font-size: 150%;color: red;"><?= $headline ?></font>
    </div>
    <div style="float:right;">
        <a href='<?=ROOTDIR ?>/admin/'>ホームへ戻る</a>
    </div>
    <div style="clear:both;"></div>
    
<!-- ページネーション -->
<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>

<!--- スタッフマスタ本体 START --->
<table id="stuff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr class="col">
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
<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>
<!--- スタッフマスタ本体 END --->

<?php echo $this->Form->end(); ?>
<br>
<a href="<?=ROOTDIR ?>/users/index">ホームへ戻る</a>

</div>