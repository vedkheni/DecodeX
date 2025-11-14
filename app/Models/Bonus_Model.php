<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Bonus_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	public function insert_employee($data) {
     	if ($this->db->table("bonus")->insert($data)) { 
			return true; 
		} 
	}
	public function update_employee($data) {
		$query = $this->db->table('bonus');
		if(isset($data['id'])){
			$query->where('id', $data['id']);
		}
		if(isset($data['emp_id'])){
			$query->where('emp_id', $data['emp_id']);
		}
		if(isset($data['month'])){
			$query->where('month', $data['month']);
		}
		if(isset($data['year'])){
			$query->where('year', $data['year']);
		}
		$query->update($data);
		return true;
	}
	public function delete_employee($id,$emp_id) {
		$this->db->table('bonus')->where('id', $id)->where('emp_id', $emp_id)->delete();
		return true;
	}
	public function get_bonus($id){
		$query = $this->db->table('bonus')
				->select('*')
				->where('id', $id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	/* public function get_employees(){
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where('status','1');
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	} */
	/* public function get_employee_bonus($limit,$start){
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where('status','1');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	} */
	/* public function get_bonus_details($emp_id,$year){
		$this->db->select('*');
		$this->db->from('bonus');
		$this->db->where('emp_id',$emp_id);
		$this->db->where('year',$year);
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	} */
	public function get_bonus_details($emp_id,$year){
		$query = $this->db->table('salary_pay')
				->select('*')
				->where('employee_id', $emp_id)
				->where('year', $year)
				->get();
		$row = $query->getResult();
		return $row;
	}
	function get_bonus_year()
    {   
		$query = $this->db->table('bonus')
				->select('year')
				->distinct()
				->orderBy('year','asc')
				->get();
		$row = $query->getResult();
		return $row;
    }
	
	public function get_bonus_month($emp_id,$month,$year){
		$query = $this->db->table('bonus')
				->select('*')
				->where('month', $month)
				->where('year', $year)
				->where('emp_id', $emp_id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_salary_pay($emp_id,$month,$year){
		$query = $this->db->table('salary_pay')
				->select('*')
				->get();
		/* $this->db->where('month', $month);
		$this->db->where('year', $year);
		$this->db->where('emp_id', $emp_id); */
		$row = $query->getResult();
		return $row;
	}
	public function get_designation(){
		$query = $this->db->table('bonus')
				->select('*')
				->get();
		$row = $query->getResult();
		return $row;
	}

	/* ====================== =================== */
	function allposts_count($id,$year)
    {  
		if($year != "all"){
			$query = $this->db->table('salary_pay')->where('employee_id',$id)->where('year',$year)->where('bonus !=','0.00')->get();
		}else{
			$query = $this->db->table('salary_pay')->where('employee_id',$id)->where('bonus !=','0.00')->get();
		}
		
		return $query->getNumRows();  
    }
    
    function allposts($id,$year,$limit,$start,$col,$dir)
    {   
		if($year != "all"){
			$query = $this->db->table('salary_pay')->where('employee_id',$id)->where('year',$year)->where('bonus !=','0.00')->limit($limit,$start)->orderBy($col,$dir)->get();
		}else{
			$query = $this->db->table('salary_pay')->where('employee_id',$id)->where('bonus !=','0.00')->limit($limit,$start)->orderBy($col,$dir)->get();
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
   
    function posts_search($id,$year,$limit,$start,$search,$col,$dir)
    {
		if($year != "all"){
			//$query=$this->db->query("SELECT * FROM salary_pay WHERE year = '".$year."' and employee_id=".$id." and bonus != '0.00' and (bonus LIKE '%".$search."%' OR month LIKE '%".$search."%' OR year LIKE '%".$search."%') ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('salary_pay')->select('*')->where('year', $year)->where('employee_id', $id)->where('bonus !=', '0.00')->like('bonus', $search)->orLike('month', $search)->orLike('year', $search)->orderBy($col, $dir)->limit($limit, $start)->get();
        }else{
			//$query=$this->db->query("SELECT * FROM salary_pay WHERE employee_id=".$id." and bonus != '0.00' and (bonus LIKE '%".$search."%' OR month LIKE '%".$search."%' OR year LIKE '%".$search."%') ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('salary_pay')->select('*')->where('employee_id', $id)->where('bonus !=', '0.00')->like('bonus', $search)->orLike('month', $search)->orLike('year', $search)->orderBy($col, $dir)->limit($limit, $start)->get();
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
	
    function posts_search_count($id,$year,$search)
    {
		if($year != "all"){
			//$query=$this->db->query("SELECT * FROM salary_pay WHERE year = '".$year."' and bonus != '0.00' and (bonus LIKE '%".$search."%' OR month LIKE '%".$search."%' OR year LIKE '%".$search."%') and employee_id=".$id);
			$query = $this->db->table('salary_pay')->select('*')->where('year', $year)->where('employee_id', $id)->where('bonus !=', '0.00')->like('bonus', $search)->orLike('month', $search)->orLike('year', $search)->get();
		}else{
			//$query=$this->db->query("SELECT * FROM salary_pay WHERE  bonus != '0.00' and (bonus LIKE '%".$search."%' OR month LIKE '%".$search."%' OR year LIKE '%".$search."%') and employee_id=".$id);
			$query =  $this->db->table('salary_pay')->select('*')->where('employee_id', $id)->where('bonus !=', '0.00')->like('bonus', $search)->orLike('month', $search)->orLike('year', $search)->get();
		}
  		return $query->getNumRows();
    }
}
?>