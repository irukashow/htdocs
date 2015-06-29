<?php 
    // 所属カンマ区切りを配列に
    $value = explode(',', $result['User']['auth']);
    //$this->log($value);
    // 所属コンボセット
    foreach($value as $val) {
        if ($val == '11') {
            $class['11'] = '大阪-人材派遣';
        }
        if ($val == '12') {
            $class['12'] = '大阪-住宅営業';
        }
        if ($val == '21') {
            $class['21'] = '東京-人材派遣';
        }
        if ($val == '22') {
            $class['22'] = '東京-住宅営業';
        }
        if ($val == '31') {
            $class['31'] = '名古屋-人材派遣';
        }
        if ($val == '32') {
            $class['32'] = '名古屋-住宅営業';
        }   
    } 
?>


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
    //echo $this->Html->css('bootstrap-theme.min');
    echo $this->Html->css('menu-styles');
    
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
                <td style="width:350px;padding-top: 7px;">
                    <a href="<?=ROOTDIR ?>/users/"><img src="<?=ROOTDIR ?>/img/logo.gif" /></a>
                    <font size="3" style="vertical-align: 8px;">
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
        <!-- メニュー部分 START -->
  
      <?php echo $content_for_layout; ?>
    </div>
    <div id="footer">
      <?php echo FOOTER; ?>
    </div>
  </div>
 </body>
</html>