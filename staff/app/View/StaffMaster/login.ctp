<!-- content start -->
<div data-role="content">
    <div style="text-align: center;">ログイン</div>

    <?php echo $this->Form->create('StaffMaster'); ?>
    <?=$this->Form->input('account', array('type' => 'text', 'label' => 'アカウント or Eメールアドレス','type' => 'textbox','style'=>'width: 95%;',))?>

    <?=$this->Form->input('password', array('label' => 'パスワード','type' => 'password','style'=>'width: 95%;',))?>

    <?=$this->Form->end(array('label' => 'ログイン','div' => false,  'data-icon' => "check"));?>

</div>



