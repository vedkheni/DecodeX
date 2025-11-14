<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Increment extends BaseController {
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
		$data['js_flag']="increment_js";
		$data['page_title']="Increment";
		$data['employee_list']= $this->Employee_Model->get_employee_list(1);
		
		if($_POST){
			$data['search']= $employee_select =$this->request->getPost('employee_select');
			return redirect()->to(base_url('increment/index/'.$employee_select));
		}else{
			$data['search']= $employee_select = $data['employee_list'][0]->id;
			
		}	

		if($id){
			$data['get_employee']= $this->Employee_Model->get_employee($id);
		}else{
			$id=$data['employee_list'][0]->id;
			$data['get_employee']= $this->Employee_Model->get_employee($id);
		}
		if($user_role != 'admin'){
			$id=$this->session->get('id');
			$data['get_employee']= $this->Employee_Model->get_employee($id);
		}
		$get_employee_increment_data= $this->Employee_Increment_Model->get_employee_increment_data($id,'');
		$data['get_employee_increment_data']=$get_employee_increment_data;
		
		//print_r($data['get_deposit_total']);
		
		$data['id']=$id;
		$data['menu']="increment";
        $this->lib->view('administrator/increment/increment_list',$data);
	}
	public function total_deposits(){
		$user_role=$this->session->get('user_role');
		$data=array();
		 $id =$this->request->getPost('id');
		$data['js_flag']="increment_js";
		$data['page_title']="Increment";
		
		if($id){
			$data['get_employee']= $this->Employee_Model->get_employee($id);
		}
		if($id){
			$u_id=$id;
		}else{
			$u_id=$data['employee_list'][0]->id;
		}
		$get_employee_increment_data= $this->Employee_Increment_Model->get_employee_increment_data($emp,'');

		$data['deposit_payment']=$this->db->query("select * from deposit_payment where employee_id =".$u_id)->getResultArray();
		//echo $u_id;
		$deposit_amount=$this->Deposit_Payment_Model->get_deposit_total($u_id);
		$sum = 0;
		foreach($deposit_amount as $key=>$value)
		{
		   $sum+= $value->deposit_amount;
		}
		$data['get_deposit_total']=$sum;
		
		$data['id']=$id;
		$data['menu']="increment";
        echo json_encode($data);
	}
	//designation
	public function append_data_employee(){
		$id=$this->request->getPost('id');

		$get_employee_increment_data= $this->Employee_Increment_Model->get_employee_increment_data($id,'');
		$get_employee= $this->Employee_Model->get_employee($id);
		// echo '<pre>'; print_r( $get_employee_increment_data ); echo '</pre>';exit;

		$data=array('data' => $get_employee_increment_data,'employee_details' => $get_employee);

		echo json_encode($data);
	}
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
		$data['js_flag']="increment_js";
		$data['page_title']="Increment";
		$data['employee_list']= $this->Employee_Model->get_employee_list(1);
		
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
		$data['menu']="increment_add";
        $this->lib->view('administrator/increment/add_increment',$data);
	}
	public function insert_increment(){
		$data = array();
		$emp_id=$this->request->getPost('emp_id');
		$id=$this->request->getPost('id');
		$list_data = $this->Employee_Model->get_employee($emp_id);
		$increment_date=$this->request->getPost('increment_date1');	
		$increment_amount=$this->request->getPost('increment_amount1');
		//$next_increment_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($increment_date)) . " + 1 year"));
		/* if($this->request->getPost('next_increment_amount1') != ""){
			$next_increment_date=$this->request->getPost('next_increment_amount1');
		} */
		$status=$this->request->getPost('increment_status_add');

			$arr=array(
				'increment_date' => Format_date($increment_date),
				'employee_id' => $emp_id,
				'amount' => $increment_amount,
				'status' => strtolower($status),
				'created_date' => date('Y-m-d h:i:s'),
			);
			$insert_employee=$this->Employee_Increment_Model->insert_data($arr);
			if($insert_employee){
				$get_employee_row=$this->Employee_Increment_Model->get_employee_increment_row($emp_id);
				if($status == 'approved'){
					$arr1=array(
						'id' => $emp_id,
						'salary' => ($get_employee_row->salary+$increment_amount),
						'salary_deduction' => 0,
						'employee_status' => 'employee',
						'updated_date' => date('Y-m-d h:i:s'),
					);
					$update_emp = $this->Employee_Model->update_employee($arr1);
					
					if($list_data[0]->personal_email){
						$mail_data = array();
						$content = $this->Mail_Content_Model->mail_content_by_slug('salary_increment_mail');
						$variables = array(
							"{{date}}" => dateFormat($increment_date),
							"{{amount}}" => $increment_amount,
							"{{new_salary}}" => ($get_employee_row->salary+$increment_amount),
						);
						$message = $content[0]->content;
						foreach ($variables as $key => $value){
							$message = str_replace($key, $value, $message);
						}
						$mail_data = array(
							'mail_type' => 'salary_increment',
							'subject' => 'Salary Increment Mail from Geek Web Solution '.date('M, Y',strtotime($increment_date)),
							'title' => 'Increment Mail - '.date('M, Y',strtotime($increment_date)),
							'greeting' => 'Dear',
							'img_name' => 'increment.png',
							'message' => $message,
							'name' => $list_data[0]->fname.' '.$list_data[0]->lname,
							'to' => $list_data[0]->personal_email,
							'base_url' => base_url(),
						);
						/* $mail_data['mail_type'] = 'salary_pay';
						$mail_data['subject'] = 'Salary Increment from Geek Web Solution '.date('M, Y',strtotime($increment_date));
						$mail_data['title'] = date('M, Y',strtotime($increment_date)).' Salary Increment';
						$mail_data['greeting'] = 'Dear';
						$mail_data['img_name'] = 'salary-paid.png';
						$mail_data['message'] = $message;
						$mail_data['name'] = $list_data[0]->fname.' '.$list_data[0]->lname;
						$mail_data['to'] = $list_data[0]->personal_email;
						$mail_data['salary'] = ($get_employee_row->salary+$increment_amount);
						$mail_data['base_url'] = base_url(); */
						$mail_send_code = $this->mailfunction->mail_send($mail_data);
						if($mail_send_code){
							$data['error_code'] = 0;
							$data['id'] = $insert_employee;
							$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Increment added.</p></div></div></div>';
						}else{
							$data['error_code'] = 1;
							$data['id'] = 0;
							$data = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">Mail not sended.</p></div></div></div>';
						}
						echo json_encode($data);exit;
						// $data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Bank status successfully updated.</p></div></div></div>';
					}else{
						$data['error_code'] = 1;
						$data['id'] = 0;
						$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">Employee personal email not found</p></div></div></div>';
						echo json_encode($data);exit;
					}
				}else{
					$data['error_code'] = 0;
					$data['id'] = $insert_employee;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Next increment added.</p></div></div></div>';
				}
			//echo $insert_employee;
		} 
		echo json_encode($data);exit;
		
	}

	public function deposit_list()
	{
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$data=array();
		$id =$this->uri->getSegment(3);
		$data['js_flag']="increment_js";
		$data['page_title']="Increment";
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
		$data['menu']="increment_list";
        $this->lib->view('administrator/increment/increment',$data);
	}
	public function insert_data(){
		// echo "<pre>"; print_r($_POST); echo "</pre>";exit();
		$data = array();
		$employee_select=$this->request->getPost('employee_select');
		$deposit=$this->request->getPost('deposit');
		$month=$this->request->getPost('deposit_month');
		$year=$this->request->getPost('deposit_year');
		$salary_deduction_per=$this->request->getPost('salary_deduction_per');
		$this->form_validation->set_rules('employee_select','Employee','required');
		$this->form_validation->set_rules('deposit','Month','required');
		$this->form_validation->set_rules('deposit_month','month','required');
		$this->form_validation->set_rules('deposit_year','Year','required');
		if($this->form_validation->run() == false)
		{
			$data['massage'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>'.validation_errors().'</p></div></div></div>';
			/*$this->session->set_flashdata('message', validation_errors());
			return redirect()->to(base_url('deposit/add'));*/
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
		echo json_encode($data);
	}
	public function employee_pagination_list(){
	
		$id = $this->request->getPost('id');
		$user_role=$this->session->get('user_role');
		$columns = array( 
                            0 =>'id', 
                            1 =>'increment_date',
                            2 =>'next_increment_date', 
							3 =>'amount',
                        );
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
  
        $totalData = $this->Increment_Model->allposts_count($id);
            
        $totalFiltered = $totalData; 
            
        if(empty($this->request->getPost('search')['value']))
        {            
            $posts = $this->Increment_Model->allposts($id,$limit,$start,$order,$dir);
        }
        else {
            $search = $this->request->getPost('search')['value'] ; 

            $posts =  $this->Increment_Model->posts_search($id,$limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Increment_Model->posts_search_count($id,$search);
        }
		
          $data = array();
        if(!empty($posts))
        {
		 $i=1;
		 foreach ($posts as $post)
            {
            	$status = 'edit';
            	
            	$nestedData['id'] = "<span>".$i ."</span>";
                $nestedData['increment_date'] = $post->increment_date;
                $nestedData['next_increment_date'] = $post->next_increment_date;
				$nestedData['amount'] = $post->amount;
				$nestedData['action']='<button data-id="'.$post->id.'"  data-increment_date="'.$post->increment_date.'" data-next_increment_date="'.$post->next_increment_date.'"  data-amount="'.$post->amount.'" class="edit-employee-increment btn btn-outline-secondary" data-toggle="modal" data-target="#modal_attendsnce">Edit</button><button data-id="'.$post->id.'" class="btn btn-outline-danger m-l-5 delete-employee-increment">Delete</button>';
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
	public function update_increment(){
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$increment_date = Format_date($this->request->getPost("increment_date"));
		$data=array(
			'id' => $this->request->getPost("increment_id"),
			'increment_date' => $increment_date,
			'status' => $this->request->getPost("increment_status"),
			'amount' => $this->request->getPost("increment_amount"),
			'updated_date' => date('Y-m-d h:i:s'),
		);
		$update= $this->Increment_Model->update_data($data);
		if ($update)
		{
			$get_employee_row=$this->Employee_Increment_Model->get_employee_increment_data($this->request->getPost("employee_id"),'approved');
			$amount = 0;
			if(isset($get_employee_row) && !empty($get_employee_row)){
				foreach($get_employee_row as $incrementDetails){
					$amount += $incrementDetails->amount;
				}
				$arr1=array(
					'id' => $this->request->getPost("employee_id"),
					'salary' => $amount,
					'updated_date' => date('Y-m-d h:i:s'),
				);
				$update_emp = $this->Employee_Model->update_employee($arr1);
			}
			echo  '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Increment updated.</p></div></div></div>';
		}
		else
		{
			echo '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Increment failed to update!</p></div></div></div>';
		}

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
	
	public function update_increment_status(){
		$id=$this->request->getPost('id');
		$increment_status=$this->request->getPost('increment_status');
		$get_employee=$this->Employee_Model->get_employee_details($id);
		// $get_employee_increment_row=$this->Employee_Increment_Model->get_employee_increment_row($id);
		if(!empty($get_employee)){
			echo json_encode($get_employee);
		}else{
			echo "0";
		}
		// if(!empty($get_employee_increment_row)){
		// 	echo json_encode($get_employee_increment_row);
		// }else{
		// }
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
	
	function delete_increment(){
		$id=$this->request->getPost('id');
		if($id){
			$res = ($id) ? $this->db->table('employee_increment')->where('id',$id)->delete() : '';

			echo ($res) ? '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Increment deleted.</p></div></div></div>' : '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Increment failed to delete!</p></div></div></div>';exit;
		}else{
			echo '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Increment id not found!</p></div></div></div>';exit;
		}
	}
}
