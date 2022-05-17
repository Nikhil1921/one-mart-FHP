<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "staff";
    private $table = "users";
    private $icon = 'fa-users';
    private $redirect = 'admin/staff';

    public $validate = [
            [
                'field' => 'username',
                'label' => 'User Name',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'email',
                'label' => 'User E-Mail',
                'rules' => 'required|valid_email|callback_email_check',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'mobile',
                'label' => 'User Mobile',
                'rules' => 'required|callback_mobile_check',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'password',
                'label' => 'User Password',
                'rules' => 'callback_password_check',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'c_password',
                'label' => 'Confirm Password',
                'rules' => 'callback_password_check|matches[password]',
                'errors' => [
                    'required' => "%s is Required",
                    'matches' => "%s must match with User Password",
                ],
            ],

            [
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
    ];

    public function mobile_check($str)
    {   

        $id = $this->uri->segment(4);
        $man = $this->main->count($this->table, array('mobile' => $str));

        if ($man && empty($id)) {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function email_check($str)
    {   
        $id = $this->uri->segment(4);
        $man = $this->main->count($this->table, array('email' => $str));

        if ($man && empty($id)) {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function password_check($str)
    {   
        $id = $this->uri->segment(4);

        if (empty($id) && $str == '') {
            $this->form_validation->set_message('password_check', 'The %s is Required');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    public function index()
    {
        if (access($this->name,'index')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;

            $this->template->load('admin/template','admin/staff/index', $data);
        }else{
        error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/StaffModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->username;  
                $sub_array[] = $row->email;  
                $sub_array[] = $row->image;  
                $sub_array[] = $row->mobile;
                $sub_array[] = $row->role;
                $permissions = $this->main->check('role', array('role'=>$row->role), 'permissions');
                $sub_array[] = '<p class="ptag">'.$permissions.'</p>';

                $sub_array[] = '
                <a href="'.base_url('admin/staff/meetings/').$row->id.'" class="btn waves-effect waves-dark btn-warning btn-outline-warning btn-icon fa fa-file-text"></a>';

                $sub_array[] = '
                <a href="'.base_url('admin/staff/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/staff/edit/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/staff/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';  

                $data[] = $sub_array;  
                $sr++;
        	}
            
            if ($_SESSION['role'] != 'super admin') {
                $admin = $this->main->count($this->table, array('role' => 'admin'));   
                $admin = $admin + $this->main->count($this->table, array('role' => 'super admin'));   
            }else{
                $admin = $this->main->count($this->table, array('role' => 'super admin'));
            }
            
            $vendor = $this->main->count($this->table, array('role' => 'vendor'));
            $recordsTotal = $this->main->all($this->table) - $vendor - $admin;

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $recordsTotal,  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/StaffModel'),
                "data"              =>     $data  
            );  

            echo json_encode($output);
        }else{
            error_404();
        }
	}

	public function create($error = '')
    {   
        if (access($this->name,'add')) {
            if ($error != '') {
                $data['error'] = $error;
            }
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $role = $this->session->userdata('role');
            if ($role == 'super admin') {
                $role = $this->db->where_not_in('role', ['super admin']);
            }else{
                $role = $this->db->where_not_in('role', ['admin','vendor']);
            }
            
            $data['role'] = $this->main->getall('role', 'role','','','', $role);

            $this->template->load('admin/template','admin/staff/create', $data);
        }else{
            error_404();
        }
    }

    public function view($id)
    {
        if (access($this->name,'view')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['staff'] = $this->main->edit($id, $this->table, 'id,username,email,image,mobile,role');
            
            $this->template->load('admin/template','admin/staff/view', $data);
        }else{
            error_404();
        }
    }

    public function meetings($id)
    {
        if (access($this->name,'view')) {
            $data['name'] = "meetings";
            $data['icon'] = "fa-file-text";
            $data['u_id'] = $id;
            $this->template->load('admin/template','admin/staff/meetings', $data);
        }else{
            error_404();
        }
    }

    public function meetings_get()
    {
        if (access($this->name,'view')) {
            $fetch_data = $this->main->make_datatables('admin/MeetingsModel');
            $sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->name;  
                $sub_array[] = $row->meeting_type;  
                $sub_array[] = $row->mobile;
                $sub_array[] = $row->remarks;
                $sub_array[] = $row->meeting_date;
                $sub_array[] = $row->meeting_time;

                $data[] = $sub_array;  
                $sr++;
            }

            $output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->count('meetings', ['is_delete'=>0]),
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/MeetingsModel'),
                "data"              =>     $data  
            );  

            echo json_encode($output);
        }else{
            error_404();
        }
    }

    public function store()
    {   
        if (access($this->name,'add')) {
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->create();
            }else{
                if (empty($_FILES['image']['name'])) {
                    $error = '<span class="custom_error">* Please Select Image </span>';
                    $this->create($error);       
                }else{
                    $post = $this->input->post();
                    
                    $config['upload_path']= "assets/images/users/";
                    $config['allowed_types']='gif|jpg|png|jpeg';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['username']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);
                    
                    if (!$this->upload->do_upload("image")) {
                        $this->create();
                    }else{
                        $data = $this->upload->data();
                        $post['image'] = $data["file_name"];
                        
                        $post['password'] = my_crypt($post["password"]);
                        unset($post['c_password']);

                        $id = $this->main->add($post, $this->table);
                        flashMsg(
                        $id, ucwords($this->name).' Added Successfully.', ucwords($this->name).' Not Added, Please Try Again.', $this->redirect
                        );
                    }
                }
            }   
        }else{
            error_404();
        }
    }
 
    public function edit($id)
    {
        if (access($this->name,'update')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['staff'] = $this->main->edit($id, $this->table, 'id,username,email,image,mobile,role');
            $role = $this->session->userdata('role');
            if ($role == 'super admin') {
                $role = $this->db->where_not_in('role', ['super admin']);
            }else{
                $role = $this->db->where_not_in('role', ['admin','vendor']);
            }
            $data['role'] = $this->main->getall('role', 'role','','','', $role);
            $this->template->load('admin/template','admin/staff/edit', $data);
        }else{
            error_404();
        }
    }

    public function update($id)
    {
        if (access($this->name,'update')) {
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->edit($id);
            }else{
                $post = $this->input->post();  
                unset($post['c_password']);  
                
                if ($post['password'] != "") {
                    $post['password'] = my_crypt($post['password']);
                }else{
                    unset($post['password']);
                }

                if (empty($_FILES['image']['name'])) {
                    
                    $id = $this->main->update($id, $post, $this->table);
                    flashMsg(
                        $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                        );     
                }else{
                    $config['upload_path']= "assets/images/users/";
                    $config['allowed_types']='gif|jpg|png|jpeg';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['username']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);
                    
                    if (!$this->upload->do_upload("image")) {
                        $this->edit($id);
                    }else{
                        $data = $this->upload->data();
                        $post['image'] = $data["file_name"];
                        
                        $id = $this->main->update($id, $post, $this->table);
                        flashMsg(
                        $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                        );
                    }
                }
            }   
        }else{
            error_404();
        }
    }

    public function delete()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');
            $id = $this->main->update($id, array('is_delete' => 'yes') ,$this->table);
            /*$id = $this->main->delete($id, $this->table);*/
            flashMsg(
                        $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.', $this->redirect
                        );
        }else{
            error_404();
        }
    }
}