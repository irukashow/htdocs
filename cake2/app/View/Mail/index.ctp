<?php 
    echo $form->create('Mail', array('url' => array(  
        'controller' => 'mails',  
    'action' => 'index',  
    'id' => null  
)))?>  
  
<dl>  
  <dt><label><?php __('件名')?></label></dt>  
  <dd><?php echo $form->input('Mail.subject', array(  
    'div' => false,  
    'label' => false,  
  ))?></dd>  
  <dt><label><?php __('宛先')?></label></dt>  
  <dd><?php echo $form->input('Mail.to', array(  
    'div' => false,  
    'label' => false,  
  ))?></dd>  
  <dt><label><?php __('本文')?></label></dt>  
  <dd><?php echo $form->input('Mail.body', array(  
    'type' => 'textarea',  
    'div' => false,  
    'label' => false,  
  ))?></dd>  
</dl>  
  
<?php echo $form->submit(__('次へ &raquo;', true), array(  
  'escape' => false,  
))?>  
  
<?php echo $form->end()?> 