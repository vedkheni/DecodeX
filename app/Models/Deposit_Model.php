<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Deposit_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	
	/* public function get_employees(){
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where('status','1');
		$this->db->orderBy('fname','asc');
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	} */
	public function get_employee_deposit($limit,$start){
		$query = $this->db->table('employee')
				->select('*')
				->where('status','1')
				->limit($limit,$start)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_deposit_details($emp_id,$year="",$month=""){
		$query = $this->db->table('deposit')
				->select('*')
				->where('employee_id',$emp_id);
		if($year != ''){
			$query->where('year',$year);
		}
		if($month != ''){
			$query->where('month',$month);
		}
		$query = $query->get();
		$row = $query->getResult();
		return $row;
	}
	
	public function get_deposit_by_id($deposit_id){
		$query = $this->db->table('deposit')
				->select('*')
				->where('id',$deposit_id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function deleteDeposit($id,$emp_id) {
		$this->db->table('deposit')
				->where('id', $id)
				->where('employee_id', $emp_id)
				->delete();
		return true;
	}
	
	public function deleteDeposit_by_monthYear($employee_id,$month,$year) {
		$this->db->table('deposit')
				->where('employee_id', $employee_id)
				->where('month',$month)
				->where('year',$year)
				->delete();
		return true;
	}

	function get_deposit_year()
    {   
		$query = $this->db->table('deposit')
				->select('year')
				->distinct()
				->orderBy('year','asc')
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
   
    function posts_search($id,$limit,$start,$search,$col,$dir)
    {
       	// $query=$this->db->query("SELECT * FROM salary_pay WHERE employee_id=".$id." and salary_pay LIKE '%".$search."%' ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
		$query = $this->db->table('salary_pay')->select('*')->where('employee_id', $id)->like('salary_pay', $search)->orderBy($col, $dir)->limit($limit, $start)->get();
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
		$query = $this->db->table('salary_pay')->select('*')->where('employee_id', $id)->like('salary_pay', $search)->get();
		return $query->getNumRows();
    }
	/*  deposit payment page */
	function allposts_count_deposit()
    {  
		$user_role=$this->session->userdata('user_role');
		$id=$this->session->userdata('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->where('status',"1")->get();	
		}else{
			$query = $this->db->table('employee')->where('id',$id)->get();
		}
		
		return $query->getNumRows();  
    }
    
    function allposts_deposit($limit,$start,$col,$dir)
    {   
		$user_role=$this->session->userdata('user_role');
		$id=$this->session->userdata('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->where('status',"1")->limit($limit,$start)->orderBy($col,$dir)->get();
		}else{
			$query = $this->db->table('employee')->where('id',$id)->limit($limit,$start)->orderBy($col,$dir)->get();
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
   
    function posts_search_deposit($limit,$start,$search,$col,$dir)
    {
		$user_role=$this->session->userdata('user_role');
		$id=$this->session->userdata('id');
		if($user_role == "admin"){
			//$query=$this->db->query("SELECT * FROM employee WHERE status = '1' and fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%' ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')->select('*')->where('status', '1')->like('fname', $search)->orLike('lname', $search)->orLike('email', $search)->orderBy($col, $dir)->limit($limit, $start)->get();
		}else{
			// $query=$this->db->query("SELECT * FROM employee WHERE  id= ".$id." and  (fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%') ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')->select('*')->where('id', $id)->like('fname', $search)->orLike('lname', $search)->orLike('email', $search)->orderBy($col, $dir)->limit($limit, $start)->get();
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
    function posts_search_count_deposit($search)
    {
  		$user_role=$this->session->userdata('user_role');
		$id=$this->session->userdata('id');
		if($user_role == "admin"){
			// $query=$this->db->query("SELECT * FROM employee WHERE status = '1' and fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%'");
			$query = $this->db->table('employee')->select('*')->where('status', '1')->like('fname', $search)->orLike('lname', $search)->orLike('email', $search)->get();
		}else{
			// $query=$this->db->query("SELECT * FROM employee WHERE id= ".$id." and (fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%')");
			$query = $this->db->table('employee')->select('*')->where('id', $id)->like('fname', $search)->orLike('lname', $search)->orLike('email', $search)->get();
		}
		return $query->getNumRows();
    }
}
?>