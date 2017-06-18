Buy Management
===
Information
---
* Problem number : 3
* Email : reza.smart306@gmail.com
* Programming Language : PHP
* Framework : Codeigniter
* Webservice method : XML-RPC

Requirements
---
1. PHP 5.4 or greater
2. MySql 5.1+
3. Apache 2.4+


Installation
---
1. write your database connection in `path/to/project/application/config/database.php`
	```php

	//path/to/project/application/config/database.php
	$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => '',
	'password' => '',
	'database' => '',

	```
2. Load migrate controller `http://localhost/path/to/project/public_html/migrate`
3. You should create api key in api table manually

User Documentaion 
---
I made a client version to test web service by load `http://path/to/project/public_html/client/test_api/signin`

