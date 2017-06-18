<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * user table model
 *        
 */
class m_user extends My_Model{

	const COLUMN_ID = 'usr_id' ;
	const COLUMN_EMAIL = 'usr_email' ;
	const COLUMN_NAME = 'usr_name' ;
	const COLUMN_PASSWORD = 'usr_password' ;
	const COLUMN_API_ID = 'usr_api_id' ;
	
	protected $_table_name = 'user';
	protected $_primary_key = 'usr_id';

	public function has_account($api_id,$email,$password)
	{
		$this->db->where(self::COLUMN_EMAIL, $email);
		$this->db->where(self::COLUMN_API_ID, $api_id);
		$this->db->where(self::COLUMN_PASSWORD, $this->hash($password));

		return $this->get(NULL, TRUE) ;
	}

	/**
	 * add salt and hash it
	 * @param  string $input 
	 * @return string        
	 */
	public function hash($input)
	{
		return md5($input . config_item('encryption_key'));
	}

	public function user_exists($api_id,$email)
	{
		$this->db->where(self::COLUMN_API_ID,$api_id);
		$this->db->where(self::COLUMN_EMAIL,$email);

		$user = $this->get(NULL,TRUE);
		if($user != NULL)
			return $user->{self::COLUMN_ID} ;
		return FALSE ;

	}

	public function add_user($api_id,$email,$password,$name)
	{
		$data = array(
			self::COLUMN_API_ID => $api_id ,
			self::COLUMN_EMAIL => $email ,
			self::COLUMN_PASSWORD => $this->hash($password) ,
			self::COLUMN_NAME => $name 
			);

		return $this->save($data) ;
	}

	
}

?>