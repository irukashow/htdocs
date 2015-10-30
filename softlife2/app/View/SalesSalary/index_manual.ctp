<?php
    echo $this->Html->css('staffmaster');
    echo $this->Html->script('fixed_midashi');
?>
<?php require('calender.ctp'); ?>
<?php
    // 所属
    $list_division = array(
        '1' => 'スタッフ',
        '2' => '社員',
        '3' => 'ベルサンテ',
    );
    // 日付のフォーマット
    function setDate($date) {
        if (empty($date)) {
            return '';
        }
        $ret = date('n月j日', strtotime($date));
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
//ページの読み込み完了後に実行
window.onload = function(){
    FixedMidashi.create();
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        //$("#staff_master").fadeIn();
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
  $('.date').datepicker({ dateFormat: 'm月d日' });
});
</script>
<style type="text/css" media="screen">
  div.scroll_div { 
      overflow: auto;
      height: 500px;
      width: auto;
      margin-top: 0px;
  }
  input [type=select] {
      font-size:90%;
  }
</style>
<!--
<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
-->
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ 売上給与
    &nbsp;&nbsp;
    <b><font Style="font-size:95%;color: yellow;">[売上給与データ]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/bill" target="" class="load"><font Style="font-size:95%;">請求書作成</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/salary" target="" class="load" onclick=''><font Style="font-size:95%;">給与金額</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/account" target="" onclick=''><font Style="font-size:95%;">銀行口座</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/address" target="" onclick=''><font Style="font-size:95%;">スタッフ住所覧</font></a>
    &nbsp;
</div>
<!-- 見出し１ END -->

<?php echo $this->Form->create('SalesSalary', array('name' => 'form')); ?>
<?php
    // 当月ならば、月を黄色に
    if ($y == date('Y') && $m == date('m')) {
        $color = 'color:#ffffcc;font-weight:bold;';
    } else {
        $color = 'color:white;';
    }
?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td style=''><a href="<?=ROOTDIR ?>/SalesSalary/index_manual?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                <td style='background-color: #006699;color: white;'><font style='font-size: 110%;<?=$color ?>'>【<?php echo $y ?>年<?php echo $m ?>月】</font></td>
                <td style=''><a href="<?=ROOTDIR ?>/SalesSalary/index_manual?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
        </tr>
</table>

<!-- ページネーション -->
<div class="pageNav03" style="margin-top:5px; margin-bottom: 30px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
    <div style="float:left;margin-left: 10px;margin-top: 5px;">
        【入力】<a href="<?=ROOTDIR ?>/SalesSalary/index?date=<?=$date ?>">自動</a> | 
        <font style="font-weight: bold;background-color: #ffffcc;float:right;pading:0px 5px;">手動</font>
    </div>
    <div style="float:left;margin-left: 20px;margin-top: 5px;">
        <button type="button" style="cursor: pointer;" 
                onclick="window.open('<?=ROOTDIR ?>/SalesSalary/property_info','物件情報','width=800,height=700,scrollbars=yes');">物件情報</button>
    </div>
    <div style="float:right;margin-top: 5px;">
        <?php echo $this->Paginator->counter(array('format' => __('総件数  <b>{:count}</b> 件')));?>
        &nbsp;&nbsp;&nbsp;
        表示件数：
        <?php
            $list = array('5'=>'5','10'=>'10','20'=>'20','50'=>'50','100'=>'100');
            echo $this->Form->input('limit', array('name' => 'limit', 'type' => 'select','label' => false,'div' => false, 'options' => $list, //'selected' => $limit,
                'onchange' => 'form.submit();'));
        ?>
    </div>
 </div>
<div style="clear:both;"></div>

