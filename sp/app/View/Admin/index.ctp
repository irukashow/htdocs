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

<div style="width:30%;height: 1000px; margin-top: 20px;margin-left: 30px;">
<?php echo $this->Form->create('User'); ?>
    <fieldset style="border: none; margin-bottom: 20px;height: 800px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('ユーザー管理'); ?></legend>
        <?php echo $this->Html->link('ユーザー一覧', '/users/view'); ?>
        <br><br>
        <?php echo $this->Html->link('ユーザー登録（新規）', '/users/add/'); ?>
        <br><br>
        <?php echo $this->Html->link('ユーザー登録（更新）', '/users/edit/'); ?>
        <br><br>
    
        <legend style="font-size: 150%;color: red;margin-top: 5px;margin-bottom: 5px;"><?php echo __('システム管理'); ?></legend>
        <?php echo $this->Html->link('バージョン情報入力ページ', './version/'); ?>
        <br><br>
        <?php echo $this->Html->link('バージョン更新履歴', '/menu/version'); ?>
        <br><br>
        <?php echo $this->Html->link('スタッフマスタ更新履歴', '/log/staff_master'); ?>
        <br><br>
        <?php echo $this->Html->link('ログイン履歴', '/log/login/sort:created/direction:desc'); ?>
         <br><br>

    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>




