<?php
    function setShokushu($shokushu_ids, $list_arr) {
        $shokushu_ids2 = explode(',', $shokushu_ids);
        $ret = '';
        foreach ($shokushu_ids2 as $value) {
            if (empty($value)) {
                continue;
            }
            if (empty($ret)) {
                $ret = space_trim($list_arr[$value], '');
            } else {
                $ret = $ret.', '.space_trim($list_arr[$value], '');
            }
        }
        return $ret;
    }
    // 全角・半角のスペースを削除
    function space_trim ($str) {
        // 行頭の半角、全角スペースを、空文字に置き換える
        $str = preg_replace('/^[ 　]+/u', '', $str);

        // 末尾の半角、全角スペースを、空文字に置き換える
        $str = preg_replace('/[ 　]+$/u', '', $str);

        return $str;
    }
?>

<div style="width:auto;margin:5px 15px;">
<?php echo $this->Form->create('StaffMaster', array('name' => 'form')); ?>
    <div id="headline" style="padding:5px 10px;">
        ★ スタッフアカウント
        &nbsp;&nbsp;
        <b><font style="font-size:95%;color: yellow;">[アカウント一覧]</font></b>
        &nbsp;&nbsp;&nbsp;
        <input type="submit" name="initiation" id="button-create" value="初期化" onclick="return window.confirm('【注意】アカウントおよびパスワードを初期化します。\nよろしいですか？');">
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
  <tr style="background-color: #45bcd2;">
    <th width="5%"><?php echo $this->Paginator->sort('id',"ID");?></th>
    <th width="15%"><?php echo $this->Paginator->sort('name','氏名');?></th>
    <th width="5%"><?php echo $this->Paginator->sort('account',"スタッフ<br>アカウント", array('escape' => false));?></th>
    <th width="15%"><?php echo $this->Paginator->sort('password','パスワード');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('birthday','生年月日');?></th>
    <th width="20%"><?php echo $this->Paginator->sort('shokushu_shoukai','職種');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('modified','登録日時<br>更新日時', array('escape' => false));?></th>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <td align="center"><?=$data['StaffMaster']['id'] ?></td>
    <td>
        <?=$data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei']; ?>
    </td>
    <td align="center">
        <?php
            if (empty($data['StaffMaster']['account'])) {
                echo '未設定';
            } else {
                echo $data['StaffMaster']['account']; 
            }
        ?>
    </td>
    <td>
        <?php
            if (empty($data['StaffMaster']['password'])) {
                echo '未設定';
            } else {
                echo '設定済'; 
            }
        ?>
    </td>
    <td>
        <?php echo $data['StaffMaster']['birthday']; ?>
    </td>
    <td>
        <?php echo setShokushu($data['StaffMaster']['shokushu_shoukai'], $list_shokushu); ?>
    </td>
    <td>
        <?php echo $data['StaffMaster']['created']; ?><br>
        <?php echo $data['StaffMaster']['modified']; ?>
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

<?php echo $this->Form->end(); ?>
</div>