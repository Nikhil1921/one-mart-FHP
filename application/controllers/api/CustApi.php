<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CustApi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        // mobile();
    }

    private $table = 'customer';

    public function getQrDetails()
    {
        get();
        $api = authenticate($this->table);
        verifyRequiredParams(['vendor_id']);
        
        $post = ['id' => my_crypt($this->input->get('vendor_id'), 'd')];
        
        if($row = $this->main->get_where("users", 'username, email, mobile, CONCAT("'.images('users/').'", image) image', $post))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Vendor Details Successfull.";
            echoRespnse(200, $response);
        } 
        else
        {
            $response["error"] = TRUE;
            $response['message'] = "Vendor Details Not Found!";
            echoRespnse(400, $response);
        }
    }

    public function login()
    {
        post();
        verifyRequiredParams(['mobile']);
        $post['mobile'] = $this->input->post('mobile');
        $mob = $this->main->check('otp', $post, 'id');
        $post['otp'] = rand(1000,9999);
        
        /*$sms = urlencode("Dear Custmer, your fhp OTP is ".$post['otp'].". Please use this for login into your application. Always happy with Forever Happy People. Do not share this OTP with anyone.");*/
        $sms = "Your FHP registration OTP ".$post['otp'];
        send_sms($post['mobile'], $sms);


        if (!$mob) {
            $id = $this->main->add($post, 'otp');
        }else{
            $id = $this->main->update($mob, $post, 'otp');
        }

        if($id)
        {
            $response['error'] = FALSE;
            $response['message'] ="OTP Sent Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "OTP Sent Not Successfull!";
            echoRespnse(400, $response);
        }
    }

    public function check_otp()
    {
    	post();
    	verifyRequiredParams(['mobile', 'otp', 'token']);
        $post['mobile'] = $this->input->post('mobile');
    	$post['otp'] = $this->input->post('otp');
        $d=strtotime("-5 minutes");
        $otp = $this->main->get_where('otp', 'id,time', $post);
    	/*if ($otp && date("Y-m-d H:i:s", $d) <= $otp['time']) {*/
        if ($otp) {
    		$this->main->delete($otp['id'], 'otp');
    		unset($post['otp']);
            $post['is_delete'] = 'no';
    		$mob = $this->main->check($this->table, $post, 'id');
            $post['token'] = $this->input->post('token');

    		if ($mob) {
    			$id = $mob;
                $this->main->update($id, ['token' => $post['token']], $this->table);
    		}else{
    			$id = (string) $this->main->add($post, $this->table);	
    		}
    	}else{
    		$id = 0;
    	}
    	
    	if($id)
	    {
	    	$response['row'] = ['u_id'=>$id, 'mobile'=>$post['mobile']];
	        $response['error'] = FALSE;
	        $response['message'] ="OTP Validated Successfull.";
	        echoRespnse(200, $response);
	    } 
	    else 
	    {
	        $response["error"] = TRUE;
	        $response['message'] = "OTP Validated Not Successfull!";
	        echoRespnse(200, $response);
	    }
    }

    public function signup()
    {
    	post();
    	$api_key = authenticate($this->table);
    	verifyRequiredParams(['name','email']);
        $post['name'] = $this->input->post('name');
        $post['email'] = $this->input->post('email');
        
        $email = $this->main->get_where($this->table, 'id', ['email'=>$post['email'], 'id !=' => $api_key]);
        if ($email) {
            $response['row'] = "Email already in use.";
            $response["error"] = TRUE;
            $response['message'] = "Sign Up Not Successfull!";
            echoRespnse(400, $response);
        }else{
            if ($this->input->post('ref_code')) {
                $ref_id = $this->main->get_where($this->table, 'id, balance', ['ref_code' => $this->input->post('ref_code')]);
                if (!$ref_id) {
                    $response["error"] = TRUE;
                    $response['message'] = "Invalid Ref Code.";
                    echoRespnse(400, $response);
                }else{
                    $new = $ref_id['balance'] + 25;
                    $this->main->add(['ref_by' => $api_key, 'ref_user' => $ref_id['id'], 'ref_money' => 25], 'ref_payments');
                    $this->main->update($ref_id['id'], ['balance' => $new], $this->table);
                }
            }
            $this->load->helper('string');
            $post['ref_code'] = strtoupper(random_string('alnum', 10));
            $post['active'] = 1;
            
            $row = $this->main->update($api_key, $post, $this->table);
            if($row)
            {
                $response['row'] = $post;
                $response['error'] = FALSE;
                $response['message'] ="Sign Up Successfull.";
                echoRespnse(200, $response);
            } 
            else 
            {
                $response["error"] = TRUE;
                $response['message'] = "Sign Up Not Successfull!";
                echoRespnse(400, $response);
            }
        }
    }

    public function category_list()
    {
    	get();
    	$api_key = authenticate($this->table);

        $row = $this->main->getall('categories', 'id,cat_name,icon,for_vendor,number_hide,price',['is_delete'=>'no'], '', 'id ASC');
        if($row)
        {
            foreach ($row as $k => $v) {
                $row[$k]['icon'] = images('category/').$v['icon'];
            }
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Category List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Category List Not Successfull!";
            echoRespnse(400, $response);
        }    
    }

    public function allSubcategoryList()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->getall('subcategory', 'id subcatid, sub_cat subcatName, cat_id catId',['is_delete'=>'no'],'', 'id ASC');
        if($row)
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Sub Category List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Sub Category List Not Successfull!";
            echoRespnse(400, $response);
        }
    }

    public function inquiry_category_list()
    {
        get();
        $api_key = authenticate($this->table);

        $row = $this->main->getall('inquiry_category', 'id,cat_name,icon',['is_delete'=>'no'], '', 'id ASC');
        if($row)
        {
            foreach ($row as $k => $v) {
                $row[$k]['icon'] = images('inquiry_category/').$v['icon'];
            }
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Category List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Category List Not Successfull!";
            echoRespnse(400, $response);
        }    
    }

    public function banner_list()
    {
        get();
        $api_key = authenticate($this->table);

        $row = $this->main->getall('banner', 'banner');
        if($row)
        {
            foreach ($row as $k => $v) {
                $row[$k]['banner'] = images('banner/').$v['banner'];
            }
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Banner List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Banner List Not Successfull!";
            echoRespnse(400, $response);
        }    
    }

    public function membership_list()
    {
        get();
        $api_key = authenticate($this->table);
        
        if ($this->input->get('cat_id')) 
            $row = $this->main->membership_list($this->input->get('cat_id'));
        else
            $row = $this->main->getall('membership', 'id,plan,price,image,details, ser_id',['is_delete'=>'no','active'=>1]);

        if($row)
        {
            foreach ($row as $k => $v) {
                $row[$k]['image'] = base_url('assets/images/membership/').$v['image'];
                $ser = (array) json_decode($v['ser_id']);
                    
                if (is_array($ser)) 
                    foreach ($ser as $cat) 
                        foreach ($cat as $subcat) 
                            foreach ($subcat as $serv) 
                                $row[$k]['service'][] = $this->main->check('services', ['id' => $serv], 'name');
            }
            
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Membership List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Membership List Not Successfull!";
            echoRespnse(400, $response);
        }    
    }

    public function membership_self()
    {
        get();
        $api = authenticate($this->table);

        $row = $this->main->getall('membership_buy', 'expiry, buy_time, used_count, unused_count, status, price, service_id, transaction_id', ['user_id' => $api]);
        if($row)
        {
            foreach ($row as $k => $v) {
                $ser = explode(",", $v['service_id']);
                    
                foreach ($ser as $serv)
                    $row[$k]['service'][] = $this->main->check('services', ['id' => $serv], 'name');
                unset($row[$k]['service_id']);
            }
            
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Membership List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Membership List Not Successfull!";
            echoRespnse(400, $response);
        }    
    }

    public function sub_cat_list()
    {
    	post();
    	$api_key = authenticate($this->table);
    	verifyRequiredParams(['cat_id']);
    	$cat_id = $this->input->post('cat_id');
    	$row = $this->main->getall('subcategory', 'subcategory.id, sub_cat, subcategory.icon, cat_id, c.cat_name',['cat_id'=>$cat_id,'subcategory.is_delete'=>'no'],['cat_id'=>'categories as c'], 'id ASC');
    	if($row)
	    {
            $images = $this->main->check('categories', ['id' => $cat_id],'slider_images');
            if ($images == 'No Image') 
                $image = [];
            else
                foreach (json_decode($images) as $key => $value)
                    $image[$key]['img'] = base_url("assets/images/category/").$value;

	    	foreach ($row as $k => $v) 
	    		$row[$k]['icon'] = images('sub_category/').$v['icon'];
	    	
            $response['sliders'] = $image;
	        $response['row'] = $row;
	        $response['error'] = FALSE;
	        $response['message'] ="Sub Category List Successfull.";
	        echoRespnse(200, $response);
	    } 
	    else 
	    {
	        $response["error"] = TRUE;
	        $response['message'] = "Sub Category List Not Successfull!";
	        echoRespnse(400, $response);
	    }
    }

    public function inquiry_sub_cat_list()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['cat_id']);
        $cat_id = $this->input->post('cat_id');
        $row = $this->main->getall('inquiry_sub_category', 'inquiry_sub_category.id,inquiry_sub_category.icon, sub_cat, cat_id, c.cat_name',['cat_id'=>$cat_id,'inquiry_sub_category.is_delete'=>'no'],['cat_id'=>'inquiry_category as c'], 'id ASC');
        if($row)
        {
            $images = $this->main->check('inquiry_category', ['id' => $cat_id],'slider_images');
            if ($images == 'No Image') 
                $image = [];
            else
                foreach (json_decode($images) as $key => $value)
                    $image[$key]['img'] = base_url("assets/images/inquiry_category/").$value;

            foreach ($row as $k => $v)
                $row[$k]['icon'] = images('sub_inquiry_category/').$v['icon'];

            $response['sliders'] = $image;
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Sub Category List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Sub Category List Not Successfull!";
            echoRespnse(400, $response);
        }
    }

    public function service_list()
    {
    	post();
    	$api_key = authenticate($this->table);
    	verifyRequiredParams(['sub_cat_id']);
    	$sub_cat_id = $this->input->post('sub_cat_id');
    	$row = $this->main->getall('services', 'services.id, name, image, services.price, visiting_charge, description, sub_cat_id, sc.cat_id, c.cat_name, sc.sub_cat',['sub_cat_id'=>$sub_cat_id,'services.is_delete'=>'no'],['cat_id'=>'categories as c','sub_cat_id'=>'subcategory as sc'], 'id ASC');
    	if($row)
	    {
	    	foreach ($row as $k => $v) {
	    		$row[$k]['image'] = images('services/').$v['image'];	    	
            }
	        $response['row'] = $row;
	        $response['error'] = FALSE;
	        $response['message'] ="Service List Successfull.";
	        echoRespnse(200, $response);
	    } 
	    else 
	    {
	        $response["error"] = TRUE;
	        $response['message'] = "Service List Not Successfull!";
	        echoRespnse(400, $response);
	    }
    }

    public function inquiry_list()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['sub_cat_id']);
        $sub_cat_id = $this->input->post('sub_cat_id');
        $row = $this->main->getall('inquiry', 'inquiry.id,inquiry.image, name, description, conditions, sub_cat_id, sc.cat_id, c.cat_name, sc.sub_cat',['sub_cat_id'=>$sub_cat_id,'inquiry.is_delete'=>'no'],['cat_id'=>'inquiry_category as c','sub_cat_id'=>'inquiry_sub_category as sc'], 'id ASC');
        if($row)
        {   
            foreach ($row as $k => $v) {
                $row[$k]['image'] = images('services/').$v['image'];            
            }
            
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Inquiry List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Inquiry List Not Successfull!";
            echoRespnse(400, $response);
        }
    }

    public function inquiry()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['inquiry_id']);
        $inquiry_id = $this->input->post('inquiry_id');
        
        $row = $this->main->check('inquiry', ['id'=>$inquiry_id], 'conditions');
        if($row)
        {   
            $response['row'] =  (object) ['name' => explode(',', $row)];
            $response['error'] = FALSE;
            $response['message'] ="Inquiry List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Inquiry List Not Successfull!";
            echoRespnse(400, $response);
        }
    }

    public function profile()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->edit($api_key,$this->table,'name, mobile, email, home_address, office_address, other_address, balance, ref_code, active');
        if($row)
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Profile Successfull.";
            echoRespnse(200, $response);
        }
        else
        {
            $response["error"] = TRUE;
            $response['message'] = "Profile Not Successfull!";
            echoRespnse(400, $response);
        }
    }

    public function add_cart()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['service_id']);
        $ser_id = $this->input->post('service_id');
        $check = $this->main->check('cart', ['service_id' => $ser_id, 'user_id' => $api_key], 'id');
        if ($check) {
            $response['error'] = TRUE;
            $response['message'] ="Service Already in cart.";
            echoRespnse(200, $response);
        }else{
            $post = ['service_id' => $ser_id, 'user_id' => $api_key, 'qty' => 1];
            $row = $this->main->add($post, 'cart');    
        }
        
        if($row)
        {
            $response['row'] = $post;
            $response['error'] = FALSE;
            $response['message'] ="Service Added to cart.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Service not Added to cart";
            echoRespnse(400, $response);
        }  
    }

    public function update_cart()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['service_id', 'qty']);
        $ser_id = $this->input->post('service_id');
        $qty = $this->input->post('qty');
        $check = $this->main->check('cart', ['service_id' => $ser_id, 'user_id' => $api_key], 'id');
        if ($check) {
            $post = ['service_id' => $ser_id, 'user_id' => $api_key, 'qty' => $qty];
            $row = $this->main->update($check, $post, 'cart');
        }else{
            $response['error'] = TRUE;
            $response['message'] ="Service Not in cart.";
            echoRespnse(200, $response);
        }
        if($row)
        {
            $response['row'] = $post;
            $response['error'] = FALSE;
            $response['message'] ="Cart Updated.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Cart Not Updated";
            echoRespnse(400, $response);
        }  
    }

    public function delete_cart()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->delete_where(['user_id' => $api_key], 'cart');
        if($row)
        {
            $response['error'] = FALSE;
            $response['message'] ="Cart Deleted";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Cart Not Deleted";
            echoRespnse(400, $response);
        }  
    }

    public function delete_service()
    {
        get();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['service_id']);
        
        $row = $this->main->delete_where(['user_id' => $api_key, 'service_id' => $this->input->get('service_id')], 'cart');
        if($row)
        {
            $response['error'] = FALSE;
            $response['message'] ="Service Deleted";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Service Not Deleted";
            echoRespnse(400, $response);
        }  
    }

    public function service_time()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['cat_id']);
        $id = $this->input->post('cat_id');
        $row = $this->main->edit($id, 'categories', 'from_time, to_time');
        if($row)
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Timing List Successfull";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Timing List Not Successfull";
            echoRespnse(400, $response);
        }  
    }

    public function summary()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->getall('cart','service_id,qty',['user_id' => $api_key]);
        $total = 0;
        $visiting_charge = 0;
        
        $membership = $this->main->get_where('membership_buy', 'service_id', ["user_id" => $api_key, "expiry >=" => date('Y-m-d')]);
        foreach ($row as $k => $v) {
            $row[$k] = $v + $this->main->get_where('services', 'name,sub_cat,price,visiting_charge', ['services.id' => $v['service_id']], ['sub_cat_id' => 'subcategory']);
            
            if ($membership && strpos($membership['service_id'], $v['service_id']) !== false) {
                $total += $row[$k]['price'] * $row[$k]['qty'];
                $visiting_charge += 0;
                $row[$k]['membership'] = "true";
            }else{
                $total += $row[$k]['price'] * $row[$k]['qty'];
                $visiting_charge += $row[$k]['visiting_charge'];
                $row[$k]['membership'] = "false";
            }
        }

        if($row)
        {
            $response['row'] = $row;
            $bal = $this->main->check($this->table, ['id' => $api_key],'balance');
            $response['balance'] = (string) ceil($bal * 0.1);
            $response['service_charge'] = (string) $total;
            $response['visiting_charge'] = (string) $visiting_charge;
            $response['total'] = (string) ($visiting_charge + $total - ceil($bal * 0.1));
            $response['error'] = FALSE;
            $response['message'] ="Summary Successfull";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Summary Not Successfull";
            echoRespnse(400, $response);
        }  
    }

    public function select_address()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->get_where($this->table,'home_address, office_address, other_address',['id' => $api_key]);
        foreach ($row as $k => $v) {
            $row[$k] = json_decode($v);
        }
        if($row)
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Address List Successfull";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Address List Not Successfull";
            echoRespnse(400, $response);
        }  
    }

    public function add_address()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['address','lat','long','flat_no', 'add_type','name']);
        $add_type = $this->input->post('add_type');
        switch ($add_type) {
            case 'home':
                $post['home_address'] = json_encode(['address' => $this->input->post('address'),
                                         'lat' => $this->input->post('lat'),
                                         'long' => $this->input->post('long'),
                                         'flat_no' => $this->input->post('flat_no'),
                                         'phone' => (!empty($this->input->post('phone'))) ? $this->input->post('phone') : '',
                                         'name' => $this->input->post('name')]);
                break;
            case 'office':
                $post['office_address'] = json_encode(['address' => $this->input->post('address'),
                                         'lat' => $this->input->post('lat'),
                                         'long' => $this->input->post('long'),
                                         'flat_no' => $this->input->post('flat_no'),
                                         'phone' => (!empty($this->input->post('phone'))) ? $this->input->post('phone') : '',
                                         'name' => $this->input->post('name')]);
                break;
            default:
                $post['other_address'] = json_encode(['address' => $this->input->post('address'),
                                         'lat' => $this->input->post('lat'),
                                         'long' => $this->input->post('long'),
                                         'flat_no' => $this->input->post('flat_no'),
                                         'phone' => (!empty($this->input->post('phone'))) ? $this->input->post('phone') : '',
                                         'name' => $this->input->post('name')]);
                break;
        }
        
        $id = $this->main->update($api_key, $post, $this->table);
        if($id)
        {
            $response['error'] = FALSE;
            $response['message'] ="Address Updated Successfull";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Address Updated Not Successfull";
            echoRespnse(400, $response);
        }  
    }

    public function final_booking()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['add_type', 'payment_type', 'date_time', 'total_amount', 'time']);
        $payment_type = $this->input->post('payment_type');

        if ($payment_type == 'online') verifyRequiredParams(['transaction_id']);

        $ser_id = $this->main->getall('cart','service_id,qty,price,visiting_charge',['user_id' => $api_key],['service_id' => 'services']);
        
        foreach ($ser_id as $k => $v) {
            $for_vendor = $this->main->edit($v['service_id'], 'services', 'for_vendor,number_hide', ['cat_id' => 'categories as c']);
            $cat_id = $this->main->check('services',['id' => $v['service_id']],'cat_id');
            $membership = $this->main->get_where('membership_buy', 'service_id, id, unused_count, used_count', ["user_id" => $api_key, "expiry >=" => date('Y-m-d'), "unused_count >" => 0]);
            if ($membership && in_array($v['service_id'], explode(',', $membership['service_id']))) {
                $ser_id[$k]['visiting_charge'] = 'Membership';
                $ser_id[$k]['membership'] = ['Yes' => $membership['id']];
                $this->main->update($membership['id'], ['unused_count' => ($membership['unused_count'] - 1), 'used_count' => ($membership['used_count'] + 1)], 'membership_buy');
            }
            else{
                $ser_id[$k]['visiting_charge'] = $v['visiting_charge'];
                $ser_id[$k]['membership'] = ['No' => 0];
            }

            $ser_id[$k]['price'] = $v['price'];
        }
        
        $add_type = $this->input->post('add_type').'_address';
        $address = $this->main->check($this->table,['id' => $api_key], $add_type);
        $bal = $this->main->check($this->table, ['id' => $api_key], 'balance');

        $latlng = json_decode($address);
        $post = ['book_id' => rand(100000,999999),
                 'cust_id' => $api_key,
                 'ser_id' => json_encode($ser_id),
                 'payment_type' => $payment_type,
                 'address' => $address,
                 'lat' => $latlng->lat,
                 'lng' => $latlng->long,
                 'for_vendor' => $for_vendor['for_vendor'],
                 'number_hide' => $for_vendor['number_hide'],
                 'cat_id' => $cat_id,
                 'total_amount' => $this->input->post('total_amount'),
                 'date' => $this->input->post('date_time'),
                 'time' => $this->input->post('time'),
                 'otp' => rand(1000, 9999),
                 'bal_used' => ($bal > 0) ? 1 : 0
                ];

        if ($payment_type == 'online') $post['transaction_id'] = $this->input->post('transaction_id');
        /*switch ($payment_type) {
            case 'cod':
                $post = ['book_id' => rand(100000,999999),
                         'cust_id' => $api_key,
                         'ser_id' => json_encode($ser_id),
                         'payment_type' => $this->input->post('payment_type'),
                         'address' => $address,
                         'lat' => $latlng->lat,
                         'lng' => $latlng->long,
                         'for_vendor' => $for_vendor['for_vendor'],
                         'number_hide' => $for_vendor['number_hide'],
                         'cat_id' => $cat_id,
                         'total_amount' => $this->input->post('total_amount'),
                         'date' => $this->input->post('date_time'),
                         'time' => $this->input->post('time')];
                break;
            case 'online':
            verifyRequiredParams(['transaction_id']);
                $post = ['book_id' => rand(100000,999999),
                         'cust_id' => $api_key,
                         'ser_id' => json_encode($ser_id),
                         'payment_type' => $this->input->post('payment_type'),
                         'address' => $address,
                         'lat' => $latlng->lat,
                         'lng' => $latlng->long,
                         'for_vendor' => $for_vendor['for_vendor'],
                         'number_hide' => $for_vendor['number_hide'],
                         'cat_id' => $cat_id,
                         'total_amount' => $this->input->post('total_amount'),
                         'transaction_id' => $this->input->post('transaction_id'),
                         'date' => $this->input->post('date_time'),
                         'time' => $this->input->post('time')];
                break;
        }*/

        $id = $this->main->add($post, 'bookings');
        
        if($id)
        {
            $send = [];
            $select = 'token';
            $select .= ', (6371 * acos (cos ( radians('.$latlng->lat.') ) * cos( radians( lat ) ) 
                            * cos( radians( lng ) - radians('.$latlng->long.') ) + sin ( radians('.$latlng->lat.') )
                            * sin( radians( lat ) ) ) ) AS distance';
            
            $distance = ($for_vendor['for_vendor'] == 0 && $for_vendor['number_hide'] == 0) ? '' : true;
            
            foreach ($this->main->check_vendors('vendor v', '1-'.$cat_id, $select, $distance) as $token)
                $send[] = $token['token'];
            
            $url = "https://fcm.googleapis.com/fcm/send";
            $serverKey = 'AAAAZtpd9Bg:APA91bELFikpL19QJLydj4XSx97M62Ko7iL0xqWh9dqSDSlRDV8IbeZrHiiMlrZJktVDZGCoWt6ZzL7BYdpg6nepcnFR-11gVnct6rz65NHFEunnhv9L2sAp69lYexm6wcCfbwuqbQeG';
            $title = "FHP";
            $body = "Your New Request";
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => implode(', ', $send), 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_exec($ch);
            curl_close($ch);
            unset($arrayToSend);

            if($bal > 0){
                $new = $bal - ceil($bal * 0.1);
                $this->main->add(['ref_by' => $id, 'ref_user' => $api_key, 'ref_money' => ceil($bal * 0.1), 'ref_type' => 'Debit'], 'ref_payments');
                $this->main->update($api_key, ['balance' => $new], $this->table);
            }

            $this->main->delete_where(['user_id' => $api_key], 'cart');
            $response['error'] = FALSE;
            $response['message'] ="Booking Successfull";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Booking Not Successfull";
            echoRespnse(400, $response);
        }
    }

    public function booking_list()
    {
        get();
        $api_key = authenticate($this->table);
        
        $inquiry_select = 'inquiry_book.id, cust_id, book_id, ser_id as all, status, total_amount, from_date as date, from_time as time, to_date, to_time, inquiry_id, cat_id, assign';
        
        $inquiry_book = $this->main->getall('inquiry_book', $inquiry_select,['cust_id' => $api_key]);
        foreach ($inquiry_book as $k => $value) {
            $inquiry_book[$k]['type'] = 'enquiry';
            $inquiry_book[$k]['location'] = $this->main->get_where('vendor', 'lat, lng', ['u_id' => $value['assign']]);
        }
        $row = $this->main->getall('bookings','book_id,status, book_time, date,time, payment_type, total_amount, transaction_id, assign',['cust_id' => $api_key]);
        foreach ($row as $k => $value) {
            $row[$k]['type'] = 'service';
            $row[$k]['location'] = $this->main->get_where('vendor', 'lat, lng', ['u_id' => $value['assign']]);
        }
        $row = array_merge($row, $inquiry_book);
        
        if($row)
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Booking List Successfull";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Booking List Not Successfull";
            echoRespnse(400, $response);
        }  
    }

    public function inquiry_booking()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['total_amount','inquiry_id','cat_id']);
        $post['book_id'] = rand(100000, 999999);
        $post['cust_id'] = $api_key;
        $post['ser_id'] = $this->input->post('all');
        $post['total_amount'] = $this->input->post('total_amount');
        $post['from_date'] = $this->input->post('from_date');
        $post['from_time'] = $this->input->post('from_time');
        $post['to_date'] = $this->input->post('to_date');
        $post['to_time'] = $this->input->post('to_time');
        $post['inquiry_id'] = $this->input->post('inquiry_id');
        $post['add_type'] = $this->input->post('add_type');
        $post['cat_id'] = $this->input->post('cat_id');
        $post['otp'] = rand(1000, 9999);
        $post['cat_price'] = $this->main->check('inquiry_category', ['id' => $post['cat_id']], 'cat_price');
        $address = json_decode($this->main->check($this->table, ['id' => $api_key], $post['add_type'].'_address'));
        $post['address'] = $address->address;
        $post['lat'] = $address->lat;
        $post['lng'] = $address->long;
        
        $id = $this->main->add($post, 'inquiry_book');

        if($id)
        {
            $tokens = $this->main->check_vendors('vendor v', '2-'.$post['cat_id'], 'token');
            
            $send = []; foreach ($tokens as $token) $send[] = $token['token'];
            
            $url = "https://fcm.googleapis.com/fcm/send";
            $serverKey = 'AAAAZtpd9Bg:APA91bELFikpL19QJLydj4XSx97M62Ko7iL0xqWh9dqSDSlRDV8IbeZrHiiMlrZJktVDZGCoWt6ZzL7BYdpg6nepcnFR-11gVnct6rz65NHFEunnhv9L2sAp69lYexm6wcCfbwuqbQeG';
            $title = "FHP";
            $body = "Your New Request";
            $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => implode(', ', $send), 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            
            curl_exec($ch);
            curl_close($ch);
            unset($arrayToSend);
            
            $response['error'] = FALSE;
            $response['message'] ="Booking Successfull";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Booking Not Successfull";
            echoRespnse(400, $response);
        }  
    }

    public function booking_details()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['book_id','type']);
        $book_id = $this->input->post('book_id');
        $type = $this->input->post('type');
        if ($type == 'service') {
            $select = 'book_id,otp,date,time,total_amount,cust_id,ser_id as service, address,status, c.cat_name, assign';
            $row = $this->main->get_where('bookings',$select,['cust_id' => $api_key, 'book_id'=>$book_id],['cat_id'=>'categories c']);
            $row['service'] = json_decode($row['service']);
            foreach ($row['service'] as $k => $v) {
                $cat = $this->main->get_where('services','name,sub_cat',['services.id' => $v->service_id],['sub_cat_id'=>'subcategory sc']);
                $row['service'][$k]->service_name = $cat['name'];
            }
            $row['sub_cat'] = $cat['sub_cat'];
            $row['address'] = json_decode($row['address'])->address;
            $row['type'] = $type;
            if ($row['assign']) {
                $row['vendor'] = $this->main->check('users',['id' => $row['assign']],'username');
            }else{
                $row['vendor'] = "Not Assigned";
            }
        }else{
            $select = 'inquiry_book.id, cust_id, book_id,otp, ser_id as all, status, total_amount, from_date as date, from_time as time, to_date, to_time, inquiry_id, ic.cat_name, i.sub_cat_id sub_cat, assign';
            $row = $this->main->get_where('inquiry_book', $select,['cust_id' => $api_key, 'book_id'=>$book_id], ['inquiry_id'=>'inquiry i','cat_id'=>'inquiry_category ic']);
            $row['type'] = $type;
            $row['sub_cat'] = $this->main->check('inquiry_sub_category',['id' => $row['sub_cat']],'sub_cat');
            $row['service'][]['service_name'] = $this->main->check('inquiry',['id' => $row['inquiry_id']],'name');
            $row['address'] = "NA";
            if ($row['assign']) {
                $row['vendor'] = $this->main->check('users',['id' => $row['assign']],'username');
            }else{
                $row['vendor'] = "Not Assigned";
            }
        }

        if($row)
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Booking List Successfull";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Booking List Not Successfull";
            echoRespnse(400, $response);
        }  
    }

    public function membership_buy()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['membership_id','transaction_id']);
        $mem = $this->main->edit($this->input->post('membership_id'), 'membership', 'price,ser_id,time_period');
        foreach (json_decode($mem['ser_id']) as $key => $v) {
            foreach ($v as $key => $va) {
                foreach ($va as $key => $s) {
                       $ser_id[] = $s;
                   }   
            }
        }
        $data = [
                'membership_id'  => $this->input->post('membership_id'),
                'transaction_id' => $this->input->post('transaction_id'),
                'service_id' => implode(',', $ser_id),
                'price' => $mem['price'],
                'user_id' => $api_key,
                'employee' => 0,
                'expiry' => date("Y-m-d", strtotime($mem['time_period']." month")),
                'membership_type' => "customer",
                'unused_count' => $this->main->check('membership', ['id' =>$this->input->post('membership_id')], 'use_count'),
            ];
        $id = $this->main->add($data, 'membership_buy');

        if($id)
        {
            $response['error'] = FALSE;
            $response['message'] ="Membership Buy Successfull";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Membership Buy Not Successfull";
            echoRespnse(400, $response);
        }
    }

    public function feature_services()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->getall('services', 'sub_cat_id id, name, image', ["feature_service" => 1]);
        if($row)
        {
            foreach ($row as $k => $v) {
                $row[$k]['image'] = images('services/').$v['image'];
            }
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Featured Services List Successfull";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Featured Services List Not Successfull";
            echoRespnse(400, $response);
        }
    }

    public function main_banner()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->getall('services', 'sub_cat_id id, name, image', ["main_banner" => 1, 'is_delete' => 'No']);
        if($row)
        {
            foreach ($row as $k => $v) {
                $row[$k]['image'] = images('services/').$v['image'];
            }
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Main Banner Successfull";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Main Banner Not Successfull";
            echoRespnse(400, $response);
        }
    }

    public function feature_inquiry()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->getall('inquiry', 'sub_cat_id id, name, image', ["feature_service" => 1, "is_delete " => 0]);
        if($row)
        {
            foreach ($row as $k => $v) {
                if ($v['image']) {
                    $row[$k]['image'] = images('services/').$v['image'];
                }
            }
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Featured Inquiry List Successfull";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Featured Inquiry List Not Successfull";
            echoRespnse(400, $response);
        }
    }

    public function main_banner_inquiry()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->getall('inquiry', 'sub_cat_id id, name, image', ["main_banner" => 1]);
        if($row)
        {
            foreach ($row as $k => $v) {
                if ($v['image']) {
                    $row[$k]['image'] = images('services/').$v['image'];
                }
            }
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Main Inquiry Banner Successfull";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Main Inquiry Banner Not Successfull";
            echoRespnse(400, $response);
        }
    }

    public function wallet_history()
    {
        get();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['history_type']);
        
        if ($this->input->get('history_type') == 'Debit') 
            $row = $this->main->getall('ref_payments', 'b.book_id name, ref_money, ref_type', ["ref_user" => $api_key, 'ref_type' => 'Debit'], ['ref_by' => 'bookings b']);
        else
            $row = $this->main->getall('ref_payments', 'c.name, ref_money, ref_type', ["ref_user" => $api_key, 'ref_type' => 'Credit'], ['ref_by' => 'customer c']);
        
        if($row)
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Wallet History Successfull";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Wallet History Not Successfull";
            echoRespnse(400, $response);
        }
    }

    public function addCareer()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['name','mobile','email','qualification','apply_post','experience']);
        
        if (empty($_FILES['resume']['name'])) {
            verifyRequiredParams(['resume']);
        }else{
            $config = [
                'upload_path'      => "assets/images/carrers/",
                'allowed_types'    => 'png|jpg|jpeg|pdf',
                'file_name'        => time(),
                'file_ext_tolower' => TRUE
            ];

            $this->upload->initialize($config);

            if (!$this->upload->do_upload("resume")) {
                $response["error"] = TRUE;
                $response['message'] = $this->upload->display_errors();
                echoRespnse(400, $response);
            }else{
                $post['name'] = str_replace('"', '', $this->input->post('name'));
                $post['mobile'] = str_replace('"', '', $this->input->post('mobile'));
                $post['email'] = str_replace('"', '', $this->input->post('email'));
                $post['qualification'] = str_replace('"', '', $this->input->post('qualification'));
                $post['apply_post'] = str_replace('"', '', $this->input->post('apply_post'));
                $post['experience'] = str_replace('"', '', $this->input->post('experience'));
                $post['resume'] = $this->upload->data('file_name');
                $post['upload_by'] = $api_key;
                
                if($this->main->add($post, 'careers'))
                {
                    $response['error'] = FALSE;
                    $response['message'] ="Carrer Upload Successfull.";
                    echoRespnse(200, $response);
                }
                else
                {
                    $response["error"] = TRUE;
                    $response['message'] = "Carrer Upload Not Successfull!";
                    echoRespnse(400, $response);
                }
            }
        }
    }
}