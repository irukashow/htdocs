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
        <table style="width: 100%;">
            <tr>
                <td>
                    <a href="/softlife2/users/" class="logo">&nbsp;</a>
                    <?php echo $header_for_layout; ?>
                </td>
                <td style="text-align: right;">
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