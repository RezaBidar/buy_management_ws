<?php 
echo '<ul>' ;
foreach ($group_list as $id => $group_name) 
{
	echo '<li><a href="' . site_url('client/test_api/purchase_list/' . $id) . '">'. $group_name .'</a>' ;
}
echo '</ul>' ;
echo '<hr/>' ;
echo '<a href="'.site_url('client/test_api/add_group/').'">Create Group</a>' ;