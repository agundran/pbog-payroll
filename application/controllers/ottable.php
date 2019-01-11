<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once("system/core/Common.php");
class Ottable extends CI_Controller
{
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('ottablemodel','',TRUE);
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
	
	function index($offset = 0, $order_column = 'ottable_id', $order_type = 'asc')
	{
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'ottable_id';
		if (empty($order_type)) $order_type = 'asc';
		
		$filter  = $this->input->post('ShortName');
		$limit =  10;

		
		//TODO: check for valid column
		// load data
		$Users = $this->ottablemodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/ottable/index');
		$config['total_rows'] = $this->ottablemodel->count_all();
		
		if(isset($post['sel']) && !empty($post['sel']))
                $config['per_page'] = $post['sel'];
                else
                $config['per_page'] = 10;
				
		//$config['per_page'] =$limit;
		
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['title'] = "";
		//$data['print_them'] = site_url('/ottable/print_user');
		
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		//anchor('ottable/index/'.$offset.'/Min Range/'.$new_order, 'Min Range'),
        
        'OT Table ID','Type','Rate','OT', 'ND', 'Actions','');
	 


	 
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
			$Users->ottable_id,
            $Users->type,		
            $Users->rate,		
            	
			$Users->OT,
            $Users->ND,



			
		//	date("F j, Y, g:i a",strtotime($Users->LastActivityDate)+60*60*8),
			
			//strtotime($Users->LastActivityDate)
		    //$Users->LastActivityDate,
			
			
			//Set Different Date Format 
			//date('d-m-Y',strtotime($Student->date_of_birth)),
			//date("F j, Y, g:i a")
			//date("Y-m-d H:i:s")
		
		anchor_popup('ottable/update/'.$Users->ottable_id,'Update',array('class'=>'update'), $upd),
		anchor('ottable/delete/'.$Users->ottable_id,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to delete?')"
		
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
		
		$data['print_me'] = anchor_popup('/ottable/print_user/','Print User List',array('class'=>'print_hello_world'),$atts);
		
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);

		if (($data['Role'] == "Administrators") || ($data['Role'] == "Execom") || ($data['Role'] == "SuperAdmin")){
			$this->load->view('pages/ottable_view', $data);
				} else
		{
				
			$this->load->view('pages/unauth_view', $data);
		}
				
	//	$this->load->view('pages/template/footer');
	 
	}
	 
		
	function new_ottabledata()
	{
	$data['title'] = 'Add New Employee';
	$data['action'] = site_url('ottable/new_ottabledata');
	$data['link_back'] = anchor('/ottable/index/','Back to list of Users',array('class'=>'back'));
	
	$this->_set_rules();

	// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new Overtime Data';
			$data['message'] = '';
			
			
			$data['employee']['employee_no']='';
			$data['employee']['last_name']='';
			$data['employee']['first_name']='';
			$data['employee']['last_name']='';
			$data['employee']['middle_name']='';
		
		

			$data['link_back'] = anchor('ottable/index/','See List Of Users',array('class'=>'back'));
			
			
			$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header2');
			$this->load->view('pages/ottableadd_view', $data);
		
		
		}else{
		
			// save data
			//$ottable_id = $this->input->post('ottable_id');
			$type = $this->input->post('type');
			$rate = $this->input->post('rate');
			$OT = $this->input->post('OT');
			$ND = $this->input->post('ND');
		
	
							
			
			$id = $this->ottablemodel->add_new_otdata($type, $rate, $OT, $ND);

			// set form input name="id"
			//$this->validation->id = $id;

		
		
			//redirect('manageuserlist/index/add_success','Refresh');
		 $message = "New User Added Successfully";
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
	
	

	 
    

	function update($id){
	 
	// set common properties
	 	$data['title'] = 'Employee Details';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules_edit();
	 	$data['action'] = ('ottable/update/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
		 $data['Users'] = (array)$this->ottablemodel->get_by_id($id)->row();
		// $data['employee_details'] = (array)$this->ottablemodel->get_by_id($id)->row();
		 
	 	//$data['Users']['Password'] = $this->ottablemodel->decryptIt($data['Users']['Password']) ;
	 	//$data['title'] = 'Employee Number: '. $data['employee']['last_name'] ;
	 	$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->ottablemodel->get_by_id($id)->row();
	 	
		
		
		//$id = $data['Users']['Username'];
		$id = $data['Users']['ottable_id'];
		
			$User1 = array(
	 			                    
                    'ottable_id' => $this->input->post('ottable_id'),
                    'type' => $this->input->post('type'),
                    'rate' => $this->input->post('rate'),
                    'OT' => $this->input->post('OT'),
                    'ND' => $this->input->post('ND'),
                );
                   

	 		
		
		//var_dump($User);
	 	$this->ottablemodel->update($id,$User1);
	 	$data['Users'] = (array)$this->ottablemodel->get_by_id($id)->row();
	      
		
		  
	 	// set user message
	 	$data['title'] = 'Overtime Type : '. $data['Users']['type'] .' has been Update';
		
		}
	 	///$data['link_back'] = anchor('ottable/index/','Cancel Update',array('class'=>'back'));
	 
	// load view//
	 		$data['Role']=$this->session->userdata('role');
			$this->load->view('pages/template/header2');
			
			//$this->load->view('pages/template/nav', $data);
			$this->load->view('pages/ottableedit_view', $data);
		//	$this->load->view('pages/template/footer');
	}
	 



	function delete($id){
	 $data['Users'] = (array)$this->ottablemodel->get_by_id($id)->row();
	 $id = $data['Users']['ottable_id'];
	 
		
	 // delete user
	 	$this->ottablemodel->delete($id, $id2);
	 	
	// redirect to Student list page
	 	redirect('ottable/index/delete_success','Refresh');
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
	 
	 
	function print_user()
	{
				
	$this->load->library('cezpdf');
	
		//$this->cezpdf->ezText('Hello World', 12, array('justification' => 'center'));
		//$this->cezpdf->ezSetDy(-10);
 
		$query = $this->db->select('*')
                        ->from('users')
                        ->join('usersinroles', 'users.Username= usersinroles.Username')
						->get();
			
		
		$col_names = array(
			'Username' => 'Username',
			'Operator' => 'Operator',
			'Email' => 'Email',
			'Rolename'=> 'User Access',
			'LastLoginDate'=> 'Last Login',
			'LastActivityDate'=> 'Last Activity'
			
		);
		
		foreach ($query->result_array() as $row)
			{
		$db_data[] = array('Username' => $row['Username'],
							'Operator'=>$row['Operator'], 
							'Email'=>$row['Email'], 
							'Rolename'=> $row['Rolename'], 
							'LastLoginDate'=>$row['LastLoginDate'], 
							'LastActivityDate'=>$row['LastActivityDate']);
		
			}
		
		$options = array(
		'width'=>550,
		'fontSize'=>8,
		'showLines'=>0
				);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'PBO Global Employee List', $options);
		$this->cezpdf->ezStream();
	}
	
	} 

?>