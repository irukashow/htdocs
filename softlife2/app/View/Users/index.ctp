<div style="float: right;">
<?php print($this->Html->link('ログアウト', 'logout')); ?>
</div>
<br>
<b>ようこそ！！</b>
<br>
<?php echo $this->Html->link('ユーザー情報更新', '/users/edit/'); ?>
<br>
<?php echo $this->Html->link('ユーザー一覧', '/account/'); ?>
<br>
<?php echo $this->Html->link('新規ユーザ登録', '/users/add/'); ?>
<br>
<?php echo $this->Html->link('パスワード変更', '/users/passwd/'); ?>
<br>
<?php echo $this->Html->link('ログイン履歴', '/loginlog/'); ?>
<br><br>