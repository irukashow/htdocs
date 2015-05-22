<?php
    if($auth->loggedIn())
    {
        //echo $this->Html->link('ログアウト', '/users/logout/');
    }else{
        //echo $this->Html->link('ログイン', '/users/login/');
        // ログイン画面へ遷移
        //header('Location: login');
        //exit();
        //echo '<script type="text/javascript">location.href = "/softlife2/users/login/"</script>';
    }
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php echo $this->Html->charset(); ?>
  <title>
    <?php echo $title_for_layout; ?>
  </title>
  <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('main');
    //echo $this->Html->css( 'page');
    //echo $this->Html->css( 'Style');
    //echo $this->Html->css( 'Style_SP');
    //echo $this->Html->css( 'jquery-ui-1.10.3.custom');
    //echo $this->Html->css( 'jquery.ui.theme');
    //echo $this->Html->css('bootstrap.min');
    //echo $this->Html->css('bootstrap-theme.min');
    echo $this->Html->css('menu-styles');
    //echo $this->Html->script('bootstrap');
    //echo $this->Html->script('station');
    
    echo $scripts_for_layout;
  ?>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">google.load("jquery", "1.7");</script>
<script type="text/javascript">
$(function() {
	$("#menu li").hover(function() {
		$(this).children('ul').show();
	}, function() {
		$(this).children('ul').hide();
	});
});
</script>
</head>
<body>
<!-- ヘッダ部分 -->
  <div id="container">
    <div id="header">
        <table style="width: 100%;height: 40px;">
            <tr>
                <td>
                    <a href="/softlife2/users/" class="logo">&nbsp;</a>
                    <font size="3">
                        <?php echo HEADER; ?>
                    </font>
                </td>
                <td style="float: right;">
                    <ul  id="menu">
                        <li>リンク <font style='font-size:50%;vertical-align: 2px;'>▼</font>
                            <ul>
                                <li><a href="#">サブメニュー</a></li>
                                <li><a href="#">サブメニュー</a></li>
                                <li><a href="#">サブメニュー</a></li>
                            </ul>
                        </li>
                        <li style="width:150px;">
                            <?php
                                if($auth->loggedIn()){
                                    echo $user_name.'さん <font style="font-size:50%;vertical-align: 2px;">▼</font>';
                            ?>
                                <ul>
                                    <li><a href="/softlife2/users/passwd">パスワード変更</a></li>
                                    <li><a href="#">バージョン情報</a></li>
                                    <li><a href="/softlife2/users/logout">ログアウト</a></li>
                                </ul>
                            <?php
                                } else {
                                    echo '<a href="login">ログイン</a>';
                                }
                             ?>

                        </li>
                    </ul>
                </td>
        </table>
    </div>
      <div style="clear:none;"></div>
    <div id="content">
      
        <!-- メニュー部分 START -->
<div id='cssmenu'>
    <ul>
        <li class='<?= $active1 ?>'><a href='/softlife2/users/'>ホーム<br><div>Home</div></a></li>
       <li class='<?= $active2 ?>'><a href='/softlife2/message/'>メッセージ<br><div>Message</div></a></li>
       <li class='<?= $active3 ?>'><a href='/softlife2/stuff_masters/'>スタッフ管理<br><div>Stuff Management</div></a></li>
       <li class='<?= $active4 ?>'><a href='/softlife2/case_management/'>案件管理<br><div>Case Management</div></a></li>
       <li class='<?= $active5 ?>'><a href='#'>その他<br><div>etc</div></a></li>
       <li class='<?= $active6 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
       <li class='<?= $active7 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
       <li class='<?= $active8 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
       <li class='<?= $active9 ?>'><a href='/softlife2/admin/'>管理者ページ<br><div>Administrator</div></a></li>
       <li class='<?= $active10 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
    </ul>
    </div>
        <div style="clear: both;height:10px;">&nbsp;</div>
        <!-- メニュー部分 END -->
        <?php echo $this->Session->flash(); ?>
      <?php echo $content_for_layout; ?>
    </div>
    <div id="footer">
      <?php echo FOOTER; ?>
    </div>
  </div>
 </body>
</html>