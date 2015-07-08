<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('station');
    echo $this->Html->script('lightbox');
    echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
    echo $this->Html->css('staffmaster');
    echo $this->Html->css('lightbox');
    echo $this->Html->css(array('print'),'stylesheet',array('media' => 'print'));
?>
<?php require('profile_element.ctp'); ?>
<style>
#loading{
    position:absolute;
    left:50%;
    top:40%;
    margin-left:-30px;
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script type="text/javascript">
  <!--
//コンテンツの非表示
$(function(){
    $('#profile').css('display', 'none');
});
//ページの読み込み完了後に実行
window.onload = function(){
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        $("#profile").fadeIn();
    });
}
  //-->
</script>
<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<?php foreach ($datas as $data){ ?>
<?php echo $this->Form->create('StaffMaster'); ?>
<table id='profile' border="0" style="margin:10px;width:98%;">
    <tr>
        <td style="width:50%;vertical-align: top;">
            <div id="header_profile" style="margin-bottom: 10px;">
                <font style="font-size: 150%;">■&nbsp;案件情報</font>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <font style="font-size: 100%;margin-top: -5px;">登録日：
<?php
    if (is_null($data['StaffMaster']['created'])) {
        echo '＜不明＞';
    } else {
        echo date('Y-m-d', strtotime($data['StaffMaster']['created'])); 
    }
?>
                </font>
                &nbsp;&nbsp;
                <font style="font-size: 100%;">更新日：
<?php
    if (is_null($data['StaffMaster']['modified'])) {
        echo '＜不明＞';
    } else {
        echo date('Y-m-d', strtotime($data['StaffMaster']['modified'])); 
    }
?>
                </font>
            </div>
                    
            <!-- 左項目 -->
            <font style="font-size: 120%;">●基本情報</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;border-spacing: 0px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>案件名称</td>
                    <td style='width:70%;'><?=$data['StaffMaster']['job_startdate_kibou'] ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>担当者（所属 氏名）</td>
                    <td style='width:70%;'><?=$data['StaffMaster']['training_date_kibou'] ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>契約形態</td>
                    <td style='width:70%;'><?=$data['StaffMaster']['training_date_kibou'] ?></td>
                </tr>
                
            </table>
        </td>
        <td style="width:50%;vertical-align: top;padding-left: 5px;">
            <div id="editbox" style="color: black;background-color: #ffff99;border:1px solid orange;padding:5px;vertical-align: middle;padding-left: 10px;margin-bottom: 10px;">
                <?php echo $this->Form->submit('編　集', array('name' => 'submit','div' => false)); ?>
                &nbsp;&nbsp;
                <?php $comment = __('本当に登録解除してよろしいですか？', true); ?>
                <?php echo $this->Form->submit('登録解除', array('name' => 'release', 'id' => 'button-release', 'div' => false, 'onclick' => 'return confirm("'.$comment.'");')); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('閉じる', 'javascript:void(0);', array('id'=>'button-delete', 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('印刷する', 'javascript:void(0);', array('id'=>'print', 'onclick' => "window.print();"))); ?>
                &nbsp;&nbsp;
                <?php echo $this->Paginator->prev('◀前へ', array(), null, array('class' => 'prev disabled')); ?>
                &nbsp;&nbsp;
                <?php echo $this->Paginator->next('次へ▶', array(), null, array('class' => 'next disabled')); ?>
                <?php echo $this->Form->input('staff_id', array('type'=>'hidden', 'value' => $data['StaffMaster']['id'])); ?>
                <?php echo $this->Form->input('staff_name', array('type'=>'hidden', 'value' => $data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei'])); ?>
                <?php echo $this->Form->input('kaijo_flag', array('type'=>'hidden', 'value' => 1)); ?> 
            </div>

            <!-- メールボックス -->
            <font id="title_messagebox" style="font-size: 120%;">■メッセージボックス</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;" id="messagebox">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td style='background-color: #e8ffff;width:70%;'>タイトル</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">表示するデータはありません。</td>
                </tr>
            </table>

            <!-- オーダー表 -->
            <font style="font-size: 120%;">■オーダー表</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td style='background-color: #e8ffff;width:70%;'>案件名</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">表示するデータはありません。</td>
                </tr>
            </table>
            
            <!-- 契約書 -->
            <font style="font-size: 120%;">■契約書</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td style='background-color: #e8ffff;width:70%;'>案件名</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">表示するデータはありません。</td>
                </tr>
            </table>
                  
        </td>
    </tr>
</table>

<?php } ?>
<?php echo $this->Form->end(); ?> 


