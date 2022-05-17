<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "role";
    private $table = "role";
    private $icon = 'fa-tasks';
    private $redirect = 'admin/role';

    public $validate = [
            [
                'field' => 'role',
                'label' => 'Role Name',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'permissions[]',
                'label' => 'Permission',
                'rules' => 'required',
                'errors' => [
                    'required' => "Select at least one %s",
                ],
            ],
    ];
    
    public function index()
    {
        if (access($this->name,'index')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;

            $this->template->load('admin/template','admin/role/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/RoleModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->role;
                $sub_array[] = $row->permissions;
                
                $sub_array[] = '
                <a href="'.base_url('admin/role/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/role/edit/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/role/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';  

                $data[] = $sub_array;  
                $sr++;
        	}

            if ($_SESSION['role'] != 'superadmin') {
                $admin = $this->main->count($this->table, array('role' => 'admin'));
                $admin = $admin + $this->main->count($this->table, array('role' => 'superadmin'));   
            }else{
                $admin = 0;
            }
            
            $recordsTotal = $this->main->all($this->table) - $admin;

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $recordsTotal,  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/RoleModel'),  
                "data"              =>     $data  
            );

            echo json_encode($output);
        }else{
            error_404();
        }
	}

	public function create()
    {
        if (access($this->name,'add')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $role = $this->session->userdata('role');
            if ($role == 'super admin') {
                $d = $this->main->getall('permissions', 'name');
                foreach ($d as $k => $v) {
                    $data['permissions'][$k] = $v['name'];    
                }
                $data['permissions'] = implode(',', $data['permissions']);
            }else{
                $data['permissions'] = $this->main->check('role', array('role'=>$role), 'permissions');
            }
            $this->template->load('admin/template','admin/role/create', $data);
        }else{
            error_404();
        }
    }

    public function view($id)
    {
        if (access($this->name,'view')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['role'] = $this->main->edit($id, $this->table, 'role,permissions');
            $role = $this->session->userdata('role');
            if ($role == 'super admin') {
                $d = $this->main->getall('permissions', 'name');
                foreach ($d as $k => $v) {
                    $data['permissions'][$k] = $v['name'];    
                }
                $data['permissions'] = implode(',', $data['permissions']);
            }else{
                $data['permissions'] = $this->main->check('role', array('role'=>$role), 'permissions');
            }

            $this->template->load('admin/template','admin/role/view', $data);
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
                    $post = $this->input->post();
                    $post['permissions'] = implode(',', $post["permissions"]);
                    $id = $this->main->add($post, $this->table);
                    flashMsg(
                    $id, ucwords($this->name).' Added Successfully.', ucwords($this->name).' Not Added, Please Try Again.',$this->redirect
                    );
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
            $data['role'] = $this->main->edit($id, $this->table, 'id,role,permissions');
            $role = $this->session->userdata('role');
            if ($role == 'super admin') {
                $d = $this->main->getall('permissions', 'name');
                foreach ($d as $k => $v) {
                    $data['permissions'][$k] = $v['name'];    
                }
                $data['permissions'] = implode(',', $data['permissions']);
            }else{
                $data['permissions'] = $this->main->check('role', array('role'=>$role), 'permissions');
            }

            $this->template->load('admin/template','admin/role/edit', $data);
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
                $post['permissions'] = implode(',', $post["permissions"]);
                
                $id = $this->main->update($id, $post, $this->table);
                flashMsg(
                    $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.',$this->redirect
                );     
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
                        $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.',$this->redirect
                        );
        }else{
            error_404();
        }
    }
}