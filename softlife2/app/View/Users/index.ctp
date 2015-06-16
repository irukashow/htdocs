<?php
    echo $this->Html->css('message');
?>
<!-- 見出し -->
<div id='headline' style="height:23px;">
    <div style="float:left;">
        ★ ホーム
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="" target=""></a>
        <a href="" target=""></a>
        <a href="" target=""></a>
    </div>
    <div style="float:right;font-size: 90%;">最終ログイン時刻：<?=$last_login ?></div>
</div>
<div style="clear:both;"></div>

<!-- メインペイン -->
<div id='message-main'>
    <table border="0" style="width:100%;">
        <tr>
            <td style="width:30%;">
                <!-- メッセージボックス -->
                <div id='message-folder'>
                        <font style="font-size:110%;font-weight: bold;color:#006699;">ようこそ！ <?=$user_name ?>さん</font><br>
                        <div style="height: 5px;"></div>
                        <?php echo $this->Html->link('パスワード変更', '/users/passwd/'); ?>
                        <br>
                        <?php echo $this->Html->link('ログアウト', 'logout', array('title'=>'確認'), 'ログアウトしてもよろしいですか？'); ?>
                </div>
            </td>
            <td style="width:70%;">
                <!-- 新着情報 -->
                <div id='message-list'>
                    <font style='font-weight: bold;font-size: 110%;'>[新着情報]</font><br>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void">
            <tr style='background-color: #459ed2;'>
                <th colspan="2">○&nbsp;メッセージ</th>
            </tr>
            <tr>
                <td width="10px">&nbsp;</td>
                <td>
<?php if ($new_count == 0) { ?>
                    新着メッセージはありません。
<?php } else { ?>
                    <a href="<?=ROOTDIR ?>/message/index"><font style="color: blue;font-weight: bold;"><?=$new_count ?>&nbsp;通</font>の新着メッセージがあります。</a>
<?php } ?>
                </td>
            </tr>
            <tr style='background-color: #459ed2;'>
                <th colspan="2">○&nbsp;管理者からのお知らせ</th>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>特にありません。</td>
            </tr>
            
        </table>

        <?php echo $this->Form->end(); ?>
                </div>
                </td>
        </tr>
    </table>
</div>

