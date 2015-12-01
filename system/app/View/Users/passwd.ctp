<div style="width:30%; margin-top: 20px; margin-left: auto; margin-right: auto;">
<?php echo $this->Form->create('User'); ?>
    <fieldset style="border: none; margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('パスワードを変更します。'); ?></legend>
        <?php 
                echo $this->Form->input('username',array('type' => 'hidden'));
    	?>
        <table>
            <tr>
                <td>氏名</td>
                <td>
                    <?php echo $this->Form->input('name_sei',array('label' => false, 'div' => false, 'disabled' => 'disabled', 'style' => 'width:70px;')); ?>
                    &nbsp;
                    <?php echo $this->Form->input('name_mei',array('label' => false, 'div' => false, 'disabled' => 'disabled', 'style' => 'width:70px;')); ?>
                </td>
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
        <div style="text-align: left;margin-top: 10px;">
            <?php echo $this->Form->submit('変更する', array('name' => 'submit','div' => false)); ?>
                &nbsp;&nbsp;
            <?php print($this->Html->link('キャンセル', 'index', array('id'=>'button-delete'))); ?>

        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>