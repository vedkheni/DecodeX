<?php 
namespace App\Models; 
use CodeIgniter\Model;

 class Employee_Model extends Model {
	function __construct() { 
		parent::__construct(); 
		$this->session = \Config\Services::session();
	} 
	public function login($data) {
		$query = $this->db->table('employee')
				->where('password="'.$data['password'].'"')
				->where('email="'.$data['email'].'"')
				->get();
		return $query;
    }
	
	public function insert_employee($data) {
     	$insert = $this->db->table('employee')->insert($data);
		if ($insert) { 
			$insert_id = $this->db->insertID();
			return  $insert_id;
		}
	}
	
	public function get_exists_employee($email) {
		$getNumRows = $this->db->table('employee')
				->where('email',$email)->countAllResults();
		return $getNumRows;	
	}

	public function insert_emergencyContactDetail($data) {
		$insert = $this->db->table('emergency_contact')->insert($data);
		if ($insert) { 
			$insert_id = $this->db->insertID();
			return  $insert_id;
		}
	}

	public function update_emergencyContactDetail($data) {
		$this->db->table('emergency_contact')->where('id', $data['id'])->update($data);
		return true;
	}
	
	public function get_emergencyContactDetail($id) {
		$query = $this->db->table('emergency_contact')->select('*')->where('employee_id',$id)->get();
		$row = $query->getRow();
		return $row;
	}

	/* public function get_employee_details() {
		$this->db->select('*');
		$this->db->table('employee');
		$this->db->where('status','1');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */

	public function get_employee_details($id){
		$query = $this->db->table('employee')
					->select('*')
					->where('id',$id)
					->limit(0,1)
		 			->get();
		$row = $query->getRow();
		return $row;
	}

	// like $status_code = 1,0

	public function get_employee_list($status_code) {
		$query = $this->db->table('employee')
				->select('*')
				->where('status',$status_code)
				->orderBy('fname','asc')
				->get();
		$row = $query->getResult();
		return $row;
	}

	/* public function all_deactive_employee() {
		$this->db->select('*');
		$this->db->table('employee');
		$this->db->where('status','0');
		$this->db->orderBy('fname','asc');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */

	public function get_employee_list1($limit,$start,$col,$dir) {
		$query = $this->db->table('employee')
				->select('*')
				->where('status','1')
				->limit($limit,$start)
				->orderBy($col,$dir)
		 		->get();
		$row = $query->getResult();
		return $row;
	}

	public function get_employee_by_search($limit,$start,$search,$col,$dir) {
		$query = $this->db->table('employee')
				->select('*')
				->where('status','1')
				->like('fname',$search)
				->orLike('lname',$search)
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

	public function get_employee_count_by_search($search) {
		$query = $this->db->table('employee')
				->select('*')
				->where('status','1')
				->like('fname',$search)
				->orLike('lname',$search)
				->get();
        return $query->getNumRows();
	}

	public function get_employee_list_with_leave($id) {
		$month=date('m');
		$year=date('Y');
		$query = $this->db->table('employee_leave_request')
				->select('employee_id,count(leave_date) as absent_leave')
				->where('employee_id',$id)
				->where('MONTH(leave_date)',$month)
				->where('YEAR(leave_date)',$year)
				->get();
		$row = $query->getResult();
		return $row;
	}

	public function update_employee($data) {
		$this->db->table('employee')->where('id', $data['id'])->update($data);
		return true;
	}

	/* public function update_emp($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('employee', $data);
		return true;
	} */

	public function delete_employee($id) {
		$this->db->table('employee')->where('id', $id)->delete();
		return true;
	}

	/* public function get_designation(){
		$this->db->select('*');
		$this->db->table('designation');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */

	/* public function get_developer(){
		$this->db->select('*');
		$this->db->table('employee');
		$this->db->where('status','1');
		$this->db->orderBy('fname','asc');
		$query = $this->db->get();
		$row = $query->getResult();
		return $row;
	} */

	public function get_employee_exists_attendance_date($id,$date){
		$query = $this->db->table('employee_attendance')
				->select('*')
				->where('DATE(`employee_in`)',$date)
				->where('employee_id',$id)
				->get();
		$row = $query->getNumRows();
		return $row;	
	}

	public function get_employee($id){
		$query = $this->db->table('employee')
				->select('employee.*,designation.name')
				// ->orderBy('status', 'asc')
				->join('designation', 'employee.designation = designation.id')
				->where('employee.id', $id)
				->limit(0,1)
				->get();
		$row = $query->getResult();
		return $row;
	}

	public function get_total_salary_pay($month,$year){
		$query = $this->db->table('salary_pay')
				->select('sum(net_salary) as total_salary')
				->where('month', $month)
				->where('year', $year)
				->where('payment_status', "paid")
				->get();
		$row = $query->getResult();
		return $row;
	}

	public function get_employee_by_id($id){
		$query = $this->db->table('employee')
				->select('email')
				->where('employee.id', $id)
				->get();
		// $this->db->orderBy('status', 'asc')
		$row = $query->getResult();
		return $row;
	}
	
	public function get_admin($id){
		$query = $this->db->table('user')
				->select('*')
				->where('id', $id)
				->limit(0,1)
				->get();
		$row = $query->getResult();
		return $row;
	}

	// function allposts_count()

	function allemp_count()
    {  
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->get();	
		}else{
			$query = $this->db->table('employee')->where('id',$id)->limit(1)->get();
		}
		return $query->getNumRows();  
    }

    // function allposts_count1($designation,$emp_status)

    function allemp_count_with_designation($designation,$emp_status)
    {  
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		$query = $this->db->table('employee');	
		if(empty($designation) && empty($emp_status) && $user_role != "admin"){
			$query = $query->where('id',$id)->get();
		}elseif(!empty($designation) && !empty($emp_status)){
			$query = $query->where('designation',$designation)->where('status',($emp_status-1));
		}elseif(!empty($designation) && empty($emp_status)) {
			$query = $query->where('designation',$designation);
		}elseif(empty($designation) && !empty($emp_status)){
			$query = $query->where('status',($emp_status-1));
		}
		$query = $query->get();
		return $query->getNumRows();  
    }
    
    // function allposts($limit,$start,$col,$dir)

    function allEmployee($limit,$start,$col,$dir)
    {   
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->limit($limit,$start)->orderBy($col,$dir)->get();
		}else{
			$query = $this->db->table('employee')->where('id',$id)->limit($limit,$start)->orderBy($col,$dir)->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
    }

    // function allposts1($designation,$emp_status,$limit,$start,$col,$dir)

    function allemp_with_designation($designation,$emp_status,$limit,$start,$col,$dir)
    {   
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		$query = $this->db->table('employee');
		if(empty($designation) && empty($emp_status) && $user_role != "admin"){
			$query = $query->where('id',$id);
		}elseif(!empty($designation) && !empty($emp_status)){
			$query = $query->where('designation',$designation)->where('status',($emp_status-1));
		}elseif(!empty($designation) && empty($emp_status)) {
			$query = $query->where('designation',$designation);
		}elseif(empty($designation) && !empty($emp_status)){
			$query = $query->where('status',($emp_status-1));
		}
		$query = $query->limit($limit,$start)->orderBy($col,$dir)->get();
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
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			// $query=$this->db->query("SELECT * FROM employee WHERE fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%' ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')
					->select('*')
					->like('fname',$search)
					->orLike('lname',$search)
					->orLike('email',$search)
					->limit($limit,$start)
					->orderBy($col,$dir)
			 		->get();
		}else{
			//$query=$this->db->query("SELECT * FROM employee WHERE id= ".$id." and  (fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%') ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')
						->select('*')
						->where('id',$id)
						->like('fname',$search)
						->orLike('lname',$search)
						->orLike('email',$search)
						->limit($limit,$start)
						->orderBy($col,$dir)
						->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult();  
        }
        else
        {
            return null;
        }
    }

    // function posts_search1($designation,$emp_status,$limit,$start,$search,$col,$dir)

    function emp_search_with_designation($designation,$emp_status,$limit,$start,$search,$col,$dir)
    {
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		
		$query = $this->db->table('employee')->select('*');

		if($user_role != "admin"){
			$query = $query->where('id',$id);
		}
		if(!empty($designation)){
			$query = $query->where('designation',$designation);
		}
		if(!empty($emp_status)){
			$status = ($emp_status == 1)?0:1;
			$query = $query->where('status',$status);
		}
		
		$query = $query->like('fname',$search)->orLike('lname',$search)->orLike('email',$search)->limit($limit,$start)->orderBy($col,$dir)->get();

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
  		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			//$query=$this->db->query("SELECT * FROM employee WHERE fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%'");
			$query = $this->db->table('employee')
					->select('*')
					->like('fname',$search)
					->orLike('lname',$search)
					->orLike('email',$search)
					->get();
		}else{
			//$query=$this->db->query("SELECT * FROM employee WHERE id= ".$id." and (fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%')");
			$query = $this->db->table('employee')
					->select('*')
					->where('id',$id)
					->like('fname',$search)
					->orLike('lname',$search)
					->orLike('email',$search)
					->get();
		}
		return $query->getNumRows();
    }

    // function posts_search_count1($designation,$emp_status,$search)

    function emp_search_count_with_designation($designation,$emp_status,$search)
    {
  		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		
		$query = $this->db->table('employee')->select('*')->like('fname',$search)->orLike('lname',$search)->orLike('email',$search);

		if(empty($designation) && empty($emp_status) && $user_role != "admin"){
			$query = $query->where('id',$id);
		}elseif(!empty($designation) && !empty($emp_status)){
				//$query=$this->db->query("SELECT * FROM employee WHERE designation= ".$designation." and WHERE status= ".($emp_status-1)." and fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%'");
				$query = $query->where('designation',$designation)->where('status',($emp_status-1));	
		}elseif(!empty($designation) && empty($emp_status)) {
			//$query=$this->db->query("SELECT * FROM employee WHERE designation= ".$designation." and fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%'");
			$query = $query->where('designation',$designation);
		}elseif(empty($designation) && !empty($emp_status)){
			//$query=$this->db->query("SELECT * FROM employee WHERE status= ".($emp_status-1)." and fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%'");
			$query = $query->where('status',($emp_status-1));
		}
		$query = $query->get();
		return $query->getNumRows();
    }

	/* salary pay query start */

	function allposts_count_salary()
    {  
		$this->session = \Config\Services::session();
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->where('status',"1")->get();	
		}else{
			$query = $this->db->table('employee')->where('status',"1")->where('id',$id)->get();
		}
		return $query->getNumRows();  
    }
    
    function allposts_salary($limit,$start,$col,$dir)
    {   
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			$query = $this->db->table('employee')->where('status',"1")->limit($limit,$start)->orderBy($col,$dir)->get();
		}else{
			$query = $this->db->table('employee')->where('id',$id)->where('status',"1")->limit($limit,$start)->orderBy($col,$dir)->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult(); 
        }
        else
        {
            return null;
        }
    }
   
    function posts_search_salary($limit,$start,$search,$col,$dir)
    {
		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			// $query=$this->db->query("SELECT * FROM employee WHERE status=1 and (fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%') ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')
						->select('*')
						->where('status','1')
						->like('fname',$search)
						->orLike('lname',$search)
						->orLike('email',$search)
						->limit($limit,$start)
						->orderBy($col,$dir)
						->get();
		}else{
			//$query=$this->db->query("SELECT * FROM employee WHERE status=1 and id= ".$id." and  (fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%') ORDER BY ".$col." ".$dir." LIMIT ".$limit." OFFSET ".$start."");
			$query = $this->db->table('employee')
					->select('*')
					->where('status','1')
					->where('id',$id)
					->like('fname',$search)
					->orLike('lname',$search)
					->orLike('email',$search)
					->limit($limit,$start)
					->orderBy($col,$dir)
					->get();
		}
		if($query->getNumRows()>0)
        {
            return $query->getResult();  
        }
        else
        {
            return null;
        }
    }

    function posts_search_count_salary($search)
    {
  		$user_role=$this->session->get('user_role');
		$id=$this->session->get('id');
		if($user_role == "admin"){
			//$query=$this->db->query("SELECT * FROM employee WHERE status=1 and (fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%')");
			$query = $this->db->table('employee')
					->select('*')
					->where('status','1')
					->like('fname',$search)
					->orLike('lname',$search)
					->orLike('email',$search)
					->get();
		}else{
			// $query=$this->db->query("SELECT * FROM employee WHERE status=1 and id= ".$id." and (fname LIKE '%".$search."%' OR lname LIKE '%".$search."%' OR email LIKE '%".$search."%')");
			$query = $this->db->table('employee')
					->select('*')
					->where('status','1')
					->where('id',$id)
					->like('fname',$search)
					->orLike('lname',$search)
					->orLike('email',$search)
					->get();
		}
		return $query->getNumRows();
    }
	
	/* public function my_mailer($receiver,$subject,$massege) {

		$config = array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'himaygeek435@gmail.com', // change it to yours
		'smtp_pass' => 'himay@2550', // change it to yours
		'mailtype' => 'html',
		'charset' => 'iso-8859-1',
		'wordwrap' => TRUE
		);
		
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from($config['smtp_user']); // change it to yours
		$this->email->to($receiver); // change it to yours
		$this->email->subject($subject);
		// $this->email->attach($file);
		$this->email->message($massege);
		$this->email->send();
		echo $this->email->print_debugger();
	} */

}
