<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('station');
    echo $this->Html->css('stuffmaster');
?>
<?php
    // 初期値セット
    $created = date('Y/m/d', strtotime($datas['StuffMaster']['created']));
    $modified = date('Y/m/d', strtotime($datas['StuffMaster']['modified']));
?>
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
  $('.date').datepicker({ dateFormat: 'yy/mm/dd' });
});
</script>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 20px;">
        <table border="0" style="width: 100%;height: 20px;">
            <tr>
                <td>
                    <div style="font-size: 150%;color: red;float:left;"><?php echo __('スタッフ登録 （評価関連）'); ?></div>
                </td>
                <td style="float: right;">
                    <?php print($this->Html->link('終了する', '', 
                            array('id'=>'button-delete','style' => 'margin:0px;', 'onclick' => 'window.opener.location.reload();window.close();'))); ?>
                </td>
            </tr>
        </table>
        <div style="clear: both;height: 0px;"></div>
        
<?php echo $this->Form->create('StuffMaster', array('name' => 'form','enctype' => 'multipart/form-data','id' => 'regist')); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $stuff_id)); ?>  
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>
        
        <!-- スタッフ情報 -->
        <table border='1' cellspacing="0" cellpadding="5" style='width: 100%;margin-top: 10px;border-spacing: 0px;'>
            <tr>
                <th colspan="2" style='background:#99ccff;text-align: center;'>スタッフ情報</th>
            </tr>
            <tr>
                <td colspan="2">
                    No.<?='0001' ?>&nbsp;&nbsp;登録番号：<?=$stuff_id ?>&nbsp;&nbsp;
                    作成日：<?=$created ?>&nbsp;&nbsp;更新日：<?=$modified ?>&nbsp;&nbsp;所属：<?=$class ?>
                </td>
            </tr>
        </table>
        <!-- 研修について -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th colspan="2" style='background:#99ccff;text-align: center;'>研修について</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>OJT/実施日</td>
                <td style='width:80%;'>
                    <?php echo $this->Form->input('ojt',array('type'=>'select','div'=>false,'label'=>false,'options'=>array('0'=>'未済','1'=>'済'),'style'=>'width:10%;text-align: left;')); ?>
                    &nbsp;&nbsp;
                    <?php echo $this->Form->input('ojt_date',array('type'=>'text','div'=>false,'label'=>false,'class'=>'date','style'=>'width:20%;text-align: left;')); ?>
                </td>
            </tr>
        </table>
        
        <!-- 評価について -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th colspan="2" style='background:#99ccff;text-align: center;'>評価について</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>表情</td>
                <td>
                <?php
                    $list1=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_hyoujou', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>発声・滑舌</td>
                <td>
                <?php
                    $list2=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_hassei', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>明るさ</td>
                <td>
                <?php
                    $list3=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_akarusa', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>華やかさ</td>
                <td>
                <?php
                    $list4=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_hanayakasa', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>清潔感</td>
                <td>
                <?php
                    $list5=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_seiketsukan', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メイク</td>
                <td>
                <?php
                    $list6=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_make', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>髪形</td>
                <td>
                <?php
                    $list7=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_hairstyle', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>姿勢</td>
                <td>
                <?php
                    $list8=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_shisei', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>所作</td>
                <td>
                <?php
                    $list9=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_shosa', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>柔軟さ</td>
                <td>
                <?php
                    $list10=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_juunansa', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>ハキハキ感</td>
                <td>
                <?php
                    $list11=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_hakihaki', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>協力度</td>
                <td>
                <?php
                    $list12=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_kyouryoku', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>雰囲気</td>
                <td>
                <?php
                    $list13=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                    echo $this->Form->input( 'hyouka_funiki', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:15%;'>備考</td>
                <td><?php echo $this->Form->input('hyouka_remarks',array('type'=>'textarea','div'=>false,'maxlength'=>'500','label'=>false,'style'=>'width:90%;height:80px;')); ?></td> 
            </tr>
        </table>
         
    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録完了', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php $back_url = '/stuff_masters/reg2/'.$stuff_id; ?>
<?php print($this->Html->link('戻　る', $back_url, array('class'=>'button-rink'))); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('終了する', '', array('id'=>'button-delete', 'onclick' => 'window.opener.location.reload();window.close();'))); ?>    
    </div>
<?php echo $this->Form->end(); ?>
</div>