<!-- content start -->
<div data-role="content">
    <div style="text-align: center;"><h3>現場責任者ページ</h3></div>

    <?php echo $this->Form->create('Client'); ?>
    <?=$this->Form->input('username', array('type' => 'text', 'label' => 'アカウントID', 'style'=>'width: 95%;',))?>

    <?=$this->Form->input('password', array('label' => 'パスワード','type' => 'password','style'=>'width: 95%;',))?>

    <?=$this->Form->end(array('label' => 'ログイン','div' => false,  'data-icon' => "check"));?>

</div>



