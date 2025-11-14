<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Mail_Content_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	public function insert_content($data) {
     	if ($this->db->table("mail_content")->insert($data)) { 
			return true; 
		} 
	}
	public function update_content($data) {
		$this->db->table('mail_content')->where('id', $data['id'])->update($data);
		return true;
	}
	public function delete_content($id,$emp_id) {
		$this->db->table('mail_content')->where('id', $id)->where('emp_id', $emp_id)->delete();
		return true;
	}
	public function get_mail_content($id){
		$query = $this->db->table('mail_content')
				->select('*')
				->where('id', $id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function mail_content_by_slug($slug){
		$query = $this->db->table('mail_content')
				->select('*')
				->where('slug', $slug)
		 		->get();
		$row = $query->getResult();
		return $row;
	}
	public function delete_mail_content($id) {
		$delete = $this->db->table('mail_content')->where('id', $id)->delete();
		if($delete){
			return true;
		}else{
			return false;
		}
	}

	public function all_mail_content(){
		$query = $this->db->table('mail_content')
				->select('*')
		 		->get();
		$row = $query->getResult();
		return $row;
	}
    
    function allposts_count()
    {  
        $query = $this->db->table('mail_content')
        		->select('*')
		 		->get();
		return $query->getNumRows();
    }
    
    function allposts($limit,$start,$col,$dir)
    {   
		
		$query = $this->db->table('mail_content')
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
   
    function posts_search($limit,$start,$search,$col,$dir)
    {
		$query = $this->db->table('mail_content')
				->like('name',$search)
				->orLike('content',$search)
				->orLike('slug',$search)
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
        $query = $this->db->table('mail_content')
        		->like('name',$search)
				->orLike('content',$search)
				->orLike('slug',$search)
				->get();
		return $query->getNumRows();
    }
	
}
?>