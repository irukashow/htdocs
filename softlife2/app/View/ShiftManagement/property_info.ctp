<?php
    echo $this->Html->css('staffmaster');
?>
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

<?php echo $this->Form->create('PropertyList', array('name' => 'form')); ?>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;margin-top: 10px;">
    ★ 物件情報リスト
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/reg_property" target=""><font Style="font-size:95%;color:yellow;">新規登録</font></a>

</div>
<!-- 見出し１ END -->

<!-- ページネーション -->
<div class="pageNav03" style="margin-top:5px; margin-bottom: 0px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
    &nbsp;&nbsp;
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
<!-- 物件情報本体 -->
<table border='1' cellspacing="0" cellpadding="3"
       style="margin-top: 0px;margin-bottom: 5px;border-spacing: 0px;background-color: white;width:100%;">
    <tr>
        <th align="center" style="background-color: #cccccc;"><?php echo $this->Paginator->sort('id','ID', array('escape' => false));?></th>
        <th align="center" style="background-color: #cccccc;">現場①</th>
        <th align="center" style="background-color: #cccccc;">現場②</th>
        <th align="center" style="background-color: #cccccc;">勤務時間</th>
        <th align="center" style="background-color: #cccccc;">売上</th>
        <th align="center" style="background-color: #cccccc;">給与</th>
    </tr>
    <tr style="background-color: #ffffcc;">
        <td align="center"></td>
        <td align="left">
            <?php echo $this->Form->input('search_scene1', array('type'=>'text', 'label' => false, 'placeholder'=>'現場①（一部分可）', 'style' => 'width:95%;font-size:90%;')); ?>
        </td>
        <td align="center">
            <?php echo $this->Form->input('search_scene2', array('type'=>'text', 'label' => false, 'placeholder'=>'現場②（一部分可）', 'style' => 'width:95%;font-size:90%;')); ?>
        </td>
        <td align="center"></td>
        <td align="center"></td>
        <td></td>
    </tr>
    <?php foreach($datas1 as $key => $data1) { ?>
    <tr>
        <td align="center" style="padding: 0px 10px;">
            <a href="<?=ROOTDIR ?>/ShiftManagement/reg_property/<?=$data1['PropertyList']['id']; ?>">
            <?=$data1['PropertyList']['id']; ?>
            </a>
        </td>
        <td align="left" style="padding: 0px 10px;">
            <a href="<?=ROOTDIR ?>/ShiftManagement/reg_property/<?=$data1['PropertyList']['id']; ?>">
            <?=$data1['PropertyList']['scene1']; ?>
            </a>
        </td>
        <td align="left">
            <a href="<?=ROOTDIR ?>/ShiftManagement/reg_property/<?=$data1['PropertyList']['id']; ?>">
            <?=$data1['PropertyList']['scene2']; ?>
            </a>
        </td>
        <td align="center" style="padding: 0px 10px;font-size: 90%;">
        <?=$data1['PropertyList']['work_time_from']; ?>~<?=$data1['PropertyList']['work_time_to']; ?>
        </td>
        <td align="left"><?=number_format($data1['PropertyList']['sales']); ?></td>
        <td align="left"><?=number_format($data1['PropertyList']['salary']); ?></td>
    </tr>        
    <?php } ?>
<?php if (count($datas1) == 0) { ?>
<tr>
    <td colspan="36" align="center" style="background-color: #fff9ff;">表示するデータはありません。</td>
</tr>
<?php } ?>
</table>
<!-- カレンダー END-->
<!--- スタッフマスタ本体 END --->

<!-- ページネーション -->
<div class="pageNav03" style="margin-top:0px; margin-bottom: 10px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
</div>
<div style="clear:both;"></div>

<div style="margin-top: 10px;">
<?php print($this->Form->input('閉 じ る', array('type'=>'button', 'id'=>'button-delete', 
    'name'=>'close','label'=>false, 'style'=>'cursor:pointer;', 'onclick'=>'window.close();'))); ?>
</div>
<?php echo $this->Form->end(); ?>

