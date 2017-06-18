<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_Api extends CI_Controller{
	const API_KEY = 'apikey' ;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
        $server_url = site_url('server/api');
        $this->load->helper('form');
        $this->load->helper('btform');
        $this->lang->load('app') ;
        $this->load->library('session');
        $this->load->library('xmlrpc');

        $this->xmlrpc->server($server_url, 80);
        // $this->xmlrpc->set_debug(TRUE);
        $this->data = array(); 
        $this->data['c_data'] = array() ;

	}


	public function telegram()
	{
		
        	$this->xmlrpc->server('149.154.167.40', 443);
			$request = array('574c1449096ba24526362b0cda0ee854');
			$this->xmlrpc->method('messages.getStickerSet');
			$this->xmlrpc->request($request);

			if ( ! $this->xmlrpc->send_request())
	        {
	                var_dump($this->xmlrpc->display_error());
	        }
	        else
	        {
	        		var_dump($this->xmlrpc->display_response()) ;
	                
	        }
	}

	public function signin()
	{
		if(isset($_POST['submit']))
		{

			$request = array(self::API_KEY,$_POST['email'],$_POST['password']);
			$this->xmlrpc->method('signin');
			$this->xmlrpc->request($request);

			if ( ! $this->xmlrpc->send_request())
	        {
	                $this->session->set_flashdata('error', $this->xmlrpc->display_error());
	        }
	        else
	        {
	        		$result = $this->xmlrpc->display_response() ;
	        		// var_dump($result) ;
                	$session_data = array(
						"email" => $result['email'],
						"name" => $result['name'],
						"logged_in" => TRUE ,
					);
					$this->session->set_userdata($session_data);
					redirect('client/test_api/group_list') ;
	                
	        }
		}

		$this->data['content_view'] = 'client_test/signin' ;
		$this->load->view('client_test/layout', $this->data);
	}

	public function signout()
	{
		$session_data = array('email', 'logged_in');
		$this->session->unset_userdata($session_data);
		redirect('client/test_api/signin');
	}

	public function signup(){

		if(isset($_POST['submit']))
		{
			$request = array(self::API_KEY,$_POST['email'],$_POST['password'],$_POST['name']);
			$this->xmlrpc->method('signup');
			$this->xmlrpc->request($request);

			if ( ! $this->xmlrpc->send_request())
	        {
	                $this->session->set_flashdata('error', $this->xmlrpc->display_error());
	        }
	        else
	        {
	        		redirect('client/test_api/signin');
	                
	        }
			
		}

		$this->data['content_view'] = 'client_test/signup' ;
		$this->load->view('client_test/layout', $this->data);
	}
	public function group_list()
	{

		$request = array(self::API_KEY,$this->session->userdata('email'));
		$this->xmlrpc->method('group_list');
		$this->xmlrpc->request($request);
        $this->data['c_data']['group_list'] = array() ;

		if ( ! $this->xmlrpc->send_request())
        {
                $this->session->set_flashdata('error', $this->xmlrpc->display_error());
        }
        else
        {
			$this->data['c_data']['group_list'] = $this->xmlrpc->display_response() ;        	
        }
		$this->data['content_view'] = 'client_test/group_list' ;
		$this->load->view('client_test/layout', $this->data);	
	}
	public function add_group()
	{
		if(isset($_POST['submit']))
		{
			$request = array(self::API_KEY,$this->session->userdata('email'),$_POST['name']);
			$this->xmlrpc->method('create_group');
			$this->xmlrpc->request($request);

			if ( ! $this->xmlrpc->send_request())
	        {
	            $this->session->set_flashdata('error', $this->xmlrpc->display_error());
	        }
	        else
	        {
				redirect('client/test_api/group_list/');
	        }	
		}
		$this->data['content_view'] = 'client_test/add_group' ;
		$this->load->view('client_test/layout', $this->data);	

	}

	public function purchase_list($group_id = '')
	{
		if($group_id =='') die('group_id is required');

		$request = array(self::API_KEY,$group_id,$this->session->userdata('email'));
        $this->data['c_data']['purchase_list'] = array() ;
        $this->data['c_data']['pending_treats'] = array() ;
        $this->data['c_data']['member_list'] = array() ;

		$this->xmlrpc->method('pending_treats');
		$this->xmlrpc->request($request);
		if ($this->xmlrpc->send_request())
        	$this->data['c_data']['pending_treats'] = $this->xmlrpc->display_response() ;

        $request = array(self::API_KEY,$group_id);
        $this->xmlrpc->method('purchase_list');
		$this->xmlrpc->request($request);
		if ($this->xmlrpc->send_request())
        	$this->data['c_data']['purchase_list'] = $this->xmlrpc->display_response() ;
        
        $request = array(self::API_KEY,$group_id);
        $this->xmlrpc->method('member_list');
		$this->xmlrpc->request($request);
		if ($this->xmlrpc->send_request())
        	$this->data['c_data']['member_list'] = $this->xmlrpc->display_response() ;
        
        

		
		$this->data['content_view'] = 'client_test/purchase_list' ;
		$this->load->view('client_test/layout', $this->data);			
	}

	
	public function add_member($group_id = '')
	{
		if($group_id == '')
			die('Group id is required') ;
		if(isset($_POST['submit']))
		{
			$request = array(
				self::API_KEY,
				$group_id ,
				$this->session->userdata('email'),
				$_POST['email'],
				$_POST['password'] ,
				$_POST['name'] ,
				);
			$this->xmlrpc->method('add_member');
			$this->xmlrpc->request($request);

			if ( ! $this->xmlrpc->send_request())
	        {
	                $this->session->set_flashdata('error', $this->xmlrpc->display_error());
	        }
	        else
	        {
	        		$this->session->set_flashdata('success', $this->xmlrpc->display_response());
	        }
		}

		$this->data['content_view'] = 'client_test/add_member' ;
		$this->load->view('client_test/layout', $this->data);				
	}
	public function add_purchase($group_id)
	{
		
		if($group_id == '')
			die('Group Id is required') ;
		

		// get member list
		$this->xmlrpc->method('member_list');
		$this->xmlrpc->request(array(self::API_KEY,$group_id,$this->session->userdata('email')));
		$this->data['c_data']['member_list'] = array();
		// $this->xmlrpc->set_debug(TRUE);
		if ($this->xmlrpc->send_request())
        	$this->data['c_data']['member_list'] = $this->xmlrpc->display_response() ;
        
		if(isset($_POST['submit']))
		{
			
			$deptors = array();
			foreach ($this->data['c_data']['member_list'] as $member_id => $name) 
			{
				if(isset($_POST['deptor-'.$member_id]) && !empty($_POST['deptor-'.$member_id]))
					$deptors[$member_id] = $_POST['deptor-'.$member_id] ;
			}
			
			$date = (new DateTime())->format('c') ;
			$title = $_POST['title'];
			$description = $_POST['description'] ;
			$price = $_POST['price'] ;
			
			// $this->xmlrpc->set_debug(TRUE);
			$this->xmlrpc->method('add_purchase');

			$request = array(
					array(self::API_KEY, 'string'),
					array($group_id, 'string'),
					array($this->session->userdata('email'), 'string'),
			        array($title, 'string'),
			        array($description, 'string'),
			        array($date, 'dateTime.iso8601'),
			        array($price, 'int'),        
			);
			if(sizeof($deptors))
				array_push($request, array($deptors, 'struct'));
			
			$this->xmlrpc->request($request);
			if (!$this->xmlrpc->send_request())
	        	$this->session->set_flashdata('error', $this->xmlrpc->display_error());
	       	else
	       		$this->session->set_flashdata('success', $this->xmlrpc->display_response());

		}

		$this->data['content_view'] = 'client_test/add_purchase' ;
		$this->load->view('client_test/layout', $this->data);
	}

	public function pay_treat($purchase_id)
	{
		
	}

	



 }
