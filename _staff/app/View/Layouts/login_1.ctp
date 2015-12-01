<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("analyticstracking.php") ?>
  <?php echo $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <title>
    <?php echo $title_for_layout; ?>
  </title>
  <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('main');
    //echo $this->Html->css( 'page');
    echo $this->Html->css( 'Style');
    //echo $this->Html->css( 'Style_SP');
    //echo $this->Html->css( 'jquery-ui-1.10.3.custom');
    //echo $this->Html->css( 'jquery.ui.theme');
    echo $scripts_for_layout;
  ?>
</head>
<body>
  <div id="container">
    <div id="header">
        <table style="width: 100%;height: 40px;">
            <tr>
                <td style="width:150px;">
                    <a href="<?=ROOTDIR ?>/users/"><img src="<?=ROOTDIR ?>/img/rogo2.png"></a>
                </td>
                <td style="width:350px;float:left;padding-top: 10px;">
                    <font size="3" style="">
                        <?php echo HEADER; ?>
                    </font>
                </td>
                <td style="float: right;">
                </td>
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