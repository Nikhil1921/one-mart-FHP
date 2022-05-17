<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "profile";
    private $table = "users";
    private $icon = 'fa-user';
    private $redirect = 'admin/';

    public $validate = [
            [
                'field' => 'username',
                'label' => 'User Name',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'c_password',
                'label' => 'Confirm Password',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
    ];
    
    public function index()
    {
        $data['name'] = $this->name;
        $data['icon'] = $this->icon;
        
        $id = $this->session->userdata('id');

        $select = "id,username,image,mobile,email";
        $data['prof'] = $this->main->edit($id, $this->table, $select);

        $this->template->load('admin/template','admin/profile/profile', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules($this->validate);
        if ($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $post = $this->input->post();
            unset($post['c_password']);
            $post['password'] = my_crypt($post['password']);
            if(empty($_FILES["image"]["name"]))  
            {   
                $id = $this->main->update($id, $post, $this->table);
                
                if($id > 0){
                    $this->session->set_tempdata('success', "Profile Updated", 2);
                }else{
                    $this->session->set_tempdata('error', "Profile Not Updated", 2);
                } 
                unset($post['password']);
                $this->session->set_userdata($post);
                return redirect($this->redirect);
            }else{
                $config['upload_path']= "assets/images/users/";
                $config['allowed_types']='gif|jpg|png|jpeg';
                $config['file_name'] = strtolower(str_replace(' ','_', $post['username']));
                $config['file_ext_tolower'] = TRUE;
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);
                
                if (!$this->upload->do_upload("image")) {
                    $this->index();
                }else{
                    $data = $this->upload->data();
                    $post['image'] = $data["file_name"];
                    $id = $this->main->update($id, $post, $this->table);

                    if($id){
                     $this->session->set_tempdata('success', "Profile Updated", 2);
                    }else{
                     $this->session->set_tempdata('error', "Profile Not Updated", 2);
                    } 
                    unset($post['password']);
                    $this->session->set_userdata($post);
                    return redirect($this->redirect);
                }
            }
        }
    }
}