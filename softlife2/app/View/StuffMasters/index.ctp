<?php
    echo $this->Html->css( 'stuffmaster');
    echo $this->Html->script('station2');
    
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
    
    // 路線・駅の表示
    function getStation($code) {
        if (!is_null($code) && !empty($code)) {
            $xml = "http://www.ekidata.jp/api/s/".$code.".xml";//ファイルを指定
            //$xml = "http://www.ekidata.jp/api/s/3300610.xml";//ファイルを指定
            $xmlData = simplexml_load_file($xml);//xmlを読み込む
            $xml_ary = json_decode(json_encode($xmlData), true);

            $line_name = $xml_ary['station']['line_name'];
            $station_name = $xml_ary['station']['station_name'];
            $ret = $line_name.' '.$station_name.'駅';
        } else {
            $ret = '';
        }
        
        return $ret;
        
        
    }
    
    // 都道府県の表示
    function getPref($code) {
        if (!is_null($code) && !empty($code)) {
            $xml = "http://www.ekidata.jp/api/p/".$code.".xml";//ファイルを指定
            $xmlData = simplexml_load_file($xml);//xmlを読み込む
            $xml_ary = json_decode(json_encode($xmlData), true);

            $ret = $xml_ary['pref']['name'];
        } else {
            $ret = '';
        }

        return $ret;
        
    }
?>

<!-- 見出し -->
<div id='headline'>
    ★ スタッフマスタ
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:void(0);" onclick="window.open('/softlife2/stuff_masters/reg1','スタッフ登録','width=1200,height=800,scrollbars=yes');" id='button-create'>新規登録</a>
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
<?php echo $this->Form->input('pref1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
    'onChange'=>'setMenuItem1(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
&nbsp;→
<?php echo $this->Form->input('s0_1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'路線を選択してください', 'style' => 'width: 200px;', 
    'onChange'=>'setMenuItem1(1,this[this.selectedIndex].value)')); ?>
&nbsp;→
<?php echo $this->Form->input('s1_1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;')); ?>
&nbsp;駅&nbsp;～&nbsp;
<?php echo $this->Form->input('s2_1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;')); ?>
&nbsp;駅<BR>

                <SPAN>路線②</SPAN>
<?php echo $this->Form->input('pref2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
    'onChange'=>'setMenuItem2(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
&nbsp;→
<?php echo $this->Form->input('s0_2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'路線を選択してください', 'style' => 'width: 200px;', 
    'onChange'=>'setMenuItem2(1,this[this.selectedIndex].value)')); ?>
&nbsp;→
<?php echo $this->Form->input('s1_2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;')); ?>
&nbsp;駅&nbsp;～&nbsp;
<?php echo $this->Form->input('s2_2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;')); ?>
&nbsp;駅<BR>

                <SPAN>路線③</SPAN>
<?php echo $this->Form->input('pref3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
    'onChange'=>'setMenuItem3(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
&nbsp;→
<?php echo $this->Form->input('s0_3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'路線を選択してください', 'style' => 'width: 200px;', 
    'onChange'=>'setMenuItem3(1,this[this.selectedIndex].value)')); ?>
&nbsp;→
<?php echo $this->Form->input('s1_3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;')); ?>
&nbsp;駅&nbsp;～&nbsp;
<?php echo $this->Form->input('s2_3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;')); ?>
&nbsp;駅<BR>
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
        <?php
            $list = array('5'=>'5','10'=>'10','20'=>'20','50'=>'50','100'=>'100');
            echo $this->Form->input('', array('name' => 'limit', 'type' => 'select','label' => false,'div' => false, 'value' => '10', 'options' => $list, 
                'onchange' => ''));
        ?>
    </div>
 </div>

<!--- スタッフマスタ本体 START --->
<table id="stuff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr>
      <th><?php echo $this->Paginator->sort('',"");?></th>
      <th><?php echo $this->Paginator->sort('id','写真<br>登録番号', array('escape' => false));?></th>
      <th><?php echo $this->Paginator->sort('name_sei','氏名<br>登録年月日', array('escape' => false));?></th>
      <th><?php echo $this->Paginator->sort('age','年齢<br>性別', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('tantou','担当者');?></th>
    <th><?php echo $this->Paginator->sort('ojt_date','OJT実施<br>実施年月日', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('service_count','勤務回数');?></th>
    <th><?php echo $this->Paginator->sort('shoukai_shokushu','紹介可能職種');?></th>
    <th><?php echo $this->Paginator->sort('koushin_date','就業状況 更新日<br>更新者', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('3m_spot','最近3ヶ月の勤務現場');?></th>
    <th><?php echo $this->Paginator->sort('address1','都道府県');?></th>
    <th><?php echo $this->Paginator->sort('s1_1','沿線<br>最寄駅', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('nenmatsu_chousei','年末調整<br>希望有無', array('escape' => false));?></th>
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
    <td>
        <a href="javascript:void(0);" onclick="window.open('/softlife2/stuff_masters/profile/<?php echo $data['StuffMaster']['id']; ?>','スタッフ登録','width=1200,height=800,scrollbars=yes');" class="link_prof">
            <?php echo $data['StuffMaster']['name_sei']." ".$data['StuffMaster']['name_mei'];?><br>
        </a>
	<?=date('Y-m-d', strtotime($data['StuffMaster']['created'])); ?>
    </td>
    <td><?php echo getAge(str_replace('-','',$data['StuffMaster']['birthday']))."<br>".getGender($data['StuffMaster']['gender']);?></td>
    <td><?php echo $data['StuffMaster']['tantou']; ?></td>
    <td><?php echo $data['StuffMaster']['ojt_date']; ?></td>
    <td><?php echo $data['StuffMaster']['service_count']; ?></td>
    <td><?php echo $data['StuffMaster']['shoukai_shokushu']; ?></td>
    <td><?php echo $data['StuffMaster']['koushin_date'].'<br>'.$data['StuffMaster']['koushin_person']; ?></td>
    <td><?php echo $data['StuffMaster']['3m_spot']; ?></td>
    <td><?php echo getPref($data['StuffMaster']['address1']).'&nbsp;'.$data['StuffMaster']['address2']; ?></td>
    <td>
        <?php echo getStation($data['StuffMaster']['s1_1']); ?>
        <br>
        <?php echo getStation($data['StuffMaster']['s1_2']); ?>
        <br>
        <?php echo getStation($data['StuffMaster']['s1_3']); ?>
    </td>
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
