<?php
    echo $this->Html->css('message');
?>
<?php require('calender.ctp'); ?>
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
                    <font style="font-size:110%;font-weight: bold;color:#006699;">ようこそ！ <?=$user_name ?>さん</font><br>
                    <div style="height: 10px;"></div>
                    <?php echo $this->Html->link('パスワード変更', '/users/passwd/'); ?>
                    <br>
                    <?php echo $this->Html->link('ログアウト', 'logout', array('title'=>'確認'), 'ログアウトしてもよろしいですか？'); ?>
                    
                    <div style="text-align: center;margin-top: 0px;">
                        <?php echo $this->Html->image('dog.gif', array('title' => 'ぼしゅうちゅう！', 'style' => 'cursor: pointer;')); ?><br>
                        <span style="font-family: 'HG創英角ﾎﾟｯﾌﾟ体';">「ホームのイメージ募集中！」</span>
                    </div>
                    
                    <div style="margin-top: 35px;">
                        <!-- カレンダー -->
                        <center><?php echo $year; ?>年<?php echo $month; ?>月</center>
                        <table id='calender' border="0" cellspacing="0" cellpadding="5" bordercolor="#459ed2" align="center" style="background-color: white;">
                            <tr>
                                <th>日</th>
                                <th>月</th>
                                <th>火</th>
                                <th>水</th>
                                <th>木</th>
                                <th>金</th>
                                <th>土</th>
                            </tr>

                            <tr>
                            <?php $cnt = 0; ?>
                            <?php foreach ($calendar as $key => $value): ?>

                                <td>
                                <?php $cnt++; ?>
                                <?php echo $value['day']; ?>
                                </td>

                            <?php if ($cnt == 7): ?>
                            </tr>
                            <tr>
                            <?php $cnt = 0; ?>
                            <?php endif; ?>

                            <?php endforeach; ?>
                            </tr>
                        </table>
                        <!-- カレンダー END-->
                    </div>
                </div>
            </td>
            <td style="width:70%;">
                <!-- 新着情報 -->
                <div id='message-list'>
                    <font style='font-weight: bold;font-size: 110%;'>[新着情報]</font><br>
                    <table border='0' id='message-table' cellspacing="0" cellpadding="5" frame="void" style="margin-bottom: 10px;">
                        <tr style='background-color: #459ed2;'>
                            <th colspan="2">○&nbsp;メッセージ（所属向け）</th>
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
                        <tr style='background-color: #459ed2;'>
                            <th colspan="2">○&nbsp;メッセージ（個人向け）</th>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>新着メッセージはありません。</td>
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
                            <th style='width:25%;'>作成日時</th>
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

