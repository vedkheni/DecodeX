<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Deposit_Payment_Model extends Model {
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
	function insert_deposit($arr){
		$deposit=$this->db->table('deposit')->insert($arr);
		if($deposit){
			return true;
		}else{
			return false;
		}
	}
	function update_deposit($arr){
		$deposit=$this->db->table('deposit')
				->where('id',$arr['id'])
				->update($arr);
		if($deposit){
			return true;
		}else{
			return false;
		}
	}
	function update_deposit_by_empId($id,$arr){
		$deposit = $this->db->table('deposit')
				->where('employee_id',$id);
		if(isset($arr['id'])){
			$deposit->where('id',$arr['id']);
		}
		if(isset($arr['month'])){
			$deposit->where('month',$arr['month']);
		}
		if(isset($arr['year'])){
			$deposit->where('year',$arr['year']);
		}
		$deposit = $deposit->update($arr);
		if($deposit){
			return true;
		}else{
			return false;
		}
	}
	public function deposit_payment_tbl(){
		$where="employee.account_number != '' and employee.ifsc_number != '' and deposit_payment.deposit_payment != '0'";
		$query = $this->db->table('deposit_payment')
				->select('*')
				->join('employee', 'employee.id = deposit_payment.employee_id')
				->where($where)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function salary_all_details($id,$month,$year){
		/* $this->db->where('id',279);
		$this->db->where('employee_id',8);
		$this->db->delete('salary_pay'); */
		$query = $this->db->table('salary_pay')
				->select('*')
				->where('employee_id',$id)
				->where('month',$month)
				->where('year',$year)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_employees_details($id){
		$query = $this->db->table('employee')
				->select('*')
				->where('id',$id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function current_month_deposit($id,$month,$year){
		$query = $this->db->table('deposit')
				->select('deposit_amount')
				->where('employee_id',$id)
				->where('month',$month)
				->where('year',$year)
				->get();
		$row = $query->getRow();
		return $row;
	}
	/* public function get_deposit_total($id){
		$this->db->select('deposit_amount');
		$this->db->from('deposit');
		$this->db->where('employee_id',$id);
		$this->db->groupBy("month");
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	public function get_deposit_list($id,$payment_status=''){
		$query =$this->db->table('deposit')
				->select('*')
				->where('employee_id',$id);
		if($payment_status != ''){
			$query->where('payment_status',$payment_status);
		}
		$query->groupBy("month");
		$query = $query->get();
		$row = $query->getResult();
		return $row;
	}
	
	/* public function get_deposit_list_pending($id){
		$this->db->select('*');
		$this->db->from('deposit');
		$this->db->where('employee_id',$id);
		$this->db->where('payment_status','pending');
		$this->db->groupBy("month");
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	
	function allposts_count($id)
    {  
		$query = $this->db->table('deposit')->where('employee_id',$id)->groupBy("month")->get();
		return $query->getNumRows();  
    }
    
    function allposts($id,$limit,$start,$col,$dir)
    {   
		if($col == 'month'){
			$order = $col.' '.$dir.', '.'year DESC';
		}else{
			$order = $col.' '.$dir;
		}
     	$query = $this->db->table('deposit')->where('employee_id',$id)->limit($limit,$start)->orderBy($order)->groupBy("month")->get();
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
        $query = $this->db->table('deposit')->select('*')->where('employee_id',$id)->like('deposit_amount',$search)->orLike('month',$search)->orLike('year',$search)->orLike('payment_status',$search)->limit($limit,$start)->orderBy($col,$dir)->groupBy("month")->get();
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
  		// $query=$this->db->query("SELECT * FROM deposit WHERE deposit_amount LIKE '%".$search."%' and month LIKE '%".$search."%' and year LIKE '%".$search."%' and payment_status LIKE '%".$search."%' and employee_id=".$id." Group BY month");
		$query = $this->db->table('deposit')->select('*')->where('employee_id', $id)->like('deposit_amount', $search)->orLike('payment_status', $search)->orLike('year', $search)->orLike('month', $search)->groupBy('month')->get();
		return $query->getNumRows();
    }
}
?>