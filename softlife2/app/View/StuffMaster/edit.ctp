<h1>Edit Page</h1>
<p>MySampleData Edit Form.</p>
<?php
  echo $this->Form->create('StuffMaster');
  echo $this->Form->input('id');
  echo $this->Form->input('name_sei');
  echo $this->Form->input('age');
  echo $this->Form->input('sex');
  echo $this->Form->end('Submit');
?>