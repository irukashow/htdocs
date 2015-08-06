<?php require('calender.ctp'); ?>
<?php
    function setFlag($val) {
        if ($val == 1) {
            $ret = '◎';
        } elseif ($val == 2) {
            $ret = '△';
        } else {
            $ret = '　';
        }
        return $ret;
    }
?>
<div id="page2" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>スケジュール</h1>
                <!--
                <a href="#" data-role="button" data-icon="refresh" data-iconpos="notext" data-inline="true" onclick="location.reload();"></a>
                -->
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>
        <div data-role="content">
            <b>スケジュール</b>
            <p>シフト希望は来月以降で願います。</p>
            <!--- シフト希望表 --->
            <!-- カレンダー -->
            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
                    <tr align="center">
                            <td><a href="<?=ROOTDIR ?>/users/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                            <td><?php echo $y ?>年<?php echo $m ?>月</td>
                            <td><a href="<?=ROOTDIR ?>/users/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
                    </tr>
            </table>

            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 5px;margin-bottom: 10px;border-spacing: 0px;background-color: white;">
                <tr align="center" style="background-color: #cccccc;">
                        <th style="width:10%">日</th>
                        <th style="width:10%">月</th>
                        <th style="width:10%">火</th>
                        <th style="width:10%">水</th>
                        <th style="width:10%">木</th>
                        <th style="width:10%">金</th>
                        <th style="width:10%">土</th>
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
                            elseif(!empty($national_holiday[date("Ymd", mktime(0, 0, 0, $m, $d, $y))]))  
                            {
                                    $style = 'color:red;';
                            }
                            else
                            {
                                    $style = '';
                            }

                            // 本日
                            if ($m == date("n") && $d == date("j") && $y == date("Y")) {
                                $style2 = 'font-weight: bold;background-color: #ffffcc;color:green;';
                            } else {
                                $style2 = '';
                            }

                            // 出力
                            echo "<td style='".$style2."'>"
                                    . "<a href='".ROOTDIR."/users/schedule_input/".$y."/".$m."/".$d."' style='".$style."'>$d</a><br>".setFlag($data[$d])
                                    ."</td>";

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
        </div>
        <div class="pagetop">
                <a href="#page2">
                    <?php echo $this->Html->image('pagetop.png'); ?>
                </a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div>

<!--ダイアログメニュー-->
<?php require('dialog_menu.ctp'); ?>
<!--ダイアログメニュー end-->