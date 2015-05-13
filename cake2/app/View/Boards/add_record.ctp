<h1>送信フォーム・サンプル</h1>
<?php echo $this->Html->link('投稿・一覧', array('controller' => 'boards', 'action' => '.')); ?>
 
<h2>登録・更新</h2>
<?php
echo $this->Form->create('Board', array('type' => 'post', 'action' => 'addRecord'));
echo $this->Form->label('Board.id', 'ID');
echo $this->Form->text('Board.id');
echo $this->Form->input('Board.name', array('label' => '名前'));
echo $this->Form->input('Board.title', array('label' => 'タイトル'));
echo $this->Form->input('Board.content', array('label' => '内容'));
echo $this->Form->submit('送信');
echo $this->Form->end();
?>