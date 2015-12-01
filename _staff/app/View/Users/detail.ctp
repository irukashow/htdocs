<?php
    echo $this->Html->script('nicEdit');
    //echo $this->Html->image('nicEditorIcons');
    echo $this->Html->css('message');
?>
<?php
    // 日付から曜日を日本語で割り出す関数
    function tag_weekday_japanese_convert( $date ){
        $weekday = array( '日', '月', '火', '水', '木', '金', '土' );
        return $weekday[date('w', strtotime( $date ) )];
    }
?>
<script type="text/javascript">
	//bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
<!-- 見出し -->
<div id='headline'>
    ★ 管理者からのメッセージ
</div>

<div style="border:1px solid #cccc99;background-color: #ffffea ;padding: 5px 5px 5px 5px;border-radius:5px;">
<?php echo $this->Form->create('AdminInfo', array('name' => 'form')); ?>
    <table id="" border="0" width="99.5%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 90%;">
        <tr style="background-color: #459ed2; color: white; font-weight: bold; font-size: 120%;">
            <td>
                <img src='<?=ROOTDIR ?>/img/msg.gif' style='vertical-align: -4px;'>
                <?php echo $data['AdminInfo']['title']; ?>
            </td>  
        </tr>
        <tr style="background-color: #ffffea;">
            <td>
                送信日時： 
                <?= date('Y-m-d', strtotime($data['AdminInfo']['created'])) ?>
                (<?= tag_weekday_japanese_convert(strtotime($data['AdminInfo']['created'])) ?>)
                <?= date('H:i', strtotime($data['AdminInfo']['created'])) ?>
            </td>
        </tr>
        <tr style="background-color: #ffffff; ">
            <td align="left" style="">
            </td>
        </tr>
        <tr style="background-color: #ffffff;">
            <td align="left">
                <?php echo str_replace("\n","<br />",$data['AdminInfo']['remarks']); ?>
            </td>
        </tr>
        <tr style="background-color: #ffffff;">
            <td align="left">
                
            </td>
        </tr>
        <tr style="background-color: #ffffea;">
            <td>
<?php 
    if (!empty($data['AdminInfo']['attachment'])) {
        $files = explode(',', $data['AdminInfo']['attachment']);
        echo '<HR>';
        echo '<font color=green style="font-weight: bold;">添付ファイル</font>：（右クリックして保存してください）<br>';
        foreach ($files as $file) {
            if (!empty($file)) {
                echo '<a href="'.ROOTDIR.'/files/message/admin/'.sprintf("%010d", $data['AdminInfo']['id']).'/'.$file.'" target="_blank">'.$file.'</a><br>';
            }
        }
    } 
?>
            </td>
        </tr>
    </table>
<?php echo $this->Form->end(); ?>
</div>
<br>
<?php echo $this->Html->link('◀ホームに戻る', 'index', array('style'=>'text-decoration: none;')) ?>