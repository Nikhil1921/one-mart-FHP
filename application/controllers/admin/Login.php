<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	private $table = 'users';

	public function index()
	{	
		login();
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->template->load('admin/log_template','admin/login');
		}
		else
		{
			$select = 'id, username, email, mobile, image, role';
			$post = $this->input->post();
			$post['password'] = my_crypt($post['password']);
			$post['is_blocked'] = 'no';
			$post['role !='] = 'vendor';
			$user = $this->main->get_where($this->table, $select, $post);
			
			if ($user) {
				$this->session->set_userdata($user);
	        	return redirect('admin/');		
			}else{
				$error['error'] = "mobile or Passsword not match";
				$this->template->load('admin/log_template','admin/login', $error);
			}
		}
	}

	public function logout()
	{
		auth();
		$this->session->sess_destroy();
		return redirect('admin/login');
	}
}