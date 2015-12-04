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
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/sunny/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
  <?php
   // echo $this->Html->meta('icon');
    echo $this->Html->meta('favicon.ico','/favicon.ico',array('type' => 'icon'));
    echo $this->Html->css('main');
    echo $this->Html->script('jquery.blockUI');
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
<!--
<script type="text/javascript">google.load("jquery", "1.7");</script>
-->
<script type="text/javascript">
$(function() {
	$("#menu li").hover(function() {
		$(this).children('ul').show();
	}, function() {
		$(this).children('ul').hide();
	});
});
</script>
<script type="text/javascript">
$(document).ready(function() { 
  $('.check').click(function() {
    $.blockUI({
      message: '<?=$this->Html->image('busy.gif'); ?> 処理中...少々お待ちください。',
      css: {
        border: 'none',
        padding: '10px',
        backgroundColor: 'white',
        opacity: .5,
        color: 'black'
      },
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6
      }
    });
    setTimeout($.unblockUI, 30000);
  });
  $('.load').click(function() {
    $.blockUI({
      message: '<?=$this->Html->image('busy.gif'); ?> ロード中...少々お待ちください。',
      css: {
        border: 'none',
        padding: '10px',
        backgroundColor: 'white',
        opacity: .5,
        color: 'black'
      },
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6
      }
    });
    setTimeout($.unblockUI, 10000);
  });
  $('.load2').change(function() {
    $.blockUI({
      message: '<?=$this->Html->image('busy.gif'); ?> ロード中...少々お待ちください。',
      css: {
        border: 'none',
        padding: '10px',
        backgroundColor: 'white',
        opacity: .5,
        color: 'black'
      },
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6
      }
    });
    setTimeout($.unblockUI, 20000);
  });
  
}); 
</script> 

</head>
<body>
<!-- ヘッダ部分 -->
  <div id="container">
    <div id="header">
        <table id="header_table" style="width: 100%;" border="0" style="">
            <tr>
                <td style="width:150px;padding-top: 0px;">
                    <a href="<?=ROOTDIR ?>/users/"><img src="<?=ROOTDIR ?>/img/rogo2.png"></a>
                </td>
                <td style="width:350px;font-family: Meiryo, メイリオ,'lucida grande',verdana,helvetica,arial,sans-serif;">
                    <font size="3" style="vertical-align: 6px;">
                        <?php echo HEADER; ?>
                    </font>
                </td>
                <td>&nbsp;</td>
                <td style="width:330px;float: right;padding-top: 5px;font-family: Meiryo, メイリオ,'lucida grande',verdana,helvetica,arial,sans-serif;">
                    <ul  id="menu">
                        <li>リンク <font style='font-size:50%;vertical-align: 2px;'>▼</font>
                            <ul>
                                <li><a href="http://www.softlife.co.jp/" target="_blank">会社ホームページ</a></li>
                                <li><a href="http://softlife.co.jp/cb9/ag.cgi?" target="_blank">サイボウズ</a></li>
                                <li><a href="http://staff.softlife.biz/" target="_blank">スタッフ専用サイト</a></li>
                            </ul>
                        </li>
                        <li style="width:130px;">
                            <?php
                                if($auth->loggedIn()){
                                    echo '<font style="font-size:100%;">'.$user_name.' </font><font style="font-size:50%;vertical-align: 2px;">▼</font>';
                            ?>
                                <ul>
                                    <li><a href="<?=ROOTDIR ?>/users/passwd">パスワード変更</a></li>
                                    <li><a href="<?=ROOTDIR ?>/menu/version/sort:id/direction:desc">バージョン情報</a></li>
                                    <li><a href="<?=ROOTDIR ?>/users/logout">ログアウト</a></li>
                                </ul>
                            <?php
                                } else {
                                    echo '<a href="login">ログイン</a>';
                                }
                             ?>

                        </li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
      <div style="clear:none;"></div>
    <div id="content">
      
        <!-- メニュー部分 START -->
        <table id="menu_table" border="0" style="width:100%;">
            <tr>
                <td>
                    <div id='cssmenu'>
                        <ul>
                            <li class='<?= $active1 ?>'><a href='<?=ROOTDIR ?>/users/'>ホーム<br><div>Home</div></a></li>
                           <li class='<?= $active2 ?>'><a href='<?=ROOTDIR ?>/message/'>メッセージ<br><div>Message</div></a></li> <!--  onclick='alert("制作中");' -->
                           <li class='<?= $active3 ?>'><a href='<?=ROOTDIR ?>/StaffMasters/index/0'>スタッフ管理<br><div>Staff Management</div></a></li>
                           <li class='<?= $active4 ?>'><a href='<?=ROOTDIR ?>/CaseManagement/index/0'>案件管理<br><div>Case Management</div></a></li>
                           <li class='<?= $active5 ?>'><a href='<?=ROOTDIR ?>/ShiftManagement/index/'>シフト管理<br><div>Shift Management</div></a></li>
                           <li class='<?= $active6 ?>'><a href='<?=ROOTDIR ?>/SalesSalary/index/'>売上給与<br><div>Sales Salary</div></a></li>
                           <li class='<?= $active7 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
                           <li class='<?= $active8 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
                           <li class='<?= $active8 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
                           <li class='<?= $active10 ?>'><a href='<?=ROOTDIR ?>/admin/'>管理者ページ<br><div>Administrator</div></a></li>
                        </ul>
                    </div>
                </td>
                <td style="text-align: center;width:170px;vertical-align: bottom;">
                    <?php echo $this->Form->create('Common', array('name' => 'form')); ?>
                    <?php echo $this->Form->input('class', array('name'=>'class','type'=>'select','label'=>false,'div'=>false, 
                        'style' => '','id' => 'class', 'selected' => $selected_class,
                        'onChange'=>'form.submit();', 'options'=>$class)); ?>
                    <?php echo $this->Form->end(); ?>
                </td>
            </tr>
        </table>

        <div style="clear: both;height:10px;">&nbsp;</div>
        <!-- メニュー部分 END -->
        <?php echo $this->Session->flash(); ?>
      <?php echo $content_for_layout; ?>
    </div>
    <div id="footer" style="font-family: Meiryo, メイリオ,'lucida grande',verdana,helvetica,arial,sans-serif;">
      <?php echo FOOTER; ?>
    </div>
  </div>
 </body>
</html>