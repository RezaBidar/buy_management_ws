<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_api extends CI_Migration{

	public function up()
	{
		$prefix = "api" ;
		$table_name = $this->db->dbprefix("api");
		$this->db->query(
				"CREATE TABLE {$table_name} (
				{$prefix}_id INT(13) NOT NULL AUTO_INCREMENT ,
				{$prefix}_key VARCHAR(32) NOT NULL ,
				CONSTRAINT api_pk PRIMARY KEY ({$prefix}_id) ,
				UNIQUE ({$prefix}_key) 
				) ENGINE=INNODB
				  DEFAULT CHARSET = utf8  
				  DEFAULT COLLATE = utf8_unicode_ci
				  ;"
						);
	}

	public function down()
	{
		$this->dbforge->drop_table('api');
	}

}