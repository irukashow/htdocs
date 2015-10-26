<?php
    //echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    //echo $this->Html->script('jquery-1.9.1');
    //echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
    //echo $this->Html->script('jquery.timepicker');
    echo $this->Html->script('fixed_midashi');
    echo $this->Html->script('jquery.tablefix');
    echo $this->Html->script('redips-drag-min');
    echo $this->Html->script('script');
    echo $this->Html->script('evol.colorpicker.min.js');
    echo $this->Html->css('evol.colorpicker.min');
    //echo $this->Html->css('jquery.timepicker');
    echo $this->Html->css('style_1');
    echo $this->Html->css('log');
?>
<script src="<?=ROOTDIR ?>/js/jquery-hex-colorpicker.js"></script>
<link rel="stylesheet" href="<?=ROOTDIR ?>/css/jquery-hex-colorpicker.css" />
<?php
    // 初期値
    //$y = date('Y');
    $y = date('Y', strtotime('+1 month'));
    //$m = date('n');
    $m = date('n', strtotime('+1 month'));

    // 日付の指定がある場合
    if(!empty($_GET['date']))
    {
            $arr_date = explode('-', $_GET['date']);

            if(count($arr_date) == 2 and is_numeric($arr_date[0]) and is_numeric($arr_date[1]))
            {
                    $y = (int)$arr_date[0];
                    $m = (int)$arr_date[1];
            }
    }
?>

<script>
onload = function() {
    FixedMidashi.create();
    REDIPS.drag.dropMode = 'multiple';
}
</script>
<script>
// 色の選択
$(document).ready(function() {
    for (i=0; i<<?=count($datas) ?> ;i++) {
        $(".demo"+i).hexColorPicker();
    }
});
// 色のセット
function setColor() {
    for (i=0; i<100; i++) {
        $(".bgcolor"+i).val($(".demo"+i).css('background-color'));
        $(".color"+i).val($(".demo"+i).css('color'));
    }
}
// 色の登録
function doSubmit() {
    setColor();
    var form = document.createElement('form');
    for (i=0; i<100; i++) {
        var input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', 'bgcolor'+i);
        input.setAttribute('value', $(".demo"+i).css('background-color'));
        form.appendChild(input);
    }
    form.setAttribute('action', '<?=ROOTDIR ?>/ShiftManagement/setting');
    form.setAttribute('method', 'post');
    form.submit();
}
</script>

<?php echo $this->Form->create('WorkTable', array('name'=>'frm', 'id'=>'form')); ?> 
<!-- 見出し１ -->
<div id='headline' style="padding:5px 10px 5px 10px;">
    ★ シフト管理
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/index" target=""><font Style="font-size:95%;">スタッフシフト希望</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/schedule" target="" onclick=''><font Style="font-size:95%;">シフト作成</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/schedule2?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target="" id="shift" class="load" onclick=''><font Style="font-size:95%;">確定シフト</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/uri9" target=""><font Style="font-size:95%;">勤務実績</font></a>
    &nbsp;
    <b><font Style="font-size:100%;color: yellow;">[詳細設定]</font></b>
    &nbsp;
</div>
<!-- 見出し１ END -->

<div style="height: 900px;">
<?php echo $this->Form->create('CaseManagement'); ?>
<p style="font-size: 110%;">１．【シフト表】案件の並び順、および背景色の変更</p>
<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>
<div style="clear:both;"></div>
<!--- 職種マスタ管理 START --->
<table border="1" width="60%" cellspacing="0" cellpadding="3" bordercolor="#333333" align="left" style="margin-top: -10px;">
  <tr class="col">
    <th width="15%"><font style="color:white;font-weight: normal;">表示順</font></th>
    <th width="10%"><?php echo $this->Paginator->sort('id',"ID");?></th>
    <th width="60%"><?php echo $this->Paginator->sort('case_name','案件名称');?></th>
    <th width="15%"><font style="color:white;font-weight: normal;"></th>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <input type="hidden" name="record" value="<?=count($datas) ?>">
  <tr id="row<?=$key ?>">
    <td align="left">
        【<?php echo $key+1; ?>】
        <!--
        <input type="hidden" name="data[CaseManagement][sequence]" value="<?=$data['CaseManagement']['sequence'] ?>">
        -->
        <?php
        if ($key == 0) {
            echo '<font style="font-size: 120%;">▲</font>';
        } else {
            print($this->Html->link('▲', 'setting/'.$datas[$key]['CaseManagement']['id'].'/'.$datas[$key-1]['CaseManagement']['id'].'/'.($key+1).'/up', array('style' => 'font-size: 120%;', 'title' => '上へ'))); 
        }
        ?>
        &nbsp;
        <?php 
        if ($key == ($record-1)) {
            echo '<font style="font-size: 120%;">▼</font>';
        } else {
            print($this->Html->link('▼', 'setting/'.$datas[$key]['CaseManagement']['id'].'/'.$datas[$key+1]['CaseManagement']['id'].'/'.($key+1).'/down', array('style' => 'font-size: 120%;', 'title' => '下へ'))); 
        }
        ?>
        <input type="hidden" name="id<?=$key ?>" value="<?=$datas[$key]['CaseManagement']['id'] ?>">
        <?php echo $this->Form->input('CaseManagement.'.$key.'.id', array('type'=>'hidden', 'value'=>$datas[$key]['CaseManagement']['id'])); ?>
        <?php echo $this->Form->input('CaseManagement.'.$key.'.bgcolor', array('type'=>'hidden', 'class'=>'bgcolor'.$key)); ?>
        <?php echo $this->Form->input('CaseManagement.'.$key.'.color', array('type'=>'hidden', 'class'=>'color'.$key)); ?>
    </td>  
    <td align="center"><?php echo $data['CaseManagement']['id']; ?></td>
    <td>
        <div class="demo<?=$key ?>" style="padding: 5px;background-color: <?=$data['CaseManagement']['bgcolor'] ?>;color: <?=$data['CaseManagement']['color'] ?>;">
        <?php echo $data['CaseManagement']['case_name']; ?>
        </div>
    </td>
    <?php if ($key == 0) { ?>
    <td align="center" rowspan="<?=count($datas) ?>" style="vertical-align: top;padding-top: 15px;">
        <?php echo $this->Form->input('背景色の変更', array('type' => 'button', 'name' => 'change_color['.$data['CaseManagement']['id'].']',
            'label' => false,'div' => false, 'id'=>'button-create', 'style' => 'padding:10px 15px;border:1px solid black;cursor:pointer;',
            'onclick' => 'doSubmit();')); ?>
    </td>
    <?php } ?>
  </tr>
  <?php endforeach; ?>
  <?php if (count($datas) == 0) { ?>
  <tr>
      <td colspan="4" align="center" style="background-color: #fff9ff;">登録している案件データがありません。</td>
  </tr>
  <?php } ?>
</table>
<!--- 職種マスタ管理 END --->
<div style="clear:both;"></div>
<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>

<?php echo $this->Form->end(); ?>
</div>


