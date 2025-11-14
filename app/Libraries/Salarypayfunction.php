<?php
	namespace App\Libraries;
	use CodeIgniter\I18n\Time;

	class Salarypayfunction 
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

		function working_holiday_days($temp){
			if(isset($temp['month']) && !empty($temp['month']) && isset($temp['year']) && !empty($temp['year'])){
				$data=array();
				$this->Salary_Pay_Model = new \App\Models\Salary_Pay_Model();
				$workingDays = $this->Salary_Pay_Model->getWorkingDays($temp);
				if(!empty($workingDays)){
					$data['total_working_days']=$workingDays[0]->working_days;
					$data['total_holiday_days']=$workingDays[0]->official_holidays;
				}else{	
					$month=$temp['month'];
					$year=$temp['year'];
					$this->Holiday_Model = new \App\Models\Holiday_Model();
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
						if(date('N',strtotime($year.'-'.$month.'-'.$i))>=6)
						$no_of_sundays++;
					} 
					$tbl_holiday = isset($get_holidays[0]) ? ($get_holidays[0]->no_of_holidays-$num) : "0";
					$data['total_holiday_days'] = $total_holiday=$no_of_sundays + $tbl_holiday;
					$data['total_working_days'] = $total_days - $total_holiday;
				}
				return  $data;
			}else{
				return  0;
			}
		}

		function employee_present_days($temp){
			if(isset($temp['month']) && !empty($temp['month']) && isset($temp['year']) && !empty($temp['year']) && isset($temp['employee_id']) && !empty($temp['employee_id'])){
				$data=array();
				$month=$temp['month'];
				$year=$temp['year'];
				$employee_id=$temp['employee_id'];
				
				$this->Employee_Model = new \App\Models\Employee_Model();
				$this->Employee_Attendance_Model = new \App\Models\Employee_Attendance_Model();
				
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
				$working_holiday_days=$this->working_holiday_days(array('month' => $month,'year' => $year));
				
				$data['full_day']=$full_day;
				$data['half_day']=$half_day;
				$data['total_present_days']= $total_present_days = ($full_day + ($half_day*0.5) );
				$data['total_absent_days']= (isset($working_holiday_days['total_working_days'])) ?  $working_holiday_days['total_working_days'] - $total_present_days : '0';
				return $data;
			}else{
				return 0;
			}

		}

		function employee_paid_leaves($temp){
			if(isset($temp['employee_id']) && !empty($temp['employee_id'])){
				$data=array();
				$employee_id=$temp['employee_id'];
				$month=$temp['month'];
				$year=$temp['year'];
				$this->Paid_Leave_Model = new \App\Models\Paid_Leave_Model();
				$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
				$next_paid_leaves = $this->Paid_Leave_Model->get_nextMonth_paidLeave($employee_id,'unused',$month,$year);
				$used_paid_leaves = $this->Paid_Leave_Model->employee_paid_leave($employee_id,'used');
				$unused_paid_leaves = $this->Paid_Leave_Model->employee_paid_leave($employee_id,'unused');
				$get_salary_pay=$this->Leave_Request_Model->get_salary_pay($employee_id,$month,$year);
				$paid_leave = !empty($get_salary_pay)?($get_salary_pay[0]->paid_leave) :0;
				$data['used_paid_leaves']= count($used_paid_leaves)-$paid_leave;
				$data['unused_paid_leaves']= count($unused_paid_leaves)+($paid_leave-count($next_paid_leaves));
				return $data;
			}else{
				return 0;
			}	
		}

		function employee_leaves($temp){
			if(isset($temp['month']) && !empty($temp['month']) && isset($temp['year']) && !empty($temp['year']) && isset($temp['employee_id']) && !empty($temp['employee_id'])){
				$data=array();
				$month=$temp['month'];
				$year=$temp['year'];
				$employee_id=$temp['employee_id'];
				
				$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
				$get_total_month_leave_list=$this->Leave_Request_Model->get_total_month_leave_list($employee_id,$month,$year);
				if(!empty($get_total_month_leave_list)){
					$leave=array();
					foreach($get_total_month_leave_list as $l){
						$employee_attendance = $this->Employee_Attendance_Model->get_employee_attendance_details($employee_id, $l->leave_date);
						if(count($employee_attendance) == 0){
							if($l->leave_status != "Sick" && $l->leave_status != "sick" && $l->status == "approved"){
								$leave['approved_leaves'][]=$l->leave_date;
							}
							if($l->leave_status == "sick" || $l->leave_status == "Sick" && $l->status == "approved"){
								$leave['sick_leave'][]=$l->leave_date;
							}
							if($l->status == "rejected" || $l->status == "unapproved"){
								$leave['unapproved_leave'][]=$l->leave_date;
							}
						}
					}
				}
				$employee_present_days=$this->employee_present_days(array('month' => $month,'year' => $year,'employee_id' => $employee_id));
				$total_absent_days=isset($employee_present_days['total_absent_days']) ? $employee_present_days['total_absent_days'] : "0";
				$total_present_days=isset($employee_present_days['total_present_days']) ? $employee_present_days['total_present_days'] : "0";
				
				
				
				$data['sick_leave']=isset($leave['sick_leave']) ? count($leave['sick_leave']) : "0";
				$data['approved_leaves']=isset($leave['approved_leaves']) ? count($leave['approved_leaves']) : "0";
				$data['unapproved_leave']= $unapproved_leave = isset($leave['unapproved_leave']) ? count($leave['unapproved_leave']) : "0";
				$data['unapproved_leave_cal']= $unapproved_leave_cal = (isset($unapproved_leave) && $unapproved_leave >= 0 ) ? ($unapproved_leave*1.5) : "0";
				
				$working_holiday_days = $this->working_holiday_days($temp);
				$employee_paid_leaves = $this->employee_paid_leaves($temp);
				
				$paid_leave = 0;
				$p = 0;
					if(isset($employee_paid_leaves['unused_paid_leaves'])){
						$p=$employee_paid_leaves['unused_paid_leaves'];
					}
					$a=$working_holiday_days['total_working_days'] - ($employee_present_days['full_day']+($employee_present_days['half_day']/2));
					if(empty($a) && $a == "0"){
						if(!empty($employee_present_days['half_day']) && $employee_present_days['half_day'] != "0"){
							if($employee_present_days['half_day'] < 1){
								$paid_leave = 0;
							}else{
								if(isset($employee_paid_leaves['unused_paid_leaves'])){
									$p=$employee_paid_leaves['unused_paid_leaves'];
								}
								$paid_leave = isset($p) ? $p : "0";
							}
						}else{
							$paid_leave = 0;
						}
					}else{		
						$paid_leave = isset($p) ? $p : "0";
					}
					$leave_day =(($working_holiday_days['total_working_days'] - ($employee_present_days['full_day'] + $employee_present_days['half_day']*0.5)) - $data['unapproved_leave']) + $data['unapproved_leave_cal'];
					$data['total_day'] = $working_holiday_days['total_working_days'] - $leave_day;
					
					if($leave_day >= $p){
						$data['total_leaves']= ($working_holiday_days['total_working_days'] - $data['total_day']) - $paid_leave;
						$data['paid_leave'] = str_replace('.5','',$paid_leave);
						// $data['paid_leave'] = $paid_leave;
					}else{
						$f=($working_holiday_days['total_working_days'] - $data['total_day']);
						$pos = strrpos($f, ".5");
						if ($pos === false) { 
							$paid_leave=$f;
						}else{
							$paid_leave=str_replace('.5','',$f);
						}
						$decimal_point = explode('.',$a);
						if(isset($decimal_point[0]) && !empty($decimal_point[0])){
							$data['paid_leave'] = $a;
						}else{
							$data['paid_leave'] = 0;
						}
						$data['paid_leave'] = str_replace('.5','',$data['paid_leave']);
						$data['total_leaves']= ($working_holiday_days['total_working_days'] - $data['total_day']) - $paid_leave;
					}
				return $data;
			}else{
				return 0;
			}
		}

		function employee_basicDetails($temp){
			if(isset($temp['employee_id']) && !empty($temp['employee_id'])){
				$employee_id=$temp['employee_id'];
				$this->Employee_Model = new \App\Models\Employee_Model();
				$employee_tbl=$this->Employee_Model->get_employee($employee_id);
				
				if(!empty($employee_tbl)){
					$data = $employee_tbl[0];
					return json_decode(json_encode($data), true);
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
		
		function employee_salary_calculation($temp){
			if(isset($temp['month']) && !empty($temp['month']) && isset($temp['year']) && !empty($temp['year']) && isset($temp['employee_id']) && !empty($temp['employee_id'])){
				$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
				$data=array();
				$month=$temp['month'];
				$year=$temp['year'];
				$employee_id=$temp['employee_id'];
				$employee_basicDetails = $this->employee_basicDetails($temp);
				$basic_salary=isset($employee_basicDetails['salary']) ? $employee_basicDetails['salary'] : 0;
				$get_salary_pay=$this->Leave_Request_Model->get_salary_pay($employee_id,$month,$year);
				$basic_salary = (empty($get_salary_pay))? $basic_salary : $get_salary_pay[0]->basic_salary;
				$working_holiday_days = $this->working_holiday_days($temp);
				$total_working_days=isset($working_holiday_days['total_working_days']) ? $working_holiday_days['total_working_days'] : "0";

				$employee_leaves = $this->employee_leaves($temp);
				$total_day=isset($employee_leaves['total_day']) ? $employee_leaves['total_day'] : 0;
				$paid_leave=isset($employee_leaves['paid_leave']) ? $employee_leaves['paid_leave'] : 0;
				$total_leaves=isset($employee_leaves['total_leaves']) ? $employee_leaves['total_leaves'] : 0;
				$perday_deduction=$basic_salary/$total_working_days;
				$halfday_deduction=$perday_deduction/2;
				$wdays=$total_day+$paid_leave;
				$data['prof_tax']=$prof_tax=$this->prof_tax($basic_salary);
				
				if ((int) $total_leaves == $total_leaves) {
					$data['total_leave_deduction'] = $total_leave_deduction=(floor($total_leaves) * $perday_deduction);
				}else{
					$data['total_leave_deduction'] = $total_leave_deduction=(floor($total_leaves) * $perday_deduction) + $halfday_deduction;
				}
				if ((int) $wdays == $wdays) {
					$data['total_salary'] = $total_salary=((floor($wdays) * $perday_deduction)) - $prof_tax;
				}else{
					$data['total_salary'] = $total_salary=((floor($wdays) * $perday_deduction) + $halfday_deduction) - $prof_tax;
				}
				return $data;
			}else{
				return 0;
			}
		}
		
		function employee_paid_leave_calculation($temp){
			if(isset($temp['employee_id']) && !empty($temp['employee_id'])){
				$data=array();
				$employee_paid_leaves = $this->employee_paid_leaves($temp);
				$employee_leaves = $this->employee_leaves($temp);
				$unused_paid_leaves=isset($employee_paid_leaves['unused_paid_leaves']) ? $employee_paid_leaves['unused_paid_leaves'] : 0;
				$unused_paid_leaves = $unused_paid_leaves-$employee_leaves['paid_leave'];
				$salary_average_total=$this->salary_average_total($temp['employee_id']);
				if(!empty($salary_average_total) && isset($salary_average_total['average_amount'])){
					$paid_leave_perday=$this->paid_leave_perday($salary_average_total['average_amount']);
					$data['payout_paid_leave']=round($paid_leave_perday * $unused_paid_leaves);
					$data['payout_paid_leave_days']=$unused_paid_leaves;
					
				}
				return $data;
			}else{
				return 0;
			}
		}

		function paid_leave_perday($average_amount){
			return $average_amount/averageMonthday;
		}

		public function salary_average_total($employee_id){
			
			$this->Employee_Increment_Model = new \App\Models\Employee_Increment_Model();
			$this->Leave_Report_Model = new \App\Models\Leave_Report_Model();
			$employee_increment=$this->Employee_Increment_Model->get_employee_increment_data($employee_id,'approved');
			$amount=0;
			$result = $increment_amount_array = $increment_total_salary_array =array();
			if(!empty($employee_increment)){
				$num = count($employee_increment);
				$total = 0;
				for($x=0;$x<$num;$x++)
				{ 
					$monthYear=date('m-Y',strtotime($employee_increment[$x]->increment_date));
					if($monthYear != date('m-Y',strtotime('- 1 month'))){
						$total = $total + $employee_increment[$x]->amount;
					}
				}
				// foreach($employee_increment as $k => $val){
				// 	$month=date('m',strtotime($val->increment_date));
				// 	$year=date('Y',strtotime($val->increment_date));
				// 	$get_salary_pay = $this->Leave_Report_Model->get_salary_pay($employee_id, $month, $year);
				// 	$monthYear = $month.'-'.$year;
				// 	if(!empty($get_salary_pay) &&  $monthYear != date('m-Y',strtotime('- 1 month'))){
				// 		array_push($increment_total_salary_array,$get_salary_pay[0]->basic_salary);
				// 		array_push($increment_amount_array,$val->amount);
				// 		$num++;
				// 	}
				// }
				// $num = count($employee_increment); 
				/* $total = $employee_increment[0]->amount;
				if(count($employee_increment) > 1){
					for($x=0;$x<$num;$x++)
					{  
					$total = $total + $employee_increment[$x]->amount;  
					} 
				} */
				// $total = $employee_increment[0]->amount;
				// if(count($increment_total_salary_array) >= 1){
				// 	for($x=0;$x<$num;$x++)
				// 	{  
				// 	$total += $increment_total_salary_array[$x];  
				// 	} 
				// }
				// $result['average']=$num;
				// $result['average_total']=$total;
				// $result['average_amount']=$total/$num;

				$result['average']=$num;
				$result['average_total']=$total;
				$result['average_amount']=$total;
				//print_r($result);
			}
			return $result;
		}

		function salary_pay($temp){
			if(isset($temp['month']) && !empty($temp['month']) && isset($temp['year']) && !empty($temp['year']) && isset($temp['employee_id']) && !empty($temp['employee_id'])){
				$this->Leave_Request_Model = new \App\Models\Leave_Request_Model();
				$this->Deposit_Model = new \App\Models\Deposit_Model();
				$this->Paid_Leave_Model = new \App\Models\Paid_Leave_Model();
				$this->Bonus_Model = new \App\Models\Bonus_Model();
				$data=array();
				$month=$temp['month'];
				$year=$temp['year'];
				$employee_id=$temp['employee_id'];
				$bonus_tbl=$this->Bonus_Model->get_bonus_month($employee_id,$month,$year);
				if(!empty($bonus_tbl)){
					$bonus=$bonus_tbl[0]->bonus;
				}else{
					$bonus=isset($temp['bonus'])?$temp['bonus']:0;
				}
				$deposit_payout=isset($temp['deposit']) ? $temp['deposit'] : 0;
				$employee_basicDetails = $this->employee_basicDetails($temp);
				
				$month_name = date("F", mktime(0, 0, 0, $month, 10));
				$data['name']=$employee_basicDetails['fname']." ".$employee_basicDetails['lname'];
				$data['employed_date']=$employee_basicDetails['employed_date'];
				$data['designation']=$employee_basicDetails['name'];
				$data['employee_status']=$employee_basicDetails['employee_status'];
				$data['month_year_name']=$month_name." - ".$year;
				
				$working_holiday_days=$this->working_holiday_days($temp);
				$data['total_working_days']=$working_holiday_days['total_working_days'];
				$data['total_holiday_days']=$working_holiday_days['total_holiday_days'];
				
				$employee_present_days=$this->employee_present_days($temp);
				$data['total_absent_days']=isset($employee_present_days['total_absent_days']) ? $employee_present_days['total_absent_days'] : 0;
				$data['total_present_days']=isset($employee_present_days['total_present_days']) ? $employee_present_days['total_present_days'] : 0;
				
				$employee_leaves = $this->employee_leaves($temp);
				$data['sick_leave']=$employee_leaves['sick_leave'];
				$data['approved_leaves']=$employee_leaves['approved_leaves']+($employee_present_days['half_day']*0.5);
				$data['unapproved_leave']=$employee_leaves['unapproved_leave'];
				$data['total_day']=$employee_leaves['total_day'];
				$data['total_absent_count']= ($employee_leaves['unapproved_leave_cal'] + $data['total_absent_days']) - $data['approved_leaves'] ;
				
				$get_salary_pay=$this->Leave_Request_Model->get_salary_pay($employee_id,$month,$year);
				$deposit_tbl=$this->Deposit_Model->get_deposit_details($employee_id,$year,$month);
				$employee_salaryDeduction = $this->employee_salaryDeduction($temp);
				$employee_paid_leave_calculation=$this->employee_paid_leave_calculation($temp);
				$employee_salary_calculation=$this->employee_salary_calculation($temp);
				
				/* $unused_paid_leaves = $this->Paid_Leave_Model->get_nextMonth_paidLeave($employee_id,'unused',$month,$year);
				$perday_deduction = (empty($employee_paid_leave_calculation['payout_paid_leave']) || empty($employee_paid_leave_calculation['payout_paid_leave_days']))? 0 : $employee_paid_leave_calculation['payout_paid_leave']/$employee_paid_leave_calculation['payout_paid_leave_days'] ;
				$payout_paid_leave_days = isset($employee_paid_leave_calculation['payout_paid_leave_days'])?$employee_paid_leave_calculation['payout_paid_leave_days']-count($unused_paid_leaves):0;
				$payout_paid_leave = $perday_deduction*$payout_paid_leave_days; */
				$payout_paid_leave = $employee_paid_leave_calculation['payout_paid_leave'];
				$payout_paid_leave_days = $employee_paid_leave_calculation['payout_paid_leave_days'];

				$data['note_message'] = $this->noteMessage($temp);

				if(empty($get_salary_pay)){
					$data['basic_salary']=$employee_basicDetails['salary'];
					$data['prof_tax']=$this->prof_tax($employee_basicDetails['salary']);
					$data['bonus']=$bonus;
					
					$data['paid_leave']=$employee_leaves['paid_leave'];
					$data['total_leaves']=$employee_leaves['total_leaves'];
					
					$data['payout_paid_leave']=isset($payout_paid_leave_days) ? $payout_paid_leave_days : 0;
					$data['payout_paid_leave_amount']=isset($payout_paid_leave) ? $payout_paid_leave : 0;

					$data['deduction_percentage']=$employee_salaryDeduction['deduction_pr'];
					$data['deduction_amount']=$employee_salaryDeduction['deduction_amount'];
					$data['total_deposit']=$employee_salaryDeduction['total_deposit'];
					$data['change_percentage']=$employee_salaryDeduction['change_pr'];
					$data['diposit_status'] = "pending";
					$data['deposit_paid'] = 0;
					$data['thisMonth_deduction'] = $data['deduction_amount'];
					
					$data['total_leave_deduction']=$employee_salary_calculation['total_leave_deduction'];
					$data['net_salary']=$employee_salary_calculation['total_salary']-$data['thisMonth_deduction'];
				}else{
					$data['basic_salary']=$get_salary_pay[0]->basic_salary;
					$data['prof_tax']=$this->prof_tax($data['basic_salary']);
					$data['bonus']=($get_salary_pay[0]->bonus)?$get_salary_pay[0]->bonus:0;
					$data['paid_leave']=$get_salary_pay[0]->paid_leave;
					$data['total_leaves']=$get_salary_pay[0]->absent_leave;

					$data['payout_paid_leave']=isset($payout_paid_leave_days) ? $payout_paid_leave_days : 0;
					$payout_paid_leave_amount=isset($payout_paid_leave) ? $payout_paid_leave : 0;
					$data['payout_paid_leave_amount'] = ($get_salary_pay[0]->payout_paid_leave != 0) ? $get_salary_pay[0]->payout_paid_leave : $payout_paid_leave_amount ;
					
					$data['deduction_percentage'] = empty($get_salary_pay[0]->per_deduction) ? $employee_salaryDeduction['deduction_pr'] : $get_salary_pay[0]->per_deduction ;
					$data['deduction_amount'] = empty($get_salary_pay[0]->amount_deduction) ? $employee_salaryDeduction['deduction_amount'] : $get_salary_pay[0]->amount_deduction ;
					$data['total_deposit']= empty($get_salary_pay[0]->deposit) ?$employee_salaryDeduction['total_deposit'] : $get_salary_pay[0]->deposit;
					$data['total_deposit'] = !empty($deposit_tbl[0]->deposit_amount)?$data['total_deposit']-$deposit_tbl[0]->deposit_amount : $data['total_deposit'] ;
					$data['change_percentage']=$employee_salaryDeduction['change_pr'];
					$data['diposit_status'] = empty($get_salary_pay[0]->deposit) ?"pending" : "paid";
					$data['deposit_paid'] = $get_salary_pay[0]->deposit;
					$data['deposit_paid'] = (!empty($deposit_tbl[0]->deposit_amount) && !empty($data['deposit_paid'])) ? $data['deposit_paid']-$deposit_tbl[0]->deposit_amount : $data['deposit_paid'] ;
					$data['thisMonth_deduction'] = !empty($deposit_tbl[0]->deposit_amount) ? $deposit_tbl[0]->deposit_amount : $employee_salaryDeduction['deduction_amount'];
					
					$data['total_leave_deduction']=$employee_salary_calculation['total_leave_deduction'];
					if(!empty($data['deposit_paid'])){
						$data['status_of_deposit'] = 'paid';
						$data['net_salary']=($employee_salary_calculation['total_salary'] + $data['deduction_amount'] + $data['total_deposit']);
					}else{
						$data['status_of_deposit'] = 'pending';
						$data['net_salary']=$employee_salary_calculation['total_salary'] - ($data['thisMonth_deduction']);
					}

				}

				$timedata=$this->employee_total_working_time($temp);
				$data['plus_time']=$timedata['plus_time'];
				$data['minus_time']=$timedata['minus_time'];
				$data['total_time']=$timedata['total_time'];
				$data['time_status']=$timedata['time_status'];
				
				return $data;
			}else{
				return 0;
			}
		}

		function noteMessage($temp){
			
			$month=$temp['month'];
			$year=$temp['year'];
			$employee_id=$temp['employee_id'];
			$this->Employee_Increment_Model = new \App\Models\Employee_Increment_Model();
			$employee_basicDetails = $this->employee_basicDetails($temp);
			$get_increment=$this->Employee_Increment_Model->get_employee_increment_data($employee_id,'pending');
			$note_message="";
			if(!empty($get_increment)){
				$current_month_date = date($year.'-'.$month.'-1');
				$increment_date_month = date("Y-m-d", strtotime($get_increment[0]->increment_date." -1 months"));

				$current_month_date = date($year.'-'.$month.'-1');
				$increment_month = date('m',strtotime($increment_date_month));
				$increment_year = date('Y',strtotime($increment_date_month));	
				$note_message1=$increment_date_month." - ".$increment_month." - ".$increment_year;
				$note_message2= date('m', strtotime($current_month_date))." - ". date('Y', strtotime($current_month_date));
				
				if($increment_month == date('m', strtotime($current_month_date)) && $increment_year == date('Y', strtotime($current_month_date))){
					$g = ($employee_basicDetails['gender'] == 'female') ? 'her' : 'his';
 					$note_message=$employee_basicDetails['fname']." ".$employee_basicDetails['lname'].", 1 Year is completed, Kindly refund ".$g." Paid Leave & LTIP amount has to be paid.";
				}
			}
			return $note_message;
		}

		function employee_salaryDeduction($temp){
			if(isset($temp['month']) && !empty($temp['month']) && isset($temp['year']) && !empty($temp['year']) && isset($temp['employee_id']) && !empty($temp['employee_id'])){
				$employee_id=$temp['employee_id'];
				
				$data = array();
				$this->Deposit_Payment_Model = new \App\Models\Deposit_Payment_Model();
				$this->Employee_Increment_Model = new \App\Models\Employee_Increment_Model();
				$get_employee_increment_data = $this->Employee_Increment_Model->get_employee_increment_data($employee_id);
				$employee_tbl=$this->employee_basicDetails($temp);

				$net_salary = (empty($get_employee_increment_data)) ? $employee_tbl['salary'] : $get_employee_increment_data[0]->amount;
				$prof_tax = $this->prof_tax($net_salary);
				
				$leave_deduction = ($this->employee_salary_calculation($temp));
				
				$salary = $net_salary-$prof_tax;
				$diposit_salary = $salary-$leave_deduction['total_leave_deduction'];
				$total_deposit = 0;
				$deposit=$this->Deposit_Payment_Model->get_deposit_list($employee_id,'pending');
				if($deposit){
					foreach($deposit as $d){
						$total_deposit += $d->deposit_amount;
					}
				}
				if($employee_tbl['employee_status'] == 'employee' && $employee_tbl['salary_deduction'] > 0){
					if(empty($deposit)){
						$data['salary'] = 0;
						if($diposit_salary == $salary){
							$pr = ($salary == 0)? 0 : (($salary/$salary)*100);
							$data['total_deposit'] = $salary;
							$data['deduction_pr'] = $pr;
							$data['deduction_amount'] = ($salary);
						}else{
							$pr = ($diposit_salary == 0 || $salary == 0)? 0 : (($diposit_salary/$salary)*100);
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
							// $pr = (($diposit_salary/$salary)*100);
							$after_deduct_salary = 0;
							(($diposit_salary-$deduction_amount) < 0) ? $deduction_amount = $diposit_salary : $after_deduct_salary = $diposit_salary-$deduction_amount;
							
							$pr = (($deduction_amount/$salary)*100);
							$data['salary'] = $after_deduct_salary;
							$data['total_deposit'] = ($total_deposit);
							$data['deduction_pr'] = number_format($pr,2);
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
					$pr = ($salary == 0 || $total_deposit == 0) ? 0 : (($total_deposit/$salary)*100);

					$data['salary'] = $employee_tbl['salary'];
					$data['total_deposit'] = $total_deposit;
					$data['deduction_pr'] = 0;
					$data['deduction_amount'] = 0;
					$data['change_pr'] = $employee_tbl['salary_deduction'];
				}
				return $data;
			}else{
				return 0;
			}
		}
		
		function employee_total_working_time($data = array()){
			$month = $data['month'];
			$year = $data['year'];
			$id = $data['employee_id'];
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

							if (Time::createFromFormat('Y-m-d H:i:s', $o) !== FALSE) {
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
			}
			
			if($plus_total_time < $minus_total_time){ $a="minus"; $t=$minus_total_time-$plus_total_time;  }else{ $a="plus"; $t=$plus_total_time-$minus_total_time; }
			$arr=array(

				'plus_time' => $this->view_time_formate($plus_total_time),
				'minus_time' => $this->view_time_formate($minus_total_time),
				'total_time' => $this->view_time_formate($t),
				'time_status' => $a,
			);
			return $arr;	
		}	
	}
