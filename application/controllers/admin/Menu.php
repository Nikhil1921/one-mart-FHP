<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "menu";
    private $table = "permissions";
    private $icon = 'fa-navicon';
    private $redirect = 'admin/menu';

    public $validate = [
            [
                'field' => 'name',
                'label' => 'Menu Name',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'icon',
                'label' => 'Menu Icon',
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

            $this->template->load('admin/template','admin/menu/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/PermissionModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->name;  
                $sub_array[] = $row->sub_menu;
                $option = '<option value="">Select</option>';
                for($i=1; $i <= $this->main->all($this->table); $i++)
                    {
                        $option .= '<option value="'.$i.'">'.$i.'</option>';
                    }
                $sub_array[] = '<span>'.$row->priority.'</span>&nbsp<form class="table_form" action="'.base_url('admin/menu/priority').'" method="POST"><select name="priority" class="form-control priority">
                                    '.$option.'</select><input type="hidden" name="id" value="'.$row->id.'"><input type="hidden" name="current" value="'.$row->priority.'">';
                $sub_array[] = '
                <a href="'.base_url('admin/menu/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/menu/edit/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/menu/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/PermissionModel'),  
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
            $data['feather'] = $this->main->getall('feather_icons', 'icon');
            $data['ope'] = $this->main->getall('operations', 'type');

            $this->template->load('admin/template','admin/menu/create', $data);
        }else{
            error_404();
        }
    }

    public function view($id)
    {
        if (access($this->name,'view')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['menu_detail'] = $this->main->edit($id, $this->table, 'id,name,menu_url,sub_menu,icon,permissions');
            $data['menu_detail']['sub_menu'] = json_decode($data['menu_detail']['sub_menu']);
            $data['menu_detail']['permissions'] = explode(',', $data['menu_detail']['permissions']);

            $this->template->load('admin/template','admin/menu/view', $data);
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

                if (is_array($post['sub_menu'])) {
                    $post['sub_menu'] = array_combine($_POST['sub_menu'],$_POST['sub_url']);
                    
                    $post['sub_menu'] = json_encode($post['sub_menu']);
                }

                $post['permissions'] = implode(',', $post["permissions"]);

                $post['priority'] = $this->main->all($this->table) + 1;
                unset($post['sub_url']);
                $id = $this->main->add($post, $this->table);
                
                flashMsg(
                        $id, ucwords($this->name).' Added Successfully.', ucwords($this->name).' Not Added, Please Try Again.'
                        , $this->redirect);
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
            $data['menu_detail'] = $this->main->edit($id, $this->table, 'id,name,menu_url,sub_menu,icon,permissions');
            $data['menu_detail']['sub_menu'] = json_decode($data['menu_detail']['sub_menu']);
            $data['feather'] = $this->main->getall('feather_icons', 'icon');
            $data['ope'] = $this->main->getall('operations', 'type');

            $this->template->load('admin/template','admin/menu/edit', $data);
        }else{
            error_404();
        }
    }

    public function update($id)
    {
        if (access($this->name,'update')) {
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->create();
            }else{

                $post = $this->input->post(); 
                $post['permissions'] = implode(',', $post["permissions"]);
                if (is_array($post['sub_menu'])) {
                    $post['sub_menu'] = array_combine($_POST['sub_menu'],$_POST['sub_url']);
                    $post['sub_menu'] = json_encode($post['sub_menu']);
                }
                unset($post['sub_url']);
                $id = $this->main->update($id, $post, $this->table);

                flashMsg(
                        $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
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
            /*$id = $this->main->delete($id, $this->table);*/

            flashMsg(
                    $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.', $this->redirect);
        }else{
            error_404();
        }
    }

    public function priority()
    {   
        if (access($this->name,'update')) {
            $post = $this->input->post();
            
            $change = array('priority' => $post['current']);
            
            unset($post['current']);
            $id = $post['id'];
            unset($post['id']);
            $change_id = $this->main->get_where($this->table, 'id', array($this->table.'.priority' => $post['priority']));
            $id1 = $this->main->update($id, $post, $this->table);
            if ($id1) {
                $id2 = $this->main->update($change_id['id'], $change, $this->table);
                
                if ($_SESSION['role'] == 'admin') {
                    $menu = $this->main->getall('permissions', 'name,menu_url,sub_menu,icon,permissions','','','priority ASC');
                }elseif ($_SESSION['role'] == 'staff') {
                    $per = explode(',', $_SESSION['permissions']);
                    $menu = $this->db->select('name,menu_url,sub_menu,icon,permissions')->where_in('id', $per)->from('permissions')->order_by('priority','ASC')->get()->result_array();
                }
                foreach ($menu as $k => $v) {
                            $menu[$k]['sub_menu'] = json_decode($v['sub_menu']);
                        }
                        $menus['menu'] = $menu;
                        $this->session->set_userdata($menus);
                flashMsg(
                        $id2, 'Priority Changed Successfully.', 'Priority Not Changed, Please Try Again.', $this->redirect);
            }else{
                flashMsg(
                        FALSE, 'Priority Changed Successfully.', 'Priority Not Changed, Please Try Again.', $this->redirect
                        );       
            }
        }else{
            error_404();
        }
    }
}