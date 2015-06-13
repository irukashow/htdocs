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
  <?php echo $this->Html->charset(); ?>
  <title>
    <?php echo $title_for_layout; ?>
  </title>
  <?php
   // echo $this->Html->meta('icon');
    echo $this->Html->meta('favicon.ico','/favicon.ico',array('type' => 'icon'));
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
        <table style="width: 100%;" border="0">
            <tr>
                <td style="width:300px;">
                    <a href="<?=ROOTDIR ?>/users/" class="logo">&nbsp;</a>
                    <font size="3">
                        <?php echo HEADER; ?>
                    </font>
                </td>
                <td>&nbsp;</td>
                <td style="width:330px;float: right;padding-top: 5px;">
                    <ul  id="menu">
                        <li>リンク <font style='font-size:50%;vertical-align: 2px;'>▼</font>
                            <ul>
                                <li><a href="http://www.softlife.co.jp/">会社ホームページ</a></li>
                                <li><a href="http://softlife.co.jp/cb9/ag.cgi?">サイボウズ</a></li>
                            </ul>
                        </li>
                        <li style="width:130px;">
                            <?php
                                if($auth->loggedIn()){
                                    echo '<font style="font-size:100%;">'.$user_name.' </font><font style="font-size:50%;vertical-align: 2px;">▼</font>';
                            ?>
                                <ul>
                                    <li><a href="<?=ROOTDIR ?>/users/passwd">パスワード変更</a></li>
                                    <li><a href="<?=ROOTDIR ?>/menu/version">バージョン情報</a></li>
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
        </table>
    </div>
      <div style="clear:none;"></div>
    <div id="content">
      
        <!-- メニュー部分 START -->
        <table border="0" style="width:100%;">
            <tr>
                <td>
                    <div id='cssmenu'>
                        <ul>
                            <li class='<?= $active1 ?>'><a href='<?=ROOTDIR ?>/users/'>ホーム<br><div>Home</div></a></li>
                           <li class='<?= $active2 ?>'><a href='<?=ROOTDIR ?>/message/'>メッセージ<br><div>Message</div></a></li>
                           <li class='<?= $active3 ?>'><a href='<?=ROOTDIR ?>/staff_masters/index/0'>スタッフ管理<br><div>Staff Management</div></a></li>
                           <li class='<?= $active4 ?>'><a href='<?=ROOTDIR ?>/case_management/'>案件管理<br><div>Case Management</div></a></li>
                           <li class='<?= $active5 ?>'><a href='' onclick='alert("追加予定")'>その他<br><div>etc</div></a></li>
                           <li class='<?= $active6 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
                           <li class='<?= $active7 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
                           <li class='<?= $active8 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
                           <li class='<?= $active9 ?>'><a href='<?=ROOTDIR ?>/admin/'>管理者ページ<br><div>Administrator</div></a></li>
                           <li class='<?= $active10 ?>'><a href='#'>&nbsp;<br><div>&nbsp;</div></a></li>
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
    <div id="footer">
      <?php echo FOOTER; ?>
    </div>
  </div>
 </body>
</html>