<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Dashboard_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	 $this->session = \Config\Services::session();
        $this->session->start();
	}

	public function get_log_time(){
		$query = $this->db->table('login_logs')
				->select('*')
				->get();
		$row = $query->getResult();
		return $row;
	}

	/* public function get_employee(){
		$this->db->select('*');
		$this->db->table('employee');
		$this->db->where('status','1');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	/* public function get_employee_details($id){
		$this->db->select('*');
		$this->db->table('employee');
		$this->db->where('id',$id);
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	} */
	public function get_employee_joining_date(){
		$query = $this->db->table('employee')
				->select('*')
				->where('status','1')
				->orderBy('employed_date', 'asc')
				->get();
		$row = $query->getResult();
		return $row;
	}
	
	
	public function get_employee_attedance(){
		$date=date('Y-m-d');
		$time=date('h:i:s',strtotime("10:00 AM"));
		$query = $this->db->table('employee_attendance')
				->select('employee_attendance.*,employee.fname,employee.gender,employee.lname,employee.profile_image')
				->where('DATE(employee_attendance.`employee_in`)',$date)
				->join('employee', 'employee.id = employee_attendance.employee_id')
				->groupBy("employee_attendance.employee_id")
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_current_date_attedance_status(){
		
		//SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM `employee_attendance` where `employee_id` = 9 and date(`employee_in`) = "2019-09-23" ORDER BY `employee_in` DESC

		$date=date('Y-m-d');
		$query = $this->db->table('employee_attendance')
				->select('employee_attendance.*,employee.fname,employee.lname,employee.profile_image')
				->where('DATE(employee_attendance.`employee_in`)',$date)
				->join('employee', 'employee.id = employee_attendance.employee_id')
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function this_month_leave(){
		$start_date=date("Y-m-01");
    	$end_date=date("Y-m-t");
    	//$search_option="AND date(`employee_in`) >= '".$start_date."' AND date(`employee_in`) <= '".$end_date."'";
		$query = $this->db->table('employee_leave_request')
				->select('employee_leave_request.*,employee.fname,employee.lname,employee.profile_image,employee.gender')
				->join('employee', 'employee.id = employee_leave_request.employee_id')
				->where('employee_leave_request.status =',"pending")
		//$this->db->where('employee_leave_request.leave_date >=', $start_date);
		//$this->db->where('employee_leave_request.leave_date <=', $end_date);
				->get();
		$row = $query->getResult();
		return $row;
	}
/* 	public function get_interview_schedule(){
		$start_date=date("Y-m-d");
    	$end_date=date("Y-m-d",strtotime('+7 day'));
		$this->db->select('*');
		$this->db->table('candidates');
		$this->db->join('interview_schedule', 'candidates.id = interview_schedule.candidate_id','right');
		$this->db->where('interview_schedule.interview_date >=', $start_date);
		$this->db->where('interview_schedule.interview_date <=', $end_date);
		$query = $this->db->get();
		$row = $query->getResult();
		
		return $row;
	} */
	public function this_month_leave_not_approv(){
		$start_date=date("Y-m-01");
    	$end_date=date("Y-m-d");
		$query = $this->db->table('employee_attendance')
				->select('employee_attendance.employee_in,employee.fname,employee.lname,employee.profile_image')
				->join('employee', 'employee.id = employee_attendance.employee_id')
				->where('employee_attendance.employee_in >=', $start_date)
				->where('employee_attendance.employee_in <=', $end_date)
		 		->get();
		$row = $query->getResult();
		
		return $this->db->getLastQuery();
	}
	public function get_employee_total_bonus($id='',$year=''){
		
		
		$query = $this->db->table('salary_pay');
		if($year != 'all' && $year != ''){
			$query->where('year',$year);
		}
		$user_session = ($id != '') ? $id : $this->session->get('id');

		$query->select('sum(bonus) as total_bonus');
		$query->where('employee_id',$user_session);
		$query = $query->get();
		$row = $query->getResult();
		return $row;
	}
	/* public function employee_total_bonus($id,$year){
		if($year != 'all'){
			$this->db->where('year',$year);
		}
		$this->db->select('sum(bonus) as total_bonus');
		$this->db->table('salary_pay');
		$this->db->where('employee_id',$id);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
}
?>