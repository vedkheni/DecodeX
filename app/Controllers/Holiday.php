<?php
// defined('BASEPATH') or exit('No direct script access allowed');
namespace App\Controllers;
use App\Controllers\BaseController;

class Holiday extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $user_session = $this->session->get('id');
        if (!$user_session)
        {
            return redirect()->to(base_url());
        }
    }

    //designation
    public function index()
    {
        $user_session = $this->session->get('id');
        if (!$user_session)
        {
            return redirect()->to(base_url('admin'));
        }

        $data = array();
        $data['page_title'] = "Holiday";
        $data['js_flag'] = "holiday_view_js";
        $data['menu'] = "holiday_view";
        $data['holiday_all'] = $this->Holiday_Model->get_holiday_all();
        $get_employee = $this->Employee_Model->get_employee_list(1);
        foreach($get_employee as $emp){
            for($i = date('Y',strtotime($emp->date_of_birth)); $i<=date('Y',strtotime('+3 year'));$i++){
                $data1['id'] = $emp->id;
                $data1['title'] = $emp->fname .' '.$emp->lname.'`s BirthDay';
                $data1['holiday_date'] = $i.'-'.date('m-d',strtotime($emp->date_of_birth));
                $data1['date_of_birth'] = 'true';
                array_push($data['holiday_all'], $data1);
            }
        }
        $this->lib->view('administrator/holiday/holiday', $data);
    }

    public function employee_pagination()
    {
        //Designation_Model
       
        $user_role = $this->session->get('user_role');
        $columns = array(
            0 => 'id',
            1 => 'title',
            2 => 'date',
            3 => 'action',
        );

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order') [0]['column']];
        $dir = $this->request->getPost('order') [0]['dir'];

        $totalData = $this->Holiday_Model->allposts_count();

        $totalFiltered = $totalData;

        if (empty($this->request->getPost('search') ['value']))
        {
            $posts = $this->Holiday_Model->allposts($limit, $start, $order, $dir);
        }
        else
        {
            $search = $this->request->getPost('search') ['value'];

            $posts = $this->Holiday_Model->posts_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Holiday_Model->posts_search_count($search);
        }

        $data = array();
        if (!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['id'] = $post->id;
                $nestedData['title'] = $post->title;
                $nestedData['client_name'] = $post->client_name;

                $nestedData['action'] = '<a href="' . base_url('project/add') . '/' . $post->id . '"><i class="fa fa-edit"></i></a>| <a data-id="' . $post->id . '" class="delete-employee"><i class="fa fa-trash" aria-hidden="true"></i></a>';
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

    public function add()
    {
        $user_session = $this->session->get('id');
        if (!$user_session)
        {
            return redirect()->to(base_url('admin'));
        }

        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin')
        {
            return redirect()->to('dashboard');
        }
        $data = array();

        if (!empty($this->uri->getSegment(3)))
        {
            $data['year'] = $year = $this->uri->getSegment(3);
        }
        else
        {
            $data['year'] = $year = date('Y');
        }
        $data['list_data'] = $this->Holiday_Model->get_holiday($year);

        if ($this->uri->getSegment(3))
        {
            $data['page_title'] = "Edit Holiday";
            $id = $this->uri->getSegment(3);
        }
        else
        {
            $data['page_title'] = "Add Holiday";
            // $data['list_data']="";
            
        }
        $data['get_developer'] = $this->Employee_Model->get_employee_list(1);

        $data['js_flag'] = "holiday_js";
        $data['menu'] = "holiday_add";
        $this->lib->view('administrator/holiday/add_holiday', $data);
    }

    public function get_holiday_list()
    {
        $year = "";
        
        $year = $this->request->getPost('year');

        $user_role = $this->session->get('user_role');
        $columns = array(
            0 => 'id',
            1 => 'holiday_date',
            2 => 'title',
            3 => 'action',
        );

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $totalData = $this->Holiday_Model->allposts_count1($year);

        $totalFiltered = $totalData;

        if (empty($this->request->getPost('search')['value']))
        {
            $posts = $this->Holiday_Model->allposts1($year,$limit, $start, $order, $dir);
        }
        else
        {
            $search = $this->request->getPost('search')['value'];
            
            $posts = $this->Holiday_Model->posts_search1($year,$limit, $start, $search, $order, $dir);

            $totalFiltered = $this->Holiday_Model->posts_search_count1($year,$search);
        }
        $cdate = date('Y-m-d');
        $data = array();
        if (!empty($posts))
        {
            $i=1;
            foreach ($posts as $post)
            {
                $nestedData['#'] = "<span>" . $i . "</span>";
                $nestedData['holiday_date'] = dateFormat($post->holiday_date);
                $nestedData['title'] = $post->title;
                $nestedData['action'] = '<button data-holiday_id="'.$post->id.'" data-holiday_title="'.$post->title.'" data-holiday_date="'.$post->holiday_date.'" class="btn btn-outline-secondary edit-holiday mr-2">Edit</button><button data-holiday_date="'.$post->holiday_date.'" data-holiday_id="'.$post->id.'" class="btn btn-danger delete-holiday">Delete</button>';
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

    public function get_data_by_year()
    {
        $user_session = $this->session->get('id');
        if (!$user_session)
        {
            return redirect()->to(base_url('admin'));
        }

        $user_role = $this->session->get('user_role');
        if ($user_role != 'admin')
        {
            return redirect()->to('dashboard');
        }
        $data = array();

        $year = '';
        if (!empty($this->request->getPost("year")))
        {
            $year = $this->request->getPost("year");
            $data['year'] = $year;
        }
        else
        {
            $year = date('Y');
            $data['year'] = $year;
        }
        $data['list_data'] = $this->Holiday_Model->get_holiday($year);

        if ($this->request->getPost("year"))
        {
            $data['page_title'] = "Edit Holiday";
            $id = $this->request->getPost("year");
        }
        else
        {
            $data['page_title'] = "Add Holiday";
            
        }
        $data['get_developer'] = $this->Employee_Model->get_developer();

        $data['js_flag'] = "holiday_js";
        $data['menu'] = "holiday_add";
        echo json_encode($data);
        
    }

    public function delete_employee()
    {
        $user_role = $this->session->get('user_role');
        if ($user_role == 'admin')
        {
            return redirect()->to('dashboard');
        }

        $id = $this->request->getPost("id");
        $delete_employee = $this->Holiday_Model->delete_holiday($id);

    }

    public function delete_holiday()
    {
        $id = $this->request->getPost("id");
        $this->db->table('holiday')->where('id', $id);
        $this->db->delete();
        $this->db->last_query();
        
    }

    public function get_exists_holiday_date()
    {
        $select_day = $this->request->getPost("select_day");
        $select_month = $this->request->getPost("select_month");
        $search_year = $this->request->getPost("search_year");
        if (empty($select_day) && !empty($select_month))
        {
            $data = "Day Field Are Empty!";
            echo ($data);
            exit;
        }
        elseif (!empty($select_day) && empty($select_month))
        {
            $data = "Month Field Are Empty!";
            echo ($data);
            exit;
        }
        elseif (!empty($select_day) && empty($select_month))
        {
            $data = "Day And Month Field Are Empty!";
            echo ($data);
            exit;
        }
        $holiday_date_input = array();
        if (!empty($select_month))
        {
            foreach ($select_month as $k4 => $val4)
            {
                if ($select_day[$k4] == "Day" && $select_month[$k4] != "Month")
                {
                    $data = "Day Field Are Empty!";
                    echo ($data);
                    exit;
                }
                elseif ($select_day[$k4] != "Day" && $select_month[$k4] == "Month")
                {
                    $data = "Month Field Are Empty!";
                    echo ($data);
                    exit;
                }
                elseif ($select_day[$k4] == "Day" && $select_month[$k4] == "Month")
                {
                    $data = "Day And Month Field Are Empty!";
                    echo ($data);
                    exit;
                }
                $date_create = date_create($search_year . "-" . $select_month[$k4] . "-" . $select_day[$k4]);
                $holiday_date_input[] = date_format($date_create, 'Y-m-d');
            }
        }

        if (isset($holiday_date_input) && !empty($holiday_date_input))
        {
            $get_exists_holiday_date = $this->Holiday_Model->get_exists_holiday_date_page1($holiday_date_input);
        }
        else
        {
            $get_exists_holiday_date = 0;
        }

        if (isset($holiday_date_input) && !empty($holiday_date_input) && $get_exists_holiday_date > 0)
        {
            $get_exists_holiday_date_row = "Date already exists!";

        }
        else
        {
            $get_exists_holiday_date_row = "success";
            if (!empty($holiday_date_input))
            {
                $dups = array();
                foreach (array_count_values($holiday_date_input) as $val => $c)
                {
                    if ($c > 1) $dups[] = $val;
                }
                if (empty($dups))
                {
                    $get_exists_holiday_date_row = "success";
                }
                else
                {
                    $get_exists_holiday_date_row = "Date already exists!";
                }
            }

        }
        echo $get_exists_holiday_date_row;
    }
  
    public function insert_data1()
    {
        $search_year = $this->request->getPost("search_year");
        $holiday_id = $this->request->getPost("holiday_id");
        $id = $this->request->getPost("e_id");
        $title_update = $this->request->getPost("title_update");
        $select_day_update = $this->request->getPost("select_day_update");
        $select_month_update = $this->request->getPost("select_month_update");
        if (!empty($search_year))
        {
            $year = $search_year;
        }
        else
        {
            $year = date('Y');
        }
        $title = $this->request->getPost("title");
        $select_day = $this->request->getPost("select_day");
        $select_month = $this->request->getPost("select_month");

        $holiday_date_input = $holiday_date_input_update = array();
        $date_create1 = $date_create = "";
        if (!empty($select_month))
        {
            foreach ($select_month as $k2 => $val2)
            {
                if ($select_day[$k2] == "Day" && $select_month[$k2] != "Month")
                {
                    $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Day field are empty!</p></div></div></div>';
                    echo json_encode($data);
                    exit;
                }
                elseif ($select_day[$k2] != "Day" && $select_month[$k2] == "Month")
                {
                    $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Month field are empty!</p></div></div></div>';
                    echo json_encode($data);
                    exit;
                }
                elseif ($select_day[$k2] == "Day" && $select_month[$k2] == "Month")
                {
                    $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Day and month field are empty!</p></div></div></div>';
                    echo json_encode($data);
                    exit;
                }
                $date_create = date_create($search_year . "-" . $select_month[$k2] . "-" . $select_day[$k2]);
                $holiday_date_input[] = date_format($date_create, 'Y-m-d');
            }
        }
        if (!empty($select_month_update))
        {
            foreach ($select_month_update as $k3 => $val3)
            {
                if ($select_day_update[$k3] == "Day" && $select_month_update[$k3] != "Month")
                {
                    $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Day field are empty!</p></div></div></div>';
                    echo json_encode($data);
                    exit;
                }
                elseif ($select_day_update[$k3] != "Day" && $select_month_update[$k3] == "Month")
                {
                    $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Month field are empty!</p></div></div></div>';
                    echo json_encode($data);
                    exit;
                }
                elseif ($select_day_update[$k3] == "Day" && $select_month_update[$k3] == "Month")
                {
                    $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Day and month field are empty!</p></div></div></div>';
                    echo json_encode($data);
                    exit;
                }
                $date_create1 = date_create($search_year . "-" . $select_month_update[$k3] . "-" . $select_day_update[$k3]);
                $holiday_date_input_update[] = date_format($date_create1, 'Y-m-d');
            }
        }
        $array_merge = array_merge($holiday_date_input, $holiday_date_input_update);
        if (isset($holiday_date_input) && !empty($holiday_date_input))
        {
            $get_exists_holiday_date = $this->Holiday_Model->get_exists_holiday_date_page1($holiday_date_input);
        }
        else
        {
            $get_exists_holiday_date = 0;
        }
        $data['msg'] = '';
        if (isset($holiday_date_input) && !empty($holiday_date_input) && $get_exists_holiday_date > 0)
        {
            $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Date already exists!</p></div></div></div>';
        }
        else
        {
            $arr_update = $arr_insert = $check_update_date = array();
            if (isset($select_month_update) && !empty($select_month_update))
            {
                foreach ($holiday_id as $k => $val)
                {
                    if (isset($select_month_update[$k]))
                    {
                        $holiday_date_update = $search_year . "-" . $select_month_update[$k] . "-" . $select_day_update[$k];
                        if ($title_update[$k] == "")
                        {
                            $data['msg'] = "";
                            echo json_encode($data);
                            exit;
                        }
                        else
                        {
                            if (!in_array($holiday_date_update, $check_update_date))
                            {
                                array_push($check_update_date, $holiday_date_update);
                                $arr_update = array(
                                    'id' => $val,
                                    'title' => $title_update[$k],
                                    'holiday_date' => $holiday_date_update,
                                );
                                $insert_employee = $this->Holiday_Model->update_holiday($arr_update);
                                // $insert_employee= true;
                                if ($insert_employee)
                                {
                                    $data['msg'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Holiday updated.</p></div></div></div>';
                                }
                                else
                                {
                                    $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Holiday field to update.</p></div></div></div>';
                                }
                            }
                            else
                            {
                                $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>' . $select_day_update[$k] . ' ' . date("F", mktime(0, 0, 0, $select_month_update[$k], 10)) . ' ' . $search_year . '  already exists!</p></div></div></div>';
                                echo json_encode($data);
                                exit;
                            }
                        }
                    }
                    else
                    {
                        // $delete_employee= true;
                        $delete_employee = $this->Holiday_Model->delete_holiday($val);
                        if ($delete_employee)
                        {
                            $data['msg'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Holiday deleted.</p></div></div></div>';
                        }
                        else
                        {
                            $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Holiday field to delete.</p></div></div></div>';
                        }
                    }
                }
            }
            $data['id'] = $data['title'] = array();
            if (isset($select_month) && !empty($select_month))
            {
                foreach ($select_month as $k1 => $val1)
                {
                    $holiday_date = $search_year . "-" . $select_month[$k1] . "-" . $select_day[$k1];
                    $arr_insert = array(
                        'title' => $title[$k1],
                        'holiday_date' => $holiday_date,
                    );
                    // $insert_employee= true;
                    $insert_employee = $this->Holiday_Model->insert_employee($arr_insert);
                    $id = $this->db->getInsertID();
                    $title = $title[$k1];
                    if ($insert_employee)
                    {
                        $data['msg'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Holiday added.</p></div></div></div>';
                        array_push($data['id'], $id);
                        array_push($data['title'], $title);
                    }
                    else
                    {
                        $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Holiday field to add.</p></div></div></div>';
                    }
                }
            }
        }
        echo json_encode($data);
    }

    public function delete_data()
    {
        /* $holiday_dates = $this->request->getPost("holiday_dates"); */
        $id = $this->request->getPost("holiday_id");
        /* $holiday_date_input = explode(' ,',$holiday_dates);
         if (isset($holiday_date_input) && !empty($holiday_date_input))
        {
            $get_exists_holiday_date = $this->Holiday_Model->get_exists_holiday_date_page1($holiday_date_input);
        }
        else
        {
            $get_exists_holiday_date = 0;
        } 
        $data['msg'] = '';
        if (isset($holiday_date_input) && !empty($holiday_date_input) && $get_exists_holiday_date > 0)
        {
            $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Date already exists!</p></div></div></div>';
        }
        else
        { */
            $delete_employee = $this->Holiday_Model->delete_holiday($id);
            if ($delete_employee)
            {
                $data['msg'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Holiday deleted.</p></div></div></div>';
            }
            else
            {
                $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Holiday field to delete.</p></div></div></div>';
            }
        /* } */
        echo json_encode($data);
    }

    public function insert_data()
    {
        // date('m-d',strtotime($emp->date_of_birth))
        $search_year = $this->request->getPost("search_year");
        $holiday_dates = $this->request->getPost("holiday_dates");
        $title = $this->request->getPost("title");
        $id = $this->request->getPost("holiday_id");
        $data['msg'] = '';
        $this->form_validation->reset();
        $this->form_validation->setRule('title', 'Title', 'required');
        $this->form_validation->setRule('holiday_dates', 'Holiday Dates', 'required');
        if ($this->form_validation->withRequest($this->request)->run() == false)
        {
            $this->session->set_flashdata('message', $this->form_validation->listErrors());
            // return redirect()->to(base_url('candidates/add'));
            $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>'.$this->form_validation->listErrors().'</p></div></div></div>';

        }
        else
        {

            $holiday_date_input = explode(' ,',$holiday_dates);
            if (!empty($search_year))
            {
                $year = $search_year;
            }
            else
            {
                $year = date('Y');
            }

            // $holiday_date_input = $holiday_date_input_update = array();
            $date_create1 = $date_create = "";
            
            // $array_merge = array_merge($holiday_date_input, $holiday_date_input_update);
            if(!empty($id)){
                if(Format_date($this->request->getPost("hidden_date")) == Format_date($holiday_dates)){
                    $get_exists_holiday_date = 0;
                }else{
                    if (isset($holiday_date_input) && !empty($holiday_date_input))
                    {
                        $get_exists_holiday_date = $this->Holiday_Model->get_exists_holiday_date_page1($holiday_date_input);
                    }
                    else
                    {
                        $get_exists_holiday_date = 0;
                    }    
                }
            }else{
                if (isset($holiday_date_input) && !empty($holiday_date_input))
                {
                    $get_exists_holiday_date = $this->Holiday_Model->get_exists_holiday_date_page1($holiday_date_input);
                }
                else
                {
                    $get_exists_holiday_date = 0;
                }
            }
            if (isset($holiday_date_input) && !empty($holiday_date_input) && $get_exists_holiday_date > 0)
            {
                $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Date already exists!</p></div></div></div>';
            }
            else
            {
                $arr_update = $arr_insert = $check_update_date = array();
                
                $data['id'] = $data['title'] = array();
                if(!empty($id)){
                    $holiday_date = Format_date($holiday_dates);
                    $arr_insert = array(
                        'id' => $id,
                        'title' => $title,
                        'holiday_date' => $holiday_date,
                    );
                    // $insert_employee= true;
                    $update_holiday = $this->Holiday_Model->update_holiday($arr_insert);
                    if ($update_holiday)
                    {
                        $data['msg'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Holiday updated.</p></div></div></div>';
                        array_push($data['id'], $id);
                        array_push($data['title'], $title);
                    }
                    else
                    {
                        $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Holiday field to update!</p></div></div></div>';
                    }
                }else{
                    foreach ($holiday_date_input as $k1 => $val1)
                    {
                        $holiday_date = Format_date($val1);
                        $arr_insert = array(
                            'title' => $title,
                            'holiday_date' => $holiday_date,
                        );
                        // $insert_employee= true;
                        $insert_employee = $this->Holiday_Model->insert_employee($arr_insert);
                        // $id = $this->db->insertID();
                        if ($insert_employee)
                        {
                            $data['msg'] = '<div class="msg-box success-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-check"></i></div><div class="msg-text"><p>Holiday added.</p></div></div></div>';
                            array_push($data['id'], $insert_employee);
                            array_push($data['title'], $title);
                        }
                        else
                        {
                            $data['msg'] = '<div class="msg-box error-box"><div class="msg-content"><div class="msg-icon"><i class="fas fa-times"></i></div><div class="msg-text"><p>Holiday field to add.</p></div></div></div>';
                        }
                    }
                }
            }
        }
        echo json_encode($data);
    }

}

