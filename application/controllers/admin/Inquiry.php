<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "inquiry";
    private $table = "inquiry";
    private $icon = 'fa-gear';
    private $redirect = 'admin/inquiry';

    public $validate = [
            [
                'field' => 'name',
                'label' => 'Service Name',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'description',
                'label' => 'Service Description',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'sub_cat_id',
                'label' => 'Service Sub Category',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'cat_id',
                'label' => 'Service Category',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'conditions[]',
                'label' => 'Service Condition',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
    ];
    
    public function index()
    {
        if (access($this->name,'index')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;

            $this->template->load('admin/template','admin/inquiry/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/InquiryModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->name;
                $sub_array[] = $row->sub_cat;
                $sub_array[] = $row->cat_name;

                $banners = '';
                
                if ($row->feature_service) {
                    $banners .= '<form class="table_form" action="'.base_url('admin/inquiry/feature_service').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><input type="hidden" name="feature_service" value="0"><button class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-check"></button>
                    </form>';
                }else{
                    $banners .= '<form class="table_form" action="'.base_url('admin/inquiry/feature_service').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><input type="hidden" name="feature_service" value="1"><button class="btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-ban"></button>
                    </form>';
                }

                if ($row->main_banner) {
                    $banners .= '<form class="table_form" action="'.base_url('admin/inquiry/main_banner').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><input type="hidden" name="main_banner" value="0"><button class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-check"></button>
                    </form>';
                }else{
                    $banners .= '<form class="table_form" action="'.base_url('admin/inquiry/main_banner').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><input type="hidden" name="main_banner" value="1"><button class="btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-ban"></button>
                    </form>';
                }

                $sub_array[] = $banners;
                
                $sub_array[] = '
                <a href="'.base_url('admin/inquiry/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/inquiry/update/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/inquiry/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->count($this->table, ['is_delete' => 0]),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/InquiryModel'),  
                "data"              =>     $data  
            );  

            echo json_encode($output);
        }else{
            error_404();
        }
	}

    public function add()
    {
        if (access($this->name,'add')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['cats'] = $this->main->getall('inquiry_category','id,cat_name');
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/inquiry/add', $data);
            }else{
                if (empty($_FILES['image']['name'])) {
                    $data['error'] = '<span class="custom_error">* Please Select Image </span>';
                    $this->template->load('admin/template','admin/inquiry/add', $data);
                }else{
                    $post = $this->input->post();
                    
                    $post['conditions'] = (is_array($post['conditions'])) ? implode(',', $post['conditions']) : $post['conditions'];
                    
                    $config['upload_path']= "assets/images/services/";
                    $config['allowed_types']='jpg|jpeg|png';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['name']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/inquiry/add', $data);
                    }else{
                        $data = $this->upload->data();
                        $post['image'] = $data["file_name"];
                        
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

    public function subCats()
    {
        if ($this->input->is_ajax_request()) { 
            $select = $this->input->post('select');
            $id = $this->input->post('id');
            $subcats = $this->main->getall('inquiry_sub_category', 'id,sub_cat', array('cat_id'=>$id));
            
            $output = '<option  value="">Select Sub Category</option>';
            foreach ($subcats as $key => $subcat) {
                $output .= '<option value="'.$subcat['id'].'">'.ucfirst($subcat['sub_cat']).'</option>';
            }
            echo $output;
        }else{
            error_404();
        }
    }

    public function view($id)
    {
        if (access($this->name,'view')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $join = ['cat_id' => 'inquiry_category as c','sub_cat_id' => 'inquiry_sub_category as sc'];
            $data['cat'] = $this->main->edit($id, $this->table, "$this->table.id,name,description,sc.sub_cat,c.cat_name,image,conditions", $join);

            $this->template->load('admin/template','admin/inquiry/view', $data);
        }else{
            error_404();
        }
    }

    public function update($id)
    {
        if (access($this->name,'update')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['cats'] = $this->main->getall('inquiry_category','id,cat_name');
            $data['cat'] = $this->main->edit($id, $this->table, "id,name,description,sub_cat_id,cat_id,conditions,image");
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/inquiry/update', $data);
            }else{
                $post = $this->input->post();
                $post['conditions'] = implode(',', $post['conditions']);
                
                if (empty($_FILES['image']['name'])) {
                    $id = $this->main->update($id, $post, $this->table);
                    flashMsg(
                        $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                        );     
                }else{
                    $config['upload_path']= "assets/images/services/";
                    $config['allowed_types']='jpg|jpeg|png';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['cat_name']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);
                    
                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/inquiry/update', $data);
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

            $id = $this->main->update($id, array('is_delete' => 1) ,$this->table);
            
            flashMsg(
                        $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.', $this->redirect
                        );
        }else{
            error_404();
        }
    }

    public function feature_service()
    {
        if (access($this->name,'update')) {
            $id = $this->input->post('id');
            $feature_service = $this->input->post('feature_service');

            $id = $this->main->update($id, array('feature_service' => $feature_service) ,$this->table);
            
            flashMsg(
                $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                );
        }else{
            error_404();
        }
    }

    public function main_banner()
    {
        if (access($this->name,'update')) {
            $id = $this->input->post('id');
            $main_banner = $this->input->post('main_banner');

            if ($main_banner == 1) {
                $this->main->update_where(['main_banner' => $main_banner], array('main_banner' => 0) ,$this->table);
            }

            $id = $this->main->update($id, array('main_banner' => $main_banner) ,$this->table);
            
            flashMsg(
                $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                );
        }else{
            error_404();
        }
    }
}