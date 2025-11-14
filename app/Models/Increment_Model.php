<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Increment_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	/* function get_employees(){
		$this->db->select('*');
		$this->db->from('employee');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	/* function insert_deposit($arr){
		$deposit=$this->db->insert('deposit',$arr);
		if($deposit){
			return true;
		}else{
			return false;
		}
	} */
	public function update_data($data) {
		$this->db->table('employee_increment')->where('id', $data['id'])->update($data);
		return true;
	}
	// public function deposit_payment_tbl(){
	// 	$where="employee.account_number != '' and employee.ifsc_number != '' and deposit_payment.deposit_payment != '0'";
	// 	$this->db->select('*');
	// 	$this->db->from('deposit_payment');
	// 	$this->db->join('employee', 'employee.id = deposit_payment.employee_id');
	// 	$this->db->where($where);
	// 	$query = $this->db->get();
	// 	$row = $query->getResult();
	// 	return $row;
	// }
	/* public function get_employees_details($id){
		$this->db->select('*');
		$this->db->from('employee');
		$this->db->where('id',$id);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
/* 	public function current_month_deposit($id,$month,$year){
		$this->db->select('deposit_amount');
		$this->db->from('deposit');
		$this->db->where('employee_id',$id);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$query = $this->db->get();
		$row = $query->row();
		return $row;
	}
	public function get_deposit_total($id){
		$this->db->select('deposit_amount');
		$this->db->from('deposit');
		$this->db->where('employee_id',$id);
		$this->db->group_by("month");
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_deposit_list($id){
		$this->db->select('*');
		$this->db->from('deposit');
		$this->db->where('employee_id',$id);
		$this->db->group_by("month");
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	
	public function get_deposit_list_pending($id){
		$query = $this->db->table('employee_increment')
				->select('*')
				->where('employee_id',$id)
				->get();
		$row = $query->getResult();
		return $row;
	}
	
	function allposts_count($id)
    {  
		$query = $this->db->table('employee_increment')->where('employee_id',$id)->get();
		return $query->getNumRows();  
    }
    
    function allposts($id,$limit,$start,$col,$dir)
    {   
     	$query = $this->db->table('employee_increment')->where('employee_id',$id)->limit($limit,$start)->orderBy($col,$dir)->get();
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
        $query = $this->db->table('employee_increment')->where('employee_id',$id)->like('employee_id',$search)->orLike('amount',$search)->orLike('increment_date',$search)->orLike('next_increment_date',$search)->limit($limit,$start)->orderBy($col,$dir)->get();
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
  		//$query=$this->db->query("SELECT * FROM employee_increment WHERE amount LIKE '%".$search."%' and increment_date LIKE '%".$search."%' and next_increment_date LIKE '%".$search."%' and employee_id LIKE '%".$search."%' and employee_id=".$id);
		$query = $this->db->table('employee_increment')
				->select('*')
				->where('employee_id', $id)
				->like('amount', $search)
				->orLike('increment_date', $search)
				->orLike('next_increment_date', $search)
				->orLike('employee_id', $search)
		 		->get();
		return $query->getNumRows();
    }
}
?>