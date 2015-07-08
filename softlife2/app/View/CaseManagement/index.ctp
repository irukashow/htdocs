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
<script type="text/javascript">
<!-- 
//ID絞り込みテキストボックスでENTERが押された場合 
function doSearch1(id) {
    if(event.keyCode == 13){
	var elm = document.createElement("input");
	elm.setAttribute("name", "id");
	elm.setAttribute("type", "hidden");
	elm.setAttribute("value", id);
	form.appendChild(elm);
	form.submit();
        return false;
    }
}
//-->
</script>    
<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ 案件管理
    &nbsp;&nbsp;
    <b><font Style="font-size:95%;color: yellow;">[案件一覧]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/case_management/customer/0" target="" onclick=''><font Style="font-size:95%;">取引先一覧</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/case_management/shokushu" target=""><font Style="font-size:95%;">職種マスタ</font></a>
</div>
<!-- 見出し１ END -->
<!-- 見出し２ -->
<div id='headline' style="padding:5px 10px 5px 10px;">
    &nbsp;
    <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/staff_masters/reg1/0/0','スタッフ登録','width=1200,height=800,scrollbars=yes');" id='button-create'>新規登録</a>
    &nbsp;
<?php if ($flag == 0 || empty($flag)) { ?>
    <b><font Style="font-size:95%;">[登録リスト]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/case_management/index/1" target=""><font Style="font-size:95%;">削除済リスト</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/case_management/index/2" target=""><font Style="font-size:95%;">クローズ一覧</font></a>
<?php } elseif ($flag == 1) { ?>
    <a href="<?=ROOTDIR ?>/case_management/index/0" target=""><font Style="font-size:95%;">登録リスト</font></a>
    &nbsp;
    <b><font Style="font-size:95%;">[削除済リスト]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/case_management/index/2" target=""><font Style="font-size:95%;">クローズ一覧</font></a>
<?php } elseif ($flag == 2) { ?>
    <a href="<?=ROOTDIR ?>/case_management/index/0" target=""><font Style="font-size:95%;">登録リスト</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/case_management/index/1" target=""><font Style="font-size:95%;">削除済リスト</font></a>
    &nbsp;
    <b><font Style="font-size:95%;">[クローズ一覧]</font></b>
<?php } ?>    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/case_management/index/<?=$flag ?>" target="" id="clear">検索条件クリア</a>
    &nbsp;
    <?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'font-size:90%; margin:0px; padding:5px 15px 5px 15px;')); ?>
</div>
<!-- 見出し２ END -->

<?php echo $this->Form->create('CaseManagement', array('name' => 'form')); ?>
<!-- ページネーション -->
<div class="pageNav03" style="margin-top:-20px; margin-bottom: 30px;">
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
<a onclick="window.open('<?=ROOTDIR ?>/case_management/profile/0/1','スタッフ登録','width=1200,height=800,scrollbars=yes');" class="link_prof">profile</a>
<!--- スタッフマスタ本体 START --->
<table id="staff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;margin: 0px 0px 5px 0px;">
  <tr style="font-size: 100%;">
      <th><?php echo $this->Paginator->sort('no',"No.");?></th>
      <th style="width:10%;"><?php echo $this->Paginator->sort('id','案件名<br>依頼主<br>事業主', array('escape' => false));?></th>
      <th style="width:10%;"><?php echo $this->Paginator->sort('name_sei','契約形態', array('escape' => false));?></th>
      <th style="width:5%;"><?php echo $this->Paginator->sort('age','開始日<br>終了日', array('escape' => false));?></th>
    <th style="width:7%;"><?php echo $this->Paginator->sort('tantou','担当者');?></th>
    <th style="width:7%;"><?php echo $this->Paginator->sort('ojt_date','就業場所<br>住所<br>電話番号<br>担当者', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('service_count','今月のオーダー内容／来月のオーダー内容<br>職種・勤務時間・受注金額・人数', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('shokushu_shoukai','オーダー入力<br>更新日<br>入力済チェック', array('escape' => false));?></th>
    <th style="width:7%;"><?php echo $this->Paginator->sort('koushin_date','シフト入力<br>更新日<br>作成済チェック', array('escape' => false));?></th>
    <th><?php echo $this->Paginator->sort('3m_spot','帳票作成<br>更新日<br>作成済チェック', array('escape' => false));?></th>
  </tr>
  <tr>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">
          <?php echo $this->Form->input('search_id', array('type'=>'text', 'label' => false, 'style' => 'width:90%;', 'onkeydown' => 'doSearch1(this.value);')); ?>
      </td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input('search_name', array('type'=>'text', 'label' => false, 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input('search_age', array('type'=>'text', 'label' => false, 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;">
          <?php echo $this->Form->input('search_tantou', 
                  array('type'=>'select', 'label' => false, 'style' => 'width:90%;','empty' => array('' => ''), 'options' => $name_arr, 'onchange' => 'form.submit();')); ?>
      </td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
  </tr>
  <?php foreach ($datas as $data): ?>
  <tr>
    <td align="right">&nbsp;</td>
    <?php $staff_id = $data['StaffMaster']['id']; ?>
    <td align="center">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/case_management/index/<?php echo $flag ?>/<?php echo $data['StaffMaster']['id']; ?>/profile','スタッフ登録','width=1200,height=800,scrollbars=yes');" class="link_prof">
            <font style="font-weight: bold;color: #006699;"><?php echo $staff_id; ?></font>
        </a>
    </td>
    <td align="center" style="font-size: 110%;">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/case_management/index/<?php echo $flag ?>/<?php echo $data['StaffMaster']['id']; ?>/profile','スタッフ登録','width=1200,height=800,scrollbars=yes');" class="link_prof">
            <?php echo $data['StaffMaster']['name_sei']." ".$data['StaffMaster']['name_mei'];?><br>
        </a>
	<?=date('Y-m-d', strtotime($data['StaffMaster']['created'])); ?>
    </td>
    <td align="center"><?php echo $data['StaffMaster']['age'].'歳'."<br>".getGender($data['StaffMaster']['gender']);?></td>
    <?php $tantou_user = $data['StaffMaster']['tantou']; ?>
    <td align="center"><?php echo $tantou_user; ?></td>
    <td align="center"><?php echo getOjt($data['StaffMaster']['ojt']).'<br>'.$data['StaffMaster']['ojt_date']; ?></td>
    <td align="center"><?php echo '＜？＞'; ?></td>
    <td align="left"><?php echo getShokushu2($data['StaffMaster']['shokushu_shoukai']); ?></td>
    <td align="left"><?php echo date('Y-m-d', strtotime($data['StaffMaster']['modified'])).'<br>'.$data['User']['koushin_name_sei'].' '.$data['User']['koushin_name_mei']; ?></td>
    <td align="center"><?php echo '＜？＞'; ?></td>
  </tr>
  <?php endforeach; ?>
<?php if (count($datas) == 0) { ?>
<tr>
    <td colspan="13" align="center">表示するデータはありません。</td>
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

