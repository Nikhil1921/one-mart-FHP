<?php defined('BASEPATH') OR exit('No direct script access allowed');

class InquiryCategory extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "inquiry-category";
    private $table = "inquiry_category";
    private $icon = 'fa-navicon';
    private $redirect = 'admin/inquiryCategory';
    // private $redirect = 'admin/inquiry-sub-category';

    public $validate = [
            [
                'field' => 'cat_name',
                'label' => 'Category Name',
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

            $this->template->load('admin/template','admin/inquiry_category/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/InquiryCategoryModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->cat_name;  
                $sub_array[] = '<img src="'.base_url('assets/images/inquiry_category/').$row->icon.'" class="table-image" >';

                $sub_array[] = '
                <a href="'.base_url('admin/inquiryCategory/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/inquiryCategory/update/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/inquiryCategory/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/InquiryCategoryModel'),  
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
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/inquiry_category/add', $data);
            }else{
                if (empty($_FILES['image']['name'])) {
                    $data['error'] = '<span class="custom_error">* Please Select Image </span>';
                    $this->template->load('admin/template','admin/inquiry_category/add', $data);
                }else{
                    $post = $this->input->post();
                    
                    $config['upload_path']= "assets/images/inquiry_category/";
                    $config['allowed_types']='png';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['cat_name']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/inquiry_category/add', $data);
                    }else{
                        $data = $this->upload->data();
                        $post['icon'] = $data["file_name"];
                        
                        $id = $this->main->add($post, $this->table);

                        flashMsg(
                        $id, ucwords($this->name).' Added Successfully.', ucwords($this->name).' Not Added, Please Try Again.', $this->redirect.'/sliderUpload/'.$id
                        );
                    }
                }
            }
        }else{
            error_404();
        }   
    }

    public function sliderUpload($id)
    {
        if (access($this->name, 'add')) {
            if (!$this->input->is_ajax_request()) {
                if (!$id) return redirect($this->redirect);
                $data['slider_images'] = $this->main->check($this->table, ['id' => $id], 'slider_images');
                if (!$data['slider_images']) return redirect($this->redirect);
                $data['id'] = $id;
                $data['name'] = $this->name;
                $data['icon'] = $this->icon;
               return $this->template->load('admin/template','admin/inquiry_category/sliderUpload', $data);
            }else{
               $config = [
                    'upload_path'      => "assets/images/inquiry_category/",
                    'allowed_types'    => 'jpg|jpeg|png',
                    'file_name'        => time(),
                    'file_ext_tolower' => TRUE
                ];

                $this->upload->initialize($config);
                
                $images = $this->main->check($this->table, ['id' => $id],'slider_images');
                if ($this->upload->do_upload("file")) {
                    if ($images == 'No Image') {
                        $image[] = $this->upload->data("file_name");
                    }else{
                        $image = json_decode($images);
                        array_push($image, $this->upload->data("file_name"));
                    }
                    $post['slider_images'] = json_encode($image);
                    $this->main->update($id, $post, $this->table);
                };
            }
        }else{
            error_404();
        }
    }

    public function removeSlider()
    {
        if (access($this->name,'add')) {
            if (!$this->input->is_ajax_request()) {
                error_404();
            }else{
                $id = $this->input->post('id');
                $img = $this->input->post('image');

                $images = $this->main->check($this->table, ['id' => $id],'slider_images');
                $images = (array) json_decode($images);
                
                if (($key = array_search($img, $images)) !== false) 
                    unset($images[$key]);
                
                if (file_exists("assets/images/inquiry_category/".$img))
                    unlink("assets/images/inquiry_category/".$img);

                $post['slider_images'] = (count($images)) ? json_encode($images) : 'No Image';

                $uId = $this->main->update($id, $post, $this->table);
                if ($uId) {
                    echo json_encode(['error' => false, 'message' => 'Image Removed.']);
                    die();
                }else{
                    echo json_encode(['error' => true, 'message' => 'Image Not Removed.']);
                    die();
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
            $data['cat'] = $this->main->edit($id, $this->table,'id,cat_name,icon,cat_price');
            
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/inquiry_category/update', $data);
            }else{
                $post = $this->input->post();  
                
                if (empty($_FILES['image']['name'])) {
                    $uid = $this->main->update($id, $post, $this->table);
                    flashMsg(
                        $uid, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect.'/sliderUpload/'.$id
                        );     
                }else{
                    $config['upload_path']= "assets/images/inquiry_category/";
                    $config['allowed_types']='png';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['cat_name']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);
                    
                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/inquiry_category/update', $data);
                    }else{
                        $data = $this->upload->data();
                        $post['icon'] = $data["file_name"];
                        
                        $uid = $this->main->update($id, $post, $this->table);
                        flashMsg(
                        $uid, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect.'/sliderUpload/'.$id
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
            /*$id = $this->main->delete($id, $this->table);*/
            
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
            
            $data['cat'] = $this->main->edit($id, $this->table,'cat_name,icon');

            $this->template->load('admin/template','admin/inquiry_category/view', $data);
        }else{
            error_404();
        }
    }
}