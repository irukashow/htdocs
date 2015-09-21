<?php
    echo $this->Html->css('staffmaster');
?>

<?php require('index_element.ctp'); ?>
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
    $('#staff_master').css('display', 'none');
});
//ページの読み込み完了後に実行
window.onload = function(){
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        $("#staff_master").fadeIn();
    });
}
  //-->
</script>
<!-- for Datepicker -->
<link type="text/css" rel="stylesheet"
  href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
<script type="text/javascript"
  src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript"
  src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<!--1国際化対応のライブラリをインポート-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript">
$(function() {
  // 2日本語を有効化
  $.datepicker.setDefaults($.datepicker.regional['ja']);
  // 3日付選択ボックスを生成
  $('.date').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<script type="text/javascript">
function doSubmit(value, flag) {
    if (flag == 1) {
        msg = "削除";
    } else if(flag == 2) {
        msg = "クローズ";    
    }
    if (confirm('本当に' + msg + '処理を行いますか？') == false) {
        return;
    }
    var form = document.getElementById("frm");
    var elm1 = document.createElement("input");
    elm1.setAttribute("name", "case_id");
    elm1.setAttribute("type", "hidden");
    elm1.setAttribute("value", value);
    form.appendChild(elm1);
    var elm2 = document.createElement("input");
    elm2.setAttribute("name", "flag");
    elm2.setAttribute("type", "hidden");
    elm2.setAttribute("value", flag);
    form.appendChild(elm2);
    form.submit();
}
</script>

<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<?php echo $this->Form->create('CaseManagement', array('name' => 'form')); ?>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ 案件管理
    &nbsp;&nbsp;
    <b><font Style="font-size:95%;color: yellow;">[案件一覧]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/CaseManagement/customer/0" target="" onclick=''><font Style="font-size:95%;">取引先一覧</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/CaseManagement/shokushu" target=""><font Style="font-size:95%;">職種マスタ</font></a>
</div>
<!-- 見出し１ END -->
<!-- 見出し２ -->
<div id='headline' style="padding:5px 10px 5px 10px;">
    &nbsp;
    <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/CaseManagement/reg1/0/0','案件登録','width=1200,height=800,scrollbars=yes');" id='button-create'>新規登録</a>
    &nbsp;
<?php if ($flag == 0 || empty($flag)) { ?>
    <b><font Style="font-size:95%;">[登録リスト]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/CaseManagement/index/1" target=""><font Style="font-size:95%;">削除済リスト</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/CaseManagement/index/2" target=""><font Style="font-size:95%;">クローズ一覧</font></a>
<?php } elseif ($flag == 1) { ?>
    <a href="<?=ROOTDIR ?>/CaseManagement/index/0" target=""><font Style="font-size:95%;">登録リスト</font></a>
    &nbsp;
    <b><font Style="font-size:95%;">[削除済リスト]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/CaseManagement/index/2" target=""><font Style="font-size:95%;">クローズ一覧</font></a>
<?php } elseif ($flag == 2) { ?>
    <a href="<?=ROOTDIR ?>/CaseManagement/index/0" target=""><font Style="font-size:95%;">登録リスト</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/CaseManagement/index/1" target=""><font Style="font-size:95%;">削除済リスト</font></a>
    &nbsp;
    <b><font Style="font-size:95%;">[クローズ一覧]</font></b>
<?php } ?>    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'font-size:90%; margin:0px; padding:5px 15px 5px 15px;')); ?>
    &nbsp;
    <a href="<?=ROOTDIR ?>/CaseManagement/index/<?=$flag ?>" target="" id="clear">検索条件クリア</a>
</div>
<!-- 見出し２ END -->

