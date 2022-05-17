<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// auth();
	}

	private $name = 'dashboard';
	private $icon = 'fa-home';

	public function index()
	{		
		$this->load->view('front/index');
	}

	public function error()
	{	
		error_404();
	}	
}