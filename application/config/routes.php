<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'home/error';
$route['otp-check'] = 'login/otp_check';
$route['check-otp'] = 'signup/otp_check';
$route['access-denied'] = 'home/error_403';
$route['addtocart'] = 'cart/addtocart';
$route['confirmation'] = 'cart/confirm';
$route['update-cart'] = 'cart/update_cart';
$route['remove-drug'] = 'cart/remove_drug';
$route['checkout'] = 'cart/checkout';
$route['place-order'] = 'cart/place_order';
$route['update-profile'] = 'dashboard/update_profile';
$route['order-detail/(:num)'] = 'cart/order_detail/$1';
$route['product_single'] = 'Product_Single';
$route['shop/:num'] = 'shop';
$route['translate_uri_dashes'] = TRUE;