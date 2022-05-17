<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "customers";
    private $table = "customer";
    private $icon = 'fa-users';
    private $redirect = 'admin/customers';
    
    public function index()
    {
        if (access($this->name,'index')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;

            $this->template->load('admin/template','admin/customer/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/CustomerModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();
                $sub_array[] = $sr;
                $sub_array[] = $row->name;
                $sub_array[] = $row->mobile;
                $sub_array[] = $row->email;
                $sub_array[] = '₹ '.$row->balance;
                
                if ($row->active) {
                    $block = '<form class="table_form" action="'.base_url('admin/customers/block').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="block btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-ban"></button>
                </form>';
                }else{
                    $block = '';
                }

                $sub_array[] = '
                <a href="'.base_url('admin/customers/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                '.$block; 

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/CustomerModel'),  
                "data"              =>     $data  
            );  

            echo json_encode($output);
        }else{
            error_404();
        }
	}

    /*public function delete()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');

            $id = $this->main->update($id, array('is_delete' => 'yes') ,$this->table);
            
            flashMsg(
                        $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.',$this->redirect
                        );
        }else{
            error_404();
        }
    }*/

     public function block()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');

            $id = $this->main->update($id, array('active' => 0) ,$this->table);
            
            flashMsg(
                        $id, ucwords($this->name).' Blocked Successfully.', ucwords($this->name).' Not Blocked, Please Try Again.',$this->redirect
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
            
            $data['cust'] = $this->main->edit($id, $this->table,'name, mobile, email, home_address,balance');

            $this->template->load('admin/template','admin/customer/view', $data);
        }else{
            error_404();
        }
    }
}