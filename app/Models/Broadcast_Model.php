<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Broadcast_Model extends Model {
	function __construct() { 
	 	parent::__construct(); 
	} 
	
	public function insertMessage($data) {
		$arr = $this->db->getFieldData('broadcast');
     	if ($this->db->table("broadcast")->insert($data)) { 
			return true; 
		} 
	}

	public function updateMessage($data) {
		$this->db->table('broadcast')->where('id', $data['id'])->update($data);
		return true;
	}

	public function delete_content($id,$emp_id) {
		$this->db->table('broadcast')->where('id', $id)->where('emp_id', $emp_id)->delete();
		return true;
	}

	public function getBroadcastMessage($id){
		$query = $this->db->table('broadcast')->select('*')->where('id', $id)->limit(1)->get();
		$row = $query->getResult();
		return $row;
	}

	/* public function mail_content_by_slug($slug){
		$query = $this->db->table('broadcast')->select('*')->where('slug', $slug)->get();
		$row = $query->getResult();
		return $row;
	} */

	public function deleteBroadcastMessage($id) {
		$delete = $this->db->table('broadcast')->where('id', $id)->delete();
		if($delete){
			return true;
		}else{
			return false;
		}
	}

	public function allBroadcastMassage(){
		$query = $this->db->table('broadcast')->select('*')->get();
		$row = $query->getResult();
		return $row;
	}
    
    function allposts_count()
    {  
        $query = $this->db->table('broadcast')->select('*')->get();
		return $query->getNumRows();
    }
    
    function allposts($limit,$start,$col,$dir)
    {   
		$query = $this->db->table('broadcast')->limit($limit,$start)->orderBy($col,$dir)->get();
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
		$query = $this->db->table('broadcast')
				->like('title',$search)
				->orLike('message',$search)
				->orLike('expiry_date',$search)
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
        $query = $this->db->table('broadcast')
        		->like('title',$search)
				->orLike('message',$search)
				->orLike('expiry_date',$search)
				->get();
		return $query->getNumRows();
    }
	
}
