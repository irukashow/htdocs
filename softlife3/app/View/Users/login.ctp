<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('ユーザIDとパスワードを入力して下さい。'); ?></legend>
        <?php echo $this->Form->input('username');
        	echo $this->Form->input('password');
    	?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>