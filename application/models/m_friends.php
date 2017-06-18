<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * friends table model
 *
 * in this system frinds and group are same
 *        
 */
class m_friends extends My_Model{

	const COLUMN_ID = 'frn_id' ;
	const COLUMN_ADMIN_ID = 'frn_admin_id' ;
	const COLUMN_NAME = 'frn_name' ;
	const COLUMN_ACTIVE = 'frn_active' ;
	
	protected $_table_name = 'friends';
	protected $_primary_key = 'frn_id';

	/**
	 * add group
	 * 
	 * @param int 		$admin_id 	User id
	 * @param string 	$name     	group name
	 */
	public function add_group($admin_id,$name)
	{
		$CI =& get_instance();
		$CI->load->model('m_member') ;
		$data = array(
			self::COLUMN_ADMIN_ID => $admin_id ,
			self::COLUMN_NAME => $name ,
			);

		$group_id = $this->save($data) ;
		$member_data = array(
				m_member::COLUMN_FRIENDS_ID => $group_id ,
				m_member::COLUMN_USER_ID => $admin_id ,
				m_member::COLUMN_LEVEL => m_member::LEVEL_ADMIN
			);
		$CI->m_member->save($member_data) ;
		return $group_id ;
	}

	/**
	 * check this user has created this group before or not
	 * 
	 * @param  int  	$admin_id 
	 * @param  string 	$name    
	 * @return boolean           
	 */
	public function group_exists($admin_id,$name)
	{
		$this->db->where(self::COLUMN_ADMIN_ID , $admin_id) ;
		$this->db->where(self::COLUMN_NAME , $name) ;

		$group = $this->get(NULL,TRUE) ;
		if($group != NULL)
			return $group->{self::COLUMN_ID} ;
		return NULL ;
	}

	/**
	 * return a list of group that this user is member of that
	 * @param  int 		$user_id 
	 * @return array          
	 */
	public function group_list($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('m_member') ;
		$this->db->join('member' , m_member::COLUMN_FRIENDS_ID . ' = ' . self::COLUMN_ID);
		$this->db->where(m_member::COLUMN_USER_ID , $user_id) ;
		$list = $this->get() ;
		$ar = array() ;
		foreach ($list as $group) {
			$ar[$group->{self::COLUMN_ID}] = $group->{self::COLUMN_NAME} ;
		}
		return $ar ;
	}

	/**
	 * check this user is admin of this group or not
	 * 
	 * @param  int  	$group_id 
	 * @param  int  	$user_id  
	 * @return boolean           
	 */
	public function is_admin($group_id,$user_id)
	{
		$this->db->where(self::COLUMN_ID , $group_id);
		$this->db->where(self::COLUMN_ADMIN_ID , $user_id);
		if($this->get(NULL,TRUE) != NULL)
			return TRUE ;
		return FALSE ;
	}

	
}

?>