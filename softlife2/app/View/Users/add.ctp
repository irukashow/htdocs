<div style="width:35%;margin-top: 20px;margin-left: auto; margin-right: auto;">
<?php echo $this->Form->create('User'); ?>
    <fieldset style="border:none;margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('ユーザー登録をしてください。'); ?></legend>
        <?php 
                echo $this->Form->input('name_sei',array('label' => '氏名（姓）', 'style'=>'width:30%;'));
                echo $this->Form->input('name_mei',array('label' => '氏名（名）', 'style'=>'width:30%;'));
	        echo $this->Form->input('password',array('label' => 'パスワード'));
                $list1 = array(''=>'', '1'=>'大阪', '2'=>'東京', '3'=>'名古屋', '99'=>'すべて');
                $list2 = array('11'=>'大阪-住宅営業', '12'=>'大阪-人材派遣', '21'=>'東京-住宅営業', '22'=>'東京-人材派遣', '31'=>'名古屋-住宅営業', '32'=>'名古屋-人材派遣');
                echo $this->Form->input('area',array('label' => '所属', 'type' => 'select', 'options' => $list1));
                echo '<div><label><b>閲覧権限</b></label></div>';
                echo $this->Form->input('auth11',array('label' => '大阪-住宅営業', 'type' => 'checkbox'));
                echo $this->Form->input('auth12',array('label' => '大阪-人材派遣', 'type' => 'checkbox'));
                echo $this->Form->input('auth21',array('label' => '東京-住宅営業', 'type' => 'checkbox'));
                echo $this->Form->input('auth22',array('label' => '東京-人材派遣', 'type' => 'checkbox'));
                echo $this->Form->input('auth31',array('label' => '名古屋-住宅営業', 'type' => 'checkbox'));
                echo $this->Form->input('auth32',array('label' => '名古屋-人材派遣', 'type' => 'checkbox'));
	        echo $this->Form->input('role', array('label' => 'ユーザーの種類',
	            'options' => array('user' => '一般ユーザー', 'admin' => 'システム管理者')
	        ));
    	?>
    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('キャンセル', '/admin/index', array('class'=>'button-rink'))); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('クリア', './add', array('class'=>'button-rink2'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>