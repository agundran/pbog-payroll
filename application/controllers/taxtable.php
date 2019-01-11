<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once("system/core/Common.php");
class Taxtable extends CI_Controller
{
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('taxtablemodel','',TRUE);
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
	
	function index($offset = 0, $order_column = 'tble_id', $order_type = 'asc')
	{
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'tble_id';
		if (empty($order_type)) $order_type = 'asc';
		
		$filter  = $this->input->post('ShortName');
		$limit =  8;

		
		//TODO: check for valid column
		// load data
		$Users = $this->taxtablemodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/taxtable/index');
		$config['total_rows'] = $this->taxtablemodel->count_all();
		
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
        
        'Tax Id','Min Salary','Description','Prescribes Minimum <br> Withholding tax','+ % over Min Salary <br> (except #7) ','');
	 


	 
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
			$Users->salary_min,
			
			
			$Users->tax_desc,
            'P '.number_format($Users->pwt,2),
			round(number_format($Users->multiplier,2)*100).'%',
			
			
		   
			
			// round((float)$str * 100 ) . '%';
	
		anchor_popup('taxtable/update/'.$Users->tax_id,'Update',array('class'=>'update'), $upd)
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
		
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		
		//access control 
		if (($data['Role'] == "Administrators") || ($data['Role'] == "Execom") || ($data['Role'] == "SuperAdmin")){
			$this->load->view('pages/taxtable_view', $data);
				} else
		{
			$this->load->view('pages/unauth_view', $data);
		}
				
		//$this->load->view('pages/template/footer');
	 
	}
	 
		
	function new_taxtable()
	{
	$data['title'] = 'Add New tax data';
	$data['action'] = site_url('taxtable/new_taxtable');
	$data['link_back'] = anchor('/taxtable/index/','Back to list of Users',array('class'=>'back'));
	
	$this->_set_rules();

			// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new tax table data';
			$data['message'] = '';
			$data['tax-table']['tbl_id']='';
			$data['tax-table']['min_range']='';
			$data['tax-table']['max_range']='';
			$data['tax-table']['salary_credit']='';
			$data['tax-table']['ss_er']='';
			$data['tax-table']['ss_ee']='';
			$data['tax-table']['ss_total']='';
			$data['tax-table']['ec_er']='';
			$data['tax-table']['total_contri']='';
			$data['tax-table']['se_vm_ofw_total_contri']='';
			$data['tax-table']['effectivedate']='';
			$data['link_back'] = anchor('taxtable/index/','See List Of Users',array('class'=>'back'));
			$data['Role']=$this->session->userdata('role');

			$this->load->view('pages/template/header2');
			$this->load->view('pages/taxtableadd_view', $data);
		}else{
			// save data
			$tbl_id = $this->input->post('tbl_id');
			$min_range = $this->input->post('min_range');
			$max_range = $this->input->post('max_range');
			$salary_credit = $this->input->post('salary_credit');
			$ss_er = $this->input->post('ss_er');
			$ss_ee = $this->input->post('ss_ee');
			$ss_total = $this->input->post('ss_total');
			$ec_er = $this->input->post('ec_er');
			$total_contri = $this->input->post('total_contri');
			$se_vm_ofw_total_contri = $this->input->post('se_vm_ofw_total_contri');
			$effectivedate = $this->input->post('effectivedate');

			
			$id = $this->taxtablemodel->add_new_taxtable($tbl_id, $min_range, $max_range, $salary_credit, $ss_er, $ss_ee, $ss_total, $ec_er, $total_contri, $se_vm_ofw_total_contri, $effectivedate);

		
		 $message = "New tax Data Added Successfully";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		window.close ();
				</script>';
				
				//redirect('/taxtable/index/','Refresh');
		
				}	
		}
	}


		 
    function view($id){
           	$data['title'] = 'Employee Details';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules_edit();
	 	$data['action'] = ('taxtable/detail/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->taxtablemodel->get_by_id($id)->row();
	 	$data['Users']['Password'] = $this->taxtablemodel->decryptIt($data['Users']['Password']) ;
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
	 	$data['User'] = (array)$this->taxtablemodel->get_by_id($id)->row();
	      
		
		  
	 	// set user message
	 	$data['title'] = 'User : '. $data['Users']['Username'] .' has been Update';
		
		}
	 	///$data['link_back'] = anchor('taxtable/index/','Cancel Update',array('class'=>'back'));
	 
	// load view//
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header');
			
			//$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/manageuserupdate_view', $data);
		//	$this->load->view('pages/template/footer');


    }

	function update($id)
	{
	 
		// set common properties
		$data['title'] = 'Tax Table Details of Tax ID:  '.$id;
		$this->load->library('form_validation');
	
   // set validation properties
		$this->_set_rules_edit();
		$data['action'] = ('taxtable/update/'.$id);
	
   // run validation
		if ($this->form_validation->run() === FALSE){
		$data['message'] = '';
		$data['Users'] = (array)$this->taxtablemodel->get_by_id($id)->row();
	   // $data['employee_details'] = (array)$this->ottablemodel->get_by_id($id)->row();
		
		//$data['Users']['Password'] = $this->ottablemodel->decryptIt($data['Users']['Password']) ;
		//$data['title'] = 'Employee Number: '. $data['employee']['last_name'] ;
		$data['message'] = '';
		
	   }else{
	
   // save data
		//$id = $this->input->post('id');
	   $data['Users'] = (array)$this->taxtablemodel->get_by_id($id)->row();
		
	   
	   //$id = $data['Users']['Username'];
	   $id = $data['Users']['tax_id'];
	   
	   $sal_min = $this->input->post('salary_min');
	   $sal_max = $this->input->post('salary_max');

		   $User1 = array(
									
				   'salary_min' => $sal_min,
				   'salary_max' => $sal_max,
				   'pwt' => $this->input->post('pwt'),
				   'multiplier' => $this->input->post('multiplier'),
				   'tax_desc' => $this->input->post('tax_desc'),
				   
				  
			   );
				  
	   
	   //var_dump($User);
		$this->taxtablemodel->update($id,$User1);
		$data['Users'] = (array)$this->taxtablemodel->get_by_id($id)->row();
		 
		// set user message
		$data['title'] = 'Overtime Type : '. $data['Users']['tax_id'] .' has been Update';
	   
	   }
		///$data['link_back'] = anchor('ottable/index/','Cancel Update',array('class'=>'back'));
	
   // load view//
			$data['Role']=$this->session->userdata('role');
		   $this->load->view('pages/template/header2');
   
		   //$this->load->view('pages/template/nav', $data);
		   $this->load->view('pages/taxtableedit_view', $data);
   }

	function delete($id)
	{
	 $data['Users'] = (array)$this->taxtablemodel->get_by_id($id)->row();
	 $id = $data['Users']['tax_id'];
	 // delete user
	 	$this->taxtablemodel->delete($id);
	 	redirect('taxtable/index/delete_success','Refresh');
	 }
 

	 // validation rules
	function _set_rules()
	{
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
		$this->form_validation->set_rules('Operator', 'operator');
		$this->form_validation->set_rules('tbl_id', 'tbl_id', 'required|min_length[4]|max_length[20]|is_unique[tax-table.tbl_id]');
			//$this->form_validation->set_rules('Password', 'Password', 'trim|min_length[4]|max_length[32]');
			//$this->form_validation->set_rules('Email', 'Email Address', 'trim|valid_email');
			
	 	}
	 
	function _set_rules_edit(){
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
		$this->form_validation->set_rules('Operator', 'operator');
			//$this->form_validation->set_rules('employee_no', 'employee_no', 'required|min_length[4]|max_length[20]|is_unique[employee.employee_no]');
			//$this->form_validation->set_rules('Username', 'Username', 'required|min_length[4]|max_length[20]|is_unique[users.Username]');
			//$this->form_validation->set_rules('Password', 'Password', 'trim|min_length[4]|max_length[32]');
			//$this->form_validation->set_rules('Email', 'Email Address', 'trim|valid_email');
			
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