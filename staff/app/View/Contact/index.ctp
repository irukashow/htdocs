<h1>お問い合わせ</h1>
<div style="width: 500px;">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Form->create('Contact'); ?>
    <?php echo $this->Form->input('name'); ?>
    <?php echo $this->Form->input('email'); ?>
    <?php echo $this->Form->textarea('body'); ?>
    <?php echo $this->Form->error('body'); ?>
    <?php echo $this->Form->submit('送信'); ?>
    <?php echo $this->Form->end(); ?>
</div>