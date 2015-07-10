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
<?php echo $this->Form->create('CaseManagement'); ?>
<table id='profile' border="0" style="margin:10px;width:98%;">
    <tr>
        <td style="width:50%;vertical-align: top;">
            <div id="header_profile" style="margin-bottom: 10px;">
                <font style="font-size: 150%;">●&nbsp;案件情報</font>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <font style="font-size: 100%;margin-top: -5px;">登録日：
<?php
    if (is_null($data['CaseManagement']['created'])) {
        echo '＜不明＞';
    } else {
        echo date('Y-m-d', strtotime($data['CaseManagement']['created'])); 
    }
?>
                </font>
                &nbsp;&nbsp;
                <font style="font-size: 100%;">更新日：
<?php
    if (is_null($data['CaseManagement']['modified'])) {
        echo '＜不明＞';
    } else {
        echo date('Y-m-d', strtotime($data['CaseManagement']['modified'])); 
    }
?>
                </font>
            </div>
                    
            <!-- 左項目 -->
            <font style="font-size: 120%;">■基本情報</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;border-spacing: 0px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;' colspan="2">案件名称</td>
                    <td style='width:70%;'><?=$data['CaseManagement']['case_name'] ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;' colspan="2">担当者（所属 氏名）</td>
                    <td style='width:70%;'><?=$contact ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;' colspan="2">契約形態</td>
                    <td style='width:70%;'>
                        <?php
                            if ($data['CaseManagement']['contract_type'] == 1) {
                                echo '派遣契約';
                            } elseif ($data['CaseManagement']['contract_type'] == 2) {
                                echo '請負契約';
                            } else {
                                echo '';
                            }
                        ?>
                    </td>
                </tr>
                <!-- 依頼主 -->
                <tr>
                    <td style='background-color: #e8ffff;width:10%;' rowspan="5">依頼主</td>
                    <td style='background-color: #e8ffff;width:20%;'>企業名<br>部署・担当者</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_client)) {
                            echo $data_client['Customer']['corp_name'].'<br>';
                            echo $data_client['Customer']['busho'].'　'.$data_client['Customer']['tantou'];
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>郵便番号<br>住所</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_client)) {
                            echo '〒'.$data_client['Customer']['zipcode1'].'-'.$data_client['Customer']['zipcode2'].'<br>';
                            echo $data_client['Customer']['address1_2'].$data_client['Customer']['address2'].$data_client['Customer']['address3']
                                    .$data_client['Customer']['address4'].' '.$data_client['Customer']['address5'];
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>TEL</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_client)) {
                            echo $data_client['Customer']['telno'];
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>FAX</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_client)) {
                            echo $data_client['Customer']['faxno'];
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>ﾒｰﾙｱﾄﾞﾚｽ</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_client)) {
                            echo $data_client['Customer']['email'];
                        }
                    ?>
                    </td>
                </tr>
                <!-- 依頼主 END -->
                <tr>
                    <td style='background-color: #e8ffff;width:20%;' colspan="2">事業主</td>
                    <td style='width:70%;'>
                            <?php echo $entrepreneur; ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;' colspan="2">開始日</td>
                    <td style='width:70%;'><?=$data['CaseManagement']['start_date'] ?></td>
                </tr>
                <!-- 就業場所 -->
                <tr>
                    <td style='background-color: #e8ffff;width:10%;' rowspan="8">就業場所</td>
                    <td style='background-color: #e8ffff;width:20%;'>名称</td>
                    <td style='width:70%;'><?=nl2br($data['CaseManagement']['work_place']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>部署</td>
                    <td style='width:70%;'><?=$data['CaseManagement']['busho'] ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>住所</td>
                    <td style='width:70%;'>
                        〒<?=$data['CaseManagement']['zipcode1'] ?>-<?=$data['CaseManagement']['zipcode2'] ?><br>
                            <?=$data['CaseManagement']['address'] ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>TEL</td>
                    <td style='width:70%;'><?=$data['CaseManagement']['telno'] ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>FAX</td>
                    <td style='width:70%;'><?=$data['CaseManagement']['faxno'] ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>指揮命令者・役職</td>
                    <td style='width:70%;'>
                            <?=$data['CaseManagement']['director'] ?>　<?=$data['CaseManagement']['position'] ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>最寄駅</td>
                    <td style='width:70%;'>
                        <?=getStation($data['CaseManagement']['s1_1']) ?><br>
                        <?=getStation($data['CaseManagement']['s1_2']) ?><br>
                        <?=getStation($data['CaseManagement']['s1_3']) ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>現場長<br>携帯<br>ﾒｰﾙｱﾄﾞﾚｽ</td>
                    <td style='width:70%;'>
                            <?=$data['CaseManagement']['leader'] ?><br>
                            <?=$data['CaseManagement']['mobile'] ?>　<?=$data['CaseManagement']['email'] ?>
                    </td>
                </tr>
                <!-- 就業場所 END -->
                <!-- 請求先① -->
                <tr>
                    <td style='background-color: #e8ffff;width:10%;' rowspan="6">請求先①</td>
                    <td style='background-color: #e8ffff;width:20%;'>企業名<br>部署・担当者</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_billing)) {
                            echo $data_billing['Customer']['corp_name'].'<br>';
                            echo $data_billing['Customer']['busho'].' '.$data_billing['Customer']['tantou'];
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>郵便番号<br>住所</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_billing)) {
                            echo '〒'.$data_billing['Customer']['zipcode1'].'-'.$data_billing['Customer']['zipcode2'].'<br>';
                            echo $data_billing['Customer']['address1_2'].$data_billing['Customer']['address2'].$data_billing['Customer']['address3']
                                    .$data_billing['Customer']['address4'].' '.$data_billing['Customer']['address5'];
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>TEL</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_billing)) {
                            echo $data_billing['Customer']['telno'];
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>FAX</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_billing)) {
                            echo $data_billing['Customer']['faxno'];
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>ﾒｰﾙｱﾄﾞﾚｽ</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_billing)) {
                            echo $data_billing['Customer']['email'];
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:20%;'>振込口座情報</td>
                    <td style='width:70%;'>
                    <?php
                        if (!empty($data_billing)) {
                            echo $data_billing['Customer']['kouza_bank'].'　'.$data_billing['Customer']['kouza_shiten'].'<br>';
                            echo '締日：'.$data_billing['Customer']['bill_cutoff'].'　'.'請求書到着日：'.$data_billing['Customer']['bill_arrival'].'<br>';
                            echo '備考：'.$data_billing['Customer']['remarks'];
                        }
                    ?>
                    </td>
                </tr>
                <!-- 請求先① END -->
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
                <?php echo $this->Form->input('case_id', array('type'=>'hidden', 'value' => $data['CaseManagement']['id'])); ?>
                <?php echo $this->Form->input('kaijo_flag', array('type'=>'hidden', 'value' => $flag)); ?> 
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
                    <td align="center" style='background-color: #e8ffff;'>履歴</td>
                </tr>
                <tr>
                    <td align="center">表示するデータはありません。</td>
                </tr>
            </table>
 
            <!-- シフト表 -->
            <font id="title_messagebox" style="font-size: 120%;">■シフト表</font>
            <br>
            <!-- 売上・給与 -->
            <font id="title_messagebox" style="font-size: 120%;">■売上・給与</font>
        </td>
    </tr>
</table>

<?php } ?>
<?php echo $this->Form->end(); ?> 


