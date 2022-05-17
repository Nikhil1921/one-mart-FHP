<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth();
	}

	private $name = 'vendors';
	private $table = "vendor";
    private $icon = 'fa-users';
    private $redirect = 'admin/vendor';

    public $validate = [
            [
                'field' => 'username',
                'label' => 'Vendor Name',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'email',
                'label' => 'Vendor E-Mail',
                'rules' => 'required|valid_email|callback_email_check',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'mobile',
                'label' => 'Vendor Mobile',
                'rules' => 'required|callback_mobile_check',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'password',
                'label' => 'Vendor Password',
                'rules' => 'callback_password_check',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'c_password',
                'label' => 'Confirm Password',
                'rules' => 'callback_password_check|matches[password]',
                'errors' => [
                    'required' => "%s is Required",
                    'matches' => "%s must match with Vendor Password",
                ],
            ],
            [
                'field' => 'com_name',
                'label' => 'Company Name',
                'rules' => 'required', 
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'gst',
                'label' => 'Vendor gst',
                'rules' => 'callback_gst_check',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'photo',
                'label' => 'Vendor photo',
                'rules' => 'callback_photo_check'
            ],
    ];

    public function mobile_check($str)
    {   
        $id = $this->uri->segment(4);
        $man = $this->main->count('users', array('mobile' => $str));

        if ($man && empty($id)) {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function email_check($str)
    {   
        $id = $this->uri->segment(4);
        $man = $this->main->count('users', array('email' => $str));

        if ($man && empty($id)) {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function password_check($str)
    {   
        $id = $this->uri->segment(4);

        if (empty($id) && $str == '') {
            $this->form_validation->set_message('password_check', 'The %s is Required');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function gst_check($str)
    {   
        if (!empty($_FILES['gst_image']['name']) && $str == '') {
            $this->form_validation->set_message('gst_check', 'The %s is Required');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function photo_check($str)
    {   
        if (!empty($_FILES['photo_image']['name']) && $str == '') {
            $this->form_validation->set_message('photo_check', 'The %s is Required');
            return FALSE;
        }else{
            return TRUE;
        }
    }

	public function index()
	{	
		if (access($this->name,'index')) {
			$data['name'] = $this->name;
			$data['icon'] = $this->icon;
			
			$this->template->load('admin/template','admin/vendor/index', $data);
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
                $sub_array[] = ucwords($row->name);
                $sub_array[] = ucwords($row->com_name);
                /*$sub_array[] = '
                Company Image <a href="'.base_url('assets/images/users/').$row->image.'" download><i class="fa fa-download text-info"></i></a><br>
                Company GST <a href="'.base_url('assets/images/gst/').$row->gst_image.'" download><i class="fa fa-download text-info"></i></a>';*/
                // $sub_array[] = '₹ '.$row->balance;
                $sub_array[] = $row->mobile;
                $sub_array[] = $row->email;
                $sub_array[] = $row->gst;

                if ($row->is_blocked == 'no') {
                    $block = '<form class="table_block" action="'.base_url('admin/vendor/block').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="block btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-check-square-o"></button></form>';
                }else{
                    $block = '<form class="table_block d-flex" action="'.base_url('admin/vendor/unblock').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><div><button class="unblock btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-times"></button></div></form>';
                }

                $sub_array[] = $block;
                $sub_array[] = '
                <a href="'.base_url('admin/vendor/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/vendor/accounts/').$row->id.'" class="btn waves-effect waves-dark btn-warning btn-outline-warning btn-icon fa fa-bank"></a>
                <a href="'.base_url('admin/vendor/update/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/vendor/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>';

                $data[] = $sub_array;
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->count($this->table, array('is_delete' => 'no')),
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/VendorModel'),  
                "data"              =>     $data
            );
            
            echo json_encode($output);
        }else{
            error_404();
        }
	}

	public function add()
	{

		if (access($this->name,'list')) {
			$data['name'] = $this->name;
			$data['icon'] = $this->icon;
            /* $data['cats'] = $this->main->getall('categories','CONCAT("1-", id) id, cat_name', ['for_vendor'=>1]); */
            $cat = $this->main->getall('categories', 'CONCAT("1-", id) id,cat_name',['is_delete'=>'no']);
        
            $enquiry = $this->main->getall('inquiry_category', 'CONCAT("2-", id) id,cat_name',['is_delete'=>'no']);
            
            $data['cats'] = array_merge($cat, $enquiry);

			$this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/vendor/add', $data);
            }else{  
                $config['upload_path']= "assets/images/users/";
                $config['allowed_types']='jpg|jpeg';
                $config['file_name'] = strtolower(str_replace(' ','_', $this->input->post('username')));
                $config['file_ext_tolower'] = TRUE;
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);
                
                if (!$this->upload->do_upload("image")) {
                    $data['error'] = '<span class="custom_error">* Please Select Image </span>';
                    $this->template->load('admin/template','admin/vendor/add', $data);
                }else{
                    $image = $this->upload->data('file_name');
                    
                    $this->load->model('admin/VendorModel', 'vendor');
                    $id = $this->vendor->addVendor($this->table, $image);
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
            /* $data['cats'] = $this->main->getall('categories','CONCAT("1-", id) id, cat_name', ['for_vendor'=>1]); */
            $cat = $this->main->getall('categories', 'CONCAT("1-", id) id, cat_name',['is_delete'=>'no']);
        
            $enquiry = $this->main->getall('inquiry_category', 'CONCAT("2-", id) id, cat_name',['is_delete'=>'no']);
            
            $data['cats'] = array_merge($cat, $enquiry);

            $join = ['u_id' => 'users as u'];
            
            $data['vendor'] = $this->main->get_where($this->table, "u.id,u.username,u.email,u.image,u.mobile,u.com_name,$this->table.address,$this->table.area,$this->table.city,$this->table.state,$this->table.cat_id,lat,lng", ['u.id'=>$id], $join);
            
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/vendor/update', $data);
            }else{
                $post = $this->input->post();  
                unset($post['c_password']);  
                $user['address'] = $post['address'];
                unset($post['address']);
                $user['area'] = $post['sublocality'];
                unset($post['sublocality']);
                $user['city'] = $post['locality'];
                unset($post['locality']);
                $user['state'] = $post['administrative_area_level_1'];
                unset($post['administrative_area_level_1']);
                $user['lat'] = $post['lat'];
                unset($post['lat']);
                $user['lng'] = $post['lng'];
                unset($post['lng']);
                $user['cat_id'] = implode(',', $post['cat_id']);
                unset($post['cat_id']);
                if ($post['password'] != "") {
                    $post['password'] = my_crypt($post['password']);
                }else{
                    unset($post['password']);
                }
                
                if (empty($_FILES['image']['name'])) {
                    $this->main->update($id, $post, 'users');
                    $id = $this->main->update_where(['u_id'=>$id], $user, $this->table);
                    flashMsg(
                        $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                        );     
                }else{
                    $config['upload_path']= "assets/images/users/";
                    $config['allowed_types']='gif|jpg|png|jpeg';
                    $config['file_name'] = strtolower(str_replace(' ','_', $post['username']));
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE;

                    $this->upload->initialize($config);
                    
                    if (!$this->upload->do_upload("image")) {
                        $this->template->load('admin/template','admin/vendor/update', $data);
                    }else{
                        $data = $this->upload->data();
                        $post['image'] = $data["file_name"];
                        
                        $this->main->update($id, $post, 'users');
                        $id = $this->main->update_where(['u_id'=>$id], $user, $this->table);
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

            $this->main->update($id, array('is_delete' => 'yes') ,'users');
            $id = $this->main->update_where(['u_id'=>$id], array('is_delete' => 'yes') ,$this->table);
            
            flashMsg(
                        $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.',$this->redirect
                        );
        }else{
            error_404();
        }
    }

    public function block()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');

            $this->main->update($id, array('is_blocked' => 'yes') ,'users');
            $id = $this->main->update_where(['u_id'=>$id], array('is_delete' => 'yes') ,$this->table);
            
            flashMsg(
                $id, ucwords($this->name).' Blocked Successfully.', ucwords($this->name).' Not Blocked, Please Try Again.',$this->redirect
            );
        }else{
            error_404();
        }
    }

    public function unblock()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');
            
            $this->main->update($id, array('is_blocked' => 'no'), 'users');
            $id = $this->main->update_where(['u_id'=>$id], array('is_delete' => 'no'), $this->table);
            
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
            /* $data['cats'] = $this->main->getall('categories','CONCAT("1-", id) id, cat_name', ['for_vendor'=>1]); */
            $cat = $this->main->getall('categories', 'CONCAT("1-", id) id,cat_name',['is_delete'=>'no']);
        
            $enquiry = $this->main->getall('inquiry_category', 'CONCAT("2-", id) id,cat_name',['is_delete'=>'no']);
            
            $data['cats'] = array_merge($cat, $enquiry);

            $join = ['u_id' => 'users as u'];
            
            $data['vendor'] = $this->main->get_where($this->table, "u.id,u.username,u.email,u.image,u.mobile,u.com_name,$this->table.gst,$this->table.gst_image,$this->table.address,$this->table.cat_id,photo_image,photo,lat,lng", ['u.id'=>$id], $join);
            
            $this->template->load('admin/template','admin/vendor/view', $data);
        }else{
            error_404();
        }
    }

    public function accounts($id)
    {
        if (access($this->name,'view')) {
            $data['name'] = "accounts";
            $data['icon'] = $this->icon;
            $data['accounts'] = $this->main->getall('accounts','payment, accounts.payment_type, book_id', ['ven_id' => $id, 'accounts.status' => 'Pending'], ['order_id' => 'bookings']);

            $data['history'] = $this->main->getall('accounts','payment, accounts.payment_type, book_id', ['ven_id' => $id, 'accounts.status' => 'Done'], ['order_id' => 'bookings']);

            $data['id'] = $id;

            $this->template->load('admin/template','admin/vendor/accounts', $data);
        }else{
            error_404();
        }
    }

    public function clear()
    {
        if (access($this->name,'view')) {
            $ven_id = $this->input->post('id');
            $id = $this->main->update_where(['ven_id' => $ven_id], ['status' => 'Done'], 'accounts');

            flashMsg(
                $id, 'Account Clear Successfully.', 'Account Clear Not Successful, Please Try Again.', $this->redirect
            );
        }else{
            error_404();
        }
    }
}