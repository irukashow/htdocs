<?php
    echo $this->Html->css( 'table.css');
?>
<!-- 見出し -->
<div id='headline'>
    ★ スタッフマスタ
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="" target="_blank">新規作成</a>
    <a href="" target="_blank">登録リスト</a>
    <a href="" target="_blank">登録解除リスト</a>
</div>

<?php echo $this->Form->create('StuffMaster', array('type' => 'post', 'action' => 'find')); ?>
    
    <!-- 駅検索 -->
        <FIELDSET class='search'>
            <LEGEND style='font-weight: bold;'>駅検索</LEGEND>         
            <DIV style="float: left;width:700px;">
                <SPAN>路線①</SPAN>
                <SELECT id="PARM51" style="width: 100px;"></SELECT>&nbsp;&nbsp;
                <SELECT id="PARM53" style="width: 150px;"></SELECT>&nbsp;&nbsp;
                <SELECT id="PARM55_from" style="width: 150px;"></SELECT>駅&nbsp;&nbsp;～&nbsp;&nbsp;
                <SELECT id="PARM55_to" style="width: 150px;"></SELECT>駅<BR>
                <SPAN>路線②</SPAN>
                <SELECT id="PARM61" style="width: 100px;"></SELECT>&nbsp;&nbsp;
                <SELECT id="PARM63" style="width: 150px;"></SELECT>&nbsp;&nbsp;
                <SELECT id="PARM65_from" style="width: 150px;"></SELECT>駅&nbsp;&nbsp;～&nbsp;&nbsp;
                <SELECT id="PARM65_to" style="width: 150px;"></SELECT>駅<BR>
                <SPAN>路線③</SPAN>
                <SELECT id="PARM71" style="width: 100px;"></SELECT>&nbsp;&nbsp;
                <SELECT id="PARM73" style="width: 150px;"></SELECT>&nbsp;&nbsp;
                <SELECT id="PARM75_from" style="width: 150px;"></SELECT>駅&nbsp;&nbsp;～&nbsp;&nbsp;
                <SELECT id="PARM75_to" style="width: 150px;"></SELECT>駅<BR>
            </DIV>
            <div style='float: left;'>
                <?php echo $this->Form->submit('検索', array('div'=>false, 'class' => '', 'name' => 'search1', 'style' => 'font-size:100%; padding:10px 15px 10px 15px;')); ?>
            </div>
            <div style="clear: both; height: 0px;"></div>
        </FIELDSET>
    
    <!-- 年齢検索 -->
        <FIELDSET class='search'>
            <LEGEND style='font-weight: bold;'>年齢検索</LEGEND>         
            <DIV style="float: left;width:300px;">
                <SPAN>年齢</SPAN>
                <INPUT style="width: 90px;" type="text" placeholder="下限年齢" value="">歳
                &nbsp;～&nbsp;
                <INPUT style="width: 90px;" type="text" placeholder="上限年齢" value="">歳 
            </DIV>
            <div>
                <?php echo $this->Form->submit('検索', array('div'=>false, 'class' => '', 'name' => 'search2', 'style' => 'font-size:100%; padding:5px 15px 5px 15px;')); ?>
            </div>
            <p style="clear: both; height: 0px;"></p>
        </FIELDSET>
    
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

<div class="pageNav03" style="margin-bottom: 30px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
 </div>
<!--- スタッフマスタ本体 END --->

<?php echo $this->Form->end(); ?>