<div class="scroll_div">
<!--- スタッフマスタ本体 START --->
<table id="staff_master" border="1" width="1750px" cellspacing="0" cellpadding="1" 
       bordercolor="#333333" align="center" style="font-size: 80%;margin: 0px 0px 5px 0px;table-layout: fixed;" _fixedhead="rows:1; cols:1">
    <colgroup>
      <col style='width:50px;'>
      <col style='width:60px;'>
      
      <col style='width:80px;'>
      <col style='width:60px;'>
      
      <col style='width:50px;'>
      <col style='width:250px;'>
      <col style='width:100px;'>
      
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:100px;'>
      
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:100px;'>
    </colgroup>
    <thead>
  <tr style="font-size: 100%;margin-top: -10px;">
    <th rowspan="2" style="width:50px;"><?php echo $this->Paginator->sort('no',"No.");?></th>
    <th rowspan="2" style="width:50px;"><?php echo $this->Paginator->sort('id','勤務日付', array('escape' => false));?></th>
    <th rowspan="1" colspan="2" style="width:150px;"><?php echo $this->Paginator->sort('name_sei','勤務者', array('escape' => false));?></th>
    <th rowspan="1" colspan="3" style="width:350px;"><?php echo $this->Paginator->sort('name_sei','物件（案件）', array('escape' => false));?></th>
    <th rowspan="1" colspan="7" style="width:500px;"><?php echo $this->Paginator->sort('name_sei','売上金額', array('escape' => false));?></th>
    <th rowspan="1" colspan="8" style="width:500px;"><?php echo $this->Paginator->sort('name_sei','給与金額', array('escape' => false));?></th>
    </tr>
    <tr>
        <th style="color: white;width:100px;">氏名</th>
        <th style="color: white;width:50px;">所属</th>
        
        <th style="color: white;width:30px;">№</th>
        <th style="color: white;width:150px;">現場①</th>
        <th style="color: white;width:120px;">勤務時間</th>
        <th style="color: white;width:20px;">売上</th>
        <th style="color: white;width:40px;">時間外費</th>
        <th style="color: white;width:40px;">遅刻早退</th>
        <th style="color: white;width:40px;">その他</th>
        <th style="color: white;width:40px;">交通費</th>
        <th style="color: white;width:40px;">合計</th>
        <th style="color: white;width:100px;">備考</th>
        
        <th style="color: white;width:40px;">給与</th>
        <th style="color: white;width:40px;">時間外費</th>
        <th style="color: white;width:40px;">遅刻早退</th>
        <th style="color: white;width:40px;">その他</th>
        <th style="color: white;width:40px;">小計</th>
        <th style="color: white;width:40px;">交通費</th>
        <th style="color: white;width:40px;">合計</th>
        <th style="color: white;width:100px;">備考</th>
    </tr>
    <tr>
        <?php for ($i=0; $i<22; $i++) { ?>
        <td style="background-color: #ffffe6;"><?=$i+1 ?></td>
        <?php } ?>
  </tr>
    </thead>
  <tbody style="overflow-y:scroll;">
  <?php foreach ($datas as $count => $data): ?>
  <tr>
    <!-- No -->
    <td align="center">
        <?php echo $count+1; ?>
    </td>
    <!-- 勤務日付 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.work_date', 
                array('type'=>'text', 'label' => false, 'class' => 'date', 'style' => 'width:80%;text-align:center;', 'value'=>setDate($data['SalesSalary']['work_date']))); ?>
    </td>
    <!-- 氏名 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.name', 
                array('type'=>'text', 'label' => false, 'style' => 'width:80%;text-align:left;', 
                    'value' => $data['SalesSalary']['name'])); ?>
    </td>
    <!-- 所属 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.division', 
                array('type'=>'select', 'label' => false, 'options' => $list_division, 'style' => 'width:95%;font-size:90%;')); ?>
    </td>
    <!-- 物件№ -->
    <td align="center" style="font-size: 100%;">
        <?php echo $data['SalesSalary']['case_id']; ?>
    </td>
    <!-- 現場① -->
    <td align="left" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.case_id', 
                array('type'=>'select', 'label' => false, 'options' => $list_case3, 'selected'=>$data['SalesSalary']['case_id'], 'style' => 'width:95%;font-size:80%;')); ?>
    </td>
    <!-- 勤務時間 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.name', 
                array('type'=>'text', 'label' => false, 'div' => false, 'style' => 'width:40px;text-align:left;', 'value' =>$data['PropertyList']['work_time_from'])); ?>
        ~
        <?php echo $this->Form->input('SalesSalary.'.$count.'.name', 
                array('type'=>'text', 'label' => false, 'div' => false, 'style' => 'width:40px;text-align:left;', 'value' =>$data['PropertyList']['work_time_to'])); ?>
    </td>
    <!-- 売上 -->
    <td align="center" style="font-size: 100%;padding: 0px;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:80%;text-align:left;', 
                    'value' => $data['PropertyList']['sales'])); ?>
    </td>
    <!-- 時間外費 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:80%;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 遅刻早退 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:80%;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- その他 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 交通費 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 合計 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 備考 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.remarks', 
                array('type'=>'text', 'label' => false, 'style' => 'width:95%;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 給与 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => $data['PropertyList']['salary'])); ?>
    </td>
    <!-- 時間外費 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 遅刻早退 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- その他 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 小計 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 交通費 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 合計 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:left;', 
                    'value' => '')); ?>
    </td>
    <!-- 備考 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:95%;text-align:left;', 
                    'value' => '')); ?>
    </td>
  </tr>
  <?php endforeach; ?>
<?php if (count($datas) == 0) { ?>
<tr>
    <td colspan="29" align="center">表示するデータはありません。</td>
</tr>
<?php } ?>
  </tbody>
</table>
</div>

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
