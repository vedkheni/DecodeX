<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Prof_Tax_Model extends Model {
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
	} */
	public function get_employees_tax($limit,$start){
		$query = $this->db->table('employee')
				->select('*')
				->where('status','1')
				->limit($limit,$start)
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
	function prof_tax_count($month,$year){
		$m=date('m');
		$y=date('Y');
		if($m == $month && $y == $year){
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
		if($col == "prof_tax"){
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
    function allposts_prof_tax($arr)
    // function allposts_prof_tax($arr,$limit,$start,$col,$dir)
    {   
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		$year=$arr['year'];
		$emp_id = $arr['id'];
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
    function get_prof_tax_year()
    // function allposts_prof_tax($arr,$limit,$start,$col,$dir)
    {   
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->distinct()->select('salary_pay.year')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.status',"1")->orderBy('salary_pay.year','asc')->get();
		}else{
			$query = $this->table('employee')->db->distinct()->select('salary_pay.year')->join('salary_pay', 'employee.id = salary_pay.employee_id')->where('employee.id',$id)->get();
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
		if($col == "prof_tax"){
			$col_name='salary_pay.'.$col;
		}else{
			$col_name='employee.'.$col;
		}
		if($user_role == "admin"){
			//$query=$this->db->query("SELECT * FROM employee  join salary_pay on 'employee.id = salary_pay.employee_id' WHERE salary_pay.month = '".$month."' AND salary_pay.year = '".$year."' AND employee.status = '1' and (salary_pay.prof_tax LIKE '%".$search."%' OR employee.fname LIKE '%".$search."%' OR employee.lname LIKE '%".$search."%' OR employee.email LIKE '%".$search."%') ORDER BY ".$col_name." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')
					->select('*')
					->join('salary_pay', 'employee.id = salary_pay.employee_id')
					->where('salary_pay.month', $month)
					->where('salary_pay.year', $year)
					->where('employee.status', '1')
					->like('salary_pay.prof_tax', $search)
					->orLike('employee.fname', $search)
					->orLike('employee.lname', $search)
					->orLike('employee.email', $search)
					->limit($limit,$start)
					->orderBy($col_name,$dir)
					->get();
		}else{
			//$query=$this->db->query("SELECT * FROM employee  join salary_pay on 'employee.id = salary_pay.employee_id' WHERE  salary_pay.month = '".$month."' AND salary_pay.year = '".$year."' AND employee.id= ".$id." and  (salary_pay.prof_tax LIKE '%".$search."%' OR employee.fname LIKE '%".$search."%' OR employee.lname LIKE '%".$search."%' OR employee.email LIKE '%".$search."%') ORDER BY ".$col_name." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')
					->select('*')
					->join('salary_pay', 'employee.id = salary_pay.employee_id')
					->where('salary_pay.month', $month)
					->where('salary_pay.year', $year)
					->where('employee.id', $id)
					->like('salary_pay.prof_tax', $search)
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
			//$query=$this->db->query("SELECT * FROM employee join salary_pay on 'employee.id = salary_pay.employee_id' WHERE salary_pay.month = '".$month."' AND salary_pay.year = '".$year."' AND employee.status = '1' and salary_pay.prof_tax LIKE '%".$search."%' OR employee.fname LIKE '%".$search."%' OR employee.lname LIKE '%".$search."%' OR employee.email LIKE '%".$search."%'");
			$query = $this->db->table('employee')
					->select('*')
					->join('salary_pay', 'employee.id = salary_pay.employee_id')
					->where('salary_pay.month', $month)
					->where('salary_pay.year', $year)
					->where('employee.status', '1')
					->like('salary_pay.prof_tax', $search)
					->orLike('employee.fname', $search)
					->orLike('employee.lname', $search)
					->orLike('employee.email', $search)
					->get();
		}else{
			//$query=$this->db->query("SELECT * FROM employee join salary_pay on 'employee.id = salary_pay.employee_id' WHERE salary_pay.month = '".$month."' AND salary_pay.year = '".$year."' AND employee.id= ".$id." and (salary_pay.prof_tax LIKE '%".$search."%' OR employee.fname LIKE '%".$search."%' OR employee.lname LIKE '%".$search."%' OR employee.email LIKE '%".$search."%')");
			$query = $this->db->table('employee')
					->select('*')
					->join('salary_pay', 'employee.id = salary_pay.employee_id')
					->where('salary_pay.month', $month)
					->where('salary_pay.year', $year)
					->where('employee.id', $id)
					->like('salary_pay.prof_tax', $search)
					->orLike('employee.fname', $search)
					->orLike('employee.lname', $search)
					->orLike('employee.email', $search)
					->get();
		}
		return $query->getNumRows();
    }
}
?>