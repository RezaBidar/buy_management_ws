<h2>Add New Purchase</h2>
<?php 
echo btform::form_open();
echo btform::form_input('Title' , array('name' => 'title')) ;
echo btform::form_input('Price' , array('name' => 'price')) ;
echo btform::form_textarea('Buy Description' , array('name'=>'description')) ;
echo '<table>' ;
foreach ($member_list as $member_id => $name) {
	echo '<tr>' ;
	echo '<td>' . $name . '</td>';
	echo '<td>' . btform::form_input('',array('name' => 'deptor-'.$member_id , 'placeholder' => 'Should pay')) . '</td>'; 
	echo '</tr>' ;
}
echo '</table>' ;

echo btform::form_submit(array('name'=>'submit'),'Submit');

