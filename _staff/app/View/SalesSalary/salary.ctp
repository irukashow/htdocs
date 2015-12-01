<?php require 'salary_element.ctp'; ?>
<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<?php echo $this->Form->create('WorkTable', array('name'=>'frm', 'id'=>'form')); ?> 
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ 売上給与
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/index" target="" onclick=''><font Style="font-size:95%;">売上給与データ</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/bill" target="" class="load"><font Style="font-size:95%;">請求書作成</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <b><font Style="font-size:95%;color: yellow;">[給与金額]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/account/2" target="" class="load" onclick=''><font Style="font-size:95%;">銀行口座</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/address/1" target="" onclick=''><font Style="font-size:95%;">スタッフ住所覧</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/modification/1" target="" onclick=''><font Style="font-size:95%;">個人情報変更</font></a>
    &nbsp;
</div>
<!-- 見出し１ END -->

<?php
    $year_arr = array();
    $year_arr = array('1999'=>'1999');
    for($j=2000; $j<2100; $j++) {
        $year_arr += array($j => $j); 
    }
    $month_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12');
    $start_month = '06';
    /**
    if (date('n') >= $start_month && date('n') <= 12) {
        $selected_year = date('Y');
    } else {
        $selected_year = date('Y', strtotime('-1 month'));
    }
     * 
     */
?>
<div style="width:100%;height:700px;margin-top: -5px;<?=$font_normal ?>;">   
    <div style="float:left;">
    <!-- 指定月 -->
        <?php echo $this->Form->input(false, 
                array('type'=>'select', 'label' => false, 'div' => false, 'name' => 'select_year', 'options' => $year_arr, 'selected' => $selected_year, 'style' => 'font-size:100%;')); ?>年度&nbsp;
    <button name="select">選択</button>
    <!-- 指定月 END -->
    </div>
    <div style="float:left;margin-left: 15px;margin-top: 2px;">
        全<?=count($datas) ?>名
    </div>
    <div style="float:right;font-size: 90%;margin-top: 2px;">※このページは全画面表示を想定して作成しております。</div>
    <div style="clear:both;"></div>
    
    <!-- 外枠 -->      
    <div style="position: relative;margin-top: 5px;margin-bottom: 0px;height: 90%;">
        <!-- ロック部分（左上） -->
        <div id="corner">
            <table border='1' style="height:75px;position:absolute;left:0px;top:0px;table-layout: fixed;text-align: center;">
                <colgroup> 
                    <col style="width: 100px;" />
                    <col style="width: 125px;" />
                    <col style="width: 150px;" />
                    <col style="width: 125px;" />
                    <col style="width: 200px;" />
                    <col style="width: 100px;" />
                    <col style="width: 125px;" />
                </colgroup>
                <tr style="background-color:#006699;color:white;font-size:90%;">
                    <td rowspan="2">登録番号</td>
                    <td rowspan="2">氏名</td>
                    <td rowspan="2">フリガナ</td>
                    <td colspan="4">振込口座</td>
                </tr>
                <tr style="background-color:#006699;color:white;font-size:90%;">
                    <td>銀行</td>
                    <td>支店</td>
                    <td>口座番号</td>
                    <td style="font-size:80%;">口座名義（カナ）</td>
                </tr>
                <tr style="background-color:#FFFFCC;color:white;font-size:90%;">
                    <td>
                        <?php echo $this->Form->input(false, array('type'=>'text', 'name'=>'search_id', 'label' => false, 'placeholder'=>'登録番号', 'style' => 'width:90%;')); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input(false, array('type'=>'text', 'name'=>'search_name', 'label' => false, 'placeholder'=>'氏名（漢字 or かな）', 'style' => 'width:90%;')); ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </dic>
        <!-- ロック部分（上） -->
        <div id="header_h">
            <table border='1' style="height:83px;width:1500px;margin-top: 0px;margin-bottom: 0px;table-layout: fixed;font-size: 90%;">
                <colgroup> 
                  <?php for ($count=0; $count<3*12; $count++){ ?>
                  <col style='width:80px;'>
                  <?php } ?>
                </colgroup>
                <tr style="background-color:#006699;color:white;font-size:100%;text-align: center;">
                <?php for ($count2=0; $count2<12; $count2++){ ?>
                    <td colspan="3"><?=date('Y年n月分', strtotime($count2.' month '.$selected_year.'-'.$start_month.'-01')); ?></td>
                <?php } ?>
                </tr>
                <tr style="background-color:#006699;color:white;font-size:90%;text-align: center;">
                <?php for ($count2=0; $count2<12; $count2++){ ?>
                    <td>小計</td>
                    <td>交通費</td>
                    <td>合計</td>
                <?php } ?>
                </tr>
            </table>
        </div>
        <!-- ロック部分（左） -->
        <div id="header_v">
            <table border='1' style="background-color: #e8ffff;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;font-size: 80%;">
                <colgroup> 
                    <col style="width: 100px;" />
                    <col style="width: 125px;" />
                    <col style="width: 150px;" />
                    <col style="width: 125px;" />
                    <col style="width: 200px;" />
                    <col style="width: 100px;" />
                    <col style="width: 125px;" />
                </colgroup>
                <?php foreach($datas as $data) { ?>
                <tr style="height:30px;">
                    <td align="center"><?=$data['StaffMaster']['id'] ?></td>
                    <td align="left"><?=$data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei'] ?></td>
                    <td align="left" style="font-size: 70%;"><?=$data['StaffMaster']['name_sei2'].' '.$data['StaffMaster']['name_mei2'] ?></td>
                    <td align="left"><?=$data['StaffMaster']['bank_name'] ?></td>
                    <td align="left"><?=$data['StaffMaster']['bank_shiten'] ?></td>
                    <td align="left"><?=$data['StaffMaster']['bank_kouza_num'] ?></td>
                    <td align="left" style="font-size: 70%;"><?=$data['StaffMaster']['bank_kouza_meigi'] ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <!-- /ロック部分 -->
        <!-- 横スクロール部分 -->
        <div class="x_scroll_box" id="data">  
        <!-- 職種入力 -->
            <table border='1' style="width:1500px;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;">
                <colgroup> 
                  <?php for ($count=0; $count<12*3; $count++){ ?>
                  <col style='width:82px;'>
                  <?php } ?>
                </colgroup>
                <tbody>
                    <?php foreach($datas as $data) { ?>
                    <tr style="height:30px;font-size: 90%;">
                    <?php for ($count=0; $count<12; $count++){ ?>
                        <td align="right">小計</td>
                        <td align="right">交通費</td>
                        <td align="right">合計</td>
                    <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
<div id="Div" style="display: none;clear:both;"><p id="Mbox0">セルをクリックしたらここに書き出します。</p>
 <p id="Mbox1">インデックス値は '0'から始まります。</p>
</div>
    </div>
<script type="text/javascript">
function $E(name){ return document.getElementById(name); }
function scroll(){
   $E("header_h").scrollLeft= $E("data").scrollLeft;// データ部のスクロールをヘッダに反映
   $E("header_v").scrollTop = $E("data").scrollTop;// データ部のスクロールをヘッダに反映
   }
$E("data").onscroll=scroll;
</script>

<?php echo $this->Form->end(); ?>  
    
</div>
    </div>