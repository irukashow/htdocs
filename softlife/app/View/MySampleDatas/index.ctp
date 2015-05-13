<?php
    echo $this->Html->css( 'main.css');
?>
<h1>Index Page</h1>
<p>MySampleData Index View.</p>
<table cellpadding="0" cellspacing="0">
  <tr>
      <th><?php echo $this->Paginator->sort('id');?></th>
      <th><?php echo $this->Paginator->sort('name');?></th>
      <th><?php echo $this->Paginator->sort('mail');?></th>
      <th><?php echo $this->Paginator->sort('tel');?></th>
  </tr>
  <?php foreach ($datas as $data): ?>
  <tr>
    <td><?php echo $data['MySampleData']['id']; ?>&nbsp;</td>
    <td><?php echo $data['MySampleData']['name']; ?>&nbsp;</td>
    <td><?php echo $data['MySampleData']['mail']; ?>&nbsp;</td>
    <td><?php echo $data['MySampleData']['tel']; ?>&nbsp;</td>
  </tr>
  <?php endforeach; ?>
</table>

<div class="pageNav03">
<?php
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
?>
 </div>