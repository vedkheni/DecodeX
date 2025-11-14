<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Deposit extends BaseController {
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
		$id =($this->uri->getSegment(2))?$this->uri->getSegment(3):'';
		$data['js_flag']="deposit_js";
		$data['page_title']="Deposit";
		$data['employee_list']= $this->Employee_Model->get_employee_list(1);
		
		
		if($_POST){
			$data['search']= $employee_select =$this->request->getPost('employee_select');
			return redirect()->to(base_url('deposit/index/'.$employee_select));
		}else{
			$data['search']= $employee_select = $data['employee_list'][0]->id;
			
		}
		if($id){
			//$data['employee_attendance_list'] = $this->Reports_Model->get_report_attendance($id,$search);
			$data['get_employee']= $this->Employee_Model->get_employee($id);
		}else{
			$id=$data['employee_list'][0]->id;
			//$data['employee_attendance_list'] = "";
			$data['get_employee']= $this->Employee_Model->get_employee($id);
			
		}
		// $salary = ($data['get_employee'][0]->salary)-($this->allfunction->prof_tax($data['get_employee'][0]->salary));
		if($user_role == "admin"){
			if($id){
				$u_id=$id;
			}else{
				$u_id=$data['employee_list'][0]->id;
			}
			// $data['deposit_payment']= $this->db->query("select * from deposit_payment where employee_id =".$u_id)->getResultArray();
			//echo $u_id;
			$deposit_amount=$this->Deposit_Payment_Model->get_deposit_list($u_id,'');
			$get_employee_increment_data= $this->Employee_Increment_Model->get_employee_increment_data($u_id,'');
		}else{
			$user_session=$this->session->get('id');
			$deposit_amount= $this->Deposit_Payment_Model->get_deposit_list($user_session,'');
			$get_employee_increment_data= $this->Employee_Increment_Model->get_employee_increment_data($user_session,'');
		}
		$salary = ($get_employee_increment_data[0]->amount)-($this->allfunction->prof_tax($get_employee_increment_data[0]->amount));
		
		$sum = 0;
		foreach($deposit_amount as $key=>$value)
		{
		   $sum+= $value->deposit_amount;
		}
		if($salary > 0){

			// if((($sum/$salary)*100) > 100){
			// 	$pr=100; 
			// }else{
			// 	$pr=(($sum/$salary)*100);
			// }
			$pr=(($sum/$salary)*100);
		}else{
			$pr = 0;
		}
		
		$data['deposit_total_pr']=$pr;
		//$data['get_deposit_total']= $this->Deposit_Payment_Model->get_deposit_list($user_session,'');
		$data['get_deposit_total']=$sum;
		
		//print_r($data['get_deposit_total']);
		
		
		$data['id']=$id;
		$data['menu']="deposit";
        $this->lib->view('administrator/deposit/deposit_list',$data);
	}
	public function total_deposits(){
		$user_role=$this->session->get('user_role');
		$data=array();
		 $id =$this->request->getPost('id');
		$data['js_flag']="deposit_js";
		$data['page_title']="Deposit";
		
		if($id){
			$data['get_employee']= $this->Employee_Model->get_employee($id);
		}
		if($id){
			$u_id=$id;
		}else{
			$u_id=$data['employee_list'][0]->id;
		}
		// $data['deposit_payment']=$this->db->query("select * from deposit_payment where employee_id =".$u_id)->getResultArray();
		//echo $u_id;
		$deposit_amount=$this->Deposit_Payment_Model->get_deposit_list($u_id,'');
		$get_employee_increment_data= $this->Employee_Increment_Model->get_employee_increment_data($u_id,'');
		$salary = ($get_employee_increment_data[0]->amount)-($this->allfunction->prof_tax($get_employee_increment_data[0]->amount));
		$sum = 0;
		foreach($deposit_amount as $key=>$value)
		{
		   $sum+= $value->deposit_amount;
		}
		$data['get_deposit_total']=number_format($sum,2);
		if($salary >0 ){

			// if((($sum/$salary)*100) > 100){
			// 	$pr=100;
			// }else{
			// 	$pr=(($sum/$salary)*100);
			// }
			$pr=(($sum/$salary)*100);
		}else{
			$pr = 0;
		}
		$data['deposit_total_pr']=number_format($pr,2);
		
		$data['id']=$id;
		$data['menu']="deposit";
        echo json_encode($data);
	}
	//designation
	public function insert_data_payment(){
		$employee_select=$this->request->getPost('id');
		$total_deposit=$this->request->getPost('total_deposit');
		$arr=array(
			'employee_id' => $employee_select,
			'deposit_payment' => $total_deposit,
			'deposit_payment_date' => date("Y-m-d"),
			'status' => "paid",
		);
		echo $this->db->table('deposit_payment')->insert($arr);
		
	}
	public function add(){
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$data=array();
		$id =$this->uri->getSegment(3);
		$deposit_id =$this->uri->getSegment(3)?$this->uri->getSegment(4):'';
		$data['js_flag']="deposit_js";
		$data['page_title']="Deposit";
		$data['employee_list']= $this->Employee_Model->get_employee_list(1);
		
		$search="";
		if($id){
			//$data['employee_attendance_list'] = $this->Reports_Model->get_report_attendance($id,$search);
			$data['get_employee']= $this->Employee_Model->get_employee($id);
			$data['get_deposit']= $this->Deposit_Model->get_deposit_by_id($deposit_id);
		}else{
			$id=1;
			//$data['employee_attendance_list'] = "";
			$data['get_employee']= $this->Employee_Model->get_employee($id);
			
		}
		// echo $id;exit;
		
		
		$data['id']=$id;
		$data['menu']="deposit_add";
        $this->lib->view('administrator/deposit/add_deposit',$data);
	}
	public function deposit_list()
	{
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$data=array();
		$id =$this->uri->getSegment(3);
		$data['js_flag']="deposit_js";
		$data['page_title']="Deposit";
		//$data['get_developer']= $this->Employee_Model->get_developer();
		
		$search="";
		if($id){
			//$data['employee_attendance_list'] = $this->Reports_Model->get_report_attendance($id,$search);
			$data['get_employee']= $this->Employee_Model->get_employee($id);
		}else{
			$id=1;
			//$data['employee_attendance_list'] = "";
			$data['get_employee']= $this->Employee_Model->get_employee($id);
			
		}
		
		$data['id']=$id;
		$data['menu']="deposit_list";
        $this->lib->view('administrator/deposit/deposit',$data);
	}
	
	public function getDeposit_data()
	{
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$data=array();
		$id =$this->request->getPost('id');
		$deposit_id =$this->request->getPost('deposit_id');

		if($id && $deposit_id){
			$data['get_employee']= $this->Employee_Model->get_employee($id);
			$data['get_deposit']= $this->Deposit_Model->get_deposit_by_id($deposit_id);
		}
		echo json_encode($data);exit;
	}
	public function insert_data(){
		// echo "<pre>"; print_r($_POST); echo "</pre>";exit();
		$data = array();
		$employee_select=$this->request->getPost('employee_select');
		$deposit=$this->request->getPost('deposit');
		$deposit_id=$this->request->getPost('deposit_id');
		$month=$this->request->getPost('deposit_month');
		$year=$this->request->getPost('deposit_year');
		$salary_deduction_per=$this->request->getPost('salary_deduction_per');
		$this->form_validation->reset();
		$this->form_validation->setRule('employee_select','Employee','required');
		$this->form_validation->setRule('deposit','Month','required');
		$this->form_validation->setRule('deposit_month','month','required');
		$this->form_validation->setRule('deposit_year','Year','required');
		if($this->validate($this->form_validation->getRules()) == false)
		{
			$data['massage'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>'.$this->validator->listErrors().'</p></div></div></div>';
			/*$this->session->set_flashdata('message', $this->validator->listErrors());
			return redirect()->to(base_url('deposit/add'));*/
		}else{
			if($deposit_id){
				$arr=array(
					'id' => $deposit_id,
					'employee_id' => $employee_select,
					'deposit_amount' => $deposit,
					'deposit_percentage' => $salary_deduction_per,
					'month' => $month,
					'year' => $year,
				); 
				$deposit=$this->Deposit_Payment_Model->update_deposit($arr);
				if($deposit){
					$data['massage'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Employee deposit Updated.</p></div></div></div>';
					// return redirect()->to(base_url('deposit/index/'.$employee_select));
				}else{
					$data['massage'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Employee deposit failed to update!</p></div></div></div>';
				}
			}else{
				$arr=array(
					'employee_id' => $employee_select,
					'deposit_amount' => $deposit,
					'deposit_percentage' => $salary_deduction_per,
					'month' => $month,
					'year' => $year,
				); 
				$deposit=$this->Deposit_Payment_Model->insert_deposit($arr);
				if($deposit){
					$data['massage'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Employee deposit added.</p></div></div></div>';
					// return redirect()->to(base_url('deposit/index/'.$employee_select));
				}else{
					$data['massage'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Employee deposit failed to add!</p></div></div></div>';
				}
			}
		}
		echo json_encode($data);
	}
	public function employee_pagination_list()
	{
		$user_role=$this->session->get('user_role');
		
		/* $this->session->set_userdata($set_session); */
		//Designation_Model
		// $id =$this->uri->getSegment(3);
		$id = $this->request->getPost('id');
		$user_role=$this->session->get('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'deposit_amount',
                            2 =>'month', 
							3 =>'year',
							4 =>'payment_status',
                        );
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
		$dir1 = ($this->request->getPost('order')[0]['dir'] == 'asc')? SORT_ASC : SORT_DESC ;
  
        $totalData = $this->Deposit_Payment_Model->allposts_count($id);
            
        $totalFiltered = $totalData; 
            
		$posts = $this->Deposit_Payment_Model->allposts($id,$limit,$start,$order,$dir);
        if(empty($this->request->getPost('search')['value']))
        {   
			$search = '';         
        }
        else {
            $search = $this->request->getPost('search')['value'] ; 

            // $posts =  $this->Deposit_Payment_Model->posts_search($id,$limit,$start,$search,$order,$dir);
			
            // $totalFiltered = $this->Deposit_Payment_Model->posts_search_count($id,$search);
        }
		
		$data = array();
		$i=0;
        if(!empty($posts))
        {
			array_sort_by_multiple_keys($posts, [
				$order => $dir1,
			]);
			foreach ($posts as $post)
            {
				$status = '';
				if (empty($search) || strpos(strtolower($post->payment_status), $search) !== false || strpos(strtolower(date('F', mktime(0, 0, 0, $post->month, 10))), $search) !== false || strpos(strtolower($post->year), $search) !== false || strpos(strtolower($post->deposit_amount), $search) !== false) {
					if(ucfirst($post->payment_status) == 'Paid'){
						$status = '<span class="text-success">'.ucfirst($post->payment_status).'</span>';
					}elseif(ucfirst($post->payment_status) == 'Pending'){
						$status = '<span class="text-danger">'.ucfirst($post->payment_status).'</span>';
					}
					$monthNum  = $post->month;
					$monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
					$nestedData['id'] = "<span>".($i+1) ."</span>";
					$nestedData['deposit_amount'] = $post->deposit_amount;
					$nestedData['month'] = $monthName;
					$nestedData['year'] = $post->year;
					$nestedData['payment_status'] = $status;
					//$nestedData['action']="";
					if($user_role == 'admin'){
						$nestedData['action'] ='<button data-emp_id="'.$id.'" data-id="'.$post->id.'" class="btn sec-btn sec-btn-outline edit_deposit" >Edit</button>  <button data-emp-id="'.$id.'" data-id="'.$post->id.'" class="btn btn-outline-danger delete_deposit">Delete</button>';
					}
					$data[] = $nestedData;
					$i++;
            	}
			}
        }
		$totalFiltered = $i; 
		// array_sort_by_multiple_keys($data, [
		// 	$order => $dir1,
		// ]);
        $json_data = array(
                    "draw"            => intval($this->request->getPost('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    ); 
       echo json_encode($json_data); 
	}
	public function employee_pagination()
	{
		//print_r($_POST);
		$month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
		$user_role=$this->session->get('user_role');
		$columns = array( 
                            0 =>'id',
                            1 =>'fname',
							2 =>'status',
                            3 =>'action',
                        );
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
  
        $totalData = $this->Deposit_Model->allposts_count_deposit();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->request->getPost('search')['value']))
        {            
            $posts = $this->Deposit_Model->allposts_deposit($limit,$start,$order,$dir);
        }
        else {
            $search = $this->request->getPost('search')['value'] ; 

            $posts =  $this->Deposit_Model->posts_search_deposit($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Deposit_Model->posts_search_count_deposit($search);
        }
        $cdate=date('Y-m-d');
         $data = array();
        if(!empty($posts))
        {
			$i=1;	
		 foreach ($posts as $post)
            {
            	$nestedData['id'] =  "<span>".$i ."</span>";
                $nestedData['fname'] = $post->fname." ".$post->lname;
               // $nestedData['lname'] = $post->lname;
                //$nestedData['email'] = $post->email;	
                $get_salary_pay=$this->Leave_Request_Model->get_deposit_payment($post->id);
				if(!empty($get_salary_pay)){
                	$button_name="View";
					$Status="Paid";
                }else{
					$button_name="Pay";
					$Status="Unpaid";
                }
				
				$nestedData['status'] = $Status;
                if($user_role == "admin"){
					$nestedData['action'] =' <a  data-id="'.$post->id.'" data-status="'.$Status.'"  class="btn btn-danger waves-effect waves-light pay-salary-btn deposit_payment_btn"  data-toggle="modal" data-target="#myModal">'.$button_name.'</a>';
                }else{
					$nestedData['action'] ="";
					//if($button_name == "View"){
						$nestedData['action'] =' <a  data-id="'.$post->id.'" data-status="'.$Status.'" class="btn btn-danger waves-effect waves-light pay-salary-btn deposit_payment_btn"  data-toggle="modal" data-target="#myModal">View</a>';
					//}
				}
				//Add Attendance
              	$data[] = $nestedData;

            $i++;}
        }
        
       	$json_data = array(
                    "draw"            => intval($this->request->getPost('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    ); 
       echo json_encode($json_data); 
	}
	public function delete_employee(){
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$id = $this->request->getPost("id");
		$emp_id = $this->request->getPost("emp_id");
		$delete_employee= $this->Bonus_Model->delete_employee($id,$emp_id);
	
	}
	public function deposit_employee_data(){
		$id=$this->request->getPost('id');
		$deposit_data= $this->allfunction->deposit_data($id);
		echo json_encode($deposit_data);
	}
	public function txt_file_update(){
		$year = date("Y");
		$month_name = date("M");
		$deposit_payment_tbl=$this->Deposit_Payment_Model->deposit_payment_tbl();
		$notpad="";
		$sum = 0;
		$c=0;
		if(!empty($deposit_payment_tbl)){
			$c=count($deposit_payment_tbl);
			foreach($deposit_payment_tbl as $salary){
				$net_salary=$salary->deposit_payment;
				$sum+= $salary->deposit_payment;
				if(strstr($salary->ifsc_number,"ICI")){
					$notpad .="MCW|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".$salary->deposit_payment."|INR|".$month_name." ".$year." Deposit|".$salary->ifsc_number."|WIB^ \n";
				}else{
					
					$notpad .="MCO|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".$salary->deposit_payment."|INR|".$month_name." ".$year." Deposit"."|NFT|".$salary->ifsc_number."^ \n";
				}
			}
		}
		$count=$c+1;
		$day=date("m/d");
		$pay_date=date('m/d', strtotime(' + 2 days'));
		if(date('N', strtotime($pay_date)) >= 6){
			$pay_date=date('m/d', strtotime($pay_date. 'next monday'));
		}
		$employee_salary=$sum;
		$notpad1="FHR|".$count."|".$pay_date."/".$year."|Cut-off|".$employee_salary."|INR|624605065816|0011^ \n".
		"MDR|624605065816|0011|GEEKWEBS28012017|".$employee_salary."|INR|".$month_name." ".$year." Deposit|ICIC0000011|WIB^ \n"
			.$notpad;
			
		 $filename =$_SERVER['DOCUMENT_ROOT'].'/assets/salary_pay/Deposit_'.$month_name.'_'.$year.'.txt';
		 if (!file_exists($filename)) {
			$handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle);
			return redirect()->to(base_url().'assets/salary_pay/Deposit_'.$month_name.'_'.$year.'.txt');
        }else{
			$handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle);
			return redirect()->to(base_url().'assets/salary_pay/Deposit_'.$month_name.'_'.$year.'.txt');
		}
	}
	public function deposit_insert_data(){
		//mktime(0, 0, 0, $month, 10);
		//print_r($_POST);
		//die;
		$year = date("Y");
		$month_name = date("M");
		$deposit_payment_tbl=$this->Deposit_Payment_Model->deposit_payment_tbl();
		 //print_r($deposit_payment_tbl);
		$notpad="";
		$sum = 0;		
		if(!empty($deposit_payment_tbl)){		
			foreach($deposit_payment_tbl as $salary){
				$net_salary=$salary->deposit_payment;
				$sum+= $salary->deposit_payment;
				if(strstr($salary->ifsc_number,"ICI")){
					$notpad .="MCW|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".$salary->deposit_payment."|INR|".$month_name." ".$year." Deposit|".$salary->ifsc_number."|WIB^ \n";
				}else{
					
					$notpad .="MCO|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".$salary->deposit_payment."|INR|".$month_name." ".$year." Deposit"."|NFT|".$salary->ifsc_number."^ \n";
				}
			}
		}
	
		$id=$this->request->getPost('id');
		$total_deposit=$this->request->getPost('total_deposit');
		$get_employee=$this->Employee_Model->get_employee($id);
		if(strstr($get_employee[0]->ifsc_number,"ICI")){
			$notpad2="MCW|".$get_employee[0]->account_number."|0011|".$get_employee[0]->fname." ".$get_employee[0]->lname."|".$total_deposit."|INR|".$month_name." ".$year." Deposit|".$get_employee[0]->ifsc_number."|WIB^";
		}else{
			$notpad2="MCO|".$get_employee[0]->account_number."|0011|".$get_employee[0]->fname." ".$get_employee[0]->lname."|".$total_deposit."|INR|".$month_name." ".$year." Deposit"."|NFT|".$get_employee[0]->ifsc_number."^ \n";
		}
		
		$day=date("m/d");
		$pay_date=date('m/d', strtotime(' + 2 days'));
		if(date('N', strtotime($pay_date)) >= 6){
			$pay_date=date('Y-m-d', strtotime($pay_date. 'next monday'));
		}
		$employee_salary=$total_deposit + $sum;
		$notpad1="FHR|3|".$pay_date."/".$year."|Cut-off|".$employee_salary."|INR|624605065816|0011^ \n".
		"MDR|624605065816|0011|GEEKWEBS28012017|".$employee_salary."|INR|".$month_name." ".$year." Deposit|ICIC0000011|WIB^ \n"
			.$notpad.$notpad2;
			//echo  $notpad1;
		 $filename =$_SERVER['DOCUMENT_ROOT'].'/assets/salary_pay/Deposit_'.$month_name.'_'.$year.'.txt';
		 if (!file_exists($filename)) {
			$handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle);
        }else{
			$handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle);
		} 
		$arr=array(
			'employee_id' => $id,
			'deposit_payment' => $total_deposit,
			'deposit_payment_date' => date("Y-m-d"),
			'status' => "paid",
		);
		echo $this->db->table('deposit_payment')->insert($arr);
			
	}
	public function deposit_query(){
		
		
		 echo "<pre>";
		/* print_r($res); */
		$select="select * from employee where status = 1 limit 0,3";
		$res1=$this->db->query($select)->getResultArray();
		$arr=array();
		foreach($res1 as $v){
			$select2="select * from deposit where year=2020 AND employee_id='".$v['id']."'";
			$res=$this->db->query($select2)->getResultArray();
			
			foreach($res as $d){
				
				for($m=1;$m<=12;$m++){
					$month_name1 = date("F Y", mktime(0, 0, 0, $m, 10,$d['year']));
					if($m == $d['month']){
						$deposit=array();
						$deposit['amount']=$d['deposit_amount'];
						$deposit['status']=$d['payment_status'];
						$arr[$month_name1][$v['fname']]=$deposit;
					}
					
					
				}
				
			}
		}
		print_r($arr);
		
		$y=date('Y');
		for($i=0;$i<1;$i++){
				for($m=1;$m<=12;$m++){
					echo "<br>";
					echo $month_name = date("F Y", mktime(0, 0, 0, $m, 10,$y-$i));
				}
		}
	
		//$month_name = date("F", mktime(0, 0, 0, 12, 10)); 
	}
	
	public function deleteDeposit(){
		
		$id = $this->request->getPost("id");
		$emp_id = $this->request->getPost("emp_id");
		$deleteDeposit= $this->Deposit_Model->deleteDeposit($id,$emp_id);

		if($deleteDeposit){
			$data['error'] = 0;
			$data['massage'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Employee deposit deleted.</p></div></div></div>';
		}else{
			$data['error'] = 1;
			$data['massage'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Employee deposit failed to delete!</p></div></div></div>';
		}

		echo json_encode($data);exit;
	
	}
}
