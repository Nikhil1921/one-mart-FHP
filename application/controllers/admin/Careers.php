<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Careers extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "careers";
    private $table = "careers";
    private $icon = 'fa-users';
    private $redirect = 'admin/careers';
    
    public function index()
    {
        if (access($this->name,'index')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;

            $this->template->load('admin/template','admin/careers/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/CareersModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                
                $sub_array[] = $row->name;
                $sub_array[] = $row->mobile;
                $sub_array[] = $row->email;
                $sub_array[] = $row->qualification;
                $sub_array[] = $row->apply_post;
                $sub_array[] = $row->experience;
                $sub_array[] = '<a href="'.base_url('assets/images/carrers/').$row->resume.'" download>Download</a>';

                $sub_array[] = '
                <a href="'.base_url('admin/careers/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/careers/update/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/careers/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/CareersModel'),  
                "data"              =>     $data  
            );  

            echo json_encode($output);
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
            
            $data['cat'] = $this->main->edit($id, $this->table,'cat_name,id,icon,for_vendor,number_hide,to_time,from_time,price');

            $this->template->load('admin/template','admin/careers/view', $data);
        }else{
            error_404();
        }
    }
}