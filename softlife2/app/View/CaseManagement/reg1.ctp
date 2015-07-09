<?php
    echo $this->Html->script('jquery-1.9.1');
?>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 5px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('案件登録<font color=gray> （基本情報）</font>'); ?></legend>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
        <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;>>&nbsp;
            オーダー情報&nbsp;>>&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;>>&nbsp;
            <a href="<?=ROOTDIR ?>/case_management/reg2/<?=$case_id ?>/<?=$koushin_flag ?>">オーダー情報</a>&nbsp;>>&nbsp;
            <a href="<?=ROOTDIR ?>/case_management/reg3/<?=$case_id ?>/<?=$koushin_flag ?>">契約書情報</a>&nbsp;
        </font>
        
<?php } ?>
        <!-- ページ選択 END -->
<?php echo $this->Form->create('CaseManagement'); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $case_id)); ?>
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>

        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;margin-bottom: 10px;border-spacing: 0px;">
            <tr>
                <th style='background:#99ccff;text-align: center;' colspan="2">項目</th>
                <th style='background:#99ccff;text-align: center;'>入力内容</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">案件名称</td>
                <td>
                    <?php echo $this->Form->input('case_name',array('type'=>'text', 'label'=>false, 'div'=>false, 'style'=>'width:95%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">新規登録日</td>
                <td>
                    <?php echo date('Y-m-d', strtotime($data['CaseManagement']['created'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">更新登録日</td>
                <td>
                    <?php echo date('Y-m-d', strtotime($data['CaseManagement']['modified'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">担当者（所属・氏名）</td>
                <td>
                <?php echo $this->Form->input('username',array('type'=>'select', 'label'=>false,'div'=>false,'empty'=>'担当者を選択してください', 
                                        'options'=>$name_arr, 'style'=>'width:70%;padding:5px;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:30%;' colspan="2">契約形態</td>
                <td>
                    <?php $list0 = array('1'=>'派遣契約　', '2'=>'請負契約　'); ?>
                    <?php echo $this->Form->input('contract_type',array('type'=>'radio', 'legend'=>false, 'div'=>false, 'options'=>$list0)); ?> 
                </td>
            </tr>
            <!-- 依頼主 -->
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="5">依頼主</td>
                <td style='background-color: #e8ffff;width:20%;'>企業名<br>部署・担当者</td>
                <td>
                    <table>
                        <tr>
                            <td width="95%">
                    <?php $list_corp = array('1' => '伊藤忠ハウジング株式会社　マンション販売部　平山直人'); ?> 
                    <?php echo $this->Form->input('corp_name',array('type'=>'select', 'label'=>false,'div'=>'display: inline; ','empty'=>'依頼主を選択してください', 
                        'options'=>$customer_arr, 'style'=>'width:100%;padding:5px;')); ?>
                            </td>
                            <td>
                    <?php echo $this->Form->submit('選 択',array('div'=>'display: inline; ', 'name'=>'select_client', 'label'=>false)); ?>
                            </td>
                        </tr>
                    </table>
                    <?php $list = array('1'=>'事業主　', '2'=>'請求先　', '0' => 'その他　'); ?>
                    <?php echo $this->Form->input('address5',array('type'=>'radio', 'legend'=>false, 'div'=>false, 'options'=>$list)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>郵便番号<br>住所</td>
                <td>
                    〒<br>
                    
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>TEL</td>
                <td>

                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>FAX</td>
                <td>

                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メールアドレス</td>
                <td>

                </td>
            </tr>
            <!-- 依頼主 END -->
            <tr>
                <td colspan="2" style='background-color: #e8ffff;width:20%;'>事業主</td>
                <td>
                    <table>
                        <tr>
                            <td width="95%">
                    <?php echo $this->Form->input('corp_name',array('type'=>'select', 'label'=>false,'div'=>'display: inline; ','empty'=>'事業主を選択してください', 
                        'options'=>$customer_arr, 'style'=>'width:100%;padding:5px;')); ?>
                            </td>
                            <td>
                    <?php echo $this->Form->submit('選 択',array('div'=>'display: inline; ', 'name'=>'select_client', 'label'=>false)); ?>
                            </td>
                        </tr>
                    </table>
                    <?php echo $this->Form->input('corp_name',array('type'=>'checkbox', 'label'=>'請求先', 'options'=>$list_corp, 'style'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" style='background-color: #e8ffff;width:20%;'>開始日</td>
                <td>
                    <?php echo $this->Form->input('name_sei',array('type'=>'text', 'label'=>false,'div'=>false, 'class'=>'date', 'style'=>'width:20%;')); ?>
                </td>
            </tr>
            <!-- 就業場所 -->
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="5">就業場所</td>
                <td style='background-color: #e8ffff;width:20%;'>企業名<br>部署・担当者</td>
                <td>
                    企業名<br>
                    <?php $list = array('1'=>'事業主　', '2'=>'請求先　', '0' => 'その他　'); ?>
                    <?php echo $this->Form->input('address5',array('type'=>'radio', 'legend'=>false, 'div'=>false, 'options'=>$list)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>郵便番号<br>住所</td>
                <td>
                    〒<br>
                    
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>TEL</td>
                <td>

                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>FAX</td>
                <td>

                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メールアドレス</td>
                <td>

                </td>
            </tr>
            <!-- 就業場所 END -->
            <!-- 請求先① -->
            <tr>
                <td style='background-color: #e8ffff;width:10%;' rowspan="6">請求先①</td>
                <td style='background-color: #e8ffff;width:20%;'>企業名<br>部署・担当者</td>
                <td>
                    <table>
                        <tr>
                            <td width="95%">
                    <?php echo $this->Form->input('corp_name',array('type'=>'select', 'label'=>false,'div'=>'display: inline; ','empty'=>'請求先を選択してください', 
                        'options'=>$customer_arr, 'style'=>'width:100%;padding:5px;')); ?>
                            </td>
                            <td>
                    <?php echo $this->Form->submit('選 択',array('div'=>'display: inline; ', 'name'=>'select_client', 'label'=>false)); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>郵便番号<br>住所</td>
                <td>
                    〒<br>
                    
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>TEL</td>
                <td>

                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>FAX</td>
                <td>

                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>メールアドレス</td>
                <td>

                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>振込口座情報</td>
                <td>
                    〇〇銀行&nbsp;&nbsp;〇〇支店&nbsp;&nbsp;普通&nbsp;&nbsp;〇〇<br>
                    名義：&nbsp;〇〇<br>
                    締日：&nbsp;月末&nbsp;&nbsp;請求書到着日：&nbsp;翌５日必着<br>
                    割合：&nbsp;100%<br>
                </td>
            </tr>
            <!-- 請求先① END -->
        </table>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
            <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;>>&nbsp;
            オーダー情報&nbsp;>>&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;>>&nbsp;
            <a href="<?=ROOTDIR ?>/case_management/reg2/<?=$case_id ?>/<?=$koushin_flag ?>">オーダー情報</a>&nbsp;>>&nbsp;
            <a href="<?=ROOTDIR ?>/case_management/reg3/<?=$case_id ?>/<?=$koushin_flag ?>">契約書情報</a>&nbsp;
        </font>
        
<?php } ?>
        <!-- ページ選択 END -->
    </fieldset>  
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('登録する', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('閉 じ る', 'javascript:void(0);', array('id'=>'button-delete', 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>