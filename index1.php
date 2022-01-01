<?php

// include database and object files
include_once './conn/session.php';
include_once './conn/config.php';
include_once './api/users.php';
include_once './api/states.php';
include_once './api/payments.php';
include_once './api/earnings.php';
include_once './api/earning_tab.php';
include_once './api/accounts.php';
include_once './api/helpers/index.php';
include_once './api/helpers/upload.php';

cors();
  
// instantiate database and product object
$database = new Database();

$api = $_SERVER["QUERY_STRING"] ? $_SERVER["QUERY_STRING"] : '';
$method = $_SERVER["REQUEST_METHOD"] ? $_SERVER["REQUEST_METHOD"] : '';
$json = file_get_contents('php://input');
$req_data = json_decode($json);

$db = $database->getConnection();
$users = new Users($db);
$payments = new Payments($db);
$states = new States($db);
$earnings = new Earnings($db);
$earning_tab = new EarningTab($db);
$accounts = new Accounts($db);

if($api === "login" && $method === 'POST') {
	echo $users->login($req_data);
	die();
}

if($api === "reset_password" && $method === 'POST') {
	echo $users->reset_password($req_data);
	die();
}

if($api === "register" && $method === 'POST') {
	echo $users->register($req_data);
	die();
}

// Check auth
$auth = $users->check_auth($req_data, '');
if($auth['is'] === 0){
	echo response((object) array(), "Your session is expired please login again!", false, 'api', 401);
	die();
}

// script api
if($api === "add_earning_points" && $method === 'POST') {
	echo $earnings->add_earning_points($req_data);
	die();
}

if($api === "points_into_amount" && $method === 'POST') {
	echo $earnings->points_into_amount($req_data);
	die();
}

if($api === "update_profile" && $method === 'POST') {
	echo $users->update($req_data);
}

if($api === "get_user_profile" && $method === 'POST') {
	echo $users->get_user_profile($req_data);
}

// admin
if($api === "get_all_users" && $method === 'POST') {
	echo $users->get_all_users($req_data);
}

// admin
if($api === "get_states" && $method === 'POST') {
	echo $states->get_states($req_data);
}

// admin
if($api === "update_user_profile_by_admin" && $method === 'POST') {
	echo $users->update_user_profile_by_admin($req_data);
}

// admin
if($api === "delete_user_profile_by_admin" && $method === 'POST') {
	echo $users->delete_user_profile_by_admin($req_data);
}

// admin
if($api === "get_all_users_earnings" && $method === 'POST') {
	echo $earnings->get_all_users_earnings($req_data);
}

// admin
if($api === "get_all_payments_request" && $method === 'POST') {
	echo $payments->get_all_payments_request($req_data);
}

// admin
if($api === "update_width_request_by_admin" && $method === 'POST') {
	echo $payments->update_width_request_by_admin($req_data);
}

// admin
if($api === "add_new_link" && $method === 'POST') {
	echo $earning_tab->add_new_link($req_data);
}

// admin
if($api === "update_link" && $method === 'POST') {
	echo $earning_tab->update_link($req_data);
}

if($api === "get_earnings" && $method === 'POST') {
	echo $earnings->get_earnings($req_data);
}

// common
if($api === "get_earning_links" && $method === 'POST') {
	echo $earning_tab->get_earning_links($req_data);
}

if($api === "link_clicked" && $method === 'POST') {
	echo $earnings->link_clicked($req_data);
}

if($api === "get_payments" && $method === 'POST') {
	echo $payments->get_payments($req_data);
}

if($api === "request_widthdraw" && $method === 'POST') {
	echo $payments->request_widthdraw($req_data);
}

if($api === "cancel_widthdraw_request" && $method === 'POST') {
	echo $payments->cancel_widthdraw_request($req_data);
}

if($api === "get_user_account" && $method === 'POST') {
	echo $accounts->get_user_account($req_data);
}

if($api === "deposit_withdraw" && $method === 'POST') {
	echo $accounts->deposit_withdraw($req_data);
}