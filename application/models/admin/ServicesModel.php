<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class ServicesModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "services as s";  
    public $tab = "s";  
    public $join = array('cat_id' => 'categories as c','sub_cat_id' => 'subcategory as sc');
	public $select_column = array('s.id','s.name','s.image','s.price','s.visiting_charge','sc.sub_cat','c.cat_name','main_banner','feature_service');
	public $search_column = array('s.id','s.name','s.image','s.price','s.visiting_charge','sc.sub_cat','c.cat_name');
    public $order_column = array(null,'s.name','s.price','s.visiting_charge','sc.sub_cat','c.cat_name',null,null);
	public $order = array('s.id' => 'DESC');

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['s.is_delete'=>'no']);

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