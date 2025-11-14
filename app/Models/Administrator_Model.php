<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Administrator_Model extends Model {
	function __construct() { 
		parent::__construct(); 
	}

	public function login($data) {
		$where = '(email="'.$data['email'].'" or username="'.$data['email'].'")';
		$query= $this->db->table('user')
			->where($where)
			->where('password="'.$data['password'].'"')
			->get();
		return $query;
	}
	
	public function admin_profile($id){
		$query = $this->db->table('user')
				->select('*')
				->where('id', $id)
				->get();
		$row = $query->getResult();
		return $row;
	}

	public function admin_settings(){
		$query = $this->db->table('settings')
				->select('*')
				->orderBy('id','desc')
				->get();
		$row = $query->getRow();
		return $row;
	}

	/* public function update_admin($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('user', $data);
		return true;
	} */
	
	public function update_user($data) {
		$query = $this->db->table('user')
				->where('id', $data['id']);
		if($query->update($data)){
			return true;
		}else{
			return false;
		}
	}
     
}
