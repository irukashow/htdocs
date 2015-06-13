<div data-role="page" id="home">
	<div data-role="header">
		<h1>ホーム</h1>
	</div>
	<div role="main" class="ui-content">
		<div data-role="navbar" data-iconpos="top">
			<ul>
				<li><a href="#" data-icon="home" class="ui-btn-active ui-state-persist">ホーム</a></li>
				<li><a href="#profile" data-icon="user">プロフィール</a></li>
				<li><a href="#inquiry" data-icon="mail">メッセージ</a></li>
			</ul>
		</div>
		<p>シフトの確認</p>
                <p>勤怠入力</p>
                <p>給与情報</p>
	</div>
	<div data-role="footer">
            <h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
	</div>
</div>
 
<div data-role="page" id="profile">
	<div data-role="header">
		<h1>プロフィール</h1>
	</div>
	<div role="main" class="ui-content">
		<div data-role="navbar">
			<ul>
				<li><a href="#home" data-icon="home">ホーム</a></li>
				<li><a href="#" data-icon="user" class="ui-btn-active ui-state-persist">プロフィール</a></li>
				<li><a href="#inquiry" data-icon="mail">メッセージ</a></li>
			</ul>
		</div>
                <p>プロフィールの修正</p>
	</div>
	<div data-role="footer">
		<h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
	</div>
</div>
 
<div data-role="page" id="inquiry">
	<div data-role="header">
		<h1>メッセージ</h1>
	</div>
	<div role="main" class="ui-content">
		<div data-role="navbar">
			<ul>
				<li><a href="#home" data-icon="home">ホーム</a></li>
				<li><a href="#profile" data-icon="user">プロフィール</a></li>
				<li><a href="#" data-icon="mail" class="ui-btn-active ui-state-persist">メッセージ</a></li>
			</ul>
		</div>
		<p>メッセージの閲覧・送信</p>
                <ul data-role="listview" data-count-theme="b">
                    <li data-icon="mail"><a href="#">受信トレイ<span class="ui-li-count">368</span></a></li>
                    <li data-icon="edit"><a href="#">下書き<span class="ui-li-count">5</span></a></li>
                    <li data-icon="action"><a href="#">送信済み<span class="ui-li-count">254</span></a></li>
                    <li data-icon="delete"><a href="#">削除済み<span class="ui-li-count">64</span></a></li>
                </ul>
	</div>
	<div data-role="footer">
		<h2>&copy; 2015 SOFTLIFE Co., Ltd.</h2>
	</div>
</div>