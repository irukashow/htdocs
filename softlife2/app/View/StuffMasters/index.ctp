<?php
    echo $this->Html->css( 'table.css');
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
    <a href="javascript:void(0);" onclick="window.open('/softlife2/stuff_masters/add','スタッフ登録','width=1200,height=700');">新規作成</a>
    <a href="javascript:void(0);" target="_blank">登録リスト</a>
    <a href="" target="_blank">登録解除リスト</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="" target="">検索条件クリア</a>
</div>

<?php echo $this->Form->create('StuffMaster', array('type' => 'post', 'action' => '.')); ?>
    
    <!-- 駅検索 -->
        <FIELDSET class='search'>
            <LEGEND style='font-weight: bold;'>駅検索</LEGEND>         
            <DIV style="float: left;width:720px;">
                <SPAN>路線①</SPAN>
<select name="pref" onChange="setMenuItem(0,this[this.selectedIndex].value)" style="width: 100px;">
    <option value="0" selected>都道府県を選択してください
    <option value="1">北海道
    <option value="2">青森県
    <option value="3">岩手県
    <option value="4">宮城県
    <option value="5">秋田県
    <option value="6">山形県
    <option value="7">福島県
    <option value="8">茨城県
    <option value="9">栃木県
    <option value="10">群馬県
    <option value="11">埼玉県
    <option value="12">千葉県
    <option value="13">東京都
    <option value="14">神奈川県
    <option value="15">新潟県
    <option value="16">富山県
    <option value="17">石川県
    <option value="18">福井県
    <option value="19">山梨県
    <option value="20">長野県
    <option value="21">岐阜県
    <option value="22">静岡県
    <option value="23">愛知県
    <option value="24">三重県
    <option value="25">滋賀県
    <option value="26">京都府
    <option value="27">大阪府
    <option value="28">兵庫県
    <option value="29">奈良県
    <option value="30">和歌山県
    <option value="31">鳥取県
    <option value="32">島根県
    <option value="33">岡山県
    <option value="34">広島県
    <option value="35">山口県
    <option value="36">徳島県
    <option value="37">香川県
    <option value="38">愛媛県
    <option value="39">高知県
    <option value="40">福岡県
    <option value="41">佐賀県
    <option value="42">長崎県
    <option value="43">熊本県
    <option value="44">大分県
    <option value="45">宮崎県
    <option value="46">鹿児島県
    <option value="47">沖縄県
</select>
&nbsp;
<select name="s0" onChange="setMenuItem(1,this[this.selectedIndex].value)" style="width: 150px;">
    <option selected>路線を選択してください</option>
</select>
&nbsp;
<select name="s1" style="width: 150px;">
    <option selected>駅を選択してください</option>
</select> 
駅&nbsp;～&nbsp;
<select name="s2" style="width: 150px;">
    <option selected>駅を選択してください</option>
</select> 
駅<BR>
                <SPAN>路線②</SPAN>
                <?php echo $this->Form->input('para21',array('type'=>'select','label'=>false,'div'=>false,'style'=>'width: 100px;', 'empty'=>'（都道府県）', 'options'=>$pref_arr)); ?>
                &nbsp;&nbsp;
                <SELECT id="PARM63" style="width: 150px;"></SELECT>&nbsp;&nbsp;
                <SELECT id="PARM65_from" style="width: 150px;"></SELECT>駅&nbsp;&nbsp;～&nbsp;&nbsp;
                <SELECT id="PARM65_to" style="width: 150px;"></SELECT>駅<BR>
                <SPAN>路線③</SPAN>
                <?php echo $this->Form->input('para31',array('type'=>'select','label'=>false,'div'=>false,'style'=>'width: 100px;', 'empty'=>'（都道府県）', 'options'=>$pref_arr)); ?>
                &nbsp;&nbsp;
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
