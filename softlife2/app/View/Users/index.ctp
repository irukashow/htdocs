<?php
    echo $this->Html->css('message');
    echo $this->Html->css('lightbox');
    echo $this->Html->script('lightbox');
    echo $this->Html->script('sanrio');
?>
<?php require('calendar.ctp'); ?>
<?php
    function getInfoStatus($val) {
        if ($val == 1) {
            $ret = '<font color=red>緊急</font>';
        } elseif ($val == 2) {
            $ret = '<font color=green>お知らせ</font>';
        }else {
            $ret = 'その他';
        }
        return $ret;
    }
    
    // 既読な否かの判定
    function isKidoku($val, $user) {
        $ret = false;
        $array = explode(',', $val);
        foreach ($array as $_array) {
            if ($_array == $user) {
                $ret = true;
            }
        }
        return $ret;
    }
?>
<!-- 見出し -->
<div id='headline' style="height:23px;">
    <div style="float:left;">
        ★ ホーム
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="" target=""></a>
        <a href="" target=""></a>
        <a href="" target=""></a>
    </div>
    <div style="float:right;font-size: 90%;">最終ログイン時刻：<?=$last_login ?></div>
</div>
<div style="clear:both;"></div>

<!-- メインペイン -->
<div id='message-main'>
    <table border="0" style="width:100%;">
        <tr>
            <td style="width:30%;">
                <!-- 左ペイン -->
                <div id='message-folder'>
                    <font style="font-size:110%;font-weight: bold;color:#006699;">ようこそ！ <?=$user_name ?>&nbsp;さん</font><br>
                    <div style="height: 10px;"></div>
                    <?php echo $this->Html->link('パスワード変更', '/users/passwd/'); ?>
                    <br>
                    <?php echo $this->Html->link('ログアウト', 'logout', array('title'=>'確認'), 'ログアウトしてもよろしいですか？'); ?>
                    
                    <div style="text-align: center;margin-top: 5px;">
                    <script type="text/javascript">
                    <!--
                      display('<?=ROOTDIR ?>');
                    //-->
                    </script>
                        <!--
                        <?php echo $this->Html->image('dog.gif', array('title' => 'ぼしゅうちゅう！', 'style' => 'cursor: pointer;')); ?><br>
                        <span style="font-family: 'HG創英角ﾎﾟｯﾌﾟ体';">「イメージ 写真 募集中！」</span><br>
                        -->
                    </div>
                    
                    <div style="margin-top: 30px;">
                        <!-- カレンダー -->
                        <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
                                <tr align="center">
                                        <td><a href="<?=ROOTDIR ?>/users/?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                                        <td><?php echo $y ?>年<?php echo $m ?>月</td>
                                        <td><a href="<?=ROOTDIR ?>/users/?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
                                </tr>
                        </table>

                        <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 5px;margin-bottom: 10px;border-spacing: 0px;background-color: white;">
                            <tr align="center" style="background-color: #cccccc;">
                                    <th>日</th>
                                    <th>月</th>
                                    <th>火</th>
                                    <th>水</th>
                                    <th>木</th>
                                    <th>金</th>
                                    <th>土</th>
                            </tr>
                            <tr align="center">
                        <?php
                                // 1日の曜日を取得
                                $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));

                                // その数だけ空のセルを作成
                                for ($i = 1; $i <= $wd1; $i++) {
                                        echo "<td> </td>";
                                }

                                $d = 1;
                                while (checkdate($m, $d, $y)) {
                                        // 日付出力（土日祝には色付け）
                                        if(date("w", mktime(0, 0, 0, $m, $d, $y)) == 0)
                                        {
                                                $style = 'color:red;';
                                        }
                                        elseif(date("w", mktime(0, 0, 0, $m, $d, $y)) == 6)
                                        {
                                                $style = 'color:blue;';
                                        }
                                        elseif(!empty($national_holiday[date("Y-m-d", mktime(0, 0, 0, $m, $d, $y))]))  
                                        {
                                                $style = 'color:red;';
                                        }
                                        else
                                        {
                                                $style = '';
                                        }
                                        
                                        // 本日
                                        if ($m == date("n") && $d == date("j") && $y == date("Y")) {
                                            $style = $style.'font-weight: bold;background-color: #ffffcc;color:green;';
                                        }
                                        
                                        // 出力
                                        echo "<td style='".$style."'>$d</td>";

                                        // 週の始まりと終わりでタグを出力
                                        if (date("w", mktime(0, 0, 0, $m, $d, $y)) == 6)
                                        {
                                            // 週を終了
                                            echo "</tr>";

                                                // 次の週がある場合は新たな行を準備
                                            if (checkdate($m, $d + 1, $y)) {
                                                echo '<tr align=\'center\'>';
                                            }
                                        }

                                    $d++;
                                }

                                // 最後の週の土曜日まで空のセルを作成
                                $wdx = date("w", mktime(0, 0, 0, $m + 1, 0, $y));

                                for ($i = 1; $i < 7 - $wdx; $i++)
                                {
                                        echo "<td>　</td>";
                                }
                        ?>
                            </tr>
                        </table>
                        <!-- カレンダー END-->
                        <div style="margin-top: 10px;">
                            <font style="font-size: 60%;">
                            <a href="http://grapee.jp/66393" target="_blank"></a>
                            </font>
                        </div>
                    </div>
                </div>
            </td>
            <td style="width:70%;">
                <!-- 新着情報 -->
                <div id='message-list'>
                    <font style='font-weight: bold;font-size: 110%;'>[新着情報]</font><br>
                    <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void" style="margin-bottom: 10px;">
                        <tr style='background-color: #459ed2;'>
                            <th colspan="2">○&nbsp;メッセージ</th>
                        </tr>
                        <tr>
                            <td width="10px">&nbsp;</td>
                            <td>
            <?php if ($new_count == 0) { ?>
                                新着メッセージはありません。
            <?php } else { ?>
                                <a href="<?=ROOTDIR ?>/message/index"><font style="color: blue;font-weight: bold;"><?=$new_count ?>&nbsp;通</font>の新着メッセージがあります。</a>
            <?php } ?>
                            </td>
                        </tr>
                    </table>
                    <font style='font-weight: bold;font-size: 110%;'>[システム情報]</font><br>
                    <!-- 管理者メッセージ部分 -->
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
                            <th style='width:10%;'>区分</th>
                            <th style='width:50%;'>標題</th>
                            <th style='width:25%;'>配信日時</th>
                        </tr>
                        <?php foreach ($datas as $data) { ?>
                    <?php if (isKidoku($data['AdminInfo']['kidoku_user'], $username)) { ?>
                        <tr>
                    <?php } else { ?>
                        <tr style='background-color: #fff6d7; border:1px solid orange; font-weight: bold;'>   
                    <?php } ?>   
                            <td style="padding-top: 8px;">
                                <?php echo $this->Form->input('check',array('type'=>'checkbox','label'=>false)); ?>
                            </td>
                            <td class='message-content'>
                                <?php echo getInfoStatus($data['AdminInfo']['status']); ?>
                            </td>
                            <td class='message-content'>
                                <?php echo $this->Html->link($data['AdminInfo']['title'], 'detail/'.$data['AdminInfo']['id'], array('style'=>'color: blue;')) ?>
                            </td>
                            <td class='message-content'><?=$data['AdminInfo']['created']; ?></td>
                        </tr>
                        <?php } ?>
                        <?php if (count($datas) == 0) { ?>
                        <tr>
                            <td colspan="5" align="center">新着メッセージはありません。</td>
                        </tr>
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
                    <!-- 管理者メッセージ部分 END -->
                </div>
                            </td>
                    </tr>
                </table>
                </div>
                </td>
        </tr>
    </table>
</div>
