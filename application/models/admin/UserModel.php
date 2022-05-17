<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class UserModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	private $table = "users as u";  
	private $select_column = array('u.id', 'u.username','u.mobile','u.email','u.wallet','u.status','u.otp'); 
	private $search_column = array('u.username','u.mobile','u.email','u.status'); 
    private $order_column = array(null, 'u.username','u.mobile','u.email','u.wallet',null,null); 
	private $order = array('u.id' => 'DESC');  

	private function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table);
        if($this->input->post('status'))
        {
            $this->db->where('u.status', $this->input->post('status'));
        }

        $i = 0;
        foreach ($this->search_column as $item) 
        {
            if($_POST['search']['value']) 
            {
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->search_column) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}  

	public function make_datatables()
	{  
	   $this->make_query();  
	   if($_POST["length"] != -1)  
	   {  
	        $this->db->limit($_POST['length'], $_POST['start']);  
	   }  
	   $query = $this->db->get(); 
	   return $query->result();  
	}  

	public function get_filtered_data(){  
	   $this->make_query();  
	   $query = $this->db->get();  

	   return $query->num_rows();  
	}         
}