<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Employee_Increment_Model extends Model {
	
/* 	function __construct() { 
		parent::__construct(); 
	}  */
	// $insert = $this->db->query("DELETE FROM `employee_increment` WHERE `employee_increment`.`employee_id` = 37");

	public function insert_data($data) {
		$insert = $this->db->table("employee_increment")->insert($data);

		if ($insert){ 
			$insert_id = $this->db->insertID();
			return  $insert_id;
		}
	}
	public function update_data($data) {
		$this->db->table('employee_increment')->where('id', $data['id'])->update($data);
		//$this->db->where('employee_id', $data['employee_id']);
		return true;
	}
	public function delete_row($id) {
		$this->db->table('employee_increment')->where('id', $id)->delete();
		return true;
	}
	 public function get_employee_increment_row($id){
		$query = $this->db->table('employee_increment')
				->select('employee_increment.*,employee.fname,employee.lname,employee.joining_date,employee.salary,employee.employee_status')
				->join('employee', 'employee.id = employee_increment.employee_id')
				->where('employee_increment.employee_id', $id)
				->groupBy("employee_increment.employee_id")
		 		->get();
		$row = $query->getRow();
		return $row;
	}
	/* public function get_employee_increment_row1($id){
		$this->db->select('*');
		$this->db->table('employee_increment');
		$this->db->where('employee_id', $id);
		$query = $this->db->get();
		$row = $query->getRow();
		return $row;
	} */
	/* public function get_employee_increment_data($id){
		$this->db->select('*');
		$this->db->table('employee_increment');
		$this->db->where('employee_id', $id);
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */
	public function get_employee_increment_data($id,$status=''){
		$query = $this->db->table('employee_increment')
				->select('*')
				->where('employee_id', $id);
		if($status != ''){
			$query->where('status',$status);
		}
		$query = $query->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_employee_increment($status,$id=''){
		$query = $this->db->table('employee_increment')
				->select('*')
				->where('status',$status);
		if(!empty($id)){
			$query->where('employee_id',$id);
		}
		$query = $query->orderBy('increment_date','asc')->get();
		$row = $query->getResult();
		return $row;
	} 
	public function get_increment_row($id){
		$query = $this->db->table('employee_increment')
				->select('*')
				->where('id', $id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	/* public function get_increment_pending($id){
		$this->db->select('*');
		$this->db->table('employee_increment');
		$this->db->where('employee_id', $id);
		$this->db->where('status','pending');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */	
}
?>