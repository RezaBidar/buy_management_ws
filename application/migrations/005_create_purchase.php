<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_purchase extends CI_Migration{

	public function up()
	{
		$prefix = "prc" ;
		$table_name = $this->db->dbprefix("purchase");
		$member_prefix = "mbr" ;
		$member_table = $this->db->dbprefix("member");
		$this->db->query(
				"CREATE TABLE {$table_name} (
				{$prefix}_id INT(13) NOT NULL AUTO_INCREMENT ,
				{$prefix}_member_id INT(13) NOT NULL,
				{$prefix}_title VARCHAR(100) NOT NULL,
				{$prefix}_description TEXT NOT NULL,
				{$prefix}_price INT(13) NULL,
				{$prefix}_date DATETIME NOT NULL,
				CONSTRAINT purchase_pk PRIMARY KEY ({$prefix}_id) ,
				CONSTRAINT purchase_fk_member FOREIGN KEY ({$prefix}_member_id) REFERENCES {$member_table} ({$member_prefix}_id) ON DELETE RESTRICT ON UPDATE CASCADE 
				) ENGINE=INNODB
				  DEFAULT CHARSET = utf8  
				  DEFAULT COLLATE = utf8_unicode_ci
				  ;"
						);
	}

	public function down()
	{
		$this->dbforge->drop_table('purchase');
	}

}