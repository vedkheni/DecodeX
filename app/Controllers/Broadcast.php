<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Broadcast extends BaseController
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
		$data = array();
		$user_session = $this->session->get('id');
		$user_role = $this->session->get('user_role');
		if (!$user_session) {
			return redirect()->to(base_url('login'));
		}

		$data['designation'] = $this->Designation_Model->get_designation();
		$data['menu'] = "broadcast_message";
		$data['broadcast_list'] = $this->Broadcast_Model->allBroadcastMassage();

		$data['page_title'] = "Broadcast Message";
		$user_session = $this->session->get('id');
		$admin_detail = $this->Administrator_Model->admin_profile($user_session);
		$data['profile'] = $admin_detail;
		$data['js_flag'] = "broadcast_message_js";
		$this->lib->view('administrator/broadcast/list_broadcast', $data);
	}

	function getMessageList()
	{

		$user_role = $this->session->get('user_role');
		$columns = array(
			0 => 'id',
			1 => 'title',
			2 => 'message',
			3 => 'expiry_date',
		);

		$limit = $this->request->getPost('length');
		$start = $this->request->getPost('start');
		$order = $columns[$this->request->getPost('order')[0]['column']];
		$dir = $this->request->getPost('order')[0]['dir'];

		$totalData = $this->Broadcast_Model->allposts_count();

		$totalFiltered = $totalData;

		if (empty($this->request->getPost('search')['value'])) {
			$posts = $this->Broadcast_Model->allposts($limit, $start, $order, $dir);
		} else {
			$search = $this->request->getPost('search')['value'];

			$posts =  $this->Broadcast_Model->posts_search($limit, $start, $search, $order, $dir);

			$totalFiltered = $this->Broadcast_Model->posts_search_count($search);
		}

		$data = array();
		if (!empty($posts)) {
			$i = 1;
			foreach ($posts as $post) {
				$nestedData['#'] = "<span>" . $i . "</span>";
				$nestedData['title'] = $post->title;
				$nestedData['event_date'] = dateFormat($post->event_date);
				$nestedData['message'] = '<button type="button" class="viewMessage btn sec-btn sec-btn-outline" onClick="viewMessage($(this))" data-message="'.$post->message.'">View Message</button>';
				$nestedData['expiry_date'] = dateFormat($post->expiry_date);
				$nestedData['action'] = '<button type="button" data-id="' . $post->id . '" class="btn sec-btn sec-btn-outline editBroadcastMessage" title="Edit">Edit</button><button type="button" data-id="' . $post->id . '" class="btn btn-outline-danger ml-2 deleteBroadcastMessage" title="Delete">Delete</button><button type="button" data-id="' . $post->id . '" class="btn sec-btn sec-btn-outline ml-2 broadcastSendMail" title="Send Mail">Send Mail</button>';
				$data[] = $nestedData;
				$i++;
				/*  <button type="button" data-id="'.$post->id.'" class="btn btn-outline-danger ml-2 delete_mail_content" title="Delete">Delete</button> */
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

	// public function agree_team(){
	// 	$agree=$this->request->getPost('agree');
	// 	$emp_id=$this->request->getPost('emp_id');
	// 	$this->db->table('employee')->where('id',$emp_id)->update(array('agree_terms_conditions' => $agree));
	// }

	// public function add(){
	// 	$data['menu']="broadcast_message";
	// 	$data['page_title']="Add Broadcast Message";
	// 	$data['js_flag']="broadcast_message_js";
	// 	$this->lib->view('administrator/broadcast/add_broadcast',$data);
	// }

	public function getBroadcastMessage()
	{
		$data = array();
		$id = $this->request->getPost('id');
		$data['broadcastMessage'] = $this->Broadcast_Model->getBroadcastMessage($id);
		if(!empty($data['broadcastMessage'])){
			$attachment_url = base_url() . 'assets/upload/broadcast_attachment/';
			if (isset($data['broadcastMessage'][0]->attachment) && !empty($data['broadcastMessage'][0]->attachment)) {
				$image1 = $_SERVER['DOCUMENT_ROOT'] . "/assets/upload/broadcast_attachment/" . $data['broadcastMessage'][0]->attachment;
				if (file_exists($image1)) {
					$image = base_url() . "assets/signature512x512/" . $data['broadcastMessage'][0]->attachment;
					$image_1 = $attachment_url . $data['broadcastMessage'][0]->attachment;
					$data['broadcastMessage']['image'] = $image_1;
				} else {
					$data['broadcastMessage']['image'] = '';
				}
			} else {
				$data['broadcastMessage']['image'] = '';
			}
		}
		echo json_encode($data);
	}

	public function broadcastSendMail()
	{
		$data = array();
		$id = $this->request->getPost('id');
		$broadcastMessage = $this->Broadcast_Model->getBroadcastMessage($id);
		if(!empty($broadcastMessage)){
			$empDetail = $this->Employee_Model->get_employee_list(1);
			$mail = array();
			foreach($empDetail as $emp_detail){
				if($emp_detail->personal_email){
					array_push($mail,$emp_detail->personal_email);	
				}
			}
			$mail = array('sagargeek435@gmail.com','ajaygeek435@gmail.com','vivekgeek435@gmail.com','karangeek435@gmail.com');
			$data1 = array();
			$data1['mail_type'] = 'broadcast_mail';
			$data1['subject'] = 'Announcment For '.$broadcastMessage[0]->title;
			$data1['title'] = 'Announcment For '.$broadcastMessage[0]->title;
			$data1['greeting'] = 'Dear';
			$data1['img_name'] = 'announcment.png';
			$data1['message'] = $broadcastMessage[0]->message.'<a href="'. base_url().'assets/upload/broadcast_attachment/'.$broadcastMessage[0]->attachment.'" target="_bleak" data-tooltip="View Attachments" class="attach-link"><i class="fas fa-file mr-1"></i> View Attachements</a>';
			$data1['name'] = 'Personnel';
			$data1['to'] = implode(',',$mail);
			$data1['base_url'] = base_url();
			$mail_send_code = $this->mailfunction->mail_send($data1);
			$mail_send_code = true;
			if(!$mail_send_code){
				$data['error_code'] = 1;
				$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Mail not sent.</p></div></div></div>';
				echo json_encode($data);exit;
			}
			$data['error_code'] = 0;
			$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Mail sent.</p></div></div></div>';

		}else{
			$data['error_code'] = 1;
			$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Broadcast message not found.</p></div></div></div>';
		}
		echo json_encode($data);
	}

	public function deleteBroadcastMessage()
	{
		$data = array();
		$id = $this->request->getPost('id');
		$delete_mail_content = $this->Broadcast_Model->deleteBroadcastMessage($id);
		if ($delete_mail_content) {
			$data['error_code'] = 0;
			$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Broadcast message deleted.</p></div></div></div>';
		} else {
			$data['error_code'] = 1;
			$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Broadcast message field to delete!</p></div></div></div>';
		}
		echo json_encode($data);
	}

	public function addMessage()
	{
		$data = array();
		$title = $this->request->getPost('title');
		$url = $_SERVER['DOCUMENT_ROOT'] . '/assets/upload/broadcast_attachment';
		$broadcastMessage = $this->request->getPost('broadcastMessage');
		$expiryDate = Format_date($this->request->getPost('expiryDate'));
		$eventDate = Format_date($this->request->getPost('eventDate'));
		$id = $this->request->getPost('id');
		$this->form_validation->reset();
		$this->form_validation->setRule('title', 'Broadcast Title', 'required');
		$this->form_validation->setRule('broadcastMessage', 'Broadcast Message', 'required');
		$this->form_validation->setRule('expiryDate', 'Message Expiry Date', 'required');
		$this->form_validation->setRule('eventDate', 'Message Event Date', 'required');
		if ($this->validate($this->form_validation->getRules()) == false) {
			$data['error_code'] = 1;
			$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">' . $this->validator->listErrors() . '</p></div></div></div>';
			echo json_encode($data);
			exit;
		} else {
			if (!empty($_FILES['attachment']['name'])) {
				$attachment = $this->request->getFile('attachment');
				$attachment_name = date('dmYhis') . $attachment->getName();
				$this->form_validation->reset();
				$this->form_validation->setRule('attachment', 'Attachment', "uploaded[attachment]|max_size[attachment,8192]|mime_in[attachment,image/jpg,image/jpeg,image/png,application/pdf]");
				if ($this->validate($this->form_validation->getRules()) == false) {
					$data['error_code'] = 1;
					$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">' . $this->validator->listErrors() . '</p></div></div></div>';
					echo json_encode($data);
					exit;
				} else {
					if ($attachment->move($url, $attachment_name)) {
						$uploadData = $attachment;
						$attachmentName = $uploadData->getName();
					} else {
						$data['error_code'] = 1;
						$data['message'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">Attachment upload field!</p></div></div></div>';
						echo json_encode($data);
						exit;
					}
				}
			} else {
				$attachmentName = $this->request->getPost('upload_attachment');
			}

			if ($id) {
				// echo "update";
				$arr = array(
					'id' => $id,
					'title' => $title,
					'attachment' => $attachmentName,
					'message' => $broadcastMessage,
					'expiry_date' => $expiryDate,
					'event_date' => $eventDate,
					'updated_date' => date('Y-m-d h:i:s'),
				);
				$updateMessage = $this->Broadcast_Model->updateMessage($arr);
				if ($updateMessage) {
					$data['error_code'] = 0;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Broadcast message updated.</p></div></div></div>';
				} else {
					$data['error_code'] = 1;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Broadcast message field to update!</p></div></div></div>';
				}
			} else {
				// echo "insert";
				$arr = array(
					'title' => $title,
					'attachment' => $attachmentName,
					'message' => $broadcastMessage,
					'expiry_date' => $expiryDate,
					'event_date' => $eventDate,
				);
				$insertMessage = $this->Broadcast_Model->insertMessage($arr);
				if ($insertMessage) {
					$data['error_code'] = 0;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Broadcast message added.</p></div></div></div>';
				} else {
					$data['error_code'] = 1;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Broadcast message field to add!</p></div></div></div>';
				}
			}
		}
		echo json_encode($data);
	}

	public function allBroadcastMassage(){
		$data = array();
		$data['broadcastMessage'] = $this->Broadcast_Model->allBroadcastMassage();
		if(!empty($data['broadcastMessage'])){
			$attachment_url = base_url() . 'assets/upload/broadcast_attachment/';
			if (isset($data['broadcastMessage'][0]->attachment) && !empty($data['broadcastMessage'][0]->attachment)) {
				$image1 = $_SERVER['DOCUMENT_ROOT'] . "/assets/upload/broadcast_attachment/" . $data['broadcastMessage'][0]->attachment;
				if (file_exists($image1)) {
					$image_1 = $attachment_url . $data['broadcastMessage'][0]->attachment;
					$data['broadcastMessage']['image'] = $image_1;
				} else {
					$data['broadcastMessage']['image'] = '';
				}
			} else {
				$data['broadcastMessage']['image'] = '';
			}
		}
			echo json_encode($data);
	}
}

