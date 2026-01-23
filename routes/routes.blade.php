<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// =========================================================================
// GYM MEMBERSHIP SYSTEM ROUTES
// =========================================================================

// Landing Page Routes
$route['about'] = 'home/about';
$route['services'] = 'home/services';
$route['membership'] = 'home/membership';
$route['contact'] = 'home/contact';
$route['contact/send'] = 'home/send_message';
$route['join'] = 'home/join';

// Authentication Routes
$route['login'] = 'auth';
$route['register'] = 'auth/registration';
$route['logout'] = 'auth/logout';

// Admin Dashboard Routes
$route['gym'] = 'gym/index';
$route['admin'] = 'gym/index';
$route['dashboard'] = 'gym/index';

// Admin - Member Management Routes
$route['gym/members'] = 'gym/members';
$route['gym/members/add'] = 'gym/add_member';
$route['gym/members/edit/(:num)'] = 'gym/edit_member/$1';
$route['gym/members/delete/(:num)'] = 'gym/delete_member/$1';

// Admin - Membership Plans Routes
$route['gym/membership-plans'] = 'gym/membership_plans';
$route['gym/membership-plans/add'] = 'gym/add_plan';
$route['gym/membership-plans/edit/(:num)'] = 'gym/edit_plan/$1';
$route['gym/membership-plans/delete/(:num)'] = 'gym/delete_plan/$1';

// Admin - Subscriptions Routes
$route['gym/subscriptions'] = 'gym/subscriptions';
$route['gym/subscriptions/add'] = 'gym/add_subscription';
$route['gym/subscriptions/edit/(:num)'] = 'gym/edit_subscription/$1';
$route['gym/subscriptions/delete/(:num)'] = 'gym/delete_subscription/$1';
$route['gym/get_subscription_details/(:num)'] = 'gym/modaldetail/$1'; 

// Admin - Attendance Routes
$route['gym/attendance'] = 'gym/attendance';
$route['gym/attendance/today'] = 'gym/attendance_today';
$route['gym/attendance/history'] = 'gym/attendance_history';

// Admin - Reports Routes
$route['gym/reports'] = 'gym/reports';
$route['gym/reports/members'] = 'gym/reports_members';
$route['gym/reports/revenue'] = 'gym/reports_revenue';
$route['gym/reports/attendance'] = 'gym/reports_attendance';

// Member Dashboard Routes
$route['member'] = 'member/index';
$route['member/dashboard'] = 'member/index';

// Member - Profile Routes
$route['member/profile'] = 'member/profile';
$route['member/profile/update'] = 'member/update_profile';
$route['member/change-password'] = 'member/change_password';

// Member - Membership Routes
$route['member/membership-plans'] = 'member/membership_plans';
$route['member/subscriptions'] = 'member/my_subscriptions';

// Member - Attendance Routes
$route['member/attendance'] = 'member/my_attendance';
$route['member/check-in'] = 'member/check_in';
$route['member/check-out'] = 'member/check_out';

// API Routes (for future mobile app or AJAX calls)
$route['api/members'] = 'api/members';
$route['api/attendance'] = 'api/attendance';
$route['api/subscriptions'] = 'api/subscriptions';

// Legacy routes redirect (for backward compatibility)
$route['user'] = 'member/index';
$route['user/index'] = 'member/index';
