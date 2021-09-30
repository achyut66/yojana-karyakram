<?php 
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id = $_GET['plan_id'];
$csd_result= Samiticostumerassociationdetails0::find_by_sql("select * from samiti_costumer_association_details_0 where plan_id=".$id);
$result = Samiticostumerassociationdetails::find_by_sql("select * from samiti_costumer_association_details where plan_id=".$id);

foreach($result as $r):
$r->delete();
endforeach;

foreach($csd_result as $data):
$data->delete();
echo alertBox("हटाउन सफल ","view_samiti_plan_form.php?id=".$id);
endforeach;
?>
  