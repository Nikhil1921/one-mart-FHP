<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class BannerModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "banner as b";  
	public $select_column = array('b.id','b.banner');
	public $search_column = array('b.id','b.banner');
    public $order_column = array(null,null, null);
	public $order = array('b.id' => 'DESC'); 

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