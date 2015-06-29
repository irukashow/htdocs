<?php
echo $this->Form->create('Sample');
echo $this->Form->input('code');
echo $this->Form->input('line', array('value' => $xmlArray['ekidata']['station']['line_name']));
echo $this->Form->input('station', array('value' => $xmlArray['ekidata']['station']['station_name']));
print_r($xmlArray);
echo $this->Form->end('send');

