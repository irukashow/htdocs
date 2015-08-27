<div id="dialog_menu" data-role="dialog">
    <ul data-role="listview">
        <input type="button" value="メッセージ" data-icon="arrow-r" data-iconpos="right" onclick='location.href="<?=ROOTDIR ?>/users/message#page1"'>
        <input type="button" value="スケジュール" data-icon="arrow-r" data-iconpos="right" onclick='location.href="<?=ROOTDIR ?>/users/schedule#page3"'>
        <input type="button" value="勤務について" data-icon="arrow-r" data-iconpos="right" onclick='location.href="<?=ROOTDIR ?>/users/work#page3"'>
        <input type="button" value="プロフィール" data-icon="arrow-r" data-iconpos="right" onclick='location.href="<?=ROOTDIR ?>/users/profile#page4"'>
        <input type="button" value="ホーム" data-theme="b" data-icon="home" data-inline="true" onclick='location.href="<?=ROOTDIR ?>/users/index#home"'>
        <a href="#" data-role="button" data-theme="b" data-rel="back" data-icon="delete" data-inline="true">閉じる</a>
        <input type="button" value="ログアウト" data-theme="b" data-icon="check" data-inline="true" onclick='location.href="<?=ROOTDIR ?>/users/logout"'>
    </ul>
</div>