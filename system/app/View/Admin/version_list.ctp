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
<?php echo $this->Form->create('VersionRemarks'); ?>

<div style="padding: 15px;">
    <div style="float:left;">
        <font style="font-size: 150%;color: red;"><?= $headline ?></font>
    </div>
    <div style="float:right;">
        <a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>
    </div>
    <div style="clear:both;"></div>
<a href='<?=ROOTDIR ?>/admin/version'>★ 新規投稿 ★</a>
<br>  
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
<table id="staff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr class="col">
    <th width="5%"><?php echo $this->Paginator->sort('id',"No.");?></th>
    <th width="5%"><?php echo $this->Paginator->sort('version_no','バージョン番号');?></th>
    <th width="10%"><?php echo $this->Paginator->sort('status','ステータス');?></th>
    <th width="20%"><?php echo $this->Paginator->sort('title','更新タイトル');?></th>
    <th width="50%"><?php echo $this->Paginator->sort('remarks','更新内容');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('release_date','リリース日');?></th>
  </tr>
  <?php foreach($datas as $data) { ?>
  <tr>
    <td><?php echo $data['VersionRemarks']['id'];?></td>
    <td><?php echo $data['VersionRemarks']['version_no']; ?></td>
    <td><?php echo getStatus($data['VersionRemarks']['status']); ?></td>
    <td>
        <a href="<?=ROOTDIR ?>/admin/version/<?=$data['VersionRemarks']['id'] ?>">
        <?php echo $data['VersionRemarks']['title']; ?>
        </a>
    </td>
    <td><?php echo str_replace("\n","<br />",$data['VersionRemarks']['remarks']); ?></td>
    <td><?php echo $data['VersionRemarks']['release_date']; ?></td>
  </tr>
  <?php } ?>
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
<a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>

</div>