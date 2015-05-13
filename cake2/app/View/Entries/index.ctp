<?php echo $this->Html->tag('h2','ユーザー登録フォーム'); ?>
 
<!-- フォーム開始 -->
<?php echo $this->Form->create('User', array(
    'type' => 'post',
    'url' => 'result'
    )); ?>
 
<?php echo $this->Form->input('User.name',array(
    'label' => "名前")); ?>
<?php //echo $this->Form->error('User.name'); ?>
 
<?php echo $this->Form->input('User.email',array(
    'label' => "メール")); ?>
<?php //echo $this->Form->error('User.email'); ?>
<!-- ラジオボタン -->
<?php $option = array(0 => '男', 1 => '女'); ?>
<?php $option2 = array('legend' => false, 'value' => 1);?>
<?php echo $this->Form->label('User.sex','性別'); ?>
<?php echo $this->Form->radio('User.sex',$option,$option2); ?>
<?php //echo $this->Form->error('User.sex'); ?>
 
<!-- パスワード -->
<?php echo $this->Form->label('User.password','パスワード'); ?>
<?php echo $this->Form->password('User.password'); ?>
<?php //echo $this->Form->error('User.password'); ?>
 
<!-- 送信ボタン -->
<?php echo $this->Form->submit(); ?>
 
<!-- フォーム終了 -->
<?php echo $this->Form->end(); ?>
 
<p>登録ユーザ</p>
 
<table class="table"><tbody>
    <tr>
      <th>名前</th>
      <th>メール</th>
      <th>登録時間</th>
    </tr>
    <?php if(!empty($data)): ?>
    <?php foreach ($data as $key => $value): ?>
        <tr>
          <td><?php echo $value['User']['name']; ?></td>
          <td><?php echo $value['User']['email']; ?></td>
          <td><?php echo $value['User']['created']; ?></td>
        </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</tbody></table>