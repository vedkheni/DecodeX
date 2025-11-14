<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Leave_Request_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	public function insert_employee($data) {
     	if ($this->db->table("employee_leave_request")->insert( $data)) { 
			return true; 
		} 
	}
	public function update_employee_paid_leave($employee_id,$paid_leave_remaing) {
		$leave_update=array(
			'monthly_paid_leave' => $paid_leave_remaing
		);
		$this->db->table('employee')->where('id',$employee_id)->update($leave_update);
		return true;
	}
	public function update_employee($data) {
		if($this->db->table('employee_leave_request')->where('id', $data['id'])->update( $data)){
			return true;
		}else {
			return false;
		}
	}
	public function delete_employee($id) {
		$this->db->table('employee_leave_request')->where('id', $id)->delete();
		return true;
	}
	public function delete_employee_leave($id,$leave_date){
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where('employee_id', $id)
				->where("date(`leave_date`)",$leave_date)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_salary_pay_details($month,$year){
		$where="employee.account_number != '' and employee.ifsc_number != '' and salary_pay.net_salary != '0' and salary_pay.payment_status = 'paid'";
		$query = $this->db->table('salary_pay')
				->select('*')
				->join('employee', 'employee.id = salary_pay.employee_id')
				->where($where)
				->where('salary_pay.year', $year)
				->where('salary_pay.month', $month)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_salary_pay_txtfile_details($month,$year){
		$where="employee.account_number != '' and employee.ifsc_number != '' and salary_pay.net_salary != '0' and salary_pay.payment_status = 'paid'";
		$query =$this->db->table('salary_pay')
				->select('*')
				->join('employee', 'employee.id = salary_pay.employee_id')
				->where($where)
				->where('salary_pay.bankstatus !=', '1')
				->where('salary_pay.year', $year)
				->where('salary_pay.month', $month)
		 		->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_salary_pay($id,$month,$year){
		$query =$this->db->table('salary_pay')
				->select('*')
				->where('year', $year)
				->where('month', $month)
				->where('employee_id', $id)
		 		->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_salary_pay_paid_leave_count($id){
		$query =$this->db->table('salary_pay')
				->select('*')
				->where('employee_id', $id)
		 		->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_deposit_payment($id){
		$query = $this->db->table('deposit_payment')
				->select('*')
				->where('employee_id', $id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_leave_request($id){
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where('id', $id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_leave_employee($id){
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where('employee_id', $id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	/* public function get_employees(){
		$this->db->select('*');
		$this->db->table('employee');
		$this->db->where('status','1');
		$this->db->orderBy('fname','asc');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	public function get_employee_leave_count($id,$status){
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where("status",$status)
				->where("leave_status","approved")
				->where('employee_id',$id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_employee_leave_total($id,$start_date,$end_date){
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where("date(`leave_date`) >=",$start_date)
				->where("date(`leave_date`) <=",$end_date)
				->where('employee_id',$id)
		 		->get();
		$row = $query->getResult();
		return $row;
		
	}
	public function get_employee_attendance_date($id,$attendance_date){
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where("date(`leave_date`)",Format_date($attendance_date))
				->where('employee_id',$id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_employee_attendance_date_multiple($id,$attendance_date){
		// $explode=explode(' , ',$attendance_date);
		// $getResult = (implode ( "', '", $explode ));
		$getResult=explode(' , ',$attendance_date);
		$query = $this->db->table('employee_leave_request')
				->select('*')
				//->where("date(`leave_date`)",$attendance_date)
				->where('employee_id',$id)
				->whereIn("date(`leave_date`)",$getResult)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_total_month_leave_list($user_session,$month,$year){
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where('employee_id',$user_session)
				->where('MONTH(leave_date)',$month)
				->where('YEAR(leave_date)',$year)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_total_month_leave_list1($user_session){
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where('employee_id',$user_session)
				->get();
		$row = $query->getResult();
		return $row;
	}
	/* public function get_employees_bonus_list($user_session,$month_number,$year){
				->table('bonus')
				->select('*')
				->where('emp_id',$user_session)
				->where('month',$month_number)
				->where('year',$year)
		 		->get()
		$row = $query->getResult();
		return $row;
	} */
	public function get_employees_leave_request_list($user_session,$month,$year){
		$where="status='approved' and leave_status='paid'";
		//$where="status='approved' and (leave_status='paid' or leave_status='sick')";
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where('employee_id',$user_session)
				->where('MONTH(leave_date)',$month)
				->where('YEAR(leave_date)',$year)
				->where($where)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_leave_not_approved_list($user_session,$month,$year){
		$where="status!='approved'";
		$query = $this->db->table('employee_leave_request')
				->select('*')
				->where('employee_id',$user_session)
				->where('MONTH(leave_date)',$month)
				->where('YEAR(leave_date)',$year)
				->where($where)
		 		->get();
		$row = $query->getResult();
		return $row;
	}
	
	function allposts_count($status,$employee_id,$select_year,$select_month,$select_leave)
    {  
		
		
		$query = $this->db->table('employee_leave_request');
		if(!empty($status) && !empty($employee_id) && empty($select_month) && empty($select_year)){
			$where="employee_leave_request.status='".$status."' and employee_leave_request.employee_id=".$employee_id;
			$query->where($where);
			/* $query->select('employee_leave_request.*,employee.fname,employee.lname');
			$query->table('employee_leave_request');
			$query->join('employee', 'employee.id = employee_leave_request.employee_id');
			$query = $query->get(); */
		}else{
			if(!empty($select_year)){
				$query->where('YEAR(employee_leave_request.leave_date)',$select_year);
			}
			if(!empty($employee_id)){
				$query->where('employee_leave_request.employee_id',$employee_id);
			}
			if(!empty($select_month)){
				$query->where('MONTH(employee_leave_request.leave_date)',$select_month);
			}
			if(!empty($status)){
				$query->where('employee_leave_request.status',$status);
			}
		}
		$date = date('Y-m-d');
		if($select_leave == 'upcoming'){
			$query->where('employee_leave_request.leave_date >= ',$date);
		}elseif($select_leave == 'recent'){
			$query->where('employee_leave_request.leave_date < ',$date);
		}
		$query->select('employee_leave_request.*,employee.fname,employee.lname');
		$query->join('employee', 'employee.id = employee_leave_request.employee_id');
		$query = $query->get();
		
		return $query->getNumRows();  
    }
    
    function allposts($status,$employee_id,$select_year,$select_month,$select_leave,$limit,$start,$col,$dir)
    {   
		$query = $this->db->table('employee_leave_request');
		if(!empty($status) && !empty($employee_id) && empty($select_month) && empty($select_year)){
			$where="employee_leave_request.status='".$status."' and employee_leave_request.employee_id=".$employee_id;
			$query->where($where);
		/* 	$query->select('employee_leave_request.*,employee.fname,employee.lname');
			$query->table('employee_leave_request');
			$query->join('employee', 'employee.id = employee_leave_request.employee_id');
			$query->limit($limit,$start);
			$query->orderBy($col,$dir);
			$query = $query->get(); */
		}else{
			if(!empty($select_year)){
				$query->where('YEAR(employee_leave_request.leave_date)',$select_year);
			}
			if(!empty($employee_id)){
				$query->where('employee_leave_request.employee_id',$employee_id);
			}
			if(!empty($select_month)){
				$query->where('MONTH(employee_leave_request.leave_date)',$select_month);
			}
			if(!empty($status)){
				$query->where('employee_leave_request.status',$status);
			}
		}
		$date = date('Y-m-d');
		if($select_leave == 'upcoming'){
			$query->where('employee_leave_request.leave_date >= ',$date);
		}elseif($select_leave == 'recent'){
			$query->where('employee_leave_request.leave_date < ',$date);
		}

		$query->select('employee_leave_request.*,employee.fname,employee.lname');
		$query->join('employee', 'employee.id = employee_leave_request.employee_id');
		$query->limit($limit,$start);
		$query->orderBy($col,$dir);
		$query = $query->get();
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search($status,$employee_id,$select_year,$select_month,$select_leave,$limit,$start,$search,$col,$dir)
    {
		$query = $this->db->table('employee_leave_request');
		if(!empty($status) && !empty($employee_id)){
			$where="(employee.fname LIKE '%".$search."%' or employee.lname LIKE '%".$search."%' or employee_leave_request.leave_date LIKE '%".$search."%' or employee_leave_request.comment LIKE '%".$search."%' or employee_leave_request.status LIKE '%".$search."%' or employee_leave_request.leave_status LIKE '%".$search."%') and employee_leave_request.status='".$status."' and employee_leave_request.employee_id=".$employee_id;
			/* $query->select('employee_leave_request.*,employee.fname,employee.lname');
			$query->where($where);
			$query->table('employee_leave_request');
			$query->join('employee', 'employee.id = employee_leave_request.employee_id');
			$query->limit($limit,$start);
			$query->orderBy($col,$dir);
			$query = $query->get(); */
		}else{
			if(!empty($select_year)){
				$query->where('YEAR(employee_leave_request.leave_date)',$select_year);
			}
			if(!empty($select_month)){
				$query->where('MONTH(employee_leave_request.leave_date)',$select_month);
			}
			if(!empty($employee_id)){
				$query->where('employee_leave_request.employee_id',$employee_id);
			}
			if(!empty($status)){
				$query->where('employee_leave_request.status',$status);
			}
			$where="employee.fname LIKE '%".$search."%' or employee.lname LIKE '%".$search."%' or employee_leave_request.leave_date LIKE '%".$search."%' or employee_leave_request.comment LIKE '%".$search."%' or employee_leave_request.status LIKE '%".$search."%' or employee_leave_request.leave_status LIKE '%".$search."%' or employee_leave_request.status LIKE '%".$search."%'";
		}
		$date = date('Y-m-d');
		if($select_leave == 'upcoming'){
			$query->where('employee_leave_request.leave_date >= ',$date);
		}elseif($select_leave == 'recent'){
			$query->where('employee_leave_request.leave_date < ',$date);
		}
		$query->select('employee_leave_request.*,employee.fname,employee.lname');
		$query->join('employee', 'employee.id = employee_leave_request.employee_id');
		$query->where($where);
		$query->limit($limit,$start);
		$query->orderBy($col,$dir);
		$query = $query->get();
       	//$query=$this->db->query("SELECT * FROM employee_leave_request WHERE name LIKE '%".$search."%' ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
        if($query->getNumRows()>0)
        {
            return $query->getResult();  
        }
        else
        {
            return null;
        }
    }
    function posts_search_count($status,$employee_id,$select_year,$select_month,$select_leave,$search)
    {
		$query = $this->db->table('employee_leave_request');
  		if(!empty($status) && !empty($employee_id)){
			$where="(employee.fname LIKE '%".$search."%' or employee.lname LIKE '%".$search."%' or employee_leave_request.leave_date LIKE '%".$search."%' or employee_leave_request.comment LIKE '%".$search."%' or employee_leave_request.status LIKE '%".$search."%' or employee_leave_request.leave_status LIKE '%".$search."%') and employee_leave_request.status='".$status."' and employee_leave_request.employee_id=".$employee_id;
			/* $query->select('employee_leave_request.*,employee.fname,employee.lname');
			$query->table('employee_leave_request');
			$query->join('employee', 'employee.id = employee_leave_request.employee_id');
			$query->where($where);
			$query = $query->get(); */
		}else{
			if(!empty($select_year)){
				$query->where('YEAR(employee_leave_request.leave_date)',$select_year);
			}
			if(!empty($select_month)){
				$query->where('MONTH(employee_leave_request.leave_date)',$select_month);
			}
			if(!empty($employee_id)){
				$query->where('employee_leave_request.employee_id',$employee_id);
			}
			if(!empty($status)){
				$query->where('employee_leave_request.status',$status);
			}
			$where="employee.fname LIKE '%".$search."%' or employee.lname LIKE '%".$search."%' or employee_leave_request.leave_date LIKE '%".$search."%' or employee_leave_request.comment LIKE '%".$search."%' or employee_leave_request.status LIKE '%".$search."%' or employee_leave_request.leave_status LIKE '%".$search."%' or employee_leave_request.status LIKE '%".$search."%'";
		}
		$date = date('Y-m-d');
		if($select_leave == 'upcoming'){
			$query->where('employee_leave_request.leave_date >= ',$date);
		}elseif($select_leave == 'recent'){
			$query->where('employee_leave_request.leave_date < ',$date);
		}
		$query->select('employee_leave_request.*,employee.fname,employee.lname');
		$query->join('employee', 'employee.id = employee_leave_request.employee_id');
		$query->where($where);
		$query = $query->get();
		//$query=$this->db->query("SELECT * FROM employee_leave_request WHERE name LIKE '%".$search."%'");
		return $query->getNumRows();
    }
}
