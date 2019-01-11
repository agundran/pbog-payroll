<?php 

class Samplereportexcelmodel extends CI_Model{


    public function employeeList() {
        $this->db->select(array('e.employee_no', 'e.last_name', 'e.first_name', 'e.position', 'e.department', 'e.status'));
        $this->db->from('employee as e');
        $query = $this->db->get();
        return $query->result_array();
    }

	
	
	
	
	
}

?>