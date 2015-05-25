<!-- 見出し -->
<div id='headline'>
    ★ バージョン情報入力ページ
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="" target="_blank"></a>
    <a href="" target="_blank"></a>
    <a href="" target="_blank"></a>
</div>

<div style="width:60%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 20px;">

<?php echo $this->Form->create('VersionRemarks'); ?>

        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
            <tr>
                <th style='background:#99ccff;text-align: center;'>項目</th>
                <th style='background:#99ccff;text-align: center;'>入力内容</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>バージョン</td>
                <td>
                    <?php echo $this->Form->input('verson_no',array('label'=>false,'div'=>false,'maxlength'=>'20','style'=>'width:20%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>種別</td>
                <td>
                    <?php  
                        $select1=array(''=>'','1'=>'緊急','2'=>'通常更新','3'=>'マイナー更新');
                        echo $this->Form->input( 'status', array( 'label'=>false,'type' => 'select', 'div'=>false,'legend'=>false,'style' => 'float:none;', 'options' => $select1));
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>更新タイトル</td>
                <td>
                    <?php echo $this->Form->input('title',array('label'=>false,'div'=>false,'style'=>'width:70%;')); ?>
                </td>
            </tr> 
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>バージョン更新内容<br />（詳細）</td>
                <td>
                    <?php echo $this->Form->input('remarks',array('type' => 'textarea','label'=>false,'div'=>false,'style'=>'width:90%;', 'rows' => '10')); ?>
                </td>
            </tr> 
        </table>


    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('キャンセル', './index', array('class'=>'button-rink'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>
