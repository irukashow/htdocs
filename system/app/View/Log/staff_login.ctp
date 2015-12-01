<div style="padding: 15px;">
    <div style="float:left;">
        <font style="font-size: 150%;color: red;"><?= $headline ?></font>
    </div>
    <div style="float:right;">
        <a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>
    </div>
    <div style="clear:both;"></div>

<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>
<div style="float:right;margin-top: 5px;">
    ページ数：
    <?php
        echo $this->paginator->counter(array('format' => '<b>%page%</b> / <b>%pages%</b>'));
    ?>
    &nbsp;&nbsp;&nbsp;
    <?php echo $this->Paginator->counter(array('format' => __('総件数：  <b>{:count}</b> 件')));?>
</div>
<!--- ログイン履歴 START --->
<table id="staff_master" border="1" width="100%" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center">
  <tr class="col">
    <th width="30px"><?php echo $this->Paginator->sort('id',"ID");?></th>
    <th width="100px"><?php echo $this->Paginator->sort('staff_id','スタッフ氏名');?></th>
    <th width="60px"><?php echo $this->Paginator->sort('area','エリア');?></th>
    <th width="60px"><?php echo $this->Paginator->sort('status','ｽﾃｰﾀｽ');?></th>
    <th width="100px"><?php echo $this->Paginator->sort('ip_address','IPアドレス');?></th>
    <th><?php echo $this->Paginator->sort('user_agent','ユーザーエージェント');?></th>
    <th width="200px"><?php echo $this->Paginator->sort('created','記録日時');?></th>
  </tr>
  <?php foreach ($datas as $key => $data): ?>
  <tr>
    <td align="center"><?php echo $data['StaffLoginLog']['id']; ?></td>
    <td><?php echo $data['StaffLoginLog']['staff_name'].' ('.$data['StaffLoginLog']['staff_id'].')'; ?></td>
    <td><?php echo $list_area[substr($data['StaffLoginLog']['class'], 0, 1)]; ?></td>
    <td><?php echo $data['StaffLoginLog']['status']; ?></td>
    <td><?php echo $data['StaffLoginLog']['ip_address']; ?></td>
    <td><?php echo $data['StaffLoginLog']['user_agent']; ?></td>
    <td><?php echo $data['StaffLoginLog']['created']; ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<!--- ログイン履歴 END --->

<?php
    echo $this->Paginator->numbers (
        array (
            'before' => $this->Paginator->hasPrev() ? $this->Paginator->first('<<').' | ' : '',
            'after' => $this->Paginator->hasNext() ? ' | '.$this->Paginator->last('>>') : '',
            )
        );
?>
<br><br>
<a href='<?=ROOTDIR ?>/admin/'>◀管理者ページへ戻る</a>

</div>