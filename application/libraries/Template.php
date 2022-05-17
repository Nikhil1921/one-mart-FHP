<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
        var $template_data = array();
        
        public function set($name, $value)
        {
            $this->template_data[$name] = $value;
        }
    
        public function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
        {               
            $this->CI =& get_instance();
            
            if (!empty($this->CI->session->userdata('role'))) {
                $role = $this->CI->session->userdata('role');
                if ($role == "super admin") {
                    $menu = $this->CI->db->select('name,menu_url,sub_menu,icon,permissions')->from('permissions')->order_by('priority','ASC')->get()->result_array();
                }else{
                    $view_data['permission'] = $this->CI->main->check('role', array('role'=>$role), 'permissions');    
                    $per = explode(',', $view_data['permission']);
                    $menu = $this->CI->db->select('name,menu_url,sub_menu,icon,permissions')->where_in('name', $per)->from('permissions')->order_by('priority','ASC')->get()->result_array();
                }
                
                foreach ($menu as $k => $v) {
                    $menu[$k]['sub_menu'] = json_decode($v['sub_menu']);
                }
                $view_data['menu'] = $menu;
            }

            $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));            
            return $this->CI->load->view($template, $this->template_data, $return);
        }
}