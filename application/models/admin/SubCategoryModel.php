<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class SubCategoryModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "subcategory as sc";  
    public $tab = "sc";  
    public $join = array('cat_id' => 'categories as c');
	public $select_column = array('sc.id','sc.sub_cat','sc.icon','c.cat_name');
	public $search_column = array('sc.sub_cat','c.cat_name'); 
    public $order_column = array(null,'sc.sub_cat','c.cat_name',null, null); 
	public $order = array('sc.id' => 'DESC');

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['sc.is_delete'=>'no']);

        foreach ($this->join as $i => $t) {
            $this->db->join($t, $t.'.id = '.$this->tab.'.'.$i) ;    
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
}