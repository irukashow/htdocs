<?php
    echo $this->Html->script('nicEdit');
    //echo $this->Html->image('nicEditorIcons');
    echo $this->Html->css('message');
?>
<script type="text/javascript">
	//bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<!-- 見出し -->
<div id='headline'>
    ★ メッセージの内容
</div>

<div style="border:1px solid #cccc99;background-color: #ffffea ;padding: 5px 5px 5px 5px;border-radius:5px;">
<?php echo $this->Form->create('Message', array('name' => 'form')); ?>
    <table id="" border="0" width="99.5%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;">
        <tr style="background-color: #459ed2; color: white; font-weight: bold; font-size: 120%;">
            <td>
                <img src='<?=ROOTDIR ?>/img/msg.gif' style='vertical-align: -4px;'>
                <?php echo $data['MessageMember']['title']; ?>
            </td>  
        </tr>
        <tr style="background-color: #ffffea;">
            <td>
                差出人： <font style="font-size: 110%;"><?=$data['MessageMember']['name'] ?></font>
            </td>
        </tr>
        <tr style="background-color: #ffffea;">
            <td>
                宛先： <?php echo $data['MessageMember']['class']; ?>
                <?php echo $data['MessageMember']['staff_id']; ?>
            </td>
        </tr>
        <tr style="background-color: #ffffff; ">
            <td align="left" style="">
            </td>
        </tr>
        <tr style="background-color: #ffffff;">
            <td align="left">
                <?php echo str_replace("\n","<br />",$data['MessageMember']['body']); ?>
            </td>
        </tr>
        <tr style="background-color: #ffffff;">
            <td align="left">
                
            </td>
        </tr>
        <tr style="background-color: #ffffff;">
            <td>添付ファイル</td>
        </tr>
    </table>
<?php echo $this->Form->end(); ?>
</div>
<br>
<?php echo $this->Html->link('◀メッセージボックスに戻る', 'index', array('style'=>'text-decoration: none;')) ?>