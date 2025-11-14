<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Internship_Model extends Model {
	function __construct() { 
	    parent::__construct(); 
	} 

    public function insert_intern($data) {
        $insert = $this->db->table('internship')->insert($data);
       if ($insert) { 
           $insert_id = $this->db->insertID();
           return  $insert_id;
       }
   }
	
	public function update_intern($data) {
		$this->db->table('internship')->where('id', $data['id'])->update($data);
		return true;
	}

    function get_intern($id)
    {  
		$query = $this->db->table('internship')->where('id',$id)->get();
		return $query->getResult();  
    }

	function allposts_count()
    {  
		$query = $this->db->table('internship')->get();
		return $query->getNumRows();  
    }
    
    function allposts($limit,$start,$col,$dir)
    {   
     	$query = $this->db->table('internship')->limit($limit,$start)->orderBy($col,$dir)->get();
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
        $query = $this->db->table('internship')->like('name',$search)->orLike('contact_number',$search)->orLike('email',$search)->orLike('address',$search)->orLike('college_or_university',$search)->orLike('course',$search)->orLike('feedback',$search)->limit($limit,$start)->orderBy($col,$dir)->get();
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
  		$query = $this->db->table('internship')
				->select('*')
				->like('name',$search)
                ->orLike('contact_number',$search)
                ->orLike('email',$search)
                ->orLike('address',$search)
                ->orLike('college_or_university',$search)
                ->orLike('course',$search)
                ->orLike('feedback',$search)
		 		->get();
		return $query->getNumRows();
    }
}
?>