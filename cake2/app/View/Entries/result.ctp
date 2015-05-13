<?php if(!empty($data)): ?>
    <?php echo $this->Html->tag('h2','この情報で登録して大丈夫ですか?'); ?>
    名前: <?php echo $data['User']['firstname']; ?>
        <?php echo $data['User']['lastname']; ?>
        <?php echo $this->Html->tag('br'); ?>
 
    性別: <?php echo $data['User']['sex']; ?>
        <?php echo $this->Html->tag('br'); ?>
    学年: <?php echo $data['User']['grade']; ?>
        <?php echo $this->Html->tag('br'); ?>
    好きなもの:
    <?php foreach($data['User']['like'] as $key => $value):?>
    <?php echo $value; ?>
    <?php endforeach; ?>
        <?php echo $this->Html->tag('br'); ?>
    コメント: <?php echo $data['User']['comment']; ?>
        <?php echo $this->Html->tag('br'); ?>
    パスワード: <?php echo $data['User']['password']; ?>
        <?php echo $this->Html->tag('br'); ?>
    登録時間: <?php echo $data['User']['time']; ?>
        <?php echo $this->Html->tag('br'); ?>
    <?php echo $this->Form->create('Submit', array(
        'type' => 'post',
        'url' => 'result'
        )); ?>
    <?php echo $this->Form->submit('登録'); ?>
<?php else: ?>
    <?php echo $this->Html->tag('h2','登録完了しました．ありがとうございました．'); ?>
    <?php echo $this->Html->link('最初に戻る','index'); ?>
<?php endif; ?>