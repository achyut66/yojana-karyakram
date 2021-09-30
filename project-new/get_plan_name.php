<?php
require_once("includes/initialize.php");
$res=array();
$plan_id = $_POST['plan_id'];
$data=  Plandetails1::find_by_id($plan_id);
$html = $data->program_name;
$res['html']= $html;
echo json_encode($res);exit;