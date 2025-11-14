<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Mail_content extends BaseController {

	public function __construct()
    {
        parent::__construct();
        $user_session = $this->session->get('id');
        if (!$user_session)
        {
            return redirect()->to(base_url());
        }
    }

	public function index()
	{
		$data=array();
		$user_session=$this->session->get('id');
		$user_role=$this->session->get('user_role');
		if(!$user_session){
			return redirect()->to(base_url('login'));	
		}

		$data['designation']= $this->Designation_Model->get_designation();
		$data['menu']="mail_content";		
		$data['content_list']=$this->Mail_Content_Model->all_mail_content();

        $data['page_title']="Mail content";
        $user_session=$this->session->get('id');
        $admin_detail=$this->Administrator_Model->admin_profile($user_session);
        $data['profile']=$admin_detail;
        $data['js_flag']="mail_content_js";
        $this->lib->view('administrator/mail_content/list_mail_content',$data);

	}
	function get_content_list(){

		$user_role=$this->session->get('user_role');
		$columns = array( 
                            0 => 'id',
                            1 => 'name',
                            2 => 'slug',
                        );
		
		$limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];
  
        $totalData = $this->Mail_Content_Model->allposts_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->request->getPost('search')['value']))
        {            
            $posts = $this->Mail_Content_Model->allposts($limit,$start,$order,$dir);
        }
        else {
            $search = $this->request->getPost('search')['value'] ; 

            $posts =  $this->Mail_Content_Model->posts_search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Mail_Content_Model->posts_search_count($search);
        }
		
          $data = array();
        if(!empty($posts))
        {
		 $i=1;
		 foreach ($posts as $post)
            {
                $nestedData['#'] = "<span>".$i ."</span>";
				$nestedData['name'] = $post->name;
				$nestedData['slug'] = $post->slug;
				$nestedData['action']='<button type="button" data-id="'.$post->id.'" class="btn sec-btn sec-btn sec-btn-outline edit_mail_content" title="Edit">Edit</button><button type="button" data-id="'.$post->id.'" class="btn btn-outline-danger ml-2 delete_mail_content" title="Delete">Delete</button>';
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

	public function agree_team(){
		$agree=$this->request->getPost('agree');
		$emp_id=$this->request->getPost('emp_id');
		$this->db->table('employee')->where('id',$emp_id)->update(array('agree_terms_conditions' => $agree));
	}
	public function add(){
		$data['menu']="mail_content";
		$data['page_title']="Add Mail content";
		$data['js_flag']="mail_content_js";
		$this->lib->view('administrator/mail_content/add_mail_content',$data);
	}
	
	public function get_mail_content(){
		$data = array();
		$id=$this->request->getPost('id');
		$data['mail_content'] = $this->Mail_Content_Model->get_mail_content($id);
		echo json_encode($data);
	}
	public function delete_mail_content(){
		$data = array();
		$id=$this->request->getPost('id');
		$delete_mail_content = $this->Mail_Content_Model->delete_mail_content($id);
		if($delete_mail_content){
			$data['error_code'] = 0;
			$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Mail content deleted.</p></div></div></div>';
		}else{
			$data['error_code'] = 1;
			$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Mail content field to delete!</p></div></div></div>';
		}
		echo json_encode($data);
	}
	public function update_content()
	{
		$data = array();
		$name=$this->request->getPost('name');
		$mail_content=$this->request->getPost('mail_content');
		$mail_slug=$this->request->getPost('mail_slug');
		$id=$this->request->getPost('id');
		$slug=$this->request->getPost('slug');
		
		$this->form_validation->reset();
		$this->form_validation->setRule('name', 'Mail Name', 'required');
		if($slug != $mail_slug){
			$this->form_validation->setRule('mail_slug', 'Mail Slug', 'required|is_unique[mail_content.slug]');
		}else{
			$this->form_validation->setRule('mail_slug', 'Mail Slug', 'required');
		}
		$this->form_validation->setRule('mail_content', 'Mail content', 'required');

		if($this->form_validation->withRequest($this->request)->run() == false)
        {
            $data['error_code'] = 1;
            $html = '';
            $error_mg = explode('</p>',$this->form_validation->listErrors());
            foreach($error_mg as $key => $value){
                if($key != (count($error_mg)-1)){
                    $html .= '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text">'.$value.'</p></div></div></div>';
                }
            }
            $data['message'] = $html;
        }else{
			if($id){
				// echo "update";
				$arr=array(
					'id' => $id,
					'name' => $name,
					'content' => $mail_content,
					'slug' => $mail_slug,
					'updated_date' => date('Y-m-d h:i:s'),
				);
				$update_content = $this->Mail_Content_Model->update_content($arr);
				if($update_content){
					$data['error_code'] = 0;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Mail content updated.</p></div></div></div>';
				}else{
					$data['error_code'] = 1;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Mail content field to update!</p></div></div></div>';
				}
			}else{
				// echo "insert";
				$arr=array(
					'name' => $name,
					'content' => $mail_content,
					'slug' => $mail_slug,
				);
				$insert_content=$this->Mail_Content_Model->insert_content($arr);
				if($insert_content){
					$data['error_code'] = 0;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Mail content added.</p></div></div></div>';
				}else{
					$data['error_code'] = 1;
					$data['message'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Mail content field to add!</p></div></div></div>';
				}
			}
		}
		echo json_encode($data);
	}
}
