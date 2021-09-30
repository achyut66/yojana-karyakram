<?php
 require_once("includes/initialize.php"); 
 if(!$session->is_logged_in()){ redirect_to("logout.php");}
$plan_id=$_GET['plan_id'];
$result= Contractanalysisbasedwithdraw::find_by_plan_id($plan_id);
foreach($result as $data)
{
    $data->delete();

}
redirect_to("contract_form3.php");