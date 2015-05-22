<!-- 見出し -->
<div id='headline'>
    ★ 管理者ページ
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="" target="_blank"></a>
    <a href="" target="_blank"></a>
    <a href="" target="_blank"></a>
</div>

<div style="width:30%; margin-top: 20px;margin-left: 30px;">
<?php echo $this->Form->create('User'); ?>
    <fieldset style="border: none; margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('管理メニュー'); ?></legend>
    <?php echo $this->Html->link('ユーザー一覧', '/account/'); ?>
    <br><br>
    <?php echo $this->Html->link('新規ユーザ登録', '/users/add/'); ?>
    <br><br>
    <?php echo $this->Html->link('ユーザー情報更新', '/users/edit/'); ?>
    <br><br>
    <?php echo $this->Html->link('バージョン更新情報', '/version_remarks/'); ?>
    <br><br>
    <?php echo $this->Html->link('スタッフマスタ履歴', '/stuffmaster_log/'); ?>
    <br><br>
    <?php echo $this->Html->link('ログイン履歴', '/login_log/'); ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>




