<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth();
	}

	private $name = 'orders';
	private $icon = 'fa-home';
	private $table = 'bookings';

	public function index()
	{		
		if (access($this->name,'index')) {
			$data['name'] = $this->name;
			$data['icon'] = $this->icon;
            
			$this->template->load('admin/template','admin/orders/index', $data);
		}else{
            error_404();
        }
	}

	public function get()
    {
        if (access($this->name,'index')) {
            $fetch_data = $this->main->make_datatables('admin/BookingModel');
    		$sr = $_POST['start'] + 1;
            $data = array();  

            foreach($fetch_data as $row)
            {  
                $sub_array = array();  
                $sub_array[] = $sr;
                $sub_array[] = $row->book_id;
                $sub_array[] = $row->mobile;
                $sub_array[] = ucwords($row->status);

                $sub_array[] = '
                <a href="'.base_url('admin/orders/view-order/').$row->id.'" class="btn waves-effect waves-dark btn-success btn-outline-success btn-icon fa fa-eye"></a>';  

                $data[] = $sub_array;  
                $sr++;
        	}

        	$output = array(  
                "draw"              =>     intval($_POST["draw"]),  
                "recordsTotal"      =>     $this->main->all($this->table),  
                "recordsFiltered"   =>     $this->main->get_filtered_data('admin/BookingModel'),  
                "data"              =>     $data  
            );  

            echo json_encode($output);
        }else{
            error_404();
        }
	}

    public function view_order($id)
    {   
        $data['name'] = 'orders';
        $data['icon'] = 'fa fa-file-text-o';

        $data['book'] = $this->main->edit($id, $this->table, "$this->table.id, book_id, status, address, book_time,c.name,c.mobile,c.email,ser_id as services,total_amount,transaction_id",['cust_id'=>'customer as c']);
        
        $this->template->load('admin/template','admin/orders/view_other', $data);
    }
}