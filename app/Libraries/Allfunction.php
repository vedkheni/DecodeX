<?php
namespace App\Libraries;
use DateTime;

class Allfunction 
{
	function prof_tax($basic_salary){
		//$basic_salary=5000;
		$config_Prof_Tax=Prof_Tax;
		if($config_Prof_Tax != 0){
			$prof_tax="0";
			if(5999 >= $basic_salary){
				$prof_tax="0";
			}else if(6000 <= $basic_salary && 8999 >= $basic_salary){
				$prof_tax="80";
			}else if(9000 <= $basic_salary && 11999 >= $basic_salary){
				$prof_tax="150";
			}else if(12000 <= $basic_salary){
				$prof_tax="200";
			}
		}else{
			$prof_tax="0";
		}
		return  $prof_tax;
		
	}
	
	function salary_pay_employee($data=array()){
		$result=array();
		if(!empty($data)){
			// $this =& get_instance();
			/* $this->load->model('Employee_Model');
			$this->load->model('Leave_Request_Model');
			$this->load->model('Holiday_Model');
			$this->load->model('Employee_Attendance_Model'); */
			$this->Employee_Model = new \App\Models\Employee_Model();
			$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
			$this->Holiday_Model = new \App\Models\Holiday_Model();
			$this->Employee_Attendance_Model = new \App\Models\Employee_Attendance_Model();

			$month=$data['month'];
			$year=$data['year'];
			$employee_id=$data['employee_id'];	
			$timedata=$this->employee_total_working_time(array('employee_id' => $employee_id,'month' => $month,'year'=>$year));
			$result['plus_time']=$timedata['plus_time'];
			$result['minus_time']=$timedata['minus_time'];
			$result['total_time']=$timedata['total_time'];
			$result['time_status']=$timedata['time_status'];
			//print_r($timedata);
			
			$basic_salary_data=$data['basic_salary'];
			$bonus_data=round($data['bonus']);
			if($bonus_data == 0){
				$result['bonus'] = $bonus =0;
			}else{
				$result['bonus'] = $bonus = $bonus_data;
			}
			$salary_deduction=0;
			$deduction=0;
			$next_month_ts = strtotime($year.'-'.$month.'-1 +1 month');
			$prev_month_number = date('m', $next_month_ts);
			
			//employee table	
			$month_name = date("F", mktime(0, 0, 0, $month, 10)); 
			$employee_tbl=$this->Employee_Model->get_employee($employee_id);
			$result['name']=$employee_tbl[0]->fname." ".$employee_tbl[0]->lname . " - ".$employee_tbl[0]->name;
			$result['month_year_name']=$month_name." - ".$year;
			$result['skip_paid_leave']=$employee_tbl[0]->skip_paid_leave;
			if($basic_salary_data == 0){
				$result['basic_salary']= $basic_salary = $employee_tbl[0]->salary;
			}else{
				$result['basic_salary']= $basic_salary = $basic_salary_data;
			}
			$select_month_date = date("Y-m-d", mktime(0, 0, 0, $month, 10));
			 $employee_tbl[0]->employed_date;
			 $employee_tbl[0]->employee_status;
			if($employee_tbl[0]->employed_date == "0000-00-00"){
				$result['salary_deduction_per']= $salary_deduction_per = 0;
				$result['salary_deduction_per_amount'] = $salary_deduction_per_amount = 0;
			}else{
				//echo $employee_tbl[0]->employed_date;
				if((strtotime($select_month_date) >= strtotime($employee_tbl[0]->employed_date)) && $employee_tbl[0]->employee_status == "employee"){
				//$v="1";
				$result['salary_deduction_per']= $salary_deduction_per = $employee_tbl[0]->salary_deduction;
				$result['salary_deduction_per_amount'] = $salary_deduction_per_amount = isset($employee_tbl[0]->salary_deduction) ? (($basic_salary * $employee_tbl[0]->salary_deduction)/100):"0";
				}else{
					$result['salary_deduction_per']= $salary_deduction_per = 0;
					$result['salary_deduction_per_amount'] = $salary_deduction_per_amount = 0;
					//$v="0";
				}	
				//echo $v;
			}
			
		
	
			$get_total_month_leave_list=$this->Leave_Request_Model->get_total_month_leave_list($employee_id,$month,$year);
			$leave=array();
			$monthly_paid_leave_total=$this->monthly_paid_leave_total(array('employee_id' => $employee_id));
			$p = $t = 0;
			
			if(!empty($get_total_month_leave_list)){
				if(isset($monthly_paid_leave_total['this_month_paid_leave'])){
					$p=$monthly_paid_leave_total['this_month_paid_leave'];
				}
				/* if(isset($monthly_paid_leave_total['total_paid_leave_remaining'])){
					$t=$monthly_paid_leave_total['total_paid_leave_remaining'];
				} */
				//echo "<pre>";$leave=array();
				//print_r($get_total_month_leave_list);
				
				foreach($get_total_month_leave_list as $l){
						if($l->leave_status == "paid" && $l->status == "approved"){
							$leave['paid'][]=$l->leave_date;
						}
						if($l->leave_status == "none" && $l->status == "approved"){
							$leave['unpaid'][]=$l->leave_date;
						}
						if($l->leave_status == "sick" && $l->status == "approved"){
							$leave['sick'][]=$l->leave_date;
						}
						if($l->status == "approved"){
							$leave['approved'][]=$l->leave_date;
						}
						if($l->status == "unapproved" || $l->status == "rejected"){
							$leave['unapproved'][]=$l->leave_date;
						}
						if($l->status == "approved" || $l->status == "rejected"){
							$leave['leaves_total'][]=$l->leave_date;
						}
				}
				
				//print_r($leave);
				
			}else{
				
			}
			
			$get_employees_leave_request_list=$this->Leave_Request_Model->get_employees_leave_request_list($employee_id,$month,$year);
			$leave_list=array('employee_id' => $employee_id);
			$leave_list_count=$this->employee_leave_count($leave_list);
			$paid_leave_used_total=$leave_list_count['paid_leave'];
			$remaing_paid_leave_total=$leave_list_count['remaing_paid_leave'];

			$sick_leave_used_total=$leave_list_count['sick_leave'];
			
			$paid_leave_total  = 12;
			$sick_leave_total  = 5;
			if($sick_leave_total >= $sick_leave_used_total){
				$result['sick_leave']=isset($leave['sick']) ? count($leave['sick']) : "0";
			}else{
				$result['sick_leave']="0";
			}
			$paid_leave = 0;
			
			/* if($paid_leave_total >= $paid_leave_used_total){
				if(!empty($get_employees_leave_request_list)){
					 $paid_leave = count($get_employees_leave_request_list);
				}
				$result['paid_leave']=isset($leave['paid']) ? count($leave['paid']) : "0";
			}else{
				$result['paid_leave']="0";
			} */
			
			//exit;
			//Year Total Remaining Leave 
			$current_date=date('Y-m-d');
			$novmber_last_date=date('Y-m-d',strtotime(date('Y-11-30')));
			$remaining_leave_salary=0;
			if(strtotime($novmber_last_date) > strtotime($current_date)){
				$result['remaing_paid_leave_total']=0;
				$result['remaing_paid_leave_salary']=0;
			}else{
				if($month == "11"){
					$remaining_leave_salary=($basic_salary/30)*$remaing_paid_leave_total;
					$result['remaing_paid_leave_total']=$remaing_paid_leave_total;
					$result['remaing_paid_leave_salary']=round($remaining_leave_salary);
				}else{
					$result['remaing_paid_leave_total']=0;
					$result['remaing_paid_leave_salary']=0;
				}
			}
			
			//not approved leave request list
			$get_leave_not_approved_list=$this->Leave_Request_Model->get_leave_not_approved_list($employee_id,$month,$year);
			$result['not_approved'] = $not_approved = 0;
			$result['not_approved_day_count'] = $not_approved_day_count = 0;
			if(!empty($get_leave_not_approved_list)){
				$result['not_approved'] = $not_approved =count($get_leave_not_approved_list);
				
				$not_approved_date=array();
				foreach($get_leave_not_approved_list as $not_approved_day){
					$not_approved_date[]=$not_approved_day->leave_date;
					$result['not_approved_day_count'] = $not_approved_day_count += 1+0.5;
				}
			}
			// holiday count
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
			 $total_holiday = isset($get_holidays[0]) ? ($get_holidays[0]->no_of_holidays-$num) : "0";
			//  one -  fullday and half day pay details
			$month_day=$total_days - ($no_of_sundays + $total_holiday);	
			
			$one=$basic_salary/$month_day;
			$h=$one/2;
			
			// salary count day
			$month_name=date('F',mktime(0,0,0,$month));
			$emp_day_all=$this->Employee_Attendance_Model->salary_count_day($month_name,$year,$employee_id);
			$full_day = $half_day = 0;
			foreach ($emp_day_all as $key => $value) {
				if($value->attendance_type =='full_day'){
						$full_day++;
				}
				if($value->attendance_type=='half_day'){
						$half_day++;	
				}
			}
			$paid_leave = 0;
			$a=$month_day - ($full_day+$half_day);
			if(empty($a) && $a == "0"){
				//echo $half_day;
				if(!empty($half_day) && $half_day != "0"){
					if($half_day < 1){
						//0.5
						//echo "if1";
						$result['paid_leave']= $paid_leave = 0;
					}else{
						//echo "else";
						 if(isset($monthly_paid_leave_total['this_month_paid_leave'])){
							$p=$monthly_paid_leave_total['this_month_paid_leave'];
						}
						/* if(isset($monthly_paid_leave_total['total_paid_leave_remaining'])){
							$t=$monthly_paid_leave_total['total_paid_leave_remaining'];
						} */ 
					
						$result['paid_leave']= $paid_leave = isset($p) ? $p : "0";
						
						//echo "sdsdsfd"; 
					}
				}else{
					//echo "if";
					$result['paid_leave']= $paid_leave = 0;
				}
			}else{		
				//echo "else2";
				$result['paid_leave']= $paid_leave = isset($p) ? $p : "0";
			}
			
			 $totalday=count($emp_day_all);
			 $total_add_extra=$one*$paid_leave+$bonus;
			 $leave_day =(($month_day - ($full_day + $half_day*0.5)) - $not_approved) + $not_approved_day_count;
			 $result['total_day'] = $month_day - $leave_day;
			 
			 $result['full_day_count']= ($month_day - $result['total_day']) - $paid_leave;
			 if ( strstr($result['total_day'], '.' ) ) {
				$d=floor($result['total_day']);
				$paid_leave_total=($one*$paid_leave);
				$total_salary=($one*$d)+$h+$paid_leave_total;
			}else{	
				$paid_leave_total=($one*$paid_leave);
				$total_salary=($one*$result['total_day'])+$paid_leave_total;
			}
		$prof_tax=$this->prof_tax($basic_salary);
		$result['total_salary']=round(((($total_salary + $bonus + $remaining_leave_salary)-$prof_tax)-$salary_deduction_per_amount));
		$result['half_day_count']= $half_day_count = $half_day*0.5;
		
		  
			
		$PF=0;
		
		//$result['total_add_extra']=$total_add_extra;
    	$lop=$one*$result['full_day_count'];
		$result['working_day']=$month_day;
		$result['offical_holiday']=$no_of_sundays + $total_holiday;
		$result['effetive_day'] =$result['total_day'];
		
		$result['absent_leave']=$result['full_day_count'];
		$result['approved_leave']=isset($leave['approved']) ? count($leave['approved']) : "0";
		$result['unapproved_leave']=isset($leave['unapproved']) ? count($leave['unapproved']) : "0";
		//$result['paid_leave']=isset($leave['paid']) ? count($leave['paid']) : "0";
		$result['unpaid_leave']=isset($leave['unpaid']) ? count($leave['unpaid']) : "0";
		//$result['sick_leave']=isset($leave['sick']) ? count($leave['sick']) : "0";
		if(isset($leave['leaves_total']) && !empty($leave['leaves_total'])){
			$result['leaves_total']=count($leave['leaves_total'])+ ($half_day*0.5);
		}else{
			$result['leaves_total']=0;
			if($half_day != "" && $half_day != '0'){
				$result['leaves_total']=$half_day*0.5;
			}
			
		}
		
		$total_deposit_data=$this->total_deposit_data($employee_id,$month,$year);
		$result['deposit']=$total_deposit_data['total_deposit'];
		$result['current_month_deposit']=$total_deposit_data['current_month_deposit'];
		
		$result['PF'] = 0;
		$result['prof_tax']= $prof_tax;
		$result['deduction']=number_format($basic_salary - $total_salary);
		$result['total_deduction']= number_format($basic_salary - $total_salary);
		//$result['total_deduction_right']= ($deduction + $PF + $prof_tax + $lop);
		//$result['total_deduction_left']= ($basic_salary - $total_salary) + $deduction;
		$result['LOP']=number_format($lop,2);
		$result['payment_status']="unpaid";
		
		}
		return $result;
	}
	function total_deposit_data($employee_id,$month,$year){
		/* $this =& get_instance();
		$this->load->model('Deposit_Payment_Model'); */
		$this->Deposit_Payment_Model = new \App\Models\Deposit_Payment_Model();
		$get_deposit_list=$this->Deposit_Payment_Model->get_deposit_list($employee_id,'pending');
		$get_employees_details=$this->Deposit_Payment_Model->get_employees_details($employee_id);
		$current_month_deposit=$this->Deposit_Payment_Model->current_month_deposit($employee_id,$month,$year);
		$data=array();
		$arr=array();
		$total=0;
		foreach($get_deposit_list as $list){
			$total +=$list->deposit_amount;
		}
		$deduction=0;
		$data['employee_name']=$get_employees_details[0]->fname." ".$get_employees_details[0]->lname;
		$data['salary']=$get_employees_details[0]->salary;
		if(!empty($get_employees_details[0]->salary_deduction)){
			$salary=$get_employees_details[0]->salary;
			$salary_deduction=$get_employees_details[0]->salary_deduction;
			$deduction=($salary*$salary_deduction)/100;
		}
		if(!empty($get_deposit_list)){
			$data['total_deposit']=$total;
			$data['total_deduction_per']=$deduction;
		}else{
			$data['total_deposit']="0";
			$data['total_deduction_per']=$deduction;
		}
		$salary_deduction_list = $this-> salary_deduction($employee_id,$month,$year);
		$data['total_deposit']=$salary_deduction_list['total_deposit'];
		$data['total_deduction_per']=$salary_deduction_list['deduction_amount'];
		$data['current_month_deposit']=(isset($current_month_deposit->deposit_amount) && !empty($current_month_deposit->deposit_amount)) ? $current_month_deposit->deposit_amount : 0;
		return $data;
	
	}
	function deposit_data($employee_id){
		/* $this =& get_instance();
		$this->load->model('Deposit_Payment_Model'); */
		$this->Deposit_Payment_Model = new \App\Models\Deposit_Payment_Model();
		$get_deposit_list=$this->Deposit_Payment_Model->get_deposit_list($employee_id);
		$get_employees_details=$this->Deposit_Payment_Model->get_employees_details($employee_id);
		$get_deposit_total=$this->Deposit_Payment_Model->get_deposit_list($employee_id);
		$data=array();
		$arr=array();
		$total=0;
		foreach($get_deposit_list as $list){
			$arr['year'][]=$list->year;
			$arr['month'][]=date('F', mktime(0, 0, 0, $list->month, 10));
			$arr['deposit_amount'][]=$list->deposit_amount;
			$total +=$list->deposit_amount;
		}
		
		$data['employee_name']=$get_employees_details[0]->fname." ".$get_employees_details[0]->lname;
		$data['salary']=$get_employees_details[0]->salary;
		$data['salary_deduction']=$get_employees_details[0]->salary_deduction;
		
		if(!empty($arr)){
			$data['deposit_data']=$arr;
			$data['salary_deduction']=$get_deposit_total[0]->deposit_amount;
			$data['total_deposit']=$total;
		}else{
			$data['deposit_data']="empty";
			$data['salary_deduction']="0";
			$data['total_deposit']="0";
		}
		return $data;
	
	}
	function employee_leave_count($data){
		
		/* $this =& get_instance();
		$this->load->model('Leave_Request_Model');
		$this->load->model('Leave_Report_Model'); */
		$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
		$this->Leave_Report_Model = new \App\Models\Leave_Report_Model();
		
		$employee_id=$data['employee_id'];
		$monthNum  = 12;
		$paid_leave  = 12;
		$sick_leave  = 5;
		$prev_year=date("Y",strtotime("-1 year"));
		$year_start_date = date($prev_year.'-m-01', mktime(0, 0, 0, $monthNum, 10)); 
		$year_end_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($year_start_date)) . " + 1 year"));
		$get_employee_leave_total=$this->Leave_Request_Model->get_employee_leave_total($employee_id,$year_start_date,$year_end_date);
		$arr = $sick_leave_count = $paid_leave_count = $paid_leave_count1 = $sick_leave_count1 =array();
		
		if(!empty($get_employee_leave_total)){
			$i=1;
			foreach($get_employee_leave_total as $leave){
				//print_r($get_employee_leave_total);
				if($leave->status == "approved" && $leave->leave_status == "paid"){
					$paid_leave_count[]=$leave->leave_date;
					$paid_leave_count1[]=date("F", strtotime($leave->leave_date));
				}
				if($leave->status == "approved" && $leave->leave_status == "sick"){
					$sick_leave_count[]=$leave->leave_date;
					$sick_leave_count1[]=date("F", strtotime($leave->leave_date));
				}
			}
		}
		$monthNum1=date("m");
		$months = $months1 = array();
		$a=0;
		if($monthNum1 == 12){
			$a="1";				
		} else if($monthNum1 == 1){
			$a="2";	
		} else if($monthNum1 == 2){
			$a="3";	
		} else if($monthNum1 == 3){
			$a="4";	
		} else if($monthNum1 == 4){
			$a="5";	
		} else if($monthNum1 == 5){
			$a="6";	
		} else if($monthNum1 == 6){
			$a="7";	
		} else if($monthNum1 == 7){
			$a="8";	
		} else if($monthNum1 == 8){
			$a="9";	
		}else if($monthNum1 == 9){
			$a="10";	
		}else if($monthNum1 == 10){
			$a="11";	
		}else if($monthNum1 == 11){
			$a="12";	
		}
			
		for ($i = 0; $i < $a; $i++) 
		{
			//if(strtotime($year_start_date) >= strtotime("2019-12-01") && strtotime($year_end_date) >= strtotime("2020-12-01")){
				
					if(!in_array(date("F", strtotime( date( 'Y-'.$monthNum1.'-01' )." -$i months")),$paid_leave_count1)){
						$months[]= date("F", strtotime( date( 'Y-'.$monthNum1.'-01' )." -$i months"));
					}
				
			//}
		}	
		$monthly_paid_leave_total=$this->monthly_paid_leave_total(array('employee_id' => $employee_id));
		$p = $t = 0;
		if(isset($monthly_paid_leave_total['monthly_paid_leave'])){
			$p=$monthly_paid_leave_total['monthly_paid_leave'];
		}
		/* if(isset($monthly_paid_leave_total['total_paid_leave_remaining'])){
			//$t=$monthly_paid_leave_total['total_paid_leave_remaining'];
		} */
		
		$salary_pay_tbl = $this->Leave_Request_Model->get_salary_pay_paid_leave_count($employee_id);
		$total_paid_leaves=0;
		$date1=date('Y-01-01');
		$date2=date('Y-01-15',strtotime("+1 year"));
		foreach($salary_pay_tbl as $leave){
			$created_date=date("Y-m-d",strtotime($leave->created_date));
			if(strtotime($date1) <= strtotime($created_date) && strtotime($date2) >= strtotime($created_date)){
				$total_paid_leaves +=$leave->paid_leave;
			}
		}
		$employee_paid_leaves = $this->Leave_Report_Model->employee_paid_leaves($employee_id);
		$r="";
		if(!empty($employee_paid_leaves)){
			$used = $unused = $rejected = 0;
			//print_r($employee_paid_leaves);
			foreach($employee_paid_leaves as $leave_count){
				 if($leave_count->status == 'used'){
					$used++;
				}
				if($leave_count->status == 'unused'){
					$unused++;
				}
				if($leave_count->status == 'rejected'){
					$rejected++;
				} 
				
				
			}
				$total_paid_leaves=$used;
				$t=$unused;
				$r=$rejected;
		}
		$arr=array('this_month_paid_leave'=>$p,
					'current_month_num'=>$monthNum1,
					'paid_leave'=>$total_paid_leaves,
					'sick_leave'=>count($sick_leave_count),
					'remaing_paid_leave' =>$t ,
					'rejected_paid_leave' =>$r ,
					'remaing_sick_leave' => $sick_leave - count($sick_leave_count));
		return $arr;
	}
	function monthly_paid_leave_total($data){
		$employee_id=$data['employee_id'];
		/* $this =& get_instance();
		$this->load->model('Employee_Model'); */
		$this->Employee_Model = new \App\Models\Employee_Model();
		$employee_tbl=$this->Employee_Model->get_employee($employee_id);
		$leave_arr=array();
		if(!empty($employee_tbl)){
			$leave_arr['monthly_paid_leave']=$employee_tbl[0]->monthly_paid_leave;
		}
		/* $total_paid_leave=12;
		$current_month=date('F');
		for($m=0; $m<12; ++$m){
			$month_name=date('F', mktime(0, 0, 0, $m, 1));
			if($month_name == $current_month){
				$leave_arr['total_paid_leave_remaining']=$total_paid_leave - ($m+1);;
			}
			
		} */
		return $leave_arr;
	}
	public function salary_average_total($employee_id){
		/* $this =& get_instance();
		$this->load->model('Employee_Increment_Model'); */
		$this->Employee_Increment_Model = new \App\Models\Employee_Increment_Model();
		$employee_increment=$this->Employee_Increment_Model->get_employee_increment_data($employee_id);
		$amount=0;
		$result=array();

		if(!empty($employee_increment)){
			$num = count($employee_increment);  
			$total = $employee_increment[0]->amount; 
			if(count($employee_increment) > 1){
				for($x=0;$x<$num;$x++)
				{  
				  $total = $total + $employee_increment[$x]->amount;  
				} 
			}
			$result['average']=$num;
			$result['average_total']=$total;
			$result['average_amount']=$total/$num;
			//print_r($result);
		}
		return $result;
	}
	function paid_leave_perday($average_amount){
		/* $this =& get_instance(); */
		return $average_amount/$this->config->item('averageMonthday');
	}
	/* hfshb */
	public function unapproved_leave($employee_id,$month,$year){
		/* $this =& get_instance();
		$this->load->model('Leave_Request_Model'); */
		$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
		$config_unapproved_leave=Unapproved_Leave;
		$get_leave_not_approved_list=$this->Leave_Request_Model->get_leave_not_approved_list($employee_id,$month,$year);
		$result['not_approved'] = $not_approved = 0;
		$result['not_approved_day_count'] = $not_approved_day_count = 0;
		if(!empty($get_leave_not_approved_list)){
			$result['not_approved'] = $not_approved =count($get_leave_not_approved_list);
			
			$not_approved_date=array();
			foreach($get_leave_not_approved_list as $not_approved_day){
				$not_approved_date[]=$not_approved_day->leave_date;
				$result['not_approved_day_count'] = $not_approved_day_count += 1+$config_unapproved_leave;
			}
		}
		return $result;
	}
	
	public function total_holiday($month,$year){
		/* $this =& get_instance();
		$this->load->model('Holiday_Model'); */
		$this->Holiday_Model = new \App\Models\Holiday_Model();
		$result = array();
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
		$result['no_of_days']=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		$no_of_sundays=0;
		$result['total_days'] = $total_days=cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$salary_month=date('Y-m-d',strtotime($year.'-'.$month.'-01'));
		$chnage_time=CHANGE_TIME;
		if(strtotime($chnage_time) <= strtotime($salary_month)){
			for($i=1;$i<=$total_days;$i++){
				if(date('N',strtotime($year.'-'.$month.'-'.$i))>=6)
				$no_of_sundays++;
			} 

		}else{ 
			for($i=1;$i<=$total_days;$i++){
					if(date('N',strtotime($year.'-'.$month.'-'.$i))==7)
						$no_of_sundays++;
			} 
		}
		// total holiday
		$result['total_holiday'] = $total_holiday = isset($get_holidays[0]) ? $get_holidays[0]->no_of_holidays-$num : "0";
		//  one -  fullday and half day pay details
		$result['month_day']=$total_days - ($no_of_sundays + $total_holiday);

		return $result;
	}
	
	function leave_deduction($employee_id,$month,$year,$salary){
		// unused
		/* $this =& get_instance();
		$this->load->model('Employee_Attendance_Model'); */
		$this->Employee_Attendance_Model = new \App\Models\Employee_Attendance_Model();
		$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
		$leave_list=array('employee_id' => $employee_id);
		$get_total_month_leave_list=$this->Leave_Request_Model->get_total_month_leave_list($employee_id,$month,$year);
		$monthly_paid_leave_total=$this->monthly_paid_leave_total($leave_list);
		$p = $t = 0;
		if(!empty($get_total_month_leave_list)){
			if(isset($monthly_paid_leave_total['monthly_paid_leave'])){
				$p=$monthly_paid_leave_total['monthly_paid_leave'];
			}
			/* if(isset($monthly_paid_leave_total['total_paid_leave_remaining'])){
				$t=$monthly_paid_leave_total['total_paid_leave_remaining'];
			} */
		}
		$leave_list_count=$this->employee_leave_count($leave_list);
		$total_holiday = $this->total_holiday($month,$year);
		$unapproved_leave = $this->unapproved_leave($employee_id,$month,$year);
		// $paid_leave_total = $leave_list_count['paid_leave_total'];

		$one=$salary/$total_holiday['month_day'];
		$h=$one/2;
		$month_name=date('F',mktime(0,0,0,$month));
		$emp_day_all=$this->Employee_Attendance_Model->salary_count_day($month_name,$year,$employee_id);
		$full_day = $half_day = 0;
		foreach ($emp_day_all as $key => $value) {
			if($value->attendance_type =='full_day'){
					$full_day++;
			}
			if($value->attendance_type=='half_day'){
					$half_day++;	
			}
		}
		$paid_leave = 0;
		$a=$total_holiday['month_day'] - ($full_day+$half_day);
		if(empty($a) && $a == "0"){
			if(!empty($half_day) && $half_day != "0"){
				if($half_day < 1){
					$paid_leave = 0;
				}else{
					if(isset($monthly_paid_leave_total['monthly_paid_leave'])){
						$p=$monthly_paid_leave_total['monthly_paid_leave'];
					}
					/* if(isset($monthly_paid_leave_total['total_paid_leave_remaining'])){
						$t=$monthly_paid_leave_total['total_paid_leave_remaining'];
					}  */
				
					$paid_leave = isset($p) ? $p : "0";
				}
			}else{
				$paid_leave = 0;
			}
		}else{		
			$paid_leave = isset($p) ? $p : "0";
		}
		$leave_day =(($total_holiday['month_day'] - ($full_day + $half_day*0.5)) - $unapproved_leave['not_approved']) + $unapproved_leave['not_approved_day_count'];
		$result['total_day'] = $total_holiday['month_day'] - $leave_day;
		
		
		if($leave_day >= $p){
			$result['full_day_count']= ($total_holiday['month_day'] - $result['total_day']) - $paid_leave;
			$result['paid_leave'] = $paid_leave;
		}else{
			$f=($total_holiday['month_day'] - $result['total_day']);
			$pos = strrpos($f, ".5");
			if ($pos === false) { // note: three equal signs
				$paid_leave=$f;
			}else{
				$paid_leave=str_replace('.5','',$f);
			}
			$result['paid_leave'] = $a;
			$result['paid_leave_remaing'] = $paid_leave - ($total_holiday['month_day'] - $result['total_day']); // count
			$result['full_day_count'] = ($total_holiday['month_day'] - $result['total_day']) - $paid_leave;
		}
			
		if ( strstr($result['total_day'], '.' ) ) {
			$d=floor($result['total_day']);
			$paid_leave_total=($one*$paid_leave);
			$total_salary=($one*$d)+$h+$paid_leave_total;
		}else{	
			$paid_leave_total=($one*$paid_leave);
			$total_salary=($one*$result['total_day'])+$paid_leave_total;
		}
		return $salary - $total_salary;
	} 
	function salary_deduction($employee_id,$month,$year){
		$data = array();
		/* $this =& get_instance();
		$this->load->model('Employee_Model');
		$this->load->model('Leave_Request_Model');
		$this->load->model('Holiday_Model');
		$this->load->model('Deposit_Payment_Model');
		$this->load->model('Employee_Increment_Model'); */
		$this->Employee_Increment_Model = new \App\Models\Employee_Increment_Model();
		$this->Employee_Model = new \App\Models\Employee_Model();
		$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
		$this->Holiday_Model = new \App\Models\Holiday_Model();
		$this->Deposit_Payment_Model = new \App\Models\Deposit_Payment_Model();

        $get_employee_increment_data= $this->Employee_Increment_Model->get_employee_increment_data($employee_id);
		$employee_tbl=$this->Employee_Model->get_employee($employee_id);
		if(empty($get_employee_increment_data)){
			$net_salary = $employee_tbl[0]->salary;
		}else{
			$net_salary = $get_employee_increment_data[0]->amount;
		}
		$prof_tax = $this->prof_tax($net_salary);
		
		// $leave_deduction = number_format($this->leave_deduction($employee_id,$month,$year,$net_salary));
		$leave_deduction = ($this->leave_deduction($employee_id,$month,$year,$net_salary));
		
		$salary = $net_salary-$prof_tax;
		$diposit_salary = $salary-$leave_deduction;
		$total_deposit = $total_deposit_pr = 0;
		$deposit=$this->Deposit_Payment_Model->get_deposit_list($employee_id,'pending');
		if($deposit){
			foreach($deposit as $d){
				$total_deposit += $d->deposit_amount;
			}
		}
		if($employee_tbl[0]->employee_status == 'employee' && $employee_tbl[0]->salary_deduction > 0){
			if(empty($deposit)){
				if($diposit_salary == $salary){
					$pr = ($salary == 0)? 0 : (($salary/$salary)*100);
					$data['salary'] = 0;
					$data['total_deposit'] = $salary;
					$data['deduction_pr'] = $pr;
					$data['deduction_amount'] = ($salary);
				}else{
					$pr = ($diposit_salary == 0 || $salary == 0)? 0 : (($diposit_salary/$salary)*100);
					$data['salary'] = 0;
					$data['total_deposit'] = $diposit_salary;
					$data['deduction_pr'] = number_format($pr,2);
					$data['deduction_amount'] = ($diposit_salary);
				}
			}else{
				if($total_deposit >= $salary){
					$data['salary'] = $salary;
					$data['total_deposit'] = ($total_deposit);
					$data['deduction_pr'] = 0;
					$data['deduction_amount'] = 0;
				}else{
					$deduction_amount = $salary-$total_deposit;
					if(($diposit_salary-$deduction_amount) < 0){
						$pr = (($diposit_salary/$salary)*100);
						$deduction_pr = $pr;
						$deduction_amount = $diposit_salary;
						$after_deduct_salary = 0;
					}else{
						$pr = (($diposit_salary/$salary)*100);
						$deduction_pr = $pr;
						$after_deduct_salary = $diposit_salary-$deduction_amount;
					}
					$data['salary'] = $after_deduct_salary;
					$data['total_deposit'] = ($total_deposit);
					$data['deduction_pr'] = number_format($deduction_pr,2);
					$data['deduction_amount'] = ($deduction_amount);
				}
			}
			if($data['total_deposit'] >= $salary){
				$data['change_pr'] = 0;
			}else{
				$pr = (($data['total_deposit']/$salary)*100);
				$data['change_pr'] = number_format(100-$pr,2);
			}
		}else{
			if($salary == 0 || $total_deposit == 0){
				$pr = 0;
			}else{
				$pr = (($total_deposit/$salary)*100);
			}
			$data['salary'] = $employee_tbl[0]->salary;
			$data['total_deposit'] = $total_deposit;
			$data['deduction_pr'] = 0;
			$data['deduction_amount'] = 0;
			$data['change_pr'] = $employee_tbl[0]->salary_deduction;
		}
		return $data;
	}
	/* hfshb */
 	function salary_details($data=array()){
		/* $this =& get_instance(); */
		$config_unapproved_leave=Unapproved_Leave;
		$result=array();
		if(!empty($data)){
			/* $this->load->model('Employee_Model');
			$this->load->model('Leave_Request_Model');
			$this->load->model('Holiday_Model');
			$this->load->model('Employee_Attendance_Model');
			$this->load->model('Employee_Increment_Model'); */
			$this->Employee_Model = new \App\Models\Employee_Model();
			$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
			$this->Holiday_Model = new \App\Models\Holiday_Model();
			$this->Employee_Attendance_Model = new \App\Models\Employee_Attendance_Model();
			$this->Employee_Increment_Model = new \App\Models\Employee_Increment_Model();
			
			//
			$month=$data['month'];
			$year=$data['year'];
			$employee_id=$data['employee_id'];	
			$timedata=$this->employee_total_working_time(array('employee_id' => $employee_id,'month' => $month,'year'=>$year));
			$result['plus_time']=$timedata['plus_time'];
			$result['minus_time']=$timedata['minus_time'];
			$result['total_time']=$timedata['total_time'];
			$result['time_status']=$timedata['time_status'];

			$salary_deduction_arr = $this->salary_deduction($employee_id,$month,$year);
			//print_r($timedata);
			$employee_tbl=$this->Employee_Model->get_employee($employee_id);
			$get_increment=$this->Employee_Increment_Model->get_employee_increment_data($employee_id,'pending');
			$result['note_message']="";
			if(!empty($get_increment)){
				$current_month_date = date($year.'-'.$month.'-1');
				   $increment_date_month = date("Y-m-d", strtotime($get_increment[0]->increment_date." -1 months"));

				//$increment_date_month = date($get_increment[0]->increment_date,strtotime("-1 months"));
				$current_month_date = date($year.'-'.$month.'-1');
				$increment_month = date('m',strtotime($increment_date_month));
				$increment_year = date('Y',strtotime($increment_date_month));	
				$result['note_message1']=$increment_date_month." - ".$increment_month." - ".$increment_year;
				$result['note_message2']= date('m', strtotime($current_month_date))." - ". date('Y', strtotime($current_month_date));
				
				if($increment_month == date('m', strtotime($current_month_date)) && $increment_year == date('Y', strtotime($current_month_date))){
					//if(strtotime($increment_date_month) < strtotime(date('Y-m-d',strtotime($current_month_date)))){
						$result['note_message']=$employee_tbl[0]->fname." ".$employee_tbl[0]->lname.", 1 Year is completed, Kindly refund his Paid Leave & LTIP amount has to be paid.";
					//}
				}
			}
			$basic_salary_data=$data['basic_salary'];
			$bonus_data=round($data['bonus']);
			if($bonus_data == 0){
				$result['bonus'] = $bonus =0;
			}else{
				$result['bonus'] = $bonus = $bonus_data;
			}
			$salary_deduction=0;
			$deduction=0;
			$next_month_ts = strtotime($year.'-'.$month.'-1 +1 month');
			$prev_month_number = date('m', $next_month_ts);
			
			//employee table	
			$month_name = date("F", mktime(0, 0, 0, $month, 10)); 
			$result['name']=$employee_tbl[0]->fname." ".$employee_tbl[0]->lname . " - ".$employee_tbl[0]->name;
			$result['employed_date']=$employee_tbl[0]->employed_date;
			$result['month_year_name']=$month_name." - ".$year;
			 $result['skip_paid_leave']=$employee_tbl[0]->skip_paid_leave;
			if($basic_salary_data == 0){
				$result['basic_salary']= $basic_salary = $employee_tbl[0]->salary;
			}else{
				$result['basic_salary']= $basic_salary = $basic_salary_data;
			}
			$select_month_date = date("Y-m-d", mktime(0, 0, 0, $month, 10));
			 $employee_tbl[0]->employed_date;
			 $employee_tbl[0]->employee_status;
			if($employee_tbl[0]->employed_date == "0000-00-00"){
				$result['salary_deduction_per']= $salary_deduction_per = 0;
				$result['salary_deduction_per_amount'] = $salary_deduction_per_amount = 0;
			}else{
				//echo $employee_tbl[0]->employed_date;
				if((strtotime($select_month_date) >= strtotime($employee_tbl[0]->employed_date)) && $employee_tbl[0]->employee_status == "employee"){
				//$v="1";
				// $result['salary_deduction_per']= $salary_deduction_per = $employee_tbl[0]->salary_deduction;
				// $result['salary_deduction_per_amount'] = $salary_deduction_per_amount = isset($employee_tbl[0]->salary_deduction) ? (($basic_salary * $employee_tbl[0]->salary_deduction)/100):"0";
				$result['salary_deduction_per']= $salary_deduction_per = $salary_deduction_arr['deduction_pr'];
				$result['salary_deduction_per_amount'] = $salary_deduction_per_amount = $salary_deduction_arr['deduction_amount'];
				}else{
					$result['salary_deduction_per']= $salary_deduction_per = 0;
					$result['salary_deduction_per_amount'] = $salary_deduction_per_amount = 0;
					//$v="0";
				}	
				//echo $v;
			}
		
	
			$get_total_month_leave_list=$this->Leave_Request_Model->get_total_month_leave_list($employee_id,$month,$year);
			$leave=array();
			// $monthly_paid_leave_total=$this->monthly_paid_leave_total(array('employee_id' => $employee_id));
			$monthly_paid_leave_total=$this->employee_leave_count(array('employee_id' => $employee_id));
			$p = $t = 0;
			
			if(!empty($get_total_month_leave_list)){
				if(isset($monthly_paid_leave_total['remaing_paid_leave'])){
					$p=$monthly_paid_leave_total['remaing_paid_leave'];
				}
				/* if(isset($monthly_paid_leave_total['this_month_paid_leave'])){
					$p=$monthly_paid_leave_total['this_month_paid_leave'];
				} */
				/* if(isset($monthly_paid_leave_total['total_paid_leave_remaining'])){
					$t=$monthly_paid_leave_total['total_paid_leave_remaining'];
				} */
				//echo "<pre>";$leave=array();
				//print_r($get_total_month_leave_list);
				
				foreach($get_total_month_leave_list as $l){
						if($l->leave_status == "paid" && $l->status == "approved"){
							$leave['paid'][]=$l->leave_date;
						}
						if($l->leave_status == "none" && $l->status == "approved"){
							$leave['unpaid'][]=$l->leave_date;
						}
						if($l->leave_status == "sick" && $l->status == "approved"){
							$leave['sick'][]=$l->leave_date;
						}
						if($l->status == "approved"){
							$leave['approved'][]=$l->leave_date;
						}
						if($l->status == "unapproved" || $l->status == "rejected"){
							$leave['unapproved'][]=$l->leave_date;
						}
						if($l->status == "approved" || $l->status == "rejected"){
							$leave['leaves_total'][]=$l->leave_date;
						}
				}
				
				//print_r($leave);
				
			}else{
				
			}
			
			$get_employees_leave_request_list=$this->Leave_Request_Model->get_employees_leave_request_list($employee_id,$month,$year);
			$leave_list=array('employee_id' => $employee_id);
			$leave_list_count=$this->employee_leave_count($leave_list);
			$paid_leave_used_total=$leave_list_count['paid_leave'];
			$remaing_paid_leave_total=$leave_list_count['remaing_paid_leave'];

			$sick_leave_used_total=$leave_list_count['sick_leave'];
			
			$paid_leave_total  = 12;
			$sick_leave_total  = 5;
			if($sick_leave_total >= $sick_leave_used_total){
				$result['sick_leave']=isset($leave['sick']) ? count($leave['sick']) : "0";
			}else{
				$result['sick_leave']="0";
			}
			$paid_leave = 0;
		
			//Year Total Remaining Leave 
			$current_date=date('Y-m-d');
			$novmber_last_date=date('Y-m-d',strtotime(date('Y-11-30')));
			$remaining_leave_salary=0;
			if(strtotime($novmber_last_date) > strtotime($current_date)){
				$result['remaing_paid_leave_total']=0;
				$result['remaing_paid_leave_salary']=0;
			}else{
				if($month == "11"){
					$remaining_leave_salary=($basic_salary/30)*$remaing_paid_leave_total;
					$result['remaing_paid_leave_total']=$remaing_paid_leave_total;
					$result['remaing_paid_leave_salary']=round($remaining_leave_salary);
				}else{
					$result['remaing_paid_leave_total']=0;
					$result['remaing_paid_leave_salary']=0;
				}
			}
			//not approved leave request list
			$get_leave_not_approved_list=$this->Leave_Request_Model->get_leave_not_approved_list($employee_id,$month,$year);
			$result['not_approved'] = $not_approved = 0;
			$result['not_approved_day_count'] = $not_approved_day_count = 0;
			if(!empty($get_leave_not_approved_list)){
				$result['not_approved'] = $not_approved =count($get_leave_not_approved_list);
				
				$not_approved_date=array();
				foreach($get_leave_not_approved_list as $not_approved_day){
					$not_approved_date[]=$not_approved_day->leave_date;
					$result['not_approved_day_count'] = $not_approved_day_count += 1+$config_unapproved_leave;
				}
			}
			// holiday count
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
			$salary_month=date('Y-m-d',strtotime($year.'-'.$month.'-01'));
			$chnage_time=CHANGE_TIME;
			if(strtotime($chnage_time) <= strtotime($salary_month)){
				for($i=1;$i<=$total_days;$i++){
					if(date('N',strtotime($year.'-'.$month.'-'.$i))>=6)
					$no_of_sundays++;
				} 

			}else{ 
				for($i=1;$i<=$total_days;$i++){
						if(date('N',strtotime($year.'-'.$month.'-'.$i))==7)
							$no_of_sundays++;
				} 
			}
			// total holiday
			 $total_holiday = isset($get_holidays[0]) ? $get_holidays[0]->no_of_holidays-$num : "0";
			//  one -  fullday and half day pay details
			$month_day=$total_days - ($no_of_sundays + $total_holiday);	
			
			$one=$basic_salary/$month_day;
			$h=$one/2;
			
			// salary count day
			$month_name=date('F',mktime(0,0,0,$month));
			$emp_day_all=$this->Employee_Attendance_Model->salary_count_day($month_name,$year,$employee_id);
			$full_day = $half_day = 0;
			foreach ($emp_day_all as $key => $value) {
				if($value->attendance_type =='full_day'){
						$full_day++;
				}
				if($value->attendance_type=='half_day'){
						$half_day++;	
				}
			}
			$paid_leave = 0;
			// $a=$month_day - ($full_day+$half_day);
			$a=$month_day - ($full_day+($half_day/2));
			if(empty($a) && $a == "0"){
				//echo $half_day;
				if(!empty($half_day) && $half_day != "0"){
					if($half_day < 1){
						//0.5
						//echo "if1";
						$paid_leave = 0;
					}else{
						//echo "else";
						 if(isset($monthly_paid_leave_total['this_month_paid_leave'])){
							$p=$monthly_paid_leave_total['this_month_paid_leave'];
						}
						/* if(isset($monthly_paid_leave_total['total_paid_leave_remaining'])){
							$t=$monthly_paid_leave_total['total_paid_leave_remaining'];
						} */ 
					
						 $paid_leave = isset($p) ? $p : "0";
						
						//echo "sdsdsfd"; 
					}
				}else{
					//echo "if";
					 $paid_leave = 0;
				}
			}else{		
				//echo "else2";
				 $paid_leave = isset($p) ? $p : "0";
			}
			 $totalday=count($emp_day_all);
			 $total_add_extra=$one*$paid_leave+$bonus;
			 $leave_day =(($month_day - ($full_day + $half_day*0.5)) - $not_approved) + $not_approved_day_count;
			 $result['total_day'] = $month_day - $leave_day;
			
			 //leaves 
			 if($leave_day >= $p){
				 $result['full_day_count']= ($month_day - $result['total_day']) - $paid_leave;
				 $result['paid_leave'] = $paid_leave;
			 }else{
				 $f=($month_day - $result['total_day']);
				 $pos = strrpos($f, ".5");
				if ($pos === false) { // note: three equal signs
					$paid_leave=$f;
				}else{
					$paid_leave=str_replace('.5','',$f);
				}
				$result['paid_leave'] = $a;
				// $result['paid_leave'] = $paid_leave; 
				$result['paid_leave_remaing'] = $paid_leave - ($month_day - $result['total_day']); // count
				$result['full_day_count']= ($month_day - $result['total_day']) - $paid_leave;
			 }
			 /* $paid_leave = $this->Paid_Leave_Model->employee_paid_leave($employee_id);
			 echo '<pre>'; print_r( $paid_leave ); echo '</pre>';exit; */
			//  $result['paid_leave'] = '';
			 //die;
			 if ( strstr($result['total_day'], '.' ) ) {
				$d=floor($result['total_day']);
				$paid_leave_total=($one*$paid_leave);
				$total_salary=($one*$d)+$h+$paid_leave_total;
			}else{	
				$paid_leave_total=($one*$paid_leave);
				$total_salary=($one*$result['total_day'])+$paid_leave_total;
			}
		$prof_tax=$this->prof_tax($basic_salary);
		$result['total_salary']=round(((($total_salary + $bonus + $remaining_leave_salary)-$prof_tax)-$salary_deduction_per_amount));
		$result['half_day_count']= $half_day_count = $half_day*0.5;
		$result['payout_paid_leave']=0;
		$result['payout_paid_leave_days']=0;
		$salary_average_total=$this->salary_average_total($employee_id);
		if(!empty($salary_average_total) && isset($salary_average_total['average_amount'])){
			$paid_leave_perday=$this->paid_leave_perday($salary_average_total['average_amount']);
			$paid_leave_days=$remaing_paid_leave_total - $result['paid_leave'];
			if($paid_leave_days > 0){
				$result['payout_paid_leave']=round($paid_leave_perday * $paid_leave_days);
				$result['payout_paid_leave_days']=$paid_leave_days;
			}
		}
		$PF=0;
		
		//$result['total_add_extra']=$total_add_extra;
    	$lop=$one*$result['full_day_count'];
		
		
		$result['working_day']=$month_day;
		$result['offical_holiday']=$no_of_sundays + $total_holiday;
		$result['effetive_day'] =$result['total_day'];
		
		$result['absent_leave']=$result['full_day_count'];
		$approved_leave=isset($leave['approved']) ? count($leave['approved']) : "0";
		$result['approved_leave']=$approved_leave + ($half_day*0.5);
		$result['unapproved_leave']=isset($leave['unapproved']) ? count($leave['unapproved']) : "0";
		//$result['paid_leave']=isset($leave['paid']) ? count($leave['paid']) : "0";
		$result['unpaid_leave']=isset($leave['unpaid']) ? count($leave['unpaid']) : "0";
		//$result['sick_leave']=isset($leave['sick']) ? count($leave['sick']) : "0";
		if(isset($leave['leaves_total']) && !empty($leave['leaves_total'])){
			$result['leaves_total']=count($leave['leaves_total'])+ ($half_day*0.5) + ($result['unapproved_leave']*$config_unapproved_leave);
		}else{
			$result['leaves_total']=0;
			if($half_day != "" && $half_day != '0'){
				$result['leaves_total']=$half_day*0.5;
			}
			
		}
		
		//echo $p; echo "<br>"; // paid leave remaing
		//echo $result['leaves_total']; echo "<br>"; // paid leave remaing
		//echo $leave_day; //  not approve day + full and half leave count
		if($result['effetive_day'] != '0'){
			$result['salary_deduction_per_new']=$salary_deduction_per_amount;
			$result['prof_tax']= $prof_tax;
		}else{
			$result['salary_deduction_per_new']=0;
			$result['prof_tax']= 0;
		}
		
		$total_deposit_data=$this->total_deposit_data($employee_id,$month,$year);
		if(!empty($total_deposit_data)){
			$result['deposit']=$total_deposit_data['total_deposit']-$salary_deduction_per_amount;
		}else{
			$result['deposit']=$total_deposit_data['total_deposit']-$salary_deduction_per_amount;
		}
		// $result['current_month_deposit']=$total_deposit_data['current_month_deposit'];
		$result['current_month_deposit']=$salary_deduction_per_amount;
		$result['PF'] = 0;
		
		$result['deduction']=number_format($basic_salary - $total_salary);
		$result['total_deduction']= number_format($basic_salary - $total_salary);
		//$result['total_deduction_right']= ($deduction + $PF + $prof_tax + $lop);
		//$result['total_deduction_left']= ($basic_salary - $total_salary) + $deduction;
		$result['LOP']=number_format($lop,2);
		$result['payment_status']="unpaid";
		$result['data-lop']=$lop;
		$result['data_total_deduction']=$basic_salary - $total_salary;
		$result['remaing_paid_leave']=$monthly_paid_leave_total['remaing_paid_leave'];
		$result['data_deduction']=$basic_salary - $total_salary;
		$result['deposit_paid']=0;
		}
		return $result;
	}
	function salary_view_details($data=array()){
		/* $this =& get_instance();
		$this->load->model('Employee_Model');
		$this->load->model('Paid_Leave_Model');
		$this->load->model('Leave_Report_Model'); */
		$this->Employee_Model = new \App\Models\Employee_Model();
		$this->Paid_Leave_Model = new \App\Models\Paid_Leave_Model();
		$this->Leave_Report_Model = new \App\Models\Leave_Report_Model();
		$employee_tbl=$this->Employee_Model->get_employee($data[0]->employee_id);
		//echo "<pre>"; print_r($employee_tbl);echo "<pre>";die;
		$leaves_total=$data[0]->unapproved_leave + $data[0]->approve_leave;
		$result=array();
		//print_r($data[0]);
		$paid_leave_payout=$this->Leave_Report_Model->employee_paid_leaves($data[0]->employee_id,'paid');
		
		$result['name']=$employee_tbl[0]->fname." ".$employee_tbl[0]->lname . " - ".$employee_tbl[0]->name;
		$result['employed_date']=$employee_tbl[0]->employed_date;
		$total_deposit_data=$this->total_deposit_data($data[0]->employee_id,$data[0]->month,$data[0]->year);
		$salary_deduction_arr = $this->salary_deduction($data[0]->employee_id,$data[0]->month,$data[0]->year);
		$result['skip_paid_leave']=$employee_tbl[0]->skip_paid_leave;
		$result['deposit']=$salary_deduction_arr['total_deposit']-$salary_deduction_arr['deduction_amount'];
		// $result['deposit']=$total_deposit_data['total_deposit'];
		$result['deposit_paid']=$data[0]->deposit;
		$result['PF'] = 0;
		if(!empty($data[0]->payout_paid_leave)){
			$result['payout_paid_leave_checkbox']="checked";
			$result['payout_paid_leave_days']=count($paid_leave_payout);
			$result['payout_paid_leave']=$data[0]->payout_paid_leave;
		}else{
			$salary_average_total=$this->salary_average_total($data[0]->employee_id);
			if(!empty($salary_average_total) && isset($salary_average_total['average_amount'])){
				$leave_list=array('employee_id' => $data[0]->employee_id);
				$leave_list_count=$this->employee_leave_count($leave_list);
				$remaing_paid_leave_total=$leave_list_count['remaing_paid_leave'];
				$paid_leave_perday=$salary_average_total['average_amount']/$data[0]->working_day;
				$paid_leave_days=$remaing_paid_leave_total;
				
				if($paid_leave_days > 0){
					$result['payout_paid_leave']=round($paid_leave_perday * $paid_leave_days);
					$result['payout_paid_leave_days']=$paid_leave_days;
				}
				$result['payout_paid_leave_checkbox']="";
			}else{
				$result['payout_paid_leave_checkbox']="";
				$result['payout_paid_leave']=0;
				$result['payout_paid_leave_days']=0;
			}
		}
		
		/* $salary_average_total=$this->salary_average_total($employee_id);
		if(!empty($salary_average_total) && isset($salary_average_total['average_amount'])){
			$paid_leave_perday=$salary_average_total['average_amount']/$month_day;
			$paid_leave_days=$remaing_paid_leave_total;
		} */
		
		$result['note_message']="";
		$result['payout_paid_leave_days']=0;
		$result['prof_tax']= number_format($data[0]->prof_tax,2);
		$result['deduction']=number_format($data[0]->deduction,2);
		$result['salary_deduction_per']= $data[0]->per_deduction;
		$result['salary_deduction_per_new']=$data[0]->amount_deduction;
		// $result['current_month_deposit']=$total_deposit_data['current_month_deposit'];
		$result['current_month_deposit']=$salary_deduction_arr['deduction_amount'];
		$result['salary_deduction_per_amount'] =$data[0]->amount_deduction;
		$result['absent_leave']=$data[0]->absent_leave;
		$result['approved_leave']=$data[0]->approve_leave;
		$result['unapproved_leave']=$data[0]->unapproved_leave;
		$result['paid_leave']=$data[0]->paid_leave;
		$result['unpaid_leave']=0;
		$result['sick_leave']=$data[0]->sick_leave;
		$result['leaves_total']=$data[0]->total_leaves;
		$result['working_day']=$data[0]->working_day;
		$result['offical_holiday']=$data[0]->official_holiday;
		$result['effetive_day'] =$data[0]->effective_day;
		$result['total_day']=$data[0]->effective_day;
		$result['half_day_count']=0;
		$result['total_salary']=round($data[0]->net_salary);
		$result['bonus']=round($data[0]->bonus);
		$month_name = date("F", mktime(0, 0, 0, $data[0]->month, 10)); 
		$result['month_year_name']=$month_name." - ".$data[0]->year;
		$result['basic_salary']=number_format($data[0]->basic_salary,2);
		$result['not_approved']=$data[0]->unapproved_leave;
		$result['not_approved_day_count']=$data[0]->unapproved_leave;
		$result['payment_status']=$data[0]->payment_status;
		$result['bankstatus']=$data[0]->bankstatus;
		$timedata=$this->employee_total_working_time(array('employee_id' => $data[0]->employee_id,'month' => $data[0]->month,'year'=>$data[0]->year));
		$result['plus_time']=$timedata['plus_time'];
		$result['minus_time']=$timedata['minus_time'];
		$result['total_time']=$timedata['total_time'];
		$result['time_status']=$timedata['time_status'];
		$result['remaing_paid_leave_total']=0;
		$result['remaing_paid_leave_salary']=0;
		$result['data-lop']='';
		$result['lop']='';
		$result['data_total_deduction']=$data[0]->basic_salary - $data[0]->net_salary;
		$result['data_deduction']=$data[0]->basic_salary - $data[0]->net_salary;
		return $result;
	}
	function view_time_formate($seconds) {
        // CONVERT TO HH:MM:SS
        $hours = floor($seconds/3600);
        $remainder_1 = ($seconds % 3600);
        $minutes = floor($remainder_1 / 60);
        $seconds = ($remainder_1 % 60);
        if(strlen($hours) == 1) {
            $hours = "0".$hours;
        }
        if(strlen($minutes) == 1) {
            $minutes = "0".$minutes;
        }
        if(strlen($seconds) == 1) {
            $seconds = "0".$seconds;
        }

        return $hours.":".$minutes."";
	}
	function seconds($seconds) {
        // CONVERT TO HH:MM:SS
        $hours = floor($seconds/3600);
        $remainder_1 = ($seconds % 3600);
        $minutes = floor($remainder_1 / 60);
        $seconds = ($remainder_1 % 60);
        if(strlen($hours) == 1) {
            $hours = "0".$hours;
        }
        if(strlen($minutes) == 1) {
            $minutes = "0".$minutes;
        }
        if(strlen($seconds) == 1) {
            $seconds = "0".$seconds;
        }

        return $hours." Hours ".$minutes." Minutes";
	}
	function employee_total_working_time($data = array()){
		$month = $data['month'];
		$year = $data['year'];
		$id = $data['employee_id'];
		/* $this = &get_instance();
		$this->load->model('Reports_Model'); */
		$this->Reports_Model = new \App\Models\Reports_Model();
		$search['search_dropdwon'] = 7;
		$employee_attendance_list = $this->Reports_Model->get_report_attendance($id, $search, $month, $year);
		



		$plus_total_time = $minus_total_time = 0;
		if (isset($employee_attendance_list) && !empty($employee_attendance_list)) {
			$in = array_filter(explode(',', $employee_attendance_list[0]->employee_attendance_in));
			$out = array_filter(explode(',', $employee_attendance_list[0]->employee_attendance_out));
			$attendance_type = array_filter(explode(',', $employee_attendance_list[0]->employee_attendance_type));
			$arr = $att_date = array();

			$out_date_arr = $out_date_arr1 = array();
			if ($employee_attendance_list[0]->employee_attendance_in) {
				$j = 0;
				$out = array_filter(explode(',', $employee_attendance_list[0]->employee_attendance_out));

				if (!empty($out)) {
					foreach ($out as $o_date => $o) {

						if (DateTime::createFromFormat('Y-m-d H:i:s', $o) !== FALSE) {
							$dateout1 = date_create($o);
							$out_date1 = date_format($dateout1, "Y-m-d");
							$out_date_arr[$out_date1][] = $o;
							$out_date_arr1[] = $out_date1;
						}
						//$out_date_arr1[]=$o;

					}
				}
				$date2Timestamp = 0;
				$a = array_unique($out_date_arr1);
				if (!empty($in)) {
					foreach ($in as $k => $v) {
						$datein = date_create($v);
						$in_date = date_format($datein, "Y-m-d");
						//echo $k;
						$arr[$in_date]['in'][] = $newDateTime = date('h:i A', strtotime($v));
						if (isset($attendance_type[$k])) {
							if ($attendance_type[$k] == "full_day") {
								$day_name = "Full Day";
							} else {
								$day_name = "Half Day";
							}
						}
						$arr[$in_date]['attendance_types'][0] = $day_name;
						$date_key = array_keys($out_date_arr);
						if (in_array($in_date, $a)) {

							$date1Timestamp = strtotime($v);
							if (isset($out_date_arr[$in_date])) {
								if (isset($out_date_arr[$in_date][0])) {
									$arr[$in_date]['out'][0] = date('h:i A', strtotime($out_date_arr[$in_date][0]));
									$date2Timestamp = strtotime($arr[$in_date]['out'][0]);
									$seconds1 =  $date2Timestamp - $date1Timestamp;
									$arr[$in_date]['seconds'][] = 0;
								}
								if (isset($out_date_arr[$in_date][1])) {
									$arr[$in_date]['out'][1] = date('h:i A', strtotime($out_date_arr[$in_date][1]));
									$date2Timestamp = strtotime($arr[$in_date]['out'][1]);
									$seconds1 =  $date2Timestamp - $date1Timestamp;
									$arr[$in_date]['seconds'][] = 0;
								}
							}
							$att_date[] = $in_date;
						}
					}
				}
			}
		}
		$all_time=array();
		if(!empty($arr)){
		$in_time = $out_time = $in_time1 = $out_time1 = $daliy_time = $plus_total_time = $minus_total_time = 0;
		$full_second=28800; $half_second=16200; $total_time=0;
		$chnage_time=CHANGE_TIME;
		       
		foreach($arr as $m => $time_count){
			if(strtotime($chnage_time) <= strtotime($m)){
				$full_second=31500;	
			} 
			if(trim($time_count['attendance_types'][0]) == 'Half Day'){
				$full_second=16200;
			}
			$seconds_count=0; 
			if(isset($time_count['in'][0]) && isset($time_count['out'][0])){
				if(!empty($time_count['in'][0]) && !empty($time_count['out'][0])){
					$in_time = strtotime($time_count['in'][0]);
					$out_time = strtotime($time_count['out'][0]);
					$seconds_count=  $out_time - $in_time;
				}
			}
			$seconds_count1=0;
			if(isset($time_count['in'][1]) && isset($time_count['out'][1])){
				if(!empty($time_count['in'][1]) && !empty($time_count['out'][1])){
					$in_time1 = strtotime($time_count['in'][1]);
					$out_time1 = strtotime($time_count['out'][1]);
					$seconds_count1=  $out_time1 - $in_time1;
				}
			}
				$minus_time = $plus_time = 0;
				$daliy_time = $seconds_count + $seconds_count1;
				if($daliy_time != 0){
					$weekDay = date('w', strtotime($m));
					if($weekDay == 6){
						if($half_second <= $daliy_time){
							$plus_time=$daliy_time - $half_second;
							$plus_total_time+=$plus_time;
						}else{
							$minus_time=$half_second - $daliy_time;
							$minus_total_time+=$minus_time;
						}
					}else{
						if($full_second <= $daliy_time){
							$plus_time=$daliy_time - $full_second;
							$plus_total_time+=$plus_time;
						}else{
							$minus_time=$full_second - $daliy_time;
							$minus_total_time+=$minus_time;
						}
						
					}
				}
				if($plus_time != 0){
					$all_time[$m]['plus_time']=$this->seconds($plus_time);
				}
				if($minus_time != 0){
					$all_time[$m]['minus_time']=$this->seconds($minus_time);
				}
		}
		//echo "<pre>"; print_r($get_report_attendance); echo "</pre>";
		}
		
		if($plus_total_time < $minus_total_time){ $a="minus"; $t=$minus_total_time-$plus_total_time;  }else{ $a="plus"; $t=$plus_total_time-$minus_total_time; }
		$arr=array(

			'plus_time' => $this->view_time_formate($plus_total_time),
			'minus_time' => $this->view_time_formate($minus_total_time),
			'total_time' => $this->view_time_formate($t),
			'time_status' => $a,
		);
		return $arr;
		//$this->seconds($minus_total_time)." - ".$this->seconds($plus_total_time)." = ".$this->seconds($t)." = ".$a;
		
	}
	function check_year($number){
		$exp1 = '';
		if($number == 1){$exp1 .= $number.' Year';}else if($number <= 0){$exp1 .= '';}else{$exp1 .= $number.' Years';}
		return $exp1;
	}
	function check_month($number){
		$exp1 = '';
		if($number == 1){$exp1 .= $number.' Month';}else if($number <= 0){$exp1 .= '';}else{$exp1 .= $number.' Months';}
		return $exp1;
	}
	function get_month_year($num){
		$exp = '';
		if($num <= 0 ){$exp .= 'Fresher';}else{
			$number = explode('.',$num);
			if(isset($number[1])){
				$exp1 = '';
				$exp2 = '';
				if($number[1] > 11){
					$year1 = explode('.',''.((float)($number[1])/12));
					$year = $number[0] + $year1[0];
					$exp1 .= $this->check_year($year);
					$month = $number[1]-($year1[0]*12);
					$exp2 .= $this->check_month($month);
				}else{
					$exp1 .= $this->check_year($number[0]);
					$exp2 .= $this->check_month($number[1]);
				}
				$exp .= $exp1.' '.$exp2; 
			}else{
				$exp .= $this->check_year($number[0]);
			}
		}
		return $exp;
	}
	function allActive_employee(){
		$data = array();
		/* $this =& get_instance();
		$this->load->model('Employee_Model'); */
		$this->Employee_Model = new \App\Models\Employee_Model();
		$data['get_employee']=$this->Employee_Model->get_employee_list(1);
		return $data;
	}
	function curlPost($url, $params)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        /*curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,10);
         curl_setopt($curl_handle,CURLOPT_TIMEOUT ,15); */
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);
        $contents = curl_exec($curl_handle);
		curl_close($curl_handle);
        if (empty($contents))
        {
            return 0;
        }
        else
        {
            return json_decode($contents, true);
        }
    }
}
?>