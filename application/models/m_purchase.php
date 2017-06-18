<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * purchase table model
 *        
 */
class m_purchase extends My_Model{

	const COLUMN_ID = 'prc_id' ;
	const COLUMN_MEMBER_ID = 'prc_member_id' ;
	const COLUMN_TITLE = 'prc_title' ;
	const COLUMN_DESCRIPTION = 'prc_description' ;
	const COLUMN_PRICE = 'prc_price' ;
	const COLUMN_DATE = 'prc_date' ;

	
	protected $_table_name = 'purchase';
	protected $_primary_key = 'prc_id';

	public function purchase_list($group_id)
	{
		$this->db->join('member' , m_member::COLUMN_ID . ' = ' . self::COLUMN_MEMBER_ID) ;
		$this->db->join('user' , m_user::COLUMN_ID . ' = ' . m_member::COLUMN_USER_ID ) ;
		$this->db->where(m_member::COLUMN_FRIENDS_ID , $group_id) ;

		$purchase_list = $this->get();
		$ar = array() ;
		foreach ($purchase_list as $purchase) 
		{
			$ar[$purchase->{m_purchase::COLUMN_ID}] = array(
				array(
					'title' => $purchase->{m_purchase::COLUMN_TITLE} ,
					'price' => $purchase->{m_purchase::COLUMN_PRICE} ,
					'buyer' => $purchase->{m_user::COLUMN_NAME} ,
					'purchase_date' => $purchase->{m_purchase::COLUMN_DATE} ,
				)
				,'struct'
			);
		}
		return $ar ;
		
	}

	public function add_purchase($buyer_member_id,$title,$description,$price,$date,$deptors = NULL)
	{
		$data = array(
				self::COLUMN_MEMBER_ID => $buyer_member_id ,
				self::COLUMN_TITLE => $title ,
				self::COLUMN_DESCRIPTION => $description ,
				self::COLUMN_PRICE => $price ,
				self::COLUMN_DATE => $date
			);
		$this->db->trans_start();
		$purchase_id = $this->save($data) ;
		if($deptors != NULL)
			$this->m_payment->add_deptor($purchase_id,$deptors) ;
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
			return NULL ;
		return $purchase_id ;
	}
	
}

?>