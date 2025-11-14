<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Holiday_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	public function insert_employee($data) {
     	if ($this->db->table("holiday")->insert($data)) { 
			return $this->db->insertID(); 
		} 
	}
	public function get_exists_holiday_date_page($holiday_date) {
		$holiday_date_1=implode(',',$holiday_date);
		// $query=$this->db->query("SELECT COUNT(*) AS `numrows` FROM `holiday` WHERE `holiday_date` IN(".$holiday_date_1.")");
		$query = $this->db->table("holiday")
				->select("count(*) as numrows")
				->whereIn("holiday_date",$holiday_date_1)
				->get();
		$num_rows = $query->getResultArray();
		return $num_rows;
	}
	public function get_exists_holiday_date_page1($holiday_date) {
		$holiday_date_1=implode(',',$holiday_date);$num=0;
		foreach ($holiday_date as $key => $value) {
			//$query=$this->db->query("SELECT * FROM `holiday` WHERE DATE(`holiday_date`)='".$value."'");
			$query = $this->db->table("holiday")
					->select("*")
					->where("date(holiday_date)",Format_date($value))
					->get();
			if($query->getNumRows() > 0){$num++;}
		}
		return $num;
	}
	public function get_exists_holiday_date($holiday_date) {
		//$query=$this->db->query("SELECT COUNT(*) AS `numrows` FROM `holiday` WHERE `holiday_date` IN(".$holiday_date.")");
		$query = $this->db->table("holiday")
				->select("count(*) as numrows")
				->whereIn("holiday_date",Format_date($holiday_date))
		 		->get();
		$num_rows = $query->getResultArray();
		return $num_rows;
	}
	public function get_holidayByDate($holiday_date) {
		//$query=$this->db->query("SELECT COUNT(*) AS `numrows` FROM `holiday` WHERE `holiday_date` IN(".$holiday_date.")");
		$query = $this->db->table("holiday")
				->select("*")
				->where("holiday_date",Format_date($holiday_date))
		 		->get();
		return $query->getResult();
	}
	public function get_exists_holiday_date_formate($holiday_date) {
		//$query=$this->db->query("SELECT COUNT(*) AS `numrows` FROM `holiday` WHERE DATE(`holiday_date`)='".$holiday_date."'");
		$query = $this->db->table("holiday")
				->select("count(*) as numrows")
				->where("date(holiday_date)",Format_date($holiday_date))
				->get();
		$num_rows = $query->getResultArray();
		return $num_rows;
	}
	public function get_exists_holiday_date_leave($holiday_date) {
		// $explode=explode(' , ',$holiday_date);
		// $result = implode ( "', '", $explode );
		$result=explode(' , ',$holiday_date);
		//$query=$this->db->query("SELECT COUNT(*) AS `numrows` FROM `holiday` WHERE `holiday_date` IN(".$result.")");
		$query = $this->db->table("holiday")
				->select("count(*) as numrows")
				// ->whereIn("holiday_date",Format_date($result))
				->whereIn("holiday_date",($result))
				->get();
		$num_rows = $query->getResultArray();
		return $num_rows;
	}
	public function get_exists_holiday_date_row($holiday_date) {
		$explode=explode(' , ',$holiday_date);
		$result = $explode;
        //$result = implode ( "', '", $explode );
		//$query=$this->db->query("SELECT * FROM `holiday` WHERE `holiday_date` IN(".$result.")");
		$query = $this->db->table("holiday")
				->select("*")
				// ->whereIn("holiday_date",[Format_date($result)])
				->whereIn("holiday_date",$result)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function update_holiday($data) {
		$this->db->table('holiday')->where('id', $data['id'])->update($data);
		return true;
	}
	/* public function update_employee($data,$id) {
		$this->db->where('id', $id);
		$this->db->update('holiday', $data);
		return true;
	} */
	/* public function delete_employee($id) {
		$this->db->where('id', $id);
		$this->db->delete('holiday');
		return true;
	} */
	public function delete_holiday($id) {
		$this->db->table('holiday')->where('id', $id)->delete();
		return true;
	}
	public function get_employee($id){
		$query = $this->db->table('holiday')
				->select('*')
				->where('id', $id)
				->limit(0,1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_holiday($year){
		$query = $this->db->table('holiday')
				->select('*')
				->where('YEAR(`holiday_date`)', $year)
		 		->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_holiday_all(){
		$query =$this->db->table('holiday')
				->select('*')
		 		->get();
		$row = $query->getResult();
		return $row;
	}

	function allposts_count1($year)
    {
		$query = $this->db->table('holiday')->where('YEAR(`holiday_date`)',$year)->get();
		return $query->getNumRows();  
	}

	function allposts1($year,$limit,$start,$col,$dir)
    {   
     	$query = $this->db->table('holiday')->where('YEAR(`holiday_date`)',$year)->limit($limit,$start)->orderBy($col,$dir)->get();
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
        
    }

	function posts_search1($year,$limit,$start,$search,$col,$dir)
    {
       	//$query=$this->db->query("SELECT * FROM holiday WHERE YEAR(`holiday_date`) = ".$year." name LIKE '%".$search."%' ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
		$query = $this->db->table('holiday')
				->select('*')
				->where('YEAR(`holiday_date`)', $year)
				->like('title', $search)
				->orderBy($col, $dir)
				->limit($limit, $start)
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
    function posts_search_count1($year,$search)
    {
  		//$query=$this->db->query("SELECT * FROM holiday WHERE YEAR(`holiday_date`) = ".$year." name LIKE '%".$search."%'");
		  $query = $this->db->table('holiday')
				->select('*')
				->where('YEAR(`holiday_date`)', $year)
				->like('title', $search)
				->get();
		return $query->getNumRows();
    }

	function allposts_count()
    {  
		$query = $this->db->table('holiday')->get();
		return $query->getNumRows();  
    }
    
    function allposts($limit,$start,$col,$dir)
    {   
     	$query = $this->db->table('holiday')->limit($limit,$start)->orderBy($col,$dir)->get();
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search($limit,$start,$search,$col,$dir)
    {
       	//$query=$this->db->query("SELECT * FROM holiday WHERE name LIKE '%".$search."%' ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
		   $query = $this->db->table('holiday')
				->select('*')
				->like('title', $search)
				->orderBy($col, $dir)
				->limit($limit, $start)
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
    function posts_search_count($search)
    {
  		//$query=$this->db->query("SELECT * FROM holiday WHERE name LIKE '%".$search."%'");
		  $query =$this->db->table('holiday')
		  		->select('*')
		  		->like('title', $search)
		   		->get();
		return $query->getNumRows();
    }
	function get_official_holidays($month,$year)
    {
  		//$query=$this->db->query("SELECT COUNT(id) as `no_of_holidays` FROM `holiday` WHERE YEAR(holiday_date)='$year' AND MONTH(holiday_date)=$month");
		$query = $this->db->table('holiday')
				->select('COUNT(id) as no_of_holidays')
				->where('YEAR(`holiday_date`)', $year)
				->where('MONTH(holiday_date)', $month)
				->get();
		//echo "SELECT COUNT(id) as `no_of_holidays` FROM `holiday` WHERE YEAR(holiday_date)='$year' AND MONTH(holiday_date)=$month";
		//die;
		return $query->getResult();
    }
	function getOfficialHolidays($month,$year)
    {
  		//$query=$this->db->query("SELECT COUNT(id) as `no_of_holidays` FROM `holiday` WHERE YEAR(holiday_date)='$year' AND MONTH(holiday_date)=$month");
		$query = $this->db->table('holiday')
				->select('*')
				->where('YEAR(`holiday_date`)', $year)
				->where('MONTH(holiday_date)', $month)
				->get();
		//echo "SELECT COUNT(id) as `no_of_holidays` FROM `holiday` WHERE YEAR(holiday_date)='$year' AND MONTH(holiday_date)=$month";
		//die;
		return $query->getResult();
    }
}
?>