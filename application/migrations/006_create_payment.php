<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_payment extends CI_Migration{

	public function up()
	{
		$prefix = "pay" ;
		$table_name = $this->db->dbprefix("payment");
		$member_prefix = "mbr" ;
		$member_table = $this->db->dbprefix("member");
		$purchase_prefix = "prc" ;
		$purchase_table = $this->db->dbprefix("purchase");
		$this->db->query(
				"CREATE TABLE {$table_name} (
				{$prefix}_id INT(13) NOT NULL AUTO_INCREMENT ,
				{$prefix}_member_id INT(13) NOT NULL,
				{$prefix}_purchase_id INT(13) NOT NULL,
				{$prefix}_deptor_treat INT(13) NOT NULL,
				{$prefix}_checkout_date DATETIME NULL,
				CONSTRAINT payment_pk PRIMARY KEY ({$prefix}_id) ,
				CONSTRAINT payment_fk_member FOREIGN KEY ({$prefix}_member_id) REFERENCES {$member_table} ({$member_prefix}_id) ON DELETE RESTRICT ON UPDATE CASCADE  ,
				CONSTRAINT payment_fk_purchase FOREIGN KEY ({$prefix}_purchase_id) REFERENCES {$purchase_table} ({$purchase_prefix}_id) ON DELETE RESTRICT ON UPDATE CASCADE  
				) ENGINE=INNODB
				  DEFAULT CHARSET = utf8  
				  DEFAULT COLLATE = utf8_unicode_ci
				  ;"
						);
	}

	public function down()
	{
		$this->dbforge->drop_table('payment');
	}

}