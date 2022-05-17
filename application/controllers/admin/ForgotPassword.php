<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPassword extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		login();
	}

	private $table = 'forgot_password';

	public function index()
	{		
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->template->load('admin/log_template','admin/forgot');	
		}
		else
		{	
			$mobile['mobile'] = $this->input->post('mobile');
			$select = 'email';
			$otp = rand(100000, 999999);
            date_default_timezone_set('Asia/Kolkata');
            $date = date("Y-m-d h:i:sa");
            $email = $this->main->check('users', $mobile, $select);
			if ($email) {
				$msg = "Link to change your accounr password.<br>";
                $msg .= 'Please go to the given link and set your new password.<br>';
                $msg .= base_url().'admin/forgotPassword/check_otp?email='.$email.'&otp='.$otp.'<br>';
                $msg .= 'This link will be valid for 10 minuts';
                
                $this->email->set_newline("\r\n");
                $this->email->from('info@fhp.com');
                $this->email->to($email);
                $this->email->subject('Password Reset');
                $this->email->message($msg);
                if ($this->email->send()) {
                	$success['success'] = "Email Sent! Check Mail";
                	$id = $this->main->check($this->table, array('email' => $email), 'id');
                	if ($id) {
						$this->main->update($id, array('email' => $email,'otp' => $otp,'valid' => $date), $this->table);
					}else{
						$this->main->add(array('email' => $email,'otp' => $otp,'valid' => $date), $this->table);
					}
                }else{
                	$success['error'] = "Email Not Sent, Try Again!";
                }
                $this->template->load('admin/log_template','admin/forgot', $success);
			}else{
				$error['error'] = "Mobile not exist, Check mobile!";
				$this->template->load('admin/log_template','admin/forgot', $error);	
			}
		}
	}

	public function check_otp()
	{
		if (isset($_GET['otp'])) {
			date_default_timezone_set('Asia/Kolkata');
			$d=strtotime("-10 minutes");
	        $data['valid'] = $this->main->get_where($this->table, 'email,valid', $_GET);
	        if ($data['valid']) {
	        	if (date("Y-m-d h:i:sa", $d) <= $data['valid']['valid']) {
	        		$this->template->load('admin/log_template','admin/generate_password', $data);
		        }else{
		        	$data['heading'] = "OTP Expired";
					$data['message'] = "Your OTP Has Been Expired! Request For New OTP";
					$this->template->load('admin/log_template','admin/password_generated', $data);
		        }
	        }else{
	        	error_404();
	        }
		}else{
			error_404();
		}
	}

	public function change()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			error_404();
		}else{
			$this->form_validation->set_rules('password', 'Password', 'required');
	        $this->form_validation->set_rules('c_password', 'Confirm Password', 'required|matches[password]');
			if ($this->form_validation->run() == FALSE)
			{	
				$data['valid'] = $this->input->post();
				$this->template->load('admin/log_template','admin/generate_password', $data);
			}
			else
			{
				$data = $this->input->post();
				$password = my_crypt($data['password']);
				$id = $this->main->check('users', array('email' => $data['email']), 'id');

				$data['heading'] = "Password Changed";
				$data['message'] = "Your Password Changed Successfully. Ligin With your new Password.";

				if ($id) {
					$this->main->update($id, array('password' => $password), 'users');

					$this->template->load('admin/log_template','admin/password_generated', $data);
				}else{
					$data['valid'] = $this->input->post();
					$data['error'] = "Something going wrong.. Try again.";
					$this->template->load('admin/log_template','admin/generate_password', $data);
				}
			}
		}
	}
}