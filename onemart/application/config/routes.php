<?php defined('BASEPATH') OR exit('No direct script access allowed');
$admin = 'adminPanel';

$route['default_controller'] = 'home';
$route['404_override'] = 'home/error_404';
$route['translate_uri_dashes'] = TRUE;

// front routes
/* $route['wishlist'] = 'home/wishlist';
$route['getProduct'] = 'home/getProduct';
$route['cart'] = 'home/cart';
$route['checkout']['get'] = 'user/checkout';
$route['checkout']['post'] = 'user/checkout_post';
$route['getCart'] = 'home/getCart';
$route['addCart']['post'] = 'home/addCart';
$route['addWish']['post'] = 'home/addWish';
$route['apply-coupon']['post'] = 'user/apply_coupon';
$route['add-address']['post'] = 'user/add_address';
$route['check-address'] = 'user/check_address';
$route['user'] = 'user/index';
$route['user/profile'] = 'user/profile';
$route['user/logout'] = 'user/logout';
$route['user/order'] = 'user/order';
$route['user/change-password'] = 'user/change_password';
$route['user/address'] = 'user/address';
$route['user/addAddress'] = 'user/addAddress';
$route['user/updateAddress/(:num)'] = 'user/updateAddress/$1';
$route['user/update-address/(:num)'] = 'user/update_address/$1';
$route['login'] = 'login/index';
$route['register'] = 'register/index';
$route['register/check'] = 'register/check';
$route['register/register'] = 'register/register';
$route['forgotPassword'] = 'forgotPassword/index';
$route['forgotPassword/check'] = 'forgotPassword/check';
$route['forgotPassword/change-password'] = 'forgotPassword/change_password';
$route['become-partner'] = 'home/become_partner';
$route['about-us'] = 'home/about_us';
$route['user/cancel']['post'] = 'user/cancel';
$route['terms-conditions'] = 'home/terms';
$route['payment-protection'] = 'home/payment';
$route['refund-policy'] = 'home/refund';
$route['delivery-information'] = 'home/delivery';

if (! in_array($this->uri->segment(1), ['api', $admin]))
{
    $route['(:any)(/:any)?'] = 'home/shop/$1$2';
    $route['(:any)/(:any)/(:any)'] = 'home/product/$1/$2/$3';
} */

// admin routes
$route["$admin/forgot-password"] = "$admin/login/forgot_password";
$route["$admin/check-otp"] = "$admin/login/check_otp";
$route["$admin/change-password"] = "$admin/login/change_password";
$route["$admin/dashboard"] = "$admin/home";