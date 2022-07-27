<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller']    = 'pages';
$route['menu/(:any)']           = 'pages/index/$1';
$route['reservation/(:any)']    = 'pages/reservation_list/$1';
$route['reservation']           = 'pages/reservation';
$route['order_history']         = 'pages/history';
$route['checkout']              = 'cart/checkout';
$route['order-history']         = 'pages/history';

$route['404_override']          = 'pages/no_page';
$route['translate_uri_dashes']  = FALSE;
