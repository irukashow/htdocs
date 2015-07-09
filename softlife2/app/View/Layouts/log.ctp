<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("analyticstracking.php") ?>
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
    echo $this->Html->css('log');
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
                <td style="width:350px;float:left;padding-top: 7px;">
                    <a href="<?=ROOTDIR ?>/users/"><img src="<?=ROOTDIR ?>/img/logo.gif"></a>
                    <font size="3" style="vertical-align: 8px;">
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
    </div>
    <div id="footer">
      <?php echo FOOTER; ?>
    </div>
  </div>
 </body>
</html>