<script type="text/javascript">
    onload = function() {
        document.getElementById('content').style.background='#ffffcc';
        document.getElementById('content').style.height='800px';
        //document.getElementById('cssmenu').style.background='#ffffcc';
    }
</script>

<!-- 見出し -->
<div id='headline'>
    ★ 管理者ページ
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="" target="_blank"></a>
    <a href="" target="_blank"></a>
    <a href="" target="_blank"></a>
</div>

<div style="margin-top: 20px;">
<?php echo $this->Form->create('User'); ?>
    <fieldset style="border: none; margin-bottom: 20px;height: 300px;">
        <table id='admin' border="1" width="100%" cellspacing="0" cellpadding="2" bordercolor="#333333" align="center" style="background-color: white;">
            <tr height="50px">
                <td colspan="6">
                    <legend style="font-size: 150%;color: red;"><?php echo __('ユーザー管理'); ?></legend>
                </td>
            </tr>
            <tr>
                <td width="15%">
                    <?php echo $this->Html->link('▶ユーザー一覧', '/users/view'); ?>
                </td>
                <td width="15%">
                    <?php echo $this->Html->link('▶ユーザー登録（新規）', '/users/add/'); ?>
                </td>
                <td width="15%">
                    <?php echo $this->Html->link('▶ユーザー登録（更新）', '/users/edit/'); ?>
                </td>
                <td width="15%"></td>
                <td width="15%"></td>
            </tr>
            <tr height="15px">
                <td colspan="6">
                    <legend style="font-size: 150%;color: red;margin-top: 5px;margin-bottom: 5px;"><?php echo __('システム管理'); ?></legend>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $this->Html->link('▶バージョン情報入力ページ', './version/'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶バージョン更新履歴', '/menu/version'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶スタッフマスタ更新履歴', '/log/staff_master'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶ログイン履歴', '/log/login/sort:created/direction:desc'); ?>
                </td>
                <td></td>
            </tr>
            <tr height="15px">
                <td colspan="6">
                    <legend style="font-size: 150%;color: red;margin-top: 5px;margin-bottom: 5px;"><?php echo __('マスタ管理'); ?></legend>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $this->Html->link('▶項目マスタ', '/master/index'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶スタッフ職種マスタ', '/master/shokushu'); ?>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td></td>
            </tr>
        </table>

    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>




