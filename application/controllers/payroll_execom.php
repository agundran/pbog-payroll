<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
session_start();
require_once("system/core/Common.php");
class Payroll_execom extends CI_Controller
{
	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('payroll_execommodel','',TRUE);
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

	
	function index($offset = 0, $order_column = 'last_name', $order_type = 'asc')
	{
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = 'last_name';
		if (empty($order_type)) $order_type = 'asc';
	
	$filter  = $this->input->post('ShortName');
	$limit =  50;
	//TODO: check for valid column
	// load data
	$Users = $this->payroll_execommodel->get_paged_list($limit, $offset, $order_column, $order_type, $filter)->result();
	// generate pagination
	$this->load->library('pagination');
	$config['base_url'] = site_url('/payrollrun_execom/index');
	$config['total_rows'] = $this->payroll_execommodel->count_all();
	
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
		   'ID','Year','Month','Period','Type', 'Description', 'Date','Status','Actions','');

		 $upd = array(
			   'width'      => '200',
			  'height'     => '200',
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
		$Users->execom_status,
		
	     //anchor_popup('payrollruns/update/'.$Users->payr_id,'Update',array('class'=>'update'), $upd).' &nbsp '.
		
		anchor('payroll_execom/view/'.$Users->payr_id,'View',array('class'=>'view')),
		
		//anchor('payrollruns/process_payroll/'.$Users->payr_id.'/'.$Users->period,'Process',array('class'=>'process_payroll')).' &nbsp '.
		//anchor_popup('payrollruns/show_employees/'.$Users->payr_id,'Create',array('class'=>'show_employees')),
		//anchor('payrollruns/create/'.$Users->payr_id,'Create',array('class'=>'create','onclick'=>"return confirm('Create new run?')",
		anchor('payroll_execom/approved/'.$Users->payr_id,'Approve',array('class'=>'approve','onclick'=>"return confirm('You are about to Approved a Payrollrun data, Continue?')"	))
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
	
	if (($data['Role'] == "SuperAdmin") || ($data['Role'] == "Execom") ){
		$this->load->view('pages/payrollexecom_view', $data);
		//$this->load->view('pages/unauth_view', $data);
		
	} else
		
		{
		
			$this->load->view('pages/unauth_view', $data);
			//$this->load->view('pages/payrollruns_view', $data);
		}
	$this->load->view('pages/template/footer');

	}

	function approved($id){
		  
		$sstat = $this->payroll_execommodel->get_by_payrollrun_status($id);
		//$stat = $this->payroll_execommodel->get_by_payrollrun_status_posting($payr_id);
		$desc = $this->payroll_execommodel->get_by_payrollrun_status_desc($id);
		

		if ($sstat == 'Approved'){
			$message = "Payroll for ".$desc." already Approved!";
			if ((isset($message)) && ($message != '')) {
				echo '<script>
				alert("'.str_replace(array("\r","\n"), '', $message).'");
				window.location.href="../payroll_execom/index/";
				  </script>';
				 }
		} else {
		
		$status = "Approved";
		$User1 = array(
			'execom_status' => $status
			);
		 
		$this->db->where('payr_id',$id);
		$this->db->update('payroll_runs',$User1);
		
               		//redirect('payroll_execom/index/','Refresh');
		$message = "Payroll for ".$desc." is Approved!";
		 if ((isset($message)) && ($message != '')) {
			 echo '<script>
			alert("'.str_replace(array("\r","\n"), '', $message).'");
			 window.location.href="../payroll_execom/index/";
			   </script>';
		 }


		}

	}
	
	function view($id)
	{
		if (empty($offset)) $offset = 0;
		if (empty($order_column)) $order_column = $id;
		if (empty($order_type)) $order_type = 'asc';
		
		$limit =  100;
		$Users = $this->payroll_execommodel->get_processed_payroll($limit, $offset, $order_column, $order_type)->result();
		
		$this->load->library('pagination');
		$config['base_url'] = site_url('/payroll_execom/view');
		$config['total_rows'] = $this->payroll_execommodel->count_all();
		
		if(isset($post['sel']) && !empty($post['sel']))
                $config['per_page'] = $post['sel'];
                else
                $config['per_page'] = 10;
				
		//$config['per_page'] =$limit;
		
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

	
		$pr = $this->payroll_execommodel->get_payrollrun($id)->result();
		

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
		$data['link_back'] = anchor('/payroll_execom/','Back to payroll runs table',array('class'=>'back'));

		$data['print_report'] = anchor('/payrollruns/exportXLS/'.$id,'Export to Excel',array('class'=>'print'));

		  
		
            

		$this->load->view('pages/template/header');
		$this->load->view('pages/template/nav',$data);
		if (($data['Role'] == "SuperAdmin") || ($data['Role'] == "Execom"))
		{
			$this->load->view('pages/payrollrunsprocessed_view', $data);

			} else
		{
    	      $this->load->view('pages/unauth_view', $data);
			//$this->load->view('pages/payrollrunsprocessed_view', $data);
		}
		
		$this->load->view('pages/template/footer');
        

	}



    //function for adding new payroll run
	
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
	   
		$pdd = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->payr_id;

		
		//$payroll_date = $this->payroll_execommodel->get_payroll_date($pdd);
		$pdate = $this->payroll_execommodel->get_payroll_date($pdd);
		$payroll_coverage = $this->payroll_execommodel->get_payroll_coverage($pdd);
		$my_pdate = strtotime($pdate);
		
       

		//$payroll_date = strtotime($pdate);
		
		$payroll_date = date("M d,Y", $my_pdate);
		
		

		$employee_no = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->employee_no;
		$last_name = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->last_name;
		$first_name = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->first_name;
		$middle_name = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->middle_name;
		
		$tin = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->tin;
		$sss = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->sss;
		$philhealth = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->philhealth;
		$hdmf = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->hdmf;
		


		$position = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->position;
		$department = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->department;

		$basic_salary = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->basic_salary;
		$salary_adjust = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->salary_adjust;
		$de_minimis_total = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->de_minimis_total;

		$days_absent = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->days_absent;
		$minutes_late = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->minutes_late;


		$tax = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->tax;
		$sss_contri = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->sss_contri;
		$philhealth_contri = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->philhealth_contri;
		$pag_ibig_contri = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->pag_ibig_contri;
		$sss_loan = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->sss_loan;
		$hdmf_loan = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->hdmf_loan;

		$other_deduc = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->other_deduc;
		$total_deduc = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->total_deduc;
		$net_pay = $this->payroll_execommodel->get_payroll_detail($payr_detail_id)->row()->net_pay;

		$totalgross = $basic_salary + $salary_adjust + $de_minimis_total;

		$image = "https://image.ibb.co/eLoxNq/pbo-heading.png";

		$image2 =  "https://image.ibb.co/iznAEJ/pbo-Global-logo1.png";
	
		$this->cezpdf->addtext(45,805,10, 'PBO GLOBAL INC',0,0);
		$this->cezpdf->addtext(45,795,8, 'Unit B, 5th Floor, Clark Center 7',0,0); 
		$this->cezpdf->addtext(45,785,8, 'Jose Abad Santos Ave., Clark Freeport Zone',0,0); 	
		$this->cezpdf->addtext(45,775,8, 'Pampanga, Philippines 2023',0,0);  	

		$this->cezpdf->addtext(275,740,10, 'PAYSLIP',0,0);       


		$this->cezpdf->addtext(45,720,10, 'Name',0,0); 					$this->cezpdf->addTextWrap(100,720,180,10, $last_name .', '.$first_name ,'right',0);
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
	

	

	function delete_payr_detail($payr_detail_id, $mid)
	{
	 $data['Users'] = (array)$this->payroll_execommodel->get_by_payr_detail_id($payr_detail_id)->row();
	 $id = $data['Users']['payr_detail_id'];
	 
		
	 // delete user
	 	$this->payroll_execommodel->delete_payr_detail($payr_detail_id);
	 	
	// redirect to payroll detail page
		
	
		redirect('payrollruns/view/'.$mid,'Refresh');
		 
	 	}

	
		 

	function delete($id)
	{
	 $data['Users'] = (array)$this->payroll_execommodel->get_by_id($id)->row();
	 $id = $data['Users']['tbl_id'];
	 
		
	 // delete user
	 	$this->payroll_execommodel->delete($id);
	 	
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