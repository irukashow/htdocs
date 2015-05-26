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
        <table style="width: 100%;" border="0">
            <tr>
                <td style="padding-top: 11px;">
                    <a href="/softlife2/users/" class="logo">&nbsp;</a>
                    <font size="3">
                        <?php echo HEADER; ?>
                    </font>
                </td>
                <td style="">
                </td>
        </table>
    </div>
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