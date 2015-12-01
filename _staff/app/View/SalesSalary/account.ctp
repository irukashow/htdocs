<?php
    echo $this->Html->css('staffmaster');
?>
<?php
    function setSalary($value, $array) {
        if (empty($array[$value])) {
            $ret = '';
        } else {
            $ret = number_format($array[$value]);
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

<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ 売上給与
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/index" target="" onclick=''><font Style="font-size:95%;">売上給与データ</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/bill" target="" class="load"><font Style="font-size:95%;">請求書作成</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/salary" target="" class="load" onclick=''><font Style="font-size:95%;">給与金額</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <b><font Style="font-size:95%;color: yellow;">[銀行口座]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/address/1" target="" onclick=''><font Style="font-size:95%;">スタッフ住所覧</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/modification/1" target="" onclick=''><font Style="font-size:95%;">個人情報変更</font></a>
    &nbsp;
</div>
<!-- 見出し１ END -->

<?php echo $this->Form->create('StaffMaster', array('name' => 'form')); ?>
<?php echo $this->Form->submit('検索', array('name' => 'search', 'style' => 'display:none;')); ?>
<!-- ページネーション -->
<div class="pageNav03" style="margin-top:0px; margin-bottom: 5px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
    <div style="float:left;margin-left: 10px;margin-top: 5px;">
        <?php if (empty($flag) || $flag == 0) { ?>
        【表示】<a href="<?=ROOTDIR ?>/SalesSalary/account/2" style="color:red;">要登録</a> | <a href="<?=ROOTDIR ?>/SalesSalary/account/1" style="color:#0000FF;">未登録</a> | <b><font style="background-color: yellow;">登録済</font></b>
        <?php } elseif ($flag == 1) { ?>
        【表示】<a href="<?=ROOTDIR ?>/SalesSalary/account/2" style="color:red;">要登録</a> | <b><font color="#FF5F17" style="background-color: yellow;color:#0000FF;">未登録</font></b> | <a href="<?=ROOTDIR ?>/SalesSalary/account/0">登録済</a>
        <?php } elseif ($flag == 2) { ?>
        【表示】<b><font color="red" style="background-color: yellow;">要登録</font></b> | <a href="<?=ROOTDIR ?>/SalesSalary/account/1" style="color:#0000FF;">未登録</a> | <a href="<?=ROOTDIR ?>/SalesSalary/account/0">登録済</a>
        <?php } ?>
    </div>
    <div style="float:right;margin-top: 5px;">
        <?php echo $this->Paginator->counter(array('format' => __('総件数  <b>{:count}</b> 件')));?>
        <input type="hidden" name="count" value="<?php echo $this->Paginator->counter(array('format' => __('{:count}')));?>">
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
    <thead>
  <tr style="font-size: 100%;margin-top: -10px;">
    <th rowspan="2" style="width:10%;"><?php echo $this->Paginator->sort('id',"登録番号");?></th>
    <th rowspan="2" style="width:10%;"><?php echo $this->Paginator->sort('name_sei','氏名', array('escape' => false));?></th>
    <th rowspan="2" colspan="1" style="width:10%;"><?php echo $this->Paginator->sort('name_sei2','フリガナ', array('escape' => false));?></th>
    <th rowspan="1" colspan="6" style="width:45%;color:white;">振込口座</th>
    <th rowspan="2" colspan="1" style="width:10%;color:white;">今月の給与<br>（現時点）</th>
  </tr>
  <tr>
    <th style="width:5%;"><?php echo $this->Paginator->sort('name_kouza_reg','登録済', array('escape' => false));?></th>
    <th style="width:10%;"><?php echo $this->Paginator->sort('bank_name','銀行', array('escape' => false));?></th>
    <th style="width:10%;"><?php echo $this->Paginator->sort('name_shiten','支店', array('escape' => false));?></th>
    <th style="width:10%;"><?php echo $this->Paginator->sort('name_branch_code','店番号', array('escape' => false));?></th>
    <th style="width:10%;"><?php echo $this->Paginator->sort('name_kouza_num','口座番号', array('escape' => false));?></th>
    <th style="width:10%;"><?php echo $this->Paginator->sort('name_kouza_meigi','口座名義（カナ）', array('escape' => false));?></th>
  </tr>
  <tr>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input(false, array('type'=>'text', 'name'=>'search_id', 'label' => false, 'placeholder'=>'登録番号', 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input(false, array('type'=>'text', 'name'=>'search_name', 'label' => false, 'placeholder'=>'氏名（漢字 or かな）', 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
  </tr>
    </thead>
  <tbody style="">
  <?php foreach ($datas as $i=>$data): ?>
    <?php
        $flag_reg = $data['StaffMaster']['bank_kouza_reg'];
        $type = '';
        if (empty($flag_reg) || $flag_reg == 0) {
            $bgcolor = '#C2EEFF';
            $flag_reg = 0;
        } elseif ($flag_reg == 1) {
            $bgcolor = '#fff9ff';
            if ($data['StaffMaster']['koushin_flag3'] == 1) {
                $bgcolor = '#FFFFCC';
                $type = '<span style="color:red;">（変更あり）</span>';
            }
        }
        if ($flag_reg == 0 && !empty(setSalary($data['StaffMaster']['id'], $data_salary))) {
            $bgcolor = '#FFFF99';
        }
    ?>
<tr style="background-color:<?=$bgcolor?>;">
    <!-- 登録番号 -->
    <td align="center">
        <?php echo $data['StaffMaster']['id']; ?>
        <input type="hidden" name="data[StaffMaster][<?=$i?>][id]" value="<?=$data['StaffMaster']['id']; ?>">
        <input type="hidden" name="data[StaffMaster][<?=$i?>][koushin_flag3]" value="0">
    </td>
    <!-- 氏名 -->
    <td align="left" style="font-size: 100%;">
                <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/StaffMasters/index/0/<?php echo $data['StaffMaster']['id']; ?>/profile','スタッフ登録','width=1200,height=900,scrollbars=yes');" class="link_prof">
        <?php echo $data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei']; ?>
                </a><?=$type ?>
    </td>
    <!-- フリガナ -->
    <td align="left" style="font-size: 100%;">
        <?php echo $data['StaffMaster']['name_sei2'].' '.$data['StaffMaster']['name_mei2']; ?>
    </td>
    <!-- 登録済み -->
    <td align="center" style="font-size: 100%;padding-left: 30px;">
        <?php 
            echo $this->Form->input('StaffMaster.'.$i.'.bank_kouza_reg', array('type'=>'checkbox', 'label' => false, 
                'style' => '', 'value' =>1, 'checked'=>$flag_reg, 'onchange'=>'')); 
        ?>
    </td>
    <!-- 銀行 -->
    <td align="left" style="font-size: 100%;">
        <?php echo $data['StaffMaster']['bank_name']; ?>
    </td>
    <!-- 支店 -->
    <td align="left" style="font-size: 100%;">
        <?php echo $data['StaffMaster']['bank_shiten']; ?>
    </td>
    <!-- 店番号 -->
    <td align="left" style="font-size: 100%;">
        <?php echo $data['StaffMaster']['bank_branch_code']; ?>
    </td>
    <!-- 口座番号 -->
    <td align="left" style="font-size: 100%;">
        <?php echo $data['StaffMaster']['bank_kouza_num']; ?>
    </td>
    <!-- 口座名義（カナ） -->
    <td align="left" style="font-size: 100%;">
        <?php echo $data['StaffMaster']['bank_kouza_meigi']; ?>
    </td>
    <!-- 今月の給与 -->
    <td align="right" style="font-size: 100%;">
        <?php echo setSalary($data['StaffMaster']['id'], $data_salary); ?>
    </td>
  </tr>
  <?php endforeach; ?>
<?php if (count($datas) == 0) { ?>
<tr>
    <td colspan="10" align="center">表示するデータはありません。</td>
</tr>
<?php } ?>
  </tbody>
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
<div style="clear:both;"></div>
    <div style='margin: 10px 0px 0px 0px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'register','div' => false)); ?>
    </div>
<!--- スタッフマスタ本体 END --->
<?php echo $this->Form->end(); ?>
