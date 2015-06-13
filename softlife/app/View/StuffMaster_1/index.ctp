<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<TITLE>	 派遣管理システム-スタッフマスタ </TITLE>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<META name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes"> 
    
<SCRIPT src="/softlife/js/jquery-1.9.1.js" type="text/javascript"></SCRIPT>
     
<SCRIPT src="/softlife/js/jquery-ui-1.10.3.custom.js" type="text/javascript"></SCRIPT>

     <LINK href="/softlife/js/jquery.mCustomScrollbar.css" rel="stylesheet" 
type="text/css" media="screen">     
<LINK href="/softlife/js/Style_SP.css" 
rel="stylesheet" type="text/css" media="only screen and (max-device-width:480px)"> 
    <LINK href="/softlife/js/Style.css" rel="stylesheet" type="text/css" 
media="screen and (min-device-width:481px)">     
<LINK href="/softlife/js/page.css" 
rel="stylesheet" type="text/css">     
<LINK href="/softlife/js/Class.css" 
rel="stylesheet" type="text/css">         
<LINK href="/softlife/js/jquery.ui.all.css" 
rel="stylesheet" type="text/css">     
<LINK href="/softlife/js/jquery-ui-1.10.3.custom.css" 
rel="stylesheet" type="text/css">     
<SCRIPT src="/softlife/js/common.js" type="text/javascript"></SCRIPT>
     
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

<?php
    echo $this->Html->css( 'main.css');
?>
    
<BODY>
<FORM name="aspnetForm" id="aspnetForm" action="a1.aspx" method="post" 
novalidate="">
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
            src="/softlife/js/rogo3.jpg"></A></TD>
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
          
<!--- スタッフマスタ本体 START --->
<table id="staff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr>
      <th><?php echo $this->Paginator->sort('id',"No.");?></th>
      <th><?php echo $this->Paginator->sort('imgdat','写真');?></th>
      <th><?php echo $this->Paginator->sort('name_sei','氏名');?></th>
      <th><?php echo $this->Paginator->sort('age','年齢・性別');?></th>
    <th><?php echo $this->Paginator->sort('tantou','担当者');?></th>
    <th><?php echo $this->Paginator->sort('ojt_date','OJT実施・実施年月日');?></th>
    <th><?php echo $this->Paginator->sort('service_count','勤務回数');?></th>
    <th><?php echo $this->Paginator->sort('shoukai_shokushu','紹介可能職種');?></th>
    <th><?php echo $this->Paginator->sort('koushin_date','就業状況・更新日・更新者');?></th>
    <th><?php echo $this->Paginator->sort('3m_spot','最近3ヶ月の・勤務現場');?></th>
    <th><?php echo $this->Paginator->sort('address1','都道府県');?></th>
    <th><?php echo $this->Paginator->sort('traffic1','沿線・最寄駅');?></th>
    <th><?php echo $this->Paginator->sort('nenmatsu_chousei','年末調整・希望有無');?></th>
  </tr>
  <?php foreach ($datas as $data): ?>
  <tr>
    <td><?php echo $data['StaffMaster']['id']; ?></td>
    <td align="center"><img src="/softlife/img/noimage.jpg" width="50"></td>
    <td><?php echo $data['StaffMaster']['name_sei']." ".$data['StaffMaster']['name_mei'];?></td>
    <td><?php echo $data['StaffMaster']['age']."<br>".$data['StaffMaster']['sex'];?></td>
    <td><?php echo $data['StaffMaster']['tantou']; ?></td>
    <td><?php echo $data['StaffMaster']['ojt_date']; ?></td>
    <td><?php echo $data['StaffMaster']['service_count']; ?></td>
    <td><?php echo $data['StaffMaster']['shoukai_shokushu']; ?></td>
    <td><?php echo $data['StaffMaster']['koushin_date'].'<br>'.$data['StaffMaster']['koushin_person']; ?></td>
    <td><?php echo $data['StaffMaster']['3m_spot']; ?></td>
    <td><?php echo $data['StaffMaster']['address1']; ?></td>
    <td><?php echo $data['StaffMaster']['traffic1'].'<br>'.$data['StaffMaster']['traffic2']; ?></td>
    <td><?php echo $data['StaffMaster']['nenmatsu_chousei']; ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<div class="pageNav03">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
 </div>
<!--- スタッフマスタ本体 END --->
<br>
<br>
<TABLE width="100%" style="border: 0px currentColor; border-image: none;"><!-- foot start --> 
              
  <TBODY>
  <TR>
    <TD style="padding: 0px;"><IFRAME src="/softlife/js/900.htm" 
      marginwidth="0" marginheight="0" scrolling="no" style="border: currentColor; border-image: none; width: 100%;"></IFRAME> 
                      </TD>
</TR>

  <TR>
    <TD>&nbsp;</TD>
</TR>
<!-- foot end -->        

</TBODY></TABLE>
     
 </FORM></BODY></HTML>




