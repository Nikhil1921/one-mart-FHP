<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "wallet";
    private $table = "vendor";
    private $icon = 'fa-inr';
    private $redirect = 'admin/wallet';

    public $validate = [
            [
                'field' => 'type',
                'label' => 'Operation',
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

            $this->template->load('admin/template','admin/wallet/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/VendorModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->name;
                $sub_array[] = '₹ '.$row->balance;
                
                $sub_array[] = '
                <form class="balance" action="'.base_url('admin/wallet/update').'" method="POST" >
                <input type="text" name="balance" class="form-control col-md-4">
                <input type="hidden" name="id" value="'.$row->id.'">
                <button class="update btn waves-effect waves-dark btn-info btn-outline-info btn-icon fa fa-save"></button>
                </form>';  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/VendorModel'),  
                "data"              =>     $data  
            );  

            echo json_encode($output);
        }else{
            error_404();
        }
	}

    public function update()
    {

        if (access($this->name,'update')) {
            $post = $this->input->post();  
            $bal = $this->main->check($this->table, ['u_id'=>$post['id']], 'balance');
            $tran['user_id'] = $post['id'];
            $tran['money'] = $post['balance'];
            $post['balance'] = $bal + (float) $post['balance'];

            $id = $this->main->update_where(['u_id'=>$post['id']], $post, $this->table);
            
            if ($id) {
                $this->main->add($tran, 'wallet_transactions');
            }

            flashMsg(
                $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
            );
        }else{
            error_404();
        }
    }
}