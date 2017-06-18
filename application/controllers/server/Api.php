<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
		$this->load->model('m_api');
		$this->load->model('m_friends');
		$this->load->model('m_member');
		$this->load->model('m_purchase');
		$this->load->model('m_payment');
	}

	public function index()
	{
		$this->load->library('xmlrpc');
		$this->load->library('xmlrpcs');

		
		$config['functions']['signin'] = array('function' => 'Api.signin');
		$config['functions']['signup'] = array('function' => 'Api.signup');
		$config['functions']['group_list'] = array('function' => 'Api.group_list');
		$config['functions']['create_group'] = array('function' => 'Api.create_group');
		$config['functions']['add_member'] = array('function' => 'Api.add_member');
		$config['functions']['member_list'] = array('function' => 'Api.member_list');
		$config['functions']['add_purchase'] = array('function' => 'Api.add_purchase');
		$config['functions']['pending_treats'] = array('function' => 'Api.pending_treats');
		$config['functions']['purchase_list'] = array('function' => 'Api.purchase_list');

		$this->xmlrpcs->initialize($config);
		// $this->xmlrpc->set_debug(TRUE);
	    $this->xmlrpcs->serve();
	}

	/**
	 * check user exists in site with this api or not
	 * 
	 * @param  string $parametr[0] 	API key
	 * @param  string $parametr[1] 	User Email
	 * @param  string $parametr[2] 	User Password
	 * @return boolean
	 */
	public function signin($request)
	{
		//prametrs = 0 -> api , 1 -> email , 2 -> password
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$email = $parameters[1] ;
		$password = $parameters[2] ;

		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}

		$user = $this->m_user->has_account($api_id,$email,$password) ;
		if($user != NULL)
		{
			$response = array(
                        array(
                                'email' => array($user->{m_user::COLUMN_EMAIL}, 'string'),
                                'name'  => array($user->{m_user::COLUMN_NAME}, 'string')
                        ),
                         'struct'
                );

		}
		else
		{
			return $this->xmlrpc->send_error_message(1, 'Email or pass is incorrect');

		}
		return $this->xmlrpc->send_response($response);

		
	}
	
	/**
	 * Sign up
	 *
	 * Sing up user in site
	 * 
	 * @param  string $parametr[0] 	API key
	 * @param  string $parametr[1] 	User Email
	 * @param  string $parametr[2] 	User Password
	 * @param  string $parametr[3] 	User Full Name
	 * @return boolean
	 */	
	public function signup($request)
	{
		//prametrs = 0 -> api , 1 -> email , 2 -> password
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$email = $parameters[1] ;
		$password = $parameters[2] ;
		$name = $parameters[3] ;


		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}

		if($this->m_user->user_exists($api_id,$email))
		{
			return $this->xmlrpc->send_error_message(2, 'This user has been created before');
		}

		if($this->m_user->add_user($api_id,$email,$password,$name) != NULL)
		{
			$response = array(TRUE,'boolean');			
			return $this->xmlrpc->send_response($response);
		}
		else
		{
			return $this->xmlrpc->send_error_message(100, 'Unknown Error');	
		}

	}

	/**
	 * group list
	 *
	 * return a list of group that this user is member of them
	 * 
	 * @param  string $parametr[0] 	API key
	 * @param  string $parametr[1] 	User Email
	 * @return struct          		group array
	 */
	public function group_list($request)
	{
		//prametrs = 0 -> api , 1 -> user_email
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$email = $parameters[1] ;



		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}

		$user_id = $this->m_user->user_exists($api_id,$email);
		if($user_id == NULL)
		{
			return $this->xmlrpc->send_error_message(3, 'User not exists');
		}

		$group_list = $this->m_friends->group_list($user_id) ;

		return $this->xmlrpc->send_response(array($group_list,'struct'));

	}

	/**
	 * create group 
	 * 
	 * @param  string $parametr[0] 	API key
	 * @param  string $parametr[1] 	User Email who make this group
	 * @param  string $parametr[2] 	Group name
	 * @return boolean          		
	 */
	public function create_group($request)
	{
		//prametrs = 0 -> api , 1 -> email , 2 -> group_name
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$email = $parameters[1] ;
		$group_name = $parameters[2] ;


		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}

		$admin_id = $this->m_user->user_exists($api_id,$email);
		if($admin_id == NULL)
		{
			return $this->xmlrpc->send_error_message(3, 'User not exists');
		}

		if($this->m_friends->group_exists($admin_id,$group_name))
		{
			return $this->xmlrpc->send_error_message(4, 'This group has been created before');
		}

		if($this->m_friends->add_group($admin_id,$group_name) != NULL)
		{
			$response = array(TRUE,'boolean');			
			return $this->xmlrpc->send_response($response);
		}
		else
		{
			return $this->xmlrpc->send_error_message(100, 'Unknown error');	
		}


	}
		
	/**
	 * check user exist in system or not
	 * 
	 * @param  string $parametr[0] 	API key
	 * @param  string $parametr[1] 	User Email
	 * @return string          		success message
	 */
	public function user_exists($request)
	{
		//prametrs = 0 -> api , 1 -> email 
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$email = $parameters[1] ;

		
		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}


		if($this->m_user->user_exists($api_id,$email))
		{
			$response = array(TRUE,'boolean');
		}
		else
		{
			$response = array(FALSE,'boolean');
		}
		return $this->xmlrpc->send_response($response);
	}

	/**
	 * add_member to group
	 *
	 * if member exsits in system 
	 * then only add to group if not 
	 * then frist sign up it and next added to group
	 * 
	 * @param  string $parametr[0] 	API key
	 * @param  string $parametr[1] 	Group Id
	 * @param  string $parametr[2] 	Admin Email // only admin can add user to group
	 * @param  string $parametr[2] 	User Email 
	 * @param  string $parametr[2] 	User password 
	 * @param  string $parametr[2] 	User full name
	 * @return string          		success response
	 */
	public function add_member($request)
	{
		//prametrs = 0 -> api , 1 -> group_id , 2 -> admin_email ,3->user_email,4->user_password,5->usr_fullname
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$group_id = $parameters[1] ;
		$admin_email = $parameters[2];
		$user_email = $parameters[3] ;
		$user_password = $parameters[4] ;
		$user_fullname = $parameters[5] ;

		
		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}

		$admin_id = $this->m_user->user_exists($api_id,$admin_email);
		if($admin_id == NULL)
		{
			return $this->xmlrpc->send_error_message(3, 'User not exists');
		}

		if(!$this->m_friends->is_admin($group_id,$admin_id))
		{
			return $this->xmlrpc->send_error_message(3, $admin_email . ' not admin and cant add new user');
		}

		$user_id = $this->m_user->user_exists($api_id,$user_email);
		if($user_id != NULL)
		{
			if($this->m_member->is_member($group_id,$user_id))
			{
				return $this->xmlrpc->send_error_message(1, 'User aleady is member of this group');
			}
			$this->m_member->add_member($group_id, $user_id) ;
			
			$response = array('User has been created before. only added to member list','string');
			return $this->xmlrpc->send_response($response);			
		}

		$user_id = $this->m_user->add_user($api_id,$user_email,$user_password,$user_fullname) ;
		$this->m_member->add_member($group_id, $user_id) ;

		$response = array('User created and added to your group','string');
		return $this->xmlrpc->send_response($response);
		
	}

	/**
	 * get member list of specific group
	 * 
	 * @param  string $parametr[0] 	API key
	 * @param  string $parametr[1] 	Group Id
	 * @param  string $parametr[2] 	User Email (Optional : if set return all member except this user)
	 * @return struct          		array of members
	 */
	public function member_list($request)
	{
		//prametrs = 0 -> api , 1 -> group_id
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$group_id = $parameters[1] ;
		if(isset($parameters[2]))
			$email = $parameters[2];
		else
			$email = NULL ;

		
		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}

		$member_list = $this->m_member->member_list($group_id,$email);
		$response = array($member_list,'struct');
		return $this->xmlrpc->send_response($response);

	}

	
	/**
	 * add purchse
	 *
	 * add purchase and deptors
	 * 
	 * @param  string 			$parametr[0] 	API key
	 * @param  string 			$parametr[1] 	Group ID
	 * @param  string 			$parametr[2] 	Buyer Email
	 * @param  string 			$parametr[3] 	title
	 * @param  string 			$parametr[4] 	Description
	 * @param  dateTime.iso8601 $parametr[5] 	Buy date
	 * @param  int 				$parametr[6] 	Price
	 * @param  struct 			$parametr[7] 	List of user that should pay their treat
	 * @return string          				   	success message
	 */
	public function add_purchase($request)
	{
		
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$group_id = $parameters[1] ;
		$buyer_email = $parameters[2] ;
		$title = $parameters[3] ;
		$description = $parameters[4] ;
		$date = $parameters[5] ;
		$price = $parameters[6] ;
		if(isset($parameters[7]))
			$deptors = $parameters[7] ;
		else
			$deptors = NULL ;

		
		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}
		
		$buyer_user_id = $this->m_user->user_exists($api_id,$buyer_email);
		if($buyer_user_id == NULL)
		{
			return $this->xmlrpc->send_error_message(3, 'User not exists');
		}

		$buyer_member_id = $this->m_member->is_member($group_id,$buyer_user_id) ;
		if($buyer_member_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Buyer is not member of group');
		}
		
		$purchase_id = $this->m_purchase->add_purchase($buyer_member_id,$title,$description,$price,$date,$deptors) ;
		if($purchase_id == NULL)
			return $this->xmlrpc->send_error_message(1, 'Transaction error');	
		//check email
		$response = array('purchase added to list','string');
		return $this->xmlrpc->send_response($response);
	}

	/**
	 * get all group purchase list
	 * @param  string $parametr[0]  API key
	 * @param  string $parametr[1] 	Group ID
	 * @return struct          	   	array of purchase
	 */
	public function purchase_list($request)
	{
		//parameters = 0 -> api_id , 1 -> group_id , 2 -> email
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$group_id = $parameters[1] ;
		
		
		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}
		
		$purchase_list = $this->m_purchase->purchase_list($group_id);
		$response = array($purchase_list,'struct');
		// var_dump($purchase_list);
		return $this->xmlrpc->send_response($response);
	}

	/**
	 * get all user pending treats
	 *
	 * return all purchase that user should pay his treat
	 * 
	 * @param  string $parametr[0]  API key
	 * @param  string $parametr[1] 	Group ID
	 * @param  string $parametr[2] 	Email of User
	 * @return struct          	   	array of pending treats
	 */
	public function pending_treats($request)
	{
		//parameters = 0 -> api_id , 1 -> group_id , 2 -> email
		$parameters = $request->output_parameters();
		$api_key = $parameters[0] ;
		$group_id = $parameters[1] ;
		$email = $parameters[2] ;

		$api_id = $this->m_api->has_access($api_key) ;
		if($api_id == NULL)
		{
			return $this->xmlrpc->send_error_message(1, 'Your Api Key is incorrect');
		}
		
		$user_id = $this->m_user->user_exists($api_id,$email);
		if($user_id == NULL)
		{
			return $this->xmlrpc->send_error_message(3, 'User not exists');
		}

		$member_id = $this->m_member->is_member($group_id,$user_id) ;
		if($member_id == NULL)
		{
			return $this->xmlrpc->send_error_message(5, 'This user is not a member of this group');	
		}
		$purchase_list = $this->m_payment->pending_treats($member_id);

		$response = array($purchase_list,'struct');
		// var_dump($purchase_list);
		return $this->xmlrpc->send_response($response);

	}

	

	



 }
