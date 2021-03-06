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
<?php
    // 職種のセット
    function getShokushu($value, $list_shokushu) {
        $ret = "";
        //$list_shokushu = Configure::read("shokushu");
        
        if (!empty($value) && $value != 0) {
            $ret = $list_shokushu[$value];  
        }

        return $ret;
    }
    function getShokushu2($array, $list_shokushu) {
        $ret = "";
        $_array = explode(',', $array);
        foreach ($_array as $key => $value) {
            if (empty($ret)) {
                $ret = getShokushu($value, $list_shokushu);
            } else {
                $ret = $ret.'<br>'.getShokushu($value, $list_shokushu);
            }  
        }
        return $ret;
    }
?>
<style>
#loading{
    position:absolute;
    left:50%;
    top:40%;
    margin-left:-30px;
}
#complete-delete {
    width: 100%;
    margin-top: 5px;
    padding: 5px;
    font-size: 150%;
    font-weight: bold;
    font-family: メイリオ;
    color:#ffffcc;
    background-color: #e0e7e7;
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
    // 画面を閉じる
    function doClose() {
        if (window.opener) {
            window.opener.location.reload();window.close();
        } else {
            window.close();
        }
    }
</script>
<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>

<?php
    if (!empty($msg)) {
        echo '<br>'.$msg.'<br>';
        echo '<button onclick="window.opener.location.reload();window.close();">閉じる</button>';
    }
