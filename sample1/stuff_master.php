<?php
	require_once 'DB.php';

	function getSex($sex) {
		if ($sex == 1) {
			return "女性";
		} else if ($sex == 2) {
			return "男性";
		} else {
			return "未分類";
		}
	}

	function getNenmatsu($flag) {
		if ($flag == 1) {
			return "○";
		} else if ($flag == 0) {
			return "✕";
		} else {
			return "エラー";
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<TITLE>	 派遣管理システム-スタッフマスタ </TITLE>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<META name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes"> 
    
<SCRIPT src="js/jquery-1.9.1.js" type="text/javascript"></SCRIPT>
     
<SCRIPT src="js/jquery-ui-1.10.3.custom.js" type="text/javascript"></SCRIPT>

<link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
  $('#table_id').dataTable({
      "oLanguage" : {
         "sProcessing":   "処理中...",
         "sLengthMenu":   "_MENU_ 件表示",
         "sZeroRecords":  "データはありません。",
         "sInfo":         "_START_件～_END_件を表示（全_TOTAL_ 件中）",
         "sInfoEmpty":    " 0 件中 0 から 0 まで表示",
         "sInfoFiltered": "（全 _MAX_ 件より抽出）",
         "sInfoPostFix":  "",
         "sSearch":       "検索フィルター:",
         "sUrl":          "",
         "oPaginate": {
             "sFirst":    "先頭",
             "sPrevious": "前ページ",
             "sNext":     "次ページ",
             "sLast":     "最終"
         }
      }
  });
});
</script>

     <LINK href="js/jquery.mCustomScrollbar.css" rel="stylesheet" 
type="text/css" media="screen">     
<LINK href="js/Style_SP.css" 
rel="stylesheet" type="text/css" media="only screen and (max-device-width:480px)"> 
    <LINK href="js/Style.css" rel="stylesheet" type="text/css" 
media="screen and (min-device-width:481px)">     
<LINK href="js/page.css" 
rel="stylesheet" type="text/css">     
<LINK href="js/Class.css" 
rel="stylesheet" type="text/css">         
<LINK href="js/jquery.ui.all.css" 
rel="stylesheet" type="text/css">     
<LINK href="js/jquery-ui-1.10.3.custom.css" 
rel="stylesheet" type="text/css">     
<SCRIPT src="js/common.js" type="text/javascript"></SCRIPT>
     
<SCRIPT type="text/javascript">
        var ajax_top = '../../ajax';
        var system_top = '../../';

        var global_uid = '1';
        var global_szk = [];
    </SCRIPT>
         
<STYLE type="text/css">
        /*.buttonUI {margin:5px;}*/
        .buttonUI.new {color:Blue;}
        .buttonUI.update {color:Green;}
        .buttonUI.remove {color:Red;}
    </STYLE>
 
<META name="GENERATOR" content="MSHTML 11.00.9600.17728"></HEAD> 
<BODY>
<FORM name="aspnetForm" id="aspnetForm" action="a1.aspx" method="post" 
novalidate="">
<DIV><INPUT name="__EVENTTARGET" id="__EVENTTARGET" type="hidden"> <INPUT name="__EVENTARGUMENT" id="__EVENTARGUMENT" type="hidden"> 
<INPUT name="__LASTFOCUS" id="__LASTFOCUS" type="hidden"> <INPUT name="__VIEWSTATE" id="__VIEWSTATE" type="hidden" value="/wEPDwUJNDMyNDU0NjAzZGSF/1bEgfxVEy21q1kuC20DzACudgDEW0UPZq1eSGQeLA=="> 
</DIV>
 
 
<DIV><INPUT name="__SCROLLPOSITIONX" id="__SCROLLPOSITIONX" type="hidden" value="0">
	 <INPUT name="__SCROLLPOSITIONY" id="__SCROLLPOSITIONY" type="hidden" value="0"> 
</DIV>
<DIV style="display: none;"></DIV>
<DIV class="headerFix" style="background-color: white;">
<DIV id="targ1">
<TABLE width="100%" class="fix" style="border: 0px currentColor; border-image: none;"><!-- head --> 
              
  <TBODY>
  <TR>
    <TD style="padding: 0px;">
      <TABLE width="100%">
        <TBODY>
        <TR>
          <TD width="75"><A href="http://deprog.jp/" target="_blank"><IMG 
            class="head_rogo" style="border-width: 0px; height: 20px;" alt="Deprog Inc." 
            src="js/rogo3.jpg"></A></TD>
          <TD width="350" class="headTitle" valign="middle">派遣管理システム - 
          スタッフマスタ</TD>
          <TD class="r">
            <TABLE width="100%">
              <TBODY>
              <TR>
                <TD style="text-align: right;">                                
                              こんにちは、<B>システム&nbsp;管理者</B>さん                       
                                    </TD>
                <TD style="width: 110px; text-align: right;"><A style="color: blue;" 
                  href="http://softlife.info/xw-user/S101/index.aspx">システムメニュ</A> 
                                                          </TD>
                <TD style="width: 80px; text-align: right;"><A id="ctl00_btnLogout" 
                  style="color: red;" href="javascript:__doPostBack('ctl00$btnLogout','')">ログアウト</A> 
                                                          </TD>
                <TD style="width: 180px; text-align: right;"><SPAN 
                  watch=""></SPAN>                                         
              </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
      <HR class="ui-widget-header" style="margin: 0px;">
    </TD></TR><!-- head end -->             <!-- menu start -->             
  <TR>
    <TD style="padding: 0px;">
      <TABLE style="width: 100%;">
        <TBODY>
        <TR>
          <TD><!-- head start -->                     
