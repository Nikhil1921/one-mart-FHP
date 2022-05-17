<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "permission";
    private $table = "access";
    private $icon = 'fa-cogs';
    private $redirect = 'admin/permission';
    
    public function index()
    {
        if (access($this->name,'index')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            if ($this->session->userdata('role') !== 'super admin') {
                $ignore = array('admin');
            }else{
                $ignore = array('super');
            }
            
            $not_in = $this->db->where_not_in('role', $ignore);
            $data['roles'] = $this->main->getall('role', 'id,role,permissions','','','', $not_in);
            $this->template->load('admin/template','admin/permission/index', $data);
        }else{
            error_404();
        }
    }

    public function create($id)
    {
        if (access($this->name,'add')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            
            $data['role'] = $this->main->edit($id,'role', 'role,permissions');
            $per = explode(',', $data['role']['permissions']);
            $menu = $this->db->select('name,menu_url,sub_menu,icon,permissions')->where_in('name', $per)->from('permissions')->order_by('priority','ASC')->get()->result_array();
            foreach ($menu as $k => $v) {
                $menu[$k]['sub_menu'] = json_decode($v['sub_menu']);
            }
            $data['menus'] = $menu;

            $data['access'] = $this->main->getall('access', 'role,menu,operation',array('role'=>$data['role']['role']));
            $data['access'] = json_encode($data['access']);
            
            $data['id'] = $id;
            $this->template->load('admin/template','admin/permission/create', $data);
        }else{
            error_404();
        }
    }

    public function add($per)
    {   
        if (access($this->name,'add')) {
            $post = $this->input->post();

            $ids = $this->main->getall($this->table, 'id', array('role' => $post['role'], 'menu' => $post['menu']));

            foreach ($ids as $k => $id) {
                $this->main->delete($id['id'], $this->table);
            }
            
            if (isset($post['operation'])) {
                foreach ($post['operation'] as $k => $v) {
                    $access[$k]['role'] = $post['role'];
                    $access[$k]['menu'] = $post['menu'];
                    $access[$k]['access'] = 1;
                    $access[$k]['operation'] = $v;
                }
                
                foreach ($access as $k => $v) {
                    $this->main->add($v, $this->table);
                }
            }
            $this->create($per);
        }else{
            error_404();
        }
    }
}