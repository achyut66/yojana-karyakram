<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id= $_GET['id'];
$data=Topicbudget::find_by_id($id);
$data->delete();
echo alertBox("डाटा हटाउन सफल  ||", "setting_budget_topic.php");