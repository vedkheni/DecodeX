<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Reports_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	}

	public function log_in(){
        $query = $this->db->table('login_logs')
        		->select('*')
        		->get();
        $row = $query->getResult();
        return $row;
    }
	public function get_all_salary_pay($id,$year,$month=""){
		$query = $this->db->table('salary_pay')
				->select('*');
		if(!empty($month)){
			$query->where('month',$month);
		}
		$query = $query->where('year',$year)
				->where('employee_id',$id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function insert_salary_slip($data) {
     	if ($this->db->table("salary_slip")->insert( $data)) { 
			return true; 
		} 
	}
	public function update_salary_slip($data) {
		$this->db->table('salary_slip')->where('id', $data['id'])->update( $data);
		return true;
	}
	public function delete_salary_slip($id) {
		$this->db->table('salary_slip')->where('id', $id)->delete();
		return true;
	}
	public function get_salary_slip($id,$month,$year){
		$query = $this->db->table('salary_slip')
				->select('*')
				->where('MONTH(salary_slip_date)',$month)
				->where('YEAR(salary_slip_date)',$year)
				->where('salary_slip_id',$id)
		 		->get();
		$row = $query->getResult();
		return $row;
	}	
	public function get_all_salary_slip(){
		$query = $this->db->table('salary_slip')
				->select('*')
				->get();
		$row = $query->getResult();
		return $row;
	}	
	// public function get_employee(){
	// 	$this->db->select('*');
	// 	$this->db->table('employee');
	// 	$query = $this->db->get();
	// 	$row = $query->getResult();
	// 	return $row;
	// }
	
	/* start working houre report */
	function getAttendance_byCount($date){
		$query = $this->db->table('employee')
				->select('employee.fname,employee.lname,employee.id,GROUP_CONCAT(DISTINCT `employee_attendance`.`employee_in` ORDER BY `employee_attendance`.`employee_in` ASC SEPARATOR ",") AS employee_attendance_in,GROUP_CONCAT(DISTINCT `employee_attendance`.`employee_out` ORDER BY `employee_attendance`.`employee_out` ASC SEPARATOR ",") AS employee_attendance_out,GROUP_CONCAT(employee_attendance.attendance_type) AS employee_attendance_type')
				->join('employee_attendance', 'employee.id = employee_attendance.employee_id','left')
				->where('date(employee_attendance.employee_in)',$date)
		// 		->where('employee_attendance.employee_id',$id)
				->groupBy('employee.id')
				->get();
		return $query->getNumRows();
	}
	function getAttendance_byDate($date, $limit, $start, $order, $dir){
		// $search_option = "AND date(`employee_in`) = '".$date."'";
		$query = $this->db->table('employee')
				->select('employee.fname,employee.lname,employee.id,GROUP_CONCAT(DISTINCT `employee_attendance`.`employee_in` ORDER BY `employee_attendance`.`employee_in` ASC SEPARATOR ",") AS employee_attendance_in,GROUP_CONCAT(DISTINCT `employee_attendance`.`employee_out` ORDER BY `employee_attendance`.`employee_out` ASC SEPARATOR ",") AS employee_attendance_out,GROUP_CONCAT(employee_attendance.attendance_type) AS employee_attendance_type')
				->join('employee_attendance', 'employee.id = employee_attendance.employee_id','left')
				// ->where('employee_attendance.employee_id',$id);
				->where('date(employee_attendance.employee_in)',$date)
				->limit($limit,$start)
				->orderBy($order,$dir)
				->groupBy('employee.id')
		 		->get();
		// $query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option."  ORDER BY `employee_in` DESC");
		/* echo $this->db->last_query();
		echo '<pre>'; print_r( $query->getResult() ); echo '</pre>';exit; */
		return $query->getResult();
	}

	function getAttendance_bySearch($date, $limit, $start, $search, $order, $dir){
		// $search_option = "AND date(`employee_in`) = '".$date."'";
		$query = $this->db->table('employee')
				->select('employee.fname,employee.lname,employee.id,GROUP_CONCAT(DISTINCT `employee_attendance`.`employee_in` ORDER BY `employee_attendance`.`employee_in` ASC SEPARATOR ",") AS employee_attendance_in,GROUP_CONCAT(DISTINCT `employee_attendance`.`employee_out` ORDER BY `employee_attendance`.`employee_out` ASC SEPARATOR ",") AS employee_attendance_out,GROUP_CONCAT(employee_attendance.attendance_type) AS employee_attendance_type')
				// $search_option = "date(employee_attendance.employee_in) = '".$date."'";
				->join('employee_attendance', 'employee.id = employee_attendance.employee_id','left')
				// ->where('employee_attendance.employee_id',$id);
				->where('date(employee_attendance.employee_in)',$date)
				->like('employee.fname',$search)
				->orLike('employee.lname',$search)
				->orLike('employee_attendance.attendance_type',$search)
				->limit($limit,$start)
				->orderBy($order,$dir)
				->groupBy('employee.id')
				->get();
		// $query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option."  ORDER BY `employee_in` DESC");
		return $query->getResult();
	}
	
	function getAttendance_bySearchCount($date, $search){
		// $search_option = "AND date(`employee_in`) = '".$date."'";
		$query = $this->db->table('employee')
				->select('employee.fname,employee.lname,employee.id,GROUP_CONCAT(DISTINCT `employee_attendance`.`employee_in` ORDER BY `employee_attendance`.`employee_in` ASC SEPARATOR ",") AS employee_attendance_in,GROUP_CONCAT(DISTINCT `employee_attendance`.`employee_out` ORDER BY `employee_attendance`.`employee_out` ASC SEPARATOR ",") AS employee_attendance_out,GROUP_CONCAT(employee_attendance.attendance_type) AS employee_attendance_type')
		// $search_option = "date(employee_attendance.employee_in) = '".$date."'";
				->join('employee_attendance', 'employee.id = employee_attendance.employee_id','left')
		// 		->where('employee_attendance.employee_id',$id);
				->like('employee.fname',$search)
				->orLike('employee.lname',$search)
				->orLike('employee_attendance.attendance_type',$search)
				->where('date(employee_attendance.employee_in)',$date)
				->groupBy('employee.id')
		 		->get();
		// $query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option."  ORDER BY `employee_in` DESC");
		return $query->getNumRows();
	}
	/* end working houre report */

	function get_report_attendance($id, $search=null,$month=null,$year=null)
    {	
		$Today=date('Y-m-d');
		$search_form = date('Y-m-01',strtotime(date('Y-m-d')));
		$query = '';
		
   		//$search_option="AND date(`employee_in`) >= '2019-09-01' AND date(`employee_in`) <= '2019-09-30'";
   		$search_option="";
		   if(!empty($search)){
			   if(isset($search['search_dropdwon']) && !empty($search['search_dropdwon'])){
				   if($search['search_dropdwon'] == 1){
					   //Today
					   $Today=date('Y-m-d');
					   $search_option="AND date(`employee_in`) = '".$Today."'";
					}
					if($search['search_dropdwon'] == 2){
						//Yesterday
						$Yesterday=date('Y-m-d', strtotime('-1 days'));
						$search_option="AND date(`employee_in`) = '".$Yesterday."'";
					}
					if($search['search_dropdwon'] == 3){
						//Last Week
						$today=date('Y-m-d');
						$week=date('Y-m-d', strtotime('-1 week'));
						$search_option="AND (date(`employee_in`) <= '".$today."' AND date(`employee_in`) >= '".$week."')";
					}
					if($search['search_dropdwon'] == 4){
						//Last Month
						$start_date=date("Y-m-d", strtotime("first day of previous month"));
						$end_date=date("Y-m-d", strtotime("last day of previous month"));
						$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
					}
					if($search['search_dropdwon'] == 5){
						//6 Month
						$start_date=date("Y-m-d", strtotime(" -6 months"));
						$end_date=date('Y-m-d');
						// $end_date=date("Y-m-d", strtotime("last day of -6 month"));
						$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
					}
					if($search['search_dropdwon'] == 6){
						//This Month
						$start_date=date("Y-m-01");
						$end_date=date("Y-m-t");
						$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
					}
					if($search['search_dropdwon'] == 7){
						//This Month
						$start_date=date($year."-".$month."-01");
						$end_date=date($year."-".$month."-t");
						$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
					}
					if(isset($search['employees']) && !empty($search['employees'])){
					$id=$search['employees'];
				}
    			$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option."  ORDER BY `employee_in` DESC");
    		}
			else{
				//$search_option="AND date(`employee_in`) = '".$Today."'";
    			if(isset($search['from_date']) && isset($search['employees'])){
					// if(isset($search['from_date']) && isset($search['to_date']) && isset($search['employees'])){
						
						// from and to date
    					$start_date=date("Y-m-d", strtotime($search['from_date']."-"."01"));
						$end_date=date("Y-m-t", strtotime($start_date));
	    				$search_option=" AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
						$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS `employee_attendance_out`,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option."  ORDER BY `employee_in` DESC");
					}	 
			}	
    	}else{
    		$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option." ORDER BY `employee_in` DESC");
		}
		return $query->getResult();

	}
	function get_all_report_attendance($id, $search="", $limit, $start, $order, $dir, $month="", $year="")
    {	
		$Today=date('Y-m-d');
		$search_form = date('Y-m-01',strtotime(date('Y-m-d')));
		
   		$search_option="";
    	if(!empty($search)){
    		if(isset($search['search_dropdwon']) && !empty($search['search_dropdwon'])){
				if($search['search_dropdwon'] == 1){
    				//Today
    				$Today=date('Y-m-d');
    				$search_option="AND date(`employee_in`) = '".$Today."'";
    			}
    			if($search['search_dropdwon'] == 2){
    				//Yesterday
    				$Yesterday=date('Y-m-d', strtotime('-1 days'));
    				$search_option="AND date(`employee_in`) = '".$Yesterday."'";
    			}
    			if($search['search_dropdwon'] == 3){
    				//Last Week
    				$today=date('Y-m-d');
    				$week=date('Y-m-d', strtotime('-1 week'));
    				$search_option="AND (date(`employee_in`) <= '".$today."' AND date(`employee_in`) >= '".$week."')";
    			}
    			if($search['search_dropdwon'] == 4){
    				//Last Month
    				$start_date=date("Y-m-d", strtotime("first day of previous month"));
    				$end_date=date("Y-m-d", strtotime("last day of previous month"));
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    			}
    			if($search['search_dropdwon'] == 5){
					//6 Month
    				$start_date=date("Y-m-d", strtotime("first day of -6 month"));
    				$end_date=date("Y-m-d", strtotime("last day of -6 month"));
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    				
    			}
				if($search['search_dropdwon'] == 6){
					//This Month
    				$start_date=date("Y-m-01");
    				$end_date=date("Y-m-t");
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    			}
				if($search['search_dropdwon'] == 7){
					//This Month
    				$start_date=date($year."-".$month."-01");
    				$end_date=date($year."-".$month."-t");
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    			}
				if(isset($search['employees']) && !empty($search['employees'])){
					$id=$search['employees'];
				}
		
				
				$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = ".$id." ".$search_option." ORDER BY '".$order."' '".$dir."' LIMIT ".$start.",".$limit);
				/* LIMIT '".$start."' '".$limit."' */
    		}
			else{
    			//$search_option="AND date(`employee_in`) = '".$Today."'";
    			if(isset($search['from_date']) && isset($search['to_date']) && isset($search['employees'])){
    				
    					// from and to date
    					$start_date=$search['from_date'];
	    				$end_date=$search['to_date'];
	    				$search_option=" AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
						$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS `employee_attendance_out`,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = ".$id." ".$search_option." ORDER BY '".$order."' '".$dir."' LIMIT ".$start.",".$limit);
						/* LIMIT '".$start."' '".$limit."' */
    			}
			}
    	}
		else{
			$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = ".$id." ".$search_option." ORDER BY '".$order."' '".$dir."' LIMIT ".$start.",".$limit);
			/* LIMIT '".$start."' '".$limit."' */
    	}
		return $query->getResult();
    }
	function all_report_attendance_search($id, $search="", $limit, $start, $search1, $order, $dir, $month="", $year="")
    {	
		$Today=date('Y-m-d');
		$search_form = date('Y-m-01',strtotime(date('Y-m-d')));
		
   		$search_option="";
    	if(!empty($search)){
    		if(isset($search['search_dropdwon']) && !empty($search['search_dropdwon'])){
				if($search['search_dropdwon'] == 1){
    				//Today
    				$Today=date('Y-m-d');
    				$search_option="AND date(`employee_in`) = '".$Today."'";
    			}
    			if($search['search_dropdwon'] == 2){
    				//Yesterday
    				$Yesterday=date('Y-m-d', strtotime('-1 days'));
    				$search_option="AND date(`employee_in`) = '".$Yesterday."'";
    			}
    			if($search['search_dropdwon'] == 3){
    				//Last Week
    				$today=date('Y-m-d');
    				$week=date('Y-m-d', strtotime('-1 week'));
    				$search_option="AND (date(`employee_in`) <= '".$today."' AND date(`employee_in`) >= '".$week."')";
    			}
    			if($search['search_dropdwon'] == 4){
    				//Last Month
    				$start_date=date("Y-m-d", strtotime("first day of previous month"));
    				$end_date=date("Y-m-d", strtotime("last day of previous month"));
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    			}
    			if($search['search_dropdwon'] == 5){
					//6 Month
    				$start_date=date("Y-m-d", strtotime("first day of -6 month"));
    				$end_date=date("Y-m-d", strtotime("last day of -6 month"));
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    				
    			}
				if($search['search_dropdwon'] == 6){
					//This Month
    				$start_date=date("Y-m-01");
    				$end_date=date("Y-m-t");
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    			}
				if($search['search_dropdwon'] == 7){
					//This Month
    				$start_date=date($year."-".$month."-01");
    				$end_date=date($year."-".$month."-t");
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    			}
				if(isset($search['employees']) && !empty($search['employees'])){
					$id=$search['employees'];
				}
				$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = ".$id." AND `attendance_type` LIKE '%".$search1."%' AND `employee_in` LIKE '%".$search1."%' ".$search_option." ORDER BY '".$order."' '".$dir."' LIMIT ".$start.",".$limit);
				/* LIMIT '".$start."' '".$limit."' */
    		}
			else{
    			//$search_option="AND date(`employee_in`) = '".$Today."'";
    			if(isset($search['from_date']) && isset($search['to_date']) && isset($search['employees'])){
    				
    					// from and to date
    					$start_date=$search['from_date'];
	    				$end_date=$search['to_date'];
	    				$search_option=" AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
						$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS `employee_attendance_out`,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = ".$id." AND `attendance_type` LIKE '%".$search1."%' AND `employee_in` LIKE '%".$search1."%' ".$search_option." ORDER BY '".$order."' '".$dir."' LIMIT ".$start.",".$limit);
						/* LIMIT '".$start."' '".$limit."' */
    			}
			}
    	}
		else{
			$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = ".$id." AND `attendance_type` LIKE '%".$search1."%' AND `employee_in` LIKE '%".$search1."%' ".$search_option." ORDER BY '".$order."' '".$dir."' LIMIT ".$start.",".$limit);
			/* LIMIT '".$start."' '".$limit."' */
    	}
		return $query->getResult();
    }
	function report_attendance_search_count($id, $search="", $search1, $month="", $year="")
    {	
		$Today=date('Y-m-d');
		$search_form = date('Y-m-01',strtotime(date('Y-m-d')));
		
   		$search_option="";
    	if(!empty($search)){
    		if(isset($search['search_dropdwon']) && !empty($search['search_dropdwon'])){
				if($search['search_dropdwon'] == 1){
    				$Today=date('Y-m-d');
    				$search_option="AND date(`employee_in`) = '".$Today."'";
    			}
    			if($search['search_dropdwon'] == 2){
    				$Yesterday=date('Y-m-d', strtotime('-1 days'));
    				$search_option="AND date(`employee_in`) = '".$Yesterday."'";
    			}
    			if($search['search_dropdwon'] == 3){
    				$today=date('Y-m-d');
    				$week=date('Y-m-d', strtotime('-1 week'));
    				$search_option="AND (date(`employee_in`) <= '".$today."' AND date(`employee_in`) >= '".$week."')";
    			}
    			if($search['search_dropdwon'] == 4){
    				$start_date=date("Y-m-d", strtotime("first day of previous month"));
    				$end_date=date("Y-m-d", strtotime("last day of previous month"));
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    			}
    			if($search['search_dropdwon'] == 5){
					$start_date=date("Y-m-d", strtotime("first day of -6 month"));
    				$end_date=date("Y-m-d", strtotime("last day of -6 month"));
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    				
    			}
				if($search['search_dropdwon'] == 6){
					$start_date=date("Y-m-01");
    				$end_date=date("Y-m-t");
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    			}
				if($search['search_dropdwon'] == 7){
					$start_date=date($year."-".$month."-01");
    				$end_date=date($year."-".$month."-t");
    				$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
    			}
				if(isset($search['employees']) && !empty($search['employees'])){
					$id=$search['employees'];
				}
				$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = ".$id." AND `attendance_type` LIKE '%".$search1."%' AND `employee_in` LIKE '%".$search1."%' ".$search_option." ORDER BY '".$order."' '".$dir."'");
			}
			else{
    			if(isset($search['from_date']) && isset($search['to_date']) && isset($search['employees'])){
    				
    					$start_date=$search['from_date'];
	    				$end_date=$search['to_date'];
	    				$search_option=" AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
						$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS `employee_attendance_out`,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = ".$id." AND `attendance_type` LIKE '%".$search1."%' AND `employee_in` LIKE '%".$search1."%' ".$search_option." ORDER BY '".$order."' '".$dir."'");
    			}
			}
    	}
		else{
			$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = ".$id." AND `attendance_type` LIKE '%".$search1."%' AND `employee_in` LIKE '%".$search1."%' ".$search_option." ORDER BY '".$order."' '".$dir."'");

    	}
		return $query->getNumRows();
    }
	function employee_prof_tax($data=array()){
		$query = $this->db->table('salary_pay')->select('*');
		if(!empty($data)){
			if(!empty($data['month']) && !empty($data['year']) && !empty($data['employee_id'])){
				$query->where('month',$data['month']);
				$query->where('year',$data['year']);
				$query->where('employee_id',$data['employee_id']);
			}
		}
		$row = $query->get()->getResult();
		return $row;
	}
    function get_report_logs($id,$search=""){
    	$Today=date('Y-m-d');
		$search_form = date('Y-m-01',strtotime(date('Y-m-d')));

		$search_option="";
    	if(!empty($search)){
    		if(isset($search['search_dropdwon']) && !empty($search['search_dropdwon'])){
				if($search['search_dropdwon'] == 1){
    				//Today
    				$Today=date('Y-m-d');
    				$search_option="AND date(`datetime`) = '".$Today."'";
    			}
    			if($search['search_dropdwon'] == 2){
    				//Yesterday
    				$Yesterday=date('Y-m-d', strtotime('-1 days'));
    				$search_option="AND date(`datetime`) = '".$Yesterday."'";
    			}
    			if($search['search_dropdwon'] == 3){
    				//Last Week
    				$today=date('Y-m-d');
    				$week=date('Y-m-d', strtotime('-1 week'));
    				$search_option="AND (date(`datetime`) <= '".$today."' AND date(`datetime`) >= '".$week."')";
    			}
    			if($search['search_dropdwon'] == 4){
    				//Last Month
    				$start_date=date("Y-m-d", strtotime("first day of previous month"));
    				$end_date=date("Y-m-d", strtotime("last day of previous month"));
    				$search_option="AND date(`datetime`) >= '".$start_date."' AND date(`datetime`) <= '".$end_date."'";
    			}
    			if($search['search_dropdwon'] == 5){
					//6 Month
    				$start_date=date("Y-m-d", strtotime("first day of -6 month"));
    				$end_date=date("Y-m-d", strtotime("last day of -6 month"));
    				$search_option="AND date(`datetime`) >= '".$start_date."' AND date(`datetime`) <= '".$end_date."'";
    			}
				if($search['search_dropdwon'] == 6){
					//This Month
    				$start_date=date("Y-m-01");
    				$end_date=date("Y-m-t");
    				$search_option="AND date(`datetime`) >= '".$start_date."' AND date(`datetime`) <= '".$end_date."'";
    			}
				if(isset($search['employees']) && !empty($search['employees'])){
					$id=$search['employees'];
				}

				$query=$this->db->query("SELECT * FROM login_logs INNER JOIN employee ON `login_logs`.`employee_id` = `employee`.`fname` where `employee_id` = $id ".$search_option." ORDER BY `datetime` DESC");
			}else {
				if(isset($search['from_date']) && isset($search['to_date']) && isset($search['employees'])){
    					// from and to date
    					$start_date=$search['from_date'];
	    				$end_date=$search['to_date'];
	    				$search_option=" AND date(`datetime`) >= '".$start_date."' AND date(`datetime`) <= '".$end_date."'";
						$query=$this->db->query("SELECT * FROM login_logs INNER JOIN employee ON `login_logs`.`employee_id` = `employee`.`fname` where `employee_id` = $id ".$search_option." ORDER BY `datetime` DESC");
    			}
			}
        }
    }
}
?>