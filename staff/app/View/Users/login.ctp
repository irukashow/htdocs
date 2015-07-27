<!-- content start -->
<div data-role="content">
    <div style="text-align: center;"><h3>スタッフ専用ページ</h3></div>

    <?php echo $this->Form->create('StaffMaster'); ?>
    <?=$this->Form->input('account', array('type' => 'text', 'label' => 'アカウントID', 'style'=>'width: 95%;',))?>
    <?=$this->Form->input('email1', array('type' => 'hidden'))?>

    <?=$this->Form->input('password', array('label' => 'パスワード','type' => 'password','style'=>'width: 95%;',))?>

    <?=$this->Form->end(array('label' => 'ログイン','div' => false,  'data-icon' => "check"));?>

</div>



