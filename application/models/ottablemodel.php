<?php 

class Ottablemodel extends CI_Model{

	private $primary_key='ottable_id';
	
	private $table_name='ottable';
	
		function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by($this->primary_key,'asc');
		//$this->db->join('Rolename', 'users.Username = usersinroles.Username');
	}
	//else{
		$query = $this->db->select('*')
                        ->from('ottable')
                        //->join('usersinroles', 'users.Username= usersinroles.Username')
						//->like('sss-table.salary_credit', $filter, 'after')
                        ->get('', $limit, $offset); 
				   
		//$this->db->order_by($order_column,$order_type);
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
	//}
	}

    function get_by_id($id){	
	$this->db->select('*')                        
						->where('ottable.ottable_id',$id);
                        //->join('employee_details', 'employee.employee_no=employee_details.employee_no');
                        //->get('', $limit, $offset); 	
	return $this->db->get($this->table_name);
	}


	function add_new_otdata($type, $rate, $OT, $ND)
	{
				
		$new_insert_data= array(
				'type' => $type,				
				'rate' => $rate,				
				'OT' => $OT,				
				
				'ND'=>$ND
				
				);
				





		
		
			//$cm	= array(				
			//	'Username' => $Username,			
								
			//	);
											
				//$insert = 
				$this->db->insert('ottable',$new_insert_data );
				//$this->db->insert('employee_details',$new_member_insert_data1);
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