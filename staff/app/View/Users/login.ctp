<!-- content start -->
<div data-role="content" data-url="<?=ROOTDIR ?>/users/login" style="height: 600px;text-shadow: 2px 2px 3px white;background-image: url('<?=ROOTDIR ?>/img/201107280400.jpg');">
    <div style="text-align: center;"><h3>スタッフ専用ページ</h3></div>

    <?php echo $this->Form->create('StaffMaster', array('name'=>'form')); ?>
    <?=$this->Form->input('account', array('type' => 'text', 'label' => 'アカウントID', 'style'=>'width: 95%;',))?>
    <?=$this->Form->input('email1', array('type' => 'hidden'))?>

    <?=$this->Form->input('password', array('label' => 'パスワード','type' => 'password','style'=>'width: 95%;',))?>
    <br>
    <a href="#" data-role="button" data-theme="e" data-icon="check" onclick="form.submit();">ログイン</a>
    <!--
    <?=$this->Form->input('ログイン', array('type' => 'submit', 'label' => false, 'div' => false, 'data-icon' => "check"));?>
    -->
    
    <?=$this->Form->end();?>

</div>



