

<!--シフト希望入力ページ-->
<div id="schedule_input" data-role="page">
    <div data-role="header" data-theme="c">
            <h1>シフト希望入力</h1>
            <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
    </div>			
    <div data-role="content" style="font-size: 100%;">
            <?php echo $this->Form->create('StaffSchedule', array('name' => 'form', 'url' => array('controller' => 'users', 'action' => 'schedule_input'))); ?>
        <?php echo $this->Form->input('id', array('type'=>'hidden')); ?>
        <?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $class)); ?>
            <?php echo $this->Form->input('staff_id', array('type'=>'hidden', 'value' => $id)); ?>
        <?php echo $this->Form->input('status', array('type'=>'hidden', 'value' => 1)); ?>
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <tr>
                    <td align="center" style='background-color: #e8ffff;width:10%;'>日付</td>
                    <td align="center" style="background-color: #ffffcc;">
                        <?php echo $this->Form->input('work_date', array('type'=>'hidden', 'value' => $date1)); ?>  
                        <?=$date2 ?>
                    </td>
                </tr>
                <tr>
                    <td align="center" style='background-color: #e8ffff;width:10%;'>勤務<br>希望</td>
                    <?php $list_work = array('1'=>'◎：可能','2'=>'△：条件付き','0'=>'✕：不可'); ?>
                    <td align="left">
                        <?php echo $this->Form->input('work_flag',array('type'=>'radio','legend'=>false,'div'=>'float:left;','style'=>'','data-inline'=>'true', 'options'=>$list_work)); ?>
                    </td>
                </tr>
                <tr>
                    <td align="center" style='background-color: #e8ffff;width:10%;'>勤務条件<br>（△の場合）</td>
                    <td align="left">
                        <?php echo $this->Form->input('conditions',array('type'=>'textarea','label'=>false,'div'=>false,'row'=>3,'style'=>'')); ?>
                        ※入力例）土日どちらかのみ可能...など
                    </td>
                </tr>
            </table>
            <div style='float:left;'>
                <input type="submit" value="申　請" data-theme="e" data-icon="check" data-inline="true">
                <input type="button" value="戻　る" data-inline="true" onclick='location.href="<?=ROOTDIR ?>/users/schedule#page2";'>
            </div>  
                <?php echo $this->Form->end(); ?>
    </div>
    <div class="pagetop">
            <a href="#page3">
                <?php echo $this->Html->image('pagetop.png'); ?>
            </a>
    </div>			
    <div id="footer">
        <?=FOOTER ?>
    </div>
</div>
<!--タイムカード入力ページ END-->