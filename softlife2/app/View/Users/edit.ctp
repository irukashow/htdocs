<div style="width:35%;margin-top: 20px;margin-left: auto; margin-right: auto;">
<?php echo $this->Form->create('User', array('type' => 'post', 'name' => 'form')); ?>
<?php $list1 = array(''=>'', '1'=>'大阪', '2'=>'東京', '3'=>'名古屋', '99'=>'すべて'); ?>
<?php $list2 = array('11'=>'大阪-人材派遣　', '12'=>'大阪-住宅営業　', '21'=>'東京-人材派遣　', '22'=>'東京-住宅営業　', '31'=>'名古屋-人材派遣　', '32'=>'名古屋-住宅営業　'); ?>
    
    <fieldset style="border:none;margin-bottom: 0px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('ユーザー情報を更新してください。'); ?></legend>
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th style="width:30%;background-color:#e8ffff;"><div class="required"><label>ユーザーID</label></div></th>
                <td style="padding-left: 5px;">
                    <?php echo $this->Form->input('username',array('type' => 'text', 'label' => false, 'div' => false, 'style' => 'width: 100px;')); ?>
                    ※入力に注意してください。
                </td>   
            </tr>
            <tr>
                <th style="width:30%;background-color:#e8ffff;"><div class="required"><label>氏名 (姓・名)</label></div></th>
                <td style="padding-left: 5px;">
                    <?php  echo $this->Form->input('username', 
                            array('type' => 'select', 'label' => false,'div' => false, 'empty' => '氏名を選択してください',
                                'style'=>'width:70%;font-size:110%;', 'options' => $datas, 'onchange' => 'form.submit();')); ?>
                </td>   
            </tr>
            <!--
            <tr>
                <th style="width:30%;background-color:#e8ffff;"><div class="required"><label>パスワード</label></div></th>
                <td style="padding-left: 5px;"><?php echo $this->Form->input('password',array('label' => false, 'div' => false, 'value' => '')); ?></td>   
            </tr>
            -->
            <tr>
                <th style="width:30%;background-color:#e8ffff;"><div class=""><label>エリア</label></div></th>
                <td><?php echo $this->Form->input('area',array('label' => false, 'type' => 'select', 'options' => $list1)); ?></td>   
            </tr>
            <tr>
                <th style="width:30%;background-color:#e8ffff;"><div class="required"><label>閲覧権限</label></div></th>
                <td>
                    <?php echo $this->Form->input('auth',array('type'=>'select','multiple' => 'checkbox', 'label' => false,'style' => 'display:inline-block', 'value' => $value, 'options' => $list2)); ?>
                </td>   
            </tr>
            <tr>
                <th style="width:30%;background-color:#e8ffff;"><div class="required"><label>ユーザーの種類</label></div></th>
                <td>
                    <?php echo $this->Form->input('role', array('label' => false,'options' => array('user' => '一般ユーザー', 'admin' => 'システム管理者'))); ?>
                </td>   
            </tr>
        </table>

                <!--
                echo $this->Form->input('auth11',array('label' => '大阪-住宅営業', 'type' => 'checkbox'));
                echo $this->Form->input('auth12',array('label' => '大阪-人材派遣', 'type' => 'checkbox'));
                echo $this->Form->input('auth21',array('label' => '東京-住宅営業', 'type' => 'checkbox'));
                echo $this->Form->input('auth22',array('label' => '東京-人材派遣', 'type' => 'checkbox'));
                echo $this->Form->input('auth31',array('label' => '名古屋-住宅営業', 'type' => 'checkbox'));
                echo $this->Form->input('auth32',array('label' => '名古屋-人材派遣', 'type' => 'checkbox'));
                -->
    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('更新する', array('name' => 'regist','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('戻　る', '/users/view', array('id' => 'button-delete'))); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('クリア', './edit', array('class'=>'button-rink'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>