<!-- content start -->
<div data-role="content" style="height: 600px;text-shadow: 2px 2px 5px white;background-image: url('<?=ROOTDIR ?>/img/201108090000.jpg');">
    <div style="text-align: center;"><h3>現場責任者ページ</h3></div>

    <?php echo $this->Form->create('Client', array('name'=>'form')); ?>
    <?=$this->Form->input('username', array('type' => 'text', 'label' => 'アカウントID', 'style'=>'width: 95%;',))?>

    <?=$this->Form->input('password', array('label' => 'パスワード','type' => 'password','style'=>'width: 95%;',))?>
    <br>
    <a href="#" data-role="button" data-theme="e" data-icon="check" onclick="form.submit();">ログイン</a>

</div>



