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

</head>
<body>
<!-- ヘッダ部分 -->
  <div id="container">
    <div id="header">
        <table style="width: 100%;height: 40px;" border="0">
            <tr>
                <td style="width:300px;float:left;">
                    <a href="/softlife2/users/" class="logo">&nbsp;</a>
                    <font size="3">
                        <?php echo HEADER; ?>
                    </font>
                </td>
                <td>&nbsp;</td>
                
        </table>
    </div>
      <div style="clear:none;"></div>
    <div id="content">
        <?php echo $this->Session->flash(); ?>
      <?php echo $content_for_layout; ?>
        <br>
        <a href='/softlife2/admin/'>管理者ページへ戻る</a>
    </div>
    <div id="footer">
      <?php echo FOOTER; ?>
    </div>
  </div>
 </body>
</html>