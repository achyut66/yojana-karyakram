<?php 
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id = $_GET['plan_id'];
$csd_result= Amanat_more_details::find_by_sql("select * from amanat_more_details where plan_id=".$id);

foreach($csd_result as $data):
$data->delete();
echo alertBox("हटाउन सफल ","view_all_amanat.php?id=".$id);
endforeach;
?>
  