<STYLE type="text/css">
                        .ui-menu { width: 150px; }
                        .menu { float:left; margin:5px; }
                    </STYLE>
                                 
<SCRIPT type="text/javascript">
                        $(function () {
                            $(".menu").menu({ position: { my: 'left top', at: 'left bottom'} });
                            $(".3").addClass("ui-state-default").css("color", "#fff");
                        });

                        $(function () {
                            $(".dataTables_wrapper").css("position", "static");
                            $(".dataTables_wrapper").find("table").addClass("table");
                        });
                    </SCRIPT>
                                 
            <UL class="menu 1">
              <LI><A href="http://softlife.info/xw-user/C101/index.aspx"><SPAN 
              class="ui-icon ui-icon-bullet"></SPAN>ホーム</A>                      
               </LI></UL>
            <UL class="menu 2">
              <LI><A href="http://softlife.info/xw-user/C101/mail.aspx"><SPAN 
              class="ui-icon ui-icon-bullet"></SPAN>メール</A>                      
               </LI></UL>
            <UL class="menu 3">
              <LI><A href="http://softlife.info/xw-user/C101/a1.aspx"><SPAN 
              class="ui-icon ui-icon-bullet"></SPAN>スタッフ管理</A>                   
                  </LI></UL>
            <UL class="menu 4">
              <LI><A href="http://softlife.info/xw-user/C101/b1.aspx"><SPAN 
              class="ui-icon ui-icon-bullet"></SPAN>案件管理</A>                     
                </LI></UL></TD>
          <TD style="width: 220px;"><SELECT name="ctl00$selSyozoku" class="selectUI " 
            id="selSyozoku" style="width: 200px;"><OPTION selected="selected" 
              value="1">大阪-人材派遣</OPTION> </SELECT>                                 
          </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></DIV>
<TABLE width="100%" class="ui-widget-content" style="border: 0px currentColor; border-image: none;">
  <TBODY>
  <TR>
    <TD style="padding: 0px;">
      <DIV title="展開・隠す" class="ui-state-highlight" id="pand1" style="height: 20px; text-align: center;" 
      open="">
      <DIV class="ui-icon ui-icon-eject" 
  style="height: 15px;"></DIV></DIV></TD></TR></TBODY></TABLE></DIV>
<TABLE width="100%" class="ui-widget-content" id="content_head" style="border: 0px currentColor; border-image: none;"><!-- menu end --> 
              
  <TBODY>
  <TR>
    <TD class="ui-widget-header" style="padding: 5px;">                    ▼ 
      スタッフマスタ                 </TD></TR>
  <TR>
    <TD><!-- content start --> 
      <DIV style="margin: 10px;">
      <DIV class="ui-state-highlight" style="margin: 10px; padding: 5px;"><A 
      style="margin: 5px; color: blue;" href="javascript:$WOpen('_staff2.aspx?id=0', '', 1400, 900);">新規作成</A> 
              <A id="remove1" style="margin: 5px; color: gray;" href="javascript:removeList('0');">登録リスト</A> 
              <A id="remove2" style="margin: 5px; color: red;" href="javascript:removeList('1');">登録解除リスト</A> 
          </DIV>
      <FIELDSET style="margin: 0px 10px 10px;"><LEGEND>駅検索</LEGEND>         
      <DIV style="float: left;"><SPAN>路線①</SPAN><SELECT id="PARM51" style="width: 100px;"></SELECT>&nbsp;&nbsp;<SELECT 
      id="PARM53" style="width: 150px;"></SELECT>&nbsp;&nbsp;<SELECT id="PARM55_from" 
      style="width: 150px;"></SELECT>駅&nbsp;&nbsp;～&nbsp;&nbsp;<SELECT id="PARM55_to" 
      style="width: 150px;"></SELECT>駅<BR><SPAN>路線②</SPAN><SELECT id="PARM61" 
      style="width: 100px;"></SELECT>&nbsp;&nbsp;<SELECT id="PARM63" style="width: 150px;"></SELECT>&nbsp;&nbsp;<SELECT 
      id="PARM65_from" 
      style="width: 150px;"></SELECT>駅&nbsp;&nbsp;～&nbsp;&nbsp;<SELECT id="PARM65_to" 
      style="width: 150px;"></SELECT>駅<BR><SPAN>路線③</SPAN><SELECT id="PARM71" 
      style="width: 100px;"></SELECT>&nbsp;&nbsp;<SELECT id="PARM73" style="width: 150px;"></SELECT>&nbsp;&nbsp;<SELECT 
      id="PARM75_from" 
      style="width: 150px;"></SELECT>駅&nbsp;&nbsp;～&nbsp;&nbsp;<SELECT id="PARM75_to" 
      style="width: 150px;"></SELECT>駅<BR></DIV>
      <DIV style="margin: 5px; float: left;"><INPUT class="buttonUI" onclick="ekiSearch();" type="button" value="検索"> 
              </DIV>
      <DIV style="clear: both;"></DIV></FIELDSET>
      <FIELDSET style="margin: 0px 10px 10px;"><LEGEND>年齢検索</LEGEND>         
      <DIV 
