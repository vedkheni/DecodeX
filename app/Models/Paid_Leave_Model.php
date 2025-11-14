<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Paid_Leave_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	/* function get_employees(){
		$this->db->select('*');
        $this->db->table('employee');
        $this->db->where('status','1');
		$this->db->orderBy('fname','asc');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
    public function insert_data($data) {
        $this->db->table('employee_paid_leaves')->insert($data);
        return true;
    }
	public function update_data($data) {
		$update = $this->db->table('employee_paid_leaves')->where('id', $data['id']);
		if(isset($data['employee_id']) && $data['employee_id'] != ''){
			$update->where('employee_id',$data['employee_id']);
		}
		$update->update($data);
		return true;
    }
	public function update_byMonthYear($data) {
		$update = $this->db->table('employee_paid_leaves');
		if(isset($data['employee_id']) && $data['employee_id'] != ''){
			$update->where('employee_id',$data['employee_id']);
		}
		if(isset($data['month']) && $data['month'] != ''){
			$update->where('month',$data['month']);
		}
		if(isset($data['year']) && $data['year'] != ''){
			$update->where('year',$data['year']);
		}
		$update->update($data);
		return true;
    }
    public function delete_data($id,$employee_id) {
		$this->db->table('employee_paid_leaves')->where('id', $id)->where('employee_id', $employee_id)->delete();
		return true;
	}

    /* 
	public function update_emp_paid_leave($leave_id,$paid_leave) {
		$this->db->where('id',$leave_id);
		$this->db->update('employee_paid_leaves',$paid_leave);
		return true;
	} */
	public function emp_paid_leave($leave_id) {
		$query = $this->db->table('employee_paid_leaves')
				->select('*')
				->where('id',$leave_id)
				->limit(1)
		 		->get();
		$row = $query->getResult();
		return $row;
    }
	public function get_nextMonth_paidLeave($emp_id,$status="",$month="",$year="") {
		$query = $this->db->table('employee_paid_leaves')->select('*')->where('employee_id',$emp_id);
		if($status != ''){
			$query->where('status',$status);
		}
		if($month != ''){
			// $month = date('m', strtotime('+1 month', strtotime(date('Y').'-'.$month.'-01')));
			if($month != 12){
				$query->where('month >',$month);
			}
		}
		if($year != ''){
			$month = ($month != '') ? $month : date('m');
			$year = date('Y', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));
			$query->where('year >=',$year);
		}
		$query = $query->get();
		// echo $this->db->getLastQuery();
		// exit;
		return $query->getResult();
	}
	public function employee_paid_leave($emp_id,$status='') {
		$query = $this->db->table('employee_paid_leaves')
				->select('*')
				->where('employee_id',$emp_id);
		if($status != ''){
			$query = $query->where('status',$status);
		}
		$query = $query->get();
		$row = $query->getResult();
		return $row;
    }
	/* public function get_employees_details($id){
		$this->db->select('*');
		$this->db->table('employee');
		$this->db->where('id',$id);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
    } */
    
	function allposts_count($id)
    {  
		$query = $this->db->table('employee_paid_leaves')->where('employee_id',$id)->get();
		return $query->getNumRows();
    }
    
    function allposts($id,$limit,$start,$col,$dir)
    {   
     	$query = $this->db->table('employee_paid_leaves')->where('employee_id',$id)->limit($limit,$start)->orderBy($col,$dir)->get();
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search($id,$limit,$start,$search,$col,$dir)
    {
       	// $query=$this->db->query("SELECT * FROM deposit WHERE employee_id=".$id." and deposit_amount LIKE '%".$search."%' and month LIKE '%".$search."%' and year LIKE '%".$search."%' and payment_status LIKE '%".$search."%' Group BY month ORDER BY ".$col." ".$dir."  LIMIT ".$limit." OFFSET ".$start."");
        $query = $this->db->table('employee_paid_leaves')->where('employee_id',$id)->like('employee_id',$search)->orLike('month',$search)->orLike('year',$search)->orLike('status',$search)->orLike('used_leave_month',$search)->limit($limit,$start)->orderBy($col,$dir)->get();
        if($query->getNumRows()>0)
        {
            return $query->getResult();  
        }
        else
        {
            return null;
        }
    }
    function posts_search_count($id,$search)
    {
          // $query=$this->db->query("SELECT * FROM employee_paid_leaves WHERE used_leave_month LIKE '%".$search."%' and 'month' LIKE '%".$search."%' and 'year' LIKE '%".$search."%' and 'status' LIKE '%".$search."%' and employee_id LIKE '%".$search."%' and employee_id=".$id);
          $query = $this->db->table('employee_paid_leaves')->where('employee_id',$id)->like('employee_id',$search)->orLike('month',$search)->orLike('year',$search)->orLike('status',$search)->orLike('used_leave_month',$search)->get();
		return $query->getNumRows();
    }
}
?>