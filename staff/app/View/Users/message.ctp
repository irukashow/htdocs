<?php
    echo $this->Html->css('message');
?>

<div id="page1" data-role="page">
    <div data-role="header" data-theme="c">
            <h1>メッセージ</h1>
            <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
    </div>			
    <div data-role="content">
        <?php if ($flag == 1) { ?>
        <b>[受信]</b>　<a href="<?=ROOTDIR ?>/users/message/2">[送信済]</a>　<a href="<?=ROOTDIR ?>/users/message/3">[新規作成]</a>
        <?php } elseif ($flag == 2) { ?>
        <a href="<?=ROOTDIR ?>/users/message/1">[受信]</a>　<b>[送信済]</b>　<a href="<?=ROOTDIR ?>/users/message/3">[新規作成]</a>
        <?php } elseif ($flag == 3) { ?>
        <a href="<?=ROOTDIR ?>/users/message/1">[受信]</a>　<a href="<?=ROOTDIR ?>/users/message/2">[送信済]</a>　<b>[新規作成]</b>
        <?php } ?>
        
        <?php if ($flag == 1) { ?>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void" style="font-size: 60%;">
            <tr style='background-color: #459ed2;color:white;'>
                <th style='width:40%;'>標題</th>
                <th style='width:15%;'>差出人</th>
                <th style='width:25%;'>受信日時</th>
            </tr>
            <?php foreach ($datas as $data) { ?>
        <?php if ($data['Message2Staff']['kidoku_flag'] == 0) { ?>
            <tr style='background-color: #fff6d7; border:1px solid orange; font-weight: bold;'>
        <?php } elseif ($data['Message2Staff']['kidoku_flag'] == 1) { ?>
            <tr>    
        <?php } ?>   
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Staff']['title'], 'detail/'.$data['Message2Staff']['id'], array('style'=>'color: blue;')) ?>
                    <?php
                        if (!empty($data['Message2Staff']['attachment'])) {
                            echo '&nbsp;';
                            echo '<span style="vertical-align:-7px;">';
                            echo '<img src="'.ROOTDIR.'/img/clip.gif" style="width: 25px;" />';
                            echo '</span>';
                        }
                    ?>
                </td>
                <td class='message-content'><?=$data['Message2Staff']['name']; ?></td>
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
        <?php } elseif ($flag == 2) { ?>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void" style="font-size: 60%;">
            <tr style='background-color: #459ed2;color:white;'>
                <th style='width:40%;'>標題</th>
                <th style='width:15%;'>宛先</th>
                <th style='width:25%;'>送信日時</th>
            </tr>
            <?php foreach ($datas as $data) { ?>
        <?php if ($data['Message2Member']['kidoku_flag'] == 0) { ?>
            <tr style='background-color: #fff6d7; border:1px solid orange; font-weight: bold;'>
        <?php } elseif ($data['Message2Member']['kidoku_flag'] == 1) { ?>
            <tr>    
        <?php } ?>   
                <td class='message-content'>
                    <?php echo $this->Html->link($data['Message2Member']['title'], 'detail/'.$data['Message2Member']['id'], array('style'=>'color: blue;')) ?>
                    <?php
                        if (!empty($data['Message2Member']['attachment'])) {
                            echo '&nbsp;';
                            echo '<span style="vertical-align:-7px;">';
                            echo '<img src="'.ROOTDIR.'/img/clip.gif" style="width: 25px;" />';
                            echo '</span>';
                        }
                    ?>
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
        <?php } elseif ($flag == 3) { ?>
        新規作成ページ
        <?php echo $this->Form->end(); ?>
        <?php } ?>
    <!-- メッセージ一覧（受信トレイ）END -->
    </div>
    <div class="pagetop">
            <a href="#page1">
                <?php echo $this->Html->image('pagetop.png'); ?>
            </a>
    </div>			
    <div id="footer">
        <?=FOOTER ?>
    </div>
</div>

<!--ダイアログメニュー-->
<?php require('dialog_menu.ctp'); ?>
<!--ダイアログメニュー end-->