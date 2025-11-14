<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Salary_Pay_Model extends Model {
	function __construct() { 
		parent::__construct(); 
	} 
	function insert_data($arr){
		$salary=$this->db->table('salary_pay')->insert($arr);
		if($salary){
			return true;
		}else{
			return false;
		}
	}
	public function update_data($data) {
		$this->db->table('salary_pay')->where('id', $data['id'])->update($data);
		return true;
	}
	
	public function update_deposit($data) {
		$this->db->table('deposit')->where('id', $data['id'])->update($data);
		return true;
	}
	public function update_employee_paid_leaves($data) {
		$this->db->table('employee_paid_leaves')
		->where('id', $data['id'])
		->where('employee_id', $data['employee_id'])
		->update($data);
		return true;
	}
	
	public function getWorkingDays($data) {
		$query = $this->db->table('working_days')->select('*');
		if(isset($data['month']) && !empty($data['month'])){
			$query = $query->where('month',$data['month']);
		}
		if(isset($data['year']) && !empty($data['year'])){
			$query = $query->where('year',$data['year']);
		}
		if(isset($data['working_days']) && !empty($data['working_days'])){
			$query = $query->where('working_days',$data['working_days']);
		}
		if(isset($data['official_holidays']) && !empty($data['official_holidays'])){
			$query = $query->where('official_holidays',$data['official_holidays']);
		}
		$query = $query->get()->getResult();
		return $query;
	}



	public function create_table() {

		/* echo $this->db->simpleQuery("CREATE TABLE working_days ( id INT NOT NULL AUTO_INCREMENT , month INT(2) NOT NULL , year INT(4) NOT NULL , working_days INT(2) NOT NULL , official_holidays INT(2) NOT NULL , created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , updated_date DATETIME NOT NULL , PRIMARY KEY (id)) ENGINE = InnoDB;");exit;
		$res = $this->db->table('salary_pay')->select('year,month,working_day,official_holiday',)->get()->getResult();
		foreach($res as $v){
			$res = $this->db->table('working_days')->select('*')->where('month',$v->month)->where('year',$v->year)->get()->getResult();
			if(empty($res)){
				echo $this->db->simpleQuery("INSERT INTO `working_days` (`month`, `year`, `working_days`, `official_holidays`) VALUES ('".$v->month."', '".$v->year."', '".$v->working_day."', '".$v->official_holiday."')");
				echo "<br>";
			}
		}
		$select="SELECT * FROM `working_days`";
		$res=$this->db->query($select)->result_array();
		echo '<pre>'; print_r( $res ); echo '</pre>';exit; */
		
	}
	
}
?>