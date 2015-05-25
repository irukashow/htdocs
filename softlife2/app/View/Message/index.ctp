<?php
    echo $this->Html->css('message');
?>

<!-- 見出し -->
<div id='headline'>
    ★ メッセージボックス
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="#" target="" id='button-send'>メッセージを送る</a>
</div>

<!-- メインペイン -->
<div id='message-main'>
    <table border="0" style="width:100%;">
        <tr>
            <td style="width:30%;">
    <!-- メッセージボックス -->
    <div id='message-folder'>
        フォルダなど
    </div>
            </td>
            <td style="width:70%;">
    <!-- メッセージ一覧 -->
    <div id='message-list'>
        <font style='font-weight: bold;font-size: 110%;'>[受信箱]</font>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void">
            <tr style='background-color: #459ed2;'>
                <th style='width:5%;'>&nbsp;</th>
                <th style='width:50%;'>標題</th>
                <th style='width:20%;'>差出人</th>
                <th style='width:25%;'>作成日時</th>
            </tr>
            <tr>
                <td style="padding-top: 8px;">
                    <?php echo $this->Form->input('check',array('type'=>'checkbox','label'=>false)); ?>
                </td>
                <td class='message-content'><a href='#' style='text-decoration: none;'>案件Aについての問い合わせ</a></td>
                <td class='message-content'><a href='#' style='text-decoration: none;'>福島 亜希子</a></td>
                <td class='message-content'>2015-07-15 10:27</td>
            </tr>
            <tr>
                <td style="padding-top: 8px;">
                    <?php echo $this->Form->input('check',array('type'=>'checkbox','label'=>false)); ?>
                </td>
                <td class='message-content'><a href='#' style='text-decoration: none;'>案件Aについての問い合わせ</a></td>
                <td class='message-content'><a href='#' style='text-decoration: none;'>福島 亜希子</a></td>
                <td class='message-content'>2015-07-15 10:27</td>
            </tr>
        </table>
    </div>
                </td>
        </tr>
    </table>
</div>