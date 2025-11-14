<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Login_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	 public function login($data) {
		 $query=$this->db->table('employee');
		 if (strpos($data['email'], 'GEEK_') !== false) {
			$GEEK_ID=str_replace('GEEK_', '', $data['email']);
			$where = '(email="'.$data['email'].'" or id="'.$GEEK_ID.'")';
			$query->where($where);	
		}else{
			$credential='"gmail_account":"'.$data['email'].'"';
			$query->like('credential', $credential);
			//$this->db->where('credential="'.$data['email'].'"');
		}
		$query=$query->where('password="'.$data['password'].'"');
		return $query->get();
		
      }
       public function attempt_insert($data) {
		   $this->db->table('ip_block_logs')->insert($data);
	   }
       public function logsInsert($arr) {
		   $this->db->table('login_logs')->insert($arr);
	   }
	   public function attempt_delete($ip) {
		  $this->db->table('ip_block_logs')->where('ip', $ip)->delete();
		 return true;
	   }
	   public function attempt_update($data,$id) {
			$this->db->table('ip_block_logs')->where('id', $id)->update($data);
			return true;
	   }
	    public function attempt_check($ip) {
		  
			$query = $this->db->table('ip_block_logs')
					->select('*')
			 		->where('ip="'.$ip.'"')
			 		->get();
			 $row = $query->getRow();
			 return $row;
		
	   }
	    public function login_status($data) {
		
		$query = $this->db->table('employee');
		if (strpos($data['email'], 'GEEK_') !== false) {
			$GEEK_ID=str_replace('GEEK_', '', $data['email']);
			$where = '(email="'.$data['email'].'" or id="'.$GEEK_ID.'")';
			$query->where($where);	
		}else{
			$credential='"gmail_account":"'.$data['email'].'"';
			$query->like('credential', $credential);
			//$this->db->where('email="'.$data['email'].'"');
		}
		$query->where('password="'.$data['password'].'"')->where('status="1"');
		return $query->get();
		
      }
}
?>