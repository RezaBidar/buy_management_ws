<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * api table model
 *        
 */
class m_api extends My_Model{

	const COLUMN_ID = 'api_id' ;
	const COLUMN_SECRET_KEY = 'api_key' ;
	
	protected $_table_name = 'api';
	protected $_primary_key = 'api_id';


	/**
	 * generate random key for secret and sit key
	 * @return string md5 hash key
	 */
	public function generate_key()
	{
		$CI =& get_instance();
		$CI->load->helper('string') ;
		return random_string('unique') ;
	}

	/**
	 * check this api exists or not
	 * @param  string  $api_key 
	 * @return boolean          
	 */
	public function has_access($api_key)
	{
		$this->db->where(self::COLUMN_SECRET_KEY , $api_key) ;
		$api = $this->get(NULL,TRUE);
		if($api != NULL)
			return $api->{self::COLUMN_ID} ;
		return FALSE ;
	}

	

	
}

?>