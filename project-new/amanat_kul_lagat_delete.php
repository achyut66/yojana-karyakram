<?php 
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id = $_GET['plan_id'];
$csd_result= AmanatLagat::find_by_sql("select * from amanat_lagat where plan_id=".$id);
$result1= Bhautik_lakshya::find_by_sql("select * from bhautik_lakshya where plan_id=".$id);


foreach($result1 as $r1):
$r1->delete();
endforeach;

foreach($csd_result as $data):
$data->delete();
echo alertBox("हटाउन सफल ","view_all_amanat.php?id=".$id);
endforeach;

?>
  