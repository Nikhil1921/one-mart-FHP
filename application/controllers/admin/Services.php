<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "services";
    private $table = "services";
    private $icon = 'fa-gear';
    private $redirect = 'admin/services';

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
                'field' => 'price',
                'label' => 'Service Price',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'visiting_charge',
                'label' => 'Visiting Charge',
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
                'field' => 'conditions',
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

            $this->template->load('admin/template','admin/services/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/ServicesModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->name;
                $sub_array[] = $row->price;
                $sub_array[] = $row->visiting_charge;
                $sub_array[] = $row->sub_cat;
                $sub_array[] = $row->cat_name;
                $sub_array[] = '<img src="'.base_url('assets/images/services/').$row->image.'" class="table-image" >';
                $banners = '';
                
                if ($row->feature_service) {
                    $banners .= '<form class="table_form" action="'.base_url('admin/services/feature_service').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><input type="hidden" name="feature_service" value="0"><button class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-check"></button>
                    </form>';
                }else{
                    $banners .= '<form class="table_form" action="'.base_url('admin/services/feature_service').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><input type="hidden" name="feature_service" value="1"><button class="btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-ban"></button>
                    </form>';
                }

                if ($row->main_banner) {
                    $banners .= '<form class="table_form" action="'.base_url('admin/services/main_banner').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><input type="hidden" name="main_banner" value="0"><button class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-check"></button>
                    </form>';
                }else{
                    $banners .= '<form class="table_form" action="'.base_url('admin/services/main_banner').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><input type="hidden" name="main_banner" value="1"><button class="btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-ban"></button>
                    </form>';
                }

                $sub_array[] = $banners;

                $sub_array[] = '
                <a href="'.base_url('admin/services/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/services/update/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/services/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/ServicesModel'),  
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
            $data['cats'] = $this->main->getall('categories','id,cat_name');
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/services/add', $data);
            }else{
                if (empty($_FILES['image']['name'])) {
                    $data['error'] = '<span class="custom_error">* Please Select Image </span>';
                    $this->template->load('admin/template','admin/services/add', $data);
                }else{
                    $post = $this->input->post();
                    
                    $config['upload_path']= "assets/images/services/";
                    $config['allowed_types']='jpg|jpeg';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['name']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/services/add', $data);
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
            $subcats = $this->main->getall('subcategory', 'id,sub_cat', array('cat_id'=>$id));
            
            $output = '<option  value="">Select Sub Category</option>';
            foreach ($subcats as $key => $subcat) {
                $output .= '<option value="'.$subcat['id'].'">'.ucfirst($subcat['sub_cat']).'</option>';
            }
            echo $output;
        }else{
            error_404();
        }
    }

    public function services()
    {
        if ($this->input->is_ajax_request()) { 
            
            $id = $this->input->post('id');
            $subcats = $this->main->getall('services', 'id,name,cat_id', array('sub_cat_id'=>$id));
            
            $output = '<div class="remove-ser">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label class="col-form-label">Service</label>
                        </div>
                        <div class="col-sm-9">';
            foreach ($subcats as $key => $v) {
                $output .= '<div class="checkbox-zoom zoom-primary">
                                <label>
                                    <input type="checkbox" value="'.$v['id'].'" name="ser_id['.$v['cat_id'].']['.$id.'][]" />
                                    <span class="cr">
                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                    <span>'.ucwords($v['name']).'</span>
                                </label>
                            </div>';
            }
            $output .= '</div>
                        <div class="col-sm-1">
                            <button class="btn btn-primary btn-round waves-effect waves-light fa fa-plus add-ser"></button>
                        </div>
                    </div>
                </div>';
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
            $join = ['cat_id' => 'categories as c','sub_cat_id' => 'subcategory as sc'];
            $data['cat'] = $this->main->edit($id, $this->table, "$this->table.id,name,image,$this->table.price,description,sc.sub_cat,c.cat_name,conditions,visiting_charge", $join);

            $this->template->load('admin/template','admin/services/view', $data);
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
            $data['cat'] = $this->main->edit($id, $this->table, "id,name,image,price,description,sub_cat_id,cat_id,conditions,visiting_charge");
            
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/services/update', $data);
            }else{
                $post = $this->input->post();  
                
                if (empty($_FILES['image']['name'])) {
                    $id = $this->main->update($id, $post, $this->table);
                    flashMsg(
                        $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                        );     
                }else{
                    $config['upload_path']= "assets/images/services/";
                    $config['allowed_types']='jpg|jpeg';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['name']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);
                    
                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/services/update', $data);
                    }else{
                        $data = $this->upload->data();
                        $image_path = 'assets/images/services/'.$post['image'];
                        unlink($image_path);
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