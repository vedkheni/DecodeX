<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Team_Condition_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	public function insert_employee($data) {
     	if ($this->db->table("team_and_condition")->insert($data)) { 
			return true; 
		} 
	}
	public function update_employee($data) {
		$this->db->table('team_and_condition')->where('id', $data['id'])->update($data);
		return true;
	}
	public function delete_employee($id,$emp_id) {
		$this->db->table('team_and_condition')
				->where('id', $id)
				->where('emp_id', $emp_id)
				->delete();
		return true;
	}
	public function get_team_and_condition($id){
		$query = $this->db->table('team_and_condition')
				->select('*')
				->where('id', $id)
				->limit(0,1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	
	
}
?>