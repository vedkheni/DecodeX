<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Project_Task_Model extends Model {
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
	public function get_employee_task($id){
		$this->db->select('project_task.*,project.title as project_title,GROUP_CONCAT(employee.fname ORDER BY employee.id) as  developer_name');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
		$this->db->join('employee', 'FIND_IN_SET(employee.id, project_task.developer) > 0');
		$this->db->where('project_task.id', $id);
		$this->db->group_by('project_task.id'); 
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	}
	public function get_employee($id){
		$this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
		$this->db->where('project_task.id', $id);
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	}
	public function get_project_details($id){
		$this->db->select('*');
		$this->db->from('project');
		$this->db->where('id', $id); 
		$query = $this->db->get();
		$row = $query->result();
		return $row;
	}
	public function get_project_task(){
		$this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
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
    	//$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%'  ORDER BY `project_task`.".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
        $this->db->select('project_task.*,project.title as project_title');
		$this->db->from('project_task');
		$this->db->join('project', 'project_task.project_id = project.id');
		$this->db->like('project_task.title', $search);
		$this->db->or_like('project_task.description', $search);
		$this->db->like('project.title', $search);
		$this->db->limit($limit,$start);
		$this->db->order_by('project_task.'.$col,$dir);
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
    function posts_search_count($search)
    {
  		//$query=$this->db->query("SELECT `project_task`.*,`project`.`title` as `project_title` FROM `project_task` join `project` on `project_task`.`project_id` = `project`.`id` WHERE `project_task`.title LIKE '%".$search."%' OR `project_task`.description LIKE '%".$search."%' OR `project`.title LIKE '%".$search."%' ");
		  $this->db->select('project_task.*,project.title as project_title');
		  $this->db->from('project_task');
		  $this->db->join('project', 'project_task.project_id = project.id');
		  $this->db->like('project_task.title', $search);
		  $this->db->or_like('project_task.description', $search);
		  $this->db->like('project.title', $search);
		  $query = $this->db->get();
		return $query->num_rows();
    }
}
?>