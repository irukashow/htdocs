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
<?php
  $ua=$_SERVER['HTTP_USER_AGENT'];
  $browser = ((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false));
    if ($browser == true){
    $browser = 'sp';
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
   // echo $this->Html->meta('icon');
    echo $this->Html->meta('favicon.ico','/favicon.ico',array('type' => 'icon'));
    //echo $this->Html->css('main');
    echo $this->Html->css('menu-styles');
    
    echo $scripts_for_layout;
  ?>
<?php if($browser == 'sp'){ ?>
    <link rel="stylesheet" type="text/css" href="<?=ROOTDIR ?>/css/main_mobile.css"/>
<?php }else{ ?>
    <link rel="stylesheet" type="text/css" href="<?=ROOTDIR ?>/css/main_pc.css" />
<?php } ?>
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
        <table style="width: 100%;" border="0">
            <tr>
                <td style="width:300px;">
                    <a href="<?=ROOTDIR ?>/users/" class="logo">&nbsp;</a>
                    <font size="4">
                        <?php echo HEADER; ?>
                    </font>
                </td>
                <td>&nbsp;</td>
                <td style="width:330px;float: right;padding-top: 5px;">&nbsp;</td>
            </tr>
        </table>
    </div>
      <div style="clear:none;"></div>
    <div id="content">

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