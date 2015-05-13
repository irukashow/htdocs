<?php
    echo $this->Html->css( 'main.css');
    //echo $this->Html->css( 'page.css');
    //echo $this->Html->css( 'Style.css');
    //echo $this->Html->css( 'Style_SP.css');
    //echo $this->Html->css( 'jquery-ui-1.10.3.custom.css');
    //echo $this->Html->css( 'jquery.ui.theme.css');
?>

<FORM name="" id="" action="a1.aspx" method="post" >
<DIV id="targ1">
<TABLE width="100%" class="fix" style="border: 0px currentColor; border-image: none;"><!-- head --> 
              
  <TBODY>
  <TR>
    <TD style="padding: 0px;">
      <TABLE width="100%">
        <TBODY>
<!-- menu start -->             
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
          </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
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
<table id="stuff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr>
      <th><?php echo $this->Paginator->sort('id',"No.");?></th>
      <th><?php echo $this->Paginator->sort('imgdat','写真');?></th>
      <th><?php echo $this->Paginator->sort('name_sei','氏名');?></th>
      <th><?php echo $this->Paginator->sort('age','年齢／性別');?></th>
    <th><?php echo $this->Paginator->sort('tantou','担当者');?></th>
    <th><?php echo $this->Paginator->sort('ojt_date','OJT実施／実施年月日');?></th>
    <th><?php echo $this->Paginator->sort('service_count','勤務回数');?></th>
    <th><?php echo $this->Paginator->sort('shoukai_shokushu','紹介可能職種');?></th>
    <th><?php echo $this->Paginator->sort('koushin_date','就業状況 更新日／更新者');?></th>
    <th><?php echo $this->Paginator->sort('3m_spot','最近3ヶ月の勤務現場');?></th>
    <th><?php echo $this->Paginator->sort('address1','都道府県');?></th>
    <th><?php echo $this->Paginator->sort('traffic1','沿線・最寄駅');?></th>
    <th><?php echo $this->Paginator->sort('nenmatsu_chousei','年末調整 希望有無');?></th>
  </tr>
  <?php foreach ($datas as $data): ?>
  <tr>
    <td><?php echo $data['StuffMaster']['id']; ?></td>
    <td align="center"><img src="/softlife/img/noimage.jpg" width="50"></td>
    <td><?php echo $data['StuffMaster']['name_sei']." ".$data['StuffMaster']['name_mei'];?></td>
    <td><?php echo $data['StuffMaster']['age']."<br>".$data['StuffMaster']['sex'];?></td>
    <td><?php echo $data['StuffMaster']['tantou']; ?></td>
    <td><?php echo $data['StuffMaster']['ojt_date']; ?></td>
    <td><?php echo $data['StuffMaster']['service_count']; ?></td>
    <td><?php echo $data['StuffMaster']['shoukai_shokushu']; ?></td>
    <td><?php echo $data['StuffMaster']['koushin_date'].'<br>'.$data['StuffMaster']['koushin_person']; ?></td>
    <td><?php echo $data['StuffMaster']['3m_spot']; ?></td>
    <td><?php echo $data['StuffMaster']['address1']; ?></td>
    <td><?php echo $data['StuffMaster']['traffic1'].'<br>'.$data['StuffMaster']['traffic2']; ?></td>
    <td><?php echo $data['StuffMaster']['nenmatsu_chousei']; ?></td>
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
     
 </FORM>
<br><br>
</div>
</div>
</div>
</div>



