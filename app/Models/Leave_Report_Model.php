<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Leave_Report_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	 $this->session = \Config\Services::session();
	} 
	
	/* public function get_employees(){
		$this->db->select('*');
		$this->db->table('employee');
		$this->db->where('status','1');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	}	 */
	/* public function get_employees_leave($limit,$start){
		$this->db->select('*');
		$this->db->table('employee');
		$this->db->where('status','1');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
   public function update_employee_paid_leave($data) {
	   $this->db->table('employee_paid_leaves')->where('id',$data['id'])->where('employee_id',$data['employee_id'])->update($data);
	   return true;
   }
	public function get_employees_leave($emp_id){
		$query =$this->db->table('employee')
				->select('*')
				->where('id',$emp_id)
				->limit(1)
				->where('status','1')
		 		->get();
		$row = $query->getResult();
		return $row;
	}
	/* public function employee_paid_leaves($id){
		$this->db->select('*');
		$this->db->table('employee_paid_leaves');
		$this->db->where('employee_id',$id);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	/* public function employee_paid_unused($id,$count){
		$this->db->select('*');
		$this->db->table('employee_paid_leaves');
		$this->db->where('employee_id',$id);
		$this->db->where('status','unused');
		$this->db->orderBy('month','asc');
		$this->db->limit($count,0);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	/* == == */
	/* public function all_paid_unused($id){
		$this->db->select('*');
		$this->db->table('employee_paid_leaves');
		$this->db->where('employee_id',$id);
		$this->db->where('status','unused');
		$this->db->orderBy('month','asc');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	// public function employee_paid_leave_payout($id){
	public function employee_paid_leaves($id,$status='',$count=''){
		$query = $this->db->table('employee_paid_leaves')->select('*')->where('employee_id',$id);
		if($status != ''){
			$query->where('status',$status)->orderBy('year asc, month asc');
		}
		if($count != ''){
			$query->limit($count,0);
		}
		$query = $query->get();
		$row = $query->getResult();
		return $row;
	}
	public function employee_paid_leaves_status($id,$status='',$count=''){
		$query = $this->db->table('employee_paid_leaves')
				->select('*')
				->where('employee_id',$id);
		if($status != ''){
			$query->where('status',$status);
			$query->orderBy('month','asc');
		}
		if($count != ''){
			$query->limit($count,0);
		}
		$query = $query->get();
		$row = $query->getResult();
		return $row;
	}
	/* == == */
	public function employee_month_paid_leaves($month,$year,$id){
		$query = $this->db->table('employee_paid_leaves')
				->select('*')
				->where('employee_id',$id)
				->where('year',$year)
				->where('month',$month)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_salary_pay($id,$month,$year){
		$query = $this->db->table('salary_pay')
				->select('*')
				->where('employee_id', $id)
				->where('month', $month)
				->where('year', $year)
				->get();
		$row = $query->getResult();
		return $row;
	}
	
	function allposts_count($id)
    {  
		$query = $this->db->table('salary_pay')->where('employee_id',$id)->get();
		return $query->getNumRows();  
    }
    
    function allposts($id,$limit,$start,$col,$dir)
    {   
     	$query = $this->db->table('salary_pay')->where('employee_id',$id)->limit($limit,$start)->orderBy($col,$dir)->get();
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
        
    }
	public function get_employee_list_with_leave($arr) {
   		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		$year=$arr['year'];
		$emp_id=$arr['id'];
		if($user_role == "admin"){   
			$query = $this->db->table('employee')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.status',"1")->where('employee.id',$emp_id)->where('salary_pay.year',$year)->get();
		}else{
			$query = $this->db->table('employee')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.id',$id)->where('salary_pay.year',$year)->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
	}
    public function get_employee_paid_leaves($arr) {
   		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		$year=$arr['year'];
		$emp_id=$arr['id'];
		if($user_role == "admin"){
			$query = $this->db->table('employee')->join('employee_paid_leaves', 'employee.id = employee_paid_leaves.employee_id')->where('employee.status',"1")->where('employee.id',$emp_id)->where('employee_paid_leaves.year',$year)->get();
		}else{
			$query = $this->db->table('employee')->join('employee_paid_leaves', 'employee.id = employee_paid_leaves.employee_id')->where('employee.id',$id)->where('employee_paid_leaves.year',$year)->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
	}
	/* public function get_employee_paid_leaves1($arr) {
   		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		$year=$arr['year'];
		$month=$arr['month'];
		$emp_id=$arr['id'];
		if($user_role == "admin"){
			$query = $this->db->table('employee')->join('employee_paid_leaves', 'employee.id = employee_paid_leaves.employee_id')->where('employee.status',"1")->where('employee.id',$emp_id)->where('employee_paid_leaves.year',$year)->where('employee_paid_leaves.month',$month)->get();
		}else{
			$query = $this->db->table('employee')->join('employee_paid_leaves', 'employee.id = employee_paid_leaves.employee_id')->where('employee.id',$id)->where('employee_paid_leaves.year',$year)->where('employee_paid_leaves.month',$month)->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
	} */
	function get_year_employee_paid_leaves()
    {   
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->distinct()->select('employee_paid_leaves.year')->join('employee_paid_leaves', 'employee.id = employee_paid_leaves.employee_id')->where('employee.status',"1")->orderBy('employee_paid_leaves.year','asc')->get();
		}else{
			$query = $this->db->table('employee')->distinct()->select('employee_paid_leaves.year')->join('employee_paid_leaves', 'employee.id = employee_paid_leaves.employee_id')->where('employee.id',$id)->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
        
    }
	 function get_leave_year()
    {   
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->distinct()->select('salary_pay.year')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.status',"1")->orderBy('salary_pay.year','asc')->get();
		}else{
			$query = $this->db->table('employee')->distinct()->select('salary_pay.year')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.id',$id)->get();
		}
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
       	//$query=$this->db->query("SELECT * FROM salary_pay WHERE employee_id=".$id." and salary_pay LIKE '%".$search."%' ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
		   $query = $this->db->table('salary_pay')
				->select('*')
				->where('employee_id',$id)
				->like('salary_pay',$search)
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
    function posts_search_count($id,$search)
    {
  		//$query=$this->db->query("SELECT * FROM salary_pay WHERE salary_pay LIKE '%".$search."%' and employee_id=".$id);
		  $query = $this->db->table('salary_pay')
				->select('*')
				->where('employee_id',$id)
				->like('salary_pay',$search)
				->get();
		return $query->getNumRows();
    }
	function leave_count($month,$year){
		$m=date('m');
		$y=date('Y');
		if($m == $month && $y == $year){
			//echo "hello";
			$query = $this->db->table('employee')
					->select('*')
					->where('status','1')
					->get();
			
		}else{
			$query = $this->db->table('employee')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.status',"1")->where('salary_pay.month',$month)->where('salary_pay.year',$year)->get();	
		}
		
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
	}
	/*  deposit payment page */
	function allposts_count_deposit($arr)
    {  
		$user_role=$this->session->get('user_role');
		$month=$arr['month'];
		$year=$arr['year'];
		$id=$this->session->get('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.status',"1")->where('salary_pay.month',$month)->where('salary_pay.year',$year)->get();	
		}else{
			$query = $this->db->table('employee')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.id',$id)->where('salary_pay.month',$month)->where('salary_pay.year',$year)->get();
		}
		
		return $query->getNumRows();  
    }
    
    function allposts_deposit($arr,$limit,$start,$col,$dir)
    {   
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		$month=$arr['month'];
		$year=$arr['year'];
		$col_name='employee.'.$col;
		if($col == "paid_leave" || $col == "absent_leave"){
			$col_name='salary_pay.'.$col;
		}else{
			$col_name='employee.'.$col;
		}
		if($user_role == "admin"){
			$query = $this->db->table('employee')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.status',"1")->where('salary_pay.month',$month)->where('salary_pay.year',$year)->limit($limit,$start)->orderBy($col_name,$dir)->get();
		}else{
			$query = $this->db->table('employee')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.id',$id)->where('salary_pay.month',$month)->where('salary_pay.year',$year)->limit($limit,$start)->orderBy('employee.'.$col_name,$dir)->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
        
    }
	function posts_search_deposit($arr,$limit,$start,$search,$col,$dir)
    {
		//->join('salary_pay', 'employee.id = salary_pay.employee_id', 'left')
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		$month=$arr['month'];
		$year=$arr['year'];
		$col_name='employee.'.$col;
		if($col == "paid_leave" || $col == "absent_leave"){
			$col_name='salary_pay.'.$col;
		}else{
			$col_name='employee.'.$col;
		}
		if($user_role == "admin"){
			//$query=$this->db->query("SELECT * FROM employee  join salary_pay on 'employee.id = salary_pay.employee_id' WHERE salary_pay.month = '".$month."' AND salary_pay.year = '".$year."' AND employee.status = '1' and (salary_pay.paid_leave LIKE '%".$search."%' OR employee.fname LIKE '%".$search."%' OR employee.lname LIKE '%".$search."%' OR employee.email LIKE '%".$search."%') ORDER BY ".$col_name." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')
					->select('*')
					->join('salary_pay', 'employee.id = salary_pay.employee_id')
					->where('salary_pay.month', $month)
					->where('salary_pay.year', $year)
					->where('employee.status', '1')
					->like('salary_pay.paid_leave', $search)
					->orLike('employee.fname', $search)
					->orLike('employee.lname', $search)
					->orLike('employee.email', $search)
					->limit($limit,$start)
					->orderBy($col_name,$dir)
					->get();
        }else{
			//$query=$this->db->query("SELECT * FROM employee  join salary_pay on 'employee.id = salary_pay.employee_id' WHERE  salary_pay.month = '".$month."' AND salary_pay.year = '".$year."' AND employee.id= ".$id." and  (salary_pay.paid_leave LIKE '%".$search."%' OR employee.fname LIKE '%".$search."%' OR employee.lname LIKE '%".$search."%' OR employee.email LIKE '%".$search."%') ORDER BY ".$col_name." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')
					->select('*')
					->join('salary_pay', 'employee.id = salary_pay.employee_id')
					->where('salary_pay.month', $month)
					->where('salary_pay.year', $year)
					->where('employee.id', $id)
					->like('salary_pay.paid_leave', $search)
					->orLike('employee.fname', $search)
					->orLike('employee.lname', $search)
					->orLike('employee.email', $search)
					->limit($limit,$start)
					->orderBy($col_name,$dir)
					->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult();  
        }
        else
        {
            return null;
        }
    }
    function posts_search_count_deposit($arr,$search)
    {
  		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		$month=$arr['month'];
		$year=$arr['year'];
		if($user_role == "admin"){
			//$query=$this->db->query("SELECT * FROM employee join salary_pay on 'employee.id = salary_pay.employee_id' WHERE salary_pay.month = '".$month."' AND salary_pay.year = '".$year."' AND employee.status = '1' and salary_pay.paid_leave LIKE '%".$search."%' OR employee.fname LIKE '%".$search."%' OR employee.lname LIKE '%".$search."%' OR employee.email LIKE '%".$search."%'");
			$query = $this->db->table('employee')
					->select('*')
					->join('salary_pay', 'employee.id = salary_pay.employee_id')
					->where('salary_pay.month', $month)
					->where('salary_pay.year', $year)
					->where('employee.status', '1')
					->like('salary_pay.paid_leave', $search)
					->orLike('employee.fname', $search)
					->orLike('employee.lname', $search)
					->orLike('employee.email', $search)
					->get();
		}else{
			//$query=$this->db->query("SELECT * FROM employee join salary_pay on 'employee.id = salary_pay.employee_id' WHERE salary_pay.month = '".$month."' AND salary_pay.year = '".$year."' AND employee.id= ".$id." and (salary_pay.paid_leave LIKE '%".$search."%' OR employee.fname LIKE '%".$search."%' OR employee.lname LIKE '%".$search."%' OR employee.email LIKE '%".$search."%')");
			$query = $this->db->table('employee')
					->select('*')
					->join('salary_pay', 'employee.id = salary_pay.employee_id')
					->where('salary_pay.month', $month)
					->where('salary_pay.year', $year)
					->where('employee.id', $id)
					->like('salary_pay.paid_leave', $search)
					->orLike('employee.fname', $search)
					->orLike('employee.lname', $search)
					->orLike('employee.email', $search)
					->get();
		}
		return $query->getNumRows();
    }
}
?>