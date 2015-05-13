<?php
echo $this->Form->create('ValidateTest', array('type' => 'post', 'action' => '.','onsubmit'=>'return confirm("送信します。よろしいですか？");'));
echo $this->Form->input('input_adress', array('label' => 'EMail Adress'));
echo $this->Form->input('input_subject', array('label' => '件名'));
echo $this->Form->input('input_text',
    array('label' => '本文','rows' => '5', 'cols' => '5'));
echo $this->Form->end(__('送信'));
?>	