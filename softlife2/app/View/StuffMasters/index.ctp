<?php
    echo $this->Html->css( 'stuffmaster');
    echo $this->Html->script('station3');
    
    // 年齢換算
    function getAge($str) {
        return floor ((date('Ymd') - $str)/10000).'歳';
    }
    // 性別変換
    function getGender($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '<img src="'.ROOTDIR.'/img/woman.png" style="width:50%">';
        } elseif ($value == 2) {
            $ret = '<img src="'.ROOTDIR.'/img/man.png" style="width:50%">';
        } else {
            $ret = '未分類';
        }
        return $ret;
    }
    // OJT済未済
    function getOjt($value) {
        $ret = '&nbsp;';
        if ($value == 0) {
            $ret = '未済';
        } elseif ($value == 1) {
            $ret = '済';
        }
        return $ret;
    }
    // 職種
    function getShokushu($value) {
        $ret = "";
        if ($value == 1) {
            $ret = '受付';
        } elseif ($value == 2) {
            $ret = 'フロア受付';
        } elseif ($value == 3) {
            $ret = 'シッター';
        } elseif ($value == 4) {
            $ret = 'ナレーター';  
        } elseif ($value == 5) {
            $ret = 'ＤＨ';
        } elseif ($value == 6) {
            $ret = '看板持ち';
        } elseif ($value == 7) {
            $ret = '事務';
        } elseif ($value == 8) {
            $ret = '誘導案内';
        } elseif ($value == 9) {
            $ret = '内覧会スタッフ';
        } else {
            $ret = '';
        }
        return $ret;
    }
    function getShokushu2($array) {
        $ret = "";
        $_array = explode(',', $array);
        foreach ($_array as $key => $value) {
            if ($key <= 1) {
                $ret = getShokushu($value);
            } else {
                $ret = $ret.', '.getShokushu($value);
            }  
        }
        return $ret;
    }
    // 年末調整
    function getNenmatsu($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '&nbsp;';
        } elseif ($value == 2) {
            $ret = '希望';
        } else {
            $ret = '不明';
        }
        return $ret;
    }
    
    // 路線・駅の表示
    function getStation($code, $flag) {
        if (!is_null($code) && !empty($code)) {
            $xml = "http://www.ekidata.jp/api/s/".$code.".xml";//ファイルを指定
            //$xml = "http://www.ekidata.jp/api/s/3300610.xml";//ファイルを指定
            $xml_data = "";
            $cp = curl_init();
            curl_setopt($cp, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt( $cp, CURLOPT_HEADER, false );
            curl_setopt($cp, CURLOPT_URL, $xml);
            curl_setopt($cp, CURLOPT_TIMEOUT, 60);
            $xml_data = curl_exec($cp);
            curl_close($cp);
            $original_xml = simplexml_load_string($xml_data);
            $xml_ary = json_decode(json_encode($original_xml), true);

            $line_name = $xml_ary['station']['line_name'];
            $station_name = $xml_ary['station']['station_name'];
            $ret = $line_name.' '.$station_name.'駅';
            if ($flag == 1) {
                $ret = $ret.'<br>';
            }
        } else {
            $ret = '';
        }
        
        return $ret;
        
        
    }
    
    // 都道府県の表示
    function getPref($code) {
        if (!is_null($code) && !empty($code)) {
            $xml = "http://www.ekidata.jp/api/p/".$code.".xml";//ファイルを指定
            // simplexml_load_fileは使えない処理
            $xml_data = "";
            $cp = curl_init();
            curl_setopt($cp, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt( $cp, CURLOPT_HEADER, false );
            curl_setopt($cp, CURLOPT_URL, $xml);
            curl_setopt($cp, CURLOPT_TIMEOUT, 60);
            $xml_data = curl_exec($cp);
            curl_close($cp);
            $original_xml = simplexml_load_string($xml_data);
            $xml_ary = json_decode(json_encode($original_xml), true);

            $ret = $xml_ary['pref']['name'];
        } else {
            $ret = '';
        }

        return $ret;
        
    }
?>

<style>
  #loading{
position:absolute;
left:50%;
top:60%;
margin-left:-30px;
  }
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script type="text/javascript">
  <!--
//コンテンツの非表示
$(function(){
    $('#stuff_master').css('display', 'none');
});
//ページの読み込み完了後に実行
window.onload = function(){
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        $("#stuff_master").fadeIn();
    });
}
  //-->
</script>

<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<!-- 見出し -->
<div id='headline'>
    ★ スタッフマスタ
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="javascript:void(0);" onclick="window.open('/softlife2/stuff_masters/reg1','スタッフ登録','width=1200,height=800,scrollbars=yes');" id='button-create'>新規登録</a>
    &nbsp;
    <a href="javascript:void(0);" onclick="alert('制作中');"><font style='color: blue;'>仮登録リスト</font></a>
    &nbsp;
