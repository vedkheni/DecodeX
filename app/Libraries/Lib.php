<?php
// if (!defined('BASEPATH'))
//     exit('No direct script access allowed');
namespace App\Libraries;
class Lib
{
    
    public function view($template_file, $data = array())
    {
		$this->Broadcast_Model = new \App\Models\Broadcast_Model();
        //echo "<pre>";	print_r($data['header']);die;
		$pro=array();
		// $CI =& get_instance();
		//$CI->load->model('Administrator_Model');
		//$pro['pro']=$CI->Administrator_Model->all_project_list();
		//$pro_pre=$CI->Administrator_Model->project_list_prifix();
		//$pro['prefix']=$pro_pre['0']->prefix; 
      /*  $user_session=$this->session->get('id');
		$controler=$this->uri->segment(1); */
	/*	if(!$user_session){
			if($controler=="login" || $controler=="admin")
			{
				$CI->load->view($template_file, $data);
				
			}
			else
			{
			$CI->load->view('visiter/include/header');
			$CI->load->view($template_file, $data);
            $CI->load->view('visiter/include/footer');
			}
		}
		else {		
			*/
			$data['broadcast_list'] = $this->Broadcast_Model->allBroadcastMassage();
            echo view('administrator/include/header',$data);
            echo view('administrator/include/sidebar',$data);
            echo view('administrator/include/head',$data);
            echo view($template_file, $data);
            echo view('administrator/include/footer',$data);
       // }
		
        
    }
    
}