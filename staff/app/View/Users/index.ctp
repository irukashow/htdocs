<!----home---------------------------->
<div id="home" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>株式会社ソフトライフ</h1>
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>
        <div class="logo">
            <?php echo $this->Html->image('logo.gif', array('style'=>'width: 50%;')); ?>
        </div>
        <div class="main_img">
            <?php echo $this->Html->image('sample1_2+.png'); ?>
        </div>
        <!--
        <div  class="sub_img">
                <a href="http://sumaho-design.com/" target="_blank"><img src="img/sample1_3.png"></a>
        </div>
        -->
        <div data-role="content">
            <!---トップリストビュー----------------------------->
            <ul data-role="listview">
                <li class="toplist_news">
                    <a href="http://sumaho-design.com/" target="_blank">
                            <p>2013.01.02</p>
                            新商品の販売開始に伴いキャンペーン実施中です。詳細はこちら
                    </a>
                </li>
                <li class="toplist_news">
                        <p>2013.01.01</p>
                        ホームページをリニューアルしました。
                </li>
                <li class="toplist_menu1"><a href="#page1">メッセージ</a></li>
                <li class="toplist_menu1"><a href="#page2">スケジュール</a></li>
                <li class="toplist_menu1"><a href="#page3">勤怠入力</a></li>
                <li class="toplist_menu1"><a href="#page4">プロフィール</a></li>
                <li class="toplist_menu2"><a href="http://www.softlife.co.jp/" target="_blank">ソフトライフ ホームページ</a></li>
                <li class="toplist_menu2"><a href="<?=ROOTDIR ?>/users/logout">ログアウト</a></li>
            </ul>
        </div>
        <div class="pagetop">
                <a href="#home">
                    <?php echo $this->Html->image('pagetop.png'); ?>
                </a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div>
<!-----home end-------------->


<!----page1---------------------------->
<div id="page1" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>メッセージ</h1>
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>
        <div data-role="content">
                <p>このページはsample page1です。<br>自由にカスタマイズして使ってください。</p>
                <p>カスタマイズ方法については下記の「jQMスマホサイト作成について」を参考にしてみてください。</p>
                <a href="http://sumaho-design.com/jqm.html" target="_blank" data-role="button">jQMスマホサイト作成について</a>
        </div>
        <div class="pagetop">
                <a href="#page1"><img src="img/pagetop.png"></a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div><!-----page1 end-------------->


<!----page2---------------------------->
<div id="page2" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>スケジュール</h1>
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>
        <div data-role="content">
            <h3>シフト希望表</h3>
                <p>来月8月で勤務可能な日に入力をお願いいたします。</p>
                <!--- シフト希望表 --->
                
                
                <a href="" target="_blank" data-role="button"></a>
        </div>
        <div class="pagetop">
                <a href="#page2"><img src="img/pagetop.png"></a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div><!-----page2 end-------------->


<!----page3---------------------------->
<div id="page3" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>勤怠入力</h1>
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>
        <div data-role="content">
                <p>このページはsample page3です。<br>自由にカスタマイズして使ってください。</p>
                <p>ボタン作成方法については下記の「ボタンについて」を参考にしてみてください。</p>
                <a href="" target="_blank" data-role="button">ボタンについて</a>
        </div>
        <div class="pagetop">
                <a href="#page3"><img src="img/pagetop.png"></a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div><!-----page3 end-------------->

<!----プロフィール（変更）---------------------------->
<?php require('profile.ctp'); ?>
<!-----プロフィール（変更） end-------------->

<!--ダイアログメニュー-->
<div id="dialog_menu" data-role="dialog">
    <ul data-role="listview">
        <a href="#page1" data-role="button" data-icon="arrow-r" data-iconpos="right">メッセージ</a>
        <a href="#page2" data-role="button" data-icon="arrow-r" data-iconpos="right">スケジュール</a>
        <a href="#page3" data-role="button" data-icon="arrow-r" data-iconpos="right">勤怠入力</a>
        <a href="#page4" data-role="button" data-icon="arrow-r" data-iconpos="right">プロフィール</a>
        <a href="#home" data-role="button" data-theme="b" data-icon="home" data-inline="true">ホーム</a>
        <a href="#" data-role="button" data-theme="b" data-rel="back" data-icon="delete" data-inline="true">閉じる</a>
        <a href="<?=ROOTDIR ?>/users/logout" data-role="button" data-theme="b" data-icon="check" data-inline="true">ログアウト</a>
    </ul>
</div>
<!--ダイアログメニュー end-->

