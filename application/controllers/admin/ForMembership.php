<?php 

/**
 * 
 */
class ForMembership extends CI_Controller
{
	
	public function __construct()
    {
        parent::__construct();
        auth();
    }

    private $name = "membership-promo";
    private $table = "membership_promo";
    private $icon = 'fa-ticket';
    private $redirect = 'admin/forMembership';

    public $validate = [
            [
                'field' => 'code',
                'label' => 'Promo Code',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'discount',
                'label' => 'Promo Code Discount',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'mem_id[]',
                'label' => 'Select Atleast one membership plan',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s",
                ],
            ],
            [
                'field' => 'details',
                'label' => 'Promo Details',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'active',
                'label' => 'Promo Activation',
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

            $this->template->load('admin/template','admin/for_member/index', $data);
        }else{
            error_404();
        }
    }

    public function get()
    {
        if (access($this->name,'list')) {
            $fetch_data = $this->main->make_datatables('admin/ForMemberModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)  
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->code;
                $sub_array[] = $row->discount;

                if ($row->active == 1) {
                    $active = '<form class="table_block" action="'.base_url('admin/forMembership/deactive').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="block btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-check-square-o"></button></form>';
                }else{
                    $active = '<form class="table_block" action="'.base_url('admin/forMembership/active').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="unblock btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-times"></button></form>';
                }
                
                $sub_array[] = '
                <a href="'.base_url('admin/forMembership/view/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>
                <a href="'.base_url('admin/forMembership/update/').$row->id.'" class="btn waves-effect waves-dark btn-primary btn-outline-primary btn-icon fa fa-pencil"></a>
                <form class="table_form" action="'.base_url('admin/forMembership/delete').'" method="POST" ><input type="hidden" name="id" value="'.$row->id.'"><button class="delete btn waves-effect waves-dark btn-danger btn-outline-danger btn-icon fa fa-trash"></button>
                </form>'.$active;  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/ForMemberModel'),  
                "data"              =>     $data  
            );  

            echo json_encode($output);
        }else{
            error_404();
        }
	}

    public function view($id)
    {
        if (access($this->name,'view')) {
            $data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['promo'] = $this->main->edit($id, $this->table, 'id, code, details, mem_id, discount, active');

            $this->template->load('admin/template','admin/for_member/view', $data);
        }else{
            error_404();
        }
    }

    public function add()
    {   
        if (access($this->name,'add')) {
        	$data['name'] = $this->name;
            $data['icon'] = $this->icon;
            $data['member'] = $this->main->getall('membership', 'plan, id');
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/for_member/add', $data);
            }else{
                    $post = $this->input->post();
                    $post['mem_id'] = implode(',', $post['mem_id']);
                    
                    $id = $this->main->add($post, $this->table);
                    flashMsg(
                    $id, ucwords($this->name).' Added Successfully.', ucwords($this->name).' Not Added, Please Try Again.', $this->redirect
                    );
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
            $data['promo'] = $this->main->edit($id, $this->table, 'id, code, details, mem_id, discount, active');

            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE) {
                $this->template->load('admin/template','admin/for_member/update', $data);
            }else{

                $post = $this->input->post();  
                $post['mem_id'] = implode(',', $post['mem_id']);
                $id = $this->main->update($id, $post, $this->table);
                flashMsg(
                    $id, ucwords($this->name).' Updated Successfully.', ucwords($this->name).' Not Updated, Please Try Again.', $this->redirect
                );     
            }
        }else{
            error_404();
        }
    }

    public function delete()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');
            $id = $this->main->update($id, array('is_delete' => 'yes') ,$this->table);
            
            flashMsg(
                        $id, ucwords($this->name).' Deleted Successfully.', ucwords($this->name).' Not Deleted, Please Try Again.', $this->redirect
                        );
        }else{
            error_404();
        }
    }

    public function active()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');
            $id = $this->main->update($id, array('active' => '1') ,$this->table);
            
            flashMsg(
                        $id, ucwords($this->name).' Activated Successfully.', ucwords($this->name).' Not Activated, Please Try Again.', $this->redirect
                        );
        }else{
            error_404();
        }
    }

    public function deactive()
    {
        if (access($this->name,'delete')) {
            $id = $this->input->post('id');
            $id = $this->main->update($id, array('active' => '0') ,$this->table);
            
            flashMsg(
                        $id, ucwords($this->name).' De-activated Successfully.', ucwords($this->name).' Not De-activated, Please Try Again.', $this->redirect
                        );
        }else{
            error_404();
        }
    }
}