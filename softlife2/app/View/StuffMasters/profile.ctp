<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('station');
?>

<table border="0" style="margin:10px;width:98%;">
    <tr>
        <td style="width:50%;">
            <div style="color: black;background-color: #99ccff;border:1px solid #0099cc;padding:3px;vertical-align: middle;padding-right: 5px;">
                <font style="font-size: 150%;">■登録者情報</font>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <font style="font-size: 100%;">登録年月日：<?='2015/05/11' ?>&nbsp;&nbsp;登録番号：<?='345678' ?></font>
            </div>
            <?php echo $this->Form->create('StuffMaster', array('name' => 'form','enctype' => 'multipart/form-data','id' => 'regist')); ?>
                    <!-- プロフィール -->
                    <table border='0' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='width:50%;'>
                                ヨコイ&nbsp;マサヒロ<br>
                                <font style='font-size:150%;'>横井&nbsp;政広&nbsp;&nbsp;40歳</font>
                            </td>
                            <td style='width:50%;text-align: center;' rowspan="5">
                                <img src='files/33333/33333.jpg' style='border:1px black solid;'>
                            </td>
                        </tr>
                        <tr>
                            <td style=''>雇用形態：&nbsp;派遣</td>
                        </tr>
                        <tr>
                            <td style=''>勤務回数：&nbsp;回</td>
                        </tr>
                        <tr>
                            <td style='background-color:#ffcc66;'>就業状況：&nbsp;</td>
                        </tr>
                        <tr>
                            <td style=''>
                                <font style='font-size:120%;'>紹介可能職種</font><br>
                                〇〇〇〇〇〇
                            </td>
                        </tr>
                    </table>
                    
                    <!-- 左項目１ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>勤務開始希望日</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>研修希望日</td>
                            <td style='width:70%;'></td>
                        </tr>
                    </table>
                    
                    <!-- 左項目２ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>電話番号１</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>電話番号２</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>メールアドレス１</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>メールアドレス２</td>
                            <td style='width:70%;'></td>
                        </tr>
                    </table>
                    
                    <!-- 左項目３ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>勤務開始希望日</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>研修希望日</td>
                            <td style='width:70%;'></td>
                        </tr>
                    </table>
                    
                    <!-- 左項目４ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>最寄駅①</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>最寄駅②</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>最寄駅③</td>
                            <td style='width:70%;'></td>
                        </tr>
                    </table>                    
                    
                    <!-- 左項目５ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>郵便番号</td>
                            <td style='width:70%;'><?= '520' ?>-<?= '0801'?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>都道府県</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>市区町村</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>生年月日</td>
                            <td style='width:70%;'></td>
                        </tr>
                    </table>  
                    
                    <!-- 左項目６ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>希望職種</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>経験職種</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>マンションギャラリー<br>経験</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>勤務可能日</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>希望勤務回数</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>希望エリア</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>通勤可能時間</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>当社以外の職業</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>配偶者</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>身長</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>制服サイズ</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>喫煙について</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>眼鏡使用について</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>給与振込先銀行</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>支店名</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>口座番号</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>口座名義</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>社会保険希望</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>社会保険未加入の理由</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>年末調整</td>
                            <td style='width:70%;'></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>備考</td>
                            <td style='width:70%;'></td>
                        </tr>
                    </table>  

                <div style='margin-left: 10px;'>
            
        </td>
        <td style="width:50%;vertical-align: top;padding-left: 5px;">
            <div style="color: black;background-color: #ffff99;border:1px solid orange;padding:0px;vertical-align: middle;padding-left: 10px;margin-bottom: 10px;">
                <?php echo $this->Form->submit('編集', array('name' => 'submit','div' => false)); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('閉じる', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'javascript:window.close();'))); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('印刷する', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'javascript:window.close();'))); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('◀前へ', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'javascript:window.close();'))); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('次へ▶', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'javascript:window.close();'))); ?>
                <?php echo $this->Form->end(); ?>
            </div>
            
            <!-- 登録者メモ -->
            <font style="font-size: 120%;">登録者メモ</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 1px;">
                <tr>
                    <td style='background-color: #e8ffff;width:70%;'>メモ一覧</td>
                    <td style='background-color: #e8ffff;width:30%;'>コマンド</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            
            <!-- 勤務実績一覧 -->
            <font style="font-size: 120%;">勤務実績一覧</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 1px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td style='background-color: #e8ffff;width:70%;'>案件名</td>
                </tr>
                <tr>
                    <td style='width:30%;'>2015-05/25</td>
                    <td style='width:70%;'></td>
                </tr>
            </table>
            
            <!-- メールボックス -->
            <font style="font-size: 120%;">メールボックス</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 1px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td style='background-color: #e8ffff;width:70%;'>タイトル</td>
                </tr>
                <tr>
                    <td style='width:30%;'>2015-05/25</td>
                    <td style='width:70%;'></td>
                </tr>
            </table>
            
            <!-- 評価項目 -->
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 1px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>OJT/実施日</td>
                    <td style='width:70%;'><?= '2015-07-01' ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>表情</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>発声・滑舌</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>明るさ</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>華やかさ</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>清潔感</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>メイク</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>髪型</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>姿勢</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>所作</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>柔軟さ</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>ハキハキ感</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>協力度</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>雰囲気</td>
                    <td style='width:70%;'></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>備考</td>
                    <td style='width:70%;'></td>
                </tr>
            </table>  
                    
        </td>
    </tr>
</table>