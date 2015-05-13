ログイン済み：<?php print($this->request->data('username')); ?>さん<br />
<?php print($this->Html->link('ログアウト', 'logout')); ?>

<b>ようこそ！！</b>
<br>
<br>
<?php echo $this->Html->link('ログイン画面', '/users/login/'); ?>
<br>
<?php echo $this->Html->link('ログアウト', '/users/logout/'); ?>
<br>
<?php echo $this->Html->link('アカウント情報更新', '/users/edit/'); ?>
<br>
<?php echo $this->Html->link('新規ユーザ登録', '/users/add/'); ?>