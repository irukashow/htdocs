<?php
    function getInfoStatus($val) {
        if ($val == 1) {
            $ret = '<font color=red>緊急</font>';
        } elseif ($val == 2) {
            $ret = '<font color=green>お知らせ</font>';
        }else {
            $ret = 'その他';
        }
        return $ret;
    }
?>
<div style="padding: 15px;">
    <div style="float:left;">
        <font style="font-size: 150%;color: red;"><?= $headline ?></font>
    </div>
    <div style="float:right;">
        <a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>
    </div>
    <div style="clear:both;"></div>
<a href='<?=ROOTDIR ?>/admin/admin_info'>★ 新規投稿 ★</a>
<br>
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
    <th width="5%"><?php echo $this->Paginator->sort('username','更新ユーザーID');?></th>
    <th width="10%"><?php echo $this->Paginator->sort('version_no','対応バージョン');?></th>
    <th width="10%"><?php echo $this->Paginator->sort('status','ステータス');?></th>
    <th width="40%"><?php echo $this->Paginator->sort('title','タイトル');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('created','記録日時');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('modified','更新日時');?></th>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <td align="center"><?php echo $data['AdminInfo']['id']; ?></td>
    <td align="center"><?php echo $data['AdminInfo']['username']; ?></td>
    <td align="center"><?php echo $data['AdminInfo']['version_no']; ?></td>
    <td><?php echo getInfoStatus($data['AdminInfo']['status']); ?></td>
    <td><a href="<?=ROOTDIR ?>/admin/admin_info/<?=$data['AdminInfo']['id'] ?>"><?php echo $data['AdminInfo']['title']; ?></a></td>
    <td><?php echo $data['AdminInfo']['created']; ?></td>
    <td><?php echo $data['AdminInfo']['modified']; ?></td>
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
<a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>

</div>