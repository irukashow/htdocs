<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">

<?php echo $this->Form->create('StaffMaster', array('name' => 'form','enctype' => 'multipart/form-data','id' => 'regist')); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $staff_id)); ?>  
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>
<?php echo $this->Form->input('name_sei', array('type'=>'hidden', 'value' => $data['StaffMaster']['name_sei'])); ?>
<?php echo $this->Form->input('name_mei', array('type'=>'hidden', 'value' => $data['StaffMaster']['name_mei'])); ?>

    <center>
    <fieldset style="border: none; margin-bottom: 5px;">
        <table>
            <tr>
                <td colspan="2">
                    <legend style="font-size: 150%;color: red;"><?php echo __('スタッフのログインアカウント変更'); ?></legend>
                </td>
            </tr>
            <tr>
                <td width='30%;'>スタッフ</td>
                <td><?='('.$staff_id.') ' ?><?php echo $data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei']; ?></td>
            </tr>
            <tr>
                <td>メールアドレス１</td>
                <td><?php echo $data['StaffMaster']['email1']; ?></td>
            </tr>
            <tr>
                <td>ログインアカウント</td>
                <td><?php echo $this->Form->input('account',array('label' => false, 'style' => 'width:200px;')); ?></td>
            </tr>
            <tr>
                <td>パスワード</td>
                <td><?php echo $this->Form->input('password',array('label' => false, 'value' => '', 'style' => 'width:200px;')); ?></td>
            </tr>
            <tr>
                <td>再入力</td>
                <td><?php echo $this->Form->input('password2',array('type' => 'password' , 'label' => false, 'value' => '', 'style' => 'width:200px;')); ?></td>
            </tr>
        </table>
        <div style="margin-top: 10px;">
            <?php echo $this->Form->submit('設定する', array('name' => 'submit','div' => false)); ?>
                &nbsp;&nbsp;
            <?php print($this->Html->link('戻　る', 'index', array('id'=>'button-delete', 'onclick' => 'javascript:window.history.back(-1);return false;'))); ?>
                &nbsp;&nbsp;
            <?php print($this->Html->link('閉 じ る', 'javascript:void(0)', array('id'=>'button-delete', 'onclick' => 'javascript:window.close();'))); ?>

        </div>
    </fieldset>
        </center>
    <?php echo $this->Form->end(); ?>
</div>