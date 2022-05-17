<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Endroid\QrCode\QrCode;

class VendorApi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        // mobile();
    }

    private $table = 'users';

    public function getQrCode()
    {
        get();
        verifyRequiredParams(['vendor_id']);
        $qrCode = new QrCode(my_crypt($this->input->get('vendor_id')));
        header('Content-Type: '.$qrCode->getContentType());
        echo $qrCode->writeString();
        exit;
    }

    public function login()
    {
    	post();
    	verifyRequiredParams(['mobile', 'password', 'token']);
    	$post['mobile'] = $this->input->post('mobile');
        $post['password'] = my_crypt($this->input->post('password'));
        // $post['is_blocked'] = 'no';
        $post['is_delete'] = 'no';
        $post['role'] = 'vendor';
        $row = $this->main->get_where($this->table, 'id, username, email, mobile, vendor_type, image, is_blocked', $post);

    	if($row)
	    {
            $token = $this->input->post('token');
            $this->main->update_where(['u_id' => $row['id']], ['token' => $token], 'vendor');
            $row['image'] = base_url('assets/images/users/'.$row['image']);
	        $response['row'] = $row;
            $response['error'] = FALSE;
	        $response['message'] ="Login Successfull.";
	        echoRespnse(200, $response);
	    }
	    else 
	    {
	        $response["error"] = TRUE;
	        $response['message'] = "Login Not Successfull! Please contact to admin for account activation";
	        echoRespnse(400, $response);
	    }
    }

    public function send_otp()
    {
        post();
        verifyRequiredParams(['mobile']);
        $post['mobile'] = $this->input->post('mobile');
        /*$check = $this->main->check($this->table, $post, 'id');

        if($check)
        {
            $response["error"] = TRUE;
            $response['message'] ="Mobile already exist.";
            echoRespnse(400, $response);
        } 
        else 
        {*/
            $mob = $this->main->check('otp', $post, 'id');
            $post['otp'] = rand(1000, 9999);
            
            if (!$mob) {
                $id = $this->main->add($post, 'otp');
            }else{
                $id = $this->main->update($mob, $post, 'otp');
            }

            if($id)
            {
                /*$sms = urlencode("Dear Vendor, your fhp OTP is ".$post['otp'].". Please use this for login into your application. Always happy with Forever Happy People. Do not share this OTP with anyone.");*/
                $sms = "Your FHP registration OTP ".$post['otp'];
                send_sms($post['mobile'], $sms);
                
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
        // }
    }

    public function check_otp()
    {
    	post();
    	verifyRequiredParams(['mobile','otp']);
        $post['mobile'] = $this->input->post('mobile');
    	$post['otp'] = $this->input->post('otp');
        $d=strtotime("-5 minutes");
        $otp = $this->main->get_where('otp', 'id,time', $post);
        
    	/*if (date("Y-m-d H:i:s", $d) <= $otp['time']) {*/
        if ($otp) {
    		$this->main->delete($otp['id'], 'otp');
    		unset($post['otp']);
            $post['role'] = 'vendor';
    		$mob = $this->main->check($this->table, $post, 'id');
            $post['is_delete'] = 'no';
            $post['is_blocked'] = 'yes';
    		if ($mob) {
    			$id = $mob;
    		}else{
    			$id = (string) $this->main->add($post, $this->table);
    		}
    	}else{
    		$id = 0;
    	}
    	
    	if($id)
	    {
	    	$response['row'] = ['u_id'=>$id,'mobile'=>$post['mobile']];
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

    public function category_list()
    {
        get();
        
        $cat = $this->main->getall('categories', 'CONCAT("1-", id) id,cat_name', "is_delete = 'no' AND (for_vendor != 0 OR number_hide != 0)");
        
        $enquiry = $this->main->getall('inquiry_category', 'CONCAT("2-", id) id,cat_name',['is_delete'=>'no']);
        
        $row = array_merge($cat, $enquiry);
        
        if($row)
        {
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

    public function signup()
    {
    	post();
    	$api_key = authenticate($this->table);
    	verifyRequiredParams(['username', 'password', 'email', 'cat_id', 'address', 'lat', 'lng', 'area', 'city', 'state']);
        $post['username'] = str_replace('"', "", $this->input->post('username'));
        $post['password'] = my_crypt(str_replace('"', "", $this->input->post('password')));
        $post['email'] = str_replace('"', "", $this->input->post('email'));
        $vendor['cat_id'] =  str_replace('"', "", $this->input->post('cat_id'));
        $vendor['cat_id'] = str_replace('[', "", $vendor['cat_id']);
        $vendor['cat_id'] = str_replace(']', "", $vendor['cat_id']);
        $vendor['cat_id'] = str_replace('', "", $vendor['cat_id']);
        $vendor['address'] = str_replace('"', "", $this->input->post('address'));
        $vendor['lat'] = str_replace('"', "", $this->input->post('lat'));
        $vendor['lng'] = str_replace('"', "", $this->input->post('lng'));
        $vendor['area'] = str_replace('"', "", $this->input->post('area'));
        $vendor['city'] = str_replace('"', "", $this->input->post('city'));
        $vendor['state'] = str_replace('"', "", $this->input->post('state'));
        $vendor['u_id'] = $api_key;

        $email = $this->main->get_where($this->table, 'id', ['email'=>$post['email'], 'id !='=>$api_key]);
        if ($email) {
            $response['row'] = "Email already in use.";
            $response["error"] = TRUE;
            $response['message'] = "Sign Up Not Successfull!";
            echoRespnse(400, $response);
        }else{
            if (isset($_FILES['image']['name'])) {
                // $vendor['gst'] = $this->input->post('gst');
                $config['upload_path']= "assets/images/users/";
                $config['allowed_types']='jpg|jpeg|png';
                $config['file_name'] = rand(100000, 999999);
                $config['file_ext_tolower'] = TRUE;
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload("image")) {
                    $response['row'] = "Image not valid. Only png, jpg or jpeg allowed.";
                    $response["error"] = TRUE;
                    $response['message'] = "Sign Up Not Successfull!";
                    echoRespnse(400, $response);
                }else{
                    $data = $this->upload->data();
                    $post['image'] = $data["file_name"];
                }
            }else{
                verifyRequiredParams(['image']);
            }
            
            /* if (isset($_FILES['gst_image']['name'])) {
                verifyRequiredParams(['gst']);
                $vendor['gst'] = str_replace('"', "", $this->input->post('gst'));
                $config['upload_path']= "assets/images/gst/";
                $config['allowed_types']='jpg|jpeg|png';
                $config['file_name'] = strtolower(str_replace(' ','_', $vendor['gst']));
                $config['file_ext_tolower'] = TRUE;
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload("gst_image")) {
                    $response['row'] = "Image not valid. Only jpg or jpeg allowed.";
                    $response["error"] = TRUE;
                    $response['message'] = "Sign Up Not Successfull!";
                    echoRespnse(400, $response);
                }else{
                    $data = $this->upload->data();
                    $vendor['gst_image'] = $data["file_name"];
                }
            }else{
                $vendor['gst'] = "No GST";
                $vendor['gst_image'] = "No Image";
            } */

            /* if (isset($_FILES['photo_image']['name'])) {
                verifyRequiredParams(['photo']);
                $vendor['photo'] = str_replace('"', "", $this->input->post('photo'));
                $config['upload_path']= "assets/images/photo/";
                $config['allowed_types']='jpg|jpeg|png';
                $config['file_name'] = strtolower(str_replace(' ','_', $vendor['photo']));
                $config['file_ext_tolower'] = TRUE;
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload("photo_image")) {
                    $response['row'] = "Image not valid. Only jpg or jpeg allowed.";
                    $response["error"] = TRUE;
                    $response['message'] = "Sign Up Not Successfull!";
                    echoRespnse(400, $response);
                }else{
                    $data = $this->upload->data();
                    $vendor['photo_image'] = $data["file_name"];
                }
            }else{
                $vendor['photo'] = "No Photo";
                $vendor['photo_image'] = "No Image";
            } */

            $vendor['photo'] = "No Photo";
            $vendor['photo_image'] = "No Image";
            $vendor['gst'] = "No GST";
            $vendor['gst_image'] = "No Image";

            $row = $this->main->update($api_key, $post, $this->table);

            $check = $this->main->check('vendor', ['u_id'=>$api_key], 'id');

            if ($check) {
                $id = $this->main->update($check,$vendor, 'vendor');
            }else{
                $id = $this->main->add($vendor, 'vendor');
            }
            
            if($row && $id)
            {
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

    public function profile()
    {
        get();
        $api_key = authenticate($this->table);
        
        if($row = $this->main->get_where('vendor', '*', ['u_id' => $api_key], ['u_id' => $this->table]))
        {
            $row['gst_image'] = ($row['gst_image'] != 'No Image') ? base_url('assets/images/gst/'.$row['gst_image']) : 'No Image';
            $row['photo_image'] = ($row['photo_image'] != 'No Image') ? base_url('assets/images/photo/'.$row['photo_image']) : 'No Image';
            $row['image'] = ($row['image'] != 'No Image') ? base_url('assets/images/users/'.$row['image']) : 'No Image';
            
            if ($row['vendor_type'] == '1') 
                foreach (explode(',', $row['cat_id']) as $k => $v) 
                    $row['categories'][$k] = $this->main->check('categories', ['id' => $v], 'cat_name');
            if ($row['vendor_type'] == '2')
                foreach (explode(',', $row['cat_id']) as $k => $v) 
                    $row['categories'][$k] = $this->main->check('inquiry_category', ['id' => $v], 'cat_name');

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

    public function check_vendor()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->get_where("membership_buy",'id,expiry', ['status'=>1,'user_id'=>$api_key,'membership_type'=>"vendor"]);
         
        if (date('Y-m-d') > $row['expiry']) {
            $id = $this->main->update($row['id'],['status'=>0], 'membership_buy');
            $v_id = $this->main->update($api_key,['vendor_type'=>2], $this->table);
        }else{
            $id = 1;
            $v_id = 1;
        }

        if($v_id && $id)
        {
            $response['error'] = FALSE;
            $response['message'] ="Status Changed Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Status Changed Not Successfull!";
            echoRespnse(400, $response);
        }  
    }

    public function booking_list()
    {
        get();
        verifyRequiredParams(['order_status']);
        $api_key = authenticate($this->table);
        $cats = $this->main->get_where('vendor', 'cat_id, lat, lng', ['u_id'=>$api_key]);
        
        $ser_cats = $inq_cats =  [];
        
        foreach (explode(',', $cats['cat_id']) as $k => $v) {
            if (strpos($v, '1-') !== false)
                $ser_cats[] = str_replace('1-', "", $v);
            else
                $inq_cats[] = str_replace('2-', "", $v);
        }
        
        $services = $this->main->booking_list($ser_cats, $cats['lat'], $cats['lng'], $api_key);
        $inquiry = $this->main->inquiry_list($inq_cats, $cats['lat'], $cats['lng'], $api_key);

        $row = array_merge($services, $inquiry);
        
        if($row)
        {   
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Booking List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Booking List Not Successfull!";
            echoRespnse(400, $response);
        }    
    }

    public function book_confirm()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['order_id','order_type']);
        
        $order_id = $this->input->post('order_id');
        $order_type = $this->input->post('order_type');

        $post['assign'] = $api_key;
        $post['status'] = "in process";

        if (!empty($this->input->post('vendor_transaction_id'))) {
            $post['vendor_transaction_id'] = $this->input->post('vendor_transaction_id');
        }else{
            $post['vendor_transaction_id'] = "Contractor or Admin";
        }

        if (!empty($this->input->post('vendor_payment'))) {
            $post['vendor_payment'] = $this->input->post('vendor_payment');
        }else{
            $post['vendor_payment'] = 0;
        }

        if ($order_type == "service") {
            $id = $this->main->update($order_id, $post, 'bookings');
        }else if ($order_type == "enquiry") {
            $id = $this->main->update($order_id, $post, 'inquiry_book');
        }

        if($id)
        {
            $response['error'] = FALSE;
            $response['message'] ="Booking Confirmed Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Booking Confirmed Not Successfull!";
            echoRespnse(400, $response);
        }
    }

    public function book_complete()
    {
        post();
        $api_key = authenticate($this->table);
        verifyRequiredParams(['order_id','order_type','otp']);
        $order_id = $this->input->post('order_id');
        $order_type = $this->input->post('order_type');
        $post['status'] = "completed";

        $otp = $this->input->post('otp');

        if ($order_type == "service") {
            $otp_check = $this->main->check("bookings", ['otp'=>$otp, 'id'=>$order_id], 'otp');
        }else if ($order_type == "enquiry") {
            $otp_check = $this->main->check("inquiry_book", ['otp'=>$otp, 'id'=>$order_id], 'otp');
        }

        if (!$otp_check) {
            $response["error"] = TRUE;
            $response['message'] = "Invalid OTP!";
            echoRespnse(400, $response);
        }

        if ($order_type == "service") {
            $service = $this->main->edit($order_id, "bookings", 'ser_id, payment_type, total_amount, cust_id');
            $visiting_charge = 0;
            foreach (json_decode($service['ser_id']) as $k => $v) {
                if ($service['payment_type'] == 'online') {
                    $visiting_charge += $v->price * $v->qty;
                    $status = 'Pending';
                    $payment_type = 'Liability';
                }else{
                    if ($v->visiting_charge != 'Membership' && $v->visiting_charge > 0) {
                      $visiting_charge += $v->visiting_charge;
                      $status = 'Pending';
                      $payment_type = 'Asset';
                    }
                }
            }

            if ($visiting_charge > 0)
                $this->main->add(['ven_id' => $api_key, 'payment' => $visiting_charge, 'payment_type' => $payment_type, 'status' => $status, 'order_id' => $order_id], 'accounts');

            $id = $this->main->update($order_id,$post, 'bookings');
            if ($id) {
                $new = $this->main->check('customer', ['id' => $service['cust_id']], 'balance') + ceil($service['total_amount'] * 0.02);
                /*$this->main->add(['ref_by' => $id, 'ref_user' => $api_key, 'ref_money' => ceil($bal * 0.1), 'ref_type' => 'Credit'], 'ref_payments');*/
                $this->main->update($service['cust_id'], ['balance' => $new], 'customer');
            }
        }else if ($order_type == "enquiry") {
            $id = $this->main->update($order_id,$post, 'inquiry_book');
        }

        if($id)
        {
            $response['error'] = FALSE;
            $response['message'] = "Booking Completed Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Booking Completed Not Successfull!";
            echoRespnse(400, $response);
        }
    }
}