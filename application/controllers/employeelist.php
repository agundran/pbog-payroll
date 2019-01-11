<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once("system/core/Common.php");

class Employeelist extends CI_Controller
{
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('employeelistmodel','',TRUE);
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
	
	function index($offset = 0, $order_column = 'last_name', $order_type = 'asc')
	{
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'last_name';
		if (empty($order_type)) $order_type = 'asc';
		
		$filter  = $this->input->post('ShortName');
		$limit =  150;

		
		//TODO: check for valid column
		// load data
		$Users = $this->employeelistmodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
		
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/employeelist/index');
		$config['total_rows'] = $this->employeelistmodel->count_all();
		
		if(isset($post['sel']) && !empty($post['sel']))
                $config['per_page'] = $post['sel'];
                else
                $config['per_page'] = 10;
				
		$config['per_page'] =$limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['title'] = "EMPLOYEES";
		$data['print_them'] = site_url('/employeelist/print_user');
		
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		anchor('employeelist/index/'.$offset.'/employee_no/'.$new_order, 'Employee No'),
		anchor('employeelist/index/'.$offset.'/last_name/'.$new_order, 'Last Name'),
		anchor('employeelist/index/'.$offset.'/first_name/'.$new_order, 'First Name'),
		anchor('employeelist/index/'.$offset.'/position/'.$new_order, 'Position'),
		anchor('employeelist/index/'.$offset.'/status/'.$new_order, 'Status'),
		anchor('employeelist/index/'.$offset.'/type/'.$new_order, 'Employment Type'),'','Actions','');
	 
