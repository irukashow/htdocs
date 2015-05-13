<h1>送信フォーム・サンプル</h1>
 
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
 
<br />
<hr>
<br />
 
<table>
    <?php
    for($i = 0; $i < count($data); $i++) {
        $arr = $data[$i]['Board'];
        echo "<tr><td>{$arr['id']}</td>";
        echo "<td>{$arr['name']}</td>";
        echo "<td>{$arr['title']}</td>";
        echo "<td>{$arr['content']}</td></tr>";
    }
    ?>
</table>