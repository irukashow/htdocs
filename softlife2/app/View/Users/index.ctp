<!-- 見出し -->
<div id='headline'>
    ★ ホーム
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="" target="_blank"></a>
    <a href="" target="_blank"></a>
    <a href="" target="_blank"></a>
</div>
<div style='float:left;width: 30%;'>
    <b>ようこそ！！</b>
    <br>
    <?php echo $this->Html->link('パスワード変更', '/users/passwd/'); ?>
    <br>
    <?php echo $this->Html->link('ログアウト', 'logout', array('title'=>'確認'), 'ログアウトしてもよろしいですか？'); ?>
</div>
<div style="float: left;width:65%;">
    <b>お知らせ</b><br>
    <table border="1" style="width:100%;">
        <tr>
            <td>日時</td>
            <td>タイトル</td>
            <td>送信者</td>
        </tr>
        <tr>
            <td>2015-05-15 18:13</td>
            <td>タイトルタイトルタイトルタイトルタイトル</td>
            <td>管理者</td>
        </tr>
        <tr>
            <td>2015-05-14 15:21</td>
            <td>タイトル</td>
            <td>管理者</td>
        </tr>
        <tr>
            <td>2015-05-10 11:09</td>
            <td>タイトル</td>
            <td>管理者</td>
        </tr>
    </table>
</div>
<div style="clear:both;"></div>