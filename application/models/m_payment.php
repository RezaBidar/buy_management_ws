<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * payment table model
 *        
 */
class m_payment extends My_Model{

	const COLUMN_ID = 'pay_id' ;
	const COLUMN_MEMBER_ID = 'pay_member_id' ;
	const COLUMN_PURCHASE_ID = 'pay_purchase_id' ;
	const COLUMN_DEPTOR_TREAT = 'pay_deptor_treat' ;
	const COLUMN_CHECKOUT_DATE = 'pay_checkout_date' ;
	
	protected $_table_name = 'payment';
	protected $_primary_key = 'pay_id';

	public function add_deptor($purchase_id,$deptors)
	{
		$ar = array();
		foreach ($deptors as $member_id => $deptor_treat) 
		{
			$data = array(
				self::COLUMN_MEMBER_ID => $member_id ,
				self::COLUMN_PURCHASE_ID => $purchase_id ,
				self::COLUMN_DEPTOR_TREAT => $deptor_treat,
				);	
			array_push($ar,$data);
		}
		$this->db->insert_batch($this->_table_name,$ar) ;
	}


	public function pending_treats($member_id)
	{
		$this->db->join('purchase' , m_purchase::COLUMN_ID . ' = ' . self::COLUMN_PURCHASE_ID);
		$this->db->join('member' , m_member::COLUMN_ID . ' = ' . m_purchase::COLUMN_MEMBER_ID );
		$this->db->join('user' , m_user::COLUMN_ID . ' = ' . m_member::COLUMN_USER_ID);
		$this->db->where(self::COLUMN_MEMBER_ID , $member_id) ;
		$this->db->where(self::COLUMN_CHECKOUT_DATE . ' IS NULL' , NULL);
		$purchase_list = $this->get();
		$ar = array() ;
		// echo $this->db->last_query();
		// var_dump($purchase_list);
		foreach ($purchase_list as $purchase) 
		{
			$ar[$purchase->{m_purchase::COLUMN_ID}] = array(
				array(
					'title' => $purchase->{m_purchase::COLUMN_TITLE} ,
					'price' => $purchase->{m_purchase::COLUMN_PRICE} ,
					'buyer' => $purchase->{m_user::COLUMN_NAME} ,
					'treat' => $purchase->{self::COLUMN_DEPTOR_TREAT} ,
					'purchase_date' => $purchase->{m_purchase::COLUMN_DATE} ,
				)
				,'struct'
			);
		}
		return $ar ;
	}
	
}

?>