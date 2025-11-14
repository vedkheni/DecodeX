<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Designation_Model extends Model {
	/* function __construct() { 
	 parent::__construct(); 
	} */ 
	
	public function insertDesignation($data) {
     	if ($this->db->table('designation')->insert($data)) { 
			return true; 
		} 
	}
	public function updateDesignation($data) {
		$this->db->table('designation')
		->where('id', $data['id'])
		->update($data);
		return true;
	}
	public function deleteDesignation($id) {
		$this->db->table('designation')
				->where('id', $id)
				->delete();
		return true;
	}
	public function getDesignation_byId($id){
		$query = $this->db->table('designation')
				->select('*')
				->where('id', $id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_designation(){
		$query = $this->db->table('designation')
				->select('*')
				->get();
		$row = $query->getResult();
		return $row;
	}
	function allposts_count()
    {  
		$query = $this->db->table('designation')->get();
		return $query->getNumRows();  
    }
    
    function allposts($limit,$start,$col,$dir)
    {   
     	$query = $this->db->table('designation')->limit($limit,$start)->orderBy($col,$dir)->get();
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
       	//$query=$this->db->query("SELECT * FROM designation WHERE name LIKE '%".$search."%' ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
		$query = $this->db->table('designation')
				->select('*') 
				->like('name',$search)
				->limit($limit,$start)
				->orderBy($col,$dir)
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
  		$query=$this->db->query("SELECT * FROM designation WHERE name LIKE '%".$search."%'");
		$query = $this->db->table('designation')
				->select('*')
				->like('name',$search)
				->get();
		return $query->getNumRows();
    }
}
?>