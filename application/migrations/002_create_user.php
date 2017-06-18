<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_user extends CI_Migration{

	public function up()
	{
		$prefix = "usr" ;
		$table_name = $this->db->dbprefix("user");
		$api_prefix = "api" ;
		$api_table = $this->db->dbprefix("api");
		$this->db->query(
				"CREATE TABLE {$table_name} (
				{$prefix}_id INT(13) NOT NULL AUTO_INCREMENT ,
				{$prefix}_email VARCHAR(100) NOT NULL ,
				{$prefix}_name VARCHAR(100) NOT NULL ,
				{$prefix}_password VARCHAR(32) NOT NULL ,
				{$prefix}_api_id INT(13) NOT NULL ,
				CONSTRAINT user_pk PRIMARY KEY ({$prefix}_id) ,
				INDEX ({$prefix}_email) ,
				CONSTRAINT user_fk_api FOREIGN KEY ({$prefix}_api_id) REFERENCES {$api_table} ({$api_prefix}_id) ON DELETE RESTRICT ON UPDATE CASCADE
				) ENGINE=INNODB
				  DEFAULT CHARSET = utf8  
				  DEFAULT COLLATE = utf8_unicode_ci
				  ;"
						);
	}

	public function down()
	{
		$this->dbforge->drop_table('user');
	}

}