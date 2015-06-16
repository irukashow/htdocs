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
<script type="text/javascript">
<!--
function mySubmit(username) {
    // フォームの生成
    var form = document.createElement("form");
    form.setAttribute("action", '<?=ROOTDIR ?>/users/edit');
    form.setAttribute("method", "post");
    form.setAttribute("name", "User");
    form.style.display = "none";
    document.body.appendChild(form);
    // パラメタの設定
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'username');
    input.setAttribute('value', username);
    form.appendChild(input);

    form.submit();        // submit する
}
// -->
</script>

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

<!--- ユーザー一覧 START --->
<table border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr class="col">
    <th width="7%"><?php echo $this->Paginator->sort('username',"ユーザーID");?></th>
    <th width="13%"><?php echo $this->Paginator->sort('name','氏名');?></th>
    <th><?php echo $this->Paginator->sort('area','エリア');?></th>
    <th><?php echo $this->Paginator->sort('role','ユーザーの種類');?></th>
    <th><?php echo $this->Paginator->sort('auth','閲覧権限');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('modified','更新日時');?></th>
    <th width="15%"><?php echo $this->Paginator->sort('created','登録日時');?></th>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <td align="center"><?php echo '<a href="#" onclick="mySubmit('.$data['User']['username'].')">'.$data['User']['username']."</a>"; ?></td>
    <td><?php echo '<a href="#" onclick="mySubmit('.$data['User']['username'].')">'.$data['User']['name_sei'].' '.$data['User']['name_mei']."</a>"; ?></td>
    <?php $area = $data['User']['area']; ?>
    <td><?php echo $getValue[1][$area]; ?></td>
    <td><?php echo getRole($data['User']['role']); ?></td>
    <?php $auth_array = explode(',', $data['User']['auth']); ?>
    <td>
        <?php
            $auth = '';
            $i = 0;
            foreach ($auth_array as $val) {
                if (!empty($val)) {
                    if (empty($auth)) {
                        $auth = $getValue[2][$val];
                    } else {
                        if ($i%2 == 0) {
                            $auth = $auth.', '.$getValue[2][$val];
                        } else {
                            $auth = $auth.'<br>'.$getValue[2][$val];
                        }
                    }
                }
                $i += 1;
            }
            echo $auth;
        ?>
    </td>
    <td><?php echo $data['User']['modified']; ?></td>
    <td><?php echo $data['User']['created']; ?></td>
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
<a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>

</div>

<?php $this->log($auth_array, LOG_DEBUG); ?>