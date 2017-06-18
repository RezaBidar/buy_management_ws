<h2>add group</h2>
<?php 
echo btform::form_open();
echo btform::form_input('Group Name' , array('name' => 'name'));
echo btform::form_submit(array('name' => 'submit'), 'Submit');
echo btform::form_close();
 ?>