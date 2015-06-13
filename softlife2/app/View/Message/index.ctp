<?php
    echo $this->Html->css('message');
?>

<!-- 見出し -->
<div id='headline'>
    ★ メッセージボックス
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="send" target="" id='button-send'>メッセージを送る</a>
</div>

<!-- メインペイン -->
<div id='message-main'>
    <table border="0" style="width:100%;">
        <tr>
            <td style="width:30%;">
    <!-- メッセージボックス -->
    <div id='message-folder'>
        <font style="font-size: 120%;color:red;">制作予定</font><br>
    </div>
            </td>
            <td style="width:70%;">
    <!-- メッセージ一覧 -->
    <div id='message-list'>
        <?php echo $this->Form->create('Message', array('name' => 'form')); ?>
        <font style='font-weight: bold;font-size: 110%;'>[受信箱]</font>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void">
            <tr style='background-color: #459ed2;'>
                <th style='width:5%;'>&nbsp;</th>
                <th style='width:50%;'>標題</th>
                <th style='width:20%;'>差出人</th>
                <th style='width:25%;'>作成日時</th>
            </tr>
            <?php foreach ($datas as $data) { ?>
            <tr>
                <td style="padding-top: 8px;">
                    <?php echo $this->Form->input('check',array('type'=>'checkbox','label'=>false)); ?>
                </td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message']['title'], 'detail/'.$data['Message']['id'], array('style'=>'text-decoration: none;')) ?>
                </td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message']['name'], 'detail/'.$data['Message']['id'], array('style'=>'text-decoration: none;')) ?>
                </td>
                <td class='message-content'><?=$data['Message']['modified']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php echo $this->Form->end(); ?>
    </div>
                </td>
        </tr>
    </table>
</div>