<!--タイムカード入力ページ-->
<div id="work_input" data-role="page" data-url="<?=ROOTDIR ?>/users/work_input?date=<?=$date1 ?>">
    <div data-role="header" data-theme="c">
            <h1>タイムカード入力</h1>
            <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
    </div>			
    <div data-role="content" style="font-size: 100%;">
            <?php echo $this->Form->create('TimeCard', array('name' => 'form', 'url' => array('controller' => 'users', 'action' => 'work_input'))); ?>
        <?php echo $this->Form->input('id', array('type'=>'hidden')); ?>
        <?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $class)); ?>
            <?php echo $this->Form->input('staff_id', array('type'=>'hidden', 'value' => $id)); ?>
            <?php echo $this->Form->input('request_flag', array('type'=>'hidden', 'value' => 1)); ?>
        <?php echo $this->Form->input('status', array('type'=>'hidden', 'value' => 1)); ?>
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <tr>
                    <td align="center" style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td align="center">
                        <?php echo $this->Form->input('work_date', array('type'=>'hidden', 'value' => $date1)); ?>  
                        <?=$date2 ?>
                    </td>
                </tr>
                <tr>
                    <td align="center" style='background-color: #e8ffff;width:20%;'>案件</td>
                    <td align="center">
                        <?php
                            $day = date('j', strtotime($date1));
                            $case_ids = explode(',', $data2['WkSchedule']['c'.$day]);
                            $case_id = $case_ids[0];
                            $this->log($case_ids, LOG_DEBUG);
                        ?>
                        <?=$list_case2[$case_id] ?>
                    </td>
                </tr>
                <tr>
                    <td align="center" style='background-color: #e8ffff;width:20%;'>始業時刻</td>
                    <?php $list_h = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23'); ?>
                    <?php $list_m = array('00'=>'00','15'=>'15','30'=>'30','45'=>'45'); ?>
                    <td align="center">
                        <div class="yoko">
                        <?php echo $this->Form->input('start_time_h',array('type'=>'select','label'=>false,'div'=>false,'style'=>'', 'options'=>$list_h)); ?>
                        <?php echo $this->Form->input('start_time_m',array('type'=>'select','label'=>false,'div'=>false,'style'=>'', 'options'=>$list_m)); ?>
                            から
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" style='background-color: #e8ffff;width:20%;'>終業時刻</td>
                    <td align="center">
                        <div class="yoko">
                        <?php echo $this->Form->input('end_time_h',array('type'=>'select','label'=>false,'div'=>false,'style'=>'', 'options'=>$list_h)); ?>
                        <?php echo $this->Form->input('end_time_m',array('type'=>'select','label'=>false,'div'=>false,'style'=>'', 'options'=>$list_m)); ?>
                            まで
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" style='background-color: #e8ffff;width:20%;'>休憩<br>時間</td>
                    <td align="center">
                        <div class="yoko">
                        <?php echo $this->Form->input('rest_time_from_h',array('type'=>'select','label'=>false,'div'=>false,'style'=>'', 'options'=>$list_h)); ?>
                        <?php echo $this->Form->input('rest_time_from_m',array('type'=>'select','label'=>false,'div'=>false,'style'=>'', 'options'=>$list_m)); ?>
                            から
                        </div>
                        <div class="yoko">
                        <?php echo $this->Form->input('rest_time_to_h',array('type'=>'select','label'=>false,'div'=>false,'style'=>'', 'options'=>$list_h)); ?>
                        <?php echo $this->Form->input('rest_time_to_m',array('type'=>'select','label'=>false,'div'=>false,'style'=>'', 'options'=>$list_m)); ?>
                            まで
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" style='background-color: #e8ffff;width:20%;'>備考</td>
                    <td align="center">
                        <?php echo $this->Form->input('remarks',array('type'=>'textarea','label'=>false,'div'=>false,'row'=>3,'style'=>'')); ?>
                    </td>
                </tr>
            </table>
            <div style='float:left;'>
                <input name="request" type="submit" value="申　請" data-theme="e" data-icon="check" data-inline="true">
                <input name="delete" type="submit" value="申請削除" data-theme="a" data-icon="delete" data-inline="true">
                <?php
                    $date3 = date('Y-m', strtotime($date1));
                ?>
                <input type="button" value="戻　る" data-inline="true" onclick='location.href="<?=ROOTDIR ?>/users/work_timecard?date=<?=$date3 ?>"'>
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