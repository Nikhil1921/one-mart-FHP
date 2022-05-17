<?php defined('BASEPATH') OR exit('No direct script access allowed');

class InquirySubCategory extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "inquiry-sub-category";
    private $table = "inquiry_sub_category";
    private $icon = 'fa-navicon';
    private $redirect = 'admin/inquirySubCategory';

    public $validate = [
            [
                'field' => 'cat_id',
                'label' => 'Category Name',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'sub_cat',
                'label' => 'Sub Category Name',
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

            $this->template->load('admin/template','admin/inquiry_sub_category/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/InquirySubCategoryModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->sub_cat;
                $sub_array[] = $row->cat_name;

                $sub_array[] = '
                <a href="'.base_url('admin/inquirySubCategory/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/inquirySubCategory/update/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/inquirySubCategory/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/InquirySubCategoryModel'),  
                "data"              =>     $data  
            );  

            echo json_encode($output);
        }else{
            error_404();
        }
	}

    /*public function add()
    {
        if (access($this->name,'add')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['cats'] = $this->main->getall('inquiry_category','id,cat_name');
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/inquiry_sub_category/add', $data);
            }else{
                $post = $this->input->post();
                    
                $id = $this->main->add($post, $this->table);

                flashMsg(
                    $id, ucwords($this->name).' Added Successfully.', ucwords($this->name).' Not Added, Please Try Again.', $this->redirect
                    );
            }
        }else{
            error_404();
        }   
    }*/

    public function add()
    {
        if (access($this->name,'add')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['cats'] = $this->main->getall('inquiry_category','id,cat_name');
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/inquiry_sub_category/add', $data);
            }else{
                if (empty($_FILES['image']['name'])) {
                    $data['error'] = '<span class="custom_error">* Please Select Image </span>';
                    $this->template->load('admin/template','admin/inquiry_sub_category/add', $data);
                }else{
                    $post = $this->input->post();
                    
                    $config['upload_path']= "assets/images/sub_inquiry_category/";
                    $config['allowed_types']='png|jpg|jpeg';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['sub_cat']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/inquiry_sub_category/add', $data);
                    }else{
                        $data = $this->upload->data();
                        $post['icon'] = $data["file_name"];
                        
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

    /*public function update($id)
    {
        if (access($this->name,'update')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['cats'] = $this->main->getall('inquiry_category','id,cat_name');
            $data['cat'] = $this->main->edit($id, $this->table,"cat_id,id,sub_cat, icon");
            
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/inquiry_sub_category/update', $data);
            }else{
                $post = $this->input->post();  
                
                
                $id = $this->main->update($id, $post, $this->table);
                flashMsg(
                    $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                    );
            }   
        }else{
            error_404();
        }
    }*/

    public function update($id)
    {
        if (access($this->name,'update')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['cats'] = $this->main->getall('inquiry_category','id,cat_name');
            $data['cat'] = $this->main->edit($id, $this->table,"cat_id,id,sub_cat, icon");
            
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/inquiry_sub_category/update', $data);
            }else{
                $post = $this->input->post();  
                
                if (empty($_FILES['image']['name'])) {
                    $id = $this->main->update($id, $post, $this->table);
                    flashMsg(
                        $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                        );     
                }else{
                    $config['upload_path']= "assets/images/sub_inquiry_category/";
                    $config['allowed_types']='png|jpg|jpeg';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['sub_cat']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);
                    
                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/inquiry_sub_category/update', $data);
                    }else{
                        $data = $this->upload->data();
                        $post['icon'] = $data["file_name"];
                        
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

            $id = $this->main->update($id, array('is_delete' => 1) ,$this->table);
            
            flashMsg(
                $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.',$this->redirect
            );
        }else{
            error_404();
        }
    }

    public function view($id)
    {
        if (access($this->name,'view')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $join = ['cat_id' => 'categories as c'];
            $data['cat'] = $this->main->edit($id, $this->table,"c.cat_name,$this->table.sub_cat,$this->table.icon", $join);
            $this->template->load('admin/template','admin/inquiry_sub_category/view', $data);
        }else{
            error_404();
        }
    }
}