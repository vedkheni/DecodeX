<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Employee_Attendance_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
		$this->session = \Config\Services::session();
        $this->session->start();
	} 
	/* public function get_employee_date(){
		$user_session=$this->session->userdata('id');
		$this->db->select('*');
		$this->db->table('employee_attendance');
		$this->db->where("date(`employee_in`)",date('Y-m-d'));
		$this->db->where('employee_id',$user_session);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	
	public function get_employee_attendance_details($id,$date=""){
		if(!empty($date)){
			$where_date=$date;
		}else{
			$where_date=date('Y-m-d');
		}
		$query = $this->db->table('employee_attendance')
				->select('*')
				->where("date(`employee_in`)",$where_date)
				->where('employee_id',$id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_employee_attendance_date($id="",$attendance_date=""){
		if(!empty($attendance_date)){$where_date=$attendance_date;}else{$where_date=date('Y-m-d');}
		if(!empty($id)){$employee_id=$id;}else{$employee_id=$this->session->get('id');}
		$query = $this->db->table('employee_attendance')
				->select('*')
				->where("date(`employee_in`)",$where_date)
				->where('employee_id',$employee_id)
				->get();
		$row = $query->getResult();
		return $row;
	}

	public function getAttendance_betweenDate($data=array()){
		$id = $data['id'];
		$first_date = $data['first_date'];
		$second_date = $data['second_date'];
		$query = $this->db->table('daily_work')->select('*');
		if(isset($second_date) && !empty($second_date) && isset($first_date) && !empty($first_date)){
			$query->where('attendance_date >=', $first_date)->where('attendance_date <=', $second_date);
		}else{
			if(isset($first_date) && !empty($first_date)){
				$query->where('attendance_date', $first_date);
			}
			if(isset($second_date) && !empty($second_date)){
				$query->where('attendance_date', $second_date);
			}
		}
		$query = $query->where('employee_id',$id)->orderBy('attendance_date', 'DESC')->get();
		$row = $query->getResult();
		return $row;
	}

	public function getUpdates_byDate($data=array()){
		$date = $data['date'];
		$query = $this->db->table('daily_work')->select('daily_work.*,employee.fname,employee.lname')->join('employee', 'employee.id = daily_work.employee_id');;
		if(isset($date) && !empty($date)){
			$query->where('daily_work.attendance_date', $date);
		}
		$query = $query->orderBy('employee.fname', 'DESC')->get();
		$row = $query->getResult();
		return $row;
	}

	/* public function get_employee_attendance_date1($id,$attendance_date){
		$this->db->select('*');
		$this->db->table('employee_attendance');
		$this->db->where("date(`employee_in`)",$attendance_date);
		$this->db->where('employee_id',$id);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	public function insert_daily_work($data) {
		if($this->db->table("daily_work")->insert($data)) { 
		   return true; 
	   } 
   }
	public function get_work_by_date($attendance_date,$id) {
		$query = $this->db->table('daily_work')
				->select('*')
				->where("attendance_date",$attendance_date)
				->where('employee_id',$id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function update_daily_work($data) {
		$this->db->table('daily_work')->where('id', $data['id'])->update($data);
		return true;
	}
	public function get_employee_attendance_data($id){
		$query = $this->db->table('employee_attendance')
				->select('*')
				->where('employee_id',$id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function insert_employee($data) {
     	if ($this->db->table("employee_attendance")->insert($data)) { 
			return true; 
		} 
	}
	public function update_employee($data) {
		$this->db->table('employee_attendance')->where('id', $data['id'])->update($data);
		return true;
	}
	public function update_attendance_time($data){
		$this->db->table('employee_attendance')->where('id', $data['id'])->where('employee_id', $data['employee_id'])->update($data);
		//$this->db->where('date(`employee_in`)', date($data['date']));
		return true;
	}
	public function delete_employee($id) {
		$this->db->table('employee_attendance')->where('id', $id)->delete();
		return true;
	}
	public function delete_daily_work($id) {
		$this->db->table('daily_work')->where('id', $id)->delete();
		return true;
	}
	// public function get_designation(){
	// 	$this->db->select('*');
	// 	$this->db->table('designation');
	// 	$query = $this->db->get();
	// 	$row = $query->getResult();
	// 	return $row;
	// }
	/* public function get_employee($id){
		$this->db->select('employee.*,designation.name');
		$this->db->table('employee');
		$this->db->join('designation', 'employee.designation = designation.id');
		$this->db->where('employee.id', $id);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	/* public function get_admin($id){
		$this->db->select('*');
		$this->db->table('user');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	function allposts_count()
    {  
		$query = $this->db->table('employee_attendance')->get();
		return $query->getNumRows();  
    }
    
    function allposts($limit,$start,$col,$dir)
    {   
     	$query = $this
				->db
				->table('employee_attendance')
				->limit($limit,$start)
				->orderBy($col,$dir)
				->get();
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search($limit,$start,$search,$col,$dir)
    {
       	//$query=$this->db->query("SELECT * FROM employee_attendance");
		$query = $this->db->table('employee_attendance')->select('*')->get();
        if($query->getNumRows()>0)
        {
            return $query->getResult();  
        }
        else
        {
            return null;
        }
    }
    function posts_search_count($search)
    {
  		// $query=$this->db->query("SELECT * FROM employee_attendance");
		$query = $this->db->table('employee_attendance')->select('*')->get();
		return $query->getNumRows();
    }
     function employee_attendance_list($id,$search="")
    {	$Today=date('Y-m-d');
		$search_form = date('Y-m-01',strtotime(date('Y-m-d')));
		//$search_option="";
   		$search_option="AND date(`employee_in`) >= '".$search_form."' AND date(`employee_in`) <= '".$Today."'";
    	if(!empty($search)){
    		if(isset($search['search_dropdwon']) && !empty($search['search_dropdwon']) && empty($search['month']) && empty($search['year'])){
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
				
    			$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option."  ORDER BY `employee_in` DESC");

    		}else{
    			//$search_option="AND date(`employee_in`) = '".$Today."'";
    			if(isset($search['month']) && isset($search['year'])){
    				
    					// from and to date
    					$m=$search['month'];
	    				$y=$search['year'];
						$start_date=date($y."-".$m."-01");
						$end_date=date($y."-".$m."-t");
	    				$search_option=" AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
						$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS `employee_attendance_out`,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option."  ORDER BY `employee_in` DESC");
    			}
    			 
			}

    		
    	}else{
    		$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option." ORDER BY `employee_in` DESC");
    	}

		return $query->getResult();

    }
	function employee_attendance_list_month_year($id,$search=""){
				if(isset($search['month']) && isset($search['year'])){
					// from and to date
					$m=$search['month'];
					$y=$search['year'];
					//$start_date=date($y."-".$m."-01");
					$start_date=date($y.'-m-01',strtotime($y."-".$m."-1"));
					$end_date=date($y.'-m-t',strtotime($y."-".$m));
	    		}else{
					$m=date('m');
					$y=date('Y');
					$start_date=date('Y-m-01',strtotime($y."-".$m."-01"));
					//$start_date=date($y."-".$m."-01");
					//$end_date=date($y."-".$m."-t");
					$end_date=date($y.'-m-t',strtotime($y."-".$m));
				}
				$search_option=" AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
				$query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS `employee_attendance_out`,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option."  ORDER BY `employee_in` DESC");
			//return $this->db->last_query();
		    return  $query->getResult();
	}
	
    function employee_attendance_date($date,$id)
    {
  		//$query=$this->db->query("SELECT id FROM employee_attendance where date(`employee_in`) = '".$date."' and employee_id = $id");
		  $query = $this->db->table('employee_attendance')
				->select('id')
				->where('date(`employee_in`)',$date)
				->where('employee_id',$id)
				->get();
		return $query->getResult();
    }
    function salary_count_day($month,$year,$id)
    {
    	$str = $year.'-'.$month;
        $timestamp = strtotime($str);
        $first_second = date('Y-m-d', $timestamp);
        $last_second  = date('Y-m-t', $timestamp);
       // $query=$this->db->query("SELECT * FROM employee_attendance where `employee_id` = $id  AND date(`employee_in`) >= '".$first_second."' AND date(`employee_in`) <= '".$last_second."' GROUP BY date(`employee_in`) ORDER BY `employee_attendance`.`employee_in` ASC");
	   $query = $this->db->table('employee_attendance')
	   			->select('*')
				->where('date(`employee_in`) >=',$first_second)
				->where('date(`employee_in`) <= ',$last_second)
				->where('employee_id',$id)
				->groupBy('date(`employee_in`)')
				->orderBy('employee_in','ASC')
				->get();
        return $query->getResult();
    }
}
// 4 11 18 25 24 15
?>