<?php
    echo $this->Html->css( 'tools');
    echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
?>
<script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

<div style="width:80%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('スタッフ登録 （基本情報）'); ?></legend>
<?php echo $this->Form->create('StuffMaster'); ?>
        
        <!-- スタッフ情報 -->
        <table style="width:100%;margin-top: 10px;border:solid;">
            <tr>
                <th colspan="2">スタッフ情報</th>
            </tr>
            <tr>
                <td colspan="2">
                    No.<?='0001' ?>&nbsp;&nbsp;登録番号：<?='0001' ?>&nbsp;&nbsp;
                    作成日：<?='2015-06-01' ?>&nbsp;&nbsp;更新日：<?='2015-06-01' ?>&nbsp;&nbsp;所属：<?='大阪-人材派遣' ?>
                </td>
            </tr>
        </table>
        <!-- 個人情報付則 -->
        <table style="width:100%;margin-top: 10px;border:solid;">
            <tr>
                <th colspan="4">個人情報付則</th>
            </tr>
            <tr>
                <td>証明写真</td>
                <td>
                    <!-- 履歴書ドラッグ＆ドロップ -->
                    <div class="dropdown" style='border:dotted;border-color:blue;width: 250px;height: 100px;'>
                        Drop files here or click to upload.
                    </div>
                </td>
                <td>履歴書</td>
                <td>
                    <!-- 履歴書ドラッグ＆ドロップ -->
                    <div class="dropdown" style='border:dotted;border-color:blue;width: 250px;height: 100px;'>
                        Drop files here or click to upload.
                    </div>
                </td>
            </tr>
            <tr>
                <td>身長</td>
                <td>cm</td>
                <td>制服サイズ</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        
        <!-- 勤務について -->
        <table style="width:100%;margin-top: 10px;">
            <tr>
                <th colspan="4">勤務について</th>
            </tr>
        </table>
         
        <!-- 経理関係 -->
        <table style="width:100%;margin-top: 10px;">
            <tr>
                <th colspan="4">経理関係</th>
            </tr>
        </table>
         
        <!-- その他 -->
        <table style="width:100%;margin-top: 10px;">
            <tr>
                <th colspan="4">その他</th>
            </tr>
        </table>


    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('次へ進む', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('キャンセル', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>