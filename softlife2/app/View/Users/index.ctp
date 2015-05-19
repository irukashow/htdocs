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
    <b>管理者からのお知らせ</b><br>
    <table border="1" style="width:100%;">
        <tr>
            <th>&nbsp;</th>
            <th>タイトル</th>
            <th>送信者</th>
            <th>日時</th>
        </tr>
        <tr>
            <td>1</td>
            <td><a href="#">タイトルタイトルタイトルタイトルタイトル</a></td>
            <td>管理者</td>
            <td>2015-05-15 18:13</td>
        </tr>
        <tr>
            <td>2</td>
            <td><a href="#">タイトル</a></td>
            <td>管理者</td>
            <td>2015-05-14 15:21</td>
        </tr>
        <tr>
            <td>3</td>
            <td><a href="#">タイトル</a></td>
            <td>管理者</td>
            <td>2015-05-10 11:09</td>
        </tr>
    </table>
</div>
<div style="clear:both;"></div>