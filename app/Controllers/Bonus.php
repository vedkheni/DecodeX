<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Bonus extends BaseController {
	public function __construct()
	{
		parent::__construct();
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
	}

	//designation
	public function index()
	{
		
		$data=array();
		$id =($this->uri->getSegment(2))?$this->uri->getSegment(3):'';
		$data['js_flag']="bonus_js";
		$data['page_title']="Bonus";
		$user_role=$this->session->get('user_role');
		if($user_role == 'admin'){
			if($_POST){
				$data['employee_id']= $employee_id = $this->request->getPost('employee_id');	
				$data['select_year']= $select_year = $this->request->getPost('select_year');	
				$data['get_employee_total_bonus']=$this->Dashboard_Model->get_employee_total_bonus($employee_id,$select_year);
			}else{
				$data['get_employee_total_bonus']=$this->Dashboard_Model->get_employee_total_bonus("2","all");
			}
		}else{
			$data['get_employee_total_bonus']=$this->Dashboard_Model->get_employee_total_bonus();
		}
		$data['get_employee_list'] = $this->Employee_Model->get_employee_list(1);

		$data['id']=$id;
		$data['menu']="bonus";
        $this->lib->view('administrator/bonus/bonus',$data);
	}
	public function totle_bouns()
	{
		$data=array();
		$data['js_flag']="bonus_js";
		$data['page_title']="Bonus";
		//$data['get_developer']= $this->Employee_Model->get_developer();
		$user_role=$this->session->get('user_role');
		if($user_role == 'admin'){
			$data['employee_id']= $employee_id = $this->request->getPost('employee_id');	
			$data['select_year']= $select_year = $this->request->getPost('select_year');	
			$data['get_employee_total_bonus']=$this->Dashboard_Model->get_employee_total_bonus($employee_id,$select_year);
		}else{
			$data['get_employee_total_bonus']=$this->Dashboard_Model->get_employee_total_bonus();
		}

		$data['menu']="bonus";
    	echo json_encode($data);
    }
	public function insert_data(){

		$emp_id=$this->request->getPost('emp_id');
		$this->form_validation->reset();
		$this->form_validation->setRule('bonus','Bonus','required');
		$this->form_validation->setRule('bonus_month','Month','required');
		$this->form_validation->setRule('bonus_year','Year','required');
		
		if($this->validate($this->form_validation->getRules()) == false)
		{
			$this->session->set_flashdata('message', $this->validator->listErrors());
			return redirect()->to(base_url('bonus/add/'.$emp_id));
		}else{
			$edit_id=$this->request->getPost('edit_id');
			$bonus=$this->request->getPost('bonus');
			$bonus_month=$this->request->getPost('bonus_month');
			$bonus_year=$this->request->getPost('bonus_year');
			 $arr=array(
				'emp_id' => $emp_id,
				'bonus' => $bonus,
				'month' => $bonus_month,
				'year' => $bonus_year,
			); 
			if(isset($edit_id) && !empty($edit_id)){
				$bonus=$this->db->table('bonus')->where('id',$edit_id)->where('emp_id',$emp_id)->update($arr);
			}else{
				$bonus=$this->db->table('bonus')->insert($arr);
			}
			if($bonus){
				return redirect()->to(base_url('bonus/add/'.$emp_id));
			}
		}
	}
	public function employee_pagination()
	{
		
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			$id=$this->session->get('id');
			$select_year="all";
		}else{
			$id=$this->request->getPost('employee_id');
			$select_year=$this->request->getPost('select_year');
		}
		$user_role=$this->session->get('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'bonus',
                            2 =>'month', 
							3 =>'year',
							
                        );
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
  
        $totalData = $this->Bonus_Model->allposts_count($id,$select_year);
            
        $totalFiltered = $totalData; 
            
		$posts = $this->Bonus_Model->allposts($id,$select_year,$limit,$start,$order,$dir);
        if(empty($this->request->getPost('search')['value']))
        {            
			$search = '';
		}
        else {
            $search = $this->request->getPost('search')['value'] ; 

            // $posts =  $this->Bonus_Model->posts_search($id,$select_year,$limit,$start,$search,$order,$dir);

            // $totalFiltered = $this->Bonus_Model->posts_search_count($id,$select_year,$search);
        }
		
          $data = array();
		  $i=0;
        if(!empty($posts))
        {
		 foreach ($posts as $post)
            {
				if (empty($search) || strpos(strtolower($post->bonus), $search) !== false || strpos(strtolower(date('F', mktime(0, 0, 0, $post->month, 10))), $search) !== false || strpos(strtolower($post->year), $search) !== false) {
					$monthNum  = $post->month;
					$monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
					$nestedData['id'] = ($i+1);
					$nestedData['bonus'] = $post->bonus;
					$nestedData['month'] = $monthName;
					$nestedData['year'] = $post->year;
					$data[] = $nestedData;
					$i++;
				}
            }
        }
		$totalFiltered = $i; 
        $json_data = array(
				"draw"            => intval($this->request->getPost('draw')),  
				"recordsTotal"    => intval($totalData),  
				"recordsFiltered" => intval($totalFiltered), 
				"data"            => $data   
				); 
       echo json_encode($json_data); 
	}
	public function delete_employee(){
		
		$this->load->model('Bonus_Model');
		$id = $this->request->getPost("id");
		$emp_id = $this->request->getPost("emp_id");
		$delete_employee= $this->Bonus_Model->delete_employee($id,$emp_id);
	
	}

	public function create_table(){
	}
	
}
