<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Membership extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "membership";
    private $table = "membership";
    private $icon = 'fa-users';
    private $redirect = 'admin/membership';

    public $validate = [
            [
                'field' => 'plan',
                'label' => 'Plan Name',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'price',
                'label' => 'Plan Price',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'ser_id[][][]',
                'label' => 'Select Atleast One service',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s",
                ],
            ],
            [
                'field' => 'details',
                'label' => 'Plan Price',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'use_count',
                'label' => 'Use Count',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ]
    ];
    
    public function index()
    {
        if (access($this->name,'index')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;

            $this->template->load('admin/template','admin/membership/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/MembershipModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->plan;
                $sub_array[] = $row->price;
                $sub_array[] = $row->details;

                if ($row->active == 1) {
                    $active = '<form class="table_block" action="'.base_url('admin/membership/deactive').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="block btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-check-square-o"></button></form>';
                }else{
                    $active = '<form class="table_block" action="'.base_url('admin/membership/active').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="unblock btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-times"></button></form>';
                }
                
                $sub_array[] = '
                <a href="'.base_url('admin/membership/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/membership/update/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/membership/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>'.$active;  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/MembershipModel'),  
                "data"              =>     $data  
            );  

            echo json_encode($output);
        }else{
            error_404();
        }
	}

    public function view($id)
    {
        if (access($this->name,'view')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['member'] = $this->main->edit($id, $this->table, 'id, plan, price, ser_id, active, details,image,time_period, use_count');

            $this->template->load('admin/template','admin/membership/view', $data);
        }else{
            error_404();
        }
    }

    public function add()
    {   
        if (access($this->name,'add')) {
        	$data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['cats'] = $this->main->getall('categories','id,cat_name');
            
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE && empty($_FILES['image']['name'])) {
                $data['error'] = '<span class="text-danger">* Select only jpg or jpeg image (max 500kb)</span>';
            	return $this->template->load('admin/template','admin/membership/add', $data);
            }else{
                    $post = $this->input->post();
                    $config['upload_path']= "assets/images/membership/";
                    $config['allowed_types']='jpg|jpeg';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['plan']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/membership/add', $data);
                    }else{
                        $data = $this->upload->data();
                        $post['image'] = $data["file_name"];
                        unset($post['cat_id']); 
                        unset($post['sub_cat_id']);
                        $post['ser_id'] = json_encode($post['ser_id']);
                        $id = $this->main->add($post, $this->table);
                        flashMsg(
                            $id, ucwords($this->name).' Added Successfully.', ucwords($this->name).' Not Added, Please Try Again.', $this->redirect
                        );
                    }
                }
        }else{
            error_404();
        }
    }

   public function update($id)
    {
        if (access($this->name,'update')) {
        	$data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['cats'] = $this->main->getall('categories','id,cat_name');
            $data['member'] = $this->main->edit($id, $this->table, 'id, plan, price, ser_id, active, details, image,time_period, use_count');

            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                return $this->template->load('admin/template','admin/membership/update', $data);
            }else{
                $post = $this->input->post();
                unset($post['cat_id']);
                unset($post['sub_cat_id']);
                $post['ser_id'] = json_encode($post['ser_id']);
                if (empty($_FILES['image']['name'])) {
                    $id = $this->main->update($id, $post, $this->table);
                    flashMsg(
                        $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                    );    
                }else{
                    $config['upload_path']= "assets/images/membership/";
                    $config['allowed_types']='jpg|jpeg';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['plan']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);
                    
                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/membership/add', $data);
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

            flashMsg(
                        $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.', $this->redirect
                        );
        }else{
            error_404();
        }
    }

    public function active()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');
            $id = $this->main->update($id, array('active' => '1') ,$this->table);
            
            flashMsg(
                        $id, ucwords($this->name).' Activated Successfully.', ucwords($this->name).' Not Activated, Please Try Again.', $this->redirect
                        );
        }else{
            error_404();
        }
    }

    public function deactive()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');
            $id = $this->main->update($id, array('active' => '0') ,$this->table);
            
            flashMsg(
                        $id, ucwords($this->name).' De-activated Successfully.', ucwords($this->name).' Not De-activated, Please Try Again.', $this->redirect
                        );
        }else{
            error_404();
        }
    }
}