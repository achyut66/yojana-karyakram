<?php
include 'includes/initialize.php';
$res = array();
$plan_id      =  $_POST['plan_id'];
$plan_details =  Plandetails1::find_by_id($plan_id);
$res['html'] = $plan_details->program_name;
echo json_encode($res);exit;
?>