<div style="width:35%;margin-top: 20px;margin-left: auto; margin-right: auto;">
<?php echo $this->Form->create('User', array('name'=>'User')); ?>
    <fieldset style="border:none;margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('ユーザー登録をしてください。'); ?></legend>
        <?php echo $this->Form->input('username',array('type' => 'hidden', 'style'=>'width:30%;')); ?>
        
            <!-- 名前コンボの値セット START -->
            <div class="input select required">
                <label for="UserUsername">名前</label>
                <select name="UserId" id="UserUsername" required="required" style="font-size: 100%;"  onChange="location.href='/softlife2/users/edit/<?=$username ?>';">   
            <?php foreach ($datas as $data): ?>
                    <option value="<?= $data['User']['username'] ?>"><?=$data['User']['name_sei'] ?> <?=$data['User']['name_mei'] ?></option> 
            <?php endforeach; ?>
                </select>
            </div>
            <!-- 名前コンボの値セット END -->
            
        <?php    
                echo $this->Form->input('検索',array('label'=>false,'type' => 'submit', 'style'=>'width:30%;'));
                
	        echo $this->Form->input('password',array('label' => 'パスワード'));
                $list1 = array(''=>'', '1'=>'大阪', '2'=>'東京', '3'=>'名古屋', '99'=>'すべて');
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
<?php print($this->Html->link('キャンセル', 'index', array('class'=>'button-rink'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>

<script type="text/javascript">
    document.getElementById('UserUsername').value = '<?=$username ?>';
</script>
