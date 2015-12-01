<!-- content start -->
<div id="success" data-role="page">
    <div data-role="content" data-url="<?=ROOTDIR ?>/users/login" style="height: 600px;text-shadow: 2px 2px 3px white;">
        <div style="text-align: center;"><h3>アカウント確認ページ</h3></div>

        <p style="color:red;"><?=$msg ?></p>
        <?php echo $this->Form->create('StaffMaster', array('name'=>'form')); ?>
        <?php if (empty($data)) { ?>
        <?=$this->Form->input('email', array('type' => 'text', 'label' => 'メールアドレス（登録の際のもの）', 'style'=>'width: 95%;',))?>
        
        <?=$this->Form->input('birthday', array('type' => 'text', 'label' => '生年月日（8桁） <br><font style="font-size:90%;">※入力例）1980年1月8日⇒19800108</font>', 'style'=>'width: 95%;',))?>
        <?php } else {
        ?>
        <label>ログインアカウント</label>
        <table border="1" cellpadding="5" style="margin-bottom: 5px;">
            <tr>
                <td style="background-color: #e8ffff;width:40%;">氏名</td>
                <td style="background-color: #FFFFDD;width:60%;"><?=$data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei'] ?></td>
            </tr>
            <tr>
                <td style="background-color: #e8ffff;width:40%;">アカウントID</td>
                <td style="background-color: #FFFFDD;width:60%;"><?=$class.$data['StaffMaster']['id'] ?></td>
            </tr>
            <tr>
                <td style="background-color: #e8ffff;width:40%;">初期パスワード</td>
                <td style="background-color: #FFFFDD;width:60%;"><?=date('Ymd', strtotime($data['StaffMaster']['birthday'])) ?></td>
            </tr>
        </table>
        <br>
        <?php
            }
        ?>
        <div style='float:left;'>
            <?php if (empty($data)) { ?>
            <input type="submit" value="確 認" data-theme="e" data-icon="check" data-inline="true">
            <?php } ?>
            <input type="button" value="ログイン" data-inline="true" onclick='location.href="<?=ROOTDIR ?>/users/login";'>
        </div> 

        <?=$this->Form->end();?>

    </div>
</div>

<!-- ログインエラー -->
<div id="error" data-role="dialog">
     <div data-role="header">
         <h1 id="dlog_title">　　エラー</h1>
     </div>
     <div data-role="content">
         <p id="dlog_content">ログインに失敗しました。<br>アカウントかパスワードが異なります。</p>
     </div>
 </div>
<!-- ログインエラー END -->



