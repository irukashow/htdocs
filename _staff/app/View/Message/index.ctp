<?php
    echo $this->Html->css('message');
?>
<!-- 見出し -->
<div id='headline' style="">
    ★ メッセージ
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/message/send" target="" id='button-send'>メッセージを送る</a>
</div>

<!-- メインペイン -->
<div id='message-main'>
    <table border="0" style="width:100%;">
        <tr>
            <td style="width:30%;">
    <!-- メッセージボックス -->
    <div id='message-folder'>
        <font style="font-size: 120%;color:red;">メッセージボックス</font><br>
        <table border="0">
            <tr>
                <td width="15px;">
                    <a href="<?=ROOTDIR ?>/message/index" style="text-decoration: none;">
                        <img src="<?=ROOTDIR ?>/img/folder1.gif" style="vertical-align: -9px;">
                    </a>
                </td>
                <td>
                    <a href="<?=ROOTDIR ?>/message/index" style="text-decoration: none;">
                        受信トレイ&nbsp;<span style="background-color: grey;color: white;padding: 0 10px 0 10px;border-radius: 5px;"><?=$new_count ?></span>
                    </a>
                </td>
            </tr>
            <tr>
                <td width="15px;">
                    <a href="<?=ROOTDIR ?>/message/index/sent" style="text-decoration: none;">
                        <img src="<?=ROOTDIR ?>/img/folder1.gif" style="vertical-align: -9px;">
                    </a>
                </td>
                <td>
                    <a href="<?=ROOTDIR ?>/message/index/sent" style="text-decoration: none;">
                        送信済み
                    </a>
                </td>
            </tr>
        </table>
    </div>
            </td>
            <td style="width:70%;">
    <!-- メッセージ一覧 -->
<?php if (empty($type)) { ?>
    <div id='message-list'>
        <?php echo $this->Form->create('Message2Staff', array('name' => 'form')); ?>
        <font style='font-weight: bold;font-size: 110%;'>[受信トレイ]</font><br>
        <?php echo $this->paginator->numbers (
            array (
                'before' => $this->paginator->hasPrev() ? $this->paginator->first('<<').' | ' : '',
                'after' => $this->paginator->hasNext() ? ' | '.$this->paginator->last('>>') : '',
            )
        );
        ?>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void">
            <tr style='background-color: #459ed2;'>
                <th style='width:40%;'>標題</th>
                <th style='width:15%;'>差出人</th>
                <th style='width:15%;'>宛先</th>
                <th style='width:25%;'>作成日時</th>
            </tr>
            <?php foreach ($datas as $data) { ?>
        <?php if ($data['Message2Staff']['kidoku_flag'] == 0) { ?>
            <tr style='background-color: #fff6d7; border:1px solid orange; font-weight: bold;'>
        <?php } elseif ($data['Message2Staff']['kidoku_flag'] == 1) { ?>
            <tr>    
        <?php } ?>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Staff']['title'], 'detail/'.$data['Message2Staff']['id'], array('style'=>'color: blue;')) ?>
                </td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Staff']['name'], 'detail/'.$data['Message2Staff']['id'], array('style'=>'')) ?>
                </td>
                <td class='message-content'><?=$data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei']; ?></td>
                <td class='message-content'><?=$data['Message2Staff']['created']; ?></td>
            </tr>
            <?php } ?>
            <?php if (count($datas) == 0) { ?>
            <tr>
                <td colspan="5" align="center">表示するメッセージはありません。</td>
            </tr>
            <?php } ?>
        </table>
        <?php echo $this->paginator->numbers (
            array (
                'before' => $this->paginator->hasPrev() ? $this->paginator->first('<<').' | ' : '',
                'after' => $this->paginator->hasNext() ? ' | '.$this->paginator->last('>>') : '',
            )
        );
        ?>
        <?php echo $this->Form->end(); ?>
    </div>
<?php } elseif ($type == 'sent') { ?>
    <div id='message-list'>
        <?php echo $this->Form->create('Message2Member', array('name' => 'form')); ?>
        <font style='font-weight: bold;font-size: 110%;'>[送信済み]</font><br>
        <?php echo $this->paginator->numbers (
            array (
                'before' => $this->paginator->hasPrev() ? $this->paginator->first('<<').' | ' : '',
                'after' => $this->paginator->hasNext() ? ' | '.$this->paginator->last('>>') : '',
            )
        );
        ?>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void">
            <tr style='background-color: #459ed2;'>
                <th style='width:40%;'>標題</th>
                <th style='width:15%;'>宛先</th>
                <th style='width:15%;'>差出人</th>
                <th style='width:25%;'>送信日時</th>
            </tr>
            <?php foreach ($datas as $data) { ?>
            <tr>    
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Member']['title'], 'detail2/'.$data['Message2Member']['id'], array('style'=>'color: blue;')) ?>
                </td>
                <td class='message-content'><?=$data['User']['name_sei'].' '.$data['User']['name_mei']; ?></td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Member']['name'], 'detail2/'.$data['Message2Member']['id'], array('style'=>'')) ?>
                </td>
                <td class='message-content'><?=$data['Message2Member']['created']; ?></td>
            </tr>
            <?php } ?>
            <?php if (count($datas) == 0) { ?>
            <tr>
                <td colspan="5" align="center">表示するメッセージはありません。</td>
            </tr>
            <?php } ?>
        </table>
        <?php echo $this->paginator->numbers (
            array (
                'before' => $this->paginator->hasPrev() ? $this->paginator->first('<<').' | ' : '',
                'after' => $this->paginator->hasNext() ? ' | '.$this->paginator->last('>>') : '',
            )
        );
        ?>
        <?php echo $this->Form->end(); ?>
    </div>
<?php } ?> 
                </td>
        </tr>
    </table>
</div>