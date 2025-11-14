<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Salary_slip extends BaseController {
	public function __construct()
	{
		parent::__construct();
		$user_session=$this->session->get('id');
		if(!$user_session){
			return redirect()->to(base_url());	
		}
	}
	
	public function index()
	{	
		$user_role=$this->session->get('user_role');
		if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}
		$data=array();
		$data['page_title']="Salary Slip";
		//$data['js_flag']="sal_js";
		$data['menu']="salary_slip";
		$this->lib->view('administrator/employee/download',$data);
	}
	public function cron_salary_slip(){
		$get_employee=$this->Reports_Model->get_employee();
		if(!empty($get_employee)){
			foreach($get_employee as $emp_details){
				$data=array(
					'employee_id' => $emp_details->id,
					'basic_salary' => $emp_details->salary,
					'salary_slip_date' => date('Y-m-d'),
					'bonus' => 0,
					'percentage_deduction' => $emp_details->salary_deduction,
					'pf' => 0,
					'prof_tax' => 0,
					'created_date' => date('Y-m-d h:i:s'),
				);
				//$this->db->insert('salary_slip',$data);
				//print_r($data);
			}
		}
	}		
	public function salary_slip_download($id,$month,$year){
		/* $year = $this->input->post("select_year");
		
		$prev_month = $this->input->post("select_month"); */
		$data=array();
		$data['month'] = $month;
		$data['year'] = $year;
		$data['employee_details']= $this->Employee_Model->get_employee($id);
		if(isset($data['employee_details'][0]) && !empty($data['employee_details'][0])){
         $filename=$data['employee_details'][0]->fname."_salary_slip";
    	}else{
    		$filename="joining_letter";
    	}
		$get_salary_pay=$this->Leave_Request_Model->get_salary_pay($id,$month,$year);
		if(!empty($get_salary_pay)){
			
			$data['basic_salary']=$get_salary_pay[0]->basic_salary;
			$data['bonus']=$get_salary_pay[0]->bonus;
			$data['deposit']=$get_salary_pay[0]->deposit;
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
			
			$data['payout_paid_leave']=$get_salary_pay[0]->payout_paid_leave;
			$data['salary_slip_percentage_deduction']=$get_salary_pay[0]->per_deduction;
			$data['deduction_per']= $salary_deduction = $get_salary_pay[0]->amount_deduction;
			$data['prof_tax']= $salary_slip_prof_tax = $get_salary_pay[0]->prof_tax;
			$data['PF']= $salary_slip_pf = 0;
			//$data['total_deduction_right']="0";
			$data['total_deduction_right']= ($salary_deduction + $salary_slip_pf + $salary_slip_prof_tax + $lop);
		}
		$html = view('administrator/employee/salary_slip_download',$data);
		$this->mpdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
		/* echo "<pre>";
			print_r($get_salary_pay);
		echo "</pre>"; */
	}
	public function calculate_slip()
	{
		$data=array();
		$user_session=$this->session->get('id');
		$year = $this->input->post("select_year");
		$prev_month = $this->input->post("select_month");
		$this->form_validation->set_rules('select_year','Year','required');
		$this->form_validation->set_rules('select_month','Month','required');
		$next_month_ts = strtotime($year.'-'.$prev_month.'-1 +1 month');
		$prev_month_number = date('m', $next_month_ts);
		$get_employee=$this->Employee_Model->get_employee($user_session);
		
		
		

		// bonus list
		//$get_employees_bonus_list=$this->Leave_Request_Model->get_employees_bonus_list($user_session,$prev_month,$year);
		$add_bouns_list=array();
		/* if(!empty($get_employees_bonus_list)){
			foreach($get_employees_bonus_list as $add_bouns){
				$add_bouns_list[]=$add_bouns->bonus;
			}
		} */
		 $add_bouns_arr=array_sum($add_bouns_list);
		//echo "<pre>"; print_r($get_employees_bonus_list);
		// leave request list
		$get_employees_leave_request_list=$this->Leave_Request_Model->get_employees_leave_request_list($user_session,$prev_month,$year);
		$paid_leave=0;
		if(!empty($get_employees_leave_request_list)){
			$paid_leave=count($get_employees_leave_request_list);
		}
		
		//not approved leave request list
		$get_leave_not_approved_list=$this->Leave_Request_Model->get_leave_not_approved_list($user_session,$prev_month,$year);
		$not_approved = $not_approved_day_count=0;
		if(!empty($get_leave_not_approved_list)){
			$not_approved=count($get_leave_not_approved_list);
			
			$not_approved_date=array();
			foreach($get_leave_not_approved_list as $not_approved_day){
				$not_approved_date[]=$not_approved_day->leave_date;
				$not_approved_day_count += 1+0.5;
			}
		}
		//echo "<pre>";
		//print_r($not_approved_date);
		
		
		//echo $count_day=$not_approved;
		//echo $not_approved_count = $count_day * 0.5;
		//echo $not_approved;
		
		//print_r($get_employees_leave_request_list);
		//die;
		
		
		$salary_slip_date=isset($get_salary_slip[0]->salary_slip_date) ? $get_salary_slip[0]->salary_slip_date : "";
		//$salary_slip_bonus=isset($get_salary_slip[0]->bonus) ? $get_salary_slip[0]->bonus : "0";
		$salary_slip_bonus=$add_bouns_arr;
		$salary_slip_percentage_deduction=isset($get_salary_slip[0]->percentage_deduction) ? $get_salary_slip[0]->percentage_deduction : "0";
		$salary_slip_pf=isset($get_salary_slip[0]->pf) ? $get_salary_slip[0]->pf : "0";
		$salary_slip_prof_tax=isset($get_salary_slip[0]->prof_tax) ? $get_salary_slip[0]->prof_tax : "0";
		$salary_slip_created_date=isset($get_salary_slip[0]->created_date) ? $get_salary_slip[0]->created_date : "";
		if(!empty($salary_slip_date)){
			$month = date('n', strtotime($salary_slip_date .' -1 month'));
		}else{
			$month=$prev_month;	
		}
		$data['month'] = $month;
		$data['year'] = $year;
		$get_holidays=$this->Holiday_Model->get_official_holidays($month,$year);
		$num = 0;
		$holidaysDetail=$this->Holiday_Model->getOfficialHolidays($month,$year);
		foreach ($holidaysDetail as $key => $value) {
			$date = strtotime($value->holiday_date);
			$date = date("l", $date);
			$date = strtolower($date);
			if($date == "saturday" || $date == "sunday") {
				$num++;
			}
		}
		$no_of_days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		$no_of_sundays=0;
		$total_days=cal_days_in_month(CAL_GREGORIAN, $month, $year);
		for($i=1;$i<=$total_days;$i++){
				if(date('N',strtotime($year.'-'.$month.'-'.$i))==7)
					$no_of_sundays++;
		} 
		// total holiday
		$total_holiday=isset($get_holidays[0]) ? $get_holidays[0]->no_of_holidays-$num : "0";
		
		$data['get_employee']=$get_employee;
		if(!empty($salary_slip_basic_salary)){
			$basic_salary=$salary_slip_basic_salary;
		}else{
			$basic_salary=isset($get_employee[0]->salary) ? $get_employee[0]->salary :"0";	
		}
		$salary_deduction="0";
		/* if($salary_slip_percentage_deduction  != "0"){
			$salary_deduction=isset($salary_slip_percentage_deduction) ? (($salary_slip_basic_salary * $salary_slip_percentage_deduction)/100):"0";
		} */
		$salary_deduction=isset($get_employee[0]->salary_deduction) ? (($basic_salary * $get_employee[0]->salary_deduction)/100):"0";
		$month_day=$total_days - ($no_of_sundays + $total_holiday);	
		$one=$basic_salary/$month_day;
		$h=$one/2;
		
	    $month_name=date('F',mktime(0,0,0,$month));
		$emp_day_all=$this->Employee_Attendance_Model->salary_count_day($month_name,$year,$user_session);
		$messages_set="";
		if(empty($emp_day_all)){
			$messages_set="This Month Data Not Found";
			$arr=array("month" =>$month,"year" => $year);
			$this->session->set_flashdata('message', $messages_set);
			$this->session->set_flashdata('message1', $arr);
			return redirect()->to(base_url('profile/download_salary_slip'));
		}
		$full_day = $half_day = 0;
		foreach ($emp_day_all as $key => $value) {
			if($value->attendance_type =='full_day'){
					$full_day++;
			}
			if($value->attendance_type=='half_day'){
					$half_day++;	
			}
		}
		 $totalday=count($emp_day_all);
		// echo "<br>";
		 $total_add_extra=$one*$paid_leave+$add_bouns_arr;
		//echo "<br>";
		/* echo $full_day;
		echo "<br>";
		echo $not_approved;
		echo "<br>";
		echo $not_approved_day_count;
		echo "<br>"; */
		$leave_day =(($month_day - ($full_day + $half_day*0.5)) - $not_approved) + $not_approved_day_count;
		$data['total_day'] = $month_day - $leave_day;
		//echo "<br>";
		 $data['full_day_count']= ($month_day - $data['total_day']) - $paid_leave;
		//echo "<br>";		
		//echo $paid_leave;	
		//echo "<br>";	
		if ( strstr($data['total_day'], '.' ) ) {
		//if(is_float($data['total_day'])){
			$d=floor($data['total_day']);
			$paid_leave_total=($one*$paid_leave);
			$total_salary=($one*$d)+$h+$paid_leave_total;
			//echo "sds";
		}else{	
			//echo "sds";	
			$paid_leave_total=($one*$paid_leave);
			$total_salary=($one*$data['total_day'])+$paid_leave_total;
		}
		//echo "<br>";
		 $data['new_add_total_salary']=$total_salary + $add_bouns_arr;
		//die;
		$data['half_day_count']= $half_day_count = $half_day*0.5;
		//echo "<br>";
		//old
		//$data['full_day_count']= ($month_day - ($full_day + $half_day*0.5)) - $paid_leave;
		//$total_salary=($one*$full_day)+($h*$half_day);
		$user_session=$this->session->get('id');
		$data['employee_details']= $this->Employee_Model->get_employee($user_session);
		if(isset($data['employee_details'][0]) && !empty($data['employee_details'][0])){
         $filename=$data['employee_details'][0]->fname."_salary_slip";
    	}else{
    		$filename="joining_letter";
    	}
		
		$data['not_approved_day_count']=$not_approved_day_count;
		$data['not_approved']=$not_approved;
		$data['total_add_extra']=$total_add_extra;
    	$lop=$one*$data['full_day_count'];
		$data['working_day']=$month_day;
		$data['basic_salary']=$basic_salary;
		$data['total_salary']=$total_salary;
		$data['bonus']=$salary_slip_bonus;
		$data['PF'] = $salary_slip_pf;
		$data['prof_tax']= $salary_slip_prof_tax;
		$data['salary_slip_percentage_deduction']=$salary_slip_percentage_deduction;
		$data['deduction']=$salary_deduction;
		$data['total_deduction']= $basic_salary - $total_salary;
		$data['total_deduction_right']= ($salary_deduction + $salary_slip_pf + $salary_slip_prof_tax + $lop);
		$data['total_deduction_left']= ($basic_salary - $total_salary) + $salary_deduction;
		$data['LOP']=$lop;
		$html = $this->load->view('administrator/employee/download',$data,true);
		$this->mpdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
		
		
			
	}
	
}
