<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class CustomerModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "customer as c";  
	public $select_column = array('c.id', 'c.name', 'c.active', 'c.mobile', 'c.email', 'c.balance');
	public $search_column = array('c.name', 'c.active', 'c.mobile', 'c.email', 'c.balance');
    public $order_column = array(null, 'c.name', 'c.mobile', 'c.email', 'c.balance', null);
	public $order = array('c.id' => 'DESC'); 

	public function make_query()
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['c.is_delete' => 'no', 'c.active' => $this->input->post('status')]);
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
}