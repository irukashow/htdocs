<br>
<div style="text-align: right;">
<?php print($this->Html->link('ログアウト', 'logout')); ?>
</div>
<HR>
<b>ようこそ！！</b>
<br>
<?php echo $this->Html->link('ユーザー情報更新', '/users/edit/'); ?>
<br>
<?php echo $this->Html->link('ユーザー一覧', '/account/'); ?>
<br>
<?php echo $this->Html->link('新規ユーザ登録', '/users/add/'); ?>
<br>
<?php echo $this->Html->link('パスワード変更', '/users/passwd/'); ?>
<br><br>