<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_friends extends CI_Migration{

	public function up()
	{
		$prefix = "frn" ;
		$table_name = $this->db->dbprefix("friends");
		$user_prefix = "usr" ;
		$user_table = $this->db->dbprefix("user");
		$this->db->query(
				"CREATE TABLE {$table_name} (
				{$prefix}_id INT(13) NOT NULL AUTO_INCREMENT ,
				{$prefix}_admin_id INT(13) NOT NULL,
				{$prefix}_name VARCHAR(100) NOT NULL ,
				{$prefix}_active BOOLEAN DEFAULT TRUE,
				CONSTRAINT friends_pk PRIMARY KEY ({$prefix}_id) ,
				CONSTRAINT friends_fk_admin FOREIGN KEY ({$prefix}_admin_id) REFERENCES {$user_table} ({$user_prefix}_id) ON DELETE RESTRICT ON UPDATE CASCADE
				) ENGINE=INNODB
				  DEFAULT CHARSET = utf8  
				  DEFAULT COLLATE = utf8_unicode_ci
				  ;"
						);
	}

	public function down()
	{
		$this->dbforge->drop_table('friends');
	}

}