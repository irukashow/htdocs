<div style="width:30%; margin-top: 20px; margin-left: auto; margin-right: auto;">
<?php echo $this->Form->create('User'); ?>
    <fieldset style="border: none; margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('パスワードを変更します。'); ?></legend>
        <?php 
                echo $this->Form->input('username',array('type' => 'hidden'));
	        echo $this->Form->input('password',array('label' => 'パスワード'));
    	?>

        <div style="text-align: left;">
            <?php echo $this->Form->submit('変更する', array('name' => 'submit','div' => false)); ?>
                &nbsp;&nbsp;
            <?php print($this->Html->link('キャンセル', 'index', array('class'=>'button-rink'))); ?>

        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>