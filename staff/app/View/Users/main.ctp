<!-- topページ -->
<div id="home" data-role="page">
    <div data-role="header">
        <h1>登録</h1>
    </div>                    
    <div role="main" class="ui-content">
        <p>コンテンツページです</p>
        <a href="#p1" class="ui-btn">P1へ</a>
        <?php echo $this->Html->link('トップページ', 'index'); ?>
    </div>
</div>
 
<!-- p1 -->
<div id="p1" data-role="page">
    <div data-role="header">
        <a data-rel="back">Back</a>
        <h1>1ページ目</h1>
    </div>                    
    <div role="main" class="ui-content">
        <p>1ページ目です</p>
        <a href="#p2" class="ui-btn" data-transition="slide">P2へ</a>
    </div>
</div>
 
<!-- p2 -->
<div id="p2" data-role="page">
    <div data-role="header">
        <a data-rel="back">Back</a>
        <h1>2ページ目</h1>
        <a href="#home">Home</a>
    </div>                    
    <div role="main" class="ui-content">
        <p>2ページ目です</p>
    </div>
</div>