<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once("system/core/Common.php");
class Payrollruns extends CI_Controller
{
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('payrollrunsmodel','',TRUE);
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

	
	
	//function index		
	function index($offset = 0, $order_column = 'last_name', $order_type = 'asc')
	{
			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'last_name';
			if (empty($order_type)) $order_type = 'asc';
		
		$filter  = $this->input->post('ShortName');
		$limit =  50;
		//TODO: check for valid column
		// load data
		$Users = $this->payrollrunsmodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('/payrollruns/index');
		$config['total_rows'] = $this->payrollrunsmodel->count_all();
		
		if(isset($post['sel']) && !empty($post['sel']))
                $config['per_page'] = $post['sel'];
                else
                $config['per_page'] = 10;
				
		$config['per_page'] =$limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['title'] = "PAYROLL RUNS";
		$data['print_them'] = site_url('/payrollruns/print_user');
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		//anchor('payrollruns/index/'.$offset.'/Min Range/'.$new_order, 'Min Range'),
       		'ID','Year','Month','Period','Type', 'Description', 'Date','Status','Approval','Actions');
 
	 		$upd = array(
           	    'width'      => '500',
          	    'height'     => '500',
              	'scrollbars' => 'yes',
            	'status'     => 'yes',
           	    'resizable'  => 'yes',
                'screenx'    => '0',
                'screeny'    => '0'
              );
	 	
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
            $Users->payr_id,
            $Users->year,
            $Users->month,
            $Users->period,		
            $Users->payrollrun_type,		
            $Users->description,
            $Users->transact_date,
			$Users->status,
			$Users->execom_status,
			
			
           anchor_popup('payrollruns/update/'.$Users->payr_id,'Update',array('class'=>'update'), $upd).' &nbsp '.
		  // anchor_popup('payrollruns/for_posting/'.$Users->payr_id,'For Posting',array('class'=>'for_posting','onclick'=>"return confirm('WARNING: You are about to post a payroll data. Are you sure you want to continue?')"),$upd).' &nbsp '.
           anchor('payrollruns/for_posting/'.$Users->payr_id,'For Posting',array('class'=>'for_posting','onclick'=>"return confirm('WARNING: You are about to post a payroll data. Are you sure you want to continue?')")).' &nbsp '.

			anchor('payrollruns/view/'.$Users->payr_id,'View',array('class'=>'view')).' &nbsp '.
			anchor('payrollruns/process_payroll/'.$Users->payr_id.'/'.$Users->period,'Process',array('class'=>'process_payroll')).' &nbsp '.
	    	//anchor_popup('payrollruns/show_employees/'.$Users->payr_id,'Create',array('class'=>'show_employees')),
        	//anchor('payrollruns/create/'.$Users->payr_id,'Create',array('class'=>'create','onclick'=>"return confirm('Create new run?')",
			 
			anchor('payrollruns/delete/'.$Users->payr_id,'Delete',array('class'=>'delete','onclick'=>"return confirm('WARNING: You are about to delete a payroll data. This cannot be undone, are you sure you want to remove this Data?')"	))
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
		
		//$data['print_me'] = anchor_popup('/payrollruns/print_user/','Print User List',array('class'=>'print_hello_world'),$upd);
		
		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		
		if (($data['Role'] == "Administrators") || ($data['Role'] == "Execom") || ($data['Role'] == "SuperAdmin")){
			$this->load->view('pages/payrollruns_view', $data);
			//$this->load->view('pages/unauth_view', $data);
			
		} else
			
			{
			
				$this->load->view('pages/unauth_view', $data);
				//$this->load->view('pages/payrollruns_view', $data);
			}
		$this->load->view('pages/template/footer');
	 
	}
	
	//function update individual payroll run details
	function update($id){
	 	// set common properties
			 $data['title'] = 'Update Payroll Run ID#'. $id;
			 $this->load->library('form_validation');
		// set validation properties
			 $this->_set_rules_edit();
			 $data['action'] = ('payrollruns/update/'.$id);
		// run validation
			 if ($this->form_validation->run() === FALSE){
			 $data['message'] = '';
			 $data['Users'] = (array)$this->payrollrunsmodel->get_by_id($id)->row();
			 $data['message'] = '';
			}else{
		 
		// save data
			 //$id = $this->input->post('id');
			$data['Users'] = (array)$this->payrollrunsmodel->get_by_id($id)->row();
			 
				
			//$id = $data['Users']['Username'];
			$id = $data['Users']['payr_id'];
			
			         $year  = $this->input->post('year');
					 $mon = $this->input->post('month');
				
					 switch ($mon) {
						 case "January":
							 $month="Jan";
							 break;
						 case "February":
							 $month="Feb";
							 break;
						 case "March":
							 $month="Mar";
							 break;
						 case "April":
							 $month="Apr";
							 break;
	 
						 case "May":
							 $month="May";
							 break;
	 
						 case "June":
							 $month="Jun";
							 break;
	 
						 case "July":
							 $month="July";
							 break;
	 
						 case "August":
							 $month="Aug";
							 break;
	 
	 
						 case "September":
							 $month="Sep";
							 break;
						 case "October":
							 $month="Oct";
							 break;
	 
						 case "November":
							 $month="Nov";
							 break;
	 
						 case "December":
							 $month="Dec";
							 break;
	 
					 
						 }
	 




					 $period = $this->input->post('period');

					 if ( $period == 1){
						$perioddays = "1 - 15";
					} elseif ( $period == 2){

						 if ($month == "Jan" || $month == "Mar" || $month == "May" || $month == "Jul" || $month == "Aug" || $month == "Oct" || $month == "Dec")
						  {$perioddays = "15 - 31";
						   } elseif  ($month == "Apr" || $month == "Jun" || $month == "Sep" || $month == "Nov" ) 
						   {
							  $perioddays = "15 - 30";
						   }  else 
							 {
							  $perioddays = "15 - 28";

							 }
					}
				   
			         $description =  $month ." ".$perioddays.", ".$year;


					 //$desc = 'Payroll for Period '.$this->input->post('period') .' of '.$this->input->post('month');   
			
					 
		


				$User1 = array(
						'year' => $this->input->post('year'),
						'month' => $this->input->post('month'),
						'period' => $this->input->post('period'),
						'payrollrun_type' => $this->input->post('payrollrun_type'),
						'description' => $description,
						'transact_date' => $this->input->post('transact_date'),
						//'status' => $this->input->post('status'),
						'status' => $stat,
						
						);
	
	
			//'description' => 'Payroll for Period '.$this->input->post('period') .' of '.$this->input->post('month'),
			//var_dump($User);
			 
            
             
			$this->payrollrunsmodel->update($id,$User1);


			 $data['Users'] = (array)$this->payrollrunsmodel->get_by_id($id)->row();
			  
			 // set user message
			 $data['title'] = 'Payroll ID # : '. $data['Users']['payr_id'] .' has been Update';
			
			}
			 ///$data['link_back'] = anchor('employeelist/index/','Cancel Update',array('class'=>'back'));
		 
		// load view//
				 $data['Role']=$this->session->userdata('role');
				$this->load->view('pages/template/header2');
				
				//$this->load->view('pages/template/nav', $data);
				$this->load->view('pages/payrollrunsedit_view', $data);
			//	$this->load->view('pages/template/footer');
		}
		 

	
		
	function for_posting($payr_id){
            //echo "payroll # ".$payr_id. " posted!";
		
			$sstat = $this->payrollrunsmodel->get_by_payrollrun_status($payr_id);
			$stat = $this->payrollrunsmodel->get_by_payrollrun_status_posting($payr_id);
			$desc = $this->payrollrunsmodel->get_by_payrollrun_status_desc($payr_id);
			
			if ($sstat == 'Awaiting Approval'  || $sstat == 'Disapproved'){
				//redirect('payrollruns/index/','Refresh');
			   $message = "Payroll for ".$desc." not yet Approved and therefore cannot be Posted!";
			   if ((isset($message)) && ($message != '')) {
				   echo '<script>
				   alert("'.str_replace(array("\r","\n"), '', $message).'");
				   window.location.href="../payrollruns/index/";
				 	</script>';
				   }
				  // $stat = 'Unposted';	
			} elseif (($sstat == 'Approved') && ($stat == 'Posted')){
				$message = "Payroll for ".$desc." already Posted!";
				if ((isset($message)) && ($message != '')) {
					echo '<script>
					alert("'.str_replace(array("\r","\n"), '', $message).'");
					window.location.href="../payrollruns/index/";
					  </script>';
 					}
			} else {
			 	 
				$status = "Posted";
				$User1 = array(
					'status' => $status
					);
				 
				$this->db->where('payr_id',$payr_id);
				$this->db->update('payroll_runs',$User1);
						
				$message = "Payroll for ".$desc." now Posted!";
				if ((isset($message)) && ($message != '')) {
					echo '<script>
					alert("'.str_replace(array("\r","\n"), '', $message).'");
					window.location.href="../payrollruns/index/";
					  </script>';
 					}
			 }
		}	

	//function process_payroll	
	function process_payroll($payr_id, $period)
	{
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'last_name';
		if (empty($order_type)) $order_type = 'asc';
		
		//$filter  = $this->input->post('ShortName');
			   
		$upd = array(
			'width'      => '1000',
			'height'     => '800',
			'scrollbars' => 'yes',
			'status'     => 'yes',
			'resizable'  => 'yes',
			'screenx'    => '0',
			'screeny'    => '0'
		  );

		//TODO: check for valid column
		// load data
		$limit =  150;
		$Users = $this->payrollrunsmodel->get_show_employee($limit, $offset, $order_column,$order_type)->result();
		//$Users = $this->payrollrunsmodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
		
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('payrollruns/process_payroll/'.$payr_id.'/'.$period.'/');
		$config['total_rows'] = $this->payrollrunsmodel->count_all();
		
				if(isset($post['sel']) && !empty($post['sel']))
                $config['per_page'] = $post['sel'];
                else
                $config['per_page'] = 10;
				
		$config['per_page'] =$limit;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
					
 
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		//$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading(
		//anchor('payrollruns/index/'.$offset.'/Min Range/'.$new_order, 'Min Range'),
        '<input type="checkbox"  id="select_all">','Employee #','Last Name','First Name','Department','Category');
	 	
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
			
			'<input name="user_id[]" value="'.$Users->employee_no.'" type="checkbox" class="checkbox" >',				
			$Users->employee_no,
			$Users->last_name ,
			$Users->first_name,
            $Users->department,		
			$Users->type		
            
			//$Users->status,		
			//anchor_popup('payrollruns/view_payroll_adjustment/'.$Users->employee_no,'view',array('class'=>'view'),$upd) . ' &nbsp &nbsp  ' .
        	//anchor_popup('payrollruns/update_payroll_adjustment/'.$Users->employee_no,'update',array('class'=>'update'),$upd)
           			
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
              'width'      => '400',
              'height'     => '400',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'yes',
              'screenx'    => '0',
              'screeny'    => '0'
            );
		
		//$data['print_me'] = anchor_popup('/payrollruns/print_user/','Print User List',array('class'=>'print_hello_world'),$atts);
		
        $data['title'] = 'Payroll Process for Payroll ID# '.$payr_id;
		$data['action'] = site_url('payrollruns/payroll_compute/'.$payr_id.'/'.$period);
		$data['process_compute'] = anchor_popup('/payrollruns/payroll_compute/'.$payr_id,'Process Selected Employees',array('class'=>'payroll_compute'),$atts);
		$data['link_back'] = anchor('/payrollruns/','Back to payroll runs table',array('class'=>'back'));

		$this->load->view('pages/template/header3');
		$this->load->view('pages/template/nav',$data);
		//if ($data['Role'] != "Administrators")
		//{
		//	$this->load->view('pages/unauth_view', $data);
		//		} else
		//{
			$this->load->view('pages/payrollrunsempshow_view', $data);
		//}
		
		$this->load->view('pages/template/footer');

	}
	
	
   
	//function computing selected employees for payroll
    function payroll_compute($payr_id, $period){
		 
		$choices = $this->input->post('user_id'); 
        var_dump($choices); 
		 

		echo "<br><br><br>";  
		

		//payroll period 

		if ($period == 1) {
		foreach ($choices as $choice){

			echo $choice ."<br>";
			$data['Employees'] = (array)$this->payrollrunsmodel->get_by_choice($choice)->row();
			$basic_salary  = $data['Employees']['basic_salary'];
			$basic_salary_half = $basic_salary / 2;
			$de_minimis_non  = ($data['Employees']['de_minimis_non'])/2;
			$de_minimis_taxable  = ($data['Employees']['de_minimis_taxable'])/2;
			$sss_contri = $data['Employees']['sss_contri'];
			
			$type = $this->payrollrunsmodel->get_employee_type($choice);

             if ($type == 'Direct Employment'  || $type == 'Contractual'){
				$net_taxable = ($basic_salary_half - $sss_contri) + $de_minimis_taxable;
			 } else {
				$net_taxable = $basic_salary_half + $de_minimis_taxable;

			 }


			//run tax computation model
						
			$tax = $this->payrollrunsmodel->compute_tax($net_taxable, $choice, $type);
			
			
			// philhealth & pagibig contribution 1 to 15 of month		
			$total_deduc = $tax + $sss_contri;
			$de_minimis_total = 0;
		
			$net_pay = ($basic_salary_half + $de_minimis_non + $de_minimis_taxable)- $total_deduc;


			$de_minimis_total = $de_minimis_non + $de_minimis_taxable;
			$Employees1 = array(
				'payr_id' => $payr_id, 
				'employee_no' => $choice, 
				'basic_salary' =>	$basic_salary_half,
				'de_minimis_total' => $de_minimis_total,
				'tax' => $tax,
				'sss_contri' => $sss_contri,
				//'philhealth_contri' => $philhealth_contri,
				//'pag_ibig_contri' => $hdmf_contri,
				'total_deduc' => $total_deduc,
				'net_pay' => $net_pay 
			);
		
			$this->payrollrunsmodel->insert_to_payroll_run_details($Employees1);
		
		}
	
	}  else if ($period == 2) {
	   
		foreach ($choices as $choice){

			echo $choice ."<br>";
			$data['Employees'] = (array)$this->payrollrunsmodel->get_by_choice($choice)->row();
			 
			$basic_salary  = $data['Employees']['basic_salary'];
			$basic_salary_half = $basic_salary / 2;
			$philhealth_contri = $data['Employees']['philhealth_contri'];
			$hdmf_contri = $data['Employees']['hdmf_contri'];
			$de_minimis_non  = ($data['Employees']['de_minimis_non'])/2;
			$de_minimis_taxable  = ($data['Employees']['de_minimis_taxable'])/2;
			
			$type = $this->payrollrunsmodel->get_employee_type($choice);

             if ($type == 'Direct Employment'  || $type == 'Contractual'){
				$net_taxable = ($basic_salary_half - $philhealth_contri - $hdmf_contri) + $de_minimis_taxable;
			 } else {
				$net_taxable = $basic_salary_half + $de_minimis_taxable;

			 }
			
			
			//run tax computation model
			$tax = $this->payrollrunsmodel->compute_tax($net_taxable, $choice, $type);
			//$sss_contri = $data['Employees']['sss_contri'];
			$philhealth_contri = $data['Employees']['philhealth_contri'];
			$hdmf_contri = $data['Employees']['hdmf_contri'];
			//$other_deduc = $data['Employees']['other_deduc'];
			

			// philhealth & pagibig contribution 16 to 30 of month	
			$total_deduc = $tax + $philhealth_contri  +  $hdmf_contri;
		
			$de_minimis_total = 0;
         	$net_pay = ($basic_salary_half + $de_minimis_non + $de_minimis_taxable)- $total_deduc;
			$de_minimis_total = $de_minimis_non + $de_minimis_taxable;
			
			$Employees1 = array(
				'payr_id' => $payr_id, 
				'employee_no' => $choice, 
				'basic_salary' =>	$basic_salary_half,
				'de_minimis_total' => $de_minimis_total,
				'tax' => $tax,
				//'sss_contri' => $sss_contri,
				'philhealth_contri' => $philhealth_contri,
				'pag_ibig_contri' => $hdmf_contri,
				'total_deduc' => $total_deduc,
				'net_pay' => $net_pay 
			);
			$this->payrollrunsmodel->insert_to_payroll_run_details($Employees1);
		}
	}


		echo "new payroll updated.......";

		//echo "<script> setTimeout(\"window.close();\",1000); </script>";
		redirect('payrollruns/view/'.$payr_id,'Refresh');

	}

	

    function payr_adjustments($id){
	   
		// set common properties
		$data['Employee_paydetails'] = (array)$this->payrollrunsmodel->get_by_payroll_runs_details($id)->row();
		$emp_no = $data['Employee_paydetails']['employee_no'];	


		$data['title'] = 'Adjustment for Employee# '. $emp_no;

		$this->load->library('form_validation');
   // set validation properties
		$this->_set_rules_edit();
		$data['action'] = ('payrollruns/payr_adjustments/'.$id);
   // run validation
		if ($this->form_validation->run() === FALSE){
		$data['message'] = '';
		//$data['Employee_paydetails'] = (array)$this->payrollrunsmodel->get_by_payroll_runs_details($id)->row();
		$data['message'] = '';
	   }else{
	
   // save data
		//$id = $this->input->post('id');
	   
		//get data from payroll run details table
		$data['Employee_paydetails'] = (array)$this->payrollrunsmodel->get_by_payroll_runs_details($id)->row();
		$emp_no = $data['Employee_paydetails']['employee_no'];		   

	   //get data from employee table	
	   $data['Employees'] = (array)$this->payrollrunsmodel->get_by_employee_detail($emp_no)->row();
	   $data['Emp'] = (array)$this->payrollrunsmodel->get_by_employee($emp_no)->row();

	  // $emp_no = $data['Employees']['employee_no'];	
	   $type = $data['Emp']['type'];	

		   
	   //$id = $data['Users']['Username'];
	   $detail_id = $data['Employee_paydetails']['payr_detail_id'];
	   
		   $desc =    'Payroll for Period '.$this->input->post('period') .' of '.$this->input->post('month');   
			
		   
		   $basic_salary = $data['Employee_paydetails']['basic_salary'];
		   $de_minimis_total  = $data['Employee_paydetails']['de_minimis_total'];

		   $de_minimis_taxable = $data['Employees']['de_minimis_taxable'];
		   //$de_minimis_non = $data['Employees']['de_minimis_non'];
		   

		   $daily_rate = $data['Employees']['daily_rate'];
		   $hourly_rate = $data['Employees']['hourly_rate'];
		   
            

		   $adjustment = $this->input->post('salary_adjust');

		   
           $days_absent = $this->input->post('days_absent');
		   $days_absent_rate = $days_absent * $daily_rate ;

		  
		   $minutes_late = $this->input->post('minutes_late');
		   $minutes_late_rate = $minutes_late * ($hourly_rate / 60);

		   $notes =   $this->input->post('notes');
		  
	      
		   $sal_adjustment = $days_absent_rate +  $minutes_late_rate;
		 


		   $sss_loan = $this->input->post('sss_loan');
		   $hdmf_loan = $this->input->post('hdmf_loan');
		   $other_deduc = $this->input->post('other_deduc');
		   
		   
		   $sss_contri = $data['Employee_paydetails']['sss_contri'];
		   $philhealth_contri = $data['Employee_paydetails']['philhealth_contri'];
		   $pag_ibig_contri = $data['Employee_paydetails']['pag_ibig_contri'];



           if ($type == 'Direct Employment'  || $type == 'Contractual'){

		   $new_taxable_income =  ($basic_salary  + $adjustment + $de_minimis_taxable) - ($sss_contri + $philhealth_contri + $pag_ibig_contri) - $sal_adjustment;

		   }else { 
	 
			$new_taxable_income =  ($basic_salary  + $adjustment + $de_minimis_taxable) - $sal_adjustment;

		   }


		   $tax_adjustment = $this->payrollrunsmodel->compute_tax($new_taxable_income, $emp_no, $type);
			
            
			
		  // if ($type == 'Direct Employment'  || $type == 'Contractual'){
			//     $new_total_deduction = $tax_adjusment + $sss_loan + $hdmf_loan +  $other_deduc ;
			//	 } else {
			
			//		$new_total_deduction = $tax_adjusment + $sss_contri +  $philhealth_contri + $pag_ibig_contri + $sss_loan + $hdmf_loan +  $other_deduc;
		 	//	}
		

		   $new_total_deduction = $tax_adjustment + $days_absent_rate + $minutes_late_rate + $sss_contri +  $philhealth_contri + $pag_ibig_contri + $sss_loan + $hdmf_loan +  $other_deduc;
		   
		 
		 
		   $new_net_salary = ($basic_salary + $de_minimis_total + $adjustment) -  $new_total_deduction;


		   $User1 = array(
				   'basic_salary' => $basic_salary,
				   'salary_adjust' => $adjustment,
				   'days_absent'  =>  $days_absent,
				   'days_absent_rate' => $days_absent_rate,
				   'minutes_late' => $minutes_late,
				   'minutes_late_rate' => $minutes_late_rate,
				   'de_minimis_total' => $de_minimis_total,
				   'tax' => $tax_adjustment,
				   'sss_contri' => $sss_contri,
				   
				   'philhealth_contri' => $philhealth_contri,
				   'pag_ibig_contri' => $pag_ibig_contri,
				   'sss_loan' => $sss_loan,
				   'hdmf_loan' =>  $hdmf_loan,
				   'other_deduc' => $other_deduc,
				   'total_deduc' => $new_total_deduction,
				   'net_pay' => $new_net_salary,
				   'notes' => $notes,

				   );


	   //'description' => 'Payroll for Period '.$this->input->post('period') .' of '.$this->input->post('month'),
	   //var_dump($User);
		$this->payrollrunsmodel->update_paytoll_runs_details($detail_id,$User1);

		//$data['Users'] = (array)$this->payrollrunsmodel->get_by_id($id)->row();
		 
		// set user message
		$data['title'] = 'Payroll Adjustment for Employee # :  '.  $emp_no .' has been Update';
		echo "<script> setTimeout(\"window.close();\",1000); </script>";
	   
	   }
		///$data['link_back'] = anchor('employeelist/index/','Cancel Update',array('class'=>'back'));
	
   // load view//
			$data['Role']=$this->session->userdata('role');
		   $this->load->view('pages/template/header2');
		   
		   //$this->load->view('pages/template/nav', $data);
		   $this->load->view('pages/payroll_adjustment_update_view', $data);
	   //	$this->load->view('pages/template/footer');


	}  

	
	function payr_adjustments_view($id){

	// set common properties


	$data['Employee_paydetails'] = (array)$this->payrollrunsmodel->get_by_payroll_runs_details($id)->row();
	$emp_no = $data['Employee_paydetails']['employee_no'];	
	$data['title'] = 'Adjustment for Employee# '. $emp_no;

	//$data['title'] = 'Adjustment for Employee#'. $id;
	$this->load->library('form_validation');
// set validation properties
	$this->_set_rules_edit();
	$data['action'] = ('payrollruns/payr_adjustments_view/'.$id);
// run validation
	if ($this->form_validation->run() === FALSE){
	$data['message'] = '';
	$data['Employee_paydetails'] = (array)$this->payrollrunsmodel->get_by_payroll_runs_details($id)->row();
	$data['message'] = '';
   }else{

// save data
	//$id = $this->input->post('id');
   
	//get data from payroll run details table
	$data['Employee_paydetails'] = (array)$this->payrollrunsmodel->get_by_payroll_runs_details($id)->row();
	$emp_no = $data['Employee_paydetails']['employee_no'];		   

   //get data from employee table	
   $data['Employees'] = (array)$this->payrollrunsmodel->get_by_employee_detail($emp_no)->row();
   $data['Emp'] = (array)$this->payrollrunsmodel->get_by_employee($emp_no)->row();

  // $emp_no = $data['Employees']['employee_no'];	
   $type = $data['Emp']['type'];	

	   
   //$id = $data['Users']['Username'];
   $detail_id = $data['Employee_paydetails']['payr_detail_id'];
   
	   $desc =    'Payroll for Period '.$this->input->post('period') .' of '.$this->input->post('month');   
		
	   
	   $basic_salary = $data['Employee_paydetails']['basic_salary'];
	   $de_minimis_total  = $data['Employee_paydetails']['de_minimis_total'];

	   $de_minimis_taxable = $data['Employees']['de_minimis_taxable'];
	   

	   $daily_rate = $data['Employees']['daily_rate'];
	   $hourly_rate = $data['Employees']['hourly_rate'];
	   
		

	   $adjustment = $this->input->post('salary_adjust');

	   if ($this->input->post('days_absent') != "") {    
	   $days_absent_rate = $this->input->post('days_absent') * $daily_rate ;
	   $days_absent = $this->input->post('days_absent');
	   }

	   if ($this->input->post('minutes_late') != "") {  
	   $minutes_late_rate = $this->input->post('minutes_late') * ($hourly_rate / 60);
	   $minutes_late = $this->input->post('minutes_late');
	   }
	 
	 
	   $notes =   $this->input->post('notes');
	   
	   $sal_adjustment = $adjustment - $days_absent_rate -  $minutes_late_rate;
      
	   $sss_loan = $this->input->post('sss_loan');
	   $hdmf_loan = $this->input->post('hdmf_loan');
	   $other_deduc = $this->input->post('other_deduc');
	   
	   
	   $sss_contri = $data['Employee_paydetails']['sss_contri'];
	   $philhealth_contri = $data['Employee_paydetails']['philhealth_contri'];
	   $pag_ibig_contri = $data['Employee_paydetails']['pag_ibig_contri'];


	   $new_taxable_income =  $basic_salary  + $sal_adjustment + $de_minimis_taxable;
	   
	   $tax_adjusment = $this->payrollrunsmodel->compute_tax($new_taxable_income, $emp_no, $type);
		
	   
	 
	   $new_total_deduction = $tax_adjusment + $sss_contri +  $philhealth_contri + $pag_ibig_contri + $sss_loan + $hdmf_loan +  $other_deduc;



	   $new_net_salary = ($basic_salary + $de_minimis_total + $adjustment) -  $new_total_deduction;


	   $User1 = array(
			   'basic_salary' => $basic_salary,
			   'salary_adjust' => $adjustment  ,
			   'days_absent'  => $days_absent ,
			   'minutes_late' => $minutes_late ,
			   'de_minimis_total' => $de_minimis_total,
			   'tax' => $tax_adjusment,
			   'sss_contri' => $sss_contri,
			   
			   'philhealth_contri' => $philhealth_contri,
			   'pag_ibig_contri' => $pag_ibig_contri,
			   'sss_loan' => $sss_loan,
			   'hdmf_loan' =>  $hdmf_loan,
			   'other_deduc' => $other_deduc,
			   'total_deduc' => $new_total_deduction,
			   'net_pay' => $new_net_salary,
			   'notes' => $notes,

			   );


   //'description' => 'Payroll for Period '.$this->input->post('period') .' of '.$this->input->post('month'),
   //var_dump($User);
	$this->payrollrunsmodel->update_paytoll_runs_details($detail_id,$User1);

	//$data['Users'] = (array)$this->payrollrunsmodel->get_by_id($id)->row();
	 
	// set user message
	$data['title'] = 'Payroll Detail ID # :  '.  $detail_id .' has been Update';
   
   }
	///$data['link_back'] = anchor('employeelist/index/','Cancel Update',array('class'=>'back'));

// load view//
		$data['Role']=$this->session->userdata('role');
	   $this->load->view('pages/template/header2');
	   
	   //$this->load->view('pages/template/nav', $data);
	   $this->load->view('pages/payroll_adjustment_view', $data);
   //	$this->load->view('pages/template/footer');
	}
	 


	//function for viewing processed payroll
    function view($id)
	{
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = $id;
		if (empty($order_type)) $order_type = 'asc';
		
		$limit =  100;
		$Users = $this->payrollrunsmodel->get_processed_payroll($limit, $offset, $order_column, $order_type)->result();
		
		$this->load->library('pagination');
		$config['base_url'] = site_url('/payrollruns/view');
		$config['total_rows'] = $this->payrollrunsmodel->count_all();
		
		if(isset($post['sel']) && !empty($post['sel']))
                $config['per_page'] = $post['sel'];
                else
                $config['per_page'] = 10;
				
		//$config['per_page'] =$limit;
		
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

	
		$pr = $this->payrollrunsmodel->get_payrollrun($id)->result();
		

		foreach ($pr as $pr){
		$data['title'] = 'Processed '.$pr->description. ' (ID # '.$pr->payr_id.')';
	    }
		
		$data['print_them'] = site_url('/payrollruns/print_user');
		   
		$upd = array(
			'width'      => '1000',
			'height'     => '800',
			'scrollbars' => 'yes',
			'status'     => 'yes',
			'resizable'  => 'yes',
			'screenx'    => '0',
			'screeny'    => '0'
		  );
		  
         
		// generate table data
		$this->load->library('table');
		$this->table->set_empty("");
		$new_order = ($order_type == 'asc' ? 'desc' : 'asc');
		$this->table->set_heading('Employee no',' Name','Basic Salary', 'Total De minimis ','Salary Adjustment','Absent(s)','Late','Withholding Tax', 'SSS Contribution', 'Philhealth Contribution','HDMF Contribution','SSS Loan','Pagibig Loan','Other Deductions','Total Deduction','Net Pay','Adjustments','Payslip', 'Actions');
 
	
		$i = 0 + $offset;
		foreach ($Users as $Users) {
			$this->table->add_row(
            $Users->employee_no,
            $Users->last_name. ', '.  $Users->first_name,		
			number_format($Users->basic_salary,2),	
				
			number_format($Users->de_minimis_total,2),
			number_format($Users->salary_adjust,2),
			number_format($Users->days_absent_rate,2),
			number_format($Users->minutes_late_rate,2),
			number_format($Users->tax,2),
			number_format($Users->sss_contri,2),
			number_format($Users->philhealth_contri,2),
			number_format($Users->pag_ibig_contri,2),
			number_format($Users->sss_loan,2),
			number_format($Users->hdmf_loan,2),
			number_format($Users->other_deduc,2),
			number_format($Users->total_deduc,2),
			number_format($Users->net_pay,2),



			anchor_popup('payrollruns/payr_adjustments/'.$Users->payr_detail_id,'Update',array('class'=>'update'), $upd).'&nbsp &nbsp'.
			anchor_popup('payrollruns/payr_adjustments_view/'.$Users->payr_detail_id,'View',array('class'=>'view'), $upd) . ' &nbsp&nbsp| ',
			anchor_popup('payrollruns/show_payslip/'.$Users->payr_detail_id,'View',array('class'=>'view'), $upd). ' &nbsp&nbsp| ',
			anchor('payrollruns/delete_payr_detail/'.$Users->payr_detail_id.'/'.$id,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure you want to remove this Data?')"	))
						
			);
		}
	   

		
		$data['table'] = $this->table->generate();
		
		
				//if ($this->uri->segment(3)=='delete_success')
				if ($this->uri->segment(3)==$id)
					
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
		
		//$data['print_me'] = anchor_popup('/payrollruns/print_user/','Print User List',array('class'=>'print_hello_world'),$atts);
		$data['link_back'] = anchor('/payrollruns/','Back to payroll runs table',array('class'=>'back'));

		$data['print_report'] = anchor('/payrollruns/exportXLS/'.$id,'Export to Excel',array('class'=>'print'));

		  
		
            

		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		if (($data['Role'] == "Administrators") || ($data['Role'] == "Execom") || ($data['Role'] == "Operators") )
		{
			$this->load->view('pages/payrollrunsprocessed_view', $data);
			

				} else
		{
            $this->load->view('pages/unauth_view', $data);
			//$this->load->view('pages/payrollrunsprocessed_view', $data);
		}
		
		$this->load->view('pages/template/footer');
        

	}

	

	


	function exportXLS($payr_id) {
		 
		
		
	  $fileName  = 'payroll_id_'.$payr_id.'_'.time().'.xlsx';
	   
	
		// create file name
		//$fileName = 'data-'.time().'.xlsx';  
		// load excel library
		$this->load->library('excel');
	   // $this->load->library('PHPExcel/IOFactory');

		$repInfo = $this->payrollrunsmodel->get_processed_payroll_print($payr_id);
        //$Users = $this->payrollrunsmodel->get_processed_payroll($limit, $offset, $order_column, $order_type)->result();   

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		// set Header
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Employee No.');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Last Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'First Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Bank Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Account No.');
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Withholding Tax'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'SSS Contribution'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Philhealth Contribution'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'HDMF Contribution'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'SSS Loan'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Pagibig Loan'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Net Pay'); 


		// set Row
		$rowCount = 2;
		foreach ($repInfo as $element) {
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['employee_no']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['last_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['first_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['bank_name']);
			$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['bank_accnt_no']);
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['tax']);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['sss_contri']);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['philhealth_contri']);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['pag_ibig_contri']);
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['sss_loan']);
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['hdmf_loan']);
	
			$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['net_pay']);




			$rowCount++;
		}
	   // original version
	   $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	   header("Content-Disposition: attachment;filename=$fileName");
	   header('Cache-Control: max-age=0');
	   $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	 
	   ob_end_clean();
	   $objWriter->save('php://output');
	   exit;

	  

	}
      





    //function for adding new payroll run
	function new_payrollrun()
	{

		$data['title'] = 'Add New Payroll Run';
		$data['action'] = site_url('payrollruns/new_payrollrun');
		$data['link_back'] = anchor('/payrollruns/index/','Back to list of Users',array('class'=>'back'));
		
		$this->_set_rules();
	
		// run validation
			if ($this->form_validation->run() === FALSE){
				$data['message'] = '';
						// set common properties
				$data['title'] = 'Add New Payroll Run';
				
				$data['message'] = '';
				$data['payroll_runs']['year']='';
				$data['payroll_runs']['month']='';
				$data['payroll_runs']['period']='';
				$data['payroll_runs']['payrollrun_type']='';
				//$data['payroll_runs']['description']='';
				$data['payroll_runs']['transact_date']='';
				
					
				
				$data['Role']=$this->session->userdata('role');
				$this->load->view('pages/template/header2');
				$this->load->view('pages/payrollrunsadd_view', $data);
			
			
			}else{
			
				// save data
				$year = $this->input->post('year');
				
				$mon = $this->input->post('month');
				
				switch ($mon) {
					case "January":
						$month="Jan";
						break;
					case "February":
						$month="Feb";
						break;
					case "March":
						$month="Mar";
						break;
					case "April":
						$month="Apr";
						break;

					case "May":
						$month="May";
						break;

					case "June":
						$month="Jun";
						break;

					case "July":
						$month="July";
						break;

					case "August":
						$month="Aug";
						break;


					case "September":
						$month="Sep";
						break;
					case "October":
						$month="Oct";
						break;

					case "November":
						$month="Nov";
						break;

					case "December":
						$month="Dec";
						break;

				
					}



				$period = $this->input->post('period');
				$payrollrun_type = $this->input->post('payrollrun_type');
				//$description = $this->input->post('description');
					
				      if ( $period == 1){
						  $perioddays = "1 - 15";
					  } elseif ( $period == 2){

                           if ($month == "Jan" || $month == "Mar" || $month == "May" || $month == "Jul" || $month == "Aug" || $month == "Oct" || $month == "Dec")
                            {$perioddays = "15 - 31";
							 } elseif  ($month == "Apr" || $month == "Jun" || $month == "Sep" || $month == "Nov" ) 
							 {
								$perioddays = "15 - 30";
							 }  else {
								$perioddays = "15 - 28";

							   }
					  }
				     
				$description =  $month ." ".$perioddays.", ".$year;
				
                

				$transact_date = $this->input->post('transact_date');
				$execom_status = 'Awaiting Approval';				
				
				$id = $this->payrollrunsmodel->add_new_payrollruns($year, $mon, $period, $payrollrun_type, $description, $transact_date, $execom_status);
				// set form input name="id"
				//$this->validation->id = $id;
	
			      
			
				//redirect('manageuserlist/index/add_success','Refresh');
			 $message = "New Payrollrun Added Successfully";
					if ((isset($message)) && ($message != '')) {
					echo '<script>
						alert("'.str_replace(array("\r","\n"), '', $message).'");
					   window.close ();
					</script>';
					}	
			}
	


	}

    // show payslip in PDF
	function show_payslip($payr_detail_id)
	{
				
	$this->load->library('cezpdf');
	
		//$this->cezpdf->ezText('Hello World', 12, array('justification' => 'center'));
		//$this->cezpdf->ezSetDy(-10);
 
		$query = $this->db->select('*')
                        ->from('payroll_runs_details')
						->join('employee', 'employee.employee_no=payroll_runs_details.employee_no')
						->where('payroll_runs_details.payr_detail_id', $payr_detail_id)
						->get();
			
		
		$col_names = array(
			'employee_no' => 'EMP #',
			'last_name' => 'Last Name',
			'basic_salary'  => 'Gross',
			'de_minimis_total'  => 'De minimis Total',
			
			'salary_adjust' => 'Adjustments',
			'tax' => 'WTH Tax',
			'total_deduc'=> 'Total Deductions',
			
			'net_pay'=> 'Net Pay'
			
		);
		
        
	



		foreach ($query->result_array() as $row)
			{
		$db_data[] = array('employee_no' => $row['employee_no'],
							'last_name'=>$row['last_name'], 
							'basic_salary'=>$row['basic_salary'],
							'de_minimis_total'=>$row['de_minimis_total'],
							'salary_adjust'=>$row['salary_adjust'],
							'tax'=>$row['tax'],
							'total_deduc'=> $row['total_deduc'], 
							
							'net_pay'=>$row['net_pay']);
		
			}
		


		$options = array(
		'width'=>550,
		'fontSize'=>8,
		'showLines'=>1
				);
		
			
				
		
		//$last_name = $this->db->get()->row()->last_name;
	   
		$pdd = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->payr_id;

		
		//$payroll_date = $this->payrollrunsmodel->get_payroll_date($pdd);
		$pdate = $this->payrollrunsmodel->get_payroll_date($pdd);
		$payroll_coverage = $this->payrollrunsmodel->get_payroll_coverage($pdd);
		$my_pdate = strtotime($pdate);
		
       

		//$payroll_date = strtotime($pdate);
		
		$payroll_date = date("M d,Y", $my_pdate);
		
		

		$employee_no = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->employee_no;
		$last_name = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->last_name;
		$first_name = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->first_name;
		$middle_name = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->middle_name;
		
		$tin = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->tin;
		$sss = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->sss;
		$philhealth = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->philhealth;
		$hdmf = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->hdmf;
		


		$position = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->position;
		$department = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->department;

		$basic_salary = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->basic_salary;
		$salary_adjust = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->salary_adjust;
		$de_minimis_total = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->de_minimis_total;

		$days_absent_rate = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->days_absent_rate;
		$days_absent = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->days_absent;

		$minutes_late = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->minutes_late;
		$minutes_late_rate = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->minutes_late_rate;


		$tax = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->tax;
		$sss_contri = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->sss_contri;
		$philhealth_contri = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->philhealth_contri;
		$pag_ibig_contri = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->pag_ibig_contri;
		$sss_loan = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->sss_loan;
		$hdmf_loan = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->hdmf_loan;

		$other_deduc = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->other_deduc;
		$total_deduc = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->total_deduc;
		$net_pay = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->net_pay;

		$totalgross = $basic_salary + $salary_adjust + $de_minimis_total;

		$image = "https://image.ibb.co/eLoxNq/pbo-heading.png";

		$image2 =  "https://image.ibb.co/iznAEJ/pbo-Global-logo1.png";
		//$this->cezpdf->ezTable($db_data, $col_names, 'Payslip', $options);

        
		//$this->cezpdf->ezText(<table> , 12, array('justification' => 'left'));
       
		//$this->cezpdf->ezImage('images/pbo_heading.png', 0, 195, 'none', 'left');
		//$this->cezpdf->ezImage($image, 1, 1, 'none', 'left');
		

		//$this->cezpdf->ezSetDy(-5);
		//$this->cezpdf->ezText('PAYSLIP', 12, array('justification' => 'center'));

		//$this->cezpdf->ezSetDy(-5);
		//$this->cezpdf->ezText('Employee No.'.' '.$employee_no  , 10, array('justification' => 'left'));
		


		//$this->cezpdf->addPngFromFile( $image,  475,  805, 0, 0,  75);
		
		$this->cezpdf->addtext(45,805,10, 'PBO GLOBAL INC',0,0);
		$this->cezpdf->addtext(45,795,8, 'Unit B, 5th Floor, Clark Center 7',0,0); 
		$this->cezpdf->addtext(45,785,8, 'Jose Abad Santos Ave., Clark Freeport Zone',0,0); 	
		$this->cezpdf->addtext(45,775,8, 'Pampanga, Philippines 2023',0,0);  	

		$this->cezpdf->addtext(275,740,10, 'PAYSLIP',0,0);       


		$this->cezpdf->addtext(45,720,10, 'Name',0,0); 					$this->cezpdf->addTextWrap(90,720,200,10, $last_name .', '.$first_name ,'right',0);
		$this->cezpdf->addtext(45,705,10, 'TIN',0,0); 					$this->cezpdf->addTextWrap(180,705,100,10, $tin,'right',0);
		$this->cezpdf->addtext(45,690,10, 'SSS no',0,0);             	$this->cezpdf->addTextWrap(180,690,100,10, $sss,'right',0);
		$this->cezpdf->addtext(45,675,10, 'PHILHEALTH No',0,0); 		$this->cezpdf->addTextWrap(180,675,100,10, $philhealth,'right',0);
		$this->cezpdf->addtext(45,660,10, 'HDMF',0,0); 					$this->cezpdf->addTextWrap(180,660,100,10, $hdmf,'right',0);
		$this->cezpdf->addtext(45,645,10, 'Remianing SL',0,0); 			$this->cezpdf->addTextWrap(180,645,100,10, "",'right',0);
		$this->cezpdf->addtext(45,630,10, 'Leave Credit',0,0); 			$this->cezpdf->addTextWrap(180,630,100,10, "",'right',0);
		



        $this->cezpdf->addtext(130,610,10, 'COMPENSATION',0,0);   
		$this->cezpdf->addtext(45,595,10, 'Basic',0,0); 					$this->cezpdf->addTextWrap(180,595,100,10,number_format($basic_salary,2),'right',0);
		$this->cezpdf->addtext(45,580,10, 'Salary Adjustment',0,0); 		$this->cezpdf->addTextWrap(180,580,100,10,number_format($salary_adjust,2),'right',0);
		$this->cezpdf->addtext(45,565,10, 'De minimis Benefits',0,0); 		$this->cezpdf->addTextWrap(180,565,100,10,number_format($de_minimis_total,2),'right',0);
		$this->cezpdf->addtext(45,550,10, '',0,0); 							$this->cezpdf->addTextWrap(180,550,100,'','right',0);
		$this->cezpdf->addtext(45,535,10, '',0,0); 							$this->cezpdf->addTextWrap(180,535,100,10,'','right',0);
		$this->cezpdf->addtext(45,520,10, ' ',0,0); 						$this->cezpdf->addTextWrap(180,520,100,10,"",'right',0);
        $this->cezpdf->addtext(45,505,10, ' ',0,0); 						$this->cezpdf->addTextWrap(180,505,100,10,"",'right',0);
		$this->cezpdf->addtext(45,490,10, ' ',0,0); 						$this->cezpdf->addTextWrap(180,490,100,10,"",'right',0);
		$this->cezpdf->addtext(45,475,10, '',0,0); 							$this->cezpdf->addTextWrap(180,475,100,10,"",'right',0);
		$this->cezpdf->addtext(231,468,10,'---------------',0,0);
		$this->cezpdf->addtext(45,460,10, 'Total Compensation',0,0); 		$this->cezpdf->addTextWrap(180,460,100,10,number_format($totalgross,2),'right',0);

		
	    $this->cezpdf->addtext(320,720,10, 'Employee No.',0,0); 			$this->cezpdf->addTextWrap(475,720,80,10, $employee_no,'right',0);
		$this->cezpdf->addtext(320,705,10, 'Payroll Date',0,0); 			$this->cezpdf->addTextWrap(475,705,80,10, $payroll_date,'right',0);
		$this->cezpdf->addtext(320,690,10, 'Date Covered',0,0);            	$this->cezpdf->addTextWrap(475,690,80,10, $payroll_coverage,'right',0);
		$this->cezpdf->addtext(320,675,10, 'Tax Status',0,0); 				$this->cezpdf->addTextWrap(475,675,80,10, "",'right',0);
		$this->cezpdf->addtext(320,660,10, 'Department',0,0); 				$this->cezpdf->addTextWrap(475,660,80,10, $department,'right',0);
		$this->cezpdf->addtext(320,645,10, 'Position',0,0); 				$this->cezpdf->addTextWrap(440,645,115,10, $position,'right',0);
		$this->cezpdf->addtext(320,630,10, 'Reamining VL',0,0); 			$this->cezpdf->addTextWrap(475,630,80,10, "",'right',0);


        $this->cezpdf->addtext(400,610,10, 'DEDUCTIONS',0,0);    
		$this->cezpdf->addtext(320,595,10, 'Absent/s '.'('.$days_absent.')' ,0,0); 					$this->cezpdf->addTextWrap(475,595,80,10, number_format($days_absent_rate,2) ,'right',0);
		$this->cezpdf->addtext(320,580,10, 'Late / Undertime '.'('.$minutes_late.')',0,0); 		$this->cezpdf->addTextWrap(475,580,80,10, number_format($minutes_late_rate,2) ,'right',0);
		$this->cezpdf->addtext(320,565,10, 'SSS Loan',0,0); 				$this->cezpdf->addTextWrap(475,565,80,10,number_format($sss_loan,2),'right',0);
		$this->cezpdf->addtext(320,550,10, 'HDMF Loan',0,0); 				$this->cezpdf->addTextWrap(475,550,80,10,number_format($hdmf_loan,2),'right',0);
		$this->cezpdf->addtext(320,535,10, 'SSS',0,0); 						$this->cezpdf->addTextWrap(475,535,80,10,number_format($sss_contri,2),'right',0);
		$this->cezpdf->addtext(320,520,10, 'PHILHEALTH',0,0);				$this->cezpdf->addTextWrap(475,520,80,10,number_format($philhealth_contri,2),'right',0);
		$this->cezpdf->addtext(320,505,10, 'HDMF',0,0); 					$this->cezpdf->addTextWrap(475,505,80,10,number_format($pag_ibig_contri,2),'right',0);
		$this->cezpdf->addtext(320,490,10, 'TAX',0,0); 						$this->cezpdf->addTextWrap(475,490,80,10,number_format($tax,2),'right',0);
		$this->cezpdf->addtext(320,475,10, 'Other Deductions',0,0); 		$this->cezpdf->addTextWrap(475,475,80,10,number_format($other_deduc,2),'right',0);
																			$this->cezpdf->addTextWrap(475,468,80,10,'---------------','right',0);
		$this->cezpdf->addtext(320,460,10, 'Total Deductions',0,0); 		$this->cezpdf->addTextWrap(475,460,80,10,number_format($total_deduc,2),'right',0);
																			
		
		$this->cezpdf->addtext(45,430,12, 'Net Pay',0,0); 					$this->cezpdf->addTextWrap(475,430,80,12,number_format($net_pay,2),'right',0);


		$this->cezpdf->line (1,420 ,600, 420);

		$this->cezpdf->ezSetDy(-10);

		$this->cezpdf->ezStream();

		$data1 = $db_data[0];

	

		
	}
	


	function show_payslip_test1($payr_detail_id)
	{
		
	$this->load->library('fpdf/fpdf');
	
		//$this->cezpdf->ezText('Hello World', 12, array('justification' => 'center'));
		//$this->cezpdf->ezSetDy(-10);
 
		$query = $this->db->select('*')
                        ->from('payroll_runs_details')
						->join('employee', 'employee.employee_no=payroll_runs_details.employee_no')
						->where('payroll_runs_details.payr_detail_id', $payr_detail_id)
						->get();
			
		
		$col_names = array(
			'employee_no' => 'EMP #',
			'last_name' => 'Last Name',
			'basic_salary'  => 'Gross',
			'de_minimis_total'  => 'De minimis Total',
			
			'salary_adjust' => 'Adjustments',
			'tax' => 'WTH Tax',
			'total_deduc'=> 'Total Deductions',
			
			'net_pay'=> 'Net Pay'
			
		);
		
        
	



		foreach ($query->result_array() as $row)
			{
		$db_data[] = array('employee_no' => $row['employee_no'],
							'last_name'=>$row['last_name'], 
							'basic_salary'=>$row['basic_salary'],
							'de_minimis_total'=>$row['de_minimis_total'],
							'salary_adjust'=>$row['salary_adjust'],
							'tax'=>$row['tax'],
							'total_deduc'=> $row['total_deduc'], 
							
							'net_pay'=>$row['net_pay']);
		
			}
		


		$options = array(
		'width'=>550,
		'fontSize'=>8,
		'showLines'=>1
				);
		
			
				
		
		//$last_name = $this->db->get()->row()->last_name;
	   
		$pdd = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->payr_id;

		
		//$payroll_date = $this->payrollrunsmodel->get_payroll_date($pdd);
		$pdate = $this->payrollrunsmodel->get_payroll_date($pdd);
		$payroll_coverage = $this->payrollrunsmodel->get_payroll_coverage($pdd);
		$my_pdate = strtotime($pdate);
		
       

		//$payroll_date = strtotime($pdate);
		
		$payroll_date = date("M d,Y", $my_pdate);
		
		

		$employee_no = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->employee_no;
		

		$data1 = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->employee_no;
		
		$last_name = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->last_name;
		
		
		$first_name = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->first_name;
		
		$data2 = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->first_name;
		
		$middle_name = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->middle_name;
		$data3 = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->middle_name;
		

		$tin = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->tin;
		
		$data4 = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->tin;
		

		$sss = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->sss;
		$data5 = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->sss;
		
		
		$philhealth = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->philhealth;

		$footer = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->philhealth;

		$hdmf = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->hdmf;
		


		$position = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->position;
		$department = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->department;

		$basic_salary = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->basic_salary;
		$salary_adjust = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->salary_adjust;
		$de_minimis_total = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->de_minimis_total;

		$days_absent = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->days_absent;
		$minutes_late = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->minutes_late;


		$tax = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->tax;
		$sss_contri = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->sss_contri;
		$philhealth_contri = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->philhealth_contri;
		$pag_ibig_contri = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->pag_ibig_contri;
		$sss_loan = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->sss_loan;
		$hdmf_loan = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->hdmf_loan;

		$other_deduc = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->other_deduc;
		$total_deduc = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->total_deduc;
		$net_pay = $this->payrollrunsmodel->get_payroll_detail($payr_detail_id)->row()->net_pay;

		$totalgross = $basic_salary + $salary_adjust + $de_minimis_total;

		//$image = ImageCreatefromjpeg("https://image.ibb.co/i3uxg6/logo.jpg");
               
				   
		//$image = imagecreatefrompng("images/logo.png");

		//$this->cezpdf->ezImage('logo.png', 0, 547.4, 'none', 'left');
		//$image = "https://image.ibb.co/i3uxg6/logo.jpg";

		//$image2 =  "https://image.ibb.co/iznAEJ/pbo-Global-logo1.png";
		//$this->cezpdf->ezTable($db_data, $col_names, 'Payslip', $options);

        
		
        
	//	$this->cezpdf->addtext(275,650,10, 'PAYSLIP',0,0);       
		//$this->cezpdf->addtext(60,785,10, 'Name',0,0); 					$this->cezpdf->addtext(180,785,10, $last_name .', '.$first_name .' '.$middle_name,0,0);
		//$this->cezpdf->addtext(60,770,10, 'TIN',0,0); 					$this->cezpdf->addtext(180,770,10, $tin,0,0);
		//$this->cezpdf->addtext(60,755,10, 'SSS no',0,0);             	$this->cezpdf->addtext(180,755,10, $sss,0,0);
		//$this->cezpdf->addtext(60,740,10, 'PHILHEALTH No',0,0); 		$this->cezpdf->addtext(180,740,10, $philhealth,0,0);
		//$this->cezpdf->addtext(60,725,10, 'HDMF',0,0); 					$this->cezpdf->addtext(180,725,10, $hdmf,0,0);
		//$this->cezpdf->addtext(60,710,10, 'Remianing SL',0,0); 			$this->cezpdf->addtext(180,710,10, "",0,0);
		//$this->cezpdf->addtext(60,695,10, 'Leave Credit',0,0); 			$this->cezpdf->addtext(180,695,10, "",0,0);
		
		$image_jpg = 'https://image.ibb.co/i3uxg6/logo.jpg';



		$pdf = new FPDF();
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','B',16);

		$pdf->Cell(40,10,'Hello World!');

		$pdf->Cell(40,20,'Hello World!');

			
		
		$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');

		$data = array('Country1', 'Capital1', 'Area (sq km)1', 'Pop. (thousands)1');
// Data loading
//$data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->AddPage();
$thpdfis->FancyTable($header,$data);


		$pdf->Output();
		

	    

		
	}

	


	function delete_payr_detail($payr_detail_id, $mid)
	{
	 $data['Users'] = (array)$this->payrollrunsmodel->get_by_payr_detail_id($payr_detail_id)->row();
	 $id = $data['Users']['payr_detail_id'];
	 
		
	 // delete user
	 	$this->payrollrunsmodel->delete_payr_detail($payr_detail_id);
	 	
	// redirect to payroll detail page
		 redirect('payrollruns/view/'.$mid,'Refresh');
		 
	 	}

	
		 

	function delete($id)
	{
	 $data['Users'] = (array)$this->payrollrunsmodel->get_by_id($id)->row();
	 $id = $data['Users']['payr_id'];
	 
		
	 // delete user
	 	$this->payrollrunsmodel->delete($id);
	 	
	// redirect to Student list page
	 	redirect('payrollruns/index/delete_success','Refresh');
	 	}
 
	// validation rules
	 
	
	 
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
	 
	 
	
	 function _set_rules(){
		
		$this->form_validation->set_rules('Rolename', 'priviledge_group');
		$this->form_validation->set_rules('Operator', 'operator');
	//		$this->form_validation->set_rules('tbl_id', 'tbl_id', 'required|min_length[4]|max_length[20]|is_unique[sss-table.tbl_id]');
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

			 
		
   }

	

	
	
	

?>