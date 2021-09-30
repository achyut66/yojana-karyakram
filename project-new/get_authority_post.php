<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res=array();
 $name=$_POST['postname'];
  $worker= Workerdetails::find_by_id($name);
   $output=$worker->post_name;                                     
$res['html']=$output; 
echo json_encode($res);exit;
?>
