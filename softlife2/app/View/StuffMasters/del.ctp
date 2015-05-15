<h1>DEL Page</h1>
<p>MySampleData Delete Form.</p>
<?php
  echo $this->Form->create('StuffMaster');
  echo $this->Form->input('id');
  echo $this->Form->input('name_sei');
  echo $this->Form->end('Submit');
