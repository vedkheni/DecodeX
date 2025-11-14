<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Salary_pay extends BaseController {
	public function __construct(){
		parent::__construct();
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
	}
	
	//designation
	/* bkp code on 10-05-2021 */

	public function index(){
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
		$data=array();
		$id =($this->uri->getSegment(2))?$this->uri->getSegment(3):'';
		$data['js_flag']="salary_pay_js";
		$data['page_title']="Salary Payment Details";
		$datestring=date('Y-m-d').' first day of last month';
		$data['current_year']= $year = date('Y',strtotime($datestring)); 
		$data['current_month']= $month = date('m',strtotime($datestring));;
		if($this->request->getPost('salary_month_search')){
			$month=$this->request->getPost('bonus_month');
			$year=$this->request->getPost('bonus_year');
			$data['current_year']=$year; 
			$data['current_month']=$month;
			//return redirect()->to(base_url('salary_pay'));
		}
		$search="";
		$data['total_salary']=$this->Employee_Model->get_total_salary_pay($month,$year);
		if($id){
			$data['get_employee']= $this->Employee_Model->get_employee($id);
		}else{
			$id=1;
			$data['get_employee']= $this->Employee_Model->get_employee($id);
			
		}
		// $salary_all_details = $this->db->query("select * from salary_pay where  month='7' AND year='2020'")->result();
		$data['id']=$id;
		$data['menu']="salary_pay";
        $this->lib->view('administrator/salary_pay/list_salary_pay',$data);
		
	} 

	public function total_salary(){
		$data=array();
		$id =$this->uri->getSegment(3);
		$data['js_flag']="salary_pay_js";
		$data['page_title']="Salary Payment Details";
		$datestring=date('Y-m-d').' first day of last month';
		$data['current_year']= $year = date('Y',strtotime($datestring)); 
		$data['current_month']= $month = date('m',strtotime($datestring));
		$month=$this->request->getPost('bonus_month');
		$year=$this->request->getPost('bonus_year');
		$data['current_year']=$year; 
		$data['current_month']=$month;

// 		$file_exists = $_SERVER['DOCUMENT_ROOT'] . '/assets/salary_pay/Salary_' . date('F',strtotime('01-'.($month).'-'.$year)) . '_' . $year . '.txt';
		$file_exists = $_SERVER['DOCUMENT_ROOT'] . '/pay_txt/Salary_' . date('F',strtotime('01-'.($month).'-'.$year)) . '_' . $year . '.txt';
		$data['file_exists'] = (file_exists($file_exists))? "true" : "false" ;
		$search="";
		$data['total_salary']=$this->Employee_Model->get_total_salary_pay($month,$year);
		
		$data['menu']="salary_pay";
        echo json_encode($data);
	} 

	public function remove_deposit(){
		/* last Removed code on 10-05-2021 */
		$id=$_POST['employee_id'];
		$month=$_POST['month'];
		$year=$_POST['year'];

		$salary_all_details = $this->Deposit_Payment_Model->salary_all_details($id,$month,$year);
		$employee_details = $this->Employee_Model->get_employee_details($id);
		
		if(!isset($salary_all_details[0]->deposit)){
			$data_json['error'] = 'Undefined';
			echo json_encode($data_json);
			exit();
		}else{
			$this->change_deposit_status($id,$salary_all_details[0]->deposit);
		}
		$salary_deduction_list = $this->allfunction->salary_deduction($id,$month,$year);
		$deposit_amount=($salary_all_details[0]->basic_salary * 10) / 100;
		$current_month_deposit1=(isset($salary_deduction_list['deduction_amount']) && !empty($salary_deduction_list['deduction_amount'])) ? $salary_deduction_list['deduction_amount'] : 0;
		if(!empty($current_month_deposit1)){
			$net_salary=$salary_all_details[0]->net_salary - $salary_all_details[0]->deposit - $deposit_amount;
		}else{
			$net_salary=$salary_all_details[0]->net_salary - $salary_all_details[0]->deposit;
		}
		$deduction_pr_list = $salary_deduction_list['deduction_pr'];
		$deposit_data = $this->allfunction->total_deposit_data($id,$month,$year);
		$this->deposit_store($year,$month,$id,$deduction_pr_list,$deposit_data['current_month_deposit']);
		$data_json=array(
			'net_salary' => $salary_deduction_list['salary'],
			'salary' => $employee_details->salary,
			'amount_deduction' => $salary_deduction_list['deduction_amount'],
			'per_deduction' => $deduction_pr_list-$employee_details->salary_deduction,
			'deposit' => $salary_deduction_list['total_deposit'],
			'bonus' => $salary_all_details[0]->bonus,
			'payout_paid_leave' => $salary_all_details[0]->payout_paid_leave,
		);
		echo json_encode($data_json);
	}

	public function pay_deposit(){
		$employee_id=$_POST['employee_id'];
		$month=$_POST['month'];
		$year=$_POST['year'];

		$deposit= $this->Deposit_Model->deleteDeposit_by_monthYear($employee_id,$month,$year);
		$deposit_data = $this->allfunction->total_deposit_data($employee_id,$month,$year);
		echo  json_encode($deposit_data);
	}

	public function mail_smtp_send(){
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'smtp.googlemail.com',
			'smtp_port' => '465',
			'smtp_user' => 'jigneshageek435@gmail.com',
			'smtp_pass' => 'geek@1234',
			'mailtype'  => 'text', 
			'charset'   => 'utf-8'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$message2 = 'hello';
		 $subject="Test Email";
		 $message=$message2;
		  $this->email->from('jigneshageek435@gmail.com');
		  $this->email->to("jigu7032@gmail.com");
		  $this->email->subject($subject);
		  $this->email->message($message);
		  if($this->email->send())
		 {	
				echo "<script type='text/javascript'>alert('Email send success');</script>";
		 }
		 else
		{
		 show_error($this->email->print_debugger());
		}
	}
	
	public function mail_send($id,$month,$year){	
		//$id=8;
		$data=array();
		$data['month'] = $month; 
		$data['year'] = $year; 
		$data['employee_details']= $this->Employee_Model->get_employee($id);
		if(isset($data['employee_details'][0]) && !empty($data['employee_details'][0])){
         $filename=$_SERVER['DOCUMENT_ROOT'].'/assets/salary_slip_pdf/'.$data['employee_details'][0]->fname."_salary_slip";
		}else{
    		$filename="joining_letter";
    	}
		$get_salary_pay=$this->Leave_Request_Model->get_salary_pay($id,$month,$year);
		if(!empty($get_salary_pay)){
			
			$data['basic_salary']=$get_salary_pay[0]->basic_salary;
			$data['bonus']=$get_salary_pay[0]->bonus;
			$data['net_salary']=$get_salary_pay[0]->net_salary;
			$data['LOP']= $lop = $get_salary_pay[0]->deduction;
			$data['official_holiday']=$get_salary_pay[0]->official_holiday;
			$data['working_day']=$get_salary_pay[0]->working_day;
			$data['effective_day']=$get_salary_pay[0]->effective_day;
			if($get_salary_pay[0]->absent_leave == "0.00"){
				$data['full_day_count']=0; // Leave Days count
			}else{
				$data['full_day_count']=$get_salary_pay[0]->absent_leave; // Leave Days count
			}
			
			$data['salary_slip_percentage_deduction']=$get_salary_pay[0]->per_deduction;
			$data['deduction_per']= $salary_deduction = $get_salary_pay[0]->amount_deduction;
			$data['prof_tax']= $salary_slip_prof_tax = $get_salary_pay[0]->prof_tax;
			$data['PF']= $salary_slip_pf = $get_salary_pay[0]->prof_tax;
			//$data['total_deduction_right']="0";
			$data['total_deduction_right']= ($salary_deduction + $salary_slip_pf + $salary_slip_prof_tax + $lop);
		}
		$html = $this->load->view('administrator/employee/salary_slip_download',$data,true);
		
		$file=$this->mpdfgenerator->generate_save($html, $filename, true, 'A4', 'portrait');
		$file_name =$_SERVER['DOCUMENT_ROOT'].'/assets/salary_slip_pdf/service_ticket_file115354.pdf';
		
		$to = 'jigneshageek435@gmail.com';

		//sender
		$from = 'jigneshageek435@gmail.com';
		$fromName = 'Geekwebsolution';
		
		//email subject
		$subject = 'Salary Slip for November-2018'; 

		//attachment file path
		$file = $file_name;

		//email body content
		$htmlContent = 'Hello,<br/><br/>Kindly find attached salary slip.<br/><br/>Regards,<br/>Geek Web Solution<br/>';

		//header for sender info
		$headers = "From: $fromName"." <".$from.">";

		//boundary 
		$semi_rand = md5(time()); 
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

		//headers for attachment 
		$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

		//multipart boundary 
		$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .$htmlContent. "\n\n"; 

		//preparing attachment
		if(!empty($file) > 0){
			if(is_file($file)){
				$message .= "--{$mime_boundary}\n";
				$fp =    @fopen($file,"rb");
				$data =  @fread($fp,filesize($file));

				@fclose($fp);
				$data = chunk_split(base64_encode($data));
				$message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
				"Content-Description: ".basename($file)."\n" .
				"Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
				"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			}
		}
		$message .= "--{$mime_boundary}--";
		$returnpath = "-f" . $from;

		//send email
		$mail = mail($to, $subject, $message, $headers, $returnpath); 

		//email sending status
		echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>"; 
		
	}

	public function download_salary($month,$year){
		$year=2019;
		$month="October";
// 		 $file=base_url()."assets/salary_pay/Salary_".$month."_".$year.".txt";
		 $file=base_url()."pay_txt/Salary_".$month."_".$year.".txt";
		 	if(!$file){ // file does not exist
			die('file not found');
		  } else {
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$file");
			header("Content-Transfer-Encoding: binary");
			// read the file from disk
			readfile($file);
		  }
	}

	public function testing_popup(){
		$data=array();
		$id =$this->uri->getSegment(3);
		$data['js_flag']="salary_pay_jssdsd";
		$data['page_title']="Salary Payment Details";
		$data['current_year']=date('Y'); 
		$data['current_month']=date('n');
		if($this->request->getPost('salary_month_search')){
			$month=$this->request->getPost('bonus_month');
			$year=$this->request->getPost('bonus_year');
			$data['current_year']=$year; 
			$data['current_month']=$month;
		}
		
		
		$search="";
		if($id){
			$data['get_employee']= $this->Employee_Model->get_employee($id);
		}else{
			$id=1;
			$data['get_employee']= $this->Employee_Model->get_employee($id);
			
		}
		$data['get_bonus']="";
		if($this->uri->getSegment(4)){
			$bonus_id =$this->uri->getSegment(4);	
			$data['get_bonus']= $this->Bonus_Model->get_bonus($bonus_id);
		}
		
		$data['id']=$id;
		$data['menu']="salary_pay";
        $this->lib->view('administrator/salary_pay/test',$data);
	}

	public function get_report_attendance(){
		$data=array();
		$prof_tax = $this->allfunction->prof_tax($data);
	}

	public function salary_slip_download($data){
		$data=array(
				'month'=>$prev_month,
				'year'=>$year,
				'employee_id' => $user_session,
				'basic_salary' => $salary_slip_basic_salary,
				'bonus' => "0",
			);
		$employee_id=8;
		$month=10;
		$year=2019;
		$get_salary_pay_tbl=$this->Leave_Request_Model->get_salary_pay($user_session,$month,$year);
		if(!empty($get_salary_pay_tbl)){
			/* echo "<pre>";
			print_r($get_salary_pay_tbl);
			die; */
			$basic_salary=$get_salary_pay_tbl[0]->basic_salary;
			$bonus=$get_salary_pay_tbl[0]->bonus;
			$deposit=$get_salary_pay_tbl[0]->deposit;
			$net_salary=$get_salary_pay_tbl[0]->net_salary;
			$deduction=$get_salary_pay_tbl[0]->deduction;
			$prof_tax=$get_salary_pay_tbl[0]->prof_tax;
			$working_day=$get_salary_pay_tbl[0]->working_day;
			$official_holiday=$get_salary_pay_tbl[0]->official_holiday;
			$effective_day=$get_salary_pay_tbl[0]->effective_day;
			$paid_leave=$get_salary_pay_tbl[0]->paid_leave;
			$approve_leave=$get_salary_pay_tbl[0]->approve_leave;
			$unapproved_leave=$get_salary_pay_tbl[0]->unapproved_leave;
			$sick_leave=$get_salary_pay_tbl[0]->sick_leave;
			
		}else{
			$get_salary_slip=$this->Reports_Model->get_salary_slip($user_session,$prev_month_number,$year);
			$salary_slip_basic_salary=isset($get_salary_slip[0]->basic_salary) ? $get_salary_slip[0]->basic_salary : ""; 
			$data=array(
				'month'=>$prev_month,
				'year'=>$year,
				'employee_id' => $user_session,
				'basic_salary' => $salary_slip_basic_salary,
				'bonus' => "0",
			);
			$salary_all_details = $this->allfunction->salary_details($data);
			$basic_salary=$salary_all_details['basic_salary'];
			$bonus=$salary_all_details['bonus'];
			$deposit=$salary_all_details['deposit'];
			$net_salary=$salary_all_details['total_salary'];
			$deduction=$salary_all_details['total_deduction'];
			$prof_tax=$salary_all_details['prof_tax'];
			$working_day=$salary_all_details['working_day'];
			$official_holiday=$salary_all_details['official_holiday'];
			$effective_day=$salary_all_details['effective_day'];
			$paid_leave=$salary_all_details['paid_leave'];
			$approve_leave=$salary_all_details['approve_leave'];
			$unapproved_leave=$salary_all_details['unapproved_leave'];
			$sick_leave=$salary_all_details['sick_leave'];
		}
	}

	public function salary_all_details(){
		$month=$this->request->getPost('month');
		$year=$this->request->getPost('year');
		$employee_id=$this->request->getPost('employee_id');
		$basic_salary=$this->request->getPost('basic_salary');
		
		$bonus_tbl=$this->Bonus_Model->get_bonus_month($employee_id,$month,$year);
		$current_month_deposit=$this->Deposit_Payment_Model->current_month_deposit($employee_id,$month,$year);
		if(isset($current_month_deposit) && !empty($current_month_deposit)){
			$deposit_amount = $current_month_deposit->deposit_amount;
		}else{
			$deposit_amount = 0;
		}
		$get_salary_pay1=$this->Bonus_Model->get_salary_pay($employee_id,$month,$year);
		if(!empty($bonus_tbl)){
			$bonus=$bonus_tbl[0]->bonus;
		}else{
			$bonus=$this->request->getPost('bonus');
		}
		$get_salary_pay=$this->Leave_Request_Model->get_salary_pay($employee_id,$month,$year);
		if(empty($get_salary_pay)){
			
				$data=array(
				'month'=>$month,
				'year'=>$year,
				'employee_id' => $employee_id,
				'basic_salary' => $basic_salary,
				'bonus' => $bonus ,
			);
			$salary_all_details = $this->allfunction->salary_details($data);
			$salary_all_details['current_month_deposit'] = $deposit_amount;
			//echo "if";
			echo  json_encode($salary_all_details);
		}else{
			//echo "else";
			$salary_view_details = $this->allfunction->salary_view_details($get_salary_pay);
			$salary_view_details['current_month_deposit'] =$deposit_amount;
			$salary_view_details['deposit'] = $salary_view_details['deposit']-$get_salary_pay[0]->amount_deduction;
			//die;
			echo  json_encode($salary_view_details);
		}
		
		
	}

	public function get_salaryDetails(){

		$month=$this->request->getPost('month');
		$year=$this->request->getPost('year');
		$employee_id=$this->request->getPost('employee_id');
		$bonus_tbl=$this->Bonus_Model->get_bonus_month($employee_id,$month,$year);
		
		if(!empty($bonus_tbl)){
			$bonus=$bonus_tbl[0]->bonus;
		}else{
			$bonus=$this->request->getPost('bonus');
		}
		$employeeDetails=$this->Employee_Model->get_employee_details($employee_id);
		$get_salary_pay=$this->Leave_Request_Model->get_salary_pay($employee_id,$month,$year);
		$data_arr = array('month' => $month,'year' => $year,'employee_id' => $employee_id);
		$salary_all_details = $this->salarypayfunction->salary_pay($data_arr);
		if(empty($get_salary_pay)){
			$salary_all_details['bonus'] = $bonus;
			$salary_all_details['payment_status'] = 'unpaid';
			$salary_all_details['payout_paid_leave_checkbox'] = 'unchecked';
		}else{
			$salary_all_details['bonus'] = $get_salary_pay[0]->bonus;
			$salary_all_details['payment_status'] = 'paid';
			$salary_all_details['payout_paid_leave_checkbox'] = (!empty($get_salary_pay[0]->payout_paid_leave))? 'checked' : 'unchecked';
			$salary_all_details['net_salary'] += ($salary_all_details['payout_paid_leave_checkbox'] == 'checked')? $salary_all_details['payout_paid_leave_amount'] : 0;
		}
		$salary_all_details['qr_code'] = (isset($employeeDetails->qr_code) && !empty($employeeDetails->qr_code)) ?  '<a href="'.base_url().'assets/upload/qrcode/'.$employeeDetails->qr_code.'" data-fancybox="image_qrcode" class="btn btn-light btn-sm">QR Code <i class="fas fa-eye"></i></a>' : '';
		echo  json_encode($salary_all_details);
	}
	
	public function txt_file_update($month,$year){
		$time = strtotime("2019-".$month."-11");
		$final = date("m", strtotime("+1 month", $time));
		$month_name = date("F", mktime(0, 0, 0, $month, 10)); 
		$month_short_name = date("M", mktime(0, 0, 0, $month, 10));
// 		$filename =$_SERVER['DOCUMENT_ROOT'].'/assets/salary_pay/Salary_'.$month_name.'_'.$year.'.txt';
		$filename =$_SERVER['DOCUMENT_ROOT'].'/pay_txt/Salary_'.$month_name.'_'.$year.'.txt';
		$get_salary_pay_details=$this->Leave_Request_Model->get_salary_pay_txtfile_details($month,$year);
		$holiday_date=$year."-".$final."-8,".$year."-".$final."-9,".$year."-".$final."-10";
		$get_exists_holiday_date_row=$this->Holiday_Model->get_exists_holiday_date_row($holiday_date);
		if(!empty($get_exists_holiday_date_row)){
			foreach($get_exists_holiday_date_row as $hdate){
				$date=$year."-".$final."-10";
				if(date('N', strtotime($date)) >= 7){
					$day="9";
					$date1="2019-".$final."-08";
					$day1=date('D', strtotime($date1));
					if($day1  == "Fri"){
						if($date1 == $hdate->holiday_date){
							$day="11";
						}else{
							$day="8";
						}
					}
				}else{
					$day="10";
				}									
			}
		}else{
			$date=$year."-".$final."-10";
			if(date('N', strtotime($date)) >= 7){
				$day="9";
				$date1="2019-".$final."-8";
				$day1=date('D', strtotime($date1));
				if($day1  == "Fri"){
					$day="8";
				}
			}else{
				$day="10";
			}
		}
		$notpad="";
		$sum = 0;
		$count="0";
		if(!empty($get_salary_pay_details)){	
			
			$i=0;
			$c=array();
			
			foreach($get_salary_pay_details as $salary){
				
				if(!empty($salary->account_number) && !empty($salary->ifsc_number)){
					$c[]=$i;
					$net_salary=$salary->net_salary;
					$sum+= $salary->net_salary;
					
					if(strstr($salary->ifsc_number,"ICI")){
						$notpad.="MCW|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".round($salary->net_salary)."|INR|".$month_short_name." ".$year." Salary|".$salary->ifsc_number."|WIB^\n";
					}else{
						$notpad.="MCO|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".round($salary->net_salary)."|INR|".$month_short_name." ".$year." Salary"."|NFT|".$salary->ifsc_number."^\n";
					}
				}
			}
			$count=count($c);
		}
		$employee_salary=$sum;
		$line_count=$count + 1;
		$current_year=date('Y');
		$notpad1="FHR|".$line_count."|".$final."/".$day."/".$current_year."|Cut-off|".$employee_salary."|INR|340005500787|0011^\n".
		"MDR|340005500787|0011|587608349|".$employee_salary."|INR|".$month_short_name." ".$year." Salary|ICIC0000011|WIB^\n"
			.trim($notpad);	
// 		$notpad1="FHR|".$line_count."|".$final."/".$day."/".$current_year."|Cut-off|".$employee_salary."|INR|624605065816|0011^\n".
// 		"MDR|624605065816|0011|GEEKWEBS28012017|".$employee_salary."|INR|".$month_short_name." ".$year." Salary|ICIC0000011|WIB^\n"
// 			.trim($notpad);	
		  if (!file_exists($filename)) {
			$handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle);
			return redirect()->to(base_url().'pay_txt/Salary_'.$month_name.'_'.$year.'.txt');
        }else{
			$handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle); 
			return redirect()->to(base_url().'pay_txt/Salary_'.$month_name.'_'.$year.'.txt');
		}  
	}

	public function upi_txt_file_update($month,$year){
		$time = strtotime("2019-".$month."-11");
		$final = date("m", strtotime("+1 month", $time));
		$month_name = date("F", mktime(0, 0, 0, $month, 10)); 
		$month_short_name = date("M", mktime(0, 0, 0, $month, 10));
// 		$filename =$_SERVER['DOCUMENT_ROOT'].'/assets/salary_pay/Salary_'.$month_name.'_'.$year.'.txt';
		$filename =$_SERVER['DOCUMENT_ROOT'].'/pay_txt/Salary_'.$month_name.'_'.$year.'.txt';
		$get_salary_pay_details=$this->Leave_Request_Model->get_salary_pay_txtfile_details($month,$year);
		$holiday_date=$year."-".$final."-8,".$year."-".$final."-9,".$year."-".$final."-10";
		$get_exists_holiday_date_row=$this->Holiday_Model->get_exists_holiday_date_row($holiday_date);
		if(!empty($get_exists_holiday_date_row)){
			foreach($get_exists_holiday_date_row as $hdate){
				$date=$year."-".$final."-10";
				if(date('N', strtotime($date)) >= 7){
					$day="9";
					$date1="2019-".$final."-08";
					$day1=date('D', strtotime($date1));
					if($day1  == "Fri"){
						if($date1 == $hdate->holiday_date){
							$day="11";
						}else{
							$day="8";
						}
					}
				}else{
					$day="10";
				}									
			}
		}else{
			$date=$year."-".$final."-10";
			if(date('N', strtotime($date)) >= 7){
				$day="9";
				$date1="2019-".$final."-8";
				$day1=date('D', strtotime($date1));
				if($day1  == "Fri"){
					$day="8";
				}
			}else{
				$day="10";
			}
		}
		$notpad="";
		$sum = 0;
		$count="0";
		if(!empty($get_salary_pay_details)){	
			
			$i=0;
			$c=array();
			
			foreach($get_salary_pay_details as $salary){
				
				if(!empty($salary->account_number) && !empty($salary->ifsc_number)){
					$c[]=$i;
					$net_salary=$salary->net_salary;
					$sum+= $salary->net_salary;
					
					if(strstr($salary->ifsc_number,"ICI")){
						// $notpad.="MCW|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".round($salary->net_salary)."|INR|".$month_short_name." ".$year." Salary|".$salary->upi_id."|WIB^\n";
						$notpad.="MCW|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".round($salary->net_salary)."|INR|".$month_short_name." ".$year." Salary|".$salary->ifsc_number."|WIB^\n";
					}else{
						// $notpad.="MCO|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".round($salary->net_salary)."|INR|".$month_short_name." ".$year." Salary"."|NFT|".$salary->upi_id ."^\n";
						$notpad.="MCO|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".round($salary->net_salary)."|INR|".$month_short_name." ".$year." Salary"."|NFT|".$salary->ifsc_number."^\n";
					}
				}
			}
			$count=count($c);
		}
		$employee_salary=$sum;
		$line_count=$count + 1;
		$current_year=date('Y');
		$notpad1="FHR|".$line_count."|".$final."/".$day."/".$current_year."|Cut-off|".$employee_salary."|INR|340005500787|0011^\n".
		"MDR|340005500787|0011|587608349|".$employee_salary."|INR|".$month_short_name." ".$year." Salary|ICIC0000011|WIB^\n"
			.trim($notpad);	
		  if (!file_exists($filename)) {
			$handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle);
			return redirect()->to(base_url().'pay_txt/Salary_'.$month_name.'_'.$year.'.txt');
        }else{
			$handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle); 
			return redirect()->to(base_url().'pay_txt/Salary_'.$month_name.'_'.$year.'.txt');
		}  
	}
	
	public function change_deposit_status($id,$deposit){
		$deposits=$this->Deposit_Payment_Model->get_deposit_list($id,'paid');
		$deposit_amount = 0;
		$status_change = '';
		foreach($deposits as $d){
			$deposit_amount += $d->deposit_amount;
			if($deposit_amount <= $deposit){
				$update_status=array(
					'id' => $d->id,
					'payment_status' => 'pending',
					'updated_date' => date('Y-m-d h:i:s')
				);
				$status_change = $this->Deposit_Payment_Model->update_deposit_by_empId($id,$update_status);
			}
		}
		if($status_change){
			$employee=array('salary_deduction' => 100,'id' => $id);
			$this->Employee_Model->update_employee($employee);
		}
	}

	public function insert_data(){
		$employee_id = $this->request->getPost('id');
		$id = $this->request->getPost('id');
		$month = $this->request->getPost('month');
		$year = $this->request->getPost('year');
		$bonus = round($this->request->getPost('bonus'));
		$total_working_day = $this->request->getPost('total_working_day');
		$diposit_status = $this->request->getPost('diposit_status');
		$total_official_holiday = $this->request->getPost('total_official_holiday');
		$total_effective_day = $this->request->getPost('total_effective_day');
		$total_absent_leave = $this->request->getPost('total_absent_leave');
		$total_unpaid_leave = $this->request->getPost('total_unpaid_leave');
		$total_approved_leave = $this->request->getPost('total_approved_leave');
		$total_paid_leave = $this->request->getPost('total_paid_leave');
		$total_sick_leave = $this->request->getPost('total_sick_leave');
		$total_unapproved_leave = $this->request->getPost('total_unapproved_leave');
		$basic_salary = $this->request->getPost('basic_salary');
		$total_deduction = $this->request->getPost('total_deduction');
		$skip_paid_leave = $this->request->getPost('skip_paid_leave');
		$submit_status = $this->request->getPost('skip_paid_leave');


		$total_net_salary1 = str_replace(array(",", "-"), array("", ""), $this->request->getPost('total_net_salary'));
		$total_net_salary = round($total_net_salary1);
		$total_prof_tax = $this->request->getPost('total_prof_tax');
		$per_val = $this->request->getPost('per_val');
		$total_leave = $this->request->getPost('total_leave');
		$payment_status = $this->request->getPost('payment_status');
		$total_deposit = $this->request->getPost('total_deposit');
		$res = preg_replace("/[^0-9.]/", "", $per_val);
		$total_deduction_per = str_replace(array(",", "-"), array("", ""), $this->request->getPost('total_deduction_per'));
		$prof_tax = str_replace(array(",", "-"), array("", ""), $total_prof_tax);
		$total_deduction_per_new = str_replace(array(",", "-"), array("", ""), $total_deduction_per);
		$total_deduction_new = str_replace(array(",", "-"), array("", ""), $total_deduction);
		$basic_salary_new = str_replace(array(",", "-"), array("", ""), $basic_salary);
		$get_salary_pay = $this->Leave_Request_Model->get_salary_pay($id, $month, $year);
		$payout_paid_leave_status = $this->request->getPost('payout_paid_leave_status');

		$salary_all_details = $this->Deposit_Payment_Model->salary_all_details($id, $month, $year);
		// $salary_all_details[0]->deposit
		if (isset($salary_all_details) && !empty($salary_all_details)) {
			$deposit = $salary_all_details[0]->deposit;
		} else {
			$deposit = 0;
		}
		if (empty($total_deposit)) {
			$total_deposit = 0;
			if (!empty($get_salary_pay)) {
				$total_deposit = $get_salary_pay[0]->deposit;
			}
		}

		$paid_leave_status = "rejected";
		if (intval($total_effective_day) >= 7) {
			$paid_leave_status = "used";
		} else {
			$total_paid_leave = "0";
		}
		if (!empty($total_deposit)) {
			$salary_deduction_list = $this->allfunction->salary_deduction($id, $month, $year);
			$current_month_deposit1 = (isset($salary_deduction_list['deduction_amount']) && !empty($salary_deduction_list['deduction_amount'])) ? $salary_deduction_list['deduction_amount'] : 0;
			$payout_paid_leave_1 = (isset($get_salary_pay[0]->payout_paid_leave) && !empty($get_salary_pay[0]->payout_paid_leave)) ? $get_salary_pay[0]->payout_paid_leave : 0;
			if(empty($get_salary_pay)){
				$deposit = $salary_deduction_list['total_deposit'];
			}else{
				if(!empty($get_salary_pay[0]->deposit)){
					$deposit = $get_salary_pay[0]->deposit;
				}else{
					$deposit = $salary_deduction_list['total_deposit'];
				}
			}
			$t = $total_deduction_new  + $prof_tax;
			if ($payout_paid_leave_status == 'check') {
				if ($diposit_status == 'paid') {
					$salary_cal = (($basic_salary_new - $t) + $bonus + $deposit + $payout_paid_leave_1);
				} else {
					$salary_cal = (($basic_salary_new - $t) + $bonus + $payout_paid_leave_1) - $current_month_deposit1;
				}
			} else {
				if ($diposit_status == 'paid') {
					$salary_cal = (($basic_salary_new - $t) + $bonus + $deposit);
				} else {
					$salary_cal = (($basic_salary_new - $t) + $bonus) - ($current_month_deposit1);
				}
			}
		} else {

			$payout_paid_leave_1 = (isset($get_salary_pay[0]->payout_paid_leave) && !empty($get_salary_pay[0]->payout_paid_leave)) ? $get_salary_pay[0]->payout_paid_leave : 0;

			//echo "else";
			$t = $total_deduction_new + $total_deduction_per_new + $prof_tax;
			if ($payout_paid_leave_status == 'check') {
				$salary_cal = ($basic_salary_new - $t) + $bonus + $payout_paid_leave_1;
			} else {
				$salary_cal = (($basic_salary_new - $t) + $bonus);
			}
		}
		if ($total_effective_day == '0') {
			$salary_cal = 0;
		}
		// echo $salary_cal;
		//die;
		$get_employee = $this->Employee_Model->get_employee($id);


		//txt file
		$config_unapproved_leave = Unapproved_Leave;
		$t = $total_leave + ($total_unapproved_leave * $config_unapproved_leave);
		$remaing_paid_leave = "";
		if ($t >= $total_paid_leave) {
			$remaing_paid_leave = $get_employee[0]->monthly_paid_leave - $total_paid_leave;
		}
		if ($diposit_status == 'pending' && $deposit > 0) {
			$total_deposit = 0;
		} else {
			$update_status = array(
				'payment_status' => 'paid',
				'updated_date' => date('Y-m-d h:i:s')
			);
			$this->Deposit_Payment_Model->update_deposit_by_empId($id, $update_status);
		}
		$arr = array(
			'employee_id' => $id,
			'year' => $year,
			'month' => $month,
			'basic_salary' => str_replace(",", "", $basic_salary),
			'bonus' => str_replace(array(",", "+"), array("", ""), $bonus),
			'net_salary' => $salary_cal,
			'deduction' => str_replace(array(",", "-"), array("", ""), $total_deduction),
			'deposit' => $total_deposit,
			'per_deduction' => $res,
			'amount_deduction' => str_replace(array(",", "-"), array("", ""), $total_deduction_per),
			'prof_tax' => str_replace(array(",", "-"), array("", ""), $total_prof_tax),
			'working_day' => $total_working_day,
			'official_holiday' => $total_official_holiday,
			'effective_day' => $total_effective_day,
			'paid_leave' => $total_paid_leave,
			'approve_leave' => $total_approved_leave,
			'unapproved_leave' => $total_unapproved_leave,
			'absent_leave' => $total_absent_leave,
			'sick_leave' => $total_sick_leave,
			'total_leaves' => $total_leave,
			'payment_status' => $payment_status,
			'created_date' => date('Y-m-d h:i:s'),
		);
		/* payout_paid_leave  */
		/* */
		$salary_deduction_list = $this->allfunction->salary_deduction($id, $month, $year);
		$pr_salary_deduction = ((100 - $salary_deduction_list['change_pr']) < 0 || (100 - $salary_deduction_list['change_pr']) >= 100) ? 0 : (100 - $salary_deduction_list['change_pr']);
		$total_deposit_list = $salary_deduction_list['total_deposit'];
		$deduction_pr_list = $salary_deduction_list['deduction_pr'];
		$deduction_amount_list = $salary_deduction_list['deduction_amount'];
		/* */

		if (empty($get_salary_pay)) {
			$salary_pay = $this->db->insert('salary_pay', $arr);
			$salary_pay_insert = "insert";
		} else {
			$salary_pay_insert = "update";
			$index_id = $get_salary_pay[0]->id;
			$this->db->where('id', $index_id);
			$salary_pay = $this->db->update('salary_pay', $arr);
			//	print_r($arr);
			//die;
		}

		if ($salary_pay) {
			if (!empty($total_deposit)) {
				$update_status = array(
					'payment_status' => 'paid',
					'updated_date' => date('Y-m-d h:i:s')
				);
				$this->db->where('employee_id', $id);
				$this->db->update('deposit', $update_status);
				//deposit
				$employee = array(
					'salary_deduction' => '0',
				);
				$this->db->where('id', $id);
				$this->db->update('employee', $employee);
			} else {
				$employee = array('salary_deduction' => $pr_salary_deduction);
				$this->db->where('id', $id);
				$this->db->update('employee', $employee);

				$salary_deduction = $get_employee[0]->salary_deduction;
				$employee_status = $get_employee[0]->employee_status;
				if (!empty($salary_deduction) && $salary_deduction != 0 && $employee_status == "employee") {
					//$deposit_amount=($get_employee[0]->salary * $salary_deduction) / 100;
					// $this->deposit_store($year,$month,$id,$salary_deduction,$deposit_amount);
					$this->deposit_store($year, $month, $id, $deduction_pr_list, $deduction_amount_list);
				}
			}
			if ($payment_status == "paid") {
				// salary_deduction code
				if ($get_employee[0]->employed_date != "" && $get_employee[0]->employed_date != "0000-00-00") {
					$new_date = strtotime(Format_date($get_employee[0]->employed_date) . " +1 year");
					$next_increment_date = date('Y-m-d', $new_date);
					$month2 = date('m', $new_date);
					$year2 = date('Y', $new_date);

					if ($month2  == $month && $year2 == $year) {
						$startTimeStamp = strtotime(date('Y-m-01', $new_date));
						$endTimeStamp = strtotime($next_increment_date);
						$timeDiff = abs($endTimeStamp - $startTimeStamp);
						$numberDays = $timeDiff / 86400;
						$numberDays = intval($numberDays) + 1;
						if ($numberDays <= 10) {
							$arr = array(
								'id' => $id,
								'salary_deduction' => 0,
							);
							$insert_employee = $this->Employee_Model->update_employee($arr);
						} else {
							$next_month = date('m', $new_date);
							$new_date1 = strtotime(Format_date($next_increment_date) . " +1 month");
							$next_month_number = date('m', $new_date1);
							$next_year_number = date('Y', $new_date1);
							$select_month = date("m", mktime(0, 0, 0, $month, 10));
							if ($select_month  == $next_month_number && $next_year_number == $year) {
								$arr = array(
									'id' => $id,
									'salary_deduction' => 0,
								);
								$insert_employee = $this->Employee_Model->update_employee($arr);
							}
						}
					}
				}

				//txt file generate
				$this->txt_file_data_store($month, $year, $id);
				if ($salary_pay_insert == "insert") {
					if ($total_leave == "0") {
						if ($total_effective_day != "0" && $total_effective_day != "0.00") {
							$plus_paid_leave = $get_employee[0]->monthly_paid_leave + 1;
						} else {
							$plus_paid_leave = $get_employee[0]->monthly_paid_leave;
							$get_salary_pay = $this->Leave_Request_Model->get_salary_pay($id, $month, $year);
							$arr2 = array(
								'paid_leave' => '1',
							);
							$index_id = $get_salary_pay[0]->id;
							$this->db->where('id', $index_id);
							$this->db->update('salary_pay', $arr2);
						}
					} else {
						if ($total_effective_day != "0" && $total_effective_day != "0.00") {
							$plus_paid_leave = 1 + $remaing_paid_leave;
						} else {
							$plus_paid_leave = $remaing_paid_leave;
						}
					}
					if ($skip_paid_leave != '1') {
						if ($paid_leave_status == "used") {
							$this->add_new_paid_leave($month, $year, $id, $total_paid_leave);
							$leave_update = array(
								'monthly_paid_leave' => $plus_paid_leave
							);
							$this->db->where('id', $id);
							$this->db->update('employee', $leave_update);
						} else {
							$this->reject_paid_leave($month, $year, $id);
						}
					} else {
						$skip_paid_leave_update = array(
							'skip_paid_leave' => '1'
						);
						$this->db->where('id', $id);
						$this->db->update('employee', $skip_paid_leave_update);
					}
					if ($payout_paid_leave_status == 'check') {
						$leave_list = array('employee_id' => $employee_id);
						$leave_list_count = $this->allfunction->employee_leave_count($leave_list);
						$remaing_paid_leave_total = $leave_list_count['remaing_paid_leave'];
						$salary_average_total = $this->allfunction->salary_average_total($employee_id);
						if (!empty($salary_average_total) && isset($salary_average_total['average_amount'])) {
							$paid_leave_perday = $this->allfunction->paid_leave_perday($salary_average_total['average_amount']);
							$paid_leave_days = $remaing_paid_leave_total - $total_paid_leave;
							if ($paid_leave_days > 0) {

								$payout_paid_leave = round($paid_leave_perday * $paid_leave_days);
								$payout_paid_leave_days = $paid_leave_days;
								$this->payout_paid_leave($month, $year, $employee_id);
								$get_salary_pay = $this->Leave_Request_Model->get_salary_pay($id, $month, $year);
								$arr3 = array(
									'payout_paid_leave' => $payout_paid_leave,
									'net_salary' => ($salary_cal + $payout_paid_leave),
								);
								$index_id = $get_salary_pay[0]->id;
								$this->db->where('id', $index_id);
								$this->db->update('salary_pay', $arr3);

								echo "insert check";
							}
						}
					}
				}else{
					$get_salary_pay = $this->Leave_Request_Model->get_salary_pay($id, $month, $year);
					if ($payout_paid_leave_status == 'uncheck') {
						$arr3 = array(
							'payout_paid_leave' => 0,
							'net_salary' => ($salary_cal),
						);
						$index_id = $get_salary_pay[0]->id;
						$this->db->where('id', $index_id);
						$this->db->update('salary_pay', $arr3);
						$this->payout_paid_leave_remove($month, $year, $employee_id);
						// echo "uncheck";
						//print_r($arr3);
			

						$employee_month_paid_leaves = $this->Leave_Report_Model->employee_paid_leaves($employee_id, 'paid');
						if (!empty($employee_month_paid_leaves)) {
							foreach ($employee_month_paid_leaves as $status) {
								if ($month == $status->used_leave_month) {
									$status_update = array(
										'status' => 'unused',
										'used_leave_month' => 0,
									);
									$this->db->where('id', $status->id);
									$this->db->where('employee_id', $emp_id);
									$this->db->update('employee_paid_leaves', $status_update);
								}
							}
						}
					}else{
						$leave_list = array('employee_id' => $employee_id);
						$leave_list_count = $this->allfunction->employee_leave_count($leave_list);
						$remaing_paid_leave_total = $leave_list_count['remaing_paid_leave'];
						$salary_average_total = $this->allfunction->salary_average_total($employee_id);
						if (isset($get_salary_pay) && empty($get_salary_pay[0]->payout_paid_leave)) {
							if (!empty($salary_average_total) && isset($salary_average_total['average_amount'])) {
								$paid_leave_perday = $salary_average_total['average_amount'] / $total_working_day;
								$paid_leave_days = $remaing_paid_leave_total - $total_paid_leave;
								if ($paid_leave_days > 0) {
									$payout_paid_leave = round($paid_leave_perday * $paid_leave_days);
									$payout_paid_leave_days = $paid_leave_days;
									$this->payout_paid_leave($month, $year, $employee_id);

									$arr3 = array(
										'payout_paid_leave' => $payout_paid_leave,
										'net_salary' => ($salary_cal + $payout_paid_leave),
									);
									// echo "check";
									//print_r($arr3);
									$index_id = $get_salary_pay[0]->id;
									$this->db->where('id', $index_id);
									$this->db->update('salary_pay', $arr3);
								}
							}
						}
					}
				}
			}
			echo "1";
		}
	}

	public function salaryDataInsert(){
		$employee_id = $this->request->getPost('id');
		$id = $this->request->getPost('id');
		$month = $this->request->getPost('month');
		$year = $this->request->getPost('year');
		$bonus = round($this->request->getPost('bonus'));
		$deposit_status = $this->request->getPost('diposit_status');
		$skip_paid_leave = $this->request->getPost('skip_paid_leave');
		$payment_status = $this->request->getPost('payment_status');
		$payout_paid_leave_status = $this->request->getPost('payout_paid_leave_status');
		$get_salary_pay = $this->Leave_Request_Model->get_salary_pay($id, $month, $year);
		$data_arr = array('month' => $month,'year' => $year,'employee_id' => $id);
		if ($deposit_status != 'pending') {
			$this->Deposit_Model->deleteDeposit_by_monthYear($employee_id,$month,$year);
		}
		$salary_pay=$this->salarypayfunction->salary_pay($data_arr);
		$salary_cal = $bonus+$salary_pay['net_salary'];
		$total_deposit = 0;
		if (!empty($get_salary_pay)) {
			$total_deposit = $get_salary_pay[0]->deposit;
		}
		if ($deposit_status == 'pending') {
			$salary_cal = $salary_cal-$total_deposit;
			// $salary_cal = $salary_cal-$salary_pay['thisMonth_deduction'];
			$total_deposit = 0;
		} else {
			// $salary_cal += $salary_pay['thisMonth_deduction'];
			$total_deposit = $salary_pay['total_deposit'];
			$salary_pay['deduction_amount'] = $salary_pay['deduction_percentage'] = $salary_pay['change_percentage'] = 0;
			$update_status = array(
				'payment_status' => 'paid',
				'updated_date' => date('Y-m-d h:i:s')
			);
			$this->Deposit_Payment_Model->update_deposit_by_empId($id, $update_status);
		}
		$payout_paid_leave_amount=($payout_paid_leave_status == 'check')? $salary_pay['payout_paid_leave_amount'] : 0;
		$salary_cal += (isset($salary_pay['status_of_deposit']) && $salary_pay['status_of_deposit'] != 'paid') ? $total_deposit : 0;
		$salary_cal += $payout_paid_leave_amount;
		$paid_leave_status = "used";
		/* $paid_leave_status = "rejected";
		if (intval($salary_pay['total_present_days']) >= 7) {
			$paid_leave_status = "used";
		} else {
			$total_paid_leave = "0";
		} */
		$p=$salary_pay['paid_leave'];
		$arr = array(
			'employee_id' => $id,
			'year' => $year,
			'month' => $month,
			'basic_salary' => $salary_pay['basic_salary'],
			'bonus' => $bonus,
			'net_salary' => round($salary_cal),
			'deduction' => $salary_pay['total_leave_deduction'],
			'deposit' => $total_deposit,
			'per_deduction' => $salary_pay['deduction_percentage'],
			'amount_deduction' => $salary_pay['deduction_amount'],
			'prof_tax' => $salary_pay['prof_tax'],
			'working_day' => $salary_pay['total_working_days'],
			'official_holiday' => $salary_pay['total_holiday_days'],
			'effective_day' => $salary_pay['total_present_days'],
			'paid_leave' => $salary_pay['paid_leave'],
			'approve_leave' => $salary_pay['approved_leaves'],
			'unapproved_leave' => $salary_pay['unapproved_leave'],
			'absent_leave' => $salary_pay['total_leaves'],
			'payout_paid_leave' => $payout_paid_leave_amount,
			'sick_leave' => $salary_pay['sick_leave'],
			'total_leaves' => $salary_pay['approved_leaves']+$salary_pay['unapproved_leave']+$salary_pay['sick_leave'],
			'payment_status' => $payment_status,
		);
		
		if (empty($get_salary_pay)) {
			$arr['created_date'] = date('Y-m-d h:i:s');
			$salarypay = $this->Salary_Pay_Model->insert_data($arr);
			$salary_pay_insert = $salarypay?"inserted":'insert';
			// $salary_pay_insert = "inserted";
		} else {
			$arr['updated_date'] = date('Y-m-d h:i:s');
			$arr['id'] =  $get_salary_pay[0]->id;
			$salarypay = $this->Salary_Pay_Model->update_data($arr);
			$salary_pay_insert = $salarypay?"updated":'update';
			// $salary_pay_insert = "updated";
		}
		$deduction_pr_list = $salary_pay['deduction_percentage'];
		$get_employee = $this->Employee_Model->get_employee($id);
		if (!empty($get_employee[0]->salary_deduction) && $get_employee[0]->salary_deduction != 0 && $salary_pay['employee_status'] == "employee" && $deposit_status == 'pending') {
			$this->deposit_store($year, $month, $id, $deduction_pr_list, $salary_pay['deduction_amount']);
		}
		$pr_salary_deduction = ((100 - $salary_pay['change_percentage']) <= 0 || (100 - $salary_pay['change_percentage']) >= 100) ? 0 : (100 - $salary_pay['change_percentage']);
		$employee = array('id' => $id,'salary_deduction' => $pr_salary_deduction);
		$this->Employee_Model->update_employee($employee);
		//txt file generate
		$this->txt_file_data_store($month, $year, $id);
		if ($salary_pay_insert == "inserted") {
			if ($skip_paid_leave != 'check') {
				if ($paid_leave_status == "used" && $salary_pay['employee_status'] == 'employee') {
					$this->add_new_paid_leave($month, $year, $id, $p);
				} else {
					$this->reject_paid_leave($month, $year, $id,$salary_pay['employee_status']);
				}	
			} else {
				$skip_paid_leave_update = array(
					'id' => $id,
					'skip_paid_leave' => '1'
				);
				$this->Employee_Model->update_employee($skip_paid_leave_update);
			}
		}else{
			if(!empty($get_salary_pay) && !empty($get_salary_pay[0]->deposit) && $deposit_status == 'pending') {
				$this->change_deposit_status($id,$get_salary_pay[0]->deposit);
			}
		}
		if($payout_paid_leave_status == 'uncheck'){
			$this->payout_paid_leave_remove($month, $year, $employee_id);
			/* $employee_month_paid_leaves = $this->Leave_Report_Model->employee_paid_leaves($employee_id, 'paid');
			if (!empty($employee_month_paid_leaves)) {
				foreach ($employee_month_paid_leaves as $status) {
					if ('paid' == $status->status) {
						$status_update = array(
							'id' => $status->id,
							'employee_id' => $employee_id,
							'status' => 'unused',
							'used_leave_month' => 0,
						);
						$this->Leave_Report_Model->update_employee_paid_leave($status_update);
					}
				}
			} */
		}
		if($payout_paid_leave_status == 'check'){
			$this->payout_paid_leave($month, $year, $employee_id);
		}
		if(isset($salary_pay_insert) && !empty($salary_pay_insert)){
			$data['error_code'] = 0;
			$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Salary pay data '.$salary_pay_insert.'.</p></div></div></div>';
		}else{
			$data['error_code'] = 1;
			$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Salary pay data field to '.$salary_pay_insert.'.</p></div></div></div>';
		}
		echo json_encode($data);
	}

	public function monthly_paid_leave_change($plus_paid_leave){
		$leave_update=array(
			'monthly_paid_leave' => $plus_paid_leave
		);
		$this->db->table('employee')->where('id',$id);
		$this->db->update($leave_update);
	}

	public function reject_paid_leave($month,$year,$emp_id,$status='employee'){
		$status_update=array(
			'employee_id' => $emp_id,
			'month' => $month,
			'year' => $year,
			'status' => 'rejected',
			'used_leave_month' => $month,
			'used_leave_year' => $year,
			'updated_date' => date('Y-m-d h:i:s')
		);
		$this->Paid_Leave_Model->update_byMonthYear($status_update);
		$next = date("Y-m-d", mktime(0, 0, 0, $month, 10,$year));
		$next_month = date('m', strtotime('+1 month', strtotime($next)));
		
		$employee_month_paid_leaves=$this->Leave_Report_Model->employee_month_paid_leaves($next_month,$year,$emp_id);
		
		if(empty($employee_month_paid_leaves) && $status == 'employee'){
			$leave_update=array(
				'employee_id' => $emp_id,
				'leave' => 1,
				'month' => $next_month,
				'year' => $year,
				'status' => 'unused',
				'used_leave_month' => 0,
				'updated_date' => date('Y-m-d h:i:s')
			);
			// $this->Paid_Leave_Model->insert_data('employee_paid_leaves',$leave_update); 
			$this->Paid_Leave_Model->insert_data($leave_update);
		}
	}

	public function payout_paid_leave($month,$year,$emp_id){
		
			$employee_paid_unused=$this->Leave_Report_Model->employee_paid_leaves($emp_id,'unused');
			$unused_paid_leaves = $this->Paid_Leave_Model->get_nextMonth_paidLeave($emp_id,'unused',$month,$year);
				if(!empty($employee_paid_unused)){
					foreach($employee_paid_unused as $status){
						if(empty($unused_paid_leaves) || $unused_paid_leaves[0]->id !== $status->id){
							$status_update=array(
								'id' => $status->id,
								'employee_id' => $emp_id,
								'status' => 'paid',
								'used_leave_month' => $month,
								'used_leave_year' => $year,
								'updated_date' => date('Y-m-d h:i:s')
							);
							$this->Paid_Leave_Model->update_data($status_update); 
						}
					}
				}
	
	}
	
	public function payout_paid_leave_remove($month,$year,$emp_id){
				$employee_month_paid_leaves=$this->Leave_Report_Model->employee_paid_leaves($emp_id,'paid');
				if(!empty($employee_month_paid_leaves)){
					foreach($employee_month_paid_leaves as $status){
						if($month == $status->used_leave_month && $year == $status->used_leave_year){
							$status_update=array(
								'id' => $status->id,
								'employee_id' => $emp_id,
								'status' => 'unused',
								'used_leave_month' => 0,
								'updated_date' => date('Y-m-d h:i:s')
							);
							$this->Paid_Leave_Model->update_data($status_update);  
						}
					}
				}
	}

	public function add_new_paid_leave($month,$year,$emp_id,$paid_leave){
		$year1 = $year;
		if($month == 12) $year = $year+1;
		$next = date("Y-m-d", mktime(0, 0, 0, $month, 10,$year));
		$next_month = date('m', strtotime('+1 month', strtotime($next)));
		$employee_month_paid_leaves=$this->Leave_Report_Model->employee_month_paid_leaves($next_month,$year,$emp_id);
		
		if(empty($employee_month_paid_leaves)){
			/*  update status */
			if(!empty($paid_leave) && $paid_leave > 0){
				$employee_paid_unused=$this->Leave_Report_Model->employee_paid_leaves($emp_id,'unused',$paid_leave);
				if(!empty($employee_paid_unused)){
					foreach($employee_paid_unused as $status){
						$status_update=array(
							'id' => $status->id,
							'employee_id' => $emp_id,
							'status' => 'used',
							'used_leave_month' => $month,
							'used_leave_year' => $year1,
							'updated_date' => date('Y-m-d h:i:s')
						);
						$this->Paid_Leave_Model->update_data($status_update); 
					}
				} 
			}
			/*  insert new paid leave */
			$leave_update=array(
				'employee_id' => $emp_id,
				'leave' => 1,
				'month' => $next_month,
				'year' => $year,
				'status' => 'unused',
				'used_leave_month' => 0
			);
			$this->Paid_Leave_Model->insert_data($leave_update);
		}
	}

	public function txt_file_data_store($month,$year,$id){
		$time = strtotime("2019-".$month."-11");
		$final = date("m", strtotime("+1 month", $time));
		$get_employee=$this->Employee_Model->get_employee($id);
		$month_name = date("F", mktime(0, 0, 0, $month, 10)); 
		$month_short_name = date("M", mktime(0, 0, 0, $month, 10));
		$filename =$_SERVER['DOCUMENT_ROOT'].'/pay_txt/Salary_'.$month_name.'_'.$year.'.txt';
		$get_salary_pay_details=$this->Leave_Request_Model->get_salary_pay_details($month,$year);
		$holiday_date=$year."-".$final."-8,".$year."-".$final."-9,".$year."-".$final."-10";
		$get_exists_holiday_date_row=$this->Holiday_Model->get_exists_holiday_date_row($holiday_date);
		if(!empty($get_exists_holiday_date_row)){
			foreach($get_exists_holiday_date_row as $hdate){
				$date=$year."-".$final."-10";
				if(date('N', strtotime($date)) >= 7){
					$day="9";
					$date1="2019-".$final."-08";
					$day1=date('D', strtotime($date1));
					if($day1  == "Fri"){
						if($date1 == $hdate->holiday_date){
							$day="11";
						}else{
							$day="8";
						}
					}
				}else{
					$day="10";
				}									
			}
		}else{
			$date=$year."-".$final."-10";
			if(date('N', strtotime($date)) >= 7){
				$day="9";
				$date1="2019-".$final."-8";
				$day1=date('D', strtotime($date1));
				if($day1  == "Fri"){
					$day="8";
				}
			}else{
				$day="10";
			}
		}
		$notpad="";
		$sum = 0;
		$count="0";
		if(!empty($get_salary_pay_details)){	
			
			$i=0;
			$c=array();
			foreach($get_salary_pay_details as $salary){
				
				if(!empty($salary->account_number) && !empty($salary->ifsc_number)){
					$c[]=$i;
					$net_salary=$salary->net_salary;
					$sum+= $salary->net_salary;
					if(strstr($salary->ifsc_number,"ICI")){
						$notpad .="MCW|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".round($salary->net_salary)."|INR|".$month_short_name." ".$year." Salary|".$salary->ifsc_number."|WIB^ \n";
					}else{
						$notpad .="MCO|".$salary->account_number."|0011|".$salary->fname." ".$salary->lname."|".round($salary->net_salary)."|INR|".$month_short_name." ".$year." Salary"."|NFT|".$salary->ifsc_number."^ \n";
					}
				}
			}
			$count=count($c);
		}
		$notpad2="";
		$total_net_salary="0";
		if(!empty($get_employee[0]->account_number) && !empty($get_employee[0]->ifsc_number)){
			if(strstr($get_employee[0]->ifsc_number,"ICI")){
				$notpad2="MCW|".$get_employee[0]->account_number."|0011|".$get_employee[0]->fname." ".$get_employee[0]->lname."|".$total_net_salary."|INR|".$month_short_name." ".$year." Salary|".$get_employee[0]->ifsc_number."|WIB^";
			}else{
				$notpad2="MCO|".$get_employee[0]->account_number."|0011|".$get_employee[0]->fname." ".$get_employee[0]->lname."|".$total_net_salary."|INR|".$month_short_name." ".$year." Salary"."|NFT|".$get_employee[0]->ifsc_number."^ \n";
			}
			$employee_salary=$total_net_salary + $sum;
		}else{
			$employee_salary=$sum;
		}
		
		
		$line_count=$count + 2;
		$notpad1="FHR|".$line_count."|".$final."/".$day."/".$year."|Cut-off|".$employee_salary."|INR|340005500787|0011^\n".
		"MDR|340005500787|0011|587608349|".$employee_salary."|INR|".$month_short_name." ".$year." Salary|ICIC0000011|WIB^\n"
			.trim($notpad).$notpad2;
// 		$notpad1="FHR|".$line_count."|".$final."/".$day."/".$year."|Cut-off|".$employee_salary."|INR|624605065816|0011^ \n".
// 		"MDR|624605065816|0011|GEEKWEBS28012017|".$employee_salary."|INR|".$month_short_name." ".$year." Salary|ICIC0000011|WIB^ \n"
// 		.$notpad.$notpad2;
		if (!file_exists($filename)) {
			write_file($filename,$notpad1,'w+');
			/* $handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle); */
        }else{
			write_file($filename,$notpad1,'w+');
			/* $handle = fopen($filename,'w+');
			fwrite($handle,$notpad1);
			fclose($handle);  */
		}
	}

	public function deposit_store($year,$month,$id,$salary_deduction,$deposit_amount){ 
		$deposit_tbl=$this->Deposit_Model->get_deposit_details($id,$year,$month);
		if(!empty($deposit_tbl)){
			$deposit=array(
				'employee_id' => $id,
				'month' => $month,
				'year' => $year,
				'deposit_percentage' => $salary_deduction,
				'deposit_amount' => $deposit_amount,
			);
			$this->Deposit_Payment_Model->update_deposit_by_empId($id,$deposit);
			
		}else{
			$deposit=array(
				'employee_id' => $id,
				'month' => $month,
				'year' => $year,
				'deposit_percentage' => $salary_deduction,
				'deposit_amount' => $deposit_amount,
			);
			$this->Deposit_Payment_Model->insert_deposit($deposit);
		}
	}
	
	public function bonus_store($year,$month,$id,$bonus){
		$bonus_tbl=$this->Bonus_Model->get_bonus_month($id,$month,$year);
		if(!empty($bonus_tbl)){
			$bonus_amount=$bonus_tbl[0]['bonus'];
			$bonus_arr=array(
				'emp_id' => $id,
				'month' => $month,
				'year' => $year,
				'bonus' => $bonus,
			);
			$this->Bonus_Model->update_employee($bonus_arr);
		}else{
			$bonus_arr=array(
				'emp_id' => $id,
				'bonus' => $bonus,
				'year' => $year,
				'month' => $month,
			);
			$this->Bonus_Model->insert_employee($bonus_arr);
		}
	}

	public function salary_slip_download_file($id,$month,$year){
		/* $year = $this->request->getPost("select_year");
		
		$prev_month = $this->request->getPost("select_month"); */
		$data=array();
		$data['month'] = $month;
		$data['year'] = $year;
		$data['employee_details']= $this->Employee_Model->get_employee($id);
		if(isset($data['employee_details'][0]) && !empty($data['employee_details'][0])){
         $filename=$_SERVER['DOCUMENT_ROOT'].'assets/salary_slip_pdf'.$data['employee_details'][0]->fname."_salary_slip";
    	}else{
    		$filename="joining_letter";
    	}
		$get_salary_pay=$this->Leave_Request_Model->get_salary_pay($id,$month,$year);
		if(!empty($get_salary_pay)){
			
			$data['basic_salary']=$get_salary_pay[0]->basic_salary;
			$data['bonus']=$get_salary_pay[0]->bonus;
			$data['net_salary']=$get_salary_pay[0]->net_salary;
			$data['LOP']= $lop = $get_salary_pay[0]->deduction;
			$data['official_holiday']=$get_salary_pay[0]->official_holiday;
			$data['working_day']=$get_salary_pay[0]->working_day;
			$data['effective_day']=$get_salary_pay[0]->effective_day;
			if($get_salary_pay[0]->absent_leave == "0.00"){
				$data['full_day_count']=0; // Leave Days count
			}else{
				$data['full_day_count']=$get_salary_pay[0]->absent_leave; // Leave Days count
			}
			
			$data['salary_slip_percentage_deduction']=$get_salary_pay[0]->per_deduction;
			$data['deduction_per']= $salary_deduction = $get_salary_pay[0]->amount_deduction;
			$data['prof_tax']= $salary_slip_prof_tax = $get_salary_pay[0]->prof_tax;
			$data['PF']= $salary_slip_pf = 0;
			//$data['total_deduction_right']="0";
			$data['total_deduction_right']= ($salary_deduction + $salary_slip_pf + $salary_slip_prof_tax + $lop);
		}
		$html = $this->load->view('administrator/employee/salary_slip_download',$data,true);
		$this->mpdfgenerator->generate_save($html, $filename, true, 'A4', 'portrait');
		/* echo "<pre>";
			print_r($get_salary_pay);
		echo "</pre>"; */
	}

	public function employee_pagination(){
		 
		//print_r($_POST);
		$month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
		$user_role=$this->session->get('user_role');
		$columns = array( 
                            0 =>'id',
                            1 =>'fname',
							2 =>'',
							3 =>'',
							4 =>'',
							5 =>'status',
							// 4 =>'bankstatus',
                            6 =>'action',
                        );
		$columns1 = array( 0 =>'id', 1 =>'fname', 2 =>'salary', 3 =>'bonus', 4 =>'leave', 5 =>'status',);

		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
        $dir1 = ($this->request->getPost('order')[0]['dir'] == 'asc')? SORT_ASC : SORT_DESC ;
        $totalData = $this->Employee_Model->allposts_count_salary();
		
        $totalFiltered = $totalData; 
		
        if(empty($this->request->getPost('search')['value']))
        {            
			$posts = $this->Employee_Model->allposts_salary($limit,$start,$order,$dir);
        }
        else {
			$search = $this->request->getPost('search')['value'] ; 
			
            $posts =  $this->Employee_Model->posts_search_salary($limit,$start,$search,$order,$dir);
			
            $totalFiltered = $this->Employee_Model->posts_search_count_salary($search);
        }
        $cdate=date('Y-m-d');
		$data = array();
        if(!empty($posts))
        {
			$i=1;
			setlocale(LC_MONETARY, 'en_IN');
			foreach ($posts as $post)
            {	
				$nestedData['id'] =  "<span>".$i ."</span>";
                $nestedData['fname'] = $post->fname." ".$post->lname;
                
                $get_salary_pay=$this->Leave_Request_Model->get_salary_pay($post->id,$month,$year);
				$employeeDetails=$this->Employee_Model->get_employee_details($post->id);
				$btn="";
				$net_salary=0;
				$bonus=0;
				$leave=0;
				$bankstatus='Pending';
				if(!empty($get_salary_pay) && $get_salary_pay[0]->payment_status == "paid"){
					$net_salary=$get_salary_pay[0]->net_salary;
					$bonus=$get_salary_pay[0]->bonus;
					$leave=$get_salary_pay[0]->total_leaves;
                	$button_name="View";
                	$class="";
					$Status="Paid";
					if($user_role == "admin"){
						if($get_salary_pay[0]->bankstatus == '1'){
							$bankstatus="Paid";
						}else{
							// $bankstatus='<a class="btn btn-danger waves-effect waves-light paid_to_bank" data-id="'.$post->id.'" data-month="'.$month.'" data-year="'.$year.'" href="#" title="Bank Status">Paid to bank</a>';
							$bankstatus='<button class="btn btn-success paid_to_bank" data-id="'.$post->id.'" data-month="'.$month.'" data-year="'.$year.'"  data-salary="'.$net_salary.'" title="Bank Status">Paid to bank</button>';
						}
					}else{
						if($get_salary_pay[0]->bankstatus == "1"){
							$bankstatus="Paid";
						}
					}
					$btn='<a  href="'.base_url('salary_slip/salary_slip_download/'.$post->id."/".$month."/".$year).'" class="btn sec-btn" >Download</a>';
                }else{
					
					$button_name="Pay";
					$class="salary-btn-block";
					$Status="Unpaid";
				}
				if($user_role == "admin"){
					$nestedData['bankstatus']= '';
					if($bankstatus == 'Pending'){
						$nestedData['bankstatus'] = '<span class="text-danger">'.$bankstatus.'</span>';
					}elseif($bankstatus == 'Paid'){
						$nestedData['bankstatus'] = '<span class="text-success">'.$bankstatus.'</span>';
					}else{
						$nestedData['bankstatus'] = $bankstatus;
					}
				}
				// $nestedData['salary'] = money_format('%!i',$net_salary);
				// $nestedData['salary'] = moneyFormat($net_salary);
				// $nestedData['bonus'] = moneyFormat($bonus);
				$nestedData['salary'] = number_format(round($net_salary));
				$nestedData['bonus'] = number_format(round($bonus));
				$nestedData['leave'] = $leave;
				if($user_role == "admin"){
					$nestedData['qrcode'] = (isset($employeeDetails->qr_code) && !empty($employeeDetails->qr_code)) ?  '<a href="'.base_url().'assets/upload/qrcode/'.$employeeDetails->qr_code.'" data-fancybox="image_group" class="btn btn-light btn-sm"><i class="fas fa-eye"></i></a>' : '';
				}
				// $nestedData['salary'] = number_to_currency($net_salary,CURRENCY);
				$nestedData['status'] = '';
				if($Status == 'Unpaid'){
					$nestedData['status'] = '<span class="text-danger">'.$Status.'</span>';
                }elseif($Status == 'Paid'){
					$nestedData['status'] = '<span class="text-success">'.$Status.'</span>';
                }else{
					$nestedData['status'] = $Status;
				}
                if($user_role == "admin"){
					if($button_name == "View"){	
						$nestedData['action'] =' <button  data-id="'.$post->id.'" class="btn btn-outline-info pay-salary-btn m-r-5 '.$class.'"  data-toggle="modal" data-target="#myModal">'.$button_name.'</button>'.$btn;
					}else{
						$nestedData['action'] =' <button  data-id="'.$post->id.'" class="btn btn-outline-dark pay-salary-btn m-r-5 '.$class.'"  data-toggle="modal" data-target="#myModal">'.$button_name.'</button>'.$btn;
					}
					if(empty($employeeDetails->salary)) $nestedData['action'] = ' - ';
                }else{
					$nestedData['action'] ="";
					//if($button_name == "View"){	
						$nestedData['action'] =' <button  data-id="'.$post->id.'" class="btn btn-outline-secondary pay-salary-btn m-r-5"  data-toggle="modal" data-target="#myModal">View</button>'.$btn;
					//}
				}
				//Add Attendance
              	$data[] = $nestedData;

            $i++;}
        }
		array_sort_by_multiple_keys($data, [
			$columns1[$this->request->getPost('order')[0]['column']] => $dir1,
		]);
       	$json_data = array(
                    "draw"            => intval($this->request->getPost('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    ); 
       echo json_encode($json_data); 
	}

	public function bank_status(){
			if($this->uri->getSegment(3) && $this->uri->getSegment(4) && $this->uri->getSegment(5)){
				$employee_id=$this->uri->getSegment(3);
				$month=$this->uri->getSegment(4);
				$year=$this->uri->getSegment(5);
				$update=array(
					'bankstatus' => '1'
				);
				$where="month='".$month."' AND year='".$year."' AND employee_id='".$employee_id."'";
				$this->db->table('salary_pay')->where($where);
				$u=$this->db->update($update);
				//echo $this->db->last_query();
				if($u){
					$this->session->set_flashdata('message','<span style="color:green;">Bank status updated.</span>');
				}
				
				
			}else{
				$this->session->set_flashdata('message','<span style="color:red;">Bank status field to update.</span>');
			}
			return redirect()->to(base_url('salary_pay'));
	}

	public function ajax_bank_status(){

			if($this->request->getPost('employee_id') && $this->request->getPost('month') && $this->request->getPost('year')){
				$employee_id=$this->request->getPost('employee_id');
				$month=$this->request->getPost('month');
				$year=$this->request->getPost('year');
				$salary=$this->request->getPost('salary');
				$data = array();
				$emp_detail = $this->Employee_Model->get_employee($employee_id);
				$update=array(
					'bankstatus' => '1'
				);
				$where="month='".$month."' AND year='".$year."' AND employee_id='".$employee_id."'";
				$u = $this->db->table('salary_pay')->where($where)->update($update);
				// $u=true;
				//echo $this->db->last_query();
				if($u){
					// $this->session->set_flashdata('message','<span style="color:green;">Bank status successfully updated.</span>');
					if($emp_detail[0]->personal_email){
						$data1 = array();
			
						$content = $this->Mail_Content_Model->mail_content_by_slug('salarypay_mail');
						$variables = array(
							"{{name}}" => $emp_detail[0]->fname.' '.$emp_detail[0]->lname,
							"{{amount}}" => $salary,
							"{{account_no}}" => $emp_detail[0]->account_number,
						);
						$message = $content[0]->content;
						foreach ($variables as $key => $value){
							$message = str_replace($key, $value, $message);
						}
						$data1['mail_type'] = 'salary_pay';
						$data1['subject'] = 'Salary Credited from DecodeX Infotech '.date('M, Y',strtotime('01-'.$month.'-'.$year));
						$data1['title'] = date('M, Y',strtotime('01-'.$month.'-'.$year)).' Salary Credited';
						$data1['greeting'] = 'Dear';
						$data1['img_name'] = 'salary-paid.png';
						$data1['message'] = $message;
						$data1['name'] = $emp_detail[0]->fname.' '.$emp_detail[0]->lname;
						$data1['to'] = $emp_detail[0]->personal_email;
						$data1['salary'] = $salary;
						$data1['base_url'] = base_url();
						$mail_send_code = $this->mailfunction->mail_send($data1);
						if(!$mail_send_code){
							$data['error_code'] = 0;
							$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Bank status updated, but mail not sended.</p></div></div></div>';
							echo json_encode($data);exit;
						}
						$data['error_code'] = 0;
						$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Bank status updated.</p></div></div></div>';
					}else{
						$data['error_code'] = 1;
						$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Employee personal email not found</p></div></div></div>';
					}
				}
			}else{
				$data['error_code'] = 1;
				$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Bank status failed to update.</p></div></div></div>';
				// $this->session->set_flashdata('message','<span style="color:red;">Bank status fail updated.</span>');
			}
			echo json_encode($data);
			// return redirect()->to(base_url('salary_pay'));
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
					
	public function create_table(){
		$this->Salary_Pay_Model->create_table();exit;
		
		$this->db = \Config\Database::connect();
		echo $this->db->query("DELETE FROM `salary_pay` WHERE `month`=6 AND `year`=2021 AND`employee_id`=30");
		// echo $this->db->query("DELETE '*' FROM salary_pay WHERE `month`='4' AND `year`='2021' AND `employee_id` = '30'");
		die;

		$select="SELECT * FROM `employee_paid_leaves` WHERE `employee_id` = '12'";
		$res=$this->db->query($select)->result_array();
		echo "<pre>";
		print_r($res);
		/* echo $res2=$this->db->query("ALTER TABLE `employee_paid_leaves` CHANGE `status` `status` ENUM('used','unused','rejected','paid') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL"); */

		$res1=$this->db->query("DESCRIBE employee_paid_leaves")->result_array();
		print_r($res1);

		echo "</pre>"; 
		die; 
		 /* $select="select * from employee_paid_leaves where employee_id=''";
		$res=$this->db->query($select)->result_array();
		echo "<pre>";
		print_r($res);
		foreach($res as $r){
					$this->db->query("UPDATE employee_paid_leaves SET employee_id = '8'  where  id =".$r['id']);

			
		}
		echo "</pre>"; 
		die; */
		echo $this->db->query("delete from salary_pay where month='4' AND year='2021'");
		die;
		// echo $this->db->query("ALTER TABLE `employee` CHANGE `salary_deduction` `salary_deduction` FLOAT(11) NOT NULL");exit;
		// echo $this->db->query("ALTER TABLE `employee` ADD `agree_terms_conditions` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '0=No,1=Yes' AFTER `employee_status`;");
		/* echo 	$this->db->query("ALTER TABLE `salary_pay` ADD `payout_paid_leave` INT(11) NULL AFTER `net_salary`"); */
		/* 
				echo $this->db->query("CREATE TABLE `team_and_condition` (
		`id` int(11) PRIMARY KEY AUTO_INCREMENT,
		`description` LONGTEXT NOT NULL,
		`created_date` datetime NOT NULL DEFAULT current_timestamp(),
		`updated_date` datetime DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");  
			*/
	 
		/* $employee_id22="INSERT INTO `employee_paid_leaves` (`employee_id`, `leave`, `month`, `year`, `status`,`used_leave_month`)
		VALUES ('22', '1', '12', '2020','unused', '0')"; 
		echo $this->db->query($employee_id22); */
		//  $update1="UPDATE employee_paid_leaves SET month = '12'  where  id =168";
		//  echo $this->db->query($update1);	
	     $select="select * from salary_pay where month='1' AND year='2021'";
		$res=$this->db->query($select)->result_array();
		echo "<pre>";
		print_r($res);
		echo "</pre>"; 
		echo $this->db->query("delete  from salary_pay where month='1' AND year='2021'");
		die;
		
		/* 
	     $select1="select * from employee_paid_leaves where employee_id =8";
		$res1=$this->db->query($select1)->result_array();
		 $update1="UPDATE employee_paid_leaves SET used_leave_month = '0' ,status = 'unused' where status = 'paid' AND employee_id =8";
		 *///echo $this->db->query($update1);   
		//echo $this->db->query("delete  from salary_pay where id=187");
		//echo $this->db->query("ALTER TABLE `employee_paid_leaves` MODIFY COLUMN `status` enum('used','unused','paid')");
		//echo "<pre>";print_r($res1); print_r($res);echo "</pre>"; 
		 //$update="UPDATE salary_pay SET payout_paid_leave = '1333', net_salary ='9453' where id = '180'";
		//echo $this->db->query($update); 
		//die; 
		//echo $this->db->query("ALTER TABLE `employee_paid_leaves` MODIFY COLUMN `status` enum('used','unused','paid')");
		//die;

		/* $up="UPDATE `employee_paid_leaves` SET `used_leave_month` = '5' WHERE `employee_paid_leaves`.`id` = 76;";
		$this->db->query($up); */
		/* $up1="UPDATE `employee_paid_leaves` SET `status` = 'unused', `used_leave_month` = '0' WHERE `employee_paid_leaves`.`id` = 56;";
		$this->db->query($up1); 
		*//* $up="UPDATE `employee_paid_leaves` SET `status` = 'unsed', `used_leave_month` = '0' WHERE `employee_paid_leaves`.`id` = 80";
		$this->db->query($up);
		$up1="UPDATE `employee_paid_leaves` SET `status` = 'rejected', `used_leave_month` = '8' WHERE `employee_paid_leaves`.`id` = 79;";
		$this->db->query($up1);  */
		//echo $this->db->query("ALTER TABLE `employee` ADD `skip_paid_leave` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '0=ON,1=OFF' AFTER `employee_status`;");
		/* echo $this->db->query("CREATE TABLE `employee_paid_leaves` (
		`id` int(11) NOT NULL,
		`employee_id` int(10) PRIMARY KEY AUTO_INCREMENT,
		`leave` int(10) NOT NULL,
		`month` int(10) NOT NULL,
		`year` int(10) NOT NULL,
		`status` enum('used','unused','rejected') NOT NULL,
		`used_leave_month` int(10) NOT NULL,
		`created_date` datetime NOT NULL DEFAULT current_timestamp(),
		`updated_date` datetime DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;"); */
	
		/*  $select="select * from bonus";
		$res=$this->db->query($select)->result_array();
		echo "<pre>"; print_r($res);echo "</pre>"; */
		/* $update="UPDATE salary_pay SET paid_leave = '0', net_salary ='0' where employee_id = '10' AND month='4'";
		echo $this->db->query($update); */
		
		
		//die;
		/* $deposit6="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (4, '2020', '6', '10', '800')"; 
		echo $this->db->query($deposit6); 
		
		$deposit5="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (12, '2020', '5', '10', '1400')"; 
		echo $this->db->query($deposit5);
		
		$deposit6="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (12, '2020', '6', '10', '1400')"; 
		echo $this->db->query($deposit6);
		
		
		$deposit5="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (13, '2020', '5', '10', '1000')"; 
		echo $this->db->query($deposit5);
		
		$deposit6="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (13, '2020', '6', '10', '1000')";		
		echo $this->db->query($deposit6);
		
		$deposit6="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (10, '2020', '6', '10', '800')"; 
		echo $this->db->query($deposit6);
		
		$delete='delete from deposit where id="81"';
		echo $this->db->query($delete); 
		
		$deposit5="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (5, '2020', '5', '10', '800')"; 
		echo $this->db->query($deposit5);
		
		$deposit6="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (5, '2020', '6', '10', '800')"; 
		echo $this->db->query($deposit6);
		
		$deposit6="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (3, '2020', '6', '10', '800')"; 
		echo $this->db->query($deposit6);
		
		$deposit6="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (15, '2020', '5', '10', '800')"; 
		echo $this->db->query($deposit6); 
		
		$deposit5="INSERT INTO `deposit` (`employee_id`, `year`, `month`, `deposit_percentage`, `deposit_amount`)
		VALUES (15, '2020', '6', '10', '800')"; 
		echo $this->db->query($deposit5);
		
		*/
		/* salary pay may */
		/*  $ins15="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (15, '2020', '5', '8000', '0', '7120', '0','800', '10', '880', '80', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')"; 
		echo $this->db->query($ins15);
		 $ins14="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (14, '2020', '5', '5000', '0', '5000', '0','0', '0', '0', '0', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')"; 
		echo $this->db->query($ins14);
		 $ins13="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (13, '2020', '5', '10000', '0', '8850', '0','1000', '10', '1150', '150', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')"; 
		echo $this->db->query($ins13);
		 $ins12="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (12, '2020', '5', '14000', '0', '12400', '0','1400', '10', '1600', '200', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')"; 
		echo $this->db->query($ins12);
		 $ins11="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (11, '2020', '5', '4000', '0', '4000', '0','0', '0', '0', '0', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')";  
		echo $this->db->query($ins11);
		$ins9="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (9, '2020', '5', '8000', '3200', '19920', '0','8800', '10', '80', '80', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')"; 
		echo $this->db->query($ins9);
		$ins8="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (8, '2020', '5', '19000', '0', '18800', '0','0', '0', '0', '200', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')";  
		echo $this->db->query($ins8);
		$ins6="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (6, '2020', '5', '8000', '1000', '17720', '0','9600', '10', '80', '80', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')"; 
		echo $this->db->query($ins6);
		$ins5="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (5, '2020', '5', '8000', '0', '7120', '0','800', '10', '880', '80', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')"; 
		echo $this->db->query($ins5);
		 $ins4="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (4, '2020', '5', '8000', '1000', '8120', '0','800', '10', '880', '80', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')"; 
		echo $this->db->query($ins4);
		 $ins3="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (3, '2020', '5', '8000', '500', '7620', '0','800', '10', '880', '80', '26', '5', '25', '1', '1', '0', '1', '0', '0','paid','2020-06-20 10:28:04')"; 
		echo $this->db->query($ins3);
		 $ins2="INSERT INTO `salary_pay` (`employee_id`, `year`, `month`, `basic_salary`, `bonus`,`net_salary`, `deduction`, `deposit`, `per_deduction`, `amount_deduction`, `prof_tax`, `working_day`, `official_holiday`,`effective_day`,`paid_leave`,`approve_leave`,`unapproved_leave`,`absent_leave`,`sick_leave`,`total_leaves`,`payment_status`,`created_date`)
		VALUES (2, '2020', '5', '8000', '500', '7620', '0','800', '10', '880', '80', '26', '5', '26', '0', '0', '0', '0', '0', '0','paid','2020-06-20 10:28:04')";  
		echo $this->db->query($ins2);
		 */
		/* 9600+7120+1000 */
		
		 /* 8800+7920=16720 deposit plus salary
		19920-16720= 3200 bonus */
		
		//	die;
	   
	
	}
	
}
?>
