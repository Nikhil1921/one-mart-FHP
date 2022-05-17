<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class BookingModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "bookings as b";  
    public $tab = "b";  
    public $join = array('cust_id' => 'customer as c');
	public $select_column = array('b.id','b.book_id','b.status','c.mobile','b.address');
	public $search_column = array('b.book_id','b.status'); 
    public $order_column = array(null,'b.book_id',null, null);
	public $order = array('b.id' => 'DESC');

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['b.is_delete'=>'no', 'b.status'=>$this->input->post('status')]);
            /*->where(['b.is_delete'=>'no','b.status'=>$this->input->post('status'),'b.for_vendor'=>$this->input->post('for_vendor'),'b.number_hide'=>$this->input->post('number_hide')]);*/

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