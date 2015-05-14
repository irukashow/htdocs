<?php
    if($auth->loggedIn())
    {
        //echo $this->Html->link('ログアウト', '/users/logout/');
    }else{
        //echo $this->Html->link('ログイン', '/users/login/');
        // ログイン画面へ遷移
        //header('Location: login');
        //exit();
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
    echo $this->Html->css('common');
    echo $this->Html->css( 'page');
    echo $this->Html->css( 'Style');
    //echo $this->Html->css( 'Style_SP');
    echo $this->Html->css( 'jquery-ui-1.10.3.custom');
    //echo $this->Html->css( 'jquery.ui.theme');
    echo $scripts_for_layout;
  ?>
    <script>
        $(function(){
            $('#menu li').hover(function(){
                $("ul:not(:animated)", this).slideDown();
            }, function(){
                $("ul.child",this).slideUp();
            });
        });        
    </script>   
</head>
<body>
  <div id="container">
    <div id="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <a href="/softlife2/users/" class="logo">&nbsp;</a>
                    <?php echo $header_for_layout; ?>
                </td>
                <td style="text-align: right;">
                    <ul  id="menu" style="list-style-type : none;">
                        <li><?php echo $this->Html->link($user_name.'さん ▼','index',array('style' => 'text-decoration: none;')); ?> </li>
                    </ul>
                </td>
        </table>
    </div>
    <div id="content">
      <?php echo $this->Session->flash(); ?>
      <?php echo $content_for_layout; ?>
    </div>
    <div id="footer">
      <?php echo $footer_for_layout; ?>
    </div>
  </div>
 </body>
</html>