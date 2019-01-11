<?php 

class Payroll_execommodel extends CI_Model{

	private $primary_key='payr_id';
	private $table_name='payroll_runs';
	private $table_name1='employee';
	
	function __construct(){
		parent::__construct();
	}

	function get_paged_list($limit, $offset, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		
		//	$this->db->order_by($this->primary_key,'asc');
			$this->db->order_by('last_name','asc');
	
	}
		$query = $this->db->select('*')
                        ->from('payroll_runs')
                        //->join('usersinroles', 'users.Username= usersinroles.Username')
						->like('payroll_runs.year', $filter, 'after')
						->get('', $limit, $offset); 
				   
		return $query;
	}


    function get_by_payr_detail_id($id){	
			$this->db->select('*')                        
			->where('payroll_runs_details.payr_detail_id',$id);
    	return $this->db->get('payroll_runs_details');
	}

       
	function get_by_payrollrun_status($id){	
		$this->db->select('execom_status');   
		$this->db->from('payroll_runs');  
		$this->db->where('payr_id',$id);
		$stat = $this->db->get()->row()->execom_status;

	   return $stat;
	}
	
	function get_by_payrollrun_status_posting($id){	
		$this->db->select('status');   
		$this->db->from('payroll_runs');  
		$this->db->where('payr_id',$id);
		$stat = $this->db->get()->row()->status;

	   return $stat;
	}
	
	function get_by_payrollrun_status_desc($id){	
		$this->db->select('description');   
		$this->db->from('payroll_runs');  
		$this->db->where('payr_id',$id);
		$desc = $this->db->get()->row()->description;

	   return $desc;
	}
	

	


	function get_show_employee($limit, $offset=0,$order_column, $order_type){
		if(empty($order_column)||empty($order_type)){		
	}
	  
		$query = $this->db->select( 'employee_no,last_name,first_name,status, department, type')
						->from('employee')
                        //->join('usersinroles', 'users.Username= usersinroles.Username')
						->where('employee.status', 'Active')
						->order_by($order_column,'ASC')
                        //;
                        ->get('', $limit, $offset); 
				   

		return $query;
	}

    function get_show_employee2($limit, $offset=0, $order_column='', $order_type='asc'){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
			}
		$sql = "SELECT 
					CONCAT('<input name=\"row_', 'id',  '\" type=\"checkbox\" value=\"row_', 'id',  '\" />') AS First_Column, 
					employee_no, 
					last_name,
					first_name,
					status 

	 				FROM 
					'employee' 
					ORDER BY
					'last_name' 
					 ";
				$query = $this->db->query($sql);

				   
		return $query;
	}




	function add_new_payrollruns($year, $month, $period, $payrollrun_type, $description, $transact_date)
	{
		$status = 'unposted';
		$new_data= array(
							
				'year' => $year,				
				'month' => $month,				
				'period' => $period,	
				'payrollrun_type'=> $payrollrun_type,
				'description' => $description, 
				'transact_date'=>$transact_date, 
				'status'=>$status
				);
				
				$this->db->insert('payroll_runs',$new_data );
			
			return ;
	
		}


	

		function get_processed_payroll($limit, $offset, $order_column, $order_type){
		   		
			if(empty($order_column)||empty($order_type)){		
				//$this->db->order_by($this->primary_key1,'asc');
				//$this->db->join('Rolename', 'users.Username = usersinroles.Username');
			}
			//else{
				//$query = $this->db->select("CONCAT('<input name=\"row_', 'id',  '\" type= \"checkbox\" value=\"row_', 'id',  '\" />') AS First_Column,employee_no,last_name,first_name,  status")
			  
				$query = $this->db->select( '*')
			  
								->from('payroll_runs_details')
								->join('payroll_runs', 'payroll_runs_details.payr_id = payroll_runs.payr_id')
								->join('employee', 'payroll_runs_details.employee_no = employee.employee_no')
	
	
								->where('payroll_runs_details.payr_id', $order_column)
								->order_by('employee.last_name', 'ASC')
								//;
								->get('', $limit, $offset); 
						   
				$this->db->order_by("last_name");
				//return $this->db->get($this->table_name, $limit, $offset);
		
				return $query;
	
	
		}	

	function get_payrollrun($id){
		$limit =  10;
		$offset = 0;
		$query = $this->db->select( '*')->from('payroll_runs')->where('payr_id', $id)
		//;
		->get('', $limit, $offset); 
   		return $query;

	}

	
     

    function get_employee_no($un){
		
		$this->db->select('employee_no');
		$this->db->from('users');
		$this->db->where('Username',$un);
		$un = $this->db->get()->row()->employee_no;
       
		return $un;    
    }
    

	function get_by_employee_detail($id){	
		$this->db->select('*')                        
		->where('employee_details.employee_no',$id);
		return $this->db->get('employee_details');
	}



	
	
	function get_employee_details($id){
		
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where('employee_no',$id);
		
       
		return $this->db->get();    
	}
	
	

	function get_payroll_date($pdd){

		$this->db->select('transact_date');
		$this->db->from('payroll_runs');
		$this->db->where('payr_id',$pdd);
		
		$pd =  $this->db->get()->row()->transact_date;

		return $pd;

	}

	function get_payroll_coverage($pdd){

		$this->db->select('description');
		$this->db->from('payroll_runs');
		$this->db->where('payr_id',$pdd);
		
		$pd =  $this->db->get()->row()->description;

		return $pd;

	}

	function get_payroll_detail($payr_detail_id){
		
		$this->db->select('*');
		$this->db->from('payroll_runs_details');
		$this->db->join('employee', 'employee.employee_no=payroll_runs_details.employee_no');
		$this->db->where('payroll_runs_details.payr_detail_id', $payr_detail_id);
              
		return $this->db->get();    
	}
	
	function compute_tax($net_taxable, $choice, $type){
	
	 if ($type == 'Direct Employment'  || $type == 'Contractual'  ) {
		//pwt
		$this->db->select('pwt');
		$this->db->from('tax-table');
		$this->db->where('salary_min <=',$net_taxable);
		$this->db->where('salary_max >=',$net_taxable);
		$pwt =  $this->db->get()->row()->pwt;

		//multiplier

		$this->db->select('multiplier');
		$this->db->from('tax-table');
		$this->db->where('salary_min <=',$net_taxable);
		$this->db->where('salary_max >=',$net_taxable);
		
		$multiplier =  $this->db->get()->row()->multiplier;
		 
		//get min salary
		$this->db->select('salary_min');
		$this->db->from('tax-table');
		$this->db->where('salary_min <=',$net_taxable);
		$this->db->where('salary_max >=',$net_taxable);
		
		$salary_min =  $this->db->get()->row()->salary_min;
	
		$tax = $pwt + (($net_taxable - $salary_min) * $multiplier) ;
		 
		} else {
		 
		$this->db->select('multiplier');
		$this->db->from('tax-table');
		$this->db->where('tax_desc','Consultant');
				
		$multiplier =  $this->db->get()->row()->multiplier;
			
		$tax = $net_taxable * $multiplier;

		}



        return $tax;
	}

	
	


	function insert_to_payroll_run_details($Employees1){
		return $this->db->insert('payroll_runs_details',$Employees1);

	}

	function count_all(){
		return $this->db->count_all($this->table_name);
	}

	function count_all_es(){
		return $this->db->count_all($this->table_name1);
	}


	function save($person){
		$this->db->insert($this->table_name,$person);
		return $this->db->insert_id();
	}

	function update($id,$person1){
		$this->db->where($this->primary_key,$id);
		$this->db->update($this->table_name,$person1);
	}
	
	
    function update_paytoll_runs_details($detail_id,$User1){

		$this->db->where('payr_detail_id',$detail_id);
		$this->db->update('payroll_runs_details',$User1);

	}

	function delete($id){
		$this->db->where($this->primary_key,$id);
		$this->db->delete($this->table_name);
	}


	function get_by_payr_detail_id1($id){	
		$this->db->select('*')                        
							->where('payroll_runs_details.payr_detail_id',$id);
		return $this->db->get('payroll_runs_details');
		}

	function delete_payr_detail($id){
		$this->db->where('payr_detail_id',$id);
		$this->db->delete('payroll_runs_details');
	}
	
	
}

?>