<h1>Index Page</h1>
<p>StaffMaster Find View.</p>
<?php
  echo $this->Form->create('StaffMaster');
  echo $this->Form->input('name_sei');
  echo $this->Form->input('name_mei');
  echo $this->Form->end('Submit');
?>
 
<?php if (isset($data)): ?>
  <pre><?php print_r($data); ?></pre>
<?php endif; ?>