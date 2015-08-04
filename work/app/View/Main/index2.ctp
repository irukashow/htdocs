<div data-role="page" id="top">
	<div data-role="panel" id="menu-left" data-theme="b" data-display="push">
		<ul data-role="listview">
			<li data-role="list-divider">サービス</li>
			<li><a href="#">メール</a></li>
			<li><a href="#">連絡先</a></li>
			<li><a href="#">カレンダー</a></li>
			<li><a href="#">タスク</a></li>
			<li><a href="#">SNS</a></li>
			<li><a href="#">ブログ</a></li>
			<li><a href="#">アプリ</a></li>
			<li><a href="#">ドキュメント</a></li>
			<li><a href="#">履歴</a></li>
		</ul>
	</div>
	<div data-role="panel" id="menu-right" data-position="right" data-theme="b" data-display="overlay">
		<ul data-role="listview">
			<li data-role="list-divider">設定</li>
			<li><a href="#">デザイン</a></li>
			<li><a href="#">プロフィール</a></li>
			<li><a href="#">パスワード</a></li>
			<li><a href="#">コンテンツ</a></li>
			<li><a href="#">ネットワーク</a></li>
			<li><a href="#">印刷</a></li>
			<li><a href="#">言語</a></li>
			<li><a href="#">システム</a></li>
			<li><a href="#">環境</a></li>
			<li><a href="#">設定リセット</a></li>
		</ul>
	</div>
	<div data-role="header">
		<a href="#menu-left" class="ui-btn ui-icon-bars ui-btn-icon-left ui-corner-all">メニュー</a>
		<a href="#menu-right" class="ui-btn ui-icon-gear ui-btn-icon-left ui-corner-all">設定</a>
		<h1>DEMOページ</h1>
	</div>
	<div role="main" class="ui-content">
		<h3>パネルウィジェットデモページ</h3>
		<h4>表示方法：data-display="push"</h4>
		<p>ヘッダーのメニューボタンをクリックすると、左からコンテンツを押し出すようにサービスメニューが一緒にスライドして出てきます。</p>
		<h4>表示方法：data-display="overlay"</h4>
		<p>ヘッダーの設定ボタンをクリックすると、コンテンツは動かず右から設定メニューがスライドしてコンテンツの上にオーバーレイします。</p>
		<p>メニュー外をクリックするかメニューをスワイプすると閉じます。<br />
			ESCキーを押しても閉じます。</p>
	</div>
	<div data-role="footer">
		<p>&copy; 2014 Web Tips アーカイブ</p>
	</div>
</div>