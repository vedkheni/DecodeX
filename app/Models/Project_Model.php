<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Project_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	public function insert_employee($data) {
     	if ($this->db->insert("project", $data)) { 
			return true; 
		} 
	}
	public function update_employee($data) {
		$this->db->table('project')->where('id', $data['id'])->update( $data);
		return true;
	}
	public function delete_employee($id) {
		$this->db->table('project')->where('id', $id)->delete();
		return true;
	}
	public function get_employee($id){
		$query = $this->db->table('project')
				->select('*')
				->where('id', $id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_project(){
		$query = $this->db->table('project')
				->select('*')
				->get();
		$row = $query->getResult();
		return $row;
	}
	function allposts_count()
    {  
		$query = $this->db->table('project')->get();
		return $query->getNumRows();  
    }
    
    function allposts($limit,$start,$col,$dir)
    {   
     	$query = $this->db->table('project')->limit($limit,$start)->orderBy($col,$dir)->get();
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
       	//$query=$this->db->query("SELECT * FROM project WHERE title LIKE '%".$search."%' OR client_name LIKE '%".$search."%' ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
		   $query = $this->db->table('project')
				->select('*')
				->like('title', $search)
				->orLike('client_name', $search)
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
  		//$query=$this->db->query("SELECT * FROM project WHERE title LIKE '%".$search."%' OR title LIKE '%".$search."%'");
		  $query = $this->db->table('project')
				->select('*')
				->like('title', $search)
				->orLike('client_name', $search)
				->get();
		return $query->getNumRows();
    }
}
?>