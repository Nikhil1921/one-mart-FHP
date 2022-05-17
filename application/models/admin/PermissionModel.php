<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class PermissionModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "permissions as p";  
	public $select_column = array('p.id', 'p.name', 'p.sub_menu', 'p.priority'); 
	public $search_column = array('p.name', 'p.sub_menu'); 
    public $order_column = array(null, 'p.name' ,null, 'p.priority',null); 
	public $order = array('p.priority' => 'ASC');  

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table);
        $i = 0;

        /*if($this->input->post('status'))
        {
            $this->db->where('u.status', $this->input->post('status'));
        }*/

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