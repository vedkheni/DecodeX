<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Pc_Issue_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	public function insert_pcid($data) {
		if($this->db->table("pc_connection")->insert($data)){ 
			return true; 
		} 
	}
	public function update_pcid($data) {
		$this->db->table('pc_connection')->where('id', $data['id'])->update($data);
		return true;
	}
	public function delete_pcIssue($id) {
		$delete = $this->db->table('pc_issue')->where('id', $id)->delete();
		if($delete){
			return true;
		}else{
			return false;
		}
	}
	public function getPc_id($emp_id){
		$query =$this->db->table('pc_connection')
				->select('*')
				->where('employee_id', $emp_id)
				->get();
		$row = $query->getResult();
		return $row;
	}
    public function insert_pcIssue($data) {
		if($this->db->table("pc_issue")->insert( $data)){ 
			return true; 
		} 
	}
	public function update_pcIssue($data) {
		$this->db->table('pc_issue')->where('id', $data['id'])->update( $data);
		return true;
	}
	public function get_pcIssue_all($status=''){
		$query = $this->db->table('pc_issue')
				->select('*');
		if($status != ''){
			$query->where('status', $status);
		}
		$query = $query->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_pcIssue($id){
		$query = $this->db->table('pc_issue')
				->select('*')
				->where('id',$id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	function allposts_count($id='')
    {  
		$this->session = \Config\Services::session();
		if($this->session->get('user_role') != 'admin'){
			$query = $this->db->table('pc_issue')->where('employee_id',$id)->get();
		}else{
			$query = $this->db->table('pc_issue')->get();
		}
		return $query->getNumRows();
    }
    function allposts($id='',$limit,$start,$col,$dir)
    {    
		$this->session = \Config\Services::session();
		$query = $this->db->table('pc_issue');
		if($this->session->get('user_role') != 'admin'){
			$query->where('employee_id',$id);
		}
		$query->limit($limit,$start);
		$query->orderBy($col,$dir);
		$query = $query->get();
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
        
    }
    function posts_search($id='',$limit,$start,$search,$col,$dir)
    {
		$this->session = \Config\Services::session();
		$query = $this->db->table('pc_issue')->select('*');
		if($this->session->get('user_role') != 'admin'){
			$query->where('employee_id',$id);
		}
		$query = $query->like('issue',$search)
			->orLike('hardware_part',$search)
			->orLike('description',$search)
			->orLike('status',$search)
			->orLike('pc_id',$search)
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
    function posts_search_count($id='',$search)
    {
		$this->session = \Config\Services::session();
		$query = $this->db->table('pc_issue')->select('*');
        if($this->session->get('user_role') != 'admin'){
			$query->where('employee_id',$id);
		}
		$query = $query->like('issue',$search)
				->orLike('hardware_part',$search)
				->orLike('description',$search)
				->orLike('status',$search)
				->orLike('pc_id',$search)
				->get();
		return $query->getNumRows();
    }

    
	
    public function interview_schedule($candidate_id){
		$query = $this->db->table('interview_schedule')
				->select('*')
				->where('candidate_id', $candidate_id)
		 		->get();
		$row = $query->getResult();
		return $row;
	}
	public function interview_schedule_by_id($id){
		$query = $this->db->table('interview_schedule')
				->select('*')
				->where('id', $id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function mail_send_status($data){
		$this->db->table('interview_schedule')->where('id', $data['id'])->update($data);
		return true;
	}
	public function get_exxel_data($designation){
		$query = $this->db->table('candidates')
				->select('*')
				->join('interview_schedule', 'candidates.id = interview_schedule.candidate_id','right');
		if($designation != 'all_designation'){
			$query->where('candidates.designation', $designation);
		}
		$query = $query->get();
		$row = $query->getResult();
		return $row;
	}
	public function candidates_by_designation($designation){
		$query = $this->db->table('candidates')
				->select('*');
		if($designation != 'all_designation'){
			$query->where('designation', $designation);
		}
		$query = $query->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_candidates_all(){
		$query = $this->db->table('candidates')
				->select('*')
				->get();
		$row = $query->getResult();
		return $row;
	}
	public function get_interview_schedule(){
		$start_date=date("Y-m-d");
    	$end_date=date("Y-m-d",strtotime('+7 day'));
		$query = $this->db->table('candidates')
				->select('*')
				->join('interview_schedule', 'candidates.id = interview_schedule.candidate_id','right')
				->where('interview_schedule.interview_date >=', $start_date)
				->where('interview_schedule.interview_date <=', $end_date)
				->get();
		$row = $query->getResult();
		
		return $row;
	}
	
}
?>