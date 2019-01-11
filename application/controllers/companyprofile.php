<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once("system/core/Common.php");
class Companyprofile extends CI_Controller
{
    

    private $id='1001';

	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('companyprofilemodel','',TRUE);
		$this->is_logged_in();
 	}
	 
	 function is_logged_in()
	{
	$is_logged_in = $this->session->userdata('is_logged_in');
	
	if(!isset($is_logged_in) || $is_logged_in != true){
		echo 'you don\'t have permission to access this page. <a href="pages/login">Login</a>';
		die();
		}	
	}
	function get_discount($Cinput)	{
			$limit = $Cinput;
	        echo json_encode($limit);
			  
			}
	
	function index()
	{
		$id = '1001';
			// set common properties
            $data['title'] = 'Company Profile';
            $this->load->library('form_validation');
        
       // set validation properties
            $this->_set_rules_edit();
            $data['action'] = ('companyprofile/index/'.$id);
        
       // run validation
            if ($this->form_validation->run() === FALSE){
           
            $data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
            $data['message'] = '';
           
            


           }else{
        
       // save data
            //$id = $this->input->post('id');
           $data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
            
           
           
           //$id = $data['Users']['Username'];
           $id = $data['Users']['co_id'];
           
               $User1 = array(
                       'co_name' => $this->input->post('co_name'),
                       'nature_business' => $this->input->post('nature_business'),
                       'address1' => $this->input->post('address1'),
                       'address2' => $this->input->post('address2'),
                       'zip_code' => $this->input->post('zip_code'),
                       'rdo' => $this->input->post('rdo'),
                       'email' => $this->input->post('email'),
                       'phones' => $this->input->post('phones'),
                       'fax' => $this->input->post('fax'),
                       'tin_no' => $this->input->post('tin_no'),
                       'sss_no' => $this->input->post('sss_no'),
                       'philhealth_no' => $this->input->post('philhealth_no'),
                       'hdmf_no' => $this->input->post('hdmf_no'),
                       

                   );
                      
                 
                
           
           //var_dump($User);
            $this->companyprofilemodel->update($id,$User1);
            $data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
             
           
             
            // set user message
            $data['title'] = 'Company Profile has been Update';
           
		   }
		   

		   $data['Role']=$this->session->userdata('role');

		  

       // load view//
                $data['Role']=$this->session->userdata('role');
               $this->load->view('pages/template/header');
               
               $this->load->view('pages/template/nav', $data);
			   
			   //access control 
			   
			   if (($data['Role'] == "Administrators") || ($data['Role'] == "Execom") || ($data['Role'] == "SuperAdmin")){
			 			 
			   $this->load->view('pages/template/co_profile_content', $data);
			   } else {

				$this->load->view('pages/unauth_view', $data);
			   }  
			
			   $this->load->view('pages/template/footer');
	 
	}
	 
		
		
	function update()
	{
		$id = '1001';
			// set common properties
            $data['title'] = 'Company Profile';
            $this->load->library('form_validation');
        
       // set validation properties
            $this->_set_rules_edit();
            $data['action'] = ('companyprofile/index/'.$id);
        
       // run validation
            if ($this->form_validation->run() === FALSE){
           
            $data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
            $data['message'] = '';
           
            


           }else{
        
       // save data
            //$id = $this->input->post('id');
           $data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
            
           
           
           //$id = $data['Users']['Username'];
           $id = $data['Users']['co_id'];
           
               $User1 = array(
                       'co_name' => $this->input->post('co_name'),
                       'nature_business' => $this->input->post('nature_business'),
                       'address1' => $this->input->post('address1'),
                       'address2' => $this->input->post('address2'),
                       'zip_code' => $this->input->post('zip_code'),
                       'rdo' => $this->input->post('rdo'),
                       'email' => $this->input->post('email'),
                       'phones' => $this->input->post('phones'),
                       'fax' => $this->input->post('fax'),
                       'tin_no' => $this->input->post('tin_no'),
                       'sss_no' => $this->input->post('sss_no'),
                       'philhealth_no' => $this->input->post('philhealth_no'),
                       'hdmf_no' => $this->input->post('hdmf_no'),
                       

                   );
                      
                 
                
           
           //var_dump($User);
            $this->companyprofilemodel->update($id,$User1);
            $data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
             
           
             
            // set user message
			$data['title'] = 'Company Profile has been Update';
			
           
           }
            ///$data['link_back'] = anchor('companyprofile/index/','Cancel Update',array('class'=>'back'));
        
       // load view//
                $data['Role']=$this->session->userdata('role');
               $this->load->view('pages/template/header');
               
               $this->load->view('pages/template/nav', $data);
               $this->load->view('pages/companyprofile_view', $data);
           	$this->load->view('pages/template/footer');
	 
	}
           

	
	

	 
    

	function show($id){
	 
	// set common properties
	 	$data['title'] = 'COmpany Profile';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules_edit();
	 	$data['action'] = ('companyprofile/show/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
		 $data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
		// $data['employee_details'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
		 
	 	//$data['Users']['Password'] = $this->companyprofilemodel->decryptIt($data['Users']['Password']) ;
	 	//$data['title'] = 'Employee Number: '. $data['employee']['last_name'] ;
	 	$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
	 	
		
		
		//$id = $data['Users']['Username'];
		$id = $data['Users']['companyprofile_id'];
		
			$User1 = array(
	 			                    
                    'companyprofile_id' => $this->input->post('companyprofile_id'),
                    'type' => $this->input->post('type'),
                    'rate' => $this->input->post('rate'),
                    'OT' => $this->input->post('OT'),
                    'ND' => $this->input->post('ND'),
                );
                   

	 		
		
		//var_dump($User);
	 	$this->companyprofilemodel->update($id,$User1);
	 	$data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
	      
		
		  
	 	// set user message
	 	$data['title'] = 'Overtime Type : '. $data['Users']['type'] .' has been Update';
		
		}
	 	///$data['link_back'] = anchor('companyprofile/index/','Cancel Update',array('class'=>'back'));
	 
	// load view//
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header2');
			
			//$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/companyprofile_view', $data);
		//	$this->load->view('pages/template/footer');
	}
	 



	function delete($id){
	 $data['Users'] = (array)$this->companyprofilemodel->get_by_id($id)->row();
	 $id = $data['Users']['companyprofile_id'];
	 
		
	 // delete user
	 	$this->companyprofilemodel->delete($id, $id2);
	 	
	// redirect to Student list page
	 	redirect('companyprofile/index/delete_success','Refresh');
	 	}
 
	// validation rules
	 
	function _set_rules(){
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
		$this->form_validation->set_rules('Operator', 'operator');
	//		$this->form_validation->set_rules('employee_no', 'employee_no', 'required|min_length[4]|max_length[20]|is_unique[employee.employee_no]');
	//		$this->form_validation->set_rules('Password', 'Password', 'trim|min_length[4]|max_length[32]');
	//		$this->form_validation->set_rules('Email', 'Email Address', 'trim|valid_email');
			
	 	}
	 
	 	function _set_rules_edit(){
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
			$this->form_validation->set_rules('Operator', 'operator');
			//$this->form_validation->set_rules('employee_no', 'employee_no', 'required|min_length[4]|max_length[20]|is_unique[employee.employee_no]');
	
	
			//$this->form_validation->set_rules('Username', 'Username', 'required|min_length[4]|max_length[20]|is_unique[users.Username]');
	//		$this->form_validation->set_rules('Password', 'Password', 'trim|min_length[4]|max_length[32]');
	//		$this->form_validation->set_rules('Email', 'Email Address', 'trim|valid_email');
			
	 	}
	 
	// date_validation callback
	 
	function valid_date($str)
	{
	 	if(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $str))
	 	{
	 		$this->form_validation->set_message('valid_date', 'date format is not valid. yyyy-mm-dd');
	 		return false;
	 	}
	 	else
	 	{
	 	return true;
	 	}
	 }
	 
	 
	
	
	} 

?>