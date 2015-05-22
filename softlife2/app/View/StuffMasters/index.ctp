<?php
    echo $this->Html->css( 'stuffmaster');
    echo $this->Html->script('station');
    
    // 年齢換算
    function getAge($str) {
        return floor ((date('Ymd') - $str)/10000);
    }
    // 性別変換
    function getGender($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '女性';
        } elseif ($value == 2) {
            $ret = '男性';
        } else {
            $ret = '未分類';
        }
        return $ret;
    }
    // 年末調整
    function getNenmatsu($value) {
        $ret = null;
        if ($value == 0) {
            $ret = '&nbsp;';
        } elseif ($value == 1) {
            $ret = '希望';
        }
        return $ret;
    }
?>

<!-- 見出し -->
<div id='headline'>
    ★ スタッフマスタ
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:void(0);" onclick="window.open('/softlife2/stuff_masters/reg1','スタッフ登録','width=1200,height=800');" id='button-create'>新規作成</a>
    &nbsp;
    <a href="javascript:void(0);" target=""><font style='color: blue;'>仮登録リスト</font></a>
    &nbsp;
    <b>登録リスト</b>
    &nbsp;
    <a href="" target="_blank">登録解除リスト</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="" target="">検索条件クリア</a>
</div>

<?php echo $this->Form->create('StuffMaster', array('type' => 'post', 'name' => 'form', 'action' => '.')); ?>
    
    <!-- 駅検索 -->
        <FIELDSET class='search'>
            <LEGEND style='font-weight: bold;'>駅検索</LEGEND>         
            <DIV style="float: left;width:770px;">
                <SPAN>路線①</SPAN>
<?php echo $this->Form->input('',array('name'=>'pref','type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
    'onChange'=>'setMenuItem1(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
&nbsp;→
<select name="s0_1" onChange="setMenuItem1(1,this[this.selectedIndex].value)" style="width: 200px;">
    <option selected>路線を選択してください</option>
</select>
→
<select name="s1_1" style="width: 150px;">
    <option selected>駅を選択してください</option>
</select> 
駅&nbsp;～&nbsp;
<select name="s2_1" style="width: 150px;">
    <option selected>駅を選択してください</option>
</select> 
駅<BR>
                <SPAN>路線②</SPAN>
<?php echo $this->Form->input('',array('name'=>'pref','type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
    'onChange'=>'setMenuItem2(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
&nbsp;→
<select name="s0_2" onChange="setMenuItem2(1,this[this.selectedIndex].value)" style="width: 200px;">
    <option selected>路線を選択してください</option>
</select>
→
<select name="s1_2" style="width: 150px;">
    <option selected>駅を選択してください</option>
</select> 
駅&nbsp;～&nbsp;
<select name="s2_2" style="width: 150px;">
    <option selected>駅を選択してください</option>
</select> 
駅<BR>
                <SPAN>路線③</SPAN>
<?php echo $this->Form->input('',array('name'=>'pref','type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
    'onChange'=>'setMenuItem3(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
&nbsp;→
<select name="s0_3" onChange="setMenuItem3(1,this[this.selectedIndex].value)" style="width: 200px;">
    <option selected>路線を選択してください</option>
</select>
→
<select name="s1_3" style="width: 150px;">
    <option selected>駅を選択してください</option>
</select> 
駅&nbsp;～&nbsp;
<select name="s2_3" style="width: 150px;">
    <option selected>駅を選択してください</option>
</select> 
駅<BR>
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

<!-- ページネーション -->
<div class="pageNav03" style="margin-bottom: 30px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
    <div style="float:right;">
        表示件数：
        <SELECT id="optDisplay">
            <OPTION value="5">5</OPTION>
            <OPTION value="10">10</OPTION>
            <OPTION value="15">15</OPTION>
            <OPTION value="20">20</OPTION>
            <OPTION value="25">25</OPTION>
        </SELECT>
    </div>
 </div>

<!--- スタッフマスタ本体 START --->
<table id="stuff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr>
      <th><?php echo $this->Paginator->sort('id',"No.");?></th>
      <th><?php echo $this->Paginator->sort('imgdat','写真／登録番号');?></th>
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
  <tr>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;"><input name="txtId" type="text" style="width:90%;"></td>
      <td style="background-color: #ffffe6;"><input name="txtRegDate" type="text" style="width:90%;"></td>
      <td style="background-color: #ffffe6;"><input name="txtName" type="text" style="width:90%;"></td>
      <td style="background-color: #ffffe6;"><input name="txtTantou" type="text" style="width:90%;"></td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;"><input name="txtArea" type="text" style="width:90%;"></td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="center"><img src="/softlife/img/noimage.jpg" width="50"><br><?php echo $data['StuffMaster']['id']; ?></td>
    <td><?php echo $data['StuffMaster']['name_sei']." ".$data['StuffMaster']['name_mei'];?></td>
    <td><?php echo getAge(str_replace('-','',$data['StuffMaster']['birthday']))."<br>".getGender($data['StuffMaster']['gender']);?></td>
    <td><?php echo $data['StuffMaster']['tantou']; ?></td>
    <td><?php echo $data['StuffMaster']['ojt_date']; ?></td>
    <td><?php echo $data['StuffMaster']['service_count']; ?></td>
    <td><?php echo $data['StuffMaster']['shoukai_shokushu']; ?></td>
    <td><?php echo $data['StuffMaster']['koushin_date'].'<br>'.$data['StuffMaster']['koushin_person']; ?></td>
    <td><?php echo $data['StuffMaster']['3m_spot']; ?></td>
    <td><?php echo $data['StuffMaster']['address1']; ?></td>
    <td><?php echo $data['StuffMaster']['traffic1'].'<br>'.$data['StuffMaster']['traffic2']; ?></td>
    <td><?php echo getNenmatsu($data['StuffMaster']['nenmatsu_chousei']); ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<!-- ページネーション -->
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
