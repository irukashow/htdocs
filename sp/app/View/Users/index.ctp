<div data-role="page">
    <!---画像２の１部分---------------------->
    <div data-role="header">
        <h3>メインページ</h3>
    </div>                    
    <!---画像２の２部分---------------------->
    <div role="main" class="ui-content">
        <h2>content</h2>
        <p>「企業のカッコいいスマートフォンサイトのまとめ」と「jQueryMobileを使ったスマホサイト作成方法」の紹介をしております。</p>
        <p>また簡単にスマホサイトが作れる「簡単スマホサイト作成ツール」や「無料スマホサイトテンプレート」などの便利ツールもあります。</p>
        <p>スマホサイトを作成する際のデザインの参考などにご活用ください。</p>
        
        <?php echo $this->Html->link('コンテンツ', 'main'); ?>
        <div style="float:right;">
            <?php echo $this->Html->link('ログアウト', 'logout'); ?>
        </div>
        
    </div>
    <br>
    <!---画像２の３部分---------------------->
    <div data-role="footer">
        <h3>株式会社ソフトライフ</h3>
    </div>
</div>