<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeApi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        // mobile();
        date_default_timezone_set('Asia/Kolkata');
    }

    private $table = 'users';

    public function login()
    {
    	post();
    	verifyRequiredParams(['mobile','password']);
    	$post['mobile'] = $this->input->post('mobile');
        $post['password'] = my_crypt($this->input->post('password'));
        $post['is_blocked'] = 'no';
        $post['is_delete'] = 'no';
        $post['vendor_type'] = 1;
        $row = $this->main->get_where($this->table, 'id, username, email, mobile, vendor_type, image', $post);

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
	        $response['message'] = "Login Not Successfull! Please contact to admin fr account activation";
	        echoRespnse(400, $response);
	    }
    }

    public function create_vendor()
    {
    	post();
    	$api_key = authenticate($this->table);
    	verifyRequiredParams(['username', 'mobile', 'password', 'email', 'cat_id', 'address', 'lat', 'lng', 'area', 'city', 'state']);
        $post['username'] = str_replace('"', "", $this->input->post('username'));
        $post['password'] = my_crypt(str_replace('"', "", $this->input->post('password')));
        $post['email'] = str_replace('"', "", $this->input->post('email'));
        $post['mobile'] = str_replace('"', "", $this->input->post('mobile'));
        $post['is_blocked'] = "yes";
        $post['vendor_type'] = 2;
        $post['role'] = 'vendor';
        $post['com_name'] = 'vendor';
        
        $email = $this->main->get_where($this->table, 'id', ['email'=>$post['email']]);
        
        if ($email) {
            $response['row'] = "Email already in use.";
            $response["error"] = TRUE;
            $response['message'] = "Sign Up Not Successfull!";
            echoRespnse(400, $response);
        }elseif ($this->main->get_where($this->table, 'id', ['mobile'=>$post['mobile']])) {
            $response['row'] = "Mobile already in use.";
            $response["error"] = TRUE;
            $response['message'] = "Sign Up Not Successfull!";
            echoRespnse(400, $response);
        }else{
            if (isset($_FILES['image']['name'])) {
            
                $vendor['gst'] = $this->input->post('gst');
                $config['upload_path']= "assets/images/users/";
                $config['allowed_types']='jpg|jpeg';
                $config['file_name'] = strtolower(str_replace(' ','_', $post['username']));
                $config['file_ext_tolower'] = TRUE;
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload("image")) {
                    $response['row'] = "Image not valid. Only jpg or jpeg allowed.";
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

            $u_id = $this->main->add($post, $this->table);

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
            $vendor['u_id'] = $u_id;

            if (isset($_FILES['gst_image']['name'])) {
                verifyRequiredParams(['gst']);
                $vendor['gst'] = str_replace('"', "", $this->input->post('gst'));
                $config['upload_path']= "assets/images/gst/";
                $config['allowed_types']='jpg|jpeg';
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
            }

            if (isset($_FILES['photo_image']['name'])) {
                verifyRequiredParams(['photo']);
                $vendor['photo'] = str_replace('"', "", $this->input->post('photo'));
                $config['upload_path']= "assets/images/photo/";
                $config['allowed_types']='jpg|jpeg';
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
            }
            
            $id = $this->main->add($vendor, 'vendor');
            
            if($u_id && $id)
            {
                $response['error'] = FALSE;
                $response['message'] ="Vendor Created Successfull.";
                echoRespnse(200, $response);
            }
            else 
            {
                $response["error"] = TRUE;
                $response['message'] = "Vendor Created Not Successfull!";
                echoRespnse(400, $response);
            }
        }
    }

    public function profile()
    {
        get();
        $api_key = authenticate($this->table);
        
        $row = $this->main->edit($api_key,$this->table,'id, username, email, mobile, wallet');
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

    public function customer_membership()
    {
        get();
        $api_key = authenticate($this->table);

        $row = $this->main->getall('membership', 'id,plan,price,image,details',['is_delete'=>'no','active'=>1]);
        if($row)
        {
            foreach ($row as $k => $v) {
                $row[$k]['image'] = base_url('assets/images/membership/').$v['image'];
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

    public function vendor_membership()
    {
        get();
        $api_key = authenticate($this->table);

        $row = $this->main->getall('vendor_membership', 'id,plan,price,image,details',['is_delete'=>'no','active'=>1]);
        if($row)
        {
            foreach ($row as $k => $v) {
                $row[$k]['image'] = base_url('assets/images/membership/').$v['image'];
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

    public function membership_buy()
    {
        post();
        $api_key = authenticate($this->table);
        
        verifyRequiredParams(['membership_id','user_mobile', 'user_type']);
        
        if ($this->input->post('user_type') == "customer") {
            $user_id = $this->main->check('customer',['mobile' => $this->input->post('user_mobile')],'id');
            
            if (!$user_id) {
                $response["error"] = TRUE;
                $response['message'] = "Mobile not registered";
                echoRespnse(400, $response);
            }

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
                'transaction_id' => "cash",
                'service_id' => implode(',', $ser_id),
                'price' => $mem['price'],
                'user_id' => $user_id,
                'employee' => $api_key,
                'expiry' => date('Y-m-d', strtotime($mem['time_period']." month")),
                'membership_type' => $this->input->post('user_type'),
            ];

        }else{
            $mem = $this->main->edit($this->input->post('membership_id'), 'vendor_membership', 'price,ser_id,time_period');
            $user_id = $this->main->check('customer',['mobile' => $this->input->post('user_mobile')],'id');
            
            if (!$user_id) {
                $response["error"] = TRUE;
                $response['message'] = "Mobile not registered";
                echoRespnse(400, $response);
            }

            $data = [
                'membership_id'  => $this->input->post('membership_id'),
                'transaction_id' => "cash",
                'service_id' => $mem['ser_id'],
                'price' => $mem['price'],
                'user_id' => $user_id,
                'employee' => $api_key,
                'expiry' => date('Y-m-d', strtotime($mem['time_period']." month")),
                'membership_type' => $this->input->post('user_type'),
            ];
        }

        $id = $this->main->add($data, 'membership_buy');

        if($id)
        {
            if ($this->input->post('user_type') == "vendor") {
                $this->main->update($user_id, ['vendor_type'=>1], 'users');
            }
            $wallet = $this->main->check('customer',['id' => $api_key],'wallet') + $mem['price'];
            $this->main->update($api_key, ['wallet'=>$wallet], 'users');
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

    public function meeting()
    {
        post();
        
        $api_key = authenticate($this->table);
        
        verifyRequiredParams(["name","meeting_type","address","mobile"]);

        $post = [
            "name" => $this->input->post('name'),
            "meeting_type" => $this->input->post('meeting_type'),
            "address" => $this->input->post('address'),
            "mobile" => $this->input->post('mobile'),
            "remarks" => ($this->input->post('remarks')) ? $this->input->post('remarks') : 'No Remarks',
            "user_id" => $api_key,
            "meeting_date" => date("d-m-Y"),
            "meeting_time" => date("h:i A"),
        ];

        $row = $this->main->add($post, 'meetings');

        if($row)
        {
            $response['row'] = (string) $row;
            $response['error'] = FALSE;
            $response['message'] ="Meetings Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Meetings Not Successfull!";
            echoRespnse(400, $response);
        }    
    }

    public function meetings()
    {
        get();
        $api_key = authenticate($this->table);

        $row = $this->main->getall('meetings', 'name, meeting_type, address, mobile, remarks, meeting_date, meeting_time',['is_delete'=>0,'user_id'=>$api_key]);
        if($row)
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Meetings List Successfull.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Meetings List Not Successfull!";
            echoRespnse(400, $response);
        }    
    }
}