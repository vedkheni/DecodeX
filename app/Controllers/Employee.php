<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use DateTime;

class Employee extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $user_session = $this->session->get('id');
        if (!$user_session) {
            return redirect()->to(base_url());
        }
    }
    public function index()
    {
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            return redirect()->to('dashboard');
        }
        $user_session = $this->session->get('id');
        if (!$user_session) {
            return redirect()->to(base_url('admin'));
        }
        $data = array();
        $data['designation'] = $this->Designation_Model->get_designation();
        $data['page_title'] = "Employees";
        $data['js_flag'] = "emp_js";
        $data['menu'] = "employee";
        $this->lib->view('administrator/employee/list_employee', $data);
    }
    public function seconds($seconds)
    {
        // CONVERT TO HH:MM:SS
        $hours = floor($seconds / 3600);
        $remainder_1 = ($seconds % 3600);
        $minutes = floor($remainder_1 / 60);
        $seconds = ($remainder_1 % 60);
        if (strlen($hours) == 1) {
            $hours = "0" . $hours;
        }
        if (strlen($minutes) == 1) {
            $minutes = "0" . $minutes;
        }
        if (strlen($seconds) == 1) {
            $seconds = "0" . $seconds;
        }
        return $hours . ":" . $minutes . "";
    }
    public function add_time()
    {

        $time = $_POST['time'];
        $id = $_POST['id'];
        $attendance_date = $_POST['attendance_date'];
        $get_employee_attendance_details = $this->Employee_Attendance_Model->get_employee_attendance_details($id, $attendance_date);
        if (!empty($get_employee_attendance_details)) {
            $class_name = "";
            $date_create1 = date_create($attendance_date . " " . $time);
            if ($_POST['type'] != 'attendance_type') {
                $edit_time = date_format($date_create1, 'Y-m-d H:i:s');
                $time_name = date_format($date_create1, 'h:i A');
            } else {
                $time_name = "Full Day";
                if ($time == "full_day") {
                    $time_name = "Full Day";
                } else {
                    $time_name = "Half Day";
                    $class_name = "halfday-leave-color";
                }
                $edit_time = $time;
            }
            if (isset($get_employee_attendance_details[0])) {
                if ($_POST['type'] == 'in' && $edit_time != '0000-00-00 00:00:00') {
                    //update query
                    $arr = array(
                        'employee_id' => $id,
                        'id' => $get_employee_attendance_details[0]->id,
                        'employee_in' => $edit_time,
                    );

                    $update = $this->Employee_Attendance_Model->update_attendance_time($arr);
                }
                if ($_POST['type'] == 'out' && $edit_time != '0000-00-00 00:00:00') {
                    $arr = array(
                        'employee_id' => $id,
                        'id' => $get_employee_attendance_details[0]->id,
                        'employee_out' => $edit_time,
                    );
                    $update = $this->Employee_Attendance_Model->update_attendance_time($arr);
                }
                if ($_POST['type'] == 'attendance_type') {
                    $arr = array(
                        'employee_id' => $id,
                        'id' => $get_employee_attendance_details[0]->id,
                        'attendance_type' => $edit_time,
                    );
                    $update = $this->Employee_Attendance_Model->update_attendance_time($arr);
                    // echo "yes";

                }
            }
            //die;
            if (isset($get_employee_attendance_details[1])) {
                if ($_POST['type'] == 'in1' && $edit_time != '0000-00-00 00:00:00') {
                    $arr = array(
                        'employee_id' => $id,
                        'id' => $get_employee_attendance_details[1]->id,
                        'employee_in' => $edit_time,
                    );
                    $update = $this->Employee_Attendance_Model->update_attendance_time($arr);
                }
                if ($_POST['type'] == 'out1' && $edit_time != '0000-00-00 00:00:00') {
                    $arr = array(
                        'employee_id' => $id,
                        'id' => $get_employee_attendance_details[1]->id,
                        'employee_out' => $edit_time,
                    );
                    $update = $this->Employee_Attendance_Model->update_attendance_time($arr);
                }
                if ($_POST['type'] == 'attendance_type') {
                    $arr = array(
                        'employee_id' => $id,
                        'id' => $get_employee_attendance_details[1]->id,
                        'attendance_type' => $edit_time,
                    );
                    $update = $this->Employee_Attendance_Model->update_attendance_time($arr);
                }
            } else {
                if ($_POST['type'] == 'in1' && $edit_time != '0000-00-00 00:00:00') {
                    $arr = array(
                        'employee_in' => $edit_time,
                        'employee_out' => null,
                        'employee_id' => $id,
                        'attendance_type' => $get_employee_attendance_details[0]->attendance_type,
                    );

                    $insert_employee = $this->Employee_Attendance_Model->insert_employee($arr);
                }
            }
            $attendance_time = array();
            $time_count = $this->Employee_Attendance_Model->get_employee_attendance_details($id, $attendance_date);

            if (!empty($time_count)) {

                //echo "<pre>"; print_r($time_count);echo "</pre>";
                $in_time = $out_time = $in_time1 = $out_time1 = $daliy_time = $plus_total_time = $minus_total_time = 0;
                $full_second = 28800;
                $half_second = 16200;
                $total_time = 0;
                $seconds_count = 0;
                if (trim($time_count[0]->attendance_type) == 'half_day') {
                    $full_second = 16200;
                } else {
                    $full_second = 28800;
                }
                if (isset($time_count[0]->employee_in) && isset($time_count[0]->employee_out)) {
                    //echo "if1";
                    if (!empty($time_count[0]->employee_in) && !empty($time_count[0]->employee_out)) {
                        //echo "if4";
                        $in = date('h:i A', strtotime($time_count[0]->employee_in));
                        $ou1 = date('h:i A', strtotime($time_count[0]->employee_out));

                        $in_time = strtotime($in);
                        $out_time = strtotime($ou1);
                        $seconds_count = $out_time - $in_time;
                    }
                }
                $seconds_count1 = 0;
                if (isset($time_count[1]->employee_in) && isset($time_count[1]->employee_out)) {
                    //echo "if2";
                    if (!empty($time_count[1]->employee_in) && !empty($time_count[1]->employee_out) && $time_count[1]->employee_out != '0000-00-00 00:00:00' && $time_count[1]->employee_in != '0000-00-00 00:00:00') {
                        //echo "if3";
                        $in1 = date('h:i A', strtotime($time_count[1]->employee_in));
                        $ou11 = date('h:i A', strtotime($time_count[1]->employee_out));

                        $in_time1 = strtotime($in1);
                        $out_time1 = strtotime($ou11);
                        $seconds_count1 = $out_time1 - $in_time1;
                    }
                }
                $daliy_time = $seconds_count + $seconds_count1;
                $plus_time = "0";
                $minus_time = "0";
                if ($daliy_time != 0) {
                    $weekDay = date('w', strtotime($attendance_date));
                    //echo "Week Days".$m." - ".$weekDay."<br/>";
                    if ($weekDay == 6) {
                        if ($half_second <= $daliy_time) {
                            $plus_time = $daliy_time - $half_second;
                        } else {
                            $minus_time = $half_second - $daliy_time;
                        }
                    } else {
                        if ($full_second <= $daliy_time) {
                            $plus_time = $daliy_time - $full_second;
                        } else {
                            $minus_time = $full_second - $daliy_time;
                        }
                    }
                }

                $total_time = $this->seconds($daliy_time);
                $html = "";
                if ($plus_time != 0 || $minus_time != 0) {
                    if ($plus_time != 0) {
                        $t = $this->seconds($plus_time);
                        $html = '<span class="time-plus"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . $t . '</span>';
                    }
                    if ($minus_time != 0) {
                        $t = $this->seconds($minus_time);
                        $html = '<span class="time-minus"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;' . $t . '</span>';
                    }
                }

                $attendance_time = array(
                    'dataall' => $time_count,
                    'total_time' => $total_time,
                    "time_count" => $html,
                    'select_time' => $time_name,
                    'class_name' => $class_name
                );
            }
            echo json_encode($attendance_time);
        }
    }
    public function leave_count()
    {
        //echo $salary_pay=$this->db->query("DELETE FROM `bonus` WHERE `bonus`.`id` = 10 and `bonus`.`emp_id` = 14");
        //$salary_pay=$this->db->query("select * from bonus where emp_id=14")->result_array();
        //echo "<pre>";
        //print_r($salary_pay);
        //die;
        //echo $this->db->query("UPDATE `employee` SET `monthly_paid_leave` = '1' WHERE `employee`.`status` = 1");
        $salary_pay_tbl = $this->Leave_Request_Model->get_salary_pay_paid_leave_count(13);
        $total_paid_leaves = 0;

        $date1 = date('Y-01-01');
        $date2 = date('Y-01-15', strtotime("+1 year"));
        foreach ($salary_pay_tbl as $leave) {
            $created_date = date("Y-m-d", strtotime($leave->created_date));
            if (strtotime($date1) <= strtotime($created_date) && strtotime($date2) >= strtotime($created_date)) {
                $total_paid_leaves += $leave->paid_leave;
            }
        }
        echo $total_paid_leaves;
        echo "<pre>";
        print_r($salary_pay_tbl);
        echo "</pre>";
        $data = array(
            'employee_id' => 2,
        );
        $salary_all_details = $this->allfunction->monthly_paid_leave_total($data);
        //echo "<pre>";print_r($salary_all_details);

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
            5 => 'list_attendance',
            6 => 'login',
            7 => 'action',
        );

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $totalData = $this->Employee_Model->allemp_count();

        $totalFiltered = $totalData;

        if (empty($this->request->getPost('search')['value'])) {
            $posts = $this->Employee_Model->allEmployee($limit, $start, $order, $dir);
        } else {
            $search = $this->request->getPost('search')['value'];

            $posts = $this->Employee_Model->posts_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Employee_Model->posts_search_count($search);
        }
        $cdate = date('Y-m-d');
        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {
                $nestedData['#'] = "<input type='checkbox' class='delete_checkbox' value='" . $post->id . "' />"; //
                $nestedData['id'] = "<span>" . $i . "</span>"; //
                $nestedData['fname'] = $post->fname . " " . $post->lname;;
                $nestedData['email'] = $post->email;
                if ($post->status == 1) {
                    $s = 'Deactive';
                    $class_name = "btn-danger";
                } else {
                    $class_name = "btn-warning";
                    $s = 'Active';
                }
                $nestedData['status'] = '<a href="javascript:void(0);" data-id="' . $post->id . '" data-status="' . $post->status . '" class="btn ' . $class_name . ' waves-effect waves-light status">' . $s . '</a>';

                $nestedData['list_attendance'] = '<a class="btn-theme-dark btn btn-outline-secondary" href="' . base_url('employee/employee_attendance_list/' . $post->id) . '" title="List attendance">List attendance</a>';

                $nestedData['login'] = '<a class="btn sec-btn sec-btn-outline login-employee" href="' . base_url('change_role/employee_login/' . $post->id) . '" title="Login">Login</a>';

                $nestedData['action'] = '	<div class="employee-list-btn">
                						<div class="dropdown"> 
                					 	<button class="btn btn-light text-dark dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-v"></i> </button>
									    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1"> 
									      <li role="presentation" class="drop-menu-item dropdown-item"><a class="menu-link" href="' . base_url('employee/add') . '/' . $post->id . '" role="menuitem" tabindex="-1" title="Edit">Edit</a></li>

									      <li role="presentation" class="drop-menu-item dropdown-item"><a class="menu-link" href="' . base_url('employee/employee_attendance/' . $post->id . '/' . $cdate) . '" role="menuitem" tabindex="-1" title="Add attendance">Add attendance</a></li>
									      <li role="presentation" class="drop-menu-item dropdown-item"><a class="menu-link" href="' . base_url('deposit/index/' . $post->id) . '" role="menuitem" tabindex="-1" title="Add Bonus">Deposit</a></li>
									         
									    </ul>
									  </div>
									   
									  <div class="employee-btn">
									  	<a href="' . base_url('employee/add') . '/' . $post->id . '" class="btn btn-danger waves-effect waves-light">Edit</a>  <a  data-id="' . $post->id . '" class="btn btn-danger waves-effect waves-light  delete-employee">Delete</a> <a href="' . base_url('employee/employee_attendance/' . $post->id . '/' . $cdate) . '" class="btn btn-danger waves-effect waves-light" target="_blank">Add attendance</a> <a  data-id="' . $post->id . '" class="btn btn-danger waves-effect waves-light pay-salary-btn">Pay</a>
									  </div>
									  </div>';
                // <li role="presentation" class="drop-menu-item" ><a data-id="' . $post->id . '" class="menu-link delete-employee" role="menuitem" tabindex="-1" title="Delete">Delete</a></li>
                //  $nestedData['action'] ='<a href="'.base_url('employee/add').'/'.$post->id.'" class="btn btn-danger waves-effect waves-light">Edit</a>  <a style="display:none;" data-id="'.$post->id.'" class="btn btn-danger waves-effect waves-light  delete-employee">Delete</a> <a href="'.base_url('change_role/employee_login/'.$post->id).'" class="btn btn-danger waves-effect waves-light login-employee">Login</a> <a href="'.base_url('employee/employee_attendance/'.$post->id .'/'.$cdate).'" class="btn btn-danger waves-effect waves-light" target="_blank">Add attendance</a> <a href="'.base_url('employee/employee_attendance_list/'.$post->id).'" class="btn btn-danger waves-effect waves-light" target="_blank">List attendance</a> <a href="'.base_url('bonus/add/'.$post->id).'" class="btn btn-danger waves-effect waves-light" target="_blank">Add Bonus</a> <a  data-id="'.$post->id.'" class="btn btn-danger waves-effect waves-light pay-salary-btn">Pay</a>';
                // Add attendance
                $data[] = $nestedData;
                $i++;
            }
        }

        $json_data = array(
            "draw" => intval($this
                ->input
                ->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function detail()
    {
        $data = array();
        $user_session_id = $this->session->get('id');
        if (!$user_session_id) {
            return redirect()->to(base_url('login'));
        }

        $data['designation'] = $this->Designation_Model->get_designation();
        $data['menu'] = "employee_detail";
        $data['page_title'] = "Employee Detail";
        $data['js_flag'] = "profile_js";
        $data['employee_list'] = $this->Employee_Model->get_employee_list(1);

        if ($this->request->getPost('id')) {
            $user_session = $this->request->getPost('id');
        } elseif ($this->uri->getSegment(3)) {
            $user_session = $this->uri->getSegment(3);
        } else {
            $user_session = $data['employee_list'][0]->id;
        }
        $data['employee_id'] = $user_session;
        $employee_detail = $this->Employee_Model->get_employee($user_session);
        $emergency_contact=$this->Employee_Model->get_emergencyContactDetail($user_session);
        $data['profile'] = $employee_detail;
        $data['emergency_contact']=$emergency_contact;
        if ($this->request->getPost('id')) {
            $profile_url = base_url() . 'assets/profile_image256x256';
            $url = base_url() . 'assets/id_proof256x256';
            $photoURL = base_url() . 'assets/upload/passport_photo';
            
            $signatureArr['filename'] = $data['profile'][0]->signature;
            $signatureArr['errormg'] = 'No Signature Uploaded.';
            $signatureArr['folderpath'] = 'signature512x512/';
            $data['profile'][0]->signature = $this->checkFile($signatureArr);

            $id_proofArr['filename'] = $data['profile'][0]->id_proof;
            $id_proofArr['errormg'] = 'No ID Proof Uploaded.';
            $id_proofArr['folderpath'] = 'id_proof512x512/';
            $data['profile'][0]->id_proof = $this->checkFile($id_proofArr);
            
            $passportPhotoArr['filename'] = $data['profile'][0]->passport_photo;
            $passportPhotoArr['errormg'] = 'Photo not Uploaded.';
            $passportPhotoArr['folderpath'] = 'upload/passport_photo/';
            $data['profile'][0]->passport_photo = $this->checkFile($passportPhotoArr);
            
            $qr_code['filename'] = $data['profile'][0]->qr_code;
            $qr_code['errormg'] = 'QR Code Not Uploaded.';
            $qr_code['folderpath'] = 'upload/qrcode/';
            $data['profile'][0]->qr_code = $this->checkFile($qr_code);

            if ($data['profile'][0]->profile_image != "") {
                $profile_image1 = $_SERVER['DOCUMENT_ROOT'] . "/assets/profile_image32x32/" . $data['profile'][0]->profile_image;
                if (file_exists($profile_image1)) {
                    $profile_image = $profile_url . "/" . $data['profile'][0]->profile_image;
                } else {
                    if (isset($data['profile'][0]->gender) && $data['profile'][0]->gender == 'female') {
                        $profile_image = base_url() . "assets/images/female-default.svg";
                    } else {
                        $profile_image = base_url() . "assets/images/male-default.svg";
                    }
                }
            } else {
                if (isset($data['profile'][0]->gender) && $data['profile'][0]->gender == 'female') {
                    $profile_image = base_url() . "assets/images/female-default.svg";
                } else {
                    $profile_image = base_url() . "assets/images/male-default.svg";
                }
            }

            $agreement = $_SERVER['DOCUMENT_ROOT'] . '/assets/agreement/agreement_' . $data['profile'][0]->id . '.pdf';
            $data['profile'][0]->agreement =  (file_exists($agreement)) ? base_url() . 'assets/agreement/agreement_' . $data['profile'][0]->id . '.pdf' : '';
            $data['profile'][0]->user_role = ucwords($data['profile'][0]->user_role);
            $data['profile'][0]->date_of_birth = ($data['profile'][0]->date_of_birth != '0000-00-00' && $data['profile'][0]->date_of_birth != '' )?dateFormat($data['profile'][0]->date_of_birth):'';
            $data['profile'][0]->gender = ucwords($data['profile'][0]->gender);
            $data['profile'][0]->joining_date = ($data['profile'][0]->joining_date != '0000-00-00' && $data['profile'][0]->joining_date != '' )?dateFormat($data['profile'][0]->joining_date):'';
            $data['profile'][0]->profile_image = $profile_image;
            $data['profile'][0]->signature = isset($signature) ? $signature : '';
            echo json_encode($data);
            exit;
            // $this->lib->view('administrator/employee/profile',$data);
        } else {
            $this->lib->view('administrator/employee/employee_detail', $data);
        }
    }

    public function checkFile($data = array()){
        $fileURL = base_url() . 'assets/'.$data['folderpath'];
        if (isset($data['filename']) && !empty($data['filename'])) {
            $file1 = $_SERVER['DOCUMENT_ROOT'] . "/assets/".$data['folderpath'] . $data['filename'];
            if (file_exists($file1)) {
                $file = base_url() . "assets/".$data['folderpath'] . $data['filename'];
                $file_1 = $fileURL.$data['filename'];
                $filename = '<a download href="' . $file . '"><img class="id-img" width="300" src="' . $file_1 . '"></a> ';
            } else {
                $filename = '<div class="empty-id-proof"><p>'.$data['errormg'].'</p></div>';
            }
        } else {
            $filename = '<div class="empty-id-proof"><p>'.$data['errormg'].'</p></div>';
        }
        return $filename;
    }

    public function employee_pagination_search()
    {

        $designation = $emp_status = "";

        $designation = $this->request->getPost('designation');
        if ($this->request->getPost('emp_status') == 'Active') {
            $emp_status = 2;
        } elseif ($this->request->getPost('emp_status') == 'Deactive') {
            $emp_status = 1;
        } else {
            $emp_status = $this->request->getPost('emp_status');
        }
        $user_role = $this->session->get('user_role');
        $columns = array(
            0 => 'id',
            1 => 'id',
            2 => 'fname',
            3 => 'email',
            4 => 'status',
            5 => 'list_attendance',
            6 => 'login',
            7 => 'action',
            8 => 'status',
        );

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
        $order = empty($emp_status)?'status':$order;
        $dir = empty($emp_status)?'desc':$dir;

        $totalData = $this->Employee_Model->allemp_count_with_designation($designation, $emp_status);

        $totalFiltered = $totalData;

        if (empty($this->request->getPost('search')['value'])) {
            $posts = $this->Employee_Model->allemp_with_designation($designation, $emp_status, $limit, $start, $order, $dir);
            $search = '';
        } else {
            $search = $this->request->getPost('search')['value'];

            $posts = $this->Employee_Model->emp_search_with_designation($designation, $emp_status, $limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Employee_Model->emp_search_count_with_designation($designation, $emp_status, $search);
        }
        $cdate = date('Y-m-d');
        $data = array();
        $i = $num = 0;
        if (!empty($posts)) {
            foreach ($posts as $post) {
                if(empty($emp_status)){ $notallowstatus=2; }elseif($emp_status == 1){ $notallowstatus=1; }elseif($emp_status == 2){ $notallowstatus=0; }else{$notallowstatus=2;}
                // if (empty($search) || strpos(strtolower($post->fname), $search) !== false || strpos(strtolower($post->lname), $search) !== false || strpos(strtolower($post->email), $search) !== false && $notallowstatus != $post->status){
                if($notallowstatus != $post->status){
                    $nestedData['#'] = "<input type='checkbox' class='delete_checkbox' value='" . $post->id . "' />"; //
                    $nestedData['id'] = "<span>" . ($i+1) . "</span>"; //
                    $cls_name=($post->status != 1)?'text-danger':'';
                    $nestedData['fname'] = '<span class="'.$cls_name.'">'.$post->fname . " " . $post->lname.'</span>';
                    $nestedData['email'] = $post->email;
                    // $nestedData['status'] = '<a href="javascript:void(0);" data-id="' . $post->id . '" data-status="' . $post->status . '" class="btn ' . $class_name . ' waves-effect waves-light status">' . $s . '</a>';
                    if ($post->status == 1) {
                        $s = 'Deactive';
                        $class_name = "text-danger";
                    } else {
                        $class_name = "text-info";
                        $s = 'Active';
                    }

                    $nestedData['list_attendance'] = '<a class="btn-theme-dark btn btn-outline-secondary" href="' . base_url('employee/employee_attendance_list/' . $post->id) . '" title="List attendance">List attendance</a>';

                    $nestedData['login'] = '<a class="btn sec-btn sec-btn-outline login-employee" href="' . base_url('change_role/employee_login/' . $post->id) . '" title="Login">Login</a>';
                    // <li role="presentation" class="drop-menu-item dropdown-item"><a class="menu-link" href="' . base_url('employee/add') . '/' . $post->id . '" role="menuitem" tabindex="-1" title="Edit" target="_blank">Edit</a></li>
                    $nestedData['action'] = '   <a class="btn sec-btn sec-btn-outline " href="' . base_url('employee/add') . '/' . $post->id . '" role="menuitem" tabindex="-1" title="Edit" target="_blank">Edit</a>
                                            <div class="employee-list-btn">
                                            <div class="dropdown"> 
                                            <button class="btn btn-light text-dark dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-ellipsis-v"></i></button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1"> 
                                                <li role="presentation" class="drop-menu-item dropdown-item"><a class="menu-link" href="' . base_url('deposit/index/' . $post->id) . '" role="menuitem" tabindex="-1" title="Add Bonus">Deposit</a></li>
                                                <li role="presentation" class="drop-menu-item dropdown-item">
                                                    <a class="menu-link" href="' . base_url('leave_request?id=' . $post->id . '&action=add_leave') . '" role="menuitem" tabindex="-1" title="Add attendance" target="_blank">Add Leave</a>
                                                </li>
                                                <li role="presentation" class="drop-menu-item dropdown-item">
                                                    <a href="javascript:void(0);" data-id="' . $post->id . '" data-status="' . $post->status . '" class="' . $class_name . ' status">' . $s . '</a>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        
                                        <div class="employee-btn">
                                            <a href="' . base_url('employee/add') . '/' . $post->id . '" class="btn btn-danger waves-effect waves-light">Edit</a>  <a  data-id="' . $post->id . '" class="btn btn-danger waves-effect waves-light  delete-employee">Delete</a> <a href="' . base_url('employee/employee_attendance/' . $post->id . '/' . $cdate) . '" class="btn btn-danger waves-effect waves-light" target="_blank">Add attendance</a> <a  data-id="' . $post->id . '" class="btn btn-danger waves-effect waves-light pay-salary-btn">Pay</a>
                                        </div>
                                        </div>';
                    /* add/ */
                    /* <li role="presentation" class="drop-menu-item dropdown-item"><a class="menu-link" href="' . base_url('employee/employee_attendance/' . $post->id . '/' . $cdate) . '" role="menuitem" tabindex="-1" title="Add attendance" target="_blank">Add attendance</a></li> */
                    // <li role="presentation" class="drop-menu-item" ><a data-id="' . $post->id . '" class="menu-link delete-employee" role="menuitem" tabindex="-1" title="Delete">Delete</a></li>
                    //  $nestedData['action'] ='<a href="'.base_url('employee/add').'/'.$post->id.'" class="btn btn-danger waves-effect waves-light">Edit</a>  <a style="display:none;" data-id="'.$post->id.'" class="btn btn-danger waves-effect waves-light  delete-employee">Delete</a> <a href="'.base_url('change_role/employee_login/'.$post->id).'" class="btn btn-danger waves-effect waves-light login-employee">Login</a> <a href="'.base_url('employee/employee_attendance/'.$post->id .'/'.$cdate).'" class="btn btn-danger waves-effect waves-light" target="_blank">Add attendance</a> <a href="'.base_url('employee/employee_attendance_list/'.$post->id).'" class="btn btn-danger waves-effect waves-light" target="_blank">List attendance</a> <a href="'.base_url('bonus/add/'.$post->id).'" class="btn btn-danger waves-effect waves-light" target="_blank">Add Bonus</a> <a  data-id="'.$post->id.'" class="btn btn-danger waves-effect waves-light pay-salary-btn">Pay</a>';
                    // Add attendance
                    $data[] = $nestedData;
                    $i++;
                }else{
                    $num++;
                }
                // }
            }
        }
        $totalFiltered -= $num;
        $json_data = array(
            "draw" => intval($this->request->getPost('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }
    function isWeekend($date)
    {
        return (date('N', strtotime($date)) >= 7);
    }
    public function delete_employee_all_leave()
    {
        $array = array();
        $emp_id = $this->request->getPost("employee_id");
        $leave_date = $this->request->getPost("leave_date");
        $all_date = explode(',', $leave_date);
        $holiday_date_count = $this->Holiday_Model->get_exists_holiday_date_leave($leave_date);
        $holiday_date = $holiday_date_count[0]['numrows'];

        $get_exists_holiday_date_row = $this->Holiday_Model->get_exists_holiday_date_row($leave_date);

        $date = strtotime("+7 day");

        $oneweek_date = date('Y-m-d', $date);
        $s1 = strtotime($oneweek_date);

        $sunday_err = "";
        $A = 0;
        foreach ($all_date as $sunday_date) {
            $sunday = $this->isWeekend($sunday_date);
            if ($sunday == 1) {
                $sunday_err .= " " . date('j F Y', strtotime($sunday_date)) . " ";
                $A++;
            }
        }
        if (isset($holiday_date) && $holiday_date > 0) {
            $holiday_date_err = "";
            foreach ($get_exists_holiday_date_row as $holiday_list) {
                $exist_date = date('j F Y', strtotime($holiday_list->holiday_date));
                $holiday_date_err .= " " . date('j F Y', strtotime($exist_date)) . " ";
                $A++;
            }
        }
        $k  = $B = 0;
        for ($i = 0; $i < count($all_date); $i++) {
            $data = $this->Leave_Request_Model->delete_employee_leave($emp_id, $all_date[$i]);
            $data1 = $this->Employee_Attendance_Model->employee_attendance_date($all_date[$i], $emp_id);
            $delete_employee = '';
            foreach ($data1 as $key => $value) {
                $did = $value->id;
                $delete_employee = $this->Employee_Attendance_Model->delete_employee($did);
            }
            $attend_date = Format_date($all_date[$i]);

            $data_1 = $this->Employee_Attendance_Model->get_work_by_date($attend_date, $emp_id);
            foreach ($data_1 as $k => $v) {
                $d_id = $v->id;
                $delete_employee1 = $this->Employee_Attendance_Model->delete_daily_work($d_id);
            }
            if ($delete_employee) {
                $B++;
                $array['success'] = 'success';
            } else {
                $array['success'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>This (' . $all_date[$i] . ') leave record found to delete!</p></div></div></div>';
            }
            foreach ($data as $leave_data) {
                if (isset($data) && count($data) > 0) {
                    $date = $leave_data->leave_date;
                    $data1 = $this->Leave_Request_Model->delete_employee($leave_data->id);
                    if ($data1) {
                        $k++;
                        $array['success'] = 'success';
                        // $array['success'] = 'This ('.$date.') Leave Date Delete successfully';       
                    } else {
                        $array['success'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>This (' . $date . ') leave record found to delete!</p></div></div></div>';
                    }
                }
            }
        }
        if (!empty($sunday_err) && count($all_date) == $A) {
            $array['success'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Selected all date are official holiday!</p></div></div></div>';
        } elseif ($k == 0 && $B == 0) {
            $array['success'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Records not matched!</p></div></div></div>';
        }
        echo json_encode($array);
    }
    public function update_employee_status()
    {
        $id = $this->request->getPost("id");
        $status = $this->request->getPost("status");
        if ($status == "1") {
            $status_chanage = 0;
        }
        if ($status == "0") {
            $status_chanage = 1;
        }
        $arr = array(
            'id' => $id,
            'status' => $status_chanage,
        );
        $update_emp = $this->Employee_Model->update_employee($arr);
    }

    public function full_month_attendance1()
    {
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            return redirect()->to('dashboard');
        }
        $user_session = $this->session->get('id');
        if (!$user_session) {
            return redirect()->to(base_url('admin'));
        }
        $data = array();
        $data['designation'] = $this->Designation_Model->get_designation();
        $data['get_developer'] = $this->Employee_Model->get_employee_list(1);
        if ($this->uri->getSegment(3)) {
            $data['page_title'] = "Edit attendance";
            $id = $this->uri->getSegment(3);
            $data['list_data'] = $this->Employee_Model->get_employee($id);
        } else {
            $data['list_data'] = "";
            $data['page_title'] = "Add attendance";
        }
        $data['js_flag'] = "emp_js";
        $data['menu'] = "full_month_attendance";
        $this->lib->view('administrator/employee/add_full_attendance', $data);
    }

    public function insert_full_attendance()
    {
        /*echo "<pre>";
        print_r($this->request->getPost());
        exit();*/
        // print_r($_POST);
        $data = array();
        $this->form_validation->reset();
        $this->form_validation->setRule('month', 'month', 'required');
        $this->form_validation->setRule('year', 'Year', 'required');
        $this->form_validation->setRule('developer', 'Employee', 'required');
        if ($this->validate($this->form_validation->getRules()) == false) {
            $data['massage'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $this->validator->listErrors() . '</p></div></div></div>';
            // $this->session->setFlashdata('message', $this->validator->listErrors());
            // return redirect()->to(base_url('employee/full_month_attendance'));
        } else {
            $holiday_date = $this->Holiday_Model->get_holiday_all();
            $holiday = array();
            if ($holiday_date) {
                foreach ($holiday_date as $holiday_day) {
                    $holiday[] = $holiday_day->holiday_date;
                }
            }
            $month = $this->request->getPost("month");
            $year = $this->request->getPost("year");
            $developer = $this->request->getPost("developer");
            $get_total_month_leave_list = $this->Leave_Request_Model->get_total_month_leave_list($developer, $month, $year);
            $total_leave_date = array();
            foreach ($get_total_month_leave_list as $total_month_leave) {
                array_push($total_leave_date, $total_month_leave->leave_date);
            }
            $list = array();
            $arr = array();
            $arr1 = array();
            //	echo "<pre>";
            $insert_success = '';
            for ($d = 1; $d <= 31; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month) {
                    if (date('N', strtotime(date('Y-m-d', $time))) != 7 && date('N', strtotime(date('Y-m-d', $time))) != 6) {
                        if (!in_array(date('Y-m-d', $time), $holiday)) {

                            if (date('N', strtotime(date('Y-m-d', $time))) == 6) {
                                //$list['sat'][]=date('Y-m-d', $time);
                                $get_employee_exists_attendance_date = $this->Employee_Model->get_employee_exists_attendance_date($developer, date('Y-m-d', $time));
                                if ($get_employee_exists_attendance_date > 0 || in_array(date('Y-m-d', $time), $total_leave_date)) {
                                    // allready insert data

                                } else {
                                    //echo "vfgxfdgs";
                                    $attendance_sat = array(
                                        'employee_in' => date('Y-m-d 09:30:00', strtotime(date('Y-m-d', $time))),
                                        'employee_out' => date('Y-m-d 14:00:00', strtotime(date('Y-m-d', $time))),
                                        'attendance_type' => "full_day",
                                        'employee_id' => $developer,
                                    );
                                    $insert_success = $this->Employee_Attendance_Model->insert_employee($attendance_sat);
                                    // $insert_success = true;
                                }
                            } else {
                                $get_employee_exists_attendance_date = $this->Employee_Model->get_employee_exists_attendance_date($developer, date('Y-m-d', $time));
                                // $get_employee_exists_attendance_date = $this->Employee_Model->get_employee_exists_attendance_date($developer, date('Y-m-d', $time));
                                if ($get_employee_exists_attendance_date > 0 || in_array(date('Y-m-d', $time), $total_leave_date)) {
                                    // allready insert data

                                } else {
                                    //echo "dnwwsefwge";
                                    $attendance = array(
                                        'employee_in' => date('Y-m-d 09:00:00', strtotime(date('Y-m-d', $time))),
                                        'employee_out' => date('Y-m-d 14:00:00', strtotime(date('Y-m-d', $time))),
                                        'attendance_type' => "full_day",
                                        'employee_id' => $developer,
                                    );
                                    // array_push($arr,$attendance);
                                    $insert_success = $this->Employee_Attendance_Model->insert_employee($attendance);
                                    // $insert_success = $this->db->table('employee_attendance')->insert($attendance);
                                    // $insert_success = true;
                                    $after_lunch = array(
                                        'employee_in' => date('Y-m-d 14:45:00', strtotime(date('Y-m-d', $time))),
                                        'employee_out' => date('Y-m-d 18:30:00', strtotime(date('Y-m-d', $time))),
                                        'attendance_type' => "full_day",
                                        'employee_id' => $developer,
                                    );
                                    // array_push($arr1,$after_lunch);
                                    $insert_success = $this->Employee_Attendance_Model->insert_employee($after_lunch);
                                    // $insert_success = true;
                                }
                            }
                        }
                    }
                }
            }
            if ($insert_success) {
                $data['massage'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Employee full month attendance added.</p></div></div></div>';
            } else {
                $data['massage'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Employee full month attendance failed to add!</p></div></div></div>';
            }
            // return redirect()->to(base_url('employee/employee_attendance_list_admin/' . $developer));
            /*return redirect()->to(base_url('employee/employee_attendance_list/' . $developer));*/
        }
        /* echo json_encode($arr);
        echo json_encode($arr1); */
        echo json_encode($data);
    }

    public function full_month_attendance()
    {
        $id = "0";
        if ($this->uri->getSegment(3)) {
            $id = $this->uri->getSegment(3);
        }

        $user_session = $this->session->get('id');
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            if ($user_session != $id) {
                return redirect()->to(base_url('dashboard'));
            }
        }
        $data = array();
        $data['id'] = $id;
        $data['js_flag'] = "employee_attendance_js";
        $data['page_title'] = "Add attendance";
        $search = "";
        $data['holiday_date'] = $this->Holiday_Model->get_holiday_all();
        $data['get_leave_employee'] = $this->Leave_Request_Model->get_leave_employee($id);
        if ($_POST) {
            $search = $_POST;
            $data['employee_attendance_list'] = $this->Employee_Attendance_Model->employee_attendance_list_month_year($id, $search);
            $data['search'] = $search;
        } else {
            $data['employee_attendance_list'] = $this->Employee_Attendance_Model->employee_attendance_list_month_year($id, $search);
        }
        $data['search'] = $search;
        $data['get_employee'] = $this->Employee_Model->get_employee($id);

        $data['get_developer'] = $this->Employee_Model->get_employee_list(1);
        $data['menu'] = "full_month_attendance";
        $this->lib->view('administrator/employee/add_full_attendance', $data);
    }
    public function add()
    {
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            return redirect()->to('dashboard');
        }
        $user_session = $this->session->get('id');
        if (!$user_session) {
            return redirect()->to(base_url('admin'));
        }
        $data = array();
        $data['designation'] = $this->Designation_Model->get_designation();
        if ($this->uri->getSegment(3)) {
            $data['page_title'] = "Edit Employee";
            $id = $this->uri->getSegment(3);
            $data['list_data'] = $this->Employee_Model->get_employee($id);
            $data['get_employee_increment'] = $this->Employee_Increment_Model->get_employee_increment_row($id);
            //$data['employee_increment']= $this->Employee_Increment_Model->get_employee_increment_row($id);
            //$data['employee_increment1']= $this->Employee_Increment_Model->get_employee_increment();

        } else {
            $data['list_data'] = "";
            $data['page_title'] = "Add Employee";
        }
        $data['js_flag'] = "emp_js";
        $data['menu'] = "add_emp";
        $this->lib->view('administrator/employee/add_employee', $data);
    }
    public function delete_employee()
    {
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            return redirect()->to('dashboard');
        }
        if ($this->request->getPost("id")) {
            $id = $this->request->getPost("id");
            for ($i = 0; $i < count($id); $i++) {
                $delete_employee = $this->Employee_Model->delete_employee($id[$i]);
            }
        }
    }

    public function insert_data()
    {
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            return redirect()->to('profile');
        }
        $id = $this->request->getPost("e_id");
        $fname = $this->request->getPost("fname");
        $lname = $this->request->getPost("lname");
        $email = $this->request->getPost("email");
        $personal_email = $this->request->getPost("personal_email");
        $addPassword = $this->request->getPost("addPassword");

        $password = "DecodeX@217";
        $phone_number = $this->request->getPost("phone_number");

        $birth_date = $this->request->getPost("birth_date");

        $birth_date = ($birth_date == '0000-00-00') ? '' : $birth_date;

        $joining_date = $this->request->getPost("joining_date");
        $gender = $this->request->getPost("gender");
        $address = $this->request->getPost("address");
        $designation = $this->request->getPost("designation");

        $salary = $this->request->getPost("basic_salary");
        $deduction = $this->request->getPost("salary_deduction");
        $skype_account = $this->request->getPost("skype_account");
        $skype_password = $this->request->getPost("skype_password");
        $gmail_account = $this->request->getPost("gmail_account");
        $gmail_password = $this->request->getPost("gmail_password");
        $employee_status = $this->request->getPost("employee_status");
        $account_number = $this->request->getPost("account_number");
        $ifsc_number = $this->request->getPost("ifsc_number");
        $bank_name = $this->request->getPost("bank_name");
        $upi_type = $this->request->getPost("upi_type");
        $upi_id = $this->request->getPost("upi_id");
        
        $employed_date = "";
        if ($this->request->getPost("employed_date")) {
            $employed_date = Format_date($this->request->getPost("employed_date"));
        }
        $crendt = array(
            "gmail" => array(
                'gmail_account' => $gmail_account,
                'gmail_password' => $gmail_password
            ),
            "skype" => array(
                'skype_account' => $skype_account,
                'skype_password' => $skype_password
            ),
        );
        $credentials = json_encode($crendt);
        $this->form_validation->reset();
        $this->form_validation->setRule('fname', 'FIrst Name', 'required|max_length[50]');
        $this->form_validation->setRule('phone_number', 'Phone Number', 'required|regex_match[/^[0-9]{10}$/]');
        $this->form_validation->setRule('lname', 'Last Name', 'required|max_length[50]');
        $this->form_validation->setRule('gmail_account', 'Gmail Account', 'required|valid_email|max_length[254]');
        $this->form_validation->setRule('gmail_password', 'Gmail Password', 'required');
        $this->form_validation->setRule('skype_account', 'Skype Account', 'required|valid_email|max_length[254]');
        $this->form_validation->setRule('skype_password', 'Skype Password', 'required');
        if (!isset($id) || empty($id)) {
            $this->form_validation->setRule('email', 'Email', 'required|valid_email|is_unique[employee.email]|max_length[254]');
        } else {
            $this->form_validation->setRule('email', 'Email', 'required|valid_email|max_length[254]');
        }
        $this->form_validation->setRule('designation', 'Designation', 'required');

        $this->form_validation->setRule('gender', 'Gender', 'required');

        $this->form_validation->setRule('joining_date', 'Joining Date', 'required');

        $this->form_validation->setRule('basic_salary', 'Salary', 'required');
        $this->form_validation->setRule('salary_deduction', 'Salary Deduction', 'required');
        $this->form_validation->setRule('employee_status', 'Status', 'required');
        // echo '<pre>'; print_r($this->request->getPost());exit;
        // if ($this->validate($this->form_validation->getRules()) == false)
        if ($this->validate($this->form_validation->getRules()) == false) {
            $this->session->setFlashdata('message', $this->validator->listErrors());
            return redirect()->to(base_url('employee/add'));
        } else {

            if (!isset($id) || empty($id)) {
                $paid_leave = "0";
                if ($salary != '0' && $salary != '') {
                    $paid_leave = "1";
                }
                $decode = md5($password);
                $arr = array(
                    'fname' => $fname,
                    'lname' => $lname,
                    'email' => $email,
                    'personal_email' => $personal_email,
                    'password' => $decode,
                    'gender' => $gender,
                    'phone_number' => $phone_number,
                    'date_of_birth' => Format_date($birth_date),
                    'address' => $address,
                    'designation' => $designation,
                    'joining_date' => Format_date($joining_date),
                    'credential' => $credentials,
                    'status' => '1',
                    'salary' => $salary,
                    'salary_deduction' => $deduction,
                    'bank_name' => $bank_name,
                    'account_number' => $account_number,
                    'ifsc_number' => $ifsc_number,
                    'upi_type' => $upi_type,
                    'upi_id' => $upi_id,
                    'ifsc_number' => $ifsc_number,
                    'monthly_paid_leave' => $paid_leave,
                    'employee_status' => $employee_status,


                );
                if ($employee_status == "employee") {
                    $arr['employed_date'] = Format_date($joining_date);
                }
                $user_exist_error = "";
                $employee_exists = $this->Employee_Model->get_exists_employee($email);
                if ($employee_exists > 0) {
                    $user_exist_error = "Employee already exists!";
                    $this->session->setFlashdata('user_exists_message', $user_exist_error);
                    return redirect()->to(base_url('employee/add'));
                } else {
                    $insert_employee = $this->Employee_Model->insert_employee($arr);
                    // $insert_employee = true;
                    if ($insert_employee) {

                        if ($employee_status == "employee") {

                            $insert_id = $insert_employee;
                            $arr1 = array(
                                'increment_date' =>  Format_date($joining_date),
                                'employee_id' => $insert_id,
                                'next_increment_date' =>  Format_date("+1 year", strtotime($joining_date)),
                                'amount' => $salary,
                                'status' => "approved",
                            );
                            $increment = $this->Employee_Increment_Model->insert_data($arr1);

                            /*  insert new paid leave */
                            $month = date('m', strtotime($joining_date));
                            $year = date('Y', strtotime($joining_date));
                            $leave_update = array(
                                'employee_id' => $insert_id,
                                'leave' => 1,
                                'month' => $month,
                                'year' => $year,
                                'status' => 'unused',
                                'used_leave_month' => 0
                            );
                            $this->db->table('employee_paid_leaves')->insert( $leave_update);
                        }
                        $emp_detail = $this->Employee_Model->get_employee($insert_employee);
                        if ($emp_detail[0]->personal_email) {
                            $data1 = array();
                            $content = $this->Mail_Content_Model->mail_content_by_slug('welcome_mail');
                            $data1['mail_type'] = 'welcome_mail';
                            $data1['name'] = $emp_detail[0]->fname . ' ' . $emp_detail[0]->lname;
                            $data1['base_url'] = base_url() . '';
                            $data1['title'] = 'Welcome to DecodeX Family';
                            $data1['greeting'] = 'Welcome';
                            $data1['img_name'] = 'handshake.png';
                            $data1['subject'] = $data1['name'] . ',welcome to the company';
                            $data1['message'] = $content[0]->content;
                            $data1['to'] = $emp_detail[0]->personal_email;
                            $mail_send_code = $this->mailfunction->mail_send($data1);
                            if ($mail_send_code == 'error') {
                                $this->session->setFlashdata('message', 'Email Not Sended');
                                return redirect()->to(base_url() . 'employee/add');
                            }
                        } else {
                            $this->session->setFlashdata('message', 'Employee personal email not found');
                            return redirect()->to(base_url() . 'employee/add');
                        }
                        return redirect()->to(base_url() . 'employee');
                    }
                }
            } else {
                $paid_leave = "0";
                if ($salary != '0' && $salary != '') {
                    $paid_leave = "1";
                }
                
                $list_data = $this->Employee_Model->get_employee($id);
                
                $decode = (!empty($addPassword)) ? md5($password) :  $list_data[0]->password;

                if ($employee_status == "employee" && ($list_data[0]->employed_date == "" || $list_data[0]->employed_date == "0000-00-00")) {
                    $arr = array(
                        'id' => $id,
                        'fname' => $fname,
                        'lname' => $lname,
                        'email' => $email,
                        'personal_email' => $personal_email,
                        'password' => $decode,
                        'gender' => $gender,
                        'phone_number' => $phone_number,
                        'date_of_birth' => Format_date($birth_date),
                        'address' => $address,
                        'designation' => $designation,
                        'joining_date' => Format_date($joining_date),
                        'credential' => $credentials,
                        'status' => '1',
                        'salary' => $salary,
                        'salary_deduction' => $deduction,
                        'employee_status' => $employee_status,
                        'bank_name' => $bank_name,
                        'account_number' => $account_number,
                        'ifsc_number' => $ifsc_number,
                        'upi_type' => $upi_type,
                        'upi_id' => $upi_id,
                        'monthly_paid_leave' => $paid_leave,
                        'employed_date' => date("Y-m-d"),
                        'updated_date' => date('Y-m-d h:i:s'),
                    );
                    $insert_employee = $this->Employee_Model->update_employee($arr);

                    $insert_id = $id;
                    $increment_date1 = date('Y-m-d');
                    $arr1 = array(
                        'increment_date' =>  $increment_date1,
                        'employee_id' => $insert_id,
                        'next_increment_date' =>  Format_date("+1 year", strtotime($increment_date1)),
                        'amount' => $salary,
                        'status' => "approved",
                    );

                    $increment = $this->Employee_Increment_Model->insert_data($arr1);
                    if($increment){
                        $insert_id = $id;
                        $increment_date1 = date('Y-m-d',strtotime('+1 year'));
                        $arr1 = array(
                            'increment_date' =>  $increment_date1,
                            'employee_id' => $insert_id,
                            'next_increment_date' =>  '0000-00-00',
                            'amount' => 0,
                            'status' => "pending",
                        );
                        $increment = $this->Employee_Increment_Model->insert_data($arr1);
                    }
                    /*  insert new paid leave */
                    $month = date('m', strtotime($joining_date));
                    $year = date('Y', strtotime($joining_date));
                    $leave_update = array(
                        'employee_id' => $insert_id,
                        'leave' => 1,
                        'month' => $month,
                        'year' => $year,
                        'status' => 'unused',
                        'used_leave_month' => 0
                    );
                    $this->db->table('employee_paid_leaves')->insert($leave_update);
                } else {
                    $arr = array(
                        'id' => $id,
                        'fname' => $fname,
                        'lname' => $lname,
                        'email' => $email,
                        'personal_email' => $personal_email,
                        'password' => $decode,
                        'gender' => $gender,
                        'phone_number' => $phone_number,
                        'date_of_birth' => Format_date($birth_date),
                        'address' => $address,
                        'designation' => $designation,
                        'joining_date' => Format_date($joining_date),
                        'credential' => $credentials,
                        'status' => '1',
                        'salary' => $salary,
                        'bank_name' => $bank_name,
                        'account_number' => $account_number,
                        'ifsc_number' => $ifsc_number,
                        'upi_type' => $upi_type,
                        'upi_id' => $upi_id,
                        'salary_deduction' => $deduction,
                        'employee_status' => $employee_status,
                        'employed_date' => $employed_date,
                        'updated_date' => date('Y-m-d h:i:s'),
                    );
                    $insert_employee = $this->Employee_Model->update_employee($arr);
                    if ($insert_employee) {
                        $get_employee_increment = $this->Employee_Increment_Model->get_employee_increment('approved', $id);
                        $lastIndex = count($get_employee_increment) - 1;
                        $amount = 0;
                        foreach ($get_employee_increment as $incrementDetails) {
                            $amount += $incrementDetails->amount;
                        }
                        if ($amount > $salary) {
                            $amount1 = $amount - $salary;
                            if ($get_employee_increment[$lastIndex]->amount >= $amount1) {
                                $data = array(
                                    'id' => $get_employee_increment[$lastIndex]->id,
                                    'amount' => ($get_employee_increment[$lastIndex]->amount) - $amount1,
                                    'updated_date' => date('Y-m-d h:i:s'),
                                );
                                $update = $this->Increment_Model->update_data($data);
                            } else {
                                for ($i = $lastIndex; $i >= 0; $i--) {
                                    if ($amount1 > 0) {
                                        $count = $amount1 - $get_employee_increment[$i]->amount;
                                        if ($count >= 0) {
                                            $amount1 -= $get_employee_increment[$i]->amount;
                                            $data = array(
                                                'id' => $get_employee_increment[$i]->id,
                                                'amount' => 0,
                                                'updated_date' => date('Y-m-d h:i:s'),
                                            );
                                        } else {
                                            $data = array(
                                                'id' => $get_employee_increment[$i]->id,
                                                'amount' => ($get_employee_increment[$i]->amount) - $amount1,
                                                'updated_date' => date('Y-m-d h:i:s'),
                                            );
                                            $amount1 -= $get_employee_increment[$i]->amount;
                                        }
                                        $update = $this->Increment_Model->update_data($data);
                                    }
                                }
                            }
                            // --
                        } elseif ($amount < $salary) {
                            $amount1 = $salary - $amount;
                            $data = array(
                                'id' => $get_employee_increment[$lastIndex]->id,
                                'amount' => ($get_employee_increment[$lastIndex]->amount) + $amount1,
                                'updated_date' => date('Y-m-d h:i:s'),
                            );
                            $update = $this->Increment_Model->update_data($data);
                            // ++
                        }
                    }

                    /* if ($this->request->getPost("increment_amount"))
                    {
                        $increment_id = $this->request->getPost("increment_id");
                        $increment_amount = $this->request->getPost("increment_amount");
                        $increment_date = $this->request->getPost("increment_date");
                        $next_increment_date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($increment_date)) . " + 1 year"));
                        if ($this->request->getPost('next_increment_date') != "")
                        {
                            $next_increment_date = $this->request->getPost('next_increment_date');
                        }
                        $arr = array(
                            'id' => $increment_id,
                            'increment_date' => $increment_date,
                            'employee_id' => $id,
                            'next_increment_date' => $next_increment_date,
                            'amount' => $increment_amount,
                            'status' => "approved",
                            'updated_date' => date('Y-m-d h:i:s') ,
                        );
					 $insert_employee = $this->Employee_Increment_Model->update($arr); 
                    } */
                }

                if ($insert_employee) {
                    return redirect()->to(base_url('employee'));
                }
            }
        }
    }
    public function employee_attendance_list($id='')
    {
        $user_session = $this->session->get('id');
        $user_role = $this->session->get('user_role');
        $data = array();
        $data['get_employee_list'] = $this->Employee_Model->get_employee_list(1);
        $data['get_deactive_emp'] = $this->Employee_Model->get_employee_list(0);
        if ($user_role != 'admin') {
            if ($user_session != $id) {
                return redirect()->to(base_url('dashboard'));
            }
        }elseif(empty($id)){
            $id = $data['get_employee_list'][0]->id;
        }

        // $data['js_flag'] = "employee_attendance_js";
        $data['page_title'] = "Employee attendance List";
        $search = "";
        $data['holiday_date'] = $this->Holiday_Model->get_holiday_all();

        $data['get_leave_employee'] = $this->Leave_Request_Model->get_leave_employee($id);
        $data['daily_work_list'] = $this->Employee_Attendance_Model->get_work_by_date(date('Y-m-d'), $id);
        if ($_POST) {
            $search = $_POST;
            $employee = $this->request->getPost("employee");
            if (isset($employee) && !empty($employee)) {
                $id = $employee;
            }
            $employee_out_time = $this->request->getPost("employee_out");
            $data['employee_attendance_list'] = $this->Employee_Attendance_Model->employee_attendance_list_month_year($id, $search);
            $data['search'] = $search;
        } else {
            $data['employee_attendance_list'] = $this->Employee_Attendance_Model->employee_attendance_list_month_year($id, $search);
            $data['search']['employee'] = $id;
            $data['search']['month'] = date('m');
            $data['search']['year'] = date('Y');
        }

        $data['get_employee'] = $this->Employee_Model->get_employee($id);
        $data['id'] = $id;
        $data['menu'] = "employee_attendance";
        if ($user_role != 'admin') {
            $data['get_employee_attendance'] = $this->Employee_Attendance_Model->get_employee_attendance_date();
            $data['js_flag'] = "employee_attendance_js";
            $this->lib->view('administrator/employee/employee_attendance_list', $data);
        } else {
            $data['js_flag'] = "employee-attendance_admin_js";
            $this->lib->view('administrator/employee/employee_attendance_list_admin', $data);
        }
    }
    public function total_employee_attendance()
    {
        $month = $this->request->getPost('month');
        $year = $this->request->getPost('year');
        $id = $this->request->getPost('id');
        $data = array();
        $data1 = array(
            'month' => $month,
            'year' => $year,
            'employee_id' => $id,
        );
        $data['emp_detail'] = $this->Employee_Model->get_employee($id);
        $data['total_time'] = $this->allfunction->employee_total_working_time($data1);
        $data['csrf_token'] = csrf_hash();
        echo json_encode($data);
    }
    public function get_employee_detail()
    {
        $id = $this->request->getPost('id');
        $data = array();
        $data['emp_detail'] = $this->Employee_Model->get_employee($id);
        echo json_encode($data);
    }
    public function employee_data_new()
    {
        $holiday_date = $this->Holiday_Model->get_holiday_all();
        $holiday = array();
        if ($holiday_date) {
            foreach ($holiday_date as $holiday_day) {
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
        if ($get_leave_employee) {
            foreach ($get_leave_employee as $get_leave) {
                $leave[] = $get_leave->leave_date;
                $leave_status[$get_leave->leave_date]['status'] = $get_leave->status;
                if ($get_leave->leave_status == "none" || $get_leave->leave_status == "") {
                    $leave_status[$get_leave->leave_date]['leave_status'] = "absent";
                } else {
                    $leave_status[$get_leave->leave_date]['leave_status'] = $get_leave->leave_status;
                }
            }
        }

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
                        $att_date[] = $in_date;
                    }
                }
            }
        }
        $list = array();
        $nestedData = array();
        $data = array();
        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $total_time = "";
                $list_date = date('Y-m-d', $time);
                if ($this->request->getPost('user') != "admin") {
                    // $action = '<a data-id="' . $id . '" data-date="' . $list_date . '"  class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="' . base_url("employee/employee_attendance/" . $id . "/" . $list_date) . '">Edit</a><a data-id="' . $id . '" data-date="' . $list_date . '"  class="delete-employee-attendances btn btn-danger waves-effect waves-light">Delete</a>';
                    $action = '<button data-id="' . $id . '" data-date="' . $list_date . '" class="view-work-updates btn btn-outline-secondary">View</button>';
                }
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
                        if (isset($arr[$list_date]['out'][1])) {
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
                    if ($weekDay == 6 && strtotime($chnage_time) > strtotime($list_date)) {
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
                } else {
                    $attendance_types = "";
                    if (date('N', strtotime($list_date)) == 7) {
                        $attendance_types = "Sunday";
                    } else if (date('N', strtotime($list_date)) == 6) {
                        $chnage_time = CHANGE_TIME;
                        if (strtotime($chnage_time) <= strtotime($list_date)) {
                            $attendance_types = "Saturday";
                        } else {
                            if (in_array($list_date, $holiday)) {
                                // $attendance_types = "Holiday";
                                $holiday_date = $this->Holiday_Model->get_holidayByDate($list_date);
                                $attendance_types = "<strong class='holiday'>".$holiday_date[0]->title."</strong>";
                            } else {
                                if (in_array($list_date, $leave)) {
                                    if ($leave_status[$list_date]['status'] == "approved") {
                                        if ($leave_status[$list_date]['leave_status'] == "paid") {
                                            $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                            $class_tr = "paid-leave-color";
                                        } else if ($leave_status[$list_date]['leave_status'] == "sick") {
                                            $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                            $class_tr = "sick-leave-color";
                                        } else {
                                            $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                            $class_tr = "absent-leave-color";
                                        }
                                    } else if ($leave_status[$list_date]['status'] == "rejected") {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "unapprove-leave-color";
                                    } else {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "absent-leave-color";
                                    }
                                } else {
                                    $attendance_types = "";
                                    if (strtotime($list_date) < strtotime(date('Y-m-d'))) {
                                        $attendance_types = "Kindly contact Hr, Otherwise, 1.5 Days of leave will be deducted.";
                                        //$class_tr = "absent-leave-color";
                                    }
                                }
                            }
                        }
                    } else {
                        if (in_array($list_date, $holiday)) {
                            // $attendance_types = "Holiday";
                            $holiday_date = $this->Holiday_Model->get_holidayByDate($list_date);
                            $attendance_types = "<strong class='holiday'>".$holiday_date[0]->title."</strong>";
                        } else {
                            if (in_array($list_date, $leave)) {
                                if ($leave_status[$list_date]['status'] == "approved") {
                                    if ($leave_status[$list_date]['leave_status'] == "paid") {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "paid-leave-color";
                                    } else if ($leave_status[$list_date]['leave_status'] == "sick") {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "sick-leave-color";
                                    } else {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "absent-leave-color";
                                    }
                                } else if ($leave_status[$list_date]['status'] == "rejected") {
                                    $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                    $class_tr = "unapprove-leave-color";
                                } else {
                                    $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                    $class_tr = "absent-leave-color";
                                }
                            } else {
                                $attendance_types = "";
                                if (strtotime($list_date) < strtotime(date('Y-m-d'))) {
                                    $attendance_types = "Kindly contact Hr, Otherwise, 1.5 Days of leave will be deducted.";
                                    //$class_tr = "absent-leave-color";
                                }
                            }
                        }
                    }
                    $in1 = "";
                    $in2 = "";
                    $out1 = "";
                    $out2 = "";
                    $time = "";
                }
                /* if(!empty($in1) && empty($out1)){
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
                if ($this->request->getPost('user') != "admin") {
                    $nestedData['action'] = $action;
                }

                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "data" => $data,
            "csrf_token" => csrf_hash()
        );
        echo json_encode($json_data);
    }
    public function employee_data_new1()
    {
        $holiday_date = $this->Holiday_Model->get_holiday_all();
        $holiday = array();
        if ($holiday_date) {
            foreach ($holiday_date as $holiday_day) {
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
        if ($get_leave_employee) {
            foreach ($get_leave_employee as $get_leave) {
                $leave[] = $get_leave->leave_date;
                $leave_status[$get_leave->leave_date]['status'] = $get_leave->status;
                if ($get_leave->leave_status == "none" || $get_leave->leave_status == "") {
                    $leave_status[$get_leave->leave_date]['leave_status'] = "absent";
                } else {
                    $leave_status[$get_leave->leave_date]['leave_status'] = $get_leave->leave_status;
                }
            }
        }
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
                        $att_date[] = $in_date;
                    }
                }
            }
        }

        $list = array();
        $nestedData = array();
        $data = array();
        $update_class = '';
        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {
                $user_role = $this->session->get('user_role');

                $total_time = "";
                $list_date = date('Y-m-d', $time);
                $chekbox = '<input type="checkbox" name="chek1" class="attendances_check" value="' . $list_date . '">';
                // <a data-id="' . $id . '" data-date="' . $list_date . '"  class="edit-employee-attendances btn btn-danger waves-effect waves-light" href="' . base_url("employee/employee_attendance/" . $id . "/" . $list_date) . '">Edit</a>
                // <a data-id="' . $id . '" data-date="' . $list_date . '"  class="delete-employee-attendances btn btn-active waves-effect waves-light">Delete</a>
                $action = '<button data-id="' . $id . '" data-date="' . $list_date . '" class="edit-employee-attendances btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal_attendsnce"><i class="fas fa-pen"></i></button>';
                if (isset($arr[$list_date])) {
                    $attendance_types = $arr[$list_date]['attendance_types'][0];
                    if ($user_role == "admin" && ($attendance_types  == 'Half Day' || $attendance_types  == 'Full Day')) {
                        $update_class = "field-edit";
                    }
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
                    if (!empty($in1)) {
                        $time_update = date('H:i', strtotime($in1));
                    } else {
                        $time_update = '';
                        $in1 = '00:00';
                    }
                    if ($user_role == "admin" && ($attendance_types  == "Half Day" || $attendance_types  == "Full Day")) {
                        $popup = '<div class="field-box">
                                <form>
                                    <div class="form-group">
                                        <label>In (' . $list_date . ')</label>
                                        <input type="time" name="time" required class="form-control get_time" value="' . $time_update . '">
                                    </div>
                                    <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="in" data-attendance-date="' . $list_date . '">
                                    <input type="button" value="Close" class="btn btn-close close_popup">
                                </form>
                            </div>';
                    } else {
                        $popup = '';
                    }
                    $html_in1 = '<span class="td_in_time ' . $update_class . '" data-popup-status="active" data-type="in" data-attendance-date="' . $list_date . '">
                            <span class="in_time_' . $list_date . ' in">' . $in1 . '</span>
                            ' . $popup . '
                            </span>';
                    if (!empty($arr[$list_date]['out'][0])) {
                        $active_class = "active";
                    } else {
                        $active_class = "";
                    }
                    if (!empty($in2)) {
                        $time_update = date('H:i', strtotime($in2));
                    } else {
                        $time_update = '';
                        if (date('N', strtotime($list_date)) != 6) {
                            $in2 = '00:00';
                        }
                    }
                    if ($user_role == "admin" && $attendance_types  == 'Full Day' && date('N', strtotime($list_date)) != 6) {
                        if (!empty($arr[$list_date]['out'][0])) {
                            $popup = '<div class="field-box">
                                <form>
                                    <div class="form-group">
                                        <label>In (' . $list_date . ')</label>
                                        <input type="time" name="time" required class="form-control get_time"  value="' . $time_update . '">
                                    </div>
                                    <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="in1" data-attendance-date="' . $list_date . '">
                                    <input type="button" value="Close" class="btn btn-close close_popup">
                                </form>
                            </div>';
                        } else {
                            $popup = '';
                        }
                    } else {
                        $popup = '';
                    }
                    $html_in2 = '<span class="td_in_time ' . $update_class . '" data-popup-status="' . $active_class . '" data-type="in1" data-attendance-date="' . $list_date . '">
                            <span class="in1_time_' . $list_date . ' in1">' . $in2 . '</span>
                                ' . $popup . '
                            </span>';
                    //out
                    if (isset($arr[$list_date]['out'])) {
                        $out1 = $arr[$list_date]['out'][0];

                        $strtotimeout1 = strtotime($out1);
                        if (isset($arr[$list_date]['out'][1])) {
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
                    if (!empty($arr[$list_date]['in'][0])) {
                        $active_class = "active";
                    } else {
                        $active_class = "";
                    }
                    if (!empty($out1)) {
                        $time_update = date('H:i', strtotime($out1));
                    } else {
                        $time_update = '';
                        $out1 = '00:00';
                    }
                    if ($user_role == "admin" && ($attendance_types  == 'Half Day' || $attendance_types  == 'Full Day')) {
                        if (!empty($arr[$list_date]['in'][0])) {
                            $popup = '<div class="field-box">
                                <form>
                                    <div class="form-group">
                                        <label>Out (' . $list_date . ')</label>
                                        <input type="time" name="time" required class="form-control get_time" value="' . $time_update . '">
                                    </div>
                                    <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="out" data-attendance-date="' . $list_date . '">
                                    <input type="button" value="Close" class="btn btn-close close_popup" data-type="out" data-attendance-date="' . $list_date . '">
                                </form>
                            </div>';
                        } else {
                            $popup = '';
                        }
                    } else {
                        $popup = '';
                    }
                    $html_out1 = '<span class="td_in_time ' . $update_class . '" data-popup-status="' . $active_class . '" data-type="out" data-attendance-date="' . $list_date . '">
                        <span class="out_time_' . $list_date . ' out">' . $out1 . '</span>
                            ' . $popup . '
                        </span>';
                    if (!empty($arr[$list_date]['in'][1])) {
                        $active_class = "active";
                    } else {
                        $active_class = "";
                    }
                    if (!empty($out2)) {
                        $time_update = date('H:i', strtotime($out2));
                    } else {
                        $time_update = '';
                        if (date('N', strtotime($list_date)) != 6) {
                            $out2 = '00:00';
                        }
                    }
                    if ($user_role == "admin" && $attendance_types  == 'Full Day' && date('N', strtotime($list_date)) != 6) {
                        if (!empty($arr[$list_date]['in'][1])) {
                            $popup = '<div class="field-box">
                                <form>
                                    <div class="form-group">
                                        <label>Out (' . $list_date . ')</label>
                                        <input type="time" name="time"required class="form-control get_time" value="' . $time_update . '">
                                    </div>
                                    
                                    <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="out1" data-attendance-date="' . $list_date . '">
                                    <input type="button" value="Close" class="btn btn-close close_popup">
                                </form>
                            </div>';
                        } else {
                            $popup = '';
                        }
                    } else {
                        $popup = '';
                    }
                    $html_out2 = '<span class="td_in_time ' . $update_class . '" data-popup-status="' . $active_class . '" data-type="out1" data-attendance-date="' . $list_date . '">
                        <span class="out1_time_' . $list_date . ' out1">' . $out2 . '</span>
                            ' . $popup . '
                        </span>';
                    if ($user_role == "admin" && ($attendance_types  == 'Half Day' || $attendance_types  == 'Full Day')) {
                        if ($attendance_types  == 'Full Day') {
                            $types = "selected='selected'";
                        } else {
                            $types = '';
                        }
                        if ($attendance_types  == 'Half Day') {
                            $types1 = "selected='selected'";
                        } else {
                            $types1 = '';
                        }
                        $popup = '<div class="field-box">
                            <form>
                                <div class="form-group">
                                    <label>attendance types</label>
                                    <select class="form-control get_time" name="time" >
                                        <option ' . $types . ' value="full_day">Full Day</option>
                                        <option ' . $types1 . '  value="half_day">Half Day</option>
                                    </select>
                                </div>
                                <input type="button" value="Update" class="btn sec-btn pull-right update_time" data-type="attendance_type" data-attendance-date="' . $list_date . '">
                                <input type="button" value="Close" class="btn btn-close close_popup">
                            </form>
                        </div>';
                    } else {
                        $popup = '';
                    }
                    $attendance_types_html = '<span class="td_in_time ' . $update_class . '" data-popup-status="active" data-type="attendance_type" data-attendance-date="' . $list_date . '"><span class="attendance_type_time_' . $list_date . ' attendance_type">' . $attendance_types . '</span>
                        ' . $popup . '
                    </span>';
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
                    if ($weekDay == 6 && strtotime($chnage_time) > strtotime($list_date)) {
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
                } else {
                    $attendance_types = "";
                    if (date('N', strtotime($list_date)) == 7) {
                        $attendance_types = "Sunday";
                        // $action = '';
                    } else if (date('N', strtotime($list_date)) == 6) {
                        $chnage_time = CHANGE_TIME;
                        if (strtotime($chnage_time) <= strtotime($list_date)) {
                            $attendance_types = "Saturday";
                            // $action = '';
                        } else {
                            if (in_array($list_date, $holiday)) {
                                $holiday_date = $this->Holiday_Model->get_holidayByDate($list_date);
                                $attendance_types = "<strong class='holiday'>".$holiday_date[0]->title."</strong>";
                                // $action = '';
                            } else {
                                if (in_array($list_date, $leave)) {
                                    if ($leave_status[$list_date]['status'] == "approved") {
                                        if ($leave_status[$list_date]['leave_status'] == "paid") {
                                            $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                            $class_tr = "paid-leave-color";
                                        } else if ($leave_status[$list_date]['leave_status'] == "sick") {
                                            $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                            $class_tr = "sick-leave-color";
                                        } else {
                                            $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                            $class_tr = "absent-leave-color";
                                        }
                                    } else if ($leave_status[$list_date]['status'] == "rejected") {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "unapprove-leave-color";
                                    } else {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "absent-leave-color";
                                    }
                                    // $action = '';
                                } else {
                                    // $attendance_types = "";
                                    $attendance_types = '';
                                }
                            }
                        }
                    } else {
                        if (in_array($list_date, $holiday)) {
                            $holiday_date = $this->Holiday_Model->get_holidayByDate($list_date);
                            $attendance_types = "<strong class='holiday'>".$holiday_date[0]->title."</strong>";
                            // $action = '';
                        } else {
                            if (in_array($list_date, $leave)) {
                                if ($leave_status[$list_date]['status'] == "approved") {
                                    if ($leave_status[$list_date]['leave_status'] == "paid") {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "paid-leave-color";
                                    } else if ($leave_status[$list_date]['leave_status'] == "sick") {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "sick-leave-color";
                                    } else {
                                        $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                        $class_tr = "absent-leave-color";
                                    }
                                } else if ($leave_status[$list_date]['status'] == "rejected") {
                                    $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                    $class_tr = "unapprove-leave-color";
                                } else {
                                    $attendance_types = ucwords($leave_status[$list_date]['leave_status']) . " Leave";
                                    $class_tr = "absent-leave-color";
                                }
                                // $action = '';
                            } else {
                                // $attendance_types = "";
                                $attendance_types = '';
                            }
                        }
                    }
                    $in1 = "";
                    $in2 = "";
                    $out1 = "";
                    $out2 = "";
                    $time = "";
                    $html_in1 = '';
                    $html_out1 = '';
                    $html_in2 = '';
                    $html_out2 = '';
                    $attendance_types_html = $attendance_types;
                }

                $nestedData['#'] = $chekbox;
                // $nestedData['id'] = $d;
                $nestedData['date'] = dateFormat($list_date);
                $nestedData['attendance'] = $attendance_types_html;
                // $nestedData['attendance'] = $attendance_types;
                $nestedData['in'] = $html_in1;
                $nestedData['out'] = $html_out1;
                $nestedData['in1'] = $html_in2;
                $nestedData['out1'] = $html_out2;
                $nestedData['total'] = $total_time;
                $nestedData['time'] = $time;
                if ($this->request->getPost('user') == "admin") {
                    $nestedData['action'] = $action;
                }

                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "data" => $data
        );
        echo json_encode($json_data);
    }
    public function delete_employee_attendance()
    {

        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            return redirect()->to('dashboard');
        }
        $date = $this->request->getPost("date");
        $id = $this->request->getPost("id");
        $attend_date = Format_date($date);

        $data1 = $this->Employee_Attendance_Model->get_work_by_date($attend_date, $id);
        $data = $this->Employee_Attendance_Model->employee_attendance_date($date, $id);
        $delete_employee = '';
        foreach ($data as $key => $value) {
            $did = $value->id;
            $delete_employee = $this->Employee_Attendance_Model->delete_employee($did);
        }
        if (count($data1) > 0) {
            foreach ($data1 as $k => $v) {
                $d_id = $v->id;
                $delete_employee1 = $this->Employee_Attendance_Model->delete_daily_work($d_id);
            }
        } else {
            $delete_employee1 = true;
        }
        if ($delete_employee && $delete_employee1) {
            echo 'Employee attendance Deleted successfully.';
        }
    }
    public function employee_attendance($id, $date = "")
    {
        $user_session = $this->session->get('id');
        if (!$user_session) {
            return redirect()->to(base_url('admin'));
        }
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            return redirect()->to('dashboard');
        }
        $data = array();
        $data['page_title'] = "Add Employee attendance";
        $data['get_employee'] = $this->Employee_Model->get_employee($id);
        $data['get_employee_list'] = $this->Employee_Model->get_employee_list(1);
        $data['get_employee_attendance'] = $this->Employee_Attendance_Model->get_employee_attendance_details($id, $date);
        $get_employee_attendance_data = $this->Employee_Attendance_Model->get_employee_attendance_data($id);
        $data['date_month'] = $get_employee_attendance_data;
        $data['id'] = $id;
        $data['get_date'] = $date;
        if ($_POST) {
            $employee = $this->request->getPost("employee");
            if (!empty($date)) {
                return redirect()->to(base_url('employee/employee_attendance/' . $employee . '/' . $date));
            } else {
                $date = date('Y-m-d');
                return redirect()->to(base_url('employee/employee_attendance/' . $employee . '/' . $date));
            }
        }

        $data['js_flag'] = "employee_attendance_admin_js";
        $data['menu'] = "employee_attendance_add";
        $this->lib->view('administrator/employee/employee_attendance_admin', $data);
    }
    public function getWork_Updates()
    {
        $user_session = $this->session->get('id');
        if (!$user_session) {
            return redirect()->to(base_url());
        }
        $data = array();
        $id = $this->request->getPost('id');
        $date = Format_date($this->request->getPost('date'));
        $data['daily_work_list'] = $this->Employee_Attendance_Model->get_work_by_date($date, $id);
        (isset($data['daily_work_list']) && !empty($data['daily_work_list'])) ? $data['daily_work_list'][0]->date = dateFormat($data['daily_work_list'][0]->attendance_date) : '';
        echo json_encode($data);
    }
    public function employee_attendance1()
    {
        $user_session = $this->session->get('id');
        if (!$user_session) {
            return redirect()->to(base_url('admin'));
        }
        $id = $this->request->getPost('id');
        $time = mktime(12, 0, 0, $this->request->getPost('month'), $this->request->getPost('day'), $this->request->getPost('year'));
        $date = date('Y-m-d', $time);
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            return redirect()->to('dashboard');
        }
        $data = array();
        $data['page_title'] = "Add Employee attendance";
        $data['get_employee_attendance'] = $this->Employee_Attendance_Model->get_employee_attendance_details($id, $date);
        $data['employee_attendance'] = $this->Employee_Attendance_Model->get_employee_attendance_date($id, $date);
        $data['daily_work_list'] = $this->Employee_Attendance_Model->get_work_by_date($date, $id);

        if (!empty($data['employee_attendance'][0]->employee_in)) {
            $date_create1 = date_create($data['employee_attendance'][0]->employee_in);
            $data['employee_in'] = date_format($date_create1, 'H:i');
            $data['employee_in_hidden'] = date_format($date_create1, 'h:i A');
        } else {
            $data['employee_in'] = '';
            $data['employee_in_hidden'] = '';
        }

        if (!empty($data['employee_attendance'][0]->employee_out)) {
            $date_create2 = date_create($data['employee_attendance'][0]->employee_out);
            $data['employee_out'] = date_format($date_create2, 'H:i');
            $data['employee_out_hidden'] = date_format($date_create2, 'h:i A');
        } else {
            $data['employee_out'] = '';
            $data['employee_out_hidden'] = '';
        }

        if (!empty($data['employee_attendance'][1]->employee_in)) {
            $date_create3 = date_create($data['employee_attendance'][1]->employee_in);
            $data['employee_in1'] = date_format($date_create3, 'H:i');
            $data['employee_in1_hidden'] = date_format($date_create3, 'h:i A');
        } else {
            $data['employee_in1'] = '';
            $data['employee_in1_hidden'] = '';
        }

        if (!empty($data['employee_attendance'][1]->employee_out)) {
            $date_create4 = date_create($data['employee_attendance'][1]->employee_out);
            $data['employee_out1'] = date_format($date_create4, 'H:i');
            $data['employee_out1_hidden'] = date_format($date_create4, 'h:i A');
        } else {
            $data['employee_out1'] = '';
            $data['employee_out1_hidden'] = '';
        }
        $data['id'] = $id;
        $data['get_date'] = $date;
        $data['js_flag'] = "employee_attendance_admin_js";
        $data['menu'] = "employee_attendance_add";
        echo json_encode($data);
    }
    public function search_employee_attendance()
    {
        $user_session = $this->session->get('id');
        if (!$user_session) {
            return redirect()->to(base_url('admin'));
        }
        $id = $this->request->getPost('employee');
        $date = date('Y-m-d');
        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin') {
            return redirect()->to('dashboard');
        }
        $data = array();
        $data['page_title'] = "Add Employee attendance";
        $data['get_employee'] = $this->Employee_Model->get_employee($id);
        $data['get_employee_attendance'] = $this->Employee_Attendance_Model->get_employee_attendance_details($id, $date);

        $data['id'] = $id;
        $data['get_date'] = $date;
        $data['js_flag'] = "employee_attendance_admin_js";
        $data['menu'] = "employee_attendance_add";
        echo json_encode($data);
    }
    public function insert_employee_attendance()
    {
        $user_session = $this->session->get('id');
        if (!$user_session) {
            return redirect()->to(base_url('admin'));
        }
        $data = '';
        $employee_in_time = $this->request->getPost("employee_in");

        $employee_out_time = $this->request->getPost("employee_out");
        $employee_in1_time = $this->request->getPost("employee_in1");
        $employee_out1_time = $this->request->getPost("employee_out1");
        $attendance_type = $this->request->getPost("attendance_type");
        $daily_work = $this->request->getPost("daily_work");
        $employee_id = $this->request->getPost("id");
        $id = explode(",", $this->request->getPost("emp_id"));
        $other_date = $this->request->getPost("other_date");
        $attendance_date = $this->request->getPost("attendance_date");
        $at_date = strtotime($attendance_date);

        $attend_date = Format_date($attendance_date);

        $emp_id = $_POST['id'];
        $get_employee_attendance_date = $this->Employee_Attendance_Model->get_employee_attendance_date($emp_id, $attend_date);
        $holiday_date1 = $this->Holiday_Model->get_exists_holiday_date_formate($attend_date);
        $holiday_date = $holiday_date1[0]['numrows'];

        $weekDay = date('w', strtotime($attendance_date));
        if ($weekDay <= 0) {
            $exist_date = date('j F Y', strtotime($attendance_date));
            $error_msg = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>This ("' . $exist_date . '") date is sunday</p></div></div></div>';
            $data = $error_msg;
            echo ($data);
            exit;
        }
        if (empty($this->request->getPost("emp_id"))) {
            //echo "add";
            if (isset($get_employee_attendance_date) && count($get_employee_attendance_date) > 0) {
                $exist_date = date('j F Y', strtotime($attendance_date));
                $error_msg = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>This ("' . $exist_date . '") date is already exist</p></div></div></div>';
                $data = $error_msg;
                echo ($data);
                exit;
            } else if (isset($holiday_date) && $holiday_date > 0) {

                $exist_date = date('j F Y', strtotime($attendance_date));
                $error_msg = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>It was a official holiday on ("' . $exist_date . '")</p></div></div></div>';
                $data = $error_msg;
                echo ($data);
                exit;
            }
        } else {

            $employee_in_arr = array();
            if (!empty($get_employee_attendance_date)) {
                foreach ($get_employee_attendance_date as $d) {
                    $employee_in_arr[] = $attend_date = Format_date($d->employee_in);
                }
            }

            if (!in_array($other_date, $employee_in_arr)) {
                if ((isset($get_employee_attendance_date) && count($get_employee_attendance_date) > 0)) {
                    $exist_date = date('j F Y', strtotime($attendance_date));
                    $error_msg = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>This ("' . $exist_date . '") date is already exist</p></div></div></div>';
                    $data = $error_msg;
                    echo ($data);
                    exit;
                } else if (isset($holiday_date) && $holiday_date > 0) {
                    $exist_date = date('j F Y', strtotime($attendance_date));
                    $error_msg = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>It was a official holiday on ("' . $exist_date . '")</p></div></div></div>';
                    $data = $error_msg;
                    echo ($data);
                    exit;
                }
            }
        }
        $get_employee_attendance_date = $this->Employee_Attendance_Model->get_employee_attendance_date($emp_id, $attend_date);

        if (isset($attendance_date) && !empty($attendance_date)) {
            $date = $attendance_date;
            if (!empty($employee_in_time)) {
                $date_create1 = date_create($attendance_date . " " . $employee_in_time);
                $employee_in = date_format($date_create1, 'Y-m-d H:i:s');
            } else {
                $employee_in = "";
            }
            if (!empty($employee_out_time)) {
                $date_create2 = date_create($attendance_date . " " . $employee_out_time);
                $employee_out = date_format($date_create2, 'Y-m-d H:i:s');
            } else {
                $employee_out = "";
            }
            if (!empty($employee_in1_time)) {
                $date_create3 = date_create($attendance_date . " " . $employee_in1_time);
                $employee_in1 = date_format($date_create3, 'Y-m-d H:i:s');
            } else {
                $employee_in1 = "";
            }
            if (!empty($employee_out1_time)) {
                $date_create4 = date_create($attendance_date . " " . $employee_out1_time);
                $employee_out1 = date_format($date_create4, 'Y-m-d H:i:s');
            } else {
                $employee_out1 = "";
            }
        }
        if (!empty($employee_out)) {
            $employee_out = $employee_out;
        } else {
            $employee_out = NULL;
        }
        if (!empty($employee_out1)) {
            $employee_out1 = $employee_out1;
        } else {
            $employee_out1 = NULL;
        }
        if ($employee_in == "" && $employee_out == "" && $employee_in1 == "" && $employee_out1 == "" && $attendance_type == "") {
            if (!empty($id)) {
                foreach ($id as $key => $value) {
                    $did = $value;
                    $delete_employee = $this->Employee_Attendance_Model->delete_employee($did);
                }
            }
        } else {

            if (isset($id[0]) && !empty($id[0])) {
                //update
                $arr = array(
                    'id' => $id[0],
                    'employee_in' => $employee_in,
                    'employee_out' => $employee_out,
                    'attendance_type' => $attendance_type,

                );
                /* 'daily_work' => $daily_work, */
                $insert_employee = $this->Employee_Attendance_Model->update_employee($arr);
                if ($insert_employee) {
                    $daily_work_list = $this->Employee_Attendance_Model->get_work_by_date($attend_date, $employee_id);
                    if (count($daily_work_list) > 0) {
                        $arr1 = array(
                            'id' => $daily_work_list[0]->id,
                            'employee_id' => $employee_id,
                            'attendance_date' => $attend_date,
                            'daily_work' => $daily_work,
                            'updated_date' => date('Y-m-d h:i:s'),
                        );
                        $insert_daily_work1 = $this->Employee_Attendance_Model->update_daily_work($arr1);
                    } elseif ($daily_work != '') {
                        $arr1 = array(
                            'employee_id' => $employee_id,
                            'attendance_date' => $attend_date,
                            'daily_work' => $daily_work,
                        );
                        $insert_daily_work1 = $this->Employee_Attendance_Model->insert_daily_work($arr1);
                    }
                    $data = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Employee attendance updated.</p></div></div></div>';
                } else {
                    $data = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Employee attendance failed to update!</p></div></div></div>';
                }
            } else {

                $this->form_validation->reset();
                $this->form_validation->setRule('employee_in', 'In', 'required');
                if ($this->validate($this->form_validation->getRules()) == false) {
                    $this->session->setFlashdata('message', $this->validator->listErrors());
                    return redirect()->to(base_url('employee/employee_attendance/' . $employee_id));
                } else {
                    //insert
                    if (!empty($employee_in)) {
                        $arr = array(
                            'employee_in' => $employee_in,
                            'employee_out' => $employee_out,
                            'employee_id' => $employee_id,
                            'attendance_type' => $attendance_type,
                        );
                        $insert_employee = $this->Employee_Attendance_Model->insert_employee($arr);
                        // $insert_employee= true;
                        if ($insert_employee) {
                            $daily_work_list = $this->Employee_Attendance_Model->get_work_by_date($attend_date, $employee_id);
                            if (count($daily_work_list) > 0) {
                                $arr1 = array(
                                    'id' => $daily_work_list[0]->id,
                                    'employee_id' => $employee_id,
                                    'attendance_date' => $attend_date,
                                    'daily_work' => $daily_work,
                                    'updated_date' => date('Y-m-d h:i:s'),
                                );
                                $insert_daily_work1 = $this->Employee_Attendance_Model->update_daily_work($arr1);
                            } elseif ($daily_work != '') {
                                $arr1 = array(
                                    'employee_id' => $employee_id,
                                    'attendance_date' => $attend_date,
                                    'daily_work' => $daily_work,
                                );
                                $insert_daily_work1 = $this->Employee_Attendance_Model->insert_daily_work($arr1);
                            }
                            $data = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Employee attendance added.</p></div></div></div>';
                        } else {
                            $data = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Employee attendance failed to add!</p></div></div></div>';
                        }
                    }
                }
            }
            if (isset($id[1]) && !empty($id[1])) {
                //update
                $arr = array(
                    'id' => $id[1],
                    'employee_in' => $employee_in1,
                    'employee_out' => $employee_out1,
                    'attendance_type' => $attendance_type,

                );
                $insert_employee = $this->Employee_Attendance_Model->update_employee($arr);
                // $insert_employee=true;
                if ($insert_employee) {
                    $daily_work_list = $this->Employee_Attendance_Model->get_work_by_date($attend_date, $employee_id);
                    if (count($daily_work_list) > 0) {
                        $arr1 = array(
                            'id' => $daily_work_list[0]->id,
                            'employee_id' => $employee_id,
                            'attendance_date' => $attend_date,
                            'daily_work' => $daily_work,
                            'updated_date' => date('Y-m-d h:i:s'),
                        );
                        $insert_daily_work1 = $this->Employee_Attendance_Model->update_daily_work($arr1);
                    } elseif ($daily_work != '') {
                        $arr1 = array(
                            'employee_id' => $employee_id,
                            'attendance_date' => $attend_date,
                            'daily_work' => $daily_work,
                        );
                        $insert_daily_work1 = $this->Employee_Attendance_Model->insert_daily_work($arr1);
                    }
                    $data = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Employee attendance updated.</p></div></div></div>';
                } else {
                    $data = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Employee attendance failed to update!</p></div></div></div>';
                }
            } else {
                if (!empty($employee_in1)) {
                    $arr = array(
                        'employee_in' => $employee_in1,
                        'employee_out' => $employee_out1,
                        'employee_id' => $employee_id,
                        'attendance_type' => $attendance_type,
                    );
                    $insert_employee = $this->Employee_Attendance_Model->insert_employee($arr);
                    // $insert_employee= true;
                    if ($insert_employee) {
                        $daily_work_list = $this->Employee_Attendance_Model->get_work_by_date($attend_date, $employee_id);
                        if (count($daily_work_list) > 0) {
                            $arr1 = array(
                                'id' => $daily_work_list[0]->id,
                                'employee_id' => $employee_id,
                                'attendance_date' => $attend_date,
                                'daily_work' => $daily_work,
                                'updated_date' => date('Y-m-d h:i:s'),
                            );
                            $insert_daily_work1 = $this->Employee_Attendance_Model->update_daily_work($arr1);
                        } elseif ($daily_work != '') {
                            $arr1 = array(
                                'employee_id' => $employee_id,
                                'attendance_date' => $attend_date,
                                'daily_work' => $daily_work,
                            );
                            $insert_daily_work1 = $this->Employee_Attendance_Model->insert_daily_work($arr1);
                        }
                        $data = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Employee attendance added.</p></div></div></div>';
                    } else {
                        $data = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Employee attendance failed to add!</p></div></div></div>';
                    }
                }
            }
        }
        echo ($data);
    }
}
