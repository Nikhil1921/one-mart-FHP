<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "banner";
    private $table = "banner";
    private $icon = 'fa-picture-o';
    private $redirect = 'admin/banner';

    public function index()
    {
        if (access($this->name,'index')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;

            $this->template->load('admin/template','admin/banner/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/BannerModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = '<img src="'.base_url('assets/images/banner/').$row->banner.'" class="table-image" >';

                $sub_array[] = '
                <form class="table_form" action="'.base_url('admin/banner/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/BannerModel'),  
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
            
            if (empty($_FILES['image']['name'])) {
                $data['error'] = '<span class="custom_error">* Please Select Image </span>';
                $this->template->load('admin/template','admin/banner/index', $data);
            }else{
                $post = $this->input->post();
                
                $config['upload_path']= "assets/images/banner/";
                $config['allowed_types']='jpg|jpeg';
                $config['file_name'] = rand(0,99);
                $config['file_ext_tolower'] = TRUE;
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);
                
                if (!$this->upload->do_upload("image")) {
                    $this->template->load('admin/template','admin/banner/index', $data);
                }else{
                    $data = $this->upload->data();
                    $post['banner'] = $data["file_name"];
                    
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

    public function delete()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');
            $image = $this->main->check($this->table,['id'=>$id], 'banner');
            $image = "assets/images/banner/".$image;
            if (unlink($image)) {
               $id = $this->main->delete($id, $this->table); 
            }else{
                $id = 0;
            }
            flashMsg(
                        $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.',$this->redirect
                        );
        }else{
            error_404();
        }
    }
}