style="float: left;"><SPAN>年齢</SPAN><INPUT class="r" id="PARM10_from" style="width: 90px;" type="text" placeholder="下限年齢" value="">歳&nbsp;&nbsp;～&nbsp;&nbsp;<INPUT class="r" id="PARM10_to" style="width: 90px;" type="text" placeholder="上限年齢" value="">歳 
              </DIV>
      <DIV style="margin: 5px; float: left;"><INPUT class="buttonUI" onclick="yearSearch();" type="button" value="検索"> 
              </DIV>
      <DIV style="clear: both;"></DIV></FIELDSET>
      <DIV style="margin: 0px 10px 10px;">
      <DIV>

<!-- サンプル表 begin -->
<TABLE id="table_id" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <thead>
    <tr>
	<td bgcolor="#87ceeb">№</td>
	<td bgcolor="#87ceeb">写真<br>登録番号</td>
	<td bgcolor="#87ceeb">氏名<br>登録年月日</td>
	<td bgcolor="#87ceeb">年齢<br>性別</td>
	<td bgcolor="#87ceeb">担当者</td>
	<td bgcolor="#87ceeb">OJT実施<br>実施年月日</td>
	<td bgcolor="#87ceeb">勤務回数</td>
	<td bgcolor="#87ceeb">紹介可能<br>職種</td>
	<td bgcolor="#87ceeb">就業状況<br>更新日・更新者</td>
	<td bgcolor="#87ceeb">最近3ヶ月の<br>勤務現場</td>
	<td bgcolor="#87ceeb">都道府県</td>
	<td bgcolor="#87ceeb">沿線<br>最寄駅</td>
	<td bgcolor="#87ceeb">年末調整<br>希望有無</td>
    </tr>
  </thead>

<tbody>
<?php

$dbh = DB::connect('mysql://root:@127.0.0.1/sample');
if (DB::isError($dbh)) {
  exit($dbh->getMessage());
}

$dbh->query('SET NAMES utf8');
if (DB::isError($dbh)) {
  exit($dbh->getMessage());
}

$sth = $dbh->query('SELECT * FROM m_stuff');
if (DB::isError($sth)) {
  exit($sth->getMessage());
}

while ($data = $sth->fetchRow(DB_FETCHMODE_ASSOC)) {
  echo '<tr>';
  echo '<td>' . $data['id']. "</td>";
  echo '<td align="center"><img src="images/noimage.jpg" width="50">' . $data['imgdat']. '</td>';
  echo '<td>' . $data['name_sei']. " " .$data['name_mei']."<br>".$data['ojt_date']. "</td>";
  echo '<td>' . $data['age']. "<br>" .getSex($data['sex']).  "</td>\n";
  echo '<td>' . $data['tantou']. "</td>";
  echo '<td>' . $data['ojt_date']. "</td>";
  echo '<td>' . $data['service_count']. "</td>";
  echo '<td>' . $data['shoukai_shokushu']. "</td>";
  echo '<td>' . $data['koushin_date']. "<br>" .$data['koushin_person']. "</td>";
  echo '<td>' . $data['3m_spot']. "</td>";
  echo '<td>' . $data['address1']. "</td>";
  echo '<td>' . $data['traffic1']. "<br>" .$data['traffic2']. "</td>";
  echo '<td>' . getNenmatsu($data['nenmatsu_chousei']). "</td>";
  echo '</tr>';
}

$dbh->disconnect();

?>
</tbody>  
</TABLE>
<!-- サンプル表 end -->
<br>
<br>
<TABLE width="100%" style="border: 0px currentColor; border-image: none;"><!-- foot start --> 
              
  <TBODY>
  <TR>
    <TD style="padding: 0px;"><IFRAME src="js/900.htm" 
      marginwidth="0" marginheight="0" scrolling="no" style="border: currentColor; border-image: none; width: 100%;"></IFRAME> 
                      </TD>
</TR>

  <TR>
    <TD>&nbsp;</TD>
</TR>
<!-- foot end -->        

</TBODY></TABLE>

<SCRIPT src="js/Common(1).js" type="text/javascript"></SCRIPT>
     
<SCRIPT type="text/javascript">
//<![CDATA[

theForm.oldSubmit = theForm.submit;
theForm.submit = WebForm_SaveScrollPositionSubmit;

theForm.oldOnSubmit = theForm.onsubmit;
theForm.onsubmit = WebForm_SaveScrollPositionOnSubmit;
//]]>
</SCRIPT>
 </FORM></BODY></HTML>
