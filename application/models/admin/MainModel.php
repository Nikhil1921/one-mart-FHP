<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class MainModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add($post, $table)
	{
		$this->db->insert($table, $post);
		return $this->db->insert_id();
	}

	public function update($id, $post, $table)
	{
		return $this->db->where('id', $id)->update($table, $post);
	}

	public function update_where($id, $post, $table)
	{
		return $this->db->where($id)->update($table, $post);
	}

	public function get_where($table, $select, $where, $joins = '')
	{
		$this->db->select($select);
		if (is_array($joins)) {
			foreach ($joins as $key => $join) {
				$this->db->join($join, $join.'.id = '.$table.'.'.$key);
			}
		}
		
		return $this->db->where($where)->from($table)->get()->row_array();
	}

	public function edit($id, $table, $select, $joins = '')
	{
		$this->db->select($select);
		if (is_array($joins)) {
			foreach ($joins as $key => $join) {
				$this->db->join($join, $join.'.id = '.$table.'.'.$key);
			}
		}

		return $this->db->where($table.'.id',$id)->from($table)->get()->row_array();
	}

	public function delete($id, $table)
	{
		return $this->db->delete($table, ['id' => $id]);
	}

	public function delete_where($where, $table)
	{
		return $this->db->delete($table, $where);
	}

	public function all($table)  
	{  
	   return $this->db->count_all($table);
	}

	public function check($table, $where, $select)  
	{
		$id = $this->db->select($select)->where($where)->from($table)->get()->row_array();
		if ($id) {
			return $id[$select];
		}else{
			return false;
		}
	}

	public function check_like($table, $like, $select)
	{
		$i = 0;
		$this->db->select($select);
        foreach ($like as $item => $value)
        {
            if($value) 
            {
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $value);
                }
                else
                {
                    $this->db->or_like($item, $value);
                }
 
                if(count($like) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
		$select = $this->db->from($table)->get()->row_array();
		return $select;
	}

	public function check_vendors($table, $like, $select, $distance='')
	{
		$this->db->select($select);
        $this->db->where(['v.is_delete' => 'no', 'u.is_blocked' => 'no', 'v.token != ' => '']);
		
		if($distance) $this->db->having(['distance <= ' => 5]);
		
        $this->db->join('users u', 'u.id = v.id');
        $this->db->group_start();
        $this->db->like('cat_id', $like);
        $this->db->group_end();
		
		return $this->db->from($table)->get()->result_array();
	}

	public function count($table, $where, $group = "")
	{
		if ($group != '') {
			$this->db->group_by($group);
		}
		return $this->db->get_where($table, $where)->num_rows();
	}

	public function getall($table, $select, $where= '', $joins = '', $order_by = '', $not_in = '', $limit = '')
	{  
		$this->db->select($select);

		if ($where != '') {
			$this->db->where($where);
		}

		if ($not_in != '') {
			$not_in;
		}

		if ($order_by != '') {
			$this->db->order_by($order_by);
		}		
		
		if (is_array($joins)) {
			foreach ($joins as $key => $join) {
				$this->db->join($join, $join.'.id = '.$table.'.'.$key);
			}
		}
		if ($limit != '') {
			$this->db->limit($limit);
		}
	    return $this->db->order_by($table.'.id', 'DESC')->get($table)->result_array();
	}

	public function make_datatables($model)
	{  
	   $this->load->model($model, 'model');			
	   $this->model->make_query();  
	   if($_POST["length"] != -1)  
	   {  
	        $this->db->limit($_POST['length'], $_POST['start']);  
	   }  
	   $query = $this->db->get();
	   
	   return $query->result();  
	}  

	public function get_filtered_data($model){  
	   $this->load->model($model, 'model');			
	   $this->model->make_query();  
	   $query = $this->db->get();  

	   return $query->num_rows();  
	}

	public function membership_list($cat_id){  
	   
	   return $this->db->select('id, plan, price, image, details, ser_id')->from('membership')
	   					->where(['is_delete'=>'no','active'=>1])
	   					->group_start()
	   					->like('ser_id', '"'.$cat_id.'"')
	   					->group_end()
	   					->get()
	   					->result_array();
	}

	public function booking_list($cat_id, $lat, $lng, $api)
	{
		$api = $this->input->get('order_status') == 'pending' ? 0 : $api;
		$distance = '(6371 * acos (cos ( radians('.$lat.') ) * cos( radians( lat ) ) 
                            * cos( radians( lng ) - radians('.$lng.') ) + sin ( radians('.$lat.') )
                            * sin( radians( lat ) ) ) ) AS distance';
		$select = 'b.id, book_id, date, time, cat_id, total_amount, cust_id, ser_id as service, address, status, name, email, mobile, for_vendor, number_hide, '.$distance;
		$bookings = $this->db->select($select)
							 ->from('bookings b')
							 ->where(['c.is_delete'=>'no', 'b.assign' => $api])
							 ->where_in('cat_id', $cat_id)
							 ->where(['b.status' => $this->input->get('order_status')])
							 ->join('customer c', 'c.id = b.cust_id')
							 ->get()
							 ->result_array();
	   	
		$return = [];
		
		foreach ($bookings as $arr) {
			$book = [
				'id'           => $arr['id'],
				'book_id'      => $arr['book_id'],
				'date'         => $arr['date'],
				'time'         => $arr['time'],
				'total_amount' => $arr['total_amount'],
				'cust_id' 	   => $arr['cust_id'],
				'address' 	   => json_decode($arr['address'])->address,
				'status' 	   => $arr['status'],
				'name' 		   => $arr['name'],
				'email' 	   => $arr['email'],
				'mobile' 	   => $arr['mobile'],
				'order_type'   => 'service',
			];

			foreach (json_decode($arr['service']) as $v)
				$book['service'][] = $this->main->check('services', ['id'=>$v->service_id], 'name');
			if($arr['for_vendor'] == 0 && $arr['number_hide'] == 0):
				$return[] = $book;
			else:
				if($arr['distance'] <= 10){
				    
					if($arr['for_vendor'] == 1 && $arr['number_hide'] == 1)
						$book['price'] = $this->main->check('categories', ['id' => $arr['cat_id']], 'price');
					
					$return[] = $book;
				}
			endif;
		}
        
		return $return;
	}

	public function inquiry_list($cat_id, $lat, $lng, $api)
	{
		$api = $this->input->get('order_status') == 'pending' ? 0 : $api;
		
		$select = 'b.id, cust_id, book_id, ser_id as all, status, total_amount, from_date as date, from_time as time, to_date, to_time, inquiry_id, cat_price, address, name, email, mobile';
		$return = [];
		
		$bookings = $this->db->select($select)
						->from('inquiry_book b')
	   					->where(['c.is_delete' => 'no', 'assign' => $api])
						->where_in('cat_id', $cat_id)
						->where(['b.status' => $this->input->get('order_status')])
	   					->join('customer c', 'c.id = b.cust_id')
	   					->get()
	   					->result_array();

		foreach ($bookings as $arr) {
			$all = $arr['all'];
			$all = str_replace("[", "", $all);
			$all = str_replace("]", "", $all);
			$all = str_replace(" ", "", $all);
			$all = explode(',', $all);
			$book = [
				'id'           => $arr['id'],
				'book_id'      => $arr['book_id'],
				'all'      	   => $all,
				'date'         => $arr['date'],
				'time'         => $arr['time'],
				'to_date'      => $arr['to_date'],
				'to_time'      => $arr['to_time'],
				'total_amount' => $arr['total_amount'],
				'cust_id' 	   => $arr['cust_id'],
				'address' 	   => $arr['address'],
				'status' 	   => $arr['status'],
				'price'        => $arr['cat_price'],
				'name' 		   => $arr['name'],
				'email' 	   => $arr['email'],
				'mobile' 	   => $arr['mobile'],
				'service' 	   => [$this->main->check('inquiry', ['id'=>$arr['inquiry_id']], 'name')],
				'order_type'   => 'enquiry',
			];
			
			$return[] = $book;
		}
		
		return $return;
	}
}