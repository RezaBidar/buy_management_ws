<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_member extends CI_Migration{

	public function up()
	{
		$prefix = "mbr" ;
		$table_name = $this->db->dbprefix("member");
		$friends_prefix = "frn" ;
		$friends_table = $this->db->dbprefix("friends");
		$user_prefix = "usr" ;
		$user_table = $this->db->dbprefix("user");
		//level -> admin -> 1 , member -> 0 
		$this->db->query(
				"CREATE TABLE {$table_name} (
				{$prefix}_id INT(13) NOT NULL AUTO_INCREMENT ,
				{$prefix}_user_id INT(13) NOT NULL,
				{$prefix}_friends_id INT(13) NOT NULL,
				{$prefix}_level TINYINT(1) NOT NULL DEFAULT 0,
				{$prefix}_active BOOLEAN DEFAULT TRUE,
				CONSTRAINT member_pk PRIMARY KEY ({$prefix}_id) ,
				CONSTRAINT member_fk_user FOREIGN KEY ({$prefix}_user_id) REFERENCES {$user_table} ({$user_prefix}_id) ON DELETE RESTRICT ON UPDATE CASCADE ,
				CONSTRAINT member_fk_admin FOREIGN KEY ({$prefix}_friends_id) REFERENCES {$friends_table} ({$friends_prefix}_id) ON DELETE RESTRICT ON UPDATE CASCADE
				) ENGINE=INNODB
				  DEFAULT CHARSET = utf8  
				  DEFAULT COLLATE = utf8_unicode_ci
				  ;"
						);
	}

	public function down()
	{
		$this->dbforge->drop_table('member');
	}

}