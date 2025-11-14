<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Issues_Task_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	public function insert_employee($data) {
     	if ($this->db->insert("project_task", $data)) { 
			return true; 
		} 
	}
	public function update_employee($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('project_task', $data);
		return true;
	}
	public function delete_employee($id) {
		$this->db->where('id', $id);
		$this->db->delete('project_task');
		return true;
	}
	public function get_employee($id){
		$this->db->select('*');
		$this->db->from('project_task');
		$this->db->where('id', $id);
		$this->db->limit(1);
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	}
	public function get_designation(){
		$this->db->select('*');
		$this->db->from('project_task');
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	}
	function allposts_count()
    {  
		$query = $this->db->get('project_task');
		return $query->num_rows();  
    }
    
    function allposts($limit,$start,$col,$dir)
    {   
    	$this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
		$this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);
		$query = $this->db->get();

		if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search($limit,$start,$search,$col,$dir)
    {
    	$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%'  ORDER BY `project_task`.".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function posts_search_count($search)
    {
  		$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%' ");
		return $query->num_rows();
    }

    // =-----------
    function allposts_count_pending()
    {  
    	$this->db->select('*');
		$this->db->from('project_task');
		$this->db->where('status', 'pending');
		$query = $this->db->get();
		return $query->num_rows();  
    }
    
    function allposts_pending($limit,$start,$col,$dir)
    {   
    	$this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
		$this->db->where('status', 'pending');
		$this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);
		$query = $this->db->get();

		if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search_pending($limit,$start,$search,$col,$dir)
    {
    	//$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%' and `project_task`.`status` ='pending' ORDER BY `project_task`.".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");

        $this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
        $this->db->where('project_task.status', 'pending');
		$this->db->like('project_task.title',$search);
		$this->db->or_like('project_task.description',$search);
		$this->db->or_like('project.title',$search);
        $this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);
        $query = $this->db->get();

        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function posts_search_count_pending($search)
    {
  		//$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%' and `project_task`.`status` ='pending'");
        $this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
		$this->db->like('project_task.title',$search);
        $this->db->where('project_task.status', 'pending');
		$this->db->or_like('project_task.description',$search);
		$this->db->or_like('project.title',$search);
        $query= $this->db->get();
		return $query->num_rows();
    }

//  ========================
function allposts_count_in_progress()
    {  
    	$this->db->select('*');
		$this->db->from('project_task');
		$this->db->where('status', 'in development');
		$query = $this->db->get();
		return $query->num_rows();  
    }
    
    function allposts_in_progress($limit,$start,$col,$dir)
    {   
    	$this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
		$this->db->where('status', 'in development');
		$this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);
		$query = $this->db->get();

		if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search_in_progress($limit,$start,$search,$col,$dir)
    {
    	//$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%' and `project_task`.`status` ='in development' ORDER BY `project_task`.".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
        
        $this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
        $this->db->where('project_task.status', 'in development');
		$this->db->like('project_task.title',$search);
		$this->db->or_like('project_task.description',$search);
		$this->db->or_like('project.title',$search);
        $this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);
        $query = $this->db->get();

        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function posts_search_count_in_progress($search)
    {
  		//$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%' and `project_task`.`status` ='in development'");
        
        $this->db->select('project_task.*,project.title as project_title');
        $this->db->from('project_task');
        $this->db->join('project', 'project_task.project_id = project.id');
        $this->db->where('project_task.status', 'in development');
        $this->db->like('project_task.title',$search);
        $this->db->or_like('project_task.description',$search);
        $this->db->or_like('project.title',$search);
        $query = $this->db->get();

          return $query->num_rows();
    }
 
// ===============
function allposts_count_completed()
    {  
    	$this->db->select('*');
		$this->db->from('project_task');
		$this->db->where('status', 'complete');
		$query = $this->db->get();
		return $query->num_rows();  
    }
    
    function allposts_completed($limit,$start,$col,$dir)
    {   
    	$this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
		$this->db->where('status', 'complete');
		$this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);
		$query = $this->db->get();

		if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function posts_search_completed($limit,$start,$search,$col,$dir)
    {
    	//$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%' and `project_task`.`status` ='complete' ORDER BY `project_task`.".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
        $this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
        $this->db->where('project_task.status', 'complete');
		$this->db->like('project_task.title',$search);
		$this->db->or_like('project_task.description',$search);
		$this->db->or_like('project.title',$search);
        $this->db->limit($limit,$start);
		$this->db->order_by($col,$dir);
        $query = $this->db->get();
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function posts_search_count_completed($search)
    {
  		//$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%' and `project_task`.`status` ='complete'");
          $this->db->select('project_task.*,project.title as project_title');
          $this->db->from('project_task');
          $this->db->join('project', 'project_task.project_id = project.id');
          $this->db->where('project_task.status', 'complete');
          $this->db->like('project_task.title',$search);
          $this->db->or_like('project_task.description',$search);
          $this->db->or_like('project.title',$search);
          $query = $this->db->get();
          return $query->num_rows();
    }
}
?>