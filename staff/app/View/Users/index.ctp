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
                <li class="toplist_menu1"><a href="<?=ROOTDIR ?>/users/message/1" style="color: white;font-weight: normal;text-shadow: 1px 1px 3px #666666;">メッセージ</a></li>
                <li class="toplist_menu1"><a href="<?=ROOTDIR ?>/users/schedule" style="color: white;font-weight: normal;text-shadow: 1px 1px 3px #666666;">スケジュール</a></li>
                <li class="toplist_menu1"><a href="<?=ROOTDIR ?>/users/work" style="color: white;font-weight: normal;text-shadow: 1px 1px 3px #666666;">勤務関連</a></li>
                <li class="toplist_menu1"><a href="<?=ROOTDIR ?>/users/profile" style="color: white;font-weight: normal;text-shadow: 1px 1px 3px #666666;">プロフィール</a></li>
                
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

<!----メッセージ---------------------------->
<!-----メッセージ end-------------->

<!----スケジュール---------------------------->
<!-----スケジュール end-------------->

<!----勤怠入力---------------------------->
<!-----勤怠入力 end-------------->

<!----プロフィール（変更）---------------------------->
<!-----プロフィール（変更） end-------------->

<!--ダイアログメニュー-->
<?php require('dialog_menu.ctp'); ?>
<!--ダイアログメニュー end-->

