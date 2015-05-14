<div style="width:35%;">
<?php echo $this->Form->create('User'); ?>
    <fieldset style="border:none;margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('ユーザー登録をしてください。'); ?></legend>
        <?php 
                echo $this->Form->input('name_sei',array('label' => '姓'));
                echo $this->Form->input('name_mei',array('label' => '名'));
	        echo $this->Form->input('password',array('label' => 'パスワード'));
	        echo $this->Form->input('role', array('label' => 'ユーザーの種類',
	            'options' => array('' => '（選択）', 'user' => '一般ユーザー', 'admin' => 'システム管理者')
	        ));
    	?>
    </fieldset>
<?php echo $this->Form->submit('登録', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('キャンセル', 'index', array('class'=>'button-rink'))); ?>
<?php echo $this->Form->end(); ?>
</div>