<?php
require_once 'includes/initialize.php';
$res=array();
$contractor_id=$_POST['contractor_id'];
$result= Contractordetails::find_by_id($contractor_id);
$output=$result->contractor_address;
$html=$result->contractor_contact;
$res['contractor_address']=$output;
$res['contractor_contact']=$html;
echo json_encode($res);exit;