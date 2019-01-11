<?php 

class Companyprofilemodel extends CI_Model{

	private $primary_key='co_id';
	
	private $table_name='company_profile';
	
		function __construct(){
	parent::__construct();
	}

	
	function get_by_id($id){	
	$this->db->select('*')                        
						->where('company_profile.co_id',$id);
                        //->join('employee_details', 'employee.employee_no=employee_details.employee_no');
                        //->get('', $limit, $offset); 	
	return $this->db->get($this->table_name);
	}


	function add_new_ssstable($co_id, $min_range, $max_range, $salary_credit, $ss_er, $ss_ee, $ss_total, $ec_er, $total_contri, $se_vm_ofw_total_contri, $effectivedate)
	
	{
				
		$new_member_insert_data= array(
				'co_id' => $co_id,				
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
				$this->db->insert('company_profile',$new_member_insert_data );
				
				//$this->db->insert('current_month',$cm);				
				return ;
				
	
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