?>
<?php foreach ($datas as $data){ ?>
<table id='profile' border="0" style="margin:10px;width:98%;">
    <tr>
        <td style="width:50%;vertical-align: top;">
            <div id="header_profile" style="">
                <font style="font-size: 150%;">■登録者情報</font>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <font style="font-size: 100%;">登録年月日：
<?php
    if (is_null($data['StaffMaster']['created'])) {
        echo '＜不明＞';
    } else {
        echo date('Y-m-d', strtotime($data['StaffMaster']['created'])); 
    }
?>
                &nbsp;&nbsp;登録番号：<?=$data['StaffMaster']['id'] ?></font>
            </div>
            
                    <!-- プロフィール -->
                    <table border='2' cellspacing="5" cellpadding="7" style="width:100%;margin-top: 2px;border-spacing: 0px;border:2px double #999;">
                        <tr>
                            <td style='width:50%;background-color: #ffffcc;'>
                                <?=$data['StaffMaster']['name_sei2'] ?>&nbsp;<?=$data['StaffMaster']['name_mei2'] ?><br>
                                <div id="name" style="float:left;">
                                    <font style='font-size: 150%;'>
                                        <?=$data['StaffMaster']['name_sei'] ?>&nbsp;<?=$data['StaffMaster']['name_mei'] ?>&nbsp;
                                        <?=  getAge(str_replace('-','',$data['StaffMaster']['birthday'])) ?>歳&nbsp;&nbsp;
                                    </font>
                                </div>
                                <div style="vertical-align: 0px;float: left;"><?=getGender($data['StaffMaster']['gender']) ?></div>
                                <div style="clear:both;"></div>
                            </td>
                            <td style='width:50%;text-align: center;' rowspan="4">
                    <?php
                        $after = $data['StaffMaster']['pic_extension'];
                        if (empty($after)) {
                    ?>
                                <img src='<?=ROOTDIR ?>/img/noimage.jpg' style='border:1px black solid; width:150px;'>
                    <?php } else { ?>
                                <a href="<?=ROOTDIR ?>/files/staff_reg/<?=$class ?>/<?=sprintf('%07d', $data['StaffMaster']['id']) ?>/<?=$data['StaffMaster']['id'] ?>.<?=$data['StaffMaster']['pic_extension'] ?>" rel="lightbox">
                                    <img src='<?=ROOTDIR ?>/files/staff_reg/<?=$class ?>/<?=sprintf('%07d', $data['StaffMaster']['id']) ?>/<?=$data['StaffMaster']['id'] ?>.<?=$data['StaffMaster']['pic_extension'] ?>' style='border:1px black solid; width:150px;'>
                                </a>
                    <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td style=''>雇用形態：&nbsp;<?= getStatus($data['StaffMaster']['employment_status']) ?></td>
                        </tr>
                        <tr>
                            <td style=''>勤務回数：&nbsp;<?='＜不明＞' ?>回</td>
                        </tr>
                        <tr>
                            <td style='background-color:#ffcc66;'>就業状況：&nbsp;<?='＜不明＞' ?></td>
                        </tr>
                        <tr>
                            <td id='shokushu_shoukai' valign="top">
                                <font style='font-size:130%;'><?=getShokushu2($data['StaffMaster']['shokushu_shoukai'], $list_shokushu) ?></font><br>
                            </td>
                            <td valign="top">
                    <!-- 保存した履歴書ファイルのリンク -->
                    <?php
                        $after2 = $data['StaffMaster']['pic_extension2'];
                        if (!is_null($after2) && !empty($after2)) {
                            echo '<a href="javascript:void(0);" onclick=window.open("'.ROOTDIR.'/files/staff_reg/'.$class.'/'.sprintf('%07d', $data['StaffMaster']['id']).'/'.$data['StaffMaster']['id'].'.'.$after2.'","履歴書","width=800,height=800,scrollbars=yes"); style="color:red;">★履歴書などの書類★</a>';
                        }
                    ?>
                    <!-- その他保存ファイルのリンク -->
                    <?php
                        $files = $data['StaffMaster']['para2'];
                        $files_2 = $data['StaffMaster']['para3'];
                        if (!is_null($files) && !empty($files)) {
                            $file_array = explode(',', $files);
                            $file_array_2 = explode(',', $files_2);
                            foreach($file_array as $key => $file) {
                                echo '<br>';
                                echo '<a href="javascript:void(0);" '
                                . 'onclick="window.open(\''.ROOTDIR.'/files/staff_reg/'.$class.'/'.sprintf('%07d', $data['StaffMaster']['id']).'/'.($file).'\',\'その他ファイル\',\'width=800,height=800,scrollbars=yes\');" '
                                        . 'style="color:red;"><font style="font-size:80%;">●'.($file_array_2[$key]).'</font></a>';
                            }
                        }
                    ?>
                            </td>
                        </tr>
                    </table>
                    
                    <!-- 待ち合わせ -->
                    <?php echo $this->Form->create('WorkTable'); ?>
                    <?php
                        $day = 1;
                        $flag_shift = 0;
                        if ($flag_shift == 0) {
                            $display = 'none';
                        } else {
                            $display = 'normal';
                        }
                    ?>
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;display:<?=$display?>;">
                        <tr>
                            <td style='background-color: #FFC7AF;font-weight: bold;' colspan="3" align="center">
                                待ち合わせ (12月5日土曜日)
                                <?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>
                                <?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $class)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style='width:20%;'>
                                <input type="checkbox" name="data[StaffMaster][appointment]" value="1" style="margin-left: 0px;vertical-align: -5px;">
                                <font style="margin-left:0px;">待ち合わせ</font>
                            </td>
                            <td style='width:70%;'>
                            <?php
                                if (empty($data_ap['WorkTable']['ap'.$day])) {
                                    $memo = '';
                                } elseif ($data_ap['WorkTable']['ap'.$day] == 1) {
                                    $memo = '';
                                } else {
                                    $memo = $data_ap['WorkTable']['ap'.$day];
                                }
                                echo $this->Form->input('appointment_memo',
                                    array('label'=>false,'div'=>false,'maxlength'=>'30', 'placeholder'=>'待ち合わせメモ', 
                                        'style'=>'width:95%;padding:3px;', 'value'=>$memo)); 
                            ?> 
                            </td>
                            <td align="center" style='width:10%;'>
                                <?php echo $this->Form->submit('登録', array('id'=>'button-create', 
                                    'name' => 'register[]', 'div' => false, 'style'=>'font-size:100%;padding:4px 15px;')); ?>
                            </td>
                        </tr>
                    </table>
                    <?php echo $this->Form->end(); ?>
                    
                    <?php echo $this->Form->create('StaffMaster'); ?>
                    <?php if ($flag == 1) { ?>
                    <?php $comment1 = '完全削除するとデータが完全に消去されます。\n本当に実行しますか？'; ?>
                    <input type="submit" id="complete-delete" name="complete_delete[<?=$data['StaffMaster']['id'] ?>]" value="★★★ 完 全 削 除 ★★★" onclick="return confirm('<?=$comment1 ?>');">
                    <?php } ?>

                    <!-- 左項目１ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>勤務開始希望日</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['job_startdate_kibou'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>研修希望日</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['training_date_kibou'] ?></td>
                        </tr>
                    </table>
                    
                    <!-- 左項目２ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>電話番号１</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['telno1'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>電話番号２</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['telno2'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>メールアドレス１</td>
                            <td style='width:70%;'>
                                <?=$data['StaffMaster']['email1'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>メールアドレス２</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['email2'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>ログインアカウント</td>
                            <td style='width:70%;'>
                    <?php
                        if (is_null($data['StaffMaster']['account'])) {
                            echo '未設定';
                            //echo '<br>';
                            //echo '→'.$this->Html->link('ログインアカウント登録', 'password/'.$data['StaffMaster']['id']);
                        } else {
                            echo $data['StaffMaster']['account'];
                            //echo '<br>';
                            //echo '→'.$this->Html->link('ログインアカウント変更', 'password/'.$data['StaffMaster']['id']);
                            echo '<br>';
                            echo '→'.$this->Html->link('ログインパスワード変更', 'password2/'.$data['StaffMaster']['id']);
                        }
                    ?>
                            </td>
                        </tr>
                    </table>
                    
                    <!-- 左項目３ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>勤務開始希望日</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['job_startdate_kibou'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>研修希望日</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['training_date_kibou'] ?></td>
                        </tr>
                    </table>

                    <!-- 左項目５ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>郵便番号</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['zipcode1'] ?>-<?=$data['StaffMaster']['zipcode2'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>都道府県</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['address1_2'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>市区町村</td>
                            <td style='width:70%;'>
                                    <?=$data['StaffMaster']['address2'] ?><?=$data['StaffMaster']['address3'] ?><?=$data['StaffMaster']['address4'] ?>&nbsp;&nbsp;<?=$data['StaffMaster']['address5'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>生年月日（初期ﾊﾟｽ）</td>
                            <td style='width:70%;'>
                            <?=date('Y年n月j日', strtotime($data['StaffMaster']['birthday'])) ?>
                                (<?=convGtJDate(date('Y-m-d', strtotime($data['StaffMaster']['birthday']))) ?>)
                                (<?=date('Ymd', strtotime($data['StaffMaster']['birthday'])) ?>)
                            </td>
                        </tr>
                    </table>  
                    
                    <!-- 左項目４ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>最寄駅①</td>
                            <td style='width:70%;'><?=getStation($data['StaffMaster']['s1_1']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>最寄駅②</td>
                            <td style='width:70%;'><?=getStation($data['StaffMaster']['s1_2']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>最寄駅③</td>
                            <td style='width:70%;'><?=getStation($data['StaffMaster']['s1_3']) ?></td>
                        </tr>
                    </table>                    
                    
                    <!-- 左項目６ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>役割</td>
                            <?php $list_role = array(''=>'', '0'=>'', '1'=>'メイン', '2'=>'サブ'); ?>
                            <td style='width:70%;'><?=$list_role[$data['StaffMaster']['role']] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>希望職種</td>
                            <td style='width:70%;'><?=getShokushu2($data['StaffMaster']['shokushu_kibou'], $list_shokushu) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>経験職種</td>
                            <td style='width:70%;'><?=getShokushu2($data['StaffMaster']['shokushu_keiken'], $list_shokushu) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>マンションギャラリー<br>経験</td>
                            <td style='width:70%;'><?=getTF($data['StaffMaster']['keiken_mansion']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>勤務可能曜日</td>
                            <td style='width:70%;'><?=getWorkable2($data['StaffMaster']['workable_day']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>希望勤務回数</td>
                            <td style='width:70%;'>
                                週 <?=$data['StaffMaster']['per_week'] ?> 回　月 <?=$data['StaffMaster']['per_month'] ?> 回
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>希望エリア</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['kibou_area'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>通勤可能時間</td>
                            <td style='width:70%;'><?=getComuterTime($data['StaffMaster']['commuter_time']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>当社以外の職業</td>
                            <td style='width:70%;'><?=getShokugyou2($data['StaffMaster']['extra_job']) ?><?=getShokugyou3($data['StaffMaster']['extra_job_etc']); ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>配偶者</td>
                            <td style='width:70%;'><?=getTF($data['StaffMaster']['haiguusha']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>身長</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['height'] ?> cm</td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>制服サイズ</td>
                            <td style='width:70%;'>上：<?=$data['StaffMaster']['size_1'] ?>号　下：<?=$data['StaffMaster']['size_2'] ?>号</td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>喫煙について</td>
                            <td style='width:70%;'><?=getTF($data['StaffMaster']['smoking']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>眼鏡使用について</td>
                            <td style='width:70%;'><?=getTF($data['StaffMaster']['glasses']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>給与振込先銀行</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['bank_name'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>支店名(店番号)</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['bank_shiten'] ?>(<?=$data['StaffMaster']['bank_branch_code'] ?>)</td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>口座番号</td>
                            <td style='width:70%;'><?=getKouza($data['StaffMaster']['bank_type']) ?> <?=$data['StaffMaster']['bank_kouza_num'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>口座名義</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['bank_kouza_meigi'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>社会保険希望</td>
                            <td style='width:70%;'><?=getTF($data['StaffMaster']['shaho_kibou']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>社会保険未加入の理由</td>
                            <td style='width:70%;'><?=$data['StaffMaster']['shaho_mikanyuu'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>年末調整</td>
                            <td style='width:70%;'><?php echo getNenmatsu($data['StaffMaster']['nenmatsu_chousei']); ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>備考</td>
                            <td style='width:70%;'><?= str_replace("\n","<br />",$data['StaffMaster']['remarks']); ?></td>
                        </tr>
                    </table>  

                <div style='margin-left: 10px;'>
            
        </td>
        <td style="width:50%;vertical-align: top;padding-left: 5px;">
            <div id="editbox" style="color: black;background-color: #ffff99;border:1px solid orange;padding:5px;vertical-align: middle;padding-left: 10px;margin-bottom: 10px;">
                <?php echo $this->Form->submit('編　集', array('name' => 'submit','div' => false)); ?>
                &nbsp;&nbsp;
                <?php
                    if ($flag == 0) {
                        $strKaijo = '登録解除';
                        $comment = __('本当に登録解除してよろしいですか？', true);
                    } else {
                        $strKaijo = '解除取消';
                        $comment = __('登録解除を取り消しますか？', true);
                    }
                ?>
                <?php echo $this->Form->submit($strKaijo, array('name' => 'release', 'id' => 'button-release', 'div' => false, 'onclick' => 'return confirm("'.$comment.'");')); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('閉じる', 'javascript:void(0);', array('id'=>'button-delete', 'onclick'=>'doClose();'))); ?>
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

            <!-- 登録者メモ -->
            <font style="font-size: 120%;">登録者メモ</font>
            <br>
            <!--
            <iframe width="100%" height="200px" src="<?=ROOTDIR ?>/StaffMasters/memo/<?=$data['StaffMaster']['id'] ?>" id="memo" frameborder='0' scrolling="yes" style="margin-bottom: 10px;"></iframe>
            <br>
            -->
            <div style="overflow-y:scroll;height:200px;margin-bottom: 10px;">
            <table border='1' cellspacing="0" cellpadding="2" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;">
                <tr>
                    <td colspan="2" style='background-color: #e8ffff;'>メモ一覧</td>
                </tr>
                <tr>
                    <td align="center" style="width:80%;">
                        <?php echo $this->Form->input('memo',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:95%;padding:3px;')); ?>
                        <?php echo $this->Form->input('username',array('type'=>'hidden', 'value' => $username)); ?>
                        <?php echo $this->Form->input('class',array('type'=>'hidden', 'value' => $class)); ?>
                        <?php echo $this->Form->input('staff_id',array('type'=>'hidden', 'value' => $data['StaffMaster']['id'])); ?>
                    </td>
                    <td align="center"><?php echo $this->Form->submit('書き込み', array('name' => 'comment', 'div' => false, 'id' => 'button-create')); ?></td>
                </tr>
                <?php foreach ($memo_datas as $mdata) { ?>
                <tr>
                    <td align="left" style="padding: 0 10px 0 10px;">
                        <?=$mdata['StaffMemo']['memo'] ?>
                    </td>
                    <td align="center"><?php echo $this->Form->submit('削　除', array('name' => 'delete['.$mdata['StaffMemo']['id'].']', 'id' => 'button-delete', 'div' => false)); ?></td>
                </tr>
                <?php } ?>
                
            </table>
            </div>
            <!-- 勤務実績一覧 -->
            <font style="font-size: 120%;">勤務実績一覧</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td style='background-color: #e8ffff;width:70%;'>案件名</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">表示するデータはありません。</td>
                </tr>
            </table>
            
            <!-- メールボックス -->
            <font id="title_messagebox" style="font-size: 120%;">メッセージボックス</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;" id="messagebox">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td style='background-color: #e8ffff;width:70%;'>タイトル</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">表示するデータはありません。</td>
                </tr>
            </table>
            
            <!-- 評価項目 -->
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>OJT/実施日</td>
                    <td style='width:70%;'><?= getOjt($data['StaffMaster']['ojt']); ?> / <?= $data['StaffMaster']['ojt_date']; ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>表情</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_hyoujou']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>発声・滑舌</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_hassei']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>明るさ</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_akarusa']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>華やかさ</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_hanayakasa']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>清潔感</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_seiketsukan']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>メイク</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_make']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>髪型</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_hairstyle']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>姿勢</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_shisei']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>所作</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_shosa']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>柔軟さ</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_juunansa']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>ハキハキ感</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_hakihaki']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>協力度</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_kyouryoku']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>雰囲気</td>
                    <td style='width:70%;'><?=getHyouka($data['StaffMaster']['hyouka_funiki']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>備考</td>
                    <td style='width:70%;'><?= str_replace("\n","<br />",$data['StaffMaster']['hyouka_remarks']); ?></td>
                </tr>
            </table>  
                  
        </td>
    </tr>
</table>

<?php } ?>
<?php echo $this->Form->end(); ?> 


