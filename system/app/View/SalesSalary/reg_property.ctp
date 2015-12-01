<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;margin-top: 10px;">
    ★ 物件情報リスト（登録）
</div>
<!-- 見出し１ END -->    
<?php echo $this->Form->create('PropertyList', array('name' => 'form')); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $id)); ?>   
<?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $selected_class)); ?>  
<?php echo $this->Form->input('created', array('type'=>'hidden')); ?>
<?php echo $this->Form->input('modified', array('type'=>'hidden')); ?>

        <!-- 本体 -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th colspan="2" style='background:#99ccff;text-align: center;'>物件情報</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>現場①</td>
                <td><?php echo $this->Form->input('scene1',array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:90%;')); ?></td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>現場②</td>
                <td><?php echo $this->Form->input('scene2',array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:90%;')); ?></td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>勤務時間</td>
                <td>
                    <?php echo $this->Form->input('work_time_from',array('type'=>'text','div'=>false,'maxlength'=>'10','label'=>false,'style'=>'width:50px;')); ?>
                    ～
                    <?php echo $this->Form->input('work_time_to',array('type'=>'text','div'=>false,'maxlength'=>'10','label'=>false,'style'=>'width:50px;')); ?>
                    <span>※入力例）9:30（すべて半角で入力）</span>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>売上金額</td>
                <td>
                    <?php echo $this->Form->input('sales',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:100px;')); ?>
                    <span>※入力例）9:30（すべて半角、カンマ（,）なし）</span>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>給与金額</td>
                <td>
                    <?php echo $this->Form->input('salary',array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:100px;')); ?>
                    <span>※入力例）9:30（すべて半角、カンマ（,）なし）</span>
                </td>
            </tr>
        </table>
    </fieldset>
    <div style='margin-left: 10px;margin-top: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('戻　る', 'property_info', array('id'=>'button-delete'))); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('閉 じ る', 'javascript:void(0);', array('id'=>'button-delete', 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
