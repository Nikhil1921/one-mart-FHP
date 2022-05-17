<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class VendorModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "vendor as v";  
    public $tab = "v";
    public $join = array('u_id' => 'users as u');
	public $select_column = array('u.id', 'u.username as name', 'u.com_name', 'u.image', 'u.mobile', 'u.email', 'v.gst', 'v.gst_image', 'v.balance', 'u.is_blocked');
	public $search_column = array('u.id', 'u.username', 'u.com_name', 'u.mobile', 'u.email', 'v.gst'); 
    public $order_column = array(null, 'u.username', 'u.com_name', 'v.balance', 'u.mobile', 'u.email', 'v.gst', null); 
	public $order = array('v.id' => 'DESC');

	public function make_query()  
	{  
        $this->db->select($this->select_column)
            ->from($this->table)
            ->where(['u.is_delete'=>'no','u.is_blocked'=>$this->input->post('status')]);

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

    public function addVendor($table, $image)
    {
        $post = [
            'username' => $this->input->post('username'),
            'password' => my_crypt($this->input->post('password')),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'role' => 'vendor',
            'image' => $image,
            'com_name' => $this->input->post('com_name')
        ];

        $this->db->trans_start();
        $this->db->insert('users', $post);
        $user = [
            'address' => $this->input->post('address'),
            'area' => $this->input->post('sublocality'),
            'city' => $this->input->post('locality'),
            'state' => $this->input->post('administrative_area_level_1'),
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
            'cat_id' => implode(',', $this->input->post('cat_id')),
            'gst' => "No GST",
            'gst_image' => "No Image",
            'photo' => "No Photo",
            'photo_image' => "No Image",
            'u_id' => $this->db->insert_id()
        ];
        $this->db->insert($table, $user);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE && file_exists("assets/images/users/$image"))
            unlink("assets/images/users/$image");

        return $this->db->trans_status();
    }
}