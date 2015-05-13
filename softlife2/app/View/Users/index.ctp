<br>
<div style="text-align: right;">
<?php print_r($name); ?>さん
<?php print($this->Html->link('ログアウト', 'logout')); ?>
</div>
<HR>
<b>ようこそ！！</b>
<br>
<?php echo $this->Html->link('アカウント情報更新', '/users/edit/'); ?>
<br>
<?php echo $this->Html->link('ユーザー一覧', '/users/view/'); ?>
<br>
<?php echo $this->Html->link('新規ユーザ登録', '/users/add/'); ?>
<br><br>