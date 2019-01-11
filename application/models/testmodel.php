<?php 

class testmodel extends CI_Model{

	private $primary_key='tax_id';
	
	private $table_name='tax-table';
	
		function __construct(){
	parent::__construct();
	}

  

   function get_result()
   {
     //$query=$this->db->query("your custom query;");
     //return $query->result_array();//return the result_array to the controller.

      $this->db->select('salary_min');
      $this->db->from('tax-table');
     $this->db->where('tax_id',$tax_id);
     $min_sal = $this->db->get()->row()->salary_min;

     return $min_sal;
   }
    


	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
		//$this->db->join('Rolename', 'users.Username = usersinroles.Username');
	}
	//else{
		$query = $this->db->select('*')
                        ->from('tax-table')
                        //->join('usersinroles', 'users.Username= usersinroles.Username')
						//->like('taxtable.salary_credit', $filter, 'after')
                        ->get('', $limit, $offset); 
				   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
	//}
	}

    function get_by_id($id){	
	$this->db->select('*')                        
						->where('tax-table.tax_id',$id);
                        //->join('employee_details', 'employee.employee_no=employee_details.employee_no');
                        //->get('', $limit, $offset); 	
	return $this->db->get($this->table_name);
	}


	function add_new_taxtable($tbl_id, $min_range, $max_range, $salary_credit, $ss_er, $ss_ee, $ss_total, $ec_er, $total_contri, $se_vm_ofw_total_contri, $effectivedate)
	
	{
				
		$new_member_insert_data= array(
				'tbl_id' => $tbl_id,				
				'min_range' => $min_range,				
				'max_range' => $max_range,				
				'salary_credit' => $salary_credit,	
				'ss_er'=> $ss_er,
				'ss_ee' => $ss_ee, 
				'ss_total'=>$ss_total, 
				'ec_er'	=>$ec_er,
				'total_contri'=>$total_contri ,		
				'se_vm_ofw_total_contri'=>$se_vm_ofw_total_contri,
				'effectivedate'=>$effectivedate
				
				
				);
				

											
				//$insert = 
				$this->db->insert('taxtable',$new_member_insert_data );
				
				//$this->db->insert('current_month',$cm);				
				return ;
				
	
		}
   
	
       
    function get_employee_no($un){
		
		$this->db->select('employee_no');
		$this->db->from('users');
		$this->db->where('Username',$un);
		$un = $this->db->get()->row()->employee_no;
       
		return $un;    
	}



	function get_payroll_date($pdd){

		$this->db->select('transact_date');
		$this->db->from('payroll_runs');
		$this->db->where('payr_id',$pdd);
		
		$pd =  $this->db->get()->row()->transact_date;

		return $pd;

	}

		
	function count_all(){
	return $this->db->count_all($this->table_name);
	}





	function save($person){
	$this->db->insert($this->table_name,$person);
	return $this->db->insert_id();
	}

	function update($id,$person1){
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$person1);
	
	
	
	
	}

	function delete($id){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	
	
	}


	
	
	
	
}

?>