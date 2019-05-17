<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//routes
$route['dashboard'] = 'dashboard';

$route['get/users']['GET']          =   'UserController/getAll';
$route['get/users/(:num)']['GET']   =   'UserController/get/$1';
$route['get/users']['POST']         =   'UserController/register';

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;