	 	$upd = array(
              'width'      => '800',
              'height'     => '800',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	 	
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			$Users->employee_no,
			$Users->last_name,			
			$Users->first_name,
        	$Users->position,
			$Users->status,
			$Users->type,

			
		anchor_popup('employeelist/update/'.$Users->employee_no,'Update',array('class'=>'update'), $upd),
		anchor_popup('employeelist/paydetails/'.$Users->employee_no.'/'.$Users->last_name.'/'.$Users->first_name,'Pay Details',array('class'=>'paydetails'), $upd),
		anchor('employeelist/delete/'.$Users->employee_no,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to delete?')"
		
		))
		
		);
		}
	 
		$data['table'] = $this->table->generate();
	
		if ($this->uri->segment(3)=='delete_success')
			$data['message'] = 'The Data was successfully deleted';
		else if ($this->uri->segment(3)=='add_success')
			$data['message'] = 'The Data has been successfully added';
		else if ($this->uri->segment(3)=='update_success')
			$data['message'] = 'The Data has been successfully updated';
		else
		$data['message'] = '';
	 
		// load view
	 	$data['Role']=$this->session->userdata('role');
		
		$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		$data['print_me'] = anchor_popup('/employeelist/print_user/','Print Employee List',array('class'=>'print_hello_world'),$atts);
		
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
 
		// access control script
		if  (($data['Role'] == "Administrators")  || ($data['Role'] == "SuperAdmin") || ($data['Role'] == "Execom") )	{
		 	 $this->load->view('pages/employeelist_view', $data);
			} else {
			$this->load->view('pages/unauth_view', $data);
		}

		$this->load->view('pages/template/footer');
	 
	}
	 
		
	function new_employee()
	{
	$data['title'] = 'Add New Employee';
	$data['action'] = site_url('employeelist/new_employee');
	$data['link_back'] = anchor('/employeelist/index/','Back to list of Users',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new Employee';
			$data['message'] = '';
			
			
			$data['employee']['employee_no']='';
			$data['employee']['last_name']='';
			$data['employee']['first_name']='';
			$data['employee']['last_name']='';
			$data['employee']['middle_name']='';
			$data['employee']['position']='';
			$data['employee']['department']='';
			$data['employee']['status']='';
			$data['employee']['type']='';
			$data['employee']['date_hire']='';
			$data['employee']['bank_name']='';
			$data['employee']['bank_accnt_no']='';

			$data['employee']['philhealth']='';
			$data['employee']['sss']='';
			$data['employee']['hdmf']='';
			$data['employee']['tin']='';
						
			
			
				$data['employee_details']['basic_salary']='';
				$data['employee_details']['de_minimis_non']='';
				$data['employee_details']['de_minimis_taxable']='';
			
			
			



			$data['link_back'] = anchor('employeeaddlist/index/','See List Of Users',array('class'=>'back'));
			
			
			$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header2');
			$this->load->view('pages/employeeaddlist_view', $data);
		
		
		}else{
		
			// save data
			$employee_no = $this->input->post('employee_no');
			$last_name = $this->input->post('last_name');
			$first_name = $this->input->post('first_name');
			$middle_name = $this->input->post('middle_name');
			$position = $this->input->post('position');
			$department = $this->input->post('department');
			$status = $this->input->post('status');
			$type = $this->input->post('type');
			$date_hire = $this->input->post('date_hire');

			$bank_name = $this->input->post('bank_name');
			$bank_accnt_no = $this->input->post('bank_accnt_no');

			$philhealth = $this->input->post('philhealth');

			$sss = $this->input->post('sss');
			$hdmf = $this->input->post('hdmf');
			$tin = $this->input->post('tin');

			$basic_salary = $this->input->post('basic_salary');
			$de_minimis_non = $this->input->post('de_minimis_non');
			$de_minimis_taxable = $this->input->post('de_minimis_taxable');



			$sss_contri =  $this->employeelistmodel->get_sss_contri($basic_salary);
			$philhealth_contri = $this->employeelistmodel->compute_philhealth($basic_salary);
			
			$daily_rate_div = $this->employeelistmodel->get_daily_rate_div();  
			$hourly_rate_div = $this->employeelistmodel->get_hourly_rate_div(); 
            $hdmf_rate = $this->employeelistmodel->get_hdmf_rate(); 

			$daily_rate =  $basic_salary / $daily_rate_div ;
			$hourly_rate = $daily_rate / $hourly_rate_div;
			$hdmf_contri = $hdmf_rate;
			//$other_deduc = 0;
			
			/*
			if ($type == 'Direct Employment'  || $type == 'Contractual'  ) {
			$net_taxable = $basic_salary - ($sss_contri + $philhealth_contri + $hdmf_contri + $other_deduc);
			
			} else {

			$net_taxable = $basic_salary;

			} */

            $Rolename = 'Operators';
			$Operator = 'pboglobal';
			$Username = $this->input->post('Username');
			$Password = $this->input->post('Password');
			$Email = $this->input->post('Email'); 
			

			$id = $this->employeelistmodel->add_new_employee($employee_no, $last_name, $first_name, $middle_name, $position, $department, $status,$type, $date_hire, $bank_name, $bank_accnt_no, $philhealth, $sss, $hdmf, $tin, $basic_salary,$de_minimis_non, $de_minimis_taxable,  $sss_contri, $philhealth_contri, $hdmf_contri, $daily_rate, $hourly_rate);

			// set form input name="id"
			//$this->validation->id = $id;
			
			$id = $this->employeelistmodel->create_user($employee_no, $Rolename, $Operator, $Username, $Password, $Email);


		         
		
			//redirect('manageuserlist/index/add_success','Refresh');
		 $message = "New User Added Successfully";

		 //redirect('employeelist/index', 'refresh');

   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
				   window.close ();
				   
        		</script>';
				}	

					
		}
	}


	function employee_no_check($str){
		
		$this->db->select('employee_no');
		$this->db->from('employee');
		$str1 = $this->db->get();
		
			if($str1 == $str)
			{
			$this->form_validation->set_message('Username already exist!');
			return false;
			}
			else
			{
				return true;
				
				
			}
		
	}
	
	
    function paydetails($id, $lname, $fname){
	 
		// set common properties
			 $data['title'] = 'Pay Details of '.$lname. ', '.$fname . ' ('.$id.')';
			 $this->load->library('form_validation');
		 
		
		// run validation
			 if ($this->form_validation->run() === FALSE){
			
			 $data['message'] = '';
			 $data['Users'] = (array)$this->employeelistmodel->get_by_id($id)->row();
			 $data['message'] = '';
		 
			}
			
		 
		// load view//
				 $data['Role']=$this->session->userdata('role');
				$this->load->view('pages/template/header2');
				
				//$this->load->view('pages/template/nav', $data);
				$this->load->view('pages/employeepaydetail_view', $data);
			//	$this->load->view('pages/template/footer');
		}

	 
    function view($id){
           	$data['title'] = 'Employee Details';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules_edit();
	 	$data['action'] = ('employeelist/detail/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->employeelistmodel->get_by_id($id)->row();
	 	$data['Users']['Password'] = $this->employeelistmodel->decryptIt($data['Users']['Password']) ;
	 	$data['title'] = 'Update User : '. $data['Users']['Username'] ;
	 	$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->manageusermodel->get_by_id($id)->row();
	 	
		
		
		//$id = $data['Users']['Username'];
		$id = $data['Users']['PKID'];
		$id2 = $data['Users']['Username'];
		
			$User1 = array(
	 				'Operator' => $this->input->post('Operator'),
	 				'Password' => $this->manageusermodel->encryptIt($this->input->post('Password')),
					'Email' => $this->input->post('Email'));
	 		$User2 = array('Rolename' => $this->input->post('Priviledge_group'),
	 				);
		
		//var_dump($User);
	 	$this->manageusermodel->update($id,$id2,$User1, $User2);
	 	$data['User'] = (array)$this->employeelistmodel->get_by_id($id)->row();
	      
		
		  
	 	// set user message
	 	$data['title'] = 'User : '. $data['Users']['Username'] .' has been Update';
		
		}
	 	///$data['link_back'] = anchor('employeelist/index/','Cancel Update',array('class'=>'back'));
	 
	// load view//
	 		$data['Role']=$this->session->userdata('role');
		
	 
			 $this->load->view('pages/template/header');
         	// access control script
		if  (($data['Role'] == "Administrators")  || ($data['Role'] == "SuperAdmin") || ($data['Role'] == "Execom") )	{
			$this->load->view('pages/manageuserupdate_view', $data);
		}  else {

			$this->load->view('pages/unauth_view', $data);
		}	
		
			//	$this->load->view('pages/template/footer');


    }

	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Employee Details';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules_edit();
	 	$data['action'] = ('employeelist/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
		 $data['Users'] = (array)$this->employeelistmodel->get_by_id($id)->row();
		// $data['employee_details'] = (array)$this->employeelistmodel->get_by_id($id)->row();
		 
	 	//$data['Users']['Password'] = $this->employeelistmodel->decryptIt($data['Users']['Password']) ;
	 	//$data['title'] = 'Employee Number: '. $data['employee']['last_name'] ;
	 	$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->employeelistmodel->get_by_id($id)->row();
	 	
		
		
		//$id = $data['Users']['Username'];
		$id = $data['Users']['employee_no'];
		$id2 = $data['Users']['employee_no'];
		          
			$User1 = array(
	 				//'Operator' => $this->input->post('Operator'),
	 				//'Password' => $this->manageusermodel->encryptIt($this->input->post('Password')),
					
                    
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'middle_name' => $this->input->post('middle_name'),
                    'position' => $this->input->post('position'),
                    'department' => $this->input->post('department'),
					 'status' => $this->input->post('status'),
					 'type' => $this->input->post('type'),
					 'bank_name' => $this->input->post('bank_name'),
					 'bank_accnt_no' => $this->input->post('bank_accnt_no'),

                     'date_hire' => $this->input->post('date_hire'),
                     'philhealth' => $this->input->post('philhealth'),
                     'sss' => $this->input->post('sss'),
                     'hdmf' => $this->input->post('hdmf'),


	 				'tin' => $this->input->post('tin'));

					 $type = $this->input->post('type');
					 $basic_salary = $this->input->post('basic_salary');

					 $daily_rate_div = $this->employeelistmodel->get_daily_rate_div();  
					 $hourly_rate_div = $this->employeelistmodel->get_hourly_rate_div(); 
					 $hdmf_rate = $this->employeelistmodel->get_hdmf_rate(); 
		 
					 $daily_rate =  $basic_salary / $daily_rate_div ;
					 $hourly_rate = $daily_rate / $hourly_rate_div;
					 $hdmf_contri = $hdmf_rate;

					 $sss_contri =  $this->employeelistmodel->get_sss_contri($basic_salary);
					 $philhealth_contri = $this->employeelistmodel->compute_philhealth($basic_salary);
					      


					 
					 //$other_deduc = 0;
					 
					/* 
					 if ($type == 'Direct Employment'  || $type == 'Contractual'  ) {
						$net_taxable = $basic_salary - ($sss_contri + $philhealth_contri + $hdmf_contri + $other_deduc);
						
						} else {
			
						$net_taxable = $basic_salary;
			
						}

                    */
	 		$User2 = array(
                     
						 'basic_salary' => $this->input->post('basic_salary'),
						 'de_minimis_non' => $this->input->post('de_minimis_non'),
						 'de_minimis_taxable' => $this->input->post('de_minimis_taxable'),
						'sss_contri' => $sss_contri,
						'philhealth_contri' => $philhealth_contri,
						'hdmf_contri' => $hdmf_contri ,
						'daily_rate' => $daily_rate,
						'hourly_rate' => $hourly_rate ,
						

					 );
					 

		
		//var_dump($User);
	 	$this->employeelistmodel->update($id,$id2,$User1, $User2);
	 	$data['Users'] = (array)$this->employeelistmodel->get_by_id($id)->row();
	      
		
		  
	 	// set user message
		 $data['title'] = 'Employee : '. $data['Users']['employee_no'] .' has been Update';
		 
		 echo "<script> setTimeout(\"window.close();\",1500); </script>";
		
		}
	 	$data['link_tax_id'] = anchor('employeelist/seetaxtable/','see tax table',array('class'=>'back'));
	 
	// load view//
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header2');
			
			//$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/employeedetail_view', $data);
		//	$this->load->view('pages/template/footer');
	}
	 

    function seetaxtable(){
	  
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'tble_id';
		if (empty($order_type)) $order_type = 'asc';
		
		$filter  = $this->input->post('ShortName');
		$limit =  8;

		
		//TODO: check for valid column
		// load data
		$Users = $this->employeelistmodel->get_tax_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/taxtable/index');
		$config['total_rows'] = $this->employeelistmodel->count_all();
		
		if(isset($post['sel']) && !empty($post['sel']))
                $config['per_page'] = $post['sel'];
                else
                $config['per_page'] = 10;
				
		//$config['per_page'] =$limit;
		
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['title'] = "REVISED WITHHOLDING TAX TABLE (ver 2)";
		$data['print_them'] = site_url('/taxtable/print_user');
		
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		//anchor('taxtable/index/'.$offset.'/Min Range/'.$new_order, 'Min Range'),
        
        'Tax Id','Description','PWT','+ Percentage');
	 


	 
	 	$upd = array(
              'width'      => '800',
              'height'     => '800',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
	 	
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			$Users->tax_id,
			$Users->tax_desc,
            number_format($Users->pwt,2),
			number_format($Users->multiplier,2)
			
           
	
		//anchor_popup('taxtable/update/'.$Users->tax_id,'Update',array('class'=>'update'), $upd)
		//anchor('taxtable/delete/'.$Users->tbl_id,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Data?')"))
		);
		}
	 
		$data['table'] = $this->table->generate();
	
		if ($this->uri->segment(3)=='delete_success')
			$data['message'] = 'The Data was successfully deleted';
		else if ($this->uri->segment(3)=='add_success')
			$data['message'] = 'The Data has been successfully added';
		else if ($this->uri->segment(3)=='update_success')
			$data['message'] = 'The Data has been successfully updated';
		else
		$data['message'] = '';
	 
		// load view
	 	$data['Role']=$this->session->userdata('role');
		
		$atts = array(
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		$data['print_me'] = anchor_popup('/taxtable/print_user/','Print User List',array('class'=>'print_hello_world'),$atts);
		$data['link_back'] = anchor('employeelist/supdate/','back',array('class'=>'back'));
		$this->load->view('pages/template/header2');
		//$this->load->view('pages/template/nav',$data);
		if ($data['Role'] != "Administrators"){
			$this->load->view('pages/unauth_view', $data);
				} else
		{
				$this->load->view('pages/taxtable_view', $data);
		}
				
		//$this->load->view('pages/template/footer');

	}

	function delete($id){
	 $data['Users'] = (array)$this->employeelistmodel->get_by_id($id)->row();
	 $id = $data['Users']['employee_no'];
	 $id2 = $data['Users']['employee_no'];
		
	 // delete user
	 	$this->employeelistmodel->delete($id, $id2);
	 	
	// redirect to Student list page
	 	redirect('employeelist/index/delete_success','Refresh');
	 	}
 
	// validation rules
	 
	function _set_rules(){
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
		$this->form_validation->set_rules('Operator', 'operator');
			$this->form_validation->set_rules('employee_no', 'employee_no', 'required|min_length[4]|max_length[20]|is_unique[employee.employee_no]');
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
	 
	 
	function print_user()
	{
				
	$this->load->library('cezpdf');
	
		//$this->cezpdf->ezText('Hello World', 12, array('justification' => 'center'));
		//$this->cezpdf->ezSetDy(-10);
 
		$query = $this->db->select('*')
                        ->from('employee')
						->join('employee_details', 'employee.employee_no= employee_details.employee_no')
						->order_by('employee.last_name', 'ASC') 
						->get();
			
		
		$col_names = array(
			'employee_no' => 'Employee No.',
			'last_name' => 'Last Name',
			'first_name' => 'First Name',
			'position'=> 'Position',
			'department'=> 'Department',
			'status'=> 'Status',
			'tax_status'=> 'Tax Status',
			'basic_salary'=> 'Basic'
		);
		
		foreach ($query->result_array() as $row)
			{
		$db_data[] = array('employee_no' => $row['employee_no'],
							'last_name'=>$row['last_name'], 
							'first_name'=>$row['first_name'], 
							'position'=> $row['position'], 
							'department'=>$row['department'], 
							'status'=>$row['status'], 
							'tax_status'=>$row['tax_status'], 
							'basic_salary'=>$row['basic_salary']);
		
			}
		
		$options = array(
		'width'=>550,
		'fontSize'=>8,
		'showLines'=>1
				);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'PBO Employee List', $options);
		$this->cezpdf->ezStream();
	}
	
	} 

?>