<h2>Add New Member</h2>
<?php 
echo btform::form_open() ;
echo btform::form_input('Email', array('name'=>'email')) ;
echo btform::form_input('Password', array('name'=>'password')) ;
echo btform::form_input('Full Name', array('name'=>'name')) ;
echo btform::form_submit(array('name'=>'submit') , 'Submit') ;
echo btform::form_close() ;

