<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Paid_leave extends BaseController {
	public function __construct()
	{
		parent::__construct();
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
	}
	public function index(){
		$user_role=$this->session->get('user_role');
		$data=array();
		$id =$this->uri->getSegment(2)?$this->uri->getSegment(3):'';
		$data['js_flag']="paid_leave_js";
		$data['page_title']="paid_leave";

		
		$data['employee_list']= $this->Employee_Model->get_employee_list(1);
        if($id){
            // $data['get_employee']= $this->Employee_Attendance_Model->get_employee($id);
            $data['paid_leave_list']= $this->Paid_Leave_Model->emp_paid_leave($id);
		}else{
            $id=$data['employee_list'][0]->id;
            $data['paid_leave_list']= $this->Paid_Leave_Model->emp_paid_leave($id);
			// $data['get_employee']= $this->Employee_Attendance_Model->get_employee($id);
        }
        /* if($_POST){
			$data['search']= $employee_select =$this->request->getPost('employee_select');
			return redirect()->to(base_url('increment/index/'.$employee_select));
		}else{
			$data['search']= $employee_select = $data['employee_list'][0]->id;
        }
        
		$get_employee_increment_data= $this->Employee_Increment_Model->get_employee_increment_data($id);
		$data['get_employee_increment_data']=$get_employee_increment_data; */
		
		//print_r($data['get_deposit_total']);

		$data['id']=$id;
		$data['menu']="paid_leave";
        $this->lib->view('administrator/paid_leave/paid_leave_list',$data);
	}
	//designation
	public function employee_paid_leave(){
        $id=$this->request->getPost('id');
        
		$paid_leave_list = $this->Paid_Leave_Model->emp_paid_leave($id);;
		$get_employee= $this->Employee_Model->get_employees_details($id);
        
		$data=array('data' => $paid_leave_list,'employee_details' => $get_employee);
        
		echo json_encode($data);
    }
	
	public function paidLeave_byYear(){
        $data = array();
		$id=$this->request->getPost('id');
        $year=date('Y',strtotime('01-01-'.$this->request->getPost('year')));
		$employee_paid_leaves=$this->Leave_Report_Model->get_employee_paid_leaves(array('id' => $id,'year'=> $year));
		if($employee_paid_leaves){
			ksort($employee_paid_leaves);
		}
		$data['employee_paid_leaves']=$employee_paid_leaves;
		echo json_encode($data);
    }
    
	public function paid_leave_list(){
	
		$id = $this->request->getPost('id');
    
		$user_role=$this->session->get('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'year',
                            2 =>'month', 
							3 =>'status',
                        );
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
  
        $totalData = $this->Paid_Leave_Model->allposts_count($id);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->request->getPost('search')['value']))
        {            
            $posts = $this->Paid_Leave_Model->allposts($id,$limit,$start,$order,$dir);
        }
        else {
            $search = $this->request->getPost('search')['value'] ; 

            $posts =  $this->Paid_Leave_Model->posts_search($id,$limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Paid_Leave_Model->posts_search_count($id,$search);
        }
		
          $data = array();
		//   echo '<pre>'; print_r( $posts ); echo '</pre>';exit;
        if(!empty($posts))
        {
		 $i=1;
		 foreach ($posts as $post)
            {
            	$status = 'edit';
            	$nestedData['#'] = "<span>".$i ."</span>";
                $nestedData['year'] = $post->year;
                $nestedData['month'] = date('M',strtotime('01-'.$post->month.'-'.$post->year));
				$nestedData['status'] = (empty($post->status))?'paid':$post->status;
				$nestedData['action']='<button data-id="'.$post->id.'"  data-year="'.$post->year.'" data-month="'.$post->month.'"  data-status="'.$post->status.'" data-used_leave_month="'.$post->used_leave_month.'" data-used_leave_year="'.$post->used_leave_year.'"  class="btn btn-outline-secondary edit-paid-leave" data-toggle="modal" data-target="#modal_attendsnce">Edit</button><button data-id="'.$post->id.'" class="btn btn-danger m-l-5 delete-paid_leave">Delete</button>';
              	$data[] = $nestedData;
				$i++;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->request->getPost('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    ); 
       echo json_encode($json_data);
	   
	}
	public function update_leave(){
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$status = $this->request->getPost("status");
		$id = $this->request->getPost("id");
		
		$this->form_validation->reset();
		$this->form_validation->setRule('month','Month','required');
		$this->form_validation->setRule('year','Year','required');
		$this->form_validation->setRule('status','Status','required');
		if($status == 'used' || $status == 'paid'){
			$this->form_validation->setRule('used_leave_month','Used Leave Month','required');
			$this->form_validation->setRule('used_leave_year','Used Leave Year','required');
		}
		if($this->form_validation->withRequest($this->request)->run() == false)
		{
			echo '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>'.$this->form_validation->listErrors().'</p></div></div></div>';
			/*$this->session->set_flashdata('message', $this->form_validation->listErrors());
			return redirect()->to(base_url('deposit/add'));*/
		}else{
			if($id){
				$data=array(
					'id' => $id,
					'month' => $this->request->getPost("month"),
					'year' => $this->request->getPost("year"),
					'status' => $status,
					'used_leave_month' => $this->request->getPost("used_leave_month"),
					'used_leave_year' => $this->request->getPost("used_leave_year"),
					'updated_date' => date('Y-m-d h:i:s'),
				);
				$update = $this->Paid_Leave_Model->update_data($data);
				if ($update)
				{
					echo  '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Paid leave updated.</p></div></div></div>';
				}
				else
				{
					echo '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Paid leave failed to update!</p></div></div></div>';
				}
			}else{
				$data=array(
					'employee_id' => $this->request->getPost("employee_id"),
					'leave' => 1,
					'month' => $this->request->getPost("month"),
					'year' => $this->request->getPost("year"),
					'status' => $this->request->getPost("status"),
					'used_leave_month' => $this->request->getPost("used_leave_month"),
					'used_leave_year' => $this->request->getPost("used_leave_year"),
				);
				$insert = $this->Paid_Leave_Model->insert_data($data);
				if ($insert)
				{
					echo  '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Paid leave added.</p></div></div></div>';
				}
				else
				{
					echo '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Paid leave failed to add!</p></div></div></div>';
				}
			}
		}

	}	
	public function delete_leave(){
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$id = $this->request->getPost("id");
		$employee_id = $this->request->getPost("employee_id");
		
		$delete_employee= $this->Paid_Leave_Model->delete_data($id,$employee_id);
		if ($delete_employee)
		{
			echo  '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Paid leave deleted.</p></div></div></div>';
		}
		else
		{
			echo '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Paid leave failed to delete!</p></div></div></div>';
		}
	
	}
	
	
}
