<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class OperationModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "operations as o";  
	public $select_column = array('o.id','o.type'); 
	public $search_column = array('o.type'); 
    public $order_column = array(null,'o.type',null); 
	public $order = array('o.id' => 'ASC');  

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table);
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