<!-- ページネーション -->
<div class="pageNav03" style="margin-top:-5px; margin-bottom: 30px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
    <div style="float:right;margin-top: 5px;">
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
<div style="clear:both;"></div>
<!--- スタッフマスタ本体 START --->
<table id="staff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;margin: 0px 0px 5px 0px;">
  <tr style="font-size: 100%;margin-top: -10px;">
      <th rowspan="2"><?php echo $this->Paginator->sort('no',"No.");?></th>
    <th rowspan="2" style="width:15%;"><?php echo $this->Paginator->sort('id','案件名<br>依頼主<br>（事業主）', array('escape' => false));?></th>
    <th rowspan="2" style="width:5%;"><?php echo $this->Paginator->sort('name_sei','契約形態', array('escape' => false));?></th>
    <th rowspan="2" style="width:6%;"><?php echo $this->Paginator->sort('age','開始日<br>終了日', array('escape' => false));?></th>
    <th rowspan="2" style="width:5%;"><?php echo $this->Paginator->sort('tantou','担当者');?></th>
    <th rowspan="2" style="width:15%;"><?php echo $this->Paginator->sort('ojt_date','就業場所<br>住所<br>電話番号<br>担当者', array('escape' => false));?></th>
    <th style="width:25%;color: white;" colspan="4">今月～来月のオーダー内容</th>
    <th rowspan="2" style="width:7%;"><?php echo $this->Paginator->sort('shokushu_shoukai','オーダー入力<br>更新日<br>入力済ﾁｪｯｸ', array('escape' => false));?></th>
    <th rowspan="2" style="width:7%;"><?php echo $this->Paginator->sort('koushin_date','シフト入力<br>更新日<br>入力済ﾁｪｯｸ', array('escape' => false));?></th>
    <th rowspan="2" style="width:7%;"><?php echo $this->Paginator->sort('3m_spot','帳票作成<br>更新日<br>作成済ﾁｪｯｸ', array('escape' => false));?></th>
    <th rowspan="2" style="width:7%;">&nbsp;</th>
  </tr>
  <tr>
      <th style="color: white;">職種</th>
      <th style="color: white;">勤務時間</th>
      <th style="color: white;">受注金額</th>
      <th style="color: white;">人数</th>
  </tr>
  <tr>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">
          <?php echo $this->Form->input('search_client', array('type'=>'text', 'label' => false, 'placeholder'=>'依頼主', 'style' => 'width:90%;font-size:90%;')); ?>
          <?php echo $this->Form->input('search_entrepreneur', array('type'=>'text', 'label' => false, 'placeholder'=>'事業主', 'style' => 'width:90%;font-size:90%;')); ?>
      </td>
      <td style="background-color: #ffffe6;">
          <?php $list_type = array('1'=>'派遣契約', '2'=>'請負契約'); ?>
          <?php echo $this->Form->input('search_contract', 
                  array('type'=>'select', 'label' => false, 'style' => 'width:90%;font-size:90%;', 'empty' => array('' => '契約形態を選んでください'), 'options' => $list_type)); ?>
      </td>
      <td style="background-color: #ffffe6;">
          <?php echo $this->Form->input('search_start_date', array('type'=>'text', 'label' => false, 'class' => 'date', 'placeholder'=>'開始日', 'style' => 'width:90%;font-size:90%;')); ?>
      </td>
      <td style="background-color: #ffffe6;">
          <?php echo $this->Form->input('search_tantou', 
                  array('type'=>'select', 'label' => false, 'style' => 'width:90%;font-size:90%;', 'empty' => array('' => '担当者を選んでください'), 'options' => $name_arr)); ?>
      </td>
      <td style="background-color: #ffffe6;">
          <?php echo $this->Form->input('search_place', array('type'=>'text', 'label' => false, 'placeholder'=>'就業場所（住所）', 'style' => 'width:95%;font-size:90%;')); ?>
      </td>
      <td style="background-color: #ffffe6;" colspan="4">
          <?php echo $this->Form->input('search_shokushu', 
                  array('type'=>'select', 'label' => false, 'style' => 'width:60%;font-size:90%;', 'empty' => array('' => '職種を選んでください'), 'options' => $list_shokushu)); ?>
      </td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
  </tr>
  <?php foreach ($datas as $key=>$data): ?>
  <?php $row = count($datas_order[$key]); ?>
  <tr>
    <td align="center" rowspan="<?=$row ?>">
        <?php $case_id = $data['CaseManagement']['id']; ?>
        <?php echo $case_id; ?>
    </td>
    <td align="left" rowspan="<?=$row ?>">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/CaseManagement/index/<?php echo $flag ?>/<?php echo $data['CaseManagement']['id']; ?>/profile','案件詳細','width=1200,height=800,scrollbars=yes');" class="link_prof">
            <font style="font-size:90%;color: #006699;">
            <b><?php echo $data['CaseManagement']['case_name']; ?></b><br>
                <?php
                    if (!empty($data['CaseManagement']['client'])) {
                        echo $customer_array[$data['CaseManagement']['client']].'<br>';
                    }
                ?>
                <?php
                    for($j=0; $j<10; $j++) {
                        if (!empty($data['CaseManagement']['entrepreneur'.($j+1)])) {
                            echo '（'.$customer_array[$data['CaseManagement']['entrepreneur'.($j+1)]].'）<br>';
                        }
                    }
                ?>
            </font>
        </a>
    </td>
    <td align="center" style="font-size: 90%;" rowspan="<?=$row ?>">
	<?=setCType($data['CaseManagement']['contract_type']); ?>
    </td>
    <td align="center" style="font-size: 90%;" rowspan="<?=$row ?>"><?php echo $data['CaseManagement']['start_date'];?></td>
    <?php $tantou_user = $data['User']['name_sei'].' '.$data['User']['name_mei']; ?>
    <td align="center" style="font-size: 90%;" rowspan="<?=$row ?>"><?php echo $tantou_user; ?></td>
    <td align="left" style="font-size: 90%;" rowspan="<?=$row ?>">
        <?php 
            echo $data['CaseManagement']['address'].'<br>'; 
            if (!empty($data['CaseManagement']['telno'])) {
                echo $data['CaseManagement']['telno'].'<br>'; 
            }
            if (!empty($data['CaseManagement']['leader'])) {
                echo $data['CaseManagement']['leader'].'<br>'; 
            }
        ?>
    </td>
    <td align="left" style="font-size: 90%;">
        <?php
            if (!empty($datas_order[$key])) {
                echo $list_shokushu[$datas_order[$key][0]['OrderInfoDetail']['shokushu_id']];
                if (!empty($datas_order[$key][0]['OrderInfoDetail']['shokushu_memo'])) {
                    echo '（'.$datas_order[$key][0]['OrderInfoDetail']['shokushu_memo'].'）';
                }
                echo '<br>';
            }
        ?>
    </td>
    <td align="center" style="font-size: 90%;">
        <?php
            if (!empty($datas_order[$key])) {
                if (!empty($datas_order[$key][0]['OrderInfoDetail']['worktime_from']) && !empty($datas_order[$key][0]['OrderInfoDetail']['worktime_to'])) {
                    echo $datas_order[$key][0]['OrderInfoDetail']['worktime_from'].'～'.$datas_order[$key][0]['OrderInfoDetail']['worktime_to'].'<br>';
                }
            }
        ?>
    </td>
    <td align="center" style="font-size: 90%;">
        <?php
            $shiharai_arr = array('1'=>'時給', '2'=>'日給', '3'=>'月給', ''=>'');
            if (!empty($datas_order[$key])) {
                echo $shiharai_arr[$datas_order[$key][0]['OrderInfoDetail']['juchuu_shiharai']].' ';
                echo $datas_order[$key][0]['OrderInfoDetail']['juchuu_money'].'円<br>';
            }
        ?>
    </td>
    <td align="center" style="font-size: 90%;">
         <?php
            if (!empty($datas_order[$key])) {
                echo $datas_order[$key][0][0]['cnt'].'名<br>';
            }
        ?>
    </td>
    <td align="center" style="font-size: 90%;" rowspan="<?=$row ?>">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/CaseManagement/reg2/<?php echo $data['CaseManagement']['id'] ?>/2','オーダー情報','width=1200,height=800,scrollbars=yes');" class="link_prof">
            【リンク】
        </a><br>
        <?php
            if (empty($order_update_date[$key])) {
                echo '<font color=red>未入力</font>';
            } else {
                echo date('Y-m-d', strtotime($order_update_date[$key]['CaseLog']['created']));
            }
        ?>
    </td>
    <td align="center" style="font-size: 90%;" rowspan="<?=$row ?>">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?=date('Y-m') ?>','オーダー情報','width=1200,height=800,scrollbars=yes');" class="link_prof">
        <!--
        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?=date('Y-m') ?>" class="link_prof">
        -->
            【リンク】
        </a><br>
        <?php
            if (empty($shift_update_date[$key])) {
                echo '<font color=red>未入力</font>';
            } else {
                echo date('Y-m-d', strtotime($shift_update_date[$key]['WorkTable']['modified']));
            }
        ?>
    </td>
    <td align="center" style="font-size: 90%;" rowspan="<?=$row ?>">
        <a href="#">
            【リンク】
        </a><br>
        <?php echo date('Y-m-d', strtotime($data['CaseManagement']['modified'])); ?><br>
        <?php echo '<font color=red>未作成</font>'; ?>
    </td>
    <td align="center" style="font-size: 90%;" rowspan="<?=$row ?>">
        <?php $id = 1; ?>
        <a href="javascript:void(0);" 
           onclick="window.open('<?=ROOTDIR ?>/CaseManagement/index/0/<?php echo $data['CaseManagement']['id']; ?>/copy','案件詳細','width=1200,height=800,scrollbars=yes');">
            【複製】
        </a><br>
        <?php echo $this->Html->link('【稼働表】', array(), array()); ?><br>
        <br>
        <a type="button" href="#" onclick="doSubmit(<?=$data['CaseManagement']['id'] ?>, 1);" class="link_prof">【削除】</a><br>
        <a type="button" href="#" onclick="doSubmit(<?=$data['CaseManagement']['id'] ?>, 2);" class="link_prof">【クローズ】</a>
    </td>
  </tr>
<?php if ($row > 1) { ?>
<?php for ($i=1; $i<$row ;$i++) { ?>
  <tr>
      <td style="font-size: 90%;" align="left">
        <?php
            echo $list_shokushu[$datas_order[$key][$i]['OrderInfoDetail']['shokushu_id']];
            if (!empty($datas_order[$key][$i]['OrderInfoDetail']['shokushu_memo'])) {
                echo '（'.$datas_order[$key][$i]['OrderInfoDetail']['shokushu_memo'].'）';
            }
            echo '<br>';
        ?>
      </td>
      <td style="font-size: 90%;" align="center">
          <?php echo $datas_order[$key][$i]['OrderInfoDetail']['worktime_from'].'～'.$datas_order[$key][$i]['OrderInfoDetail']['worktime_to'].'<br>'; ?>
      </td>
      <td style="font-size: 90%;" align="center">
        <?php
            $shiharai_arr = array('1'=>'時給', '2'=>'日給', '3'=>'月給', ''=>'');
            echo $shiharai_arr[$datas_order[$key][$i]['OrderInfoDetail']['juchuu_shiharai']].' ';
            echo $datas_order[$key][$i]['OrderInfoDetail']['juchuu_money'].'円<br>'; 
        ?>
      </td>
      <td style="font-size: 90%;" align="center">
          <?php echo $datas_order[$key][$i][0]['cnt'].'名<br>'; ?>
      </td>
  </tr>
    <?php } ?>
    <?php } ?>
  <?php endforeach; ?>
<?php if (count($datas) == 0) { ?>
<tr>
    <td colspan="14" align="center">表示するデータはありません。</td>
</tr>
<?php } ?>
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

<!-- 機能紹介 -->
<script type="text/javascript">
/**
$(function() {
    //alert('制作中です');
  // 2ダイアログ機能を適用
  $('#dialog').dialog({
    modal: true,
    buttons: {
　　　　"OK": function(){
　　　　$(this).dialog('close');
　　　　}
　　　}
  });
});
**/
</script>
<div id="dialog" title="案件管理の紹介" style="display: none">
<p style="font-size: 90%;">
    この機能を使って、取引先の登録、職種の登録、各案件の登録・管理が可能になります。<br>
    <br>
    ※ただいま<font color="red">制作中</font>です。</p>
</div>