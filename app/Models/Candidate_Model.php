<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Candidate_Model extends Model {
	function __construct() { 
	 parent::__construct(); 
	} 
	
	public function insert_hrround_detail($data) {
		$insert = $this->db->table("interview_schedule")->insert($data);
		if($insert){ 
			return $this->db->insertID(); 
		} 
	}
	public function insert_candidate($data) {
		$insert = $this->db->table("candidates")->insert($data);
		if($insert){ 
			return $this->db->insertID(); 
		} 
	}
	public function update_hrround_detail($data) {
		$this->db->table('interview_schedule')
				->where('candidate_id', $data['candidate_id'])
				->where('id', $data['id'])
				->update($data);
		return true;
	}
	public function update_candidate($data) {
		$this->db->table('candidates')->where('id', $data['id'])->update($data);
		return true;
	}
	public function delete_candidate($id) {
		$this->db->table('candidates')->where('id', $id)->delete();
		return true;
	}
	/* public function delete_schedule($id,$candidate_id) {
		$this->db->where('id', $id);
		$this->db->where('candidate_id', $candidate_id);
		$this->db->delete('interview_schedule');
		return true;
	} */
	public function delete_schedule($id) {
		$this->db->table('interview_schedule')->where('candidate_id', $id)->delete();
		return true;
	}
	public function get_candidates($id){
		$query = $this->db->table('candidates')
				->select('*')
				->where('id', $id)
				->limit(1)
				->get();
		$row = $query->getResult();
		return $row;
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
		$this->db->table('interview_schedule')
				->where('id', $data['id'])
				->update($data);
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
				->orderBy('interview_schedule.interview_date','asc')
				->get();
		$row = $query->getResult();
		
		return $row;
	}
	function allposts_count($designation,$schedule_type,$interviewDate)
    {  
		// interview_status
		$query = $this->db->table('candidates')
					->select('candidates.*,interview_schedule.candidate_id, interview_schedule.interview_date, interview_schedule.interview_status as interview_schedule_status,interview_schedule.status')
					->join('interview_schedule', 'interview_schedule.candidate_id = candidates.id','left');
		if($designation != 'all_designation'){
			$query = $query->where('candidates.designation',$designation);
		}
		if($schedule_type != 'all_candidate'){
			$query = $query->where('candidates.interview_status',$schedule_type);
		}
		if(!empty($interviewDate)){
			$query = $query->where('interview_schedule.interview_date',$interviewDate);
		}
		$query = $query->get();
		return $query->getNumRows();
    }
    
    function allposts($designation,$schedule_type,$interviewDate,$limit,$start,$col,$dir)
    {   
		$query = $this->db->table('candidates')
					->select('candidates.*,interview_schedule.candidate_id, interview_schedule.interview_date, interview_schedule.interview_status as interview_schedule_status,interview_schedule.status')
					->join('interview_schedule', 'interview_schedule.candidate_id = candidates.id','left');
		if($designation != 'all_designation'){
			$query->where('candidates.designation',$designation);
		}
		if($schedule_type != 'all_candidate'){
			$query->where('candidates.interview_status',$schedule_type);
		}
		if(!empty($interviewDate)){
			$query->where('interview_schedule.interview_date',$interviewDate);
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
   
    function posts_search($designation,$schedule_type,$interviewDate,$limit,$start,$search,$col,$dir)
    {
		$query = $this->db->table('candidates')
					->select('candidates.*,interview_schedule.candidate_id, interview_schedule.interview_date, interview_schedule.interview_status as interview_schedule_status,interview_schedule.status')
					->join('interview_schedule', 'interview_schedule.candidate_id = candidates.id','left');
       	if($designation != 'all_designation'){
		   $query->where('candidates.designation',$designation);
		}
		if($schedule_type != 'all_candidate'){
			$query->where('candidates.interview_status',$schedule_type);
		}
		if(!empty($interviewDate)){
			$query->where('interview_schedule.interview_date',$interviewDate);
		}
		$query->like('candidates.designation',$search);
		$query->orLike('candidates.name',$search);
		$query->orLike('candidates.location',$search);
		$query->orLike('candidates.skills',$search);
		$query->orLike('candidates.phone_number',$search);
		$query->orLike('candidates.email',$search);
		$query->orLike('interview_schedule.interview_date',$search);
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
    function posts_search_count($id,$schedule_type,$interviewDate,$search)
    {
        /* if($designation != 'all_designation'){
		  	$this->db->where('designation',$designation);
		} */
		$query = $this->db->table('candidates')
				->select('candidates.*,interview_schedule.candidate_id, interview_schedule.interview_date, interview_schedule.interview_status as interview_schedule_status,interview_schedule.status')
				->join('interview_schedule', 'interview_schedule.candidate_id = candidates.id','left')
				->like('candidates.designation',$search)
				->orLike('candidates.name',$search)
				->orLike('candidates.location',$search)
				->orLike('candidates.skills',$search)
				->orLike('candidates.phone_number',$search)
				->orLike('candidates.email',$search)
				->orLike('interview_schedule.interview_date',$search)
			 	->get();
		return $query->getNumRows();
    }
	
	
}
?>