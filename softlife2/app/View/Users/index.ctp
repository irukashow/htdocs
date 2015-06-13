<?php
    echo $this->Html->css('message');
?>
<!-- 見出し -->
<div id='headline'>
    ★ ホーム
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="" target=""></a>
    <a href="" target=""></a>
    <a href="" target=""></a>
</div>

<!-- メインペイン -->
<div id='message-main'>
    <table border="0" style="width:100%;">
        <tr>
            <td style="width:30%;">
                <!-- メッセージボックス -->
                <div id='message-folder'>
                        <font style="font-size:110%;font-weight: bold;color:#006699;">ようこそ！ <?=$user_name ?>さん</font><br>
                        <div style="height: 5px;"></div>
                        <?php echo $this->Html->link('パスワード変更', '/users/passwd/'); ?>
                        <br>
                        <?php echo $this->Html->link('ログアウト', 'logout', array('title'=>'確認'), 'ログアウトしてもよろしいですか？'); ?>
                </div>
            </td>
            <td style="width:70%;">
                <!-- メッセージ一覧 -->
                <div id='message-list'>
                    <font style='font-weight: bold;font-size: 110%;'>[新着メッセージ]</font><br>
        <?php echo $this->paginator->numbers (
            array (
                'before' => $this->paginator->hasPrev() ? $this->paginator->first('<<').' | ' : '',
                'after' => $this->paginator->hasNext() ? ' | '.$this->paginator->last('>>') : '',
            )
        );
        ?>
        <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void">
            <tr style='background-color: #459ed2;'>
                <th style='width:5%;'>&nbsp;</th>
                <th style='width:50%;'>標題</th>
                <th style='width:20%;'>差出人</th>
                <th style='width:25%;'>作成日時</th>
            </tr>
            <?php foreach ($datas as $data) { ?>
        <?php if ($data['MessageMember']['kidoku_flag'] == 0) { ?>
            <tr style='background-color: #fff6d7; border:1px solid orange; font-weight: bold;'>
                <td style="padding-top: 8px;">
                    <?php echo $this->Form->input('check',array('type'=>'checkbox','label'=>false)); ?>
                </td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['MessageMember']['title'], 'detail/'.$data['MessageMember']['id'], array('style'=>'color: blue;')) ?>
                </td>
                <td class='message-content'>
                    <?php echo $this->Html->link($data['MessageMember']['name'], 'detail/'.$data['MessageMember']['id'], array('style'=>'')) ?>
                </td>
                <td class='message-content'><?=$data['MessageMember']['modified']; ?></td>
            </tr>
            <?php } ?> 
            <?php } ?>
        </table>
        <?php echo $this->paginator->numbers (
            array (
                'before' => $this->paginator->hasPrev() ? $this->paginator->first('<<').' | ' : '',
                'after' => $this->paginator->hasNext() ? ' | '.$this->paginator->last('>>') : '',
            )
        );
        ?>
        <?php echo $this->Form->end(); ?>
                </div>
                </td>
        </tr>
    </table>
</div>

