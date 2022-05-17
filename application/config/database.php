<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

switch ($_SERVER['SERVER_NAME']) {
    case 'www.myfhp.in':
    case 'myfhp.in':
    case 'https://www.myfhp.in':
    case 'https://myfhp.in':
        $db['default'] = array(
            'dsn'	=> '',
            'hostname' => 'localhost',
            'username' => 'labmajol_fhp',
            'password' => 'TVnVDtcn7]]V',
            'database' => 'labmajol_fhp',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );

        break;
    
    default:
        $db['default'] = array(
            'dsn'	=> '',
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'jigs_fhp',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => FALSE,
            'db_debug' => (ENVIRONMENT !== 'production'),
            'cache_on' => FALSE,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => FALSE,
            'compress' => FALSE,
            'stricton' => FALSE,
            'failover' => array(),
            'save_queries' => TRUE
        );

        break;
}