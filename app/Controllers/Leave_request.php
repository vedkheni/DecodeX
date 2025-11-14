<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Leave_request extends BaseController
{
	//designation
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
		$data = array();
		$user_session = $this->session->get('id');
		if (!$user_session) {
			return redirect()->to(base_url('admin'));
		}
		$user_role = $this->session->get('user_role');
		if ($user_role != "admin") {
			$data['paid_leave'] = $this->Leave_Request_Model->get_employee_leave_count("paid", $user_session);
			$data['sick_leave'] = $this->Leave_Request_Model->get_employee_leave_count("sick", $user_session);
		} else {
			$data['employee_id'] = $this->request->getPost('employee_id');
			$data['select_year'] = $this->request->getPost('select_year');
			$data['select_month'] = $this->request->getPost('select_month');
		}

		$id = ($this->uri->getSegment(2)) ? $this->uri->getSegment(3) : '';
		if ($user_role == 'admin') {
			$data['list_data'] = $this->Employee_Model->get_employee($id);
		} else {
			$id = (empty($id)) ? $user_session : $id;
			$data['list_data'] = $this->Leave_Request_Model->get_leave_request($id);
		}
		$data['leave_count'] = "";
		if ($user_role != "admin") {
			$arr = array('employee_id' => $user_session);
			$data['leave_count'] = $this->allfunction->employee_leave_count($arr);
		}
		$data['all_employees'] = $this->Employee_Model->get_employee_list(1);
		$data['get_employee_list'] = $this->Employee_Model->get_employee_list(1);
		$data['page_title'] = "Leave Request";
		$data['js_flag'] = "leave_request_js";
		$data['menu'] = "leave_request";
		$this->lib->view('administrator/leave_request/list_leave_request', $data);
	}
	public function employee_pagination()
	{
		//Designation_Model
		$status = $employee_id = $select_year = $select_month = "";
		if ($this->uri->getSegment(3) && $this->uri->getSegment(4)) {
			$status = $this->uri->getSegment(3);
			$employee_id = $this->uri->getSegment(4);
			$select_leave = '';
		} else {
			$status = $this->uri->getSegment(3);
			$employee_id = $this->request->getPost('employee_id');
			$select_year = $this->request->getPost('select_year');
			$select_month = $this->request->getPost('select_month');
			$select_leave = $this->request->getPost('select_leave');
		}
		// else{
		// 	$employee_id=$this->request->getPost('employee_id');
		// 	$select_year=$this->request->getPost('select_year');
		// 	$select_month=$this->request->getPost('select_month');
		// }
		$user_role = $this->session->get('user_role');
		if($user_role != 'admin'){
			if($status == 'pending'){
				$columns = array(0 => '#',1 => 'id', 2 => 'leave_date', 3 => 'leave_status', 4 => 'action');
			}else{
				$columns = array(1 => 'id', 2 => 'leave_date', 3 => 'leave_status', 4 => 'action');
			}
		}else{
			$columns = array(
				0 => '#',
				1 => 'id',
				2 => 'fname',
				3 => 'leave_date',
				4 => 'comment',
				5 => 'leave_status',
				// 5 =>'status',
				6 => 'action',
			);
		}
		$limit = $this->request->getPost('length');
		$start = $this->request->getPost('start');
		$order = $columns[$this->request->getPost('order')[0]['column']];
		$dir = $this->request->getPost('order')[0]['dir'];

		$totalData = $this->Leave_Request_Model->allposts_count($status, $employee_id, $select_year, $select_month, $select_leave);
		$totalFiltered = $totalData;

		if (empty($this->request->getPost('search')['value'])) {
			$posts = $this->Leave_Request_Model->allposts($status, $employee_id, $select_year, $select_month, $select_leave, $limit, $start, $order, $dir);
		} else {
			$search = $this->request->getPost('search')['value'];

			$posts =  $this->Leave_Request_Model->posts_search($status, $employee_id, $select_year, $select_month, $select_leave, $limit, $start, $search, $order, $dir);

			$totalFiltered = $this->Leave_Request_Model->posts_search_count($status, $employee_id, $select_year, $select_month, $select_leave, $search);
		}

		$data = array();
		if (!empty($posts)) {
			$user_role = $this->session->get('user_role');
			$i = 1;
			foreach ($posts as $post) {
				if ($user_role == "admin" || $post->status  == 'pending') {
					$nestedData['#'] = '<input type="checkbox" class="delete_leave" value="' . $post->id . '">';
				}
				$nestedData['id'] = "<span>" . $i . "</span>";
				if ($user_role == "admin") {
					$nestedData['fname'] = $post->fname . " " . $post->lname . ' - ' . date("F Y", strtotime($post->leave_date));
				} else {
					// $nestedData['fname'] = $post->fname ." ".$post->lname;
				}
				$nestedData['leave_date'] = dateFormat($post->leave_date);
				$nestedData['comment'] = $post->comment;
				$leaveStatus = empty($post->leave_status)?'General':$post->leave_status;
				$nestedData['leave_status'] = "<span class='" . $leaveStatus . "'>" . ucwords($leaveStatus) . " Leave </span>";

				if ($user_role == "admin") {
					/* <a data-id="'.$post->id.'" class="btn btn-deactive waves-effect waves-light  status-update" data-status="Approved">Approve</a> <a data-id="'.$post->id.'" class="btn btn-active waves-effect waves-light  status-update" data-status="rejected">Reject</a> */
					if ($post->status == "approved" || $post->status == "rejected") {
						$nestedData['action'] = '<button class="btn btn-outline-secondary edit_leave" data-id="' . $post->id . '" >Edit</button><button data-id="' . $post->id . '" class="btn btn-danger m-l-5 delete-employee">Delete</button>';
						// $nestedData['action'] ='<a href="'.base_url('leave_request/add').'/'.$post->id.'" class="btn btn-danger waves-effect waves-light edit_leave" data-id="'.$post->id.'" >Edit</a><a data-id="'.$post->id.'" class="btn btn-active waves-effect waves-light  delete-employee">Delete</a>';
						/* if($post->status == "approved"){
							$nestedData['status'] = '<span class="text-success">'.ucwords($post->status).'</span>';
						}else{
							$nestedData['status'] = '<span class="text-danger">'.ucwords($post->status).'</span>';
						} */
					} else {
						$nestedData['action'] = '<button class="' . ucwords($post->status) . ' btn btn-outline-secondary edit_leave" data-id="' . $post->id . '" >Edit</button><button data-id="' . $post->id . '" class="btn btn-danger m-l-5 delete-employee">Delete</button>';
						// $nestedData['action'] ='<a href="'.base_url('leave_request/add').'/'.$post->id.'" class="btn btn-danger waves-effect waves-light edit_leave" data-id="'.$post->id.'" >Edit</a><a data-id="'.$post->id.'" class="btn btn-active waves-effect waves-light  delete-employee">Delete</a>';
						$nestedData['status'] = '<button data-id="' . $post->id . '" class="btn btn-outline-success status-update" data-status="approved">Approve</button> <button data-id="' . $post->id . '" class="btn btn-outline-danger status-update" data-status="rejected">Reject</button>';
					}
				} else {
					/* if($post->status == "approved"){
						$nestedData['status'] = '<span class="text-success">'.ucwords($post->status).'</span>';
					}else{
						$nestedData['status'] = '<span class="text-danger">'.ucwords($post->status).'</span>';
					} */
					if ($status == "approved" || $status == "rejected") {
						$nestedData['action'] = '';
					} else {
						/*edit_leave*/
						// $nestedData['action'] ='<button class="btn btn-outline-secondary edit_leave" data-id="'.$post->id.'" >Edit</button><button data-id="'.$post->id.'" class="btn btn-danger m-l-5 delete-employee">Delete</button>';
						$nestedData['action'] = '<button class="btn btn-outline-secondary edit_leave" data-id="' . $post->id . '">Edit</button><button data-id="' . $post->id . '" class="btn btn-danger m-l-5 delete-employee">Delete</button>';
						// $nestedData['action'] ='<a href="'.base_url('leave_request/add').'/'.$post->id.'" class="btn btn-outline-secondary" >Edit</a><button data-id="'.$post->id.'" class="btn btn-danger m-l-5 delete-employee">Delete</button>';
					}
				}
				$nestedData['action'] .= '<button class="btn btn-outline-secondary m-l-5 viewLeaveReason" onclick="viewLeaveReason(' . $post->id . ')">Reason</button>';
				$i++;
				$data[] = $nestedData;
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
	public function add()
	{
		$user_session = $this->session->get('id');
		$user_role = $this->session->get('user_role');
		if (!$user_session) {
			return redirect()->to(base_url('admin'));
		}



		$data = array();
		if ($this->uri->getSegment(3)) {

			$data['page_title'] = "Edit Leave Request";
			$id = $this->uri->getSegment(3);
			if ($user_role == 'admin') {
				$data['list_data'] = $this->Employee_Model->get_employee($id);
			} else {
				$data['list_data'] = $this->Leave_Request_Model->get_leave_request($id);
			}
		} else {
			$data['page_title'] = "Add Leave Request";
			$data['list_data'] = "";
		}
		$data['leave_count'] = "";
		if ($user_role != "admin") {
			$arr = array('employee_id' => $user_session);
			$data['leave_count'] = $this->allfunction->employee_leave_count($arr);
		}


		$data['all_employees'] = $this->Employee_Model->get_employee_list(1);
		$data['js_flag'] = "leave_request_js";
		$data['menu'] = "leave_request_add";
		$this->lib->view('administrator/leave_request/add_leave_request', $data);
	}
	public function get_leave_detail()
	{
		$user_session = $this->session->get('id');
		$user_role = $this->session->get('user_role');
		if (!$user_session) {
			return redirect()->to(base_url('admin'));
		}

		$data = array();
		if ($this->request->getPost("id")) {

			$data['page_title'] = "Edit Leave Request";
			$id = $this->request->getPost("id");
			$data['list_data'] = $this->Leave_Request_Model->get_leave_request($id);
		} else {
			$data['page_title'] = "Add Leave Request";
			$data['list_data'] = "";
		}
		$data['leave_count'] = "";
		if ($user_role != "admin") {
			$arr = array('employee_id' => $user_session);
			$data['leave_count'] = $this->allfunction->employee_leave_count($arr);
		}


		$data['all_employees'] = $this->Employee_Model->get_employee_list(1);
		$data['js_flag'] = "leave_request_js";
		$data['menu'] = "leave_request_add";
		echo json_encode($data);
		// $this->lib->view('administrator/leave_request/add_leave_request',$data);
	}
	public function getMonthStr($offset)
	{
		return date("F", strtotime("$offset months"));
	}
	public function leave_count()
	{
		$id = $this->request->getPost("employee_id");
		$data = array();
		$data['employee_id'] = $id;
		$count = $this->allfunction->employee_leave_count($data);
		echo json_encode($count);
	}
	public function delete_employee()
	{
		$user_role = $this->session->get('user_role');
		/*if($user_role != 'admin'){
			return redirect()->to('dashboard');	
		}*/
		$id = $this->request->getPost("id");
		$delete_employee = $this->Leave_Request_Model->delete_employee($id);
		if ($delete_employee) {
			$data['error'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Leave request deleted</p></div></div></div>';
		} else {
			$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Leave request failed delete</p></div></div></div>';
		}
		echo json_encode($data);
	}
	public function update_status()
	{


		$id_array = $this->request->getPost("id");
		$status_update = $this->request->getPost("status_update");
		foreach ($id_array as $id) {
			$arr = array(
				'id' => $id,
				'status' => strtolower($status_update),
			);
			$leave_status_update = $this->Leave_Request_Model->update_employee($arr);
		}

		if ($leave_status_update) {
			$data['error'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Leave ' . $status_update . '</p></div></div></div>';
		} else {
			$status_update = ($status_update == 'Approved')?'approve':'reject';
			$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Leave failed to ' . $status_update . '</p></div></div></div>';
		}
		echo json_encode($data);
	}
	function isWeekend($date)
	{
		if ((date('N', strtotime($date)) >= 7) || (date('N', strtotime($date)) >= 6))
			return true;
	}
	public function insert_data()
	{
		$leave_date = $this->request->getPost("leave_date");
		$all_date1 = explode(' , ', $leave_date);
		$all_date = array();
		for ($i = 0; $i < count($all_date1); $i++) {
			array_push($all_date, Format_date($all_date1[$i]));
		}
		$type = $this->request->getPost("type");
		$user_role = $this->session->get('user_role');

		$id = $this->request->getPost("e_id");
		$e_id = $this->request->getPost("e_id");
		if ($user_role == "admin") {
			$emp_id = $this->request->getPost("employee_select");
		} else {
			$emp_id = $this->session->get('id');
		}
		$user_session = $this->session->get('id');
		$employee_id = $this->request->getPost("employee_id");
		$leave_date = $this->request->getPost("leave_date");
		$old_leave_date = $this->request->getPost("old_leave_date");
		$leave_status = $this->request->getPost("leave_status");
		$leave_commet = $this->request->getPost("leave_commet");
		$add_comment = $this->request->getPost("add_comment");

		$status = $this->request->getPost("status");
		$employee_select = $this->request->getPost("employee_select");
		//$get_employee_attendance_date= $this->Leave_Request_Model->get_employee_attendance_date($emp_id,$leave_date);
		$get_employee_attendance_date = $this->Leave_Request_Model->get_employee_attendance_date_multiple($emp_id, implode(' , ', $all_date));
		$holiday_date_count = $this->Holiday_Model->get_exists_holiday_date_leave(implode(' , ', $all_date));
		$holiday_date = $holiday_date_count[0]['numrows'];

		$get_exists_holiday_date_row = $this->Holiday_Model->get_exists_holiday_date_row(implode(' , ', $all_date));

		$date = strtotime("+7 day");

		$oneweek_date = date('Y-m-d', $date);
		$s1 = strtotime($oneweek_date);

		$sunday_err = "";
		foreach ($all_date as $sunday_date) {
			$sunday = $this->isWeekend($sunday_date);
			if ($sunday == 1) {
				$sunday_err .= " " . date('j F Y', strtotime($sunday_date)) . " ";
			}
		}
		if (!empty($sunday_err)) {
			$exist_date = date('j F Y', strtotime($leave_date));
			$error_msg = "It was a official holiday on (" . $sunday_err . ")";
			if (isset($type) && !empty($type) && $type == 'ajax') {
				$data['error_code'] = 1;
				$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $error_msg . '</p></div></div></div>';
				echo json_encode($data);
				exit();
			} else {
				$this->session->setFlashdata('message', $error_msg);
				if (!empty($e_id)) {
					return redirect()->to(base_url('leave_request/add' . $emp_id));
				} else {
					return redirect()->to(base_url('leave_request/add'));
				}
			}
		}


		if (!empty($e_id)) {

			$employee_in_arr = array();
			if (!empty($get_employee_attendance_date)) {
				foreach ($get_employee_attendance_date as $d) {
					if (in_array($d->leave_date, $all_date) &&  $e_id == $d->id) {
					} else {
						$employee_in_arr[] = Format_date($d->leave_date);
					}
				}
			}

			if (isset($holiday_date) && $holiday_date > 0) {
				$holiday_date_err = "";
				foreach ($get_exists_holiday_date_row as $holiday_list) {
					$exist_date = date('j F Y', strtotime($holiday_list->holiday_date));
					$holiday_date_err .= " " . date('j F Y', strtotime($exist_date)) . " ";
				}
				if (!empty($holiday_date_err)) {
					$error_msg = "It was a official holiday on (" . $holiday_date_err . ")";
					if (isset($type) && !empty($type) && $type == 'ajax') {
						$data['error_code'] = 1;
						$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $error_msg . '</p></div></div></div>';
						echo json_encode($data);
						exit();
					} else {
						$this->session->setFlashdata('message', $error_msg);
						return redirect()->to(base_url('leave_request/add/' . $id));
					}
				}
			}

			if (Format_date($old_leave_date) != Format_date($leave_date)) {
				if ((!empty($employee_in_arr) && count($employee_in_arr) > 0)) {
					$already_exist_date_err = "";
					foreach ($employee_in_arr as $already_exist_date) {
						$already_exist_date_err .= " " . date('j F Y', strtotime($already_exist_date)) . " ";
					}
					if (!empty($already_exist_date_err)) {
						$error_msg = "This (" . $already_exist_date_err . ") date is already exist";
						if (isset($type) && !empty($type) && $type == 'ajax') {
							$data['error_code'] = 1;
							$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $error_msg . '</p></div></div></div>';
							echo json_encode($data);
							exit();
						} else {
							$this->session->setFlashdata('message', $error_msg);
							return redirect()->to(base_url('leave_request/add/' . $id));
						}
					}
				}
			}
		} else {

			//echo "add";
			if (isset($get_employee_attendance_date) && count($get_employee_attendance_date) > 0) {
				$already_exist_date_err = "";
				foreach ($get_employee_attendance_date as $already_exist_date) {
					$already_exist_date_err .= " " . date('j F Y', strtotime($already_exist_date->leave_date)) . " ";
				}
				if (!empty($already_exist_date_err)) {
					$error_msg = "This (" . $already_exist_date_err . ") date is already exist";
					if (isset($type) && !empty($type) && $type == 'ajax') {
						$data['error_code'] = 1;
						$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $error_msg . '</p></div></div></div>';
						echo json_encode($data);
						exit();
					} else {
						$this->session->setFlashdata('message1', $error_msg);
						return redirect()->to(base_url('leave_request/add/' . $id));
						//echo "ifrtryty";
					}
				}
			} else if (isset($holiday_date) && $holiday_date > 0) {
				$holiday_date_err = "";
				foreach ($get_exists_holiday_date_row as $holiday_list) {
					$exist_date = date('j F Y', strtotime($holiday_list->holiday_date));
					$holiday_date_err .= " " . date('j F Y', strtotime($exist_date)) . " ";
				}
				$error_msg = "It was a official holiday on (" . $holiday_date_err . ")";
				if (isset($type) && !empty($type) && $type == 'ajax') {
					$data['error_code'] = 1;
					$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $error_msg . '</p></div></div></div>';
					echo json_encode($data);
					exit();
				} else {
					$this->session->setFlashdata('message1', $error_msg);
					return redirect()->to(base_url('leave_request/add'));
				}
			}
		}
		if ($user_role != "admin") {
			foreach ($all_date as $week_later_date) {
				$s2 = strtotime($week_later_date);
				if ($s1 > $s2) {
					$exist_date = date('j F Y', strtotime($leave_date));
					$error_msg = "Please select a week later date";
					if (isset($type) && !empty($type) && $type == 'ajax') {
						$data['error_code'] = 1;
						$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $error_msg . '</p></div></div></div>';
						echo json_encode($data);
						exit();
					} else {
						$this->session->setFlashdata('message1', $error_msg);
						return redirect()->to(base_url('leave_request/add'));
					}
				}
			}
		}
		$this->form_validation->reset();
		$this->form_validation->setRule('leave_date', 'Leave Date', 'required');
		$this->form_validation->setRule('leave_status', 'Leave Status', 'required');
		if($add_comment == 'true'){
			$this->form_validation->setRule('leave_commet', 'Leave Commet', 'required');
		}

		if ($this->form_validation->withRequest($this->request)->run() == false) {
			if (isset($type) && !empty($type) && $type == 'ajax') {
				$data['error_code'] = 1;
				$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $this->form_validation->listErrors() . '</p></div></div></div>';
				echo json_encode($data);
				exit();
			} else {
				$this->session->setFlashdata('message', $this->form_validation->listErrors());
				return redirect()->to(base_url('leave_request/add'));
			}
		} else {
			$arr1 = array('employee_id' => $emp_id);
			$leave_count = $this->allfunction->employee_leave_count($arr1);
			$remaing_sick_leave = $leave_count['remaing_sick_leave'];
			$this_month_paid_leave = $leave_count['this_month_paid_leave'];
			$sick_leave = $leave_count['sick_leave'];
			$paid_leave = $leave_count['paid_leave'];
			if (!isset($id) || empty($id)) {
				$i = 1;
				$html = '';
				foreach ($all_date as $insert_date) {

					if ($leave_status == "paid") {
						if ($i <= $this_month_paid_leave) {
							//echo "if";
							$leave_status1 = "paid";
						} else {
							//echo "else";
							$leave_status1 = "none";
						}
					}
					if ($leave_status == "sick" || $leave_status == "Sick") {
						if ($i <= $remaing_sick_leave) {
							// $leave_status1 = $leave_status;
							$leave_status1 = "Sick";
						} else {
							$leave_status1 = $leave_status;
						}
					}else{
						$leave_status1 = $leave_status;
					}
					
					/* if ($leave_status == "none") {
						$leave_status1 = "none";
					} */
					$insert_date = Format_date($insert_date);
					$employee_attendance = $this->Employee_Attendance_Model->get_employee_attendance_details($emp_id, $insert_date);
					if (count($employee_attendance) == 0) {
						if ($user_role == "admin") {

							$arr = array(
								'employee_id' => $emp_id,
								'leave_date' => $insert_date,
								'comment' => $leave_commet,
								'status' => $status,
								'leave_status' => $leave_status1,
								'created_datetime' => date('Y-m-d h:i:s')
							);
							$insert_employee = $this->Leave_Request_Model->insert_employee($arr);
						} else {
							$arr = array(
								'employee_id' => $emp_id,
								'leave_date' => $insert_date,
								'comment' => $leave_commet,
								'status' => "pending",
								'leave_status' => $leave_status1,
								'created_datetime' => date('Y-m-d h:i:s')
							);
							$insert_employee = $this->Leave_Request_Model->insert_employee($arr);
						}
					} else {
						$data['error_code'] = 1;
						$html .= '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Present entry already exists on this date (' . $insert_date . ')</p></div></div></div>';
					}
					//print_r($arr);

					//die;

					$i++;
				}
				if ($html != '') {
					$data['error_code'] = 1;
					$data['error'] = $html;
					echo json_encode($data);
					exit();
				}
				//die;
				//die;
				if ($insert_employee) {
					if (isset($type) && !empty($type) && $type == 'ajax') {
						$data['error_code'] = 0;
						$data['error'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Leave added.</p></div></div></div>';
					} else {
						$data['error_code'] = 1;
						$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Leave failed to add!</p></div></div></div>';
						// return redirect()->to(base_url('leave_request'));
					}
					echo json_encode($data);
					exit();
				}
			} else {
				$leave_date = Format_date($leave_date);
				$employee_attendance = $this->Employee_Attendance_Model->get_employee_attendance_details($emp_id, $leave_date);
				if (count($employee_attendance) == 0) {
					if ($user_role == "admin") {
						$arr = array(
							'id' => $id,
							'employee_id' => $emp_id,
							'leave_date' => $leave_date,
							'comment' => $leave_commet,
							'leave_status' => $leave_status,
							'status' => $status,
						);
						//'updated_datetime' => date('Y-m-d h:i:s')
					} else {
						$arr = array(
							'id' => $id,
							'employee_id' => $emp_id,
							'leave_date' => $leave_date,
							'comment' => $leave_commet,
							'leave_status' => $leave_status,
							'updated_datetime' => date('Y-m-d h:i:s')
						);
					}

					$insert_employee = $this->Leave_Request_Model->update_employee($arr);
					if ($insert_employee) {
						if (isset($type) && !empty($type) && $type == 'ajax') {
							$data['error_code'] = 0;
							$data['error'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Leave updated.</p></div></div></div>';
						} else {
							$data['error_code'] = 1;
							$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Leave failed to update!</p></div></div></div>';
							// return redirect()->to(base_url('leave_request'));
						}
						echo json_encode($data);
						exit();
					}
				} else {
					$data['error_code'] = 1;
					$data['error'] =  '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $leave_date . '</p></div></div></div>';
					echo json_encode($data);
					exit();
				}
			}
		}
	}

	public function delete_leave()
	{

		$data = array();
		if ($this->request->getPost("id")) {
			$id = $this->request->getPost("id");
			for ($i = 0; $i < count($id); $i++) {
				$delete_employee = $this->Leave_Request_Model->delete_employee($id[$i]);
				if ($delete_employee) {
					$data['error'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Leave request deleted</p></div></div></div>';
				} else {
					$data['error'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Leave request failed to delete</p></div></div></div>';
				}
			}
		}
		echo json_encode($data);
	}

	public function view_leave_reason(){
		$data = array();
		$id = $this->request->getPost("id");
		$data['leave_detail'] = $this->Leave_Request_Model->get_leave_request($id);

		echo json_encode($data);
	}
}
