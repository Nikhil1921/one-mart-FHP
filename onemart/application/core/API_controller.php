<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class API_controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('api');
	}

	public function verify_api_key()
	{
		$headers = apache_request_headers();
        $response = array();
        
        if (isset($headers['Authorization']))
        {
            $key = str_replace('"', "", $headers['Authorization']);
            
            $authDB = $this->load->database('auth', TRUE);

            if (! $authDB->select('id')->where(['id' => $key, 'active' => 1])->from('customer')->get()->row_array())
            {
                $response["error"] = true;
                $response["message"] = "Unauthorized User";
                echoRespnse(200, $response);
            } else {
                return $key;
            }
        } else {
            $response["error"] = true;
            $response["message"] = "Api key is missing";
            echoRespnse(200, $response);
        }
	}

	public function error_404()
	{
		$response['error'] = true;
		$response['message'] = "The page you are attempting to reach is currently not available.";
		
		echoRespnse(404, $response);
	}
}