<?php
    // 日付から曜日を日本語で割り出す関数
    function tag_weekday_japanese_convert( $date ){
        $weekday = array( '日', '月', '火', '水', '木', '金', '土' );
        return $weekday[date('w', strtotime( $date ) )];
    }
?>
<!-- メッセージ内容ページ -->
<div id="detail" data-role="page">
    <div data-role="header" data-theme="c">
            <h1>メッセージ内容</h1>
            <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
    </div>			
    <div data-role="content" style="font-size: 80%;">
    <?php echo $this->Form->create('Message2Member', array('name' => 'form')); ?>
        <table id="" border="0" width="99.5%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;">
            <tr style="background-color: #459ed2; color: white; font-weight: bold; font-size: 120%; text-shadow: 1px 1px 3px #666666;">
                <td>
                    <img src='<?=ROOTDIR ?>/img/msg.gif' style='vertical-align: -4px;'>
                    <?php echo $data['Message2Member']['title']; ?>
                </td>  
            </tr>
            <tr style="background-color: #ffffea;">
                <td>
                    送信時刻：<?= date('Y-m-d', strtotime($data['Message2Member']['created'])) ?>
                    (<?= tag_weekday_japanese_convert(strtotime($data['Message2Member']['created'])) ?>)
                    <?= date('H:i', strtotime($data['Message2Member']['created'])) ?>
                </td>
            </tr>
            <tr style="background-color: #ffffea;">
                <td>
                    宛先： <?php echo $name_member; ?>
                </td>
            </tr>
            <tr style="background-color: #ffffff; ">
                <td align="left" style="">
                </td>
            </tr>
            <tr style="background-color: #ffffff;">
                <td align="left">
                    <?php echo str_replace("\n","<br />",$data['Message2Member']['body']); ?>
                </td>
            </tr>
            <tr style="background-color: #ffffff;">
                <td align="left">

                </td>
            </tr>
            <tr style="background-color: #ffffea;">
                <td>
    <?php 
        if (!empty($data['Message2Member']['attachment'])) {
            $files = explode(',', $data['Message2Member']['attachment']);
            echo '<HR>';
            echo '<font color=green style="font-weight: bold;">添付ファイル</font>：（右クリックして保存してください）<br>';
            foreach ($files as $file) {
                if (!empty($file)) {
                    echo '<a href="'.STAFF_URL.'/files/message/member/'.sprintf("%07d", $data['Message2Member']['recipient_member']).'/'.$file.'" target="_blank">'.$file.'</a><br>';
                }
            }
        } 
    ?>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <div style='float:left;'>
                        <input type="button" value="戻　る" data-inline="true" onclick='location.href="<?=ROOTDIR ?>/users/message/2"'>
                    </div>
                </td>
            </tr>
        </table>
    <?php echo $this->Form->end(); ?>
    </div>
    <div class="pagetop">
            <a href="#detail">
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