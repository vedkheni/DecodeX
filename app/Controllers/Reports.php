<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use DateTime;

class Reports extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $user_session = $this->session->get('id');
        if(!$user_session)
        {
            return redirect()->to(base_url());
        }
    }

    public function index()
    {
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin')
        {
            return redirect()->to('dashboard');
        }
        $data = array();

        $data['js_flag'] = "reports_js";
        $data['page_title'] = "Attendance Reports";
        $data['get_developer'] = $this->Employee_Model->get_employee_list(1);
        $search = "";
        if ($_POST)
        {
            // echo $_POST['to_date']."<br>";
            // echo date($_POST['to_date']);exit;
            $search = $_POST;

            $id = $search['employees'];
            $data['employee_attendance_list'] = $this->Reports_Model->get_report_attendance($id, $search);

            $data['get_employee'] = $this->Employee_Model->get_employee($id);
            $data['search'] = $search;

        }
        else
        {
            $id = 1;
            $data['employee_attendance_list'] = "";
            $data['get_employee'] = $this->Employee_Model->get_employee($id);

        }
        $data['search'] = $search;
        //$data['get_employee']= $this->Employee_Model->get_employee($id);
        $data['menu'] = "reports";
        $this->lib->view('administrator/reports/attendance_report', $data);
    }

    public function attendance_report()
    {
        $data = array();

        $data['js_flag'] = "reports_js";
        $data['page_title'] = "Attendance Reports";
        $data['get_developer'] = $this->Employee_Model->get_employee_list(1);
        $search = "";
        $user_role = $this->session->get('user_role');
        $columns = array(
            0 => 'id',
            1 => 'date',
            2 => 'attendance',
            3 => 'in',
            4 => 'out',
            5 => 'in',
            6 => 'out',
            7 => 'total',
            8 => 'time',
        );
        
        $employee_attendance_list = '';
        if ($this->request->getPost())
        {
            $search = $this->request->getPost();
            
            $id = $search['employees'];
            $employee_attendance_list = $this->Reports_Model->get_report_attendance($id, $search);
            
            $data['get_employee'] = $this->Employee_Model->get_employee($id);
            
        }
        else
        {
            $id = 1;
            $employee_attendance_list = "";
            $data['get_employee'] = $this->Employee_Model->get_employee($id);

        }
        
        $posts = $employee_attendance_list;
       
        $cdate = date('Y-m-d');
        $data = array();
        $in = array_filter(explode(',', $posts[0]->employee_attendance_in));
        $out = array_filter(explode(',', $posts[0]->employee_attendance_out));
        $attendance_type = array_filter(explode(',', $posts[0]->employee_attendance_type));
        $arr = $att_date = array();
            
        $out_date_arr = $out_date_arr1 = array();
       
        if ($posts[0]->employee_attendance_in)
        {
            $j = 0;
            $out = array_filter(explode(',', $posts[0]->employee_attendance_out));
            if (!empty($out))
            {
                foreach ($out as $o_date => $o)
                {

                    if (DateTime::createFromFormat('Y-m-d H:i:s', $o) !== false)
                    {
                        $dateout1 = date_create($o);
                        $out_date1 = date_format($dateout1, "Y-m-d");
                        $out_date_arr[$out_date1][] = $o;
                        $out_date_arr1[] = $out_date1;
                    }
                }
            }
            $date2Timestamp = 0;
            $a = array_unique($out_date_arr1);
            if (!empty($in))
            {
                foreach ($in as $k => $v)
                {

                    $datein = date_create($v);
                    $in_date = date_format($datein, "Y-m-d");
                    //echo $k;
                    $arr[$in_date]['in'][] = $newDateTime = date('h:i A', strtotime($v));
                    if (isset($attendance_type[$k]))
                    {
                        if ($attendance_type[$k] == "full_day")
                        {
                            $day_name = "Full Day";
                        }
                        else
                        {
                            $day_name = "Half Day";
                        }
                    }
                    $arr[$in_date]['attendance_types'][0] = $day_name;
                    $date_key = array_keys($out_date_arr);
                    if (in_array($in_date, $a))
                    {

                        $date1Timestamp = strtotime($v);
                        if (isset($out_date_arr[$in_date]))
                        {
                            if (isset($out_date_arr[$in_date][0]))
                            {
                                $arr[$in_date]['out'][0] = date('h:i A', strtotime($out_date_arr[$in_date][0]));
                                $date2Timestamp = strtotime($arr[$in_date]['out'][0]);
                                $seconds1 = $date2Timestamp - $date1Timestamp;
                                $arr[$in_date]['seconds'][] = 0;
                            }
                            if (isset($out_date_arr[$in_date][1]))
                            {
                                $arr[$in_date]['out'][1] = date('h:i A', strtotime($out_date_arr[$in_date][1]));
                                $date2Timestamp = strtotime($arr[$in_date]['out'][1]);
                                $seconds1 = $date2Timestamp - $date1Timestamp;
                                $arr[$in_date]['seconds'][] = 0;
                            }

                        }
                    
                        $att_date[] = ($in_date);

                    }
                }
            }
        }
        
        $list = array();
        $nestedData = array();
        $data1 = array();
        $attendance_types = '';$in1 = '';
        $out1 = '';$in2 = '';$out2 = '';$total_time = '';$time = '';
        $att_date = array_unique($att_date);
        $i = 1;
        foreach ($att_date as $d => $value) {
            $total_time = "";
            $list_date = date('Y-m-d', strtotime($value));
    
            if (isset($arr[$list_date]))
            {
                $attendance_types = $arr[$list_date]['attendance_types'][0];
                //in
              
                
                if (isset($arr[$list_date]['in']))
                {
                    $in1 = $arr[$list_date]['in'][0];
                    $strtotimein1 = strtotime($in1);
                    if (isset($arr[$list_date]['in'][1]))
                    {
                        $in2 = $arr[$list_date]['in'][1];
                        $strtotimein2 = strtotime($in2);
                    }
                    else
                    {
                        $strtotimein2 = 0;
                        $in2 = "";
                    }
                }
                else
                {
                    $strtotimein2 = 0;
                    $strtotimein1 = 0;
                    $in1 = "";
                    $in2 = "";
                }
                //out
                if (isset($arr[$list_date]['out']))
                {
                    $out1 = $arr[$list_date]['out'][0];
                    $strtotimeout1 = strtotime($out1);
                    if (isset($arr[$list_date]['out'][1]))
                    {
                        $out2 = $arr[$list_date]['out'][1];
                        $strtotimeout2 = strtotime($out2);
                    }
                    else
                    {
                        $strtotimeout2 = 0;
                        $out2 = "";
                    }
                }
                else
                {
                    $strtotimeout1 = 0;
                    $strtotimeout2 = 0;
                    $out1 = "";
                    $out2 = "";
                }
                if ($strtotimeout2 != 0 && $strtotimein2 != 0)
                {
                    $seconds3 = $strtotimeout2 - $strtotimein2;
                }
                else
                {
                    $seconds3 = 0;
                }

                if ($strtotimeout1 != 0 && $strtotimein1 != 0)
                {
                    $seconds4 = $strtotimeout1 - $strtotimein1;
                }
                else
                {
                    $seconds4 = 0;
                }
                $seconds = $seconds3 + $seconds4;
                $full_second=28800;
                $chnage_time=CHANGE_TIME;
                if(strtotime($chnage_time) <= strtotime($list_date)){
                    $full_second=31500; 
                }                     $half_second = 16200;
                $total_time = 0;
                $weekDay = date('w', strtotime($list_date));
                $time = "";
                $minus_time = $plus_time = 0;
                if ($weekDay == 6)
                {
                    if ($half_second <= $seconds)
                    {
                        $plus_time = $seconds - $half_second;
                    }
                    else
                    {
                        $minus_time = $half_second - $seconds;
                    }
                    if ($plus_time != 0)
                    {
                        $time = '<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($plus_time) . '</span>';
                    }
                    if ($minus_time != 0)
                    {
                        $time = '<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($minus_time) . '</span>';
                    }
                }
                else
                {
                    if ($attendance_types == 'Full Day')
                    {
                        if ($full_second <= $seconds)
                        {
                            $plus_time = $seconds - $full_second;
                        }
                        else
                        {
                            $minus_time = $full_second - $seconds;
                        }
                    }
                    else
                    {
                        if ($half_second <= $seconds)
                        {
                            $plus_time = $seconds - $half_second;
                        }
                        else
                        {
                            $minus_time = $half_second - $seconds;
                        }
                    }
                    if ($plus_time != 0)
                    {
                        $time = '<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($plus_time) . '</span>';
                    }
                    if ($minus_time != 0)
                    {
                        $time = '<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($minus_time) . '</span>';
                    }
                }
                $total_time = $this->seconds($seconds);
            }
                $nestedData['#'] = ($i);
                $nestedData['date'] = dateFormat($list_date);
                $nestedData['attendance'] = $attendance_types;
                $nestedData['in'] = $in1;
                $nestedData['out'] = $out1;
                $nestedData['in1'] = $in2;
                $nestedData['out1'] = $out2;
                $nestedData['total'] = $total_time;
                $nestedData['time'] = $time;
                $data1[] = $nestedData;
                $i++;
        }
        $json_data = array(
            /* "draw" => intval($this->request->getPost('draw')) ,
            "recordsTotal" => intval($totalData) ,
            "recordsFiltered" => intval($totalFiltered) , */
            "data" => $data1
        );

        echo json_encode($json_data);
    }

    // for ($d = 0;$d < count($att_date);$d++)
        // {
        //         $total_time = "";
        //         $list_date = date('Y-m-d', strtotime($att_date[$d]));
        
        //         if (isset($arr[$list_date]))
        //         {
        //             $attendance_types = $arr[$list_date]['attendance_types'][0];
        //             //in
        //             print_r($arr[$list_date]['in']);
                    
        //             if (isset($arr[$list_date]['in']))
        //             {
        //                 $in1 = $arr[$list_date]['in'][0];
        //                 $strtotimein1 = strtotime($in1);
        //                 if (isset($arr[$list_date]['in'][1]))
        //                 {
        //                     $in2 = $arr[$list_date]['in'][1];
        //                     $strtotimein2 = strtotime($in2);
        //                 }
        //                 else
        //                 {
        //                     $strtotimein2 = 0;
        //                     $in2 = "";
        //                 }
        //             }
        //             else
        //             {
        //                 $strtotimein2 = 0;
        //                 $strtotimein1 = 0;
        //                 $in1 = "";
        //                 $in2 = "";
        //             }
        //             //out
        //             if (isset($arr[$list_date]['out']))
        //             {
        //                 $out1 = $arr[$list_date]['out'][0];
        //                 $strtotimeout1 = strtotime($out1);
        //                 if (isset($arr[$list_date]['out'][1]))
        //                 {
        //                     $out2 = $arr[$list_date]['out'][1];
        //                     $strtotimeout2 = strtotime($out2);
        //                 }
        //                 else
        //                 {
        //                     $strtotimeout2 = 0;
        //                     $out2 = "";
        //                 }
        //             }
        //             else
        //             {
        //                 $strtotimeout1 = 0;
        //                 $strtotimeout2 = 0;
        //                 $out1 = "";
        //                 $out2 = "";
        //             }
        //             if ($strtotimeout2 != 0 && $strtotimein2 != 0)
        //             {
        //                 $seconds3 = $strtotimeout2 - $strtotimein2;
        //             }
        //             else
        //             {
        //                 $seconds3 = 0;
        //             }

        //             if ($strtotimeout1 != 0 && $strtotimein1 != 0)
        //             {
        //                 $seconds4 = $strtotimeout1 - $strtotimein1;
        //             }
        //             else
        //             {
        //                 $seconds4 = 0;
        //             }
        //             $seconds = $seconds3 + $seconds4;
        //             $full_second=28800;
        //             $chnage_time=CHANGE_TIME;
        //             if(strtotime($chnage_time) <= strtotime($list_date)){
        //                 $full_second=31500;  
        //             }                     $half_second = 16200;
        //             $total_time = 0;
        //             $weekDay = date('w', strtotime($list_date));
        //             $time = "";
        //             $minus_time = $plus_time = 0;
        //             if ($weekDay == 6)
        //             {
        //                 if ($half_second <= $seconds)
        //                 {
        //                     $plus_time = $seconds - $half_second;
        //                 }
        //                 else
        //                 {
        //                     $minus_time = $half_second - $seconds;
        //                 }
        //                 if ($plus_time != 0)
        //                 {
        //                     $time = '<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($plus_time) . '</span>';
        //                 }
        //                 if ($minus_time != 0)
        //                 {
        //                     $time = '<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($minus_time) . '</span>';
        //                 }
        //             }
        //             else
        //             {
        //                 if ($attendance_types == 'Full Day')
        //                 {
        //                     if ($full_second <= $seconds)
        //                     {
        //                         $plus_time = $seconds - $full_second;
        //                     }
        //                     else
        //                     {
        //                         $minus_time = $full_second - $seconds;
        //                     }
        //                 }
        //                 else
        //                 {
        //                     if ($half_second <= $seconds)
        //                     {
        //                         $plus_time = $seconds - $half_second;
        //                     }
        //                     else
        //                     {
        //                         $minus_time = $half_second - $seconds;
        //                     }
        //                 }
        //                 if ($plus_time != 0)
        //                 {
        //                     $time = '<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($plus_time) . '</span>';
        //                 }
        //                 if ($minus_time != 0)
        //                 {
        //                     $time = '<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($minus_time) . '</span>';

        //                 }
        //             }
        //             $total_time = $this->seconds($seconds);
        //         }
        //             $nestedData['#'] = ($d+1);
        //             $nestedData['date'] = $list_date;
        //             $nestedData['attendance'] = $attendance_types;
        //             $nestedData['in'] = $in1;
        //             $nestedData['out'] = $out1;
        //             $nestedData['in1'] = $in2;
        //             $nestedData['out1'] = $out2;
        //             $nestedData['total'] = $total_time;
        //             $nestedData['time'] = $time;
        //             $data1[] = $nestedData;
        //     }
        //     $json_data = array(
        //         "draw" => intval($this->request->getPost('draw')) ,
        //         "recordsTotal" => intval($totalData) ,
        //         "recordsFiltered" => intval($totalFiltered) ,
        //         "data" => $data1
        //     );
        //     echo json_encode($json_data);
        

    // }
   
    public function logs()
    {
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin')
        {
            return redirect()->to('dashboard');
        }
        $data = array();
        $data['js_flag'] = "reports_js";
        $data['page_title'] = "Logs Reports";
        $data['get_developer'] = $this->Employee_Model->get_employee_list(1);
        $search = "";

        if ($_POST)
        {
            $search = $_POST;
            $id = $search['employees'];
            $data['logs_list'] = $this->Reports_Model->get_report_logs($id, $search);
            $data['get_employee'] = $this->Employee_Model->get_employee($id);
            $data['search'] = $search;
        }
        else
        {
            $id = 1;
            $data['logs_list'] = "";
            $data['get_employee'] = $this->Employee_Model->get_employee($id);

        }

        $data['search'] = $search;
        $data['menu'] = "log_rep";
        $data['logs'] = $this->Reports_Model->log_in();
        //$this->db->query("ALTER TABLE `login_logs` ADD `ip_address` VARCHAR(50) NOT NULL AFTER `employee_id`");
        /* $login_logs=$this->db->query("select * from `login_logs`")->result_array();
        echo "<pre>";
        print_r($login_logs);
        exit; */
        $this->lib->view('administrator/reports/log_report', $data);
    }
    /* employee report */

    public function employee_report()
    {
        $user_role = $this->session->get('user_role');
        $data = array();
        if ($_POST)
        {

            $month = $this->request->getPost('bonus_month');
            $year = $this->request->getPost('bonus_year');
            $arr = array(
                'month' => $this->request->getPost('bonus_month') ,
                'year' => $this->request->getPost('bonus_year') ,
                'employee_id' => $this->request->getPost('employee_id') ,
            );
            $emp = $this->request->getPost('employee_id');
            $data['search'] = $arr;
            $data['employee_attendance_list'] = $this->Employee_Attendance_Model->employee_attendance_list_month_year($emp, $arr);
            //return redirect()->to(base_url('reports/prof_tax'));
            
        }
        else
        {
            $month = date('m', strtotime("-1 month"));
            $year = date('Y');
            $arr = array(
                'month' => $month,
                'year' => $year,
                'employee_id' => 2,
            );
            $emp = 2;
            $data['employee_attendance_list'] = $this->Employee_Attendance_Model->employee_attendance_list_month_year($emp, $arr);
            $data['search'] = $arr;

        }
        $deposit_data = $this->allfunction->deposit_data($emp);
        $data1 = array(
            'month' => $month,
            'year' => $year,
            'employee_id' => $emp,
        );
        $employee_tbl = $this->Employee_Model->get_employee($emp);
        $get_salary_pay = $this->Leave_Report_Model->get_salary_pay($emp, $month, $year);
        if (!empty($get_salary_pay))
        {

            $basic_salary = $get_salary_pay[0]->basic_salary;
            $bonus = $get_salary_pay[0]->bonus;
            $net_salary = $get_salary_pay[0]->net_salary;
            $leave_deduction = $get_salary_pay[0]->deduction;
            $prof_tax = $get_salary_pay[0]->prof_tax;
            $working_day = $get_salary_pay[0]->working_day;
            $total_leaves = $get_salary_pay[0]->total_leaves;
            $deposit = $get_salary_pay[0]->amount_deduction;
            $paid_leaves = $get_salary_pay[0]->paid_leave;
            $sick_leaves = $get_salary_pay[0]->sick_leave;
            $present_day = $get_salary_pay[0]->working_day - $get_salary_pay[0]->total_leaves;
        }
        else
        {
            $month_name = date('F', mktime(0, 0, 0, $month));
            $no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $no_of_sundays = 0;
            $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($i = 1;$i <= $total_days;$i++)
            {
                if (date('N', strtotime($year . '-' . $month . '-' . $i)) == 7) $no_of_sundays++;
            }
            $get_holidays = $this->Holiday_Model->get_official_holidays($month, $year);
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
            // total holiday
            $total_holiday = isset($get_holidays[0]) ? $get_holidays[0]->no_of_holidays-$num : "0";

            //  one -  fullday and half day pay details
            $month_day = $total_days - ($no_of_sundays + $total_holiday);

            $emp_day_all = $this->Employee_Attendance_Model->salary_count_day($month_name, $year, $emp);
            $full_day = $half_day = 0;
            foreach ($emp_day_all as $key => $value)
            {
                if ($value->attendance_type == 'full_day')
                {
                    $full_day++;
                }
                if ($value->attendance_type == 'half_day')
                {
                    $half_day++;
                }
            }
            $basic_salary = $deposit_data['salary'];

            $full = $basic_salary / $month_day;
            $half = $full / 2;
            $t = $half_day * 0.5;
            $present_day = ($full_day + $t);
            $net = ($full_day * $full) + ($half_day * $half);
            $bonus = 0;
            $net_salary = $net - $this->allfunction->prof_tax($basic_salary) - $deposit_data['salary_deduction'];
            $leave_deduction = $basic_salary - $net;
            $prof_tax = $this->allfunction->prof_tax($basic_salary);
            $working_day = $month_day;
            $total_leaves = $working_day - $present_day;
            $deposit = $deposit_data['salary_deduction'];
            $paid_leaves = $employee_tbl[0]->monthly_paid_leave;
            $sick_leaves = "0";
        }

        $total_time = $this->allfunction->employee_total_working_time($data1);
        $result = array(
            'name' => $deposit_data['employee_name'],
            'basic_salary' => $basic_salary,
            'bonus' => $bonus,
            'net_salary' => $net_salary,
            'leave_deduction' => $leave_deduction,
            'deposit' => $deposit,
            'working_day' => $working_day,
            'present_day' => $present_day,
            'total_leaves' => $total_leaves,
            'prof_tax' => $prof_tax,
            'plus_time' => $total_time['plus_time'],
            'total_time' => $total_time['total_time'],
            'minus_time' => $total_time['minus_time'],
            'time_status' => $total_time['time_status'],
            'paid_leaves' => $paid_leaves,
            'sick_leaves' => $sick_leaves,
            'month_name' => date('F', mktime(0, 0, 0, $month)) . "-" . $year,

        );

        $arr2 = array();

        $arr2['employee_id'] = $emp;
        $id = $this->uri->getSegment(3);
        $data['holiday_date'] = $this->Holiday_Model->get_holiday_all();
        $data['get_leave_employee'] = $this->Leave_Request_Model->get_leave_employee($emp);
        $data['result'] = $result;
        $data['js_flag'] = "employee_report_js";
        $data['page_title'] = "Employee Reports";
        $data['id'] = $id;
        $data['employee_all'] = $this->Employee_Model->get_employee_list(1);
        $data['all_deactive_emp'] = $this->Employee_Model->get_employee_list(0);
        $data['employee_deatils'] = $this->Employee_Model->get_employee($emp);
        $data['employee_increment_deatils'] = $this->Employee_Increment_Model->get_employee_increment_data($emp);
        $data['leave_count'] = $this->allfunction->employee_leave_count($arr2);
        $data['employee_list'] = $this->Employee_Model->get_employee_list(1);
        $data['menu'] = "employee_report";
        $this->lib->view('administrator/reports/employee_report', $data);
    }
    public function employee_report1()
    {
        $user_role = $this->session->get('user_role');
        $data = array();
        
        if ($_POST)
        {

            $month = $this->request->getPost('bonus_month');
            $year = $this->request->getPost('bonus_year');
            $arr = array(
                'month' => $this->request->getPost('bonus_month') ,
                'year' => $this->request->getPost('bonus_year') ,
                'employee_id' => $this->request->getPost('employee_id') ,
            );
            $emp = $this->request->getPost('employee_id');
            $data['search'] = $arr;
            $data['employee_attendance_list'] = $this->Employee_Attendance_Model->employee_attendance_list_month_year($emp, $arr);
            //return redirect()->to(base_url('reports/prof_tax'));
            
        }
        else
        {
            $month = date('m', strtotime("-1 month"));
            $year = date('Y');
            $arr = array(
                'month' => $month,
                'year' => $year,
                'employee_id' => 2,
            );
            $emp = 2;
            $data['employee_attendance_list'] = $this->Employee_Attendance_Model->employee_attendance_list_month_year($emp, $arr);
            $data['search'] = $arr;

        }
        
        $deposit_data = $this->allfunction->deposit_data($emp);
        $data1 = array(
            'month' => $month,
            'year' => $year,
            'employee_id' => $emp,
        );
        $employee_tbl = $this->Employee_Model->get_employee($emp);
        $get_salary_pay = $this->Leave_Report_Model->get_salary_pay($emp, $month, $year);
        if (!empty($get_salary_pay))
        {

            $basic_salary = $get_salary_pay[0]->basic_salary;
            $bonus = $get_salary_pay[0]->bonus;
            $net_salary = $get_salary_pay[0]->net_salary;
            $leave_deduction = $get_salary_pay[0]->deduction;
            $prof_tax = $get_salary_pay[0]->prof_tax;
            $working_day = $get_salary_pay[0]->working_day;
            $total_leaves = $get_salary_pay[0]->total_leaves;
            $deposit = $get_salary_pay[0]->amount_deduction;
            $paid_leaves = $get_salary_pay[0]->paid_leave;
            $sick_leaves = $get_salary_pay[0]->sick_leave;
            $present_day = $get_salary_pay[0]->working_day - $get_salary_pay[0]->total_leaves;
        }
        else
        {
            $month_name = date('F', mktime(0, 0, 0, $month));
            $no_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $no_of_sundays = 0;
            $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($i = 1;$i <= $total_days;$i++)
            {
                if (date('N', strtotime($year . '-' . $month . '-' . $i)) == 7) $no_of_sundays++;
            }
            $get_holidays = $this->Holiday_Model->get_official_holidays($month, $year);
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
            // total holiday
            $total_holiday = isset($get_holidays[0]) ? $get_holidays[0]->no_of_holidays-$num : "0";

            //  one -  fullday and half day pay details
            $month_day = $total_days - ($no_of_sundays + $total_holiday);

            $emp_day_all = $this->Employee_Attendance_Model->salary_count_day($month_name, $year, $emp);
            $full_day = $half_day = 0;
            foreach ($emp_day_all as $key => $value)
            {
                if ($value->attendance_type == 'full_day')
                {
                    $full_day++;
                }
                if ($value->attendance_type == 'half_day')
                {
                    $half_day++;
                }
            }
            $basic_salary = $deposit_data['salary'];

            $full = $basic_salary / $month_day;
            $half = $full / 2;
            $t = $half_day * 0.5;
            $present_day = ($full_day + $t);
            $net = ($full_day * $full) + ($half_day * $half);
            $bonus = 0;
            $net_salary = $net - $this->allfunction->prof_tax($basic_salary) - $deposit_data['salary_deduction'];
            $leave_deduction = $basic_salary - $net;
            $prof_tax = $this->allfunction->prof_tax($basic_salary);
            $working_day = $month_day;
            $total_leaves = $working_day - $present_day;
            $deposit = $deposit_data['salary_deduction'];
            $paid_leaves = $employee_tbl[0]->monthly_paid_leave;
            $sick_leaves = "0";
        }

        $total_time = $this->allfunction->employee_total_working_time($data1);

        $salary_pay=$this->salarypayfunction->salary_pay($data1);
        $result = array(
            'name' => $salary_pay['name'],
            'basic_salary' => $salary_pay['basic_salary'],
            'bonus' => $salary_pay['bonus'],
            'net_salary' => number_format($salary_pay['net_salary'],2),
            'leave_deduction' => number_format($salary_pay['total_leave_deduction'],2),
            'deposit' => $salary_pay['thisMonth_deduction'],
            'working_day' => $salary_pay['total_working_days'],
            'present_day' => $salary_pay['total_present_days'],
            'total_leaves' => $salary_pay['total_leaves'],
            'leaves' => $salary_pay['total_absent_days'],
            'approved_leaves' => $salary_pay['approved_leaves'],
            'unapproved_leave' => $salary_pay['unapproved_leave'],
            'prof_tax' => $salary_pay['prof_tax'],
            'plus_time' => $salary_pay['plus_time'],
            'total_time' => $salary_pay['total_time'],
            'minus_time' => $salary_pay['minus_time'],
            'time_status' => $salary_pay['time_status'],
            'paid_leaves' => $salary_pay['paid_leave'],
            'sick_leaves' => $salary_pay['sick_leave'],
            'month_name' => $salary_pay['month_year_name'],

        );

        $arr2 = array();

        $arr2['employee_id'] = $emp;
        $id = $this->uri->getSegment(3);
        $data['holiday_date'] = $this->Holiday_Model->get_holiday_all();
        $data['get_leave_employee'] = $this->Leave_Request_Model->get_leave_employee($emp);
        $data['result'] = $result;
        $data['js_flag'] = "employee_report_js";
        $data['page_title'] = "Employee Reports";
        $data['id'] = $id;
        $data['employee_all'] = $this->Employee_Model->get_employee_list(1);
        $data['all_deactive_emp'] = $this->Employee_Model->get_employee_list(0);
        $data['employee_deatils'] = $this->Employee_Model->get_employee($emp);
        $data['leave_count'] = $this->allfunction->employee_leave_count($arr2);
        $data['employee_list'] = $this->Employee_Model->get_employee_list(1);
        $data['total_time'] = $this->allfunction->employee_total_working_time($data1);
        $data['menu'] = "employee_report";
        echo json_encode($data);
        // $this->lib->view('administrator/reports/employee_report',$data);
        
    }
    public function seconds($seconds)
    {
        // CONVERT TO HH:MM:SS
        $hours = floor($seconds / 3600);
        $remainder_1 = ($seconds % 3600);
        $minutes = floor($remainder_1 / 60);
        $seconds = ($remainder_1 % 60);
        if (strlen($hours) == 1)
        {
            $hours = "0" . $hours;
        }
        if (strlen($minutes) == 1)
        {
            $minutes = "0" . $minutes;
        }
        if (strlen($seconds) == 1)
        {
            $seconds = "0" . $seconds;
        }
        return $hours . ":" . $minutes . "";
    }
    public function total_employee_attendance()
    {
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $id = $this->request->getPost('id');
        $data1 = array(
            'month' => $month,
            'year' => $year,
            'employee_id' => $id,
        );
        $total_time = $this->allfunction->employee_total_working_time($data1);
        echo json_encode($total_time);
    }
    public function employee_increment_deatils()
    {
        $emp = $this->request->getPost('id');
        $data=array();
        $get_employee_increment_data= $this->Employee_Increment_Model->get_employee_increment_data($emp);
        $increment_date_arr  = $increment_amount_array = $increment_total_salary_array =  array();
        $next_increment_date_arr="";
        if(!empty($get_employee_increment_data)){
            $next_increment=end($get_employee_increment_data);
            $next_increment_date_arr=$next_increment->next_increment_date;
            foreach($get_employee_increment_data as $k => $val){
                $month=date('m',strtotime($val->increment_date));
                $year=date('Y',strtotime($val->increment_date));
                $get_salary_pay = $this->Leave_Report_Model->get_salary_pay($emp, $month, $year);
                if(!empty($get_salary_pay)){
                    array_push($increment_total_salary_array,$get_salary_pay[0]->basic_salary);
                }
                array_push($increment_date_arr,$val->increment_date);
                array_push($increment_amount_array,$val->amount);
            }
        }
        

        $data['next_increment_date'] = $next_increment_date_arr;
        $data['increment_date'] = $increment_date_arr;
        $data['increment_amount'] = $increment_amount_array;
        $data['increment_total_salary'] = $increment_total_salary_array;
        echo json_encode($data);
    }
    public function employee_data_new()
    {
        $holiday_date = $this->Holiday_Model->get_holiday_all();
        $holiday = array();
        if ($holiday_date)
        {
            foreach ($holiday_date as $holiday_day)
            {
                $holiday[] = $holiday_day->holiday_date;
            }
        }
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $id = $this->request->getPost('id');
        $arr = array(
            'month' => $month,
            'year' => $year,
            'employee_id' => $id,
        );
        $employee_attendance_list = $this->Employee_Attendance_Model->employee_attendance_list_month_year($id, $arr);
        $get_leave_employee = $this->Leave_Request_Model->get_leave_employee($id);
        $leave = array();
        $leave_status = array();
        if ($get_leave_employee)
        {
            foreach ($get_leave_employee as $get_leave)
            {
                $leave[] = $get_leave->leave_date;
                $leave_status[$get_leave->leave_date]['status'] = $get_leave->status;
                if ($get_leave->leave_status == "none")
                {
                    $leave_status[$get_leave->leave_date]['leave_status'] = "absent";
                }
                else
                {
                    $leave_status[$get_leave->leave_date]['leave_status'] = $get_leave->leave_status;
                }
            }
        }
        $in = array_filter(explode(',', $employee_attendance_list[0]->employee_attendance_in));
        $out = array_filter(explode(',', $employee_attendance_list[0]->employee_attendance_out));
        $attendance_type = array_filter(explode(',', $employee_attendance_list[0]->employee_attendance_type));
        $arr = $att_date = array();

        $out_date_arr = $out_date_arr1 = array();
        if ($employee_attendance_list[0]->employee_attendance_in)
        {
            $j = 0;
            $out = array_filter(explode(',', $employee_attendance_list[0]->employee_attendance_out));

            if (!empty($out))
            {
                foreach ($out as $o_date => $o)
                {

                    if (DateTime::createFromFormat('Y-m-d H:i:s', $o) !== false)
                    {
                        $dateout1 = date_create($o);
                        $out_date1 = date_format($dateout1, "Y-m-d");
                        $out_date_arr[$out_date1][] = $o;
                        $out_date_arr1[] = $out_date1;
                    }
                }
            }
            $date2Timestamp = 0;
            $a = array_unique($out_date_arr1);
            if (!empty($in))
            {
                foreach ($in as $k => $v)
                {

                    $datein = date_create($v);
                    $in_date = date_format($datein, "Y-m-d");

                    $arr[$in_date]['in'][] = $newDateTime = date('h:i A', strtotime($v));
                    if (isset($attendance_type[$k]))
                    {
                        if ($attendance_type[$k] == "full_day")
                        {
                            $day_name = "Full Day";
                        }
                        else
                        {
                            $day_name = "Half Day";
                        }
                    }
                    $arr[$in_date]['attendance_types'][0] = $day_name;
                    $date_key = array_keys($out_date_arr);
                    if (in_array($in_date, $a))
                    {

                        $date1Timestamp = strtotime($v);
                        if (isset($out_date_arr[$in_date]))
                        {
                            if (isset($out_date_arr[$in_date][0]))
                            {
                                $arr[$in_date]['out'][0] = date('h:i A', strtotime($out_date_arr[$in_date][0]));
                                $date2Timestamp = strtotime($arr[$in_date]['out'][0]);
                                $seconds1 = $date2Timestamp - $date1Timestamp;
                                $arr[$in_date]['seconds'][] = 0;
                            }
                            if (isset($out_date_arr[$in_date][1]))
                            {
                                $arr[$in_date]['out'][1] = date('h:i A', strtotime($out_date_arr[$in_date][1]));
                                $date2Timestamp = strtotime($arr[$in_date]['out'][1]);
                                $seconds1 = $date2Timestamp - $date1Timestamp;
                                $arr[$in_date]['seconds'][] = 0;
                            }

                        }
                        $att_date[] = $in_date;

                    }
                }
            }
        }
        $list = array();
        $nestedData = array();
        $data = array();
        for ($d = 1;$d <= 31;$d++)
        {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
            {
                $total_time = "";
                $list_date = date('Y-m-d', $time);
                if (isset($arr[$list_date]))
                {
                    $attendance_types = $arr[$list_date]['attendance_types'][0];
                    //in
                    if (isset($arr[$list_date]['in']))
                    {
                        $in1 = $arr[$list_date]['in'][0];
                        $strtotimein1 = strtotime($in1);
                        if (isset($arr[$list_date]['in'][1]))
                        {
                            $in2 = $arr[$list_date]['in'][1];
                            $strtotimein2 = strtotime($in2);
                        }
                        else
                        {
                            $strtotimein2 = 0;
                            $in2 = "";
                        }
                    }
                    else
                    {
                        $strtotimein2 = 0;
                        $strtotimein1 = 0;
                        $in1 = "";
                        $in2 = "";
                    }
                    //out
                    if (isset($arr[$list_date]['out']))
                    {
                        $out1 = $arr[$list_date]['out'][0];
                        $strtotimeout1 = strtotime($out1);
                        if (isset($arr[$list_date]['out'][1]))
                        {
                            $out2 = $arr[$list_date]['out'][1];
                            $strtotimeout2 = strtotime($out2);
                        }
                        else
                        {
                            $strtotimeout2 = 0;
                            $out2 = "";
                        }
                    }
                    else
                    {
                        $strtotimeout1 = 0;
                        $strtotimeout2 = 0;
                        $out1 = "";
                        $out2 = "";
                    }
                    if ($strtotimeout2 != 0 && $strtotimein2 != 0)
                    {
                        $seconds3 = $strtotimeout2 - $strtotimein2;
                    }
                    else
                    {
                        $seconds3 = 0;
                    }
                    if ($strtotimeout1 != 0 && $strtotimein1 != 0)
                    {
                        $seconds4 = $strtotimeout1 - $strtotimein1;
                    }
                    else
                    {
                        $seconds4 = 0;
                    }
                    $seconds = $seconds3 + $seconds4;
                    $full_second=28800;
                    $chnage_time=CHANGE_TIME;
                    if(strtotime($chnage_time) <= strtotime($list_date)){
                        $full_second=31500; 
                    }        
                    $half_second = 16200;
                    $total_time = 0;
                    $weekDay = date('w', strtotime($list_date));
                    $time = "";
                    $minus_time = $plus_time = 0;
                    if ($weekDay == 6)
                    {
                        if ($half_second <= $seconds)
                        {
                            $plus_time = $seconds - $half_second;
                        }
                        else
                        {
                            $minus_time = $half_second - $seconds;
                        }
                        if ($plus_time != 0)
                        {
                            $time = '<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($plus_time) . '</span>';
                        }
                        if ($minus_time != 0)
                        {
                            $time = '<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($minus_time) . '</span>';

                        }
                    }
                    else
                    {
                        if ($attendance_types == 'Full Day')
                        {
                            if ($full_second <= $seconds)
                            {
                                $plus_time = $seconds - $full_second;
                            }
                            else
                            {
                                $minus_time = $full_second - $seconds;
                            }
                        }
                        else
                        {
                            if ($half_second <= $seconds)
                            {
                                $plus_time = $seconds - $half_second;
                            }
                            else
                            {
                                $minus_time = $half_second - $seconds;
                            }
                        }
                        if ($plus_time != 0)
                        {
                            $time = '<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($plus_time) . '</span>';
                        }
                        if ($minus_time != 0)
                        {
                            $time = '<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($minus_time) . '</span>';

                        }
                    }
                    $total_time = $this->seconds($seconds);
                }
                else
                {
                    $attendance_types = "";
                    if (date('N', strtotime($list_date)) == 7)
                    {
                        $attendance_types = "Sunday";
                    }else if(date('N', strtotime($list_date)) == 6){
                        $chnage_time=CHANGE_TIME;
                        if(strtotime($chnage_time) <= strtotime($list_date)){
                            $attendance_types = "Saturday";
                        }else{
                            if (in_array($list_date, $holiday))
                        {
                            $attendance_types = "Holiday";
                        }
                        else
                        {
                            if (in_array($list_date, $leave))
                            {
                                if ($leave_status[$list_date]['status'] == "approved")
                                {
                                    if ($leave_status[$list_date]['leave_status'] == "paid")
                                    {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "paid-leave-color";
                                    }
                                    else if ($leave_status[$list_date]['leave_status'] == "sick")
                                    {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "sick-leave-color";
                                    }
                                    else
                                    {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "absent-leave-color";
                                    }
                                }
                                else if ($leave_status[$list_date]['status'] == "rejected")
                                {
                                    $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                    $class_tr = "unapprove-leave-color";
                                }
                                else
                                {
                                    $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                    $class_tr = "absent-leave-color";
                                }
                            }
                            else
                            {
                                $attendance_types = "Absent";
                            }
                        }
                        } 
                    }
                    else
                    {
                        if (in_array($list_date, $holiday))
                        {
                            $attendance_types = "Holiday";
                        }
                        else
                        {
                            if (in_array($list_date, $leave))
                            {
                                if ($leave_status[$list_date]['status'] == "approved")
                                {
                                    if ($leave_status[$list_date]['leave_status'] == "paid")
                                    {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "paid-leave-color";
                                    }
                                    else if ($leave_status[$list_date]['leave_status'] == "sick")
                                    {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "sick-leave-color";
                                    }
                                    else
                                    {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "absent-leave-color";
                                    }
                                }
                                else if ($leave_status[$list_date]['status'] == "rejected")
                                {
                                    $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                    $class_tr = "unapprove-leave-color";
                                }
                                else
                                {
                                    $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                    $class_tr = "absent-leave-color";
                                }
                            }
                            else
                            {
                                $attendance_types = "Absent";
                            }
                        }
                    }
                    $in1 = $in2 = $out1 = $out2 = $time = "";
                }
              /*  if(!empty($in1) && empty($out1)){
                    $out1 = '00:00';
                }
                if(!empty($in1) && empty($in2) && date('N', strtotime($list_date)) != 6){
                    $in2 = '00:00';
                }
                if(!empty($in1) && empty($out2) && date('N', strtotime($list_date)) != 6){
                    $out2 = '00:00';
                }*/
                $nestedData['id'] = $d;
                $nestedData['date'] = dateFormat($list_date);
                $nestedData['attendance'] = $attendance_types;
                $nestedData['in'] = $in1;
                $nestedData['out'] = $out1;
                $nestedData['in1'] = $in2;
                $nestedData['out1'] = $out2;
                $nestedData['total'] = $total_time;
                $nestedData['time'] = $time;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "data" => $data
        );
        echo json_encode($json_data);

    }
    public function all_salary_details()
    {
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $id = $this->request->getPost('id');

        if ($month == "all")
        {
            $get_all_salary_pay = $this->Reports_Model->get_all_salary_pay($id, $year);
        }
        else
        {
            $get_all_salary_pay = $this->Reports_Model->get_all_salary_pay($id, $year, $month);
        }

        $data = $result = array();
        if (!empty($get_all_salary_pay))
        {
            foreach ($get_all_salary_pay as $key => $val)
            {
                $m = date('y-d-m', strtotime($val->month));
                $result['month_name'] = $val->month;
                $result['year'] = $year;
                $result['basic_salary'] = $val->basic_salary;
                $result['bonus'] = $val->bonus;
                $result['net_salary'] = $val->net_salary;
                $result['deduction'] = $val->deduction;
                $result['per_deduction'] = $val->per_deduction;
                $result['amount_deduction'] = $val->amount_deduction;
                $result['prof_tax'] = $val->prof_tax;
                $result['working_day'] = $val->working_day;
                $result['official_holiday'] = $val->official_holiday;
                $result['effective_day'] = $val->effective_day;
                $result['approve_leave'] = $val->approve_leave;
                $result['paid_leave'] = $val->paid_leave;
                $result['unapproved_leave'] = $val->unapproved_leave;
                $result['absent_leave'] = $val->absent_leave;
                $result['sick_leave'] = $val->sick_leave;
                $result['total_leaves'] = $val->total_leaves;

                $data[] = $result;
            }

        }
        echo json_encode($data);
        //echo "<pre>";
        //print_r($data);
        
    }
    public function employee_data()
    {
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $id = $this->request->getPost('id');

        $data = array(
            'month' => $month,
            'year' => $year,
            'employee_id' => $id,
        );
        $salary_pay=$this->salarypayfunction->salary_pay($data);
        $result = array(
            'name' => $salary_pay['name'],
            'basic_salary' => $salary_pay['basic_salary'],
            'bonus' => $salary_pay['bonus'],
            'net_salary' => number_format($salary_pay['net_salary'],2),
            'leave_deduction' => number_format($salary_pay['total_leave_deduction'],2),
            'deposit' => $salary_pay['thisMonth_deduction'],
            'working_day' => $salary_pay['total_working_days'],
            'present_day' => $salary_pay['total_present_days'],
            'total_leaves' => $salary_pay['total_leaves'],
            'leaves' => $salary_pay['total_absent_days'],
            'approved_leaves' => $salary_pay['approved_leaves'],
            'unapproved_leave' => $salary_pay['unapproved_leave'],
            'prof_tax' => $salary_pay['prof_tax'],
            'plus_time' => $salary_pay['plus_time'],
            'total_time' => $salary_pay['total_time'],
            'minus_time' => $salary_pay['minus_time'],
            'time_status' => $salary_pay['time_status'],
            'paid_leaves' => $salary_pay['paid_leave'],
            'sick_leaves' => $salary_pay['sick_leave'],
            'month_name' => $salary_pay['month_year_name'],

        );
        echo json_encode($result);
    }
    public function employee_pagination()
    {
        $user_role = $this->session->get('user_role');
        $columns = array(
            0 => 'id',
            1 => 'fname',
            2 => 'lname',
            3 => 'email',
            4 => 'status',
            5 => 'action',
        );
        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order') [0]['column']];
        $dir = $this->request->getPost('order') [0]['dir'];
        $totalData = $this->Employee_Model->allemp_count();
        $totalFiltered = $totalData;

        if (empty($this->request->getPost('search') ['value']))
        {
            $posts = $this->Employee_Model->allEmployee($limit, $start, $order, $dir);
        }
        else
        {
            $search = $this->request->getPost('search') ['value'];

            $posts = $this->Employee_Model->posts_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Employee_Model->posts_search_count($search);
        }
        $cdate = date('Y-m-d');
        $data = array();
        if (!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['id'] = "<span>" . $post->id . "</span>";
                $nestedData['fname'] = $post->fname . " " . $post->lname;;
                $nestedData['action'] = '<a data-id="' . $post->id . '" data-toggle="modal" data-target="#myModal_employee_details"  class="btn btn-danger waves-effect waves-light employee-details">View Details</a>';
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw" => intval($this->request->getPost('draw')) ,
            "recordsTotal" => intval($totalData) ,
            "recordsFiltered" => intval($totalFiltered) ,
            "data" => $data
        );
        echo json_encode($json_data);

    }
    /* prof tax report */
    public function prof_tax()
    {
        $user_role = $this->session->get('user_role');
        $data = array();
        $id = $this->uri->getSegment(3);
        $data['js_flag'] = "prof_tax_js";
        $data['page_title'] = "Professional Tax Reports";
        $data['employee_list'] = $this->Employee_Model->get_employee_list(1);
        if ($_POST)
        {
            $month = $this->request->getPost('bonus_month');
            $year = $this->request->getPost('bonus_year');
            $arr = array(
                'month' => $this->request->getPost('bonus_month') ,
                'year' => $this->request->getPost('bonus_year') ,
            );
            $data['search'] = $arr;
            //return redirect()->to(base_url('reports/prof_tax'));
            
        }
        else
        {
            $month = date('m');
            $year = date('Y');
            $arr = array(
                'month' => $month,
                'year' => $year,
            );
            $data['search'] = $arr;

        }
        $data['prof_tax_count'] = $this->Prof_Tax_Model->prof_tax_count($month, $year);
        if ($id)
        {
            $data['get_employee'] = $this->Employee_Model->get_employee($id);
        }
        else
        {
            $id = $data['employee_list'][0]->id;
            //$data['employee_attendance_list'] = "";
            $data['get_employee'] = $this->Employee_Model->get_employee($id);

        }
        if ($user_role == "admin")
        {
            if ($id)
            {
                $u_id = $id;
            }
            else
            {
                $u_id = $data['employee_list'][0]->id;
            }
            $data['deposit_payment'] = $this->db->query("select * from deposit_payment where employee_id =" . $u_id)->result_array();
            //echo $u_id;
            $deposit_amount = $this->Deposit_Payment_Model->get_deposit_total($u_id);
            $sum = 0;
            foreach ($deposit_amount as $key => $value)
            {
                $sum += $value->deposit_amount;
            }

            /* echo "<pre>";
            print_r($deposit_amount);
            echo "</pre>"; */
            $data['get_deposit_total'] = $sum;
        }
        else
        {
            $user_session = $this->session->get('id');
            $deposit_amount = $this->Deposit_Payment_Model->get_deposit_total($user_session);
            $sum = 0;
            foreach ($deposit_amount as $key => $value)
            {
                $sum += $value->deposit_amount;
            }

            //$data['get_deposit_total']= $this->Deposit_Payment_Model->get_deposit_total($user_session);
            $data['get_deposit_total'] = $sum;
        }

        $data['id'] = $id;
        $data['menu'] = "prof_tax";
        $this->lib->view('administrator/reports/prof_tax_report', $data);
    }
    public function current_month_prof_tax()
    {

        $columns = array(
            0 => 'id',
            1 => 'fname',
            2 => 'prof_tax',
            3 => 'action',
        );

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order') [0]['column']];
        $dir = $this->request->getPost('order') [0]['dir'];

        $get_employee_list = $this->Employee_Model->get_employee_list(1);
        // echo "<pre>"; print_r($get_employee_list);
        // print_r($this->request->getPost());exit();
        $nestedData = $data = array();
        $totalData = count($get_employee_list);
        $totalFiltered = $totalData;

        if (empty($this->request->getPost('search') ['value']))
        {
            $posts = $this->Employee_Model->get_employee_list1($limit, $start, $order, $dir);
        }
        else
        {
            $search = $this->request->getPost('search') ['value'];

            $posts = $this->Employee_Model->get_employee_by_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Employee_Model->get_employee_count_by_search($search);
        }
        if (!empty($posts))
        {
            $i = 0;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $post->id;
                $nestedData['fname'] = $post->fname . " " . $post->lname;
                $nestedData['prof_tax'] = $this->allfunction->prof_tax($post->salary);
                $data[] = $nestedData;
                $i++;
            }
            $json_data = array(
                "draw" => intval($this->request->getPost('draw')) ,
                "recordsTotal" => intval($totalData) ,
                "recordsFiltered" => intval($totalFiltered) ,
                "data" => $data
            );
            echo json_encode($json_data);
        }
    }
    public function prof_tax_pagination()
    {
        //print_r($_POST);
        //die;
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $arr = array(
            'month' => $month,
            'year' => $year,
        );

        $user_role = $this->session->get('user_role');
        $columns = array(
            0 => 'id',
            1 => 'fname',
            2 => 'prof_tax',
            3 => 'action',
        );

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order') [0]['column']];
        $dir = $this->request->getPost('order') [0]['dir'];

        $totalData = $this->Prof_Tax_Model->allposts_count_deposit($arr);

        $totalFiltered = $totalData;

        if (empty($this->request->getPost('search') ['value']))
        {
            $posts = $this->Prof_Tax_Model->allposts_deposit($arr, $limit, $start, $order, $dir);
        }
        else
        {
            $search = $this->request->getPost('search') ['value'];

            $posts = $this->Prof_Tax_Model->posts_search_deposit($arr, $limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Prof_Tax_Model->posts_search_count_deposit($arr, $search);
        }
        $cdate = date('Y-m-d');
        $data = array();
        if (!empty($posts))
        {
            $i = 1;
            foreach ($posts as $post)
            {

                if (!empty($post->prof_tax))
                {
                    $prof_tax = $post->prof_tax;
                }
                else
                {
                    $prof_tax = 0;
                }
                $nestedData['id'] = "<span>" . $i . "</span>";
                $nestedData['fname'] = $post->fname . " " . $post->lname;
                $nestedData['prof_tax'] = $post->prof_tax;
                //  $nestedData['action']="";
                $data[] = $nestedData;

                $i++;
            }
        }

        $json_data = array(
            "draw" => intval($this->request->getPost('draw')) ,
            "recordsTotal" => intval($totalData) ,
            "recordsFiltered" => intval($totalFiltered) ,
            "data" => $data
        );
        echo json_encode($json_data);
    }

    /* bonus report */
   /*  public function bonus_new()
    {
        $data = array();
        $data['menu'] = "bonus_new";
        $data['js_flag'] = "bonus_new_js";
        $this->lib->view('administrator/reports/bonus_report_new', $data);

    } */
    public function bonus_onchange()
    {
        $page = $this->request->getPost('page');
        $year = $this->request->getPost('year');
        $skip_year = array();
        $employee_id = $this->request->getPost('employee_id');
        $y = date('Y');
        $deposit_array = array();
        $get_employees1 = $this->Employee_Model->get_employee_list(1);
        $total_count = count($get_employees1);
        $total_records_per_page = 20;
        $total_no_of_pages = ceil($total_count / $total_records_per_page);
        $offset = ($page - 1) * $total_records_per_page;
        $get_employees = $this->Leave_Report_Model->get_employees_leave($employee_id);
        // $get_employees = $this->Bonus_Model->get_employee_bonus($total_records_per_page, $offset);
        $year_name = array();
        $deposit_array['total_no_of_pages'] = $total_no_of_pages;

        if ($year == 'all_year')
        {
            $get_deposit_year = $this->Bonus_Model->get_bonus_year();
            $all_data_year = array();
            foreach ($get_deposit_year as $k)
            {
                $year_name[] = $k->year;
            }
            $year_reverse = $year_name;
            $year = count($year_reverse);
        }
        else
        {
            for ($i = 0;$i < $year;$i++)
            {
                $year_name[] = $y - $i;
            }
            $year_reverse = array_reverse($year_name);
        }
        if (!empty($get_employees))
        {
            foreach ($get_employees as $v)
            {
                $emp_id = $v->id;
                for($y=0;$y<$year;$y++)
                {
                    $get_deposit_details = $this->Bonus_Model->get_bonus_details($emp_id, $year_reverse[$y]);
                    if (!empty($get_deposit_details))
                    {
                        foreach ($get_deposit_details as $d)
                        {
                            $month_name1 = date("M, Y", mktime(0, 0, 0, $d->month, 10, $d->year));
                            $deposit_array['employee_details'][$year_reverse[$y]][$month_name1] = $d->bonus;
                        }
                    }else{
                        $skip_year[] = $y;
                        /* for ($m = 1;$m <= 12;$m++)
                        {
                            $month_name = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                            $deposit_array['employee_details'][$year_reverse[$y]][$month_name] = '-';
                        } */
                    }
                }
            }
        }
        $num = 0;
        for ($i = 0;$i < $year;$i++)
        {
            if(!in_array($i,$skip_year)){
                for ($m = 1;$m <= 12;$m++)
                {
                    $month_name = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$i]));
                    $deposit_array['year_data'][$num][] = $month_name;
                }
                $num++;
            }
        }
        echo json_encode($deposit_array);
    }
    /* deposit report */
    /* public function deposit_new()
    {
        $data = array();
        $data['menu'] = "deposit_report_new";
        $data['js_flag'] = "deposit_report_new_js";
        // $data['menu']="deposit_report";
        $this->lib->view('administrator/reports/deposit_report_new', $data);

    } */
    public function deposit_onchange()
    {
        $page = $this->request->getPost('page');
        $year = $this->request->getPost('year');
        $skip_year = array();
        $employee_id = $this->request->getPost('employee_id');
        $y = date('Y');
        $deposit_array = array();
        $get_employees1 = $this->Employee_Model->get_employee_list(1);
        $total_count = count($get_employees1);
        $total_records_per_page = 20;
        $total_no_of_pages = ceil($total_count / $total_records_per_page);
        $offset = ($page - 1) * $total_records_per_page;
        $get_employees = $this->Leave_Report_Model->get_employees_leave($employee_id);
        // $get_employees = $this->Deposit_Model->get_employee_deposit($total_records_per_page, $offset);
        $year_name = array();
        $deposit_array['total_no_of_pages'] = $total_no_of_pages;

        if ($year == 'all_year')
        {
            $get_deposit_year = $this->Deposit_Model->get_deposit_year();
            $all_data_year = array();
            foreach ($get_deposit_year as $k)
            {
                $year_name[] = $k->year;
            }
            $year_reverse = $year_name;
            $year = count($year_reverse);
        }
        else
        {
            for ($i = 0;$i < $year;$i++)
            {
                $year_name[] = $y - $i;
            }
            $year_reverse = array_reverse($year_name);
        }
        if (!empty($get_employees))
        {
            foreach ($get_employees as $v)
            {
                $emp_id = $v->id;
                //$deposit_array['employee_name'][]=$v->fname;
                for ($i = 0;$i < $year;$i++)
                {
                    $get_deposit_details = $this->Deposit_Model->get_deposit_details($emp_id, $year_reverse[$i]);
                    if (!empty($get_deposit_details))
                    {
                        foreach ($get_deposit_details as $d)
                        {
                            $month_name1 = date("M, Y", mktime(0, 0, 0, $d->month, 10, $d->year));
                            if ($d->payment_status == 'paid')
                            {
                                $deposit_array['employee_details'][$year_reverse[$i]][$month_name1] = '<span class="deposite-paid">' . $d->deposit_amount . '</span>';
                            }
                            else
                            {
                                $deposit_array['employee_details'][$year_reverse[$i]][$month_name1] = '<span>' . $d->deposit_amount . '</span>';
                            }
                        }
                    }else{
                        $skip_year[] = $i;
                        /* for ($m = 1;$m <= 12;$m++)
                        {
                            $month_name = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$i]));
                            $deposit_array['employee_details'][$year_reverse[$i]][$month_name] = '-';
                        } */
                    }
                }
            }
        }
        $num = 0;
        for ($i = 0;$i < $year;$i++)
        {
            if(!in_array($i,$skip_year)){

                for ($m = 1;$m <= 12;$m++)
                {
                    $month_name = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$i]));
                    $deposit_array['year_data'][$num][] = $month_name;
                }
                $num++;
            }
        }
        echo json_encode($deposit_array);
    }

    /*Prof Tax*/
    /* public function prof_tax_new()
    {
        $data = array();
        $data['menu'] = "prof_tax_new";
        $data['js_flag'] = "prof_tax_new_js";
        // $data['menu']="prof_tax";
        $this->lib->view('administrator/reports/pro_tax_report_new', $data);
    } */
    public function prof_tax_onchange()
    {
        $data = $year_month = $arr = $year_name = $year_reverse = array();
        $year1 = $this->request->getPost('year');
        $page = $this->request->getPost('page');
        $skip_year = array();
        $year = date("Y");
        $employee_detail1 = $this->Employee_Model->get_employee_list(1);
        $total_count = count($employee_detail1);
        $total_records_per_page = 20;
        $total_no_of_pages = ceil($total_count / $total_records_per_page);
        $offset = ($page - 1) * $total_records_per_page;
        $employee_id = $this->request->getPost('employee_id');
        $employee_detail = $this->Leave_Report_Model->get_employees_leave($employee_id);
        // $employee_detail = $this->Prof_Tax_Model->get_employees_tax($total_records_per_page, $offset);
        $year_month['total_no_of_pages'] = $total_no_of_pages;
        if ($year1 == 'all_year')
        {
            $get_prof_tax_year = $this->Prof_Tax_Model->get_prof_tax_year();
            
            $all_data_year = array();
            foreach ($get_prof_tax_year as $k1 => $v1)
            {
                $all_data_year[] = $v1->year;
            }
            $year_reverse = $all_data_year;
            $year1 = count($year_reverse);
        }
        else
        {
            for ($y = 0;$y < $year1;$y++)
            {
                $year_name[] = $year - $y;
            }
            $year_reverse = array_reverse($year_name);
        }
        if (!empty($employee_detail))
        {
            foreach ($employee_detail as $key => $value)
            {
                $year_month['emp_name'][] = $value->fname;
                for ($y = 0;$y < $year1;$y++)
                {
                    $arr['year'] = $year_reverse[$y];
                    $arr['id'] = $value->id;
                    $employee_data = $this->Prof_Tax_Model->allposts_prof_tax($arr);
                    if (!empty($employee_data))
                    {
                        foreach ($employee_data as $k => $v)
                        {
                            $month_name = date("M, Y", mktime(0, 0, 0, $v->month, 10, $v->year));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name] = $v->prof_tax;
                        }
                    }else{
                        $skip_year[] = $y;
                        /* for ($m = 1;$m <= 12;$m++)
                        {
                            $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name1] = '-';
                        } */
                    }
                }
            }
        }
        $num = 0;
        for ($y = 0;$y < $year1;$y++)
        {
            if(!in_array($y,$skip_year)){
                for ($m = 1;$m <= 12;$m++)
                {
                    $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                    $year_month['year_month'][$num][] = $month_name1;
                }
                $num++;
            }
        }
        echo json_encode($year_month);
    }
    /*Leave Reports*/
    public function general_reports()
    {
        $user_session = $this->session->get('id');
        if(empty($user_session))
        {
            return redirect()->to(base_url());
        }
        $data = array();
        $data['get_employee'] = $this->Employee_Model->get_employee_list(1);
        $data['menu'] = "paid_leave_report_new";
        $data['page_title'] = "General Reports";
        $data['js_flag'] = "paid_leave_report_new_js";
        // $data['menu']="leave_report";
        $this->lib->view('administrator/reports/general_reports', $data);
    }
    
    /* start working hours report */
    public function workingHours(){
        $data = array();
        $data['get_employee'] = $this->Employee_Model->get_employee_list(1);
        $data['menu'] = "workingHours_report";
        $data['page_title'] = "Working Hours Reports";
        $data['js_flag'] = "workingHours_report_js";
        // $data['menu']="leave_report";
        $this->lib->view('administrator/reports/workingHours_reports', $data);
    }
    
    function get_workingHours(){
        $data = array();
        
        $data['js_flag'] = "reports_js";
        $data['page_title'] = "Attendance Reports";
        $data['get_developer'] = $this->Employee_Model->get_employee_list(1);
        $search = "";
        $user_role = $this->session->get('user_role');
        
        $columns = array(
            0 => 'employee.id',
            1 => 'employee.fname',
            2 => 'employee_attendance.attendance_type',
            3 => 'employee_attendance.employee_in',
            4 => 'employee_attendance.employee_out',
        );
        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order') [0]['dir'];

        $list = array();
        $num = 1;
        $date = Format_date($this->request->getPost('date'));
        // foreach($data['get_developer'] as $key => $emp){
            $employee_attendance_list = '';
            $totalData = $this->Reports_Model->getAttendance_byCount($date);
            $totalFiltered = $totalData;
            if(empty($this->request->getPost('search')['value'])){
                $employee_attendance_list = $this->Reports_Model->getAttendance_byDate($date, $limit, $start, $order, $dir);
            }else{
                $search = $this->request->getPost('search') ['value'];
                $employee_attendance_list = $this->Reports_Model->getAttendance_bySearch($date, $limit, $start, $search, $order, $dir);
                $totalFiltered = $this->Reports_Model->getAttendance_bySearchCount($date, $search);
            }
            // $data['get_employee'] = $this->Employee_Model->get_employee($emp->id);
            
            $posts = $employee_attendance_list;
        foreach ($posts as $key => $post) {
            $cdate = date('Y-m-d');
            $data = array();
            $in = array_filter(explode(',', $post->employee_attendance_in));
            $out = array_filter(explode(',', $post->employee_attendance_out));
            $attendance_type = array_filter(explode(',', $post->employee_attendance_type));
            $arr = $att_date = array();

            $out_date_arr = $out_date_arr1 = array();
            if ($post->employee_attendance_in) {
                $j = 0;
                $out = array_filter(explode(', ', $post->employee_attendance_out));

                if (!empty($out)) {
                    foreach ($out as $o_date => $o) {

                        if (DateTime::createFromFormat('Y-m-d H:i:s', $o) !== false) {
                            $dateout1 = date_create($o);
                            $out_date1 = date_format($dateout1, "Y-m-d");
                            $out_date_arr[$out_date1][] = $o;
                            $out_date_arr1[] = $out_date1;
                        }
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
                                    $seconds1 = $date2Timestamp - $date1Timestamp;
                                    $arr[$in_date]['seconds'][] = 0;
                                }
                                if (isset($out_date_arr[$in_date][1])) {
                                    $arr[$in_date]['out'][1] = date('h:i A', strtotime($out_date_arr[$in_date][1]));
                                    $date2Timestamp = strtotime($arr[$in_date]['out'][1]);
                                    $seconds1 = $date2Timestamp - $date1Timestamp;
                                    $arr[$in_date]['seconds'][] = 0;
                                }
                            }

                            $att_date[] = ($in_date);
                        }
                    }
                }
            }

            $nestedData = array();
            $data1 = array();
            $attendance_types = '';
            $in1 = '';
            $out1 = '';
            $in2 = '';
            $out2 = '';
            $total_time = '';
            $time = '';
            $att_date = array_unique($att_date);
            $i = 1;
            foreach ($att_date as $d => $value) {
                $total_time = "";
                $list_date = date('Y-m-d', strtotime($value));

                if (isset($arr[$list_date])) {
                    $attendance_types = $arr[$list_date]['attendance_types'][0];
                    //in
                    if (isset($arr[$list_date]['in'])) {
                        $in1 = $arr[$list_date]['in'][0];
                        $strtotimein1 = strtotime($in1);
                        if (isset($arr[$list_date]['in'][1])) {
                            $in2 = $arr[$list_date]['in'][1];
                            $strtotimein2 = strtotime($in2);
                        } else {
                            $strtotimein2 = 0;
                            $in2 = "";
                        }
                    } else {
                        $strtotimein2 = 0;
                        $strtotimein1 = 0;
                        $in1 = "";
                        $in2 = "";
                    }
                    //out
                    if (isset($arr[$list_date]['out'])) {
                        $out1 = $arr[$list_date]['out'][0];
                        $strtotimeout1 = strtotime($out1);
                        if (isset($arr[$list_date]['out'][1]) && !empty($arr[$list_date]['out'][1])) {
                            $out2 = $arr[$list_date]['out'][1];
                            $strtotimeout2 = strtotime($out2);
                        } else {
                            $strtotimeout2 = 0;
                            $out2 = "";
                        }
                    } else {
                        $strtotimeout1 = 0;
                        $strtotimeout2 = 0;
                        $out1 = "";
                        $out2 = "";
                    }
                    if ($strtotimeout2 != 0 && $strtotimein2 != 0) {
                        $seconds3 = $strtotimeout2 - $strtotimein2;
                    } else {
                        $seconds3 = 0;
                    }

                    if ($strtotimeout1 != 0 && $strtotimein1 != 0) {
                        $seconds4 = $strtotimeout1 - $strtotimein1;
                    } else {
                        $seconds4 = 0;
                    }
                    $seconds = $seconds3 + $seconds4;
                    $full_second = 28800;
                    $chnage_time = CHANGE_TIME;
                    if (strtotime($chnage_time) <= strtotime($list_date)) {
                        $full_second = 31500;
                    }
                    $half_second = 16200;
                    $total_time = 0;
                    $weekDay = date('w', strtotime($list_date));
                    $time = "";
                    $minus_time = $plus_time = 0;
                    if ($weekDay == 6) {
                        if ($half_second <= $seconds) {
                            $plus_time = $seconds - $half_second;
                        } else {
                            $minus_time = $half_second - $seconds;
                        }
                        if ($plus_time != 0) {
                            $time = '<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($plus_time) . '</span>';
                        }
                        if ($minus_time != 0) {
                            $time = '<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($minus_time) . '</span>';
                        }
                    } else {
                        if ($attendance_types == 'Full Day') {
                            if ($full_second <= $seconds) {
                                $plus_time = $seconds - $full_second;
                            } else {
                                $minus_time = $full_second - $seconds;
                            }
                        } else {
                            if ($half_second <= $seconds) {
                                $plus_time = $seconds - $half_second;
                            } else {
                                $minus_time = $half_second - $seconds;
                            }
                        }
                        if ($plus_time != 0) {
                            $time = '<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($plus_time) . '</span>';
                        }
                        if ($minus_time != 0) {
                            $time = '<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' . $this->seconds($minus_time) . '</span>';
                        }
                    }
                    $total_time = $this->seconds($seconds);
                }
                if(!empty($out1) && !empty($in2)){
                    $start = new DateTime($list_date." ".$out1);
                    $end = new DateTime($list_date." ".$in2);
                    $interval = $start->diff($end);
                    $breakTime = $interval->format('%H:%I'); 
                }else{
                    $breakTime = '00:00';
                }
                $nestedData['id'] = ($num);
                // $nestedData['date'] = (!empty(dateFormat($list_date)))?dateFormat($list_date): '-' ;
                $nestedData['name'] = $post->fname . ' ' . $post->lname;
                $nestedData['attendance'] = (!empty($attendance_types)) ? $attendance_types : '-';
                $nestedData['in'] = !empty($in1)?$in1:'<span class="text-danger">00:00</span>';
                $nestedData['out'] = !empty($out1)?$out1:'<span class="text-danger">00:00</span>';
                $nestedData['in1'] = !empty($in2)?$in2:'<span class="text-danger">00:00</span>';
                $nestedData['out1'] = !empty($out2)?$out2:'<span class="text-danger">00:00</span>';
                $nestedData['break'] = $breakTime;
                $nestedData['total'] = (!empty($total_time)) ? $total_time : '-';
                $nestedData['time'] = (!empty($time)) ? $time : '-';
                // $data1[] = $nestedData;
                $i++;
                $num++;
            }
            if ($i <= 1) {
                if(!empty($out1) && !empty($in2)){
                    $start = new DateTime($list_date." ".$out1);
                    $end = new DateTime($list_date." ".$in2);
                    $interval = $start->diff($end);
                    $breakTime = $interval->format('%H:%I'); 
                }else{
                    $breakTime = '00:00';
                }
                $type = explode(',', $post->employee_attendance_type);
                $day_name = ($type[0] == "full_day") ? "Full Day" : "Half Day";
                $nestedData['id'] = ($num);
                // $nestedData['date'] = (!empty(dateFormat($list_date)))?dateFormat($list_date): '-' ;
                $nestedData['name'] = $post->fname . ' ' . $post->lname;
                $nestedData['attendance'] = (!empty($attendance_types)) ? $attendance_types : $day_name;
                $nestedData['in'] = !empty($in1)?$in1:'<span class="text-danger">00:00</span>';
                $nestedData['out'] = !empty($out1)?$out1:'<span class="text-danger">00:00</span>';
                $nestedData['in1'] = !empty($in2)?$in2:'<span class="text-danger">00:00</span>';
                $nestedData['out1'] = !empty($out2)?$out2:'<span class="text-danger">00:00</span>';
                $nestedData['break'] = $breakTime;
                $nestedData['total'] = (!empty($total_time)) ? $total_time : '-';
                $nestedData['time'] = (!empty($time)) ? $time : '-';
                $num++;
            }
            // $nestedData['emp_id'] = $post->id;
            array_push($list, $nestedData);
        }
        // }
        $json_data = array(
            "draw" => intval($this->request->getPost('draw')) ,
            "recordsTotal" => intval($totalData) ,
            "recordsFiltered" => intval($totalFiltered) ,
            "data" => $list
        );
        echo json_encode($json_data);
        // echo json_encode($list);
    }

    /* end working hours report */
    
    public function paid_leave_onchange()
    {
        $skip_year = array();
        $data = $year_month = $arr = $year_name = $year_reverse = array();
        $year1 = $this->request->getPost('year');
        $page = $this->request->getPost('page');
        $year = date("Y");
        $employee_detail1 = $this->Employee_Model->get_employee_list(1);
        $total_count = count($employee_detail1);
        $total_records_per_page = 20;
        $total_no_of_pages = ceil($total_count / $total_records_per_page);
        $offset = ($page - 1) * $total_records_per_page;
        $employee_id = $this->request->getPost('employee_id');
        $employee_detail = $this->Leave_Report_Model->get_employees_leave($employee_id);
        // $employee_detail = $this->Leave_Report_Model->get_employees_leave($total_records_per_page, $offset);
        $year_month['total_no_of_pages'] = $total_no_of_pages;
        if ($year1 == 'all_year')
        {
            $get_prof_tax_year = $this->Leave_Report_Model->get_leave_year();
            $all_data_year = array();
            foreach ($get_prof_tax_year as $k1 => $v1)
            {
                $all_data_year[] = $v1->year;
            }
            $year_reverse = $all_data_year;
            $year1 = count($year_reverse);
        }
        else
        {
            for ($y = 0;$y < $year1;$y++)
            {
                $year_name[] = $year - $y;
            }
            $year_reverse = array_reverse($year_name);
        }
        if (!empty($employee_detail))
        {
            foreach ($employee_detail as $key => $value)
            {
                $year_month['emp_name'][] = $value->fname;
                for ($y = 0;$y < $year1;$y++)
                {
                    $arr['year'] = $year_reverse[$y];
                    $arr['id'] = $value->id;
                    $employee_data = $this->Leave_Report_Model->get_employee_list_with_leave($arr);
                    if (!empty($employee_data))
                    {
                        foreach ($employee_data as $k => $v)
                        {
                            $month_name = date("M, Y", mktime(0, 0, 0, $v->month, 10, $v->year));
                            if ($v->month == '11' && $v->year == '2019')
                            {
                                $year_month['emp_detail'][$year_reverse[$y]][$month_name] = '-';
                            }
                            else
                            {   
                                $year_month['emp_detail'][$year_reverse[$y]][$month_name] = $v->paid_leave;
                            }
                        }
                    }else{
                        $skip_year[] = $y;
                        /* for ($m = 1;$m <= 12;$m++)
                        {
                            $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name1] = '-';
                        } */
                    }
                }
            }
        }
        $num = 0;
        for ($y = 0;$y < $year1;$y++)
        {
            if(!in_array($y,$skip_year)){
                for ($m = 1;$m <= 12;$m++)
                {   
                    $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                    $year_month['year_month'][$num][] = $month_name1;
                }
                $num++;
            }
        }
        echo json_encode($year_month);
    }
    
    /* public function paid_leave_new1(){
        $data = array();
        $data['menu'] = "paid_leave_report_new";
        $data['js_flag'] = "use_paid_leave_report_new_js";
        // $data['menu']="leave_report";
        $this->lib->view('administrator/reports/paid_leave_report_new1', $data);
    } */

    public function paid_leave_onchange1()
    {
        $data = $year_month = $arr = $year_name = $year_reverse = array();
        $year1 = $this->request->getPost('year');
        $employee_id = $this->request->getPost('employee_id');
        $page = $this->request->getPost('page');
        $skip_year = array();
        $year = date("Y");
        $employee_detail1 = $this->Employee_Model->get_employee_list(1);
        $total_count = count($employee_detail1);
        $total_records_per_page = 20;
        $total_no_of_pages = ceil($total_count / $total_records_per_page);
        $offset = ($page - 1) * $total_records_per_page;
        $employee_detail = $this->Leave_Report_Model->get_employees_leave($employee_id);
        $year_month['total_no_of_pages'] = $total_no_of_pages;
        if ($year1 == 'all_year')
        {
            $get_prof_tax_year = $this->Leave_Report_Model->get_year_employee_paid_leaves();
            $all_data_year = array();
            foreach ($get_prof_tax_year as $k1 => $v1)
            {
                $all_data_year[] = $v1->year;
            }
            $year_reverse = $all_data_year;
            $year1 = count($year_reverse);
        }
        else
        {
            for ($y = 0;$y < $year1;$y++)
            {
                $year_name[] = $year - $y;
            }
            $year_reverse = array_reverse($year_name);
        }
        if (!empty($employee_detail))
        {
            foreach ($employee_detail as $key => $value)
            {
                $year_month['emp_name'][] = $value->fname;
                for ($y = 0;$y < $year1;$y++)
                {
                    $arr['year'] = $year_reverse[$y];
                    $arr['id'] = $value->id;
                    $employee_data = $this->Leave_Report_Model->get_employee_paid_leaves($arr);
                    if (!empty($employee_data))
                    {
                        foreach ($employee_data as $k => $v)
                        {
                            $month_name = date("M, Y", mktime(0, 0, 0, $v->month, 10, $v->year));
                            if ($v->status == 'used')
                            {
                                $class_name = "deposite-paid";
                                $leave_month = date("F", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year));
                                $leave_month_use = "(" . date("F", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year)) . ")";

                            }
                            else if ($v->status == 'rejected')
                            {
                                $class_name = "deposite-rejected ";
                                $leave_month = date("F", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year));
                                $leave_month_use = "(" . date("F", mktime(0, 0, 0, $v->used_leave_month, 10, $v->year)) . ")";
                            }
                            else if ($v->status == 'unused'){
                                 $class_name = "deposite-pending";
                                $leave_month = "(" . date("F", mktime(0, 0, 0, $v->month, 10, $v->year)) . ")";
                                $leave_month_use = "";
                            }
                            else
                            {
                                $class_name = "deposite-paid";
                                $leave_month ="(" . date("F", mktime(0, 0, 0, $v->month, 10, $v->year)) . ")";
                                $leave_month_use = "";
                            }
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name] = "<span title='" . $leave_month . "' class='" . $class_name . "'>" . $v->leave . " " . $leave_month_use . "</span>";
                        }
                    }else{
                        $skip_year[] = $y;
                        /* for ($m = 1;$m <= 12;$m++)
                        {
                            $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name1] = '-';
                        } */
                    }
                }
            }
        }
        $num = 0;
        for ($y = 0;$y < $year1;$y++)
        {
            if(!in_array($y,$skip_year)){

                for ($m = 1;$m <= 12;$m++)
                {
                    $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                    $year_month['year_month'][$num][] = $month_name1;
                }
                $num++;
            }
        }
        echo json_encode($year_month);
    }
   /*  public function leave_new()
    {
        $data = array();
        $data['menu'] = "leave_report_new";
        $data['js_flag'] = "leave_report_new_js";
        // $data['menu']="leave_report";
        $this->lib->view('administrator/reports/leave_report_new', $data);
    } */
    public function leave_onchange()
    {
        $data = $year_month = $arr = $year_name = $year_reverse = array();
        $year1 = $this->request->getPost('year');
        $page = $this->request->getPost('page');
        $employee_id = $this->request->getPost('employee_id');
        $skip_year = array();
        $year = date("Y");
        $employee_detail1 = $this->Employee_Model->get_employee_list(1);
        $total_count = count($employee_detail1);
        $total_records_per_page = 20;
        $total_no_of_pages = ceil($total_count / $total_records_per_page);
        $offset = ($page - 1) * $total_records_per_page;
        $employee_detail = $this->Leave_Report_Model->get_employees_leave($employee_id);
        $year_month['total_no_of_pages'] = $total_no_of_pages;

        if ($year1 == 'all_year')
        {
            $get_prof_tax_year = $this->Leave_Report_Model->get_leave_year();
            $all_data_year = array();
            foreach ($get_prof_tax_year as $k1 => $v1)
            {
                $all_data_year[] = $v1->year;
            }
            $year_reverse = $all_data_year;
            $year1 = count($year_reverse);
        }
        else
        {
            for ($y = 0;$y < $year1;$y++)
            {
                $year_name[] = $year - $y;
            }
            $year_reverse = array_reverse($year_name);
        }
        if (!empty($employee_detail))
        {
            foreach ($employee_detail as $key => $value)
            {
                $year_month['emp_name'][] = $value->fname;
                for ($y = 0;$y < $year1;$y++)
                {
                    $arr['year'] = $year_reverse[$y];
                    $arr['id'] = $value->id;
                    $employee_data = $this->Leave_Report_Model->get_employee_list_with_leave($arr);
                    if (!empty($employee_data))
                    {
                        foreach ($employee_data as $k => $v)
                        {
                            $month_name = date("M, Y", mktime(0, 0, 0, $v->month, 10, $v->year));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name] = $v->total_leaves;
                        }
                    }else{
                        $skip_year[] = $y;
                        /* for ($m = 1;$m <= 12;$m++)
                        {
                            $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name1] = '-';
                        } */
                    }
                }
            }
        }
        $num = 0;
        for ($y = 0;$y < $year1;$y++)
        {
            if(!in_array($y,$skip_year)){
                for ($m = 1;$m <= 12;$m++)
                {
                    $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                    $year_month['year_month'][$num][] = $month_name1;
                }
                $num++;
            }
        }
        echo json_encode($year_month);
    }
   /*  public function sick_leave_new()
    {
        $data = array();
        $data['menu'] = "sick_leave_report";
        $data['js_flag'] = "sick_leave_report_js";
        // $data['menu']="leave_report";
        $this->lib->view('administrator/reports/sick_leave_report', $data);
    } */
    public function sick_leave_onchange()
    {
        $data = $year_month = $arr = $year_name = $year_reverse = array();
        $year1 = $this->request->getPost('year');
        $page = $this->request->getPost('page');
        $employee_id = $this->request->getPost('employee_id');
        $year = date("Y");
        $skip_year = array();
        $employee_detail1 = $this->Employee_Model->get_employee_list(1);
        $total_count = count($employee_detail1);
        $total_records_per_page = 20;
        $total_no_of_pages = ceil($total_count / $total_records_per_page);
        $offset = ($page - 1) * $total_records_per_page;
        $employee_detail = $this->Leave_Report_Model->get_employees_leave($employee_id);
        // $employee_detail = $this->Leave_Report_Model->get_employees_leave($total_records_per_page, $offset);
        $year_month['total_no_of_pages'] = $total_no_of_pages;

        if ($year1 == 'all_year')
        {
            $get_prof_tax_year = $this->Leave_Report_Model->get_leave_year();
            $all_data_year = array();
            foreach ($get_prof_tax_year as $k1 => $v1)
            {
                $all_data_year[] = $v1->year;
            }
            $year_reverse = $all_data_year;
            $year1 = count($year_reverse);
        }
        else
        {
            for ($y = 0;$y < $year1;$y++)
            {
                $year_name[] = $year - $y;
            }
            $year_reverse = array_reverse($year_name);
        }
        if (!empty($employee_detail))
        {
            foreach ($employee_detail as $key => $value)
            {
                $year_month['emp_name'][] = $value->fname;
                for ($y = 0;$y < $year1;$y++)
                {
                    $arr['year'] = $year_reverse[$y];
                    $arr['id'] = $value->id;
                    $employee_data = $this->Leave_Report_Model->get_employee_list_with_leave($arr);
                    if (!empty($employee_data))
                    {
                        foreach ($employee_data as $k => $v)
                        {
                            $month_name = date("M, Y", mktime(0, 0, 0, $v->month, 10, $v->year));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name] = $v->sick_leave;
                        }
                    }else{
                        $skip_year[] = $y;
                        /* for ($m = 1;$m <= 12;$m++)
                        {
                            $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name1] = '-';
                        } */
                    }
                }
            }
        }
        $num = 0;
        for ($y = 0;$y < $year1;$y++)
        {
            if(!in_array($y,$skip_year)){
                for ($m = 1;$m <= 12;$m++)
                {
                    $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                    $year_month['year_month'][$num][] = $month_name1;
                }
                $num++;
            }
        }
        echo json_encode($year_month);
    }
    /* public function salary_new()
    {
        $data = array();
        $data['menu'] = "salary_report_new";
        $data['js_flag'] = "salary_report_new_js";
        // $data['menu']="leave_report";
        $this->lib->view('administrator/reports/salary_report_new', $data);
    } */
    public function salary_onchange()
    {
        $data = $year_month = $arr = $year_name = $year_reverse = array();
        $year1 = $this->request->getPost('year');
        $page = $this->request->getPost('page');
        $year = date("Y");
        $skip_year = array();
        $employee_detail1 = $this->Employee_Model->get_employee_list(1);
        $total_count = count($employee_detail1);
        $total_records_per_page = 20;
        $total_no_of_pages = ceil($total_count / $total_records_per_page);
        $offset = ($page - 1) * $total_records_per_page;
        $employee_id = $this->request->getPost('employee_id');
        $employee_detail = $this->Leave_Report_Model->get_employees_leave($employee_id);
        // $employee_detail = $this->Leave_Report_Model->get_employees_leave($total_records_per_page, $offset);
        $year_month['total_no_of_pages'] = $total_no_of_pages;

        if ($year1 == 'all_year')
        {
            $get_prof_tax_year = $this->Leave_Report_Model->get_leave_year();
            $all_data_year = array();
            foreach ($get_prof_tax_year as $k1 => $v1)
            {
                $all_data_year[] = $v1->year;
            }
            $year_reverse = $all_data_year;
            $year1 = count($year_reverse);
        }
        else
        {
            for ($y = 0;$y < $year1;$y++)
            {
                $year_name[] = $year - $y;
            }
            $year_reverse = array_reverse($year_name);
        }
        if (!empty($employee_detail))
        {
            foreach ($employee_detail as $key => $value)
            {
                $year_month['emp_name'][] = $value->fname;
                for ($y = 0;$y < $year1;$y++)
                {
                    $arr['year'] = $year_reverse[$y];
                    $arr['id'] = $value->id;
                    $employee_data = $this->Leave_Report_Model->get_employee_list_with_leave($arr);
                    if (!empty($employee_data))
                    {
                        foreach ($employee_data as $k => $v)
                        {
                            $month_name = date("M, Y", mktime(0, 0, 0, $v->month, 10, $v->year));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name] = $v->net_salary;
                        }
                    }else{
                        $skip_year[] = $y;
                        /* for ($m = 1;$m <= 12;$m++)
                        {
                            $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                            $year_month['emp_detail'][$year_reverse[$y]][$month_name1] = '-';
                        } */
                    }
                }
            }
        }
        $num = 0;
        for ($y = 0;$y < $year1;$y++)
        {
            if(!in_array($y,$skip_year)){
                for ($m = 1;$m <= 12;$m++)
                {
                    $month_name1 = date("M, Y", mktime(0, 0, 0, $m, 10, $year_reverse[$y]));
                    $year_month['year_month'][$num][] = $month_name1;
                }
                $num++;
            }
        }
        echo json_encode($year_month);
    }
    public function deposit()
    {
        $user_role = $this->session->get('user_role');
        $data = array();
        $id = $this->uri->getSegment(3);
        $data['js_flag'] = "deposit_js";
        $data['page_title'] = "Deposit Reports";
        $data['employee_list'] = $this->Employee_Model->get_employee_list(1);

        if ($_POST)
        {
            $month = $this->request->getPost('bonus_month');
            $year = $this->request->getPost('bonus_year');
            $arr = array(
                'month' => $this->request->getPost('bonus_month') ,
                'year' => $this->request->getPost('bonus_year') ,
            );
            $data['search'] = $arr;
            //return redirect()->to(base_url('reports/prof_tax'));
            
        }
        else
        {
            $month = date('m');
            $year = date('Y');
            $arr = array(
                'month' => $month,
                'year' => $year,
            );
            $data['search'] = $arr;

        }
        $data['prof_tax_count'] = $this->Deposit_Report_Model->deposit_count($month, $year);
        if ($id)
        {
            //$data['employee_attendance_list'] = $this->Reports_Model->get_report_attendance($id,$search);
            $data['get_employee'] = $this->Employee_Model->get_employee($id);
        }
        else
        {
            $id = $data['employee_list'][0]->id;
            //$data['employee_attendance_list'] = "";
            $data['get_employee'] = $this->Employee_Model->get_employee($id);

        }
        if ($user_role == "admin")
        {
            if ($id)
            {
                $u_id = $id;
            }
            else
            {
                $u_id = $data['employee_list'][0]->id;
            }
            $data['deposit_payment'] = $this->db->query("select * from deposit_payment where employee_id =" . $u_id)->result_array();
            //echo $u_id;
            $deposit_amount = $this->Deposit_Payment_Model->get_deposit_total($u_id);
            $sum = 0;
            foreach ($deposit_amount as $key => $value)
            {
                $sum += $value->deposit_amount;
            }

            /* echo "<pre>";
            print_r($deposit_amount);
            echo "</pre>"; */
            $data['get_deposit_total'] = $sum;
        }
        else
        {
            $user_session = $this->session->get('id');
            $deposit_amount = $this->Deposit_Payment_Model->get_deposit_total($user_session);
            $sum = 0;
            foreach ($deposit_amount as $key => $value)
            {
                $sum += $value->deposit_amount;
            }

            //$data['get_deposit_total']= $this->Deposit_Payment_Model->get_deposit_total($user_session);
            $data['get_deposit_total'] = $sum;
        }

        //print_r($data['get_deposit_total']);
        

        $data['id'] = $id;
        $data['menu'] = "deposit_report";
        $this->lib->view('administrator/reports/deposit_report', $data);
    }
    public function current_month_deposit()
    {
        $get_employee_list = $this->Employee_Model->get_employee_list(1);
        $nestedData = $data = array();
        $totalData = count($get_employee_list);
        $totalFiltered = $totalData;
        if (!empty($get_employee_list))
        {
            $i = 0;
            foreach ($get_employee_list as $prof_tax)
            {
                $nestedData['id'] = $prof_tax->id;
                $nestedData['fname'] = $prof_tax->fname . " " . $prof_tax->lname;
                $nestedData['deposit_amount'] = ($prof_tax->salary * $prof_tax->salary_deduction) / 100;
                $data[] = $nestedData;
                $i++;
            }
            $json_data = array(
                "draw" => intval($this->request->getPost('draw')) ,
                "recordsTotal" => intval($totalData) ,
                "recordsFiltered" => intval($totalFiltered) ,
                "data" => $data
            );
            echo json_encode($json_data);
        }
    }
    public function deposit_pagination()
    {
        //print_r($_POST);
        //die;
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $arr = array(
            'month' => $month,
            'year' => $year,
        );

        $user_role = $this->session->get('user_role');
        $columns = array(
            0 => 'id',
            1 => 'fname',
            2 => 'deposit_amount',
            3 => 'action',
        );

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order') [0]['column']];
        $dir = $this->request->getPost('order') [0]['dir'];

        $totalData = $this->Deposit_Report_Model->allposts_count_deposit($arr);

        $totalFiltered = $totalData;
        if (empty($this->request->getPost('search') ['value']))
        {
            $posts = $this->Deposit_Report_Model->allposts_deposit($arr, $limit, $start, $order, $dir);
        }
        else
        {
            $search = $this->request->getPost('search') ['value'];

            $posts = $this->Deposit_Report_Model->posts_search_deposit($arr, $limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Deposit_Report_Model->posts_search_count_deposit($arr, $search);
        }
        $cdate = date('Y-m-d');
        $data = array();
        if (!empty($posts))
        {
            $i = 1;
            foreach ($posts as $post)
            {

                if (!empty($post->prof_tax))
                {
                    $prof_tax = $post->prof_tax;
                }
                else
                {
                    $prof_tax = 0;
                }
                $nestedData['id'] = "<span>" . $i . "</span>";
                $nestedData['fname'] = $post->fname . " " . $post->lname;
                $nestedData['deposit_amount'] = $post->deposit_amount;
                //  $nestedData['action']="";
                $data[] = $nestedData;

                $i++;
            }
        }

        $json_data = array(
            "draw" => intval($this->request->getPost('draw')) ,
            "recordsTotal" => intval($totalData) ,
            "recordsFiltered" => intval($totalFiltered) ,
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function current_month_leave()
    {
        $get_employee_list = $this->Employee_Model->get_employee_list(1);
        $nestedData = $data = array();
        $totalData = count($get_employee_list);
        $totalFiltered = $totalData;

        if (!empty($get_employee_list))
        {
            $i = 0;
            foreach ($get_employee_list as $prof_tax)
            {

                $get_employee_list_with_leave = $this->Employee_Model->get_employee_list_with_leave($prof_tax->id);
                $nestedData['id'] = $prof_tax->id;
                $nestedData['fname'] = $prof_tax->fname . " " . $prof_tax->lname;
                $nestedData['paid_leave'] = $prof_tax->monthly_paid_leave;
                $nestedData['absent_leave'] = $get_employee_list_with_leave[0]->absent_leave;
                $data[] = $nestedData;
                $i++;
            }
            $json_data = array(
                "draw" => intval($this->request->getPost('draw')) ,
                "recordsTotal" => intval($totalData) ,
                "recordsFiltered" => intval($totalFiltered) ,
                "data" => $data
            );
            echo json_encode($json_data);
        }
    }
    /* leaves reports */
    public function leave()
    {
        $user_role = $this->session->get('user_role');
        $data = array();
        $id = $this->uri->getSegment(3);
        $data['js_flag'] = "leave_report_js";
        $data['page_title'] = "Leave Reports";
        $data['employee_list'] = $this->Employee_Model->get_employee_list(1);

        if ($_POST)
        {
            $month = $this->request->getPost('bonus_month');
            $year = $this->request->getPost('bonus_year');
            $arr = array(
                'month' => $this->request->getPost('bonus_month') ,
                'year' => $this->request->getPost('bonus_year') ,
            );
            $data['search'] = $arr;
            //return redirect()->to(base_url('reports/prof_tax'));
            
        }
        else
        {
            $month = date('m');
            $year = date('Y');
            $arr = array(
                'month' => $month,
                'year' => $year,
            );
            $data['search'] = $arr;

        }
        if (date('m') == $month && date('Y') == $year)
        {
            $get_employee_list = $this->Employee_Model->get_employee_list(1);
            $nestedData = $data_all = array();
            if (!empty($get_employee_list))
            {
                $i = 0;
                foreach ($get_employee_list as $prof_tax)
                {
                    $get_employee_list_with_leave = $this->Employee_Model->get_employee_list_with_leave($prof_tax->id);
                    $nestedData['id'] = $prof_tax->id;
                    $nestedData['fname'] = $prof_tax->fname . " " . $prof_tax->lname;
                    $nestedData['paid_leave'] = $prof_tax->monthly_paid_leave;
                    $nestedData['absent_leave'] = $get_employee_list_with_leave[0]->absent_leave;
                    $data_all[] = $nestedData;
                    $i++;
                }
            }
            $data['prof_tax_count'] = $data_all;
        }
        else
        {
            $data['prof_tax_count'] = $this->Leave_Report_Model->leave_count($month, $year);
        }
        if ($id)
        {
            $data['get_employee'] = $this->Employee_Model->get_employee($id);
        }
        else
        {
            $id = $data['employee_list'][0]->id;
            //$data['employee_attendance_list'] = "";
            $data['get_employee'] = $this->Employee_Model->get_employee($id);

        }
        if ($user_role == "admin")
        {
            if ($id)
            {
                $u_id = $id;
            }
            else
            {
                $u_id = $data['employee_list'][0]->id;
            }
            $data['deposit_payment'] = $this->db->query("select * from deposit_payment where employee_id =" . $u_id)->result_array();
            //echo $u_id;
            $deposit_amount = $this->Deposit_Payment_Model->get_deposit_total($u_id);
            $sum = 0;
            foreach ($deposit_amount as $key => $value)
            {
                $sum += $value->deposit_amount;
            }

            /* echo "<pre>";
            print_r($deposit_amount);
            echo "</pre>"; */
            $data['get_deposit_total'] = $sum;
        }
        else
        {
            $user_session = $this->session->get('id');
            $deposit_amount = $this->Deposit_Payment_Model->get_deposit_total($user_session);
            $sum = 0;
            foreach ($deposit_amount as $key => $value)
            {
                $sum += $value->deposit_amount;
            }

            //$data['get_deposit_total']= $this->Deposit_Payment_Model->get_deposit_total($user_session);
            $data['get_deposit_total'] = $sum;
        }

        //print_r($data['get_deposit_total']);
        

        $data['id'] = $id;
        $data['menu'] = "leave_report";
        $this->lib->view('administrator/reports/leave_report', $data);
    }
    public function leaves_pagination()
    {
        //print_r($_POST);
        //die;
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $arr = array(
            'month' => $month,
            'year' => $year,
        );

        $user_role = $this->session->get('user_role');
        $columns = array(
            0 => 'id',
            1 => 'fname',
            2 => 'paid_leave',
            3 => 'absent_leave',

        );

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order') [0]['column']];
        $dir = $this->request->getPost('order') [0]['dir'];

        $totalData = $this->Leave_Report_Model->allposts_count_deposit($arr);

        $totalFiltered = $totalData;

        if (empty($this->request->getPost('search') ['value']))
        {
            $posts = $this->Leave_Report_Model->allposts_deposit($arr, $limit, $start, $order, $dir);
        }
        else
        {
            $search = $this->request->getPost('search') ['value'];

            $posts = $this->Leave_Report_Model->posts_search_deposit($arr, $limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Leave_Report_Model->posts_search_count_deposit($arr, $search);
        }
        $cdate = date('Y-m-d');
        $data = array();
        if (!empty($posts))
        {
            $i = 1;
            foreach ($posts as $post)
            {

                //print_r($post);
                $nestedData['id'] = "<span>" . $i . "</span>";
                $nestedData['fname'] = $post->fname . " " . $post->lname;
                $nestedData['paid_leave'] = $post->paid_leave;
                $nestedData['absent_leave'] = $post->total_leaves + 0;

                //  $nestedData['action']="";
                $data[] = $nestedData;

                $i++;
            }
        }

        $json_data = array(
            "draw" => intval($this->request->getPost('draw')) ,
            "recordsTotal" => intval($totalData) ,
            "recordsFiltered" => intval($totalFiltered) ,
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function employeeWorkUpdates(){
        $date = $this->request->getPost('date');
        if(isset($date) && !empty($date)){
            $data = $this->Employee_Attendance_Model->getUpdates_byDate(array('date' => Format_date($date,'Y-m-d'),));
        }else{
            $range = explode(' - ',$this->request->getPost('range'));
            $id = $this->request->getPost('id');
            $arr = array(
                'id' => $id,
                'first_date' => Format_date($range[0], "Y-m-d"), 
                'second_date' => Format_date($range[1], "Y-m-d"), 
            );
            $data = $this->Employee_Attendance_Model->getAttendance_betweenDate($arr);
        }
        echo json_encode($data);exit;
    }

    public function create_table()
    {
        $arr=$this->db->query("select employee.fname,employee.lname,employee.id,GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type from employee  join employee_attendance ON employee.id = employee_attendance.employee_id where date(employee_attendance.employee_in) ='2021-04-20' group by employee.id")->result();
        // $query=$this->db->query("SELECT GROUP_CONCAT(`employee_in`) AS employee_attendance_in,GROUP_CONCAT(`employee_out`) AS employee_attendance_out,GROUP_CONCAT(`attendance_type`) AS employee_attendance_type FROM employee_attendance where `employee_id` = $id ".$search_option."  ORDER BY `employee_in` DESC");
        echo "<pre>";
        print_r($arr);
        die;
        
        /* $insert="INSERT INTO `employee_increment` (`employee_id`, `increment_date`, `next_increment_date`, `amount`, `status`) VALUES
        ( 2, '2019-07-01', '2020-07-01', 8000, 'approved'),
        ( 2, '2020-07-01', '2021-07-01', 6000, 'approved'),
        ( 2, '2021-07-01', '0000-00-00', 0, 'pending'),
        ( 3, '2019-12-01', '2020-12-01', 8000, 'approved'),
        ( 3, '2020-12-01', '0000-00-00', 0, 'pending'),
        ( 4, '2019-09-01', '2020-09-01', 8000, 'approved'),
        ( 4, '2020-09-08', '2021-09-08', 6000, 'approved'),
        ( 4, '2021-09-08', '0000-00-00', 0, 'pending'),
        ( 5, '2019-12-01', '2020-12-01', 8000, 'approved'),
        ( 5, '2020-12-01', '0000-00-00', 0, 'pending'),
        ( 6, '2019-06-01', '2020-06-01', 8000, 'approved'),
        ( 6, '2020-06-01', '2021-06-01', 6000, 'approved'),
        ( 6, '2021-06-01', '0000-00-00', 0, 'pending'),
        ( 8, '2019-02-01', '2020-02-01', 16000, 'approved'),
        ( 8, '2020-02-01', '2021-02-01', 3000, 'approved'),
        ( 8, '2021-02-01', '0000-00-00', 0, 'pending'),
        ( 9, '2019-06-01', '2020-06-01', 8000, 'approved'),
        ( 9, '2020-06-01', '2021-06-01', 6000, 'approved'),
        ( 9, '2021-06-01', '0000-00-00', 0, 'pending'),
        ( 10, '2019-11-01', '2020-11-01', 8000, 'approved'),
        ( 10, '2020-11-01', '0000-00-00', 0, 'pending'),
        ( 11, '2020-08-01', '2021-08-01', 8000, 'approved'),
        ( 11, '2021-08-01', '0000-00-00', 0, 'pending'),
        ( 12, '2019-10-01', '2020-10-01', 14000, 'approved'),
        ( 12, '2020-10-01', '2021-10-01', 5000, 'approved'),
        ( 12, '2021-10-01', '0000-00-00', 0, 'pending'),
        ( 13, '2019-11-01', '2020-11-01', 10000, 'approved'),
        ( 13, '2020-11-01', '2021-11-01', 5000, 'approved'),
        ( 13, '2021-11-01', '0000-00-00', 0, 'pending'),
        ( 14, '2020-06-01', '2021-06-01', 8000, 'approved'),
        ( 14, '2021-06-01', '0000-00-00', 0, 'pending'),
        ( 15, '2020-04-01', '2021-04-01', 8000, 'approved'),
        ( 15, '2021-04-01', '0000-00-00', 0, 'pending')"; */
        //echo $this->db->query($insert);
        //echo $this->db->query("ALTER TABLE `employee_increment` CHANGE `status` `status` ENUM('approved','rejected','pending') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
         
        // echo $this->db->query("UPDATE `employee_increment` SET `status` = 'pending' WHERE `employee_increment`.`id` = 21");

        //die; 
        /* 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-02-01',8,'0000-00-00',0,'pending')");

                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-02-01',8,'0000-00-00',0,'pending')");  */

                /* echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-07-01',2,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-12-01',3,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-09-08',4,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-12-01',5,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-06-01',6,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-06-01',9,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-11-01',10,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-08-01',11,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-10-01',12,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-11-01',13,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-06-01',14,'0000-00-00',0,'pending')"); 
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2021-04-01',15,'0000-00-00',0,'pending')"); 
        */
                /* 
                
                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-07-01',2,'2020-07-01',8000,'approved')");
                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-07-01',2,'2021-07-01',6000,'approved')");


        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-12-01',3,'2020-12-01',8000,'approved')");

                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-08-01',4,'2020-09-01',8000,'approved')");
        $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-09-08',4,'2021-09-08',6000,'approved')");

                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-12-01',5,'2020-12-01',8000,'approved')");

                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-06-01',6,'2020-06-01',8000,'approved')");
                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-06-01',6,'2021-06-01',6000,'approved')");

        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-02-01',8,'2020-02-01',16000,'approved')");
                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-02-01',8,'2021-02-01',3000,'approved')");
                
                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-06-01',9,'2020-06-01',8000,'approved')"); 
                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-06-01',9,'2021-06-01',6000,'approved')");

                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-11-01',10,'2020-11-01',8000,'approved')");

                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-08-01',11,'2021-08-01',8000,'approved')");

        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-10-01',12,'2021-10-01',5000,'approved')");
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-10-01',12,'2020-10-01',14000,'approved')");

                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2019-11-01',13,'2020-11-01',10000,'approved')");
        echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-11-01',13,'2021-11-01',5000,'approved')");

                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-06-01',14,'2021-06-01',8000,'approved')");

                echo $this->db->query("INSERT INTO `employee_increment`(`increment_date`, `employee_id`, `next_increment_date`, `amount`,`status`) 
        VALUES ('2020-04-01',15,'2021-04-01',8000,'approved')");   */
    
    
    }
}

