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
<?php echo $this->Form->create('Customer', array('name' => 'form')); ?>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ 案件管理
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/case_management/index/0" target="" onclick=''><font Style="font-size:95%;">案件一覧</font></a>
    &nbsp;
    <b><font Style="font-size:95%;color: yellow;">[取引先一覧]</font></b>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/case_management/shokushu" target=""><font Style="font-size:95%;">職種マスタ</font></a>
</div>
<!-- 見出し１ END -->
<!-- 見出し２ -->
<div id='headline' style="padding:5px 10px 5px 10px;">
    &nbsp;
    <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/case_management/register_customer/0/0','新規登録','width=1200,height=800,scrollbars=yes');" id='button-create'>新規登録</a>
    &nbsp;
<?php if ($flag == 0 || empty($flag)) { ?>
    <b><font Style="font-size:95%;">[登録リスト]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/case_management/customer/1" target=""><font Style="font-size:95%;">登録解除リスト</font></a>
<?php } elseif ($flag == 1) { ?>
    <a href="<?=ROOTDIR ?>/case_management/customer/0" target=""><font Style="font-size:95%;">登録リスト</font></a>
    &nbsp;
    <b><font Style="font-size:95%;">[登録解除リスト]</font></b>
<?php } ?>
    &nbsp;&nbsp;&nbsp;
    <?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'font-size:90%; margin:0px; padding:5px 15px 5px 15px;')); ?>
    &nbsp;
    <?php echo $this->Form->submit('検索条件クリア', array('name' => 'clear', 'div' => false, 'id' => 'clear', 'style' => 'font-size:90%; margin:0px; padding:5px 15px 5px 15px;')); ?>
</div>
<!-- 見出し２ END -->

<!-- ページネーション -->
<div class="pageNav03" style="margin-bottom: 30px;">
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

<!--- スタッフマスタ本体 START --->
<table id="staff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;margin: 0px 0px 5px 0px;">
  <tr style="font-size: 100%;">
      <th style="width:5%;"><?php echo $this->Paginator->sort('id',"No.");?></th>
    <th style="width:15%;"><?php echo $this->Paginator->sort('corp_name','企業名');?></th>
    <th style="width:15%;"><?php echo $this->Paginator->sort('busho','部署<br>担当者', array('escape' => false));?></th>
    <th style="width:10%;"><?php echo $this->Paginator->sort('telno','電話番号', array('escape' => false));?></th>
    <th style="width:15%;"><?php echo $this->Paginator->sort('email','メールアドレス');?></th>
    <th style="width:10%;"><?php echo $this->Paginator->sort('modified','作成日<br>更新日', array('escape' => false));?></th>
  </tr>
  <tr>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input('search_corp_name', array('type'=>'text', 'label' => false, 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input('search_tantou', array('type'=>'text', 'label' => false, 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input('search_telno', array('type'=>'text', 'label' => false, 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;"><?php echo $this->Form->input('search_email', array('type'=>'text', 'label' => false, 'style' => 'width:90%;')); ?></td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
  </tr>
  <?php foreach ($datas as $data): ?>
  <tr>
    <?php $staff_id = $data['Customer']['id']; ?>
    <td align="center">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/case_management/register_customer/<?php echo $flag ?>/<?php echo $data['Customer']['id']; ?>','取引先登録','width=1200,height=800,scrollbars=yes');" class="link_prof">
            <font style="font-weight: bold;color: #006699;"><?php echo $staff_id; ?></font>
        </a>
    </td>
    <td align="left">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/case_management/register_customer/<?php echo $flag ?>/<?php echo $data['Customer']['id']; ?>','取引先登録','width=1200,height=800,scrollbars=yes');" class="link_prof">
            <?php echo $data['Customer']['corp_name']; ?>
        </a>
    </td>
    <td align="left">
        <a href="javascript:void(0);" onclick="window.open('<?=ROOTDIR ?>/case_management/register_customer/<?php echo $flag ?>/<?php echo $data['Customer']['id']; ?>','取引先登録','width=1200,height=800,scrollbars=yes');" class="link_prof">
            <?php echo $data['Customer']['busho'].'<br>'.$data['Customer']['tantou']; ?>
        </a>
    </td>
    <td align="left"><?php echo $data['Customer']['telno']; ?></td>
    <td align="left"><?php echo $data['Customer']['email']; ?></td>
    <td align="center"><?php echo date('Y-m-d', strtotime($data['Customer']['created'])).'<br>'.date('Y-m-d', strtotime($data['Customer']['modified'])); ?></td>
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