<?php if ($flag == 1) { ?>
    <a href="<?=ROOTDIR ?>/stuff_masters/index/" target="">登録リスト</a>
    &nbsp;
    <b>登録解除リスト</b>
<?php } else { ?>
    <b>登録リスト</b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/stuff_masters/index/1" target="">登録解除リスト</a>
<?php } ?>    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/stuff_masters/index/<?=$flag ?>" target="">検索条件クリア</a>
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
                <?php echo $this->Form->input('search_age_lower', array('type'=>'text', 'label' => false,'div' => false, 'placeholder'=>'下限年齢', 'style' => 'width:90px;')); ?>歳
                &nbsp;～&nbsp;
                <?php echo $this->Form->input('search_age_upper', array('type'=>'text', 'label' => false,'div' => false, 'placeholder'=>'上限年齢', 'style' => 'width:90px;')); ?>歳 
            </DIV>
            <div style="margin-top: -5px;">
                <?php echo $this->Form->submit('検索', array('div'=>false, 'class' => '', 'name' => 'search2', 'style' => 'font-size:100%; padding:5px 15px 5px 15px;')); ?>
            </div>
        </FIELDSET>
    <p style="clear: both; height: 0px;"></p>

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
        <?php echo $this->Paginator->counter(array('format' => __('総件数  <b>{:count}</b> 件')));?>
        &nbsp;&nbsp;&nbsp;
        表示件数：
        <?php
            $list = array('5'=>'5','10'=>'10','20'=>'20','50'=>'50','100'=>'100');
            echo $this->Form->input('limit', array('name' => 'limit', 'type' => 'select','label' => false,'div' => false, 'options' => $list, 'selected' => $limit,
                'onchange' => 'form.submit();'));
        ?>
    </div>
 </div>

<!--- スタッフマスタ本体 START --->
<table id="stuff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;margin: 0px 0px 5px 0px;">
  <tr style="font-size: 100%;">
      <th><?php echo $this->Paginator->sort('',"");?></th>
      <th style="width:10%;"><?php echo $this->Paginator->sort('id','写真<br>登録番号', array('escape' => false));?></th>
      <th style="width:10%;"><?php echo $this->Paginator->sort('name_sei','氏名<br>登録年月日', array('escape' => false));?></th>
      <th style="width:5%;"><?php echo $this->Paginator->sort('age','年齢<br>性別', array('escape' => false));?></th>
    <th style="width:7%;"><?php echo $this->Paginator->sort('tantou','担当者');?></th>
    <th style="width:7%;"><?php echo $this->Paginator->sort('ojt_date','OJT実施<br>実施年月日', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('service_count','勤務回数');?></th>
    <th><?php echo $this->Paginator->sort('shokushu_shoukai','紹介可能職種');?></th>
    <th style="width:7%;"><?php echo $this->Paginator->sort('koushin_date','就業状況<br>更新日<br>更新者', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('3m_spot','最近3ヶ月の勤務現場');?></th>
    <th style="width:10%;"><?php echo $this->Paginator->sort('address1','都道府県');?></th>
    <th style="width:14%;"><?php echo $this->Paginator->sort('s1_1','沿線<br>最寄駅', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('nenmatsu_chousei','年末調整<br>希望有無', array('escape' => false));?></th>
  </tr>
  <tr>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input('search_id', array('type'=>'text', 'label' => false, 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input('search_name', array('type'=>'text', 'label' => false, 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input('search_age', array('type'=>'text', 'label' => false, 'style' => 'width:90%;')); ?></td>
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
  <?php foreach ($datas as $data): ?>
  <tr>
    <td align="right">&nbsp;</td>
    <?php $stuff_id = $data['StuffMaster']['id']; ?>
    <td align="center">
        <a href="javascript:void(0);" onclick="window.open('/softlife2/stuff_masters/profile/<?php echo $data['StuffMaster']['id']; ?>','スタッフ登録','width=1200,height=800,scrollbars=yes');" class="link_prof">
                <?php
                    $after = $data['StuffMaster']['pic_extension'];
                    if (is_null($after)) {
                ?>
            <img src="<?=ROOTDIR ?>/img/noimage.jpg" width="80px">
                <?php } else { ?>
            <img src="<?=ROOTDIR ?>/files/stuff_reg/<?=$stuff_id ?>/<?=$stuff_id ?>.<?=$after ?>" width="80px">
                <?php } ?>
            <br>
            <font style="font-weight: bold;color: #006699;"><?php echo $stuff_id; ?></font>
        </a>
    </td>
    <td align="center" style="font-size: 110%;">
        <a href="javascript:void(0);" onclick="window.open('/softlife2/stuff_masters/profile/<?php echo $data['StuffMaster']['id']; ?>','スタッフ登録','width=1200,height=800,scrollbars=yes');" class="link_prof">
            <?php echo $data['StuffMaster']['name_sei']." ".$data['StuffMaster']['name_mei'];?><br>
        </a>
	<?=date('Y-m-d', strtotime($data['StuffMaster']['created'])); ?>
    </td>
    <td align="center"><?php echo getAge(str_replace('-','',$data['StuffMaster']['birthday']))."<br>".getGender($data['StuffMaster']['gender']);?></td>
    <td align="center"><?php echo '＜不明＞'; ?></td>
    <td align="center"><?php echo getOjt($data['StuffMaster']['ojt']).'<br>'.$data['StuffMaster']['ojt_date']; ?></td>
    <td align="center"><?php echo '＜不明＞'; ?></td>
    <td align="left"><?php echo getShokushu2($data['StuffMaster']['shokushu_shoukai']); ?></td>
    <td align="left"><?php echo date('Y-m-d', strtotime($data['StuffMaster']['modified'])).'<br>'.$data['User']['koushin_name_sei'].' '.$data['User']['koushin_name_mei']; ?></td>
    <td align="center"><?php echo '＜不明＞'; ?></td>
    <td align="left"><?php echo getPref($data['StuffMaster']['address1']).'&nbsp;'.$data['StuffMaster']['address2']; ?></td>
    <td align="left">
        <?php echo getStation($data['StuffMaster']['s1_1'], 1); ?>
        <?php echo getStation($data['StuffMaster']['s1_2'], 1); ?>
        <?php echo getStation($data['StuffMaster']['s1_3'], 0); ?>
    </td>
    <td align="center"><?php echo getNenmatsu($data['StuffMaster']['nenmatsu_chousei']); ?></td>
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
