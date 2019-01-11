<?php 

class Employeelistmodel extends CI_Model{

	private $primary_key='employee_no';
	private $primary_key2='employee_no';
	private $table_name='employee';
	private $table_name2='employee_details';
	
		function __construct(){
	parent::__construct();
	}

	
	function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
		if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('last_name','asc');
		//$this->db->join('Rolename', 'users.Username = usersinroles.Username');
	}
	//else{
		$query = $this->db->select('*')
                        ->from('employee')
                        //->join('usersinroles', 'users.Username= usersinroles.Username')
						->like('employee.last_name', $filter, 'after')
						->order_by('employee.last_name', 'asc')
                        ->get('', $limit, $offset); 
				   
						
		//return $this->db->get($this->table_name, $limit, $offset);
		return $query;
	//}
	}
	 
	function get_tax_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $filter){
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
						->where('employee.employee_no',$id)
                        ->join('employee_details', 'employee.employee_no=employee_details.employee_no');
                        //->get('', $limit, $offset); 	
	return $this->db->get($this->table_name);
	}
	
	

	function add_new_employee($employee_no, $last_name, $first_name, $middle_name, $position, $department, $status,$type, $date_hire, $bank_name, $bank_accnt_no, $philhealth, $sss, $hdmf, $tin, $basic_salary,$de_minimis_non, $de_minimis_taxable,  $sss_contri, $philhealth_contri, $hdmf_contri, $daily_rate, $hourly_rate)
	{
				
		$new_member_insert_data= array(
				'employee_no' => $employee_no,				
				'last_name' => $last_name,				
				'first_name' => $first_name,				
				'middle_name' => $middle_name,	
				'position'=> $position,
				'department' => $department, 
				'status'=>$status, 
				'type' => $type,
				'date_hire'	=>$date_hire,
				'bank_name'	=>$bank_name,
				'bank_accnt_no'	=>$bank_accnt_no,
				'philhealth'=>$philhealth ,		
				'sss'=>$sss,
				'hdmf'=>$hdmf,
				'tin'=>$tin
				
				);
				



			
			 

			 

		$new_member_insert_data1= array(				
				//'detail_id' => $detail_id,		
				'employee_no' => $employee_no,		
				'basic_salary' => $basic_salary,	
				'de_minimis_non' => $de_minimis_non, 
				'de_minimis_taxable' => $de_minimis_taxable,

				'daily_rate' =>$daily_rate,
				'hourly_rate' =>$hourly_rate,
				'sss_contri' => $sss_contri,		
				'philhealth_contri' => $philhealth_contri,		
				'hdmf_contri' => $hdmf_contri,
				
								
				);
		
			//$cm	= array(				
			//	'Username' => $Username,			
								
			//	);
											
				//$insert = 
				$this->db->insert('employee',$new_member_insert_data );
				$this->db->insert('employee_details',$new_member_insert_data1);
				//$this->db->insert('current_month',$cm);				
				return ;
				
	
		}

	
		function create_user($employee_no,$Rolename, $Operator, $Username, $Password, $Email){
			$application_name = 'PBOPORTAL';
			$password_question= 'What am I doing here?';
			$password_answer='Jw4WJqBOA2hYxSfoop9z/pAC+38=';
			$charid = strtolower(md5(uniqid(rand(), true)));
				$hyphen = chr(45);// "-"
			  $creationdate =  date("Y-m-d H:i:s");
			$nodate = "0000-00-00 00:00:00";
			$initialctr = 0;
			$initialctr1 = 1;
			
			$myguid = substr($charid, 0, 8).$hyphen.substr($charid, 8, 4).$hyphen.substr($charid,12, 4).$hyphen.substr($charid,16,4).$hyphen.substr($charid,20,12); 
			
			$new_member_insert_data= array(
			'PKID' => $myguid,		
			'employee_no' => $employee_no,		
			'Username' => $Username,				
			'ApplicationName' => $application_name,				
			'Email' => $Email,	
			'IsApproved'=> $initialctr1,
			'LastActivityDate' => $creationdate, 
			'LastPasswordChangedDate'=>$creationdate, 
			'LastLoginDate'	=>$creationdate,
			'CreationDate'=>$creationdate ,		
			'LastLockedOutDate'=>$nodate,
			'IsLockedOut'=>$initialctr,
			'FailedPasswordAttemptCount'=>$initialctr,
			'FailedPasswordAnswerAttemptCount'=>$initialctr,
			'FailedPasswordAttemptWindowStart'=>$nodate ,
			
			'FailedPasswordAnswerAttemptWindowStart'=>$nodate ,
			'Operator' => $Operator,
			'PasswordQuestion' => $password_question,				
			'PasswordAnswer' => $password_answer,				
			'Password' => $this->encryptIt($Password));
			
			$new_member_insert_data1= array(				
			'Username' => $Username,			
			'ApplicationName' => $application_name,				
			'Rolename' => $Rolename,
							
			);
	
		//$cm	= array(				
		//	'Username' => $Username,			
							
		//	);
										
			//$insert = 
			$this->db->insert('users',$new_member_insert_data );
			$this->db->insert('usersinroles',$new_member_insert_data1);
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

	function update($id,$id2,$person1, $person2){
	$this->db->where($this->primary_key,$id);
	$this->db->update($this->table_name,$person1);
	
	$this->db->where($this->primary_key2,$id);
	$this->db->update($this->table_name2,$person2);
	
	
	}


	

	function delete($id, $id2){
	$this->db->where($this->primary_key,$id);
	$this->db->delete($this->table_name);
	
	$this->db->where($this->primary_key2,$id2);
	$this->db->delete($this->table_name2);
	
	}

   
	function get_department() { 		
		$this->db->select('name');
		 $this->db->order_by('name', 'ASC');
		  $query=$this->db->get('department');
		  $result = $query->result();
		 $drop_menu_department_name = array();
			foreach($result as $item){
				$options[$item->name] = $item->name;
				  }
		  return $options;	
	}
	

	function get_tax_id(){
		$this->db->select('tax_id,tax_desc ');
		$this->db->order_by('tax_id', 'ASC');
		 $query=$this->db->get('tax-table');
		 $result = $query->result();
		$drop_menu_department_name = array();
		   foreach($result as $item){
			   $options[$item->tax_id] = $item->tax_id .' -> '.$item->tax_desc;
				 }
		 return $options;	
	}

	function get_sss_contri($sal){ 	
		
    		if ($sal >=1000 && $sal < 15750){
				$this->db->select('ss_ee');
				$this->db->from('sss-table');
				$this->db->where('min_range <=',$sal);
				$this->db->where('max_range >=',$sal);
				$sss_contri = $this->db->get()->row()->ss_ee;
			return $sss_contri;
	 		} 
	 
			elseif ($sal >= 15750) {
				$sss_contri = 581.3;
				return $sss_contri;
			} else {
			$sss_contri = 0;
			return $sss_contri;
			}
	
	}
	
	
    function get_daily_rate_div(){
			$this->db->select('rate');
			$this->db->from('pay_rates');
			$this->db->where('pay_rateId',1);
			$pay_rate = $this->db->get()->row()->rate;
		
			return $pay_rate;
	}  
	function get_hourly_rate_div(){
		$this->db->select('rate');
			$this->db->from('pay_rates');
			$this->db->where('pay_rateId',2);
			$pay_rate = $this->db->get()->row()->rate;
		
			return $pay_rate;
	} 
    function get_hdmf_rate(){
		$this->db->select('rate');
			$this->db->from('pay_rates');
			$this->db->where('pay_rateId',3);
			$pay_rate = $this->db->get()->row()->rate;
		
			return $pay_rate / 2;
	} 


	function compute_philhealth($sal){

		$mbs = $this->get_max_philhealth_rate();
	   
         $prate =  $this->get_philhealth_rate() / 100; 

			if ($sal <= $mbs){
				$philhealth_contri = ($sal * $prate) / 2;;
				return $philhealth_contri;
			}  else if ($sal > $mbs){
				$philhealth_contri = ($mbs * $prate) / 2;
				//$philhealth_contri = ($mbs * .0275) / 2;
				return $philhealth_contri;
			}
		}
	
	function get_philhealth_rate(){
			$this->db->select('rate');
				$this->db->from('pay_rates');
				$this->db->where('pay_rateId',4);
				$pay_rate = $this->db->get()->row()->rate;
			
				return $pay_rate;
		} 

	function get_max_philhealth_rate(){
			$this->db->select('max_covered');
				$this->db->from('pay_rates');
				$this->db->where('pay_rateId',4);
				$max_covered = $this->db->get()->row()->max_covered;
			
				return $max_covered;
		} 	
    

	function get_employee_status() { 		
		$this->db->select('status_name');
		 $this->db->order_by('status_name', 'DESC');
		  $query=$this->db->get('employee_status');
		  $result = $query->result();
		 $drop_menu_department_name = array();
			foreach($result as $item){
				$options[$item->status_name] = $item->status_name;
				  }
		  return $options;	
	}


	function get_bank_details() { 		
		$this->db->select('name');
		 $this->db->order_by('name', 'ASC');
		  $query=$this->db->get('banks');
		  $result = $query->result();
		 $drop_menu_department_name = array();
			foreach($result as $item){
				$options[$item->name] = $item->name;
				  }
		  return $options;	
	}
	
	function get_employee_type() { 		
		$this->db->select('type_name');
		 $this->db->order_by('code', 'DESC');
		  $query=$this->db->get('employee_type');
		  $result = $query->result();
		 $drop_menu_department_name = array();
			foreach($result as $item){
				$options[$item->type_name] = $item->type_name;
				  }
		  return $options;	
	}
	

	function encryptIt( $q ) {
		$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		$qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5(md5( $cryptKey ))));
		return( $qEncoded );
		}
	
	
		function decryptIt( $q ) {
		$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		$qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ),MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		return( $qDecoded );
		}


}

?>