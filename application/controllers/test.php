<?php
class Test extends CI_Controller{

	function __construct()
 	{
		parent::__construct();
	 	#load library 
	 	$this->load->library(array('table','form_validation'));
	 	$this->load->helper(array('form', 'url'));
	 	$this->load->model('testmodel','',TRUE);
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


	function index(){
		
		

		
		//$data['d']=$this->testmodel->get_result();
	//	$this->load->view('welcome_message.php',$data);//$data is an array which is sent to view
		

	

		  
		$data['Role']=$this->session->userdata('role');
		$un=$this->session->userdata('username');
		

		
        
		$emp_no = $this->testmodel->get_employee_no($un);

		   echo $emp_no; 
		

		$this->load->view('pages/template/header3');
		//$this->load->view('pages/template/nav',$data);
		//$this->load->view('pages/template/nav',$data);
		
		//$this->load->view('pages/template/header2');
		$this->load->view('pages/test_view',$data);
		
		
		
		/*
		$this->Datagrid->hidePkCol(true);
		$this->Datagrid->ignoreFields(array('password'));
		$this->Datagrid->setHeadings(array('email'=>'E-mail'));
		if($error = $this->session->flashdata('form_error')){
			echo "<font color=red>$error</font>";
		}
		echo form_open('test/proc');
		echo $this->Datagrid->generate();
		echo Datagrid::createButton('delete','Delete');
		echo form_close();
		*/
	}
	


	
           
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
		
        
		$this->cezpdf->addtext(275,810,10, 'PAYSLIP',0,0);       
		$this->cezpdf->addtext(60,785,10, 'Name',0,0); 					$this->cezpdf->addtext(180,785,10, $last_name .', '.$first_name .' '.$middle_name,0,0);
		$this->cezpdf->addtext(60,770,10, 'TIN',0,0); 					$this->cezpdf->addtext(180,770,10, $tin,0,0);
		$this->cezpdf->addtext(60,755,10, 'SSS no',0,0);             	$this->cezpdf->addtext(180,755,10, $sss,0,0);
		$this->cezpdf->addtext(60,740,10, 'PHILHEALTH No',0,0); 		$this->cezpdf->addtext(180,740,10, $philhealth,0,0);
		$this->cezpdf->addtext(60,725,10, 'HDMF',0,0); 					$this->cezpdf->addtext(180,725,10, $hdmf,0,0);
		$this->cezpdf->addtext(60,710,10, 'Remianing SL',0,0); 			$this->cezpdf->addtext(180,710,10, "",0,0);
		$this->cezpdf->addtext(60,695,10, 'Leave Credit',0,0); 			$this->cezpdf->addtext(180,695,10, "",0,0);
		



        $this->cezpdf->addtext(105,680,10, 'COMPENSATION',0,0);   
		$this->cezpdf->addtext(60,665,10, 'Basic',0,0); 					$this->cezpdf->addTextWrap(180,665,55,10,number_format($basic_salary,2),'right',0);
		$this->cezpdf->addtext(60,650,10, 'Salary Adjustment',0,0); 		$this->cezpdf->addTextWrap(180,650,55,10,number_format($salary_adjust,2),'right',0);
		$this->cezpdf->addtext(60,635,10, 'De minimis Benefits',0,0); 		$this->cezpdf->addTextWrap(180,635,55,10,number_format($de_minimis_total,2),'right',0);
		$this->cezpdf->addtext(60,620,10, '',0,0); 							$this->cezpdf->addTextWrap(180,620,55,'','right',0);
		$this->cezpdf->addtext(60,605,10, '',0,0); 							$this->cezpdf->addTextWrap(180,605,55,10,'','right',0);
		$this->cezpdf->addtext(60,590,10, ' ',0,0); 						$this->cezpdf->addTextWrap(180,590,55,10,"",'right',0);
        $this->cezpdf->addtext(60,575,10, ' ',0,0); 						$this->cezpdf->addTextWrap(180,575,55,10,"",'right',0);
		$this->cezpdf->addtext(60,560,10, ' ',0,0); 						$this->cezpdf->addTextWrap(180,560,55,10,"",'right',0);
		$this->cezpdf->addtext(60,545,10, '',0,0); 							$this->cezpdf->addTextWrap(180,545,55,10,"",'right',0);
		$this->cezpdf->addtext(60,530,10, 'Total Compensation',0,0); 		$this->cezpdf->addTextWrap(180,530,55,10,number_format($totalgross,2),'right',0);

		
	    $this->cezpdf->addtext(320,785,10, 'Employee No.',0,0); 			$this->cezpdf->addtext(475,785,10, $employee_no,0,0);
		$this->cezpdf->addtext(320,770,10, 'Payroll Date',0,0); 			$this->cezpdf->addtext(475,770,10, $payroll_date,0,0);
		$this->cezpdf->addtext(320,755,10, 'Date Covered',0,0);            	$this->cezpdf->addtext(475,755,10, $payroll_coverage,0,0);
		$this->cezpdf->addtext(320,740,10, 'Tax Status',0,0); 				$this->cezpdf->addtext(475,740,10, "",0,0);
		$this->cezpdf->addtext(320,725,10, 'Department',0,0); 				$this->cezpdf->addtext(475,725,10, $department,0,0);
		$this->cezpdf->addtext(320,710,10, 'Position',0,0); 				$this->cezpdf->addtext(475,710,10, $position,0,0);
		$this->cezpdf->addtext(320,695,10, 'Reamining VL',0,0); 			$this->cezpdf->addtext(475,695,10, "",0,0);


        $this->cezpdf->addtext(385,680,10, 'DEDUCTIONS',0,0);    
		$this->cezpdf->addtext(320,665,10, 'Absent',0,0); 					$this->cezpdf->addTextWrap(475,665,55,10, $days_absent ,'right',0);
		$this->cezpdf->addtext(320,650,10, 'Late / Undertime',0,0); 		$this->cezpdf->addTextWrap(475,650,55,10, $minutes_late ,'right',0);
		$this->cezpdf->addtext(320,635,10, 'SSS Loan',0,0); 				$this->cezpdf->addTextWrap(475,635,55,10,number_format($sss_loan,2),'right',0);
		$this->cezpdf->addtext(320,620,10, 'HDMF Loan',0,0); 				$this->cezpdf->addTextWrap(475,620,55,10,number_format($hdmf_loan,2),'right',0);
		$this->cezpdf->addtext(320,605,10, 'SSS',0,0); 						$this->cezpdf->addTextWrap(475,605,55,10,number_format($sss_contri,2),'right',0);
		$this->cezpdf->addtext(320,590,10, 'PHILHEALTH',0,0);				$this->cezpdf->addTextWrap(475,590,55,10,number_format($philhealth_contri,2),'right',0);
		$this->cezpdf->addtext(320,575,10, 'HDMF',0,0); 					$this->cezpdf->addTextWrap(475,575,55,10,number_format($pag_ibig_contri,2),'right',0);
		$this->cezpdf->addtext(320,560,10, 'TAX',0,0); 						$this->cezpdf->addTextWrap(475,560,55,10,number_format($tax,2),'right',0);
		$this->cezpdf->addtext(320,545,10, 'Other Deductions',0,0); 		$this->cezpdf->addTextWrap(475,545,55,10,number_format($other_deduc,2),'right',0);
		$this->cezpdf->addtext(320,530,10, 'Total Deductions',0,0); 		$this->cezpdf->addTextWrap(475,530,55,10,number_format($total_deduc,2),'right',0);
		
		$this->cezpdf->addtext(60,500,12, 'Net Pay',0,0); 					$this->cezpdf->addTextWrap(475,500,55,12,number_format($net_pay,2),'right',0);

		
		



		//$this->cezpdf->addtext(20,740,10, 'PAYSLIP',0,0); 


		/*
		$this->cezpdf->ezSetDy(-5);
		//$this->cezpdf->ezText('Name:'.' '.$last_name .', '.$first_name .' '.$middle_name , 10, array('justification' => 'left'));  
   
		//$this->cezpdf->ezSetDy(-10);
		//$this->cezpdf->ezText('TIN'.' '.$tin  , 10, array('justification' => 'left'));
		//$this->cezpdf->ezSetDy(-2);
		$this->cezpdf->ezText('SSS No'.' '.$sss  , 10, array('justification' => 'left'));
		$this->cezpdf->ezSetDy(-2);
		$this->cezpdf->ezText('PHILHEALTH No'.' '.$philhealth  , 10, array('justification' => 'left'));
		$this->cezpdf->ezSetDy(-2);
		$this->cezpdf->ezText('HDMF'.' '.$hdmf  , 10, array('justification' => 'left'));



		
		$this->cezpdf->ezSetDy(-10);
		$this->cezpdf->ezText('Basic'.' '.number_format($basic_salary,2)  , 10, array('justification' => 'left'));
		$this->cezpdf->ezSetDy(-2);
		$this->cezpdf->ezText('Salary Adjustment'.' '.number_format($salary_adjust,2)   , 10, array('justification' => 'left'));
		$this->cezpdf->ezSetDy(-2);
		$this->cezpdf->ezText('De minimis Benefits'.' '.number_format($de_minimis_total,2)   , 10, array('justification' => 'left'));
		$this->cezpdf->ezSetDy(-2);
		$this->cezpdf->ezText('Total Compensation'.' '.number_format($totalgross,2)   , 10, array('justification' => 'left'));
		

		//$this->cezpdf->ezText(</table> , 12, array('justification' => 'left'));
 
          */

		$this->cezpdf->ezSetDy(-10);

			  
		


		$this->cezpdf->ezStream();

		$data1 = $db_data[0];

	

		
	}


	function proc($request_type = ''){
		$this->load->helper('url');
		if($action = Datagrid::getPostAction()){
			$error = "";
			switch($action){
				case 'delete' :
					if(!$this->Datagrid->deletePostSelection()){
						$error = 'Items could not be deleted';
					}
				break;
			}
			if($request_type!='ajax'){
				$this->load->library('session');
				$this->session->set_flashdata('form_error',$error);
				redirect('test/index');
			} else {
				echo json_encode(array('error' => $error));
			}
		} else {
			die("Bad Request");
		}
	}

}

?>