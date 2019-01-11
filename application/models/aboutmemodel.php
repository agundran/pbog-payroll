<?php

class Aboutmemodel extends CI_Model{
	
	
	function __construct(){
	parent::__construct();
	}


function get_paged_list($limit, $offset=0, $order_column='SiteName', $order_type='asc', $filter, $StartDate, $EndDate){
		
		//$aStartDate = date('Y-m-d',strtotime('2015-01-01'));
		
		
	
	if(empty($order_column)||empty($order_type)){		
		$this->db->order_by('SiteName','asc');
		}
	else{
		
					 
				$query = $this->db->select('distinct(t2.SiteName),  t2.SysCode')  
						
                        ->join('site_operators as t2', 't2.SiteName = t1.SiteName')
						->join ('registration as t3','t1.SiteName= t3.SiteName' )
						//->join('contract_header as t4', 't2.SiteName = t4.SiteName')
						//->join('contract_detail as t5', 't4.Seq = t5.Contract')
						
						
						->where ('t3.Active',1)
					//	->where('t4.StartDate >=',$astartdate)
						//->where('t4.EndDate <=',$EndDate)'
						//->group_by('t1.ContractName')
					//	->group_by('t4.SiteName')
						->like('t1.SiteName', $filter, 'after')
						
						//->group_by('SiteName')
                        ->get('contract_header as t1', $limit, $offset); 	 
					   
					   
					   
					   
				
		return $query;

		
	
	}

}

function count_all(){
	
	
			$this->db->select('t1.SiteName, t1.SysCode, ')
					->from('site_operators as t1')
					->join ('registration as t3','t1.SiteName= t3.SiteName' )
					->join('clients as t2','t1.SiteName = t2.ShortName')
					
					->where ('t3.Active',1)
				
	                    ;
						 
	return $this->db->count_all_results();
	
	}
	

   

}

?>