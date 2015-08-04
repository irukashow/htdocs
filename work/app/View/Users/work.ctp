<div id="page3" data-role="page">
    <div data-role="header" data-theme="c">
            <h1>勤務関連</h1>
            <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
    </div>			
    <div data-role="content">
        <b>勤務関連</b>
        <p>以下の変更ができます。</p>
        <input type="button" value="１．タイムカード" data-icon="arrow-r" data-iconpos="right" onclick='location.href="<?=ROOTDIR ?>/users/work_timecard"'>
        <input type="button" value="２．給与確認" data-icon="arrow-r" data-iconpos="right" onclick='location.href="#salary"'>
        <div style='float:left;'>       
            <input type="button" value="ホーム" data-theme="b" data-icon="home" onclick='location.href="<?=ROOTDIR ?>/users/index#home"'>
        </div> 
    </div>
    <div class="pagetop">
            <a href="#page3">
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

