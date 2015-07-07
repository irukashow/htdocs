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
        <table id='admin' border="0" width="100%" cellspacing="2" cellpadding="10" bordercolor="#459ed2" align="center" style="background-color: white;">
            <tr style="height: 40px;">
                <th width="20%">
                    <legend style=""><?php echo __('ユーザー管理'); ?></legend>
                </th>
                <th width="20%">
                    <legend style=""><?php echo __('システム管理'); ?></legend>
                </th>
                <th width="20%">
                    <legend style=""><?php echo __('システム履歴情報'); ?></legend>
                </th>
                <th width="20%">
                    <legend style=""><?php echo __('マスタ管理'); ?></legend>
                </th>
                <th width="20%"></th>
            </tr>
            <tr>
                <td>
                    <?php echo $this->Html->link('▶ユーザー一覧', '/users/view'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶管理者からのお知らせ', './admin_info_list'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶ログイン履歴', '/log/login/sort:created/direction:desc'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶項目マスタ', '/master/index'); ?>
                </td>
                <td>元サイト：<a href="http://softlife.xsrv.jp/" target="_blank">http://softlife.xsrv.jp/</a></td>
            </tr>
            <tr>
                <td>
                    <?php echo $this->Html->link('▶ユーザー登録（新規）', '/users/add/'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶バージョン情報入力ページ', './version/'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶スタッフマスタ更新履歴', '/log/staff_master'); ?>
                </td>
                <td>
                    <?php echo $this->Html->link('▶スタッフ職種マスタ', '/master/shokushu'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td width="15%">
                    <?php echo $this->Html->link('▶ユーザー登録（更新）', '/users/edit/'); ?>
                </td>
                <td>

                </td>
                <td>
                    <?php echo $this->Html->link('▶スタッフ仮登録履歴', '/log/staff_preregist'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    
                </td>
                <td>
                    <?php echo $this->Html->link('▶バージョン更新履歴', '/menu/version'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
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




