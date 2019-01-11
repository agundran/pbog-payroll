<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once("system/core/Common.php");
class Banktable extends CI_Controller
{
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('banktablemodel','',TRUE);
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
	
	function index($offset = 0, $order_column = 'tbl_id', $order_type = 'asc')
	{
		
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'tbl_id';
		if (empty($order_type)) $order_type = 'asc';
		
		$filter  = $this->input->post('ShortName');
		$limit =  8;

		
		//TODO: check for valid column
		// load data
		$Users = $this->banktablemodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/banktable/index');
		$config['total_rows'] = $this->banktablemodel->count_all();
		
		if(isset($post['sel']) && !empty($post['sel']))
                $config['per_page'] = $post['sel'];
                else
                $config['per_page'] = 10;
				
		//$config['per_page'] =$limit;
		
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['title'] = "Bank List Table";
		$data['print_them'] = site_url('/banktable/print_user');
		
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		
		//anchor('banktable/index/'.$offset.'/Min Range/'.$new_order, 'Min Range'),
        
        'Bank Id','Bank Name','Code','Ramarks','Actions','');
	 


	 
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
			$Users->tbl_id,
            $Users->name,
            $Users->code,
            $Users->remarks,
            
			
			
	
		anchor_popup('banktable/update/'.$Users->tbl_id,'Update',array('class'=>'update'), $upd),
		anchor('banktable/delete/'.$Users->tbl_id,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Bank Data?')"))
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
		
		$data['print_me'] = anchor_popup('/banktable/print_user/','Print User List',array('class'=>'print_hello_world'),$atts);
		
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		
		//access control 
		if (($data['Role'] == "Administrators") || ($data['Role'] == "Execom") || ($data['Role'] == "SuperAdmin")){
			$this->load->view('pages/banktable_view', $data);
			} else
		{
			$this->load->view('pages/unauth_view', $data);
		}
				
	//	$this->load->view('pages/template/footer');
	 
	}
	 
		
	function new_banktable()
	{
	$data['title'] = 'Add New tax data';
	$data['action'] = site_url('banktable/new_banktable');
	$data['link_back'] = anchor('/banktable/index/','Back to list of Users',array('class'=>'back'));
	
	$this->_set_rules();

			// run validation
		if ($this->form_validation->run() === FALSE){
			$data['message'] = '';
					// set common properties
			$data['title'] = 'Add new bank table data';
			$data['message'] = '';
			//$data['banks']['tbl_id']='';
			$data['banks']['name']='';
			$data['banks']['code']='';
			$data['banks']['remarks']='';
	
			$data['link_back'] = anchor('banktable/index/','See List Of Users',array('class'=>'back'));
			$data['Role']=$this->session->userdata('role');

			$this->load->view('pages/template/header2');
			$this->load->view('pages/banktableadd_view', $data);
		}else{
			// save data
			$name = $this->input->post('name');
			$code = $this->input->post('code');
			$remarks = $this->input->post('remarks');
	

			
			$id = $this->banktablemodel->add_new_banktable($name, $code, $remarks);

		
		 $message = "New tax Data Added Successfully";
   			 if ((isset($message)) && ($message != '')) {
        		echo '<script>
           		 alert("'.str_replace(array("\r","\n"), '', $message).'");
           		window.close ();
				</script>';
				
				//redirect('/banktable/index/','Refresh');
		
				}	
		}
	}


		 
    function view($id){
           	$data['title'] = 'Employee Details';
	 	$this->load->library('form_validation');
	 
	// set validation properties
	 	$this->_set_rules_edit();
	 	$data['action'] = ('banktable/detail/'.$id);
	 
	// run validation
	 	if ($this->form_validation->run() === FALSE){
	 	$data['message'] = '';
	 	$data['Users'] = (array)$this->banktablemodel->get_by_id($id)->row();
	 	$data['Users']['Password'] = $this->banktablemodel->decryptIt($data['Users']['Password']) ;
	 	$data['title'] = 'Update User : '. $data['Users']['Username'] ;
	 	$data['message'] = '';
	 	
		}else{
	 
	// save data
	 	//$id = $this->input->post('id');
		$data['Users'] = (array)$this->banktablemodel->get_by_id($id)->row();
	 	
		
		
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
	 	$data['User'] = (array)$this->banktablemodel->get_by_id($id)->row();
	      
		
		  
	 	// set user message
         $data['title'] = 'User : '. $data['Users']['Username'] .' has been updated';
         echo "<script> setTimeout(\"window.close();\",1000); </script>";
		
		}
	 	///$data['link_back'] = anchor('banktable/index/','Cancel Update',array('class'=>'back'));
	 
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
		$data['title'] = 'Update';
		$this->load->library('form_validation');
	
   // set validation properties
		$this->_set_rules_edit();
		$data['action'] = ('banktable/update/'.$id);
	
   // run validation
		if ($this->form_validation->run() === FALSE){
		$data['message'] = '';
		$data['Users'] = (array)$this->banktablemodel->get_by_id($id)->row();
	   // $data['employee_details'] = (array)$this->ottablemodel->get_by_id($id)->row();
		
		//$data['Users']['Password'] = $this->ottablemodel->decryptIt($data['Users']['Password']) ;
		//$data['title'] = 'Employee Number: '. $data['employee']['last_name'] ;
		$data['message'] = '';
		
	   }else{
	
   // save data
		//$id = $this->input->post('id');
	   $data['Users'] = (array)$this->banktablemodel->get_by_id($id)->row();
		
	   
	   //$id = $data['Users']['Username'];
	   $id = $data['Users']['tbl_id'];
	   
	   $name = $this->input->post('name');
       $code = $this->input->post('code');
       $remarks = $this->input->post('remarks');


		   $User1 = array(
									
				   'name' => $name,
				   'code' => $code,
				   'remarks' => $remarks
			
				   
				  
			   );
				  
	   
	   //var_dump($User);
		$this->banktablemodel->update($id,$User1);
		$data['Users'] = (array)$this->banktablemodel->get_by_id($id)->row();
		 
		// set user message
		$data['title'] = 'Bank Data : '. $data['Users']['name'] .' has been Updated';
	    echo "<script> setTimeout(\"window.close();\",1500); </script>";
	   }
		///$data['link_back'] = anchor('ottable/index/','Cancel Update',array('class'=>'back'));
	
   // load view//
			$data['Role']=$this->session->userdata('role');
		   $this->load->view('pages/template/header2');
   
		   //$this->load->view('pages/template/nav', $data);
		   $this->load->view('pages/banktableedit_view', $data);
   }

	function delete($id)
	{
	 $data['Users'] = (array)$this->banktablemodel->get_by_id($id)->row();
	 $id = $data['Users']['tbl_id'];
	 // delete user
	 	$this->banktablemodel->delete($id);
	 	redirect('banktable/index/delete_success','Refresh');
	 }
 

	 // validation rules
	function _set_rules()
	{
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
		$this->form_validation->set_rules('Operator', 'operator');
		//$this->form_validation->set_rules('tbl_id', 'tbl_id', 'required|min_length[4]|max_length[20]|is_unique[banks.tbl_id]');
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