<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends API_controller {

    public function getBanners()
    {
        get();

        $data = $this->main->getBanners();

        $response['row'] = $data ? $data : [];
        $response['error'] = false;
        $response['message'] = "Banners list success.";

        echoRespnse(200, $response);
    }

    public function getCats($c_id=0)
    {
        get();

        $data = $this->main->getCats($c_id);

        $response['row'] = $data ? $data : [];
        $response['error'] = false;
        $response['message'] = "Category list success.";

        echoRespnse(200, $response);
    }

    public function getProds($sub_cat_id)
    {
        get();

        $data = $this->main->getProducts(['p.sub_cat_id' => $sub_cat_id]);

        $response['row'] = $data ? $data : [];
        // $response['url'] = base_url($this->config->item('products'));
        $response['error'] = false;
        $response['message'] = "Products list success.";

        echoRespnse(200, $response);
    }

    protected $table = 'users';

    public function __construct()
    {
        parent::__construct($this->table);
        $this->api = $this->verify_api_key();
    }
}