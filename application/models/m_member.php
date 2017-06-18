<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * member table model
 *        
 */
class m_member extends My_Model{

	const COLUMN_ID = 'mbr_id' ;
	const COLUMN_USER_ID = 'mbr_user_id' ;
	const COLUMN_FRIENDS_ID = 'mbr_friends_id' ;
	const COLUMN_LEVEL = 'mbr_level' ;
	const COLUMN_ACTIVE = 'mbr_active' ;
	
	const LEVEL_ADMIN = '1' ;
	const LEVEL_MEMBER = '0' ;

	protected $_table_name = 'member';
	protected $_primary_key = 'mbr_id';

	/**
	 * check this user is member of this group or not
	 * 
	 * @param  int  	$group_id 
	 * @param  int  	$user_id  
	 * @return boolean           
	 */
	public function is_member($group_id,$user_id)
	{
		$this->db->where(self::COLUMN_FRIENDS_ID , $group_id);
		$this->db->where(self::COLUMN_USER_ID , $user_id);
		$this->db->where(self::COLUMN_ACTIVE , TRUE) ;
		$member = $this->get(NULL,TRUE) ;
		if($member != NULL)
			return $member->{self::COLUMN_ID} ;
		return NULL ;
	}

	public function add_member($group_id,$user_id)
	{
		$data = array(
				self::COLUMN_FRIENDS_ID => $group_id ,
				self::COLUMN_USER_ID => $user_id 
			);
		$member = $this->get_by($data,TRUE);
		if($member != NULL)
		{
			if(!$member->{self::COLUMN_ACTIVE})
			{
				$data[self::COLUMN_ACTIVE] = TRUE ;
				$this->save($data,$member->{self::COLUMN_ID});
				return $memeber->{self::COLUMN_ID} ;
			}
		}
		else
		{
			$data[self::COLUMN_ACTIVE] = TRUE ;
			return $this->save($data);	
		}
		return NULL ;
	}

	public function member_list($group_id,$email = NULL)
	{
		$this->db->join('user', m_user::COLUMN_ID . ' = ' . self::COLUMN_USER_ID);
		$this->db->where(self::COLUMN_FRIENDS_ID , $group_id ) ;
		if($email != NULL)
			$this->db->where(m_user::COLUMN_EMAIL . ' != ' , $email) ;
		$member_list = $this->get();
		$ar = array();
		foreach ($member_list as $member) 
		{
			$ar[$member->{self::COLUMN_ID}] = $member->{m_user::COLUMN_NAME} ;
		}
		return $ar ;
	}

	
}

?>