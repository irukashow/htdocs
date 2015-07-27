<div data-role="page" id="home">
	<div data-role="header">
		<h1>ホーム</h1>
	</div>
	<div role="main" class="ui-content" style="padding-top: 5px;">
                <div style="float:right;"><?= $name ?> さん</div>
                <div style="clear:both;height:5px;"></div>
		<div data-role="navbar" data-iconpos="top">
			<ul>
				<li><a href="#" data-icon="home" class="ui-btn-active ui-state-persist">ホーム</a></li>
				<li><a href="#inquiry" data-icon="mail">メッセージ</a></li>
                                <li><a href="#schedule" data-icon="clock">スケジュール</a></li>
                                <li><a href="#edit" data-icon="edit">勤怠入力</a></li>
                                <li><a href="#profile" data-icon="user">プロフィール</a></li>
			</ul>
		</div>
		<p>シフトの確認</p>
                <p>勤怠入力</p>
                <p>給与情報</p>
                <p><a href="<?=ROOTDIR ?>/users/logout">ログアウト</a></p>
	</div>
	<div data-role="footer">
		<h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
	</div>
</div>

<!-- メッセージ -->
<div data-role="page" id="inquiry">
	<div data-role="header">
		<h1>メッセージ</h1>
	</div>
	<div role="main" class="ui-content" style="padding-top: 5px;">
                <div style="float:right;"><?= $name ?> さん</div>
                <div style="clear:both;height:5px;"></div>
		<div data-role="navbar">
			<ul>
				<li><a href="#home" data-icon="home">ホーム</a></li>
				<li><a href="#" data-icon="mail" class="ui-btn-active ui-state-persist">メッセージ</a></li>
                                <li><a href="#schedule" data-icon="clock">スケジュール</a></li>
                                <li><a href="#edit" data-icon="edit">勤怠入力</a></li>
                                <li><a href="#profile" data-icon="user">プロフィール</a></li>
			</ul>
		</div>
                <p><a href="<?=ROOTDIR ?>/message/index">メッセージの閲覧・送信</a></p>
	</div>
	<div data-role="footer">
		<h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
	</div>
</div>

<!-- スケジュール -->
<div data-role="page" id="schedule">
	<div data-role="header">
		<h1>スケジュール</h1>
	</div>
	<div role="main" class="ui-content" style="padding-top: 5px;">
                <div style="float:right;"><?= $name ?> さん</div>
                <div style="clear:both;height:5px;"></div>
		<div data-role="navbar">
			<ul>
				<li><a href="#home" data-icon="home">ホーム</a></li>
				<li><a href="#inquiry" data-icon="mail">メッセージ</a></li>
                                <li><a href="#" data-icon="clock" class="ui-btn-active ui-state-persist">スケジュール</a></li>
                                <li><a href="#edit" data-icon="edit">勤怠入力</a></li>
                                <li><a href="#profile" data-icon="user">プロフィール</a></li>
			</ul>
		</div>
                <p><a href="<?=ROOTDIR ?>/message/index">メッセージの閲覧・送信</a></p>
	</div>
	<div data-role="footer">
		<h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
	</div>
</div>

<!-- 勤怠入力 -->
<div data-role="page" id="edit">
	<div data-role="header">
		<h1>勤怠入力</h1>
	</div>
	<div role="main" class="ui-content" style="padding-top: 5px;">
                <div style="float:right;"><?= $name ?> さん</div>
                <div style="clear:both;height:5px;"></div>
		<div data-role="navbar">
			<ul>
				<li><a href="#home" data-icon="home">ホーム</a></li>
				<li><a href="#inquiry" data-icon="mail">メッセージ</a></li>
                                <li><a href="#schedule" data-icon="clock">スケジュール</a></li>
                                <li><a href="#" data-icon="edit" class="ui-btn-active ui-state-persist">勤怠入力</a></li>
                                <li><a href="#profile" data-icon="user">プロフィール</a></li>
			</ul>
		</div>
                <p><a href="<?=ROOTDIR ?>/message/index">メッセージの閲覧・送信</a></p>
	</div>
	<div data-role="footer">
		<h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
	</div>
</div>
 
<!-- プロフィール -->
<div data-role="page" id="profile">
	<div data-role="header">
		<h1>プロフィール</h1>
	</div>
	<div role="main" class="ui-content" style="padding-top: 5px;">
                <div style="float:right;"><?= $name ?> さん</div>
                <div style="clear:both;height:5px;"></div>
		<div data-role="navbar">
			<ul>
				<li><a href="#home" data-icon="home">ホーム</a></li>
				<li><a href="#inquiry" data-icon="mail">メッセージ</a></li>
                                <li><a href="#schedule" data-icon="clock">スケジュール</a></li>
                                <li><a href="#edit" data-icon="edit">勤怠入力</a></li>
				<li><a href="#" data-icon="user" class="ui-btn-active ui-state-persist">プロフィール</a></li>
			</ul>
		</div>
                <p>プロフィールの修正</p>
	</div>
	<div data-role="footer">
		<h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
	</div>
</div>
 
