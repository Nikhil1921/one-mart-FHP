<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class ForMemberModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "membership_promo as fm";  
    public $tab = "fm";  
    public $join = array('mem_id' => 'membership as m');
	public $select_column = array('fm.id','fm.code','fm.discount','m.plan','fm.active');
	public $search_column = array('fm.code','m.plan'); 
    public $order_column = array(null,'fm.code','m.plan',null, null); 
	public $order = array('fm.id' => 'DESC');

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['fm.is_delete' => 'no', 'fm.active' => $this->input->post('status')]);

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