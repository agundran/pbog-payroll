<?php

class Site extends CI_Controller 
{
	function _construct()
	{
		parent::CI_Controller();
		$this->is_logged_in();
	}
	
	function Administrators()
	{
		$this->load->helper('url');
		
		$data['Role']="Administrators";
		$data['Permission']="Admin";
				
		$this->load->view('pages/template/header',$data);
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/template/content',$data);
		$this->load->view('pages/template/footer',$data);
		///ADMIN		
	}
 

	function SuperAdmin()
	{
		$this->load->helper('url');
		
		$data['Role']="SuperAdmin";
		$data['Permission']="SuperAdmin";
				
		$this->load->view('pages/template/header',$data);
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/template/content',$data);
		$this->load->view('pages/template/footer',$data);
		///ADMIN		
	}
 
 
    function Execom()
	{
		$this->load->helper('url');
		
		$data['Role']="Execom";
		$data['Permission']="Execom";
				
		$this->load->view('pages/template/header',$data);
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/template/content',$data);
		$this->load->view('pages/template/footer',$data);
		///ADMIN		
	}

	function Operators()
	{
		$this->load->helper('url');
		
		$data['Role']="Operators";
		$data['Permission']="Operator";
		$this->load->view('pages/template/header',$data);
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/template/content',$data);
		$this->load->view('pages/template/footer',$data);
		///OPERATOR
	}
	
	function Applicant()
	{
		$this->load->helper('url');
		
		$data['Role']="Applicant";
		$data['Permission']="Applicant";
			
		$this->load->view('pages/template/header',$data);
		$this->load->view('pages/template/nav',$data);
		$this->load->view('pages/template/content-applicant',$data);
		$this->load->view('pages/template/footer',$data);
		///CABLESYSTEM
		
	}
	
	
	function another_page() // just for sample
	{
		echo 'good. you\'re logged in.';
	}
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';	
			die();		
			//$this->load->view('login_form');
		}		
	}	
	
	function logout()
	{
    $user_data = $this->session->all_userdata();
	
	   
	            $Username= $user_data['username'];
				
				$data = array(
				'LastActivityDate'=> date("Y-m-d H:i:s")
				);
                 
				$this->db->where('Username', $Username);
				$this->db->update('users', $data);  
                
				
				
	
        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->session->unset_userdata($key);
            }
        }
    $this->session->sess_destroy();
    redirect('default_controller');
	}

}
