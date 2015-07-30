<?php
    echo $this->Html->css('message');
?>
<?php
    // 現在選択中のボックスの背景色を変える
    $style1 = '';$style2 = '';$style3 = '';$style4 = '';
    if (empty($type)) {
        $style1 = 'padding: 2px;color:white;background-color:#45bcd2;';
    } elseif ($type == 'send') {
        $style2 = 'padding: 2px;color:white;background-color:#45bcd2;';
    } elseif ($type == 'draft') {
        $style3 = 'padding: 2px;color:white;background-color:#45bcd2;';
    } elseif ($type == 'trashbox') {
        $style4 = 'padding: 2px;color:white;background-color:#45bcd2;';
    }
    // 受信メッセージの新着があればその件数を表示
    $new_message = '';
    if ($new_count > 0) {
        $new_message = '<span style="background-color: grey;color: white;padding: 0 10px 0 10px;border-radius: 5px;">'.$new_count.'</span>';
    }
    // 下書きがあればその件数を表示
    $draft_message = '';
    if ($draft_count > 0) {
        $draft_message = '<span style="background-color: grey;color: white;padding: 0 10px 0 10px;border-radius: 5px;">'.$draft_count.'</span>';
    }
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
                        <span style="<?=$style1 ?>">受信トレイ</span>&nbsp;<?=$new_message ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td width="15px;">
                    <a href="<?=ROOTDIR ?>/message/index/send" style="text-decoration: none;">
                        <img src="<?=ROOTDIR ?>/img/folder1.gif" style="vertical-align: -9px;">
                    </a>
                </td>
                <td>
                    <a href="<?=ROOTDIR ?>/message/index/send" style="text-decoration: none;">
                        <span style="<?=$style2 ?>">送信済み</span>
                    </a>
                </td>
            </tr>
            <tr>
                <td width="15px;">
                    <a href="<?=ROOTDIR ?>/message/index/draft" style="text-decoration: none;">
                        <img src="<?=ROOTDIR ?>/img/folder1.gif" style="vertical-align: -9px;">
                    </a>
                </td>
                <td>
                    <a href="<?=ROOTDIR ?>/message/index/draft" style="text-decoration: none;">
                        <span style="<?=$style3 ?>">下書き</span>&nbsp;<?=$draft_message ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td width="15px;">
                    <a href="<?=ROOTDIR ?>/message/index/trashbox" style="text-decoration: none;">
                        <img src="<?=ROOTDIR ?>/img/dustbox.gif" style="vertical-align: -9px;margin-left: 5px;">
                    </a>
                </td>
                <td>
                    <a href="<?=ROOTDIR ?>/message/index/trashbox" style="text-decoration: none;">
                        <span style="<?=$style4 ?>">削除済み</span>
                    </a>
                </td>
            </tr>
        </table>
        <!--
        <a href="<?=ROOTDIR ?>/message/staff">●テストページ「スタッフからの送信」</a>
        -->
    </div>
            </td>
            <td style="width:70%;" valign="top">
    <!-- メッセージ一覧（受信トレイ） -->
    <?php if (empty($type) || $type == 'trashbox') { ?>
    <div id='message-list'>
        <?php echo $this->Form->create('Message2Member', array('name' => 'form')); ?>
        <font style='font-weight: bold;font-size: 110%;'>
        <?php
            if (empty($type)) {
                echo '[受信トレイ]';
            } else {
                echo '[ゴミ箱]';
            }
        ?>
        </font>
        &nbsp;&nbsp;&nbsp;
        <?php if (empty($type)) { ?>
        <input type='submit' name='2trashbox' value='ゴミ箱へ' style='padding: 5px 10px 5px 10px;font-size: 90%;'>
        <?php } else { ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type='submit' name='delete' value='完全削除' style='padding: 5px 10px 5px 10px;font-size: 90%;'>
        <?php } ?>
        <br>
        <?php echo $this->paginator->numbers (
            array (
                'before' => $this->paginator->hasPrev() ? $this->paginator->first('<<').' | ' : '',
                'after' => $this->paginator->hasNext() ? ' | '.$this->paginator->last('>>') : '',
            )
        );
        ?>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void">
            <tr style='background-color: #459ed2;'>
                <th style='width:5%;'>&nbsp;</th>
                <th style='width:40%;'>標題</th>
                <th style='width:15%;'>差出人</th>
                <th style='width:15%;'>宛先</th>
                <th style='width:25%;'>受信日時</th>
            </tr>
            <?php foreach ($datas as $data) { ?>
        <?php if ($data['Message2Member']['kidoku_flag'] == 0) { ?>
            <tr style='background-color: #fff6d7; border:1px solid orange; font-weight: bold;'>
        <?php } elseif ($data['Message2Member']['kidoku_flag'] == 1) { ?>
            <tr>    
        <?php } ?>   
                <td style="padding-top: 8px;">
                    <?php echo $this->Form->input('check', array('name'=>'check['.$data['Message2Member']['id'].']', 'type'=>'checkbox','label'=>false)); ?>
                </td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Member']['title'], 'detail/'.$data['Message2Member']['id'], array('style'=>'color: blue;')) ?>
                    <?php
                        if (!empty($data['Message2Member']['attachment'])) {
                            echo '&nbsp;';
                            echo '<span style="vertical-align:-7px;">';
                            echo '<img src="'.ROOTDIR.'/img/clip.png" style="width: 25px;" />';
                            echo '</span>';
                        }
                    ?>
                </td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Member']['name'], 'detail/'.$data['Message2Member']['id'], array('style'=>'')) ?>
                </td>
                <td class='message-content'><?=$data['User']['name_sei'].' '.$data['User']['name_mei']; ?></td>
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
    <!-- メッセージ一覧（受信トレイ）END -->
    <?php } elseif ($type == 'send' || $type == 'draft') { ?>
    <!-- メッセージ一覧（送信済み） -->
    <div id='message-list'>
        <?php echo $this->Form->create('Message2Staff', array('name' => 'form')); ?>
        <font style='font-weight: bold;font-size: 110%;'>
        <?php
            if ($type == 'send') {
                echo '[送信済み]';
                $dir = 'detail2';
            } elseif ($type == 'draft') {
                echo '[下書き]';
                $dir = 'send';
            }
        ?>
        </font>
        <?php if ($type == 'send') { ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php } elseif ($type == 'draft') { ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php } ?>
        <input type='submit' name='delete' value='削　除' style='padding: 5px 10px 5px 10px;font-size: 90%;'>
        <br>
        <?php echo $this->paginator->numbers (
            array (
                'before' => $this->paginator->hasPrev() ? $this->paginator->first('<<').' | ' : '',
                'after' => $this->paginator->hasNext() ? ' | '.$this->paginator->last('>>') : '',
            )
        );
        ?>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void">
            <tr style='background-color: #459ed2;'>
                <th style='width:5%;'>&nbsp;</th>
                <th style='width:40%;'>標題</th>
                <th style='width:15%;'>宛先</th>
                <th style='width:15%;'>差出人</th>
                <th style='width:25%;'>送信日時</th>
            </tr>
            <?php foreach ($datas as $data) { ?>
            <tr>    
                <td style="padding-top: 8px;">
                    <?php echo $this->Form->input('check',array('name'=>'check['.$data['Message2Staff']['id'].']', 'type'=>'checkbox','label'=>false)); ?>
                </td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Staff']['title'], $dir.'/'.$data['Message2Staff']['id'], array('style'=>'color: blue;')) ?>
                    <?php
                        if (!empty($data['Message2Staff']['attachment'])) {
                            echo '&nbsp;';
                            echo '<span style="vertical-align:-7px;">';
                            echo '<img src="'.ROOTDIR.'/img/clip.png" style="width: 25px;" />';
                            echo '</span>';
                        }
                    ?>
                </td>
                <td class='message-content'>
                            <?=$data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei']; ?>
                    <?php
                        if (strpos($data['Message2Staff']['recipient_staff'], ',')) {
                            echo '&nbsp;など';
                        }
                    
                    ?>
                </td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Staff']['name'], $dir.'/'.$data['Message2Staff']['id'], array('style'=>'')) ?>
                </td>
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
    <?php } ?>
    <!-- メッセージ一覧（受信トレイ）END -->
                </td>
        </tr>
    </table>
</div>

<!-- 機能紹介 -->
<script type="text/javascript">
$(function() {
    //alert('制作中です');
  // 2ダイアログ機能を適用
  $('#dialog').dialog({
    modal: false
  });
});
</script>
<div id="dialog" title="メッセージ機能の紹介" style="display: none">
<p style="font-size: 90%;">
    この機能を使って、スタッフの方とメッセージをやりとりすることが可能です。<br>
    ※ただし、スタッフ専用サイトが開設されるまでは使用できません。</p>
</div>