<?php
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id = $_GET['plan_id'];
//print_r($id);exit;
$csd_result= Quotationtotalinvestment::find_by_sql("select * from quotation_total_investment where plan_id=".$id);
//$result1= Quotationmoredetails::find_by_sql("select * from quotation_more_details where plan_id=".$id);
foreach($csd_result as $data):
    $data->delete();
    echo alertBox("हटाउन सफल ","view_quotation_form.php?id=".$id);
endforeach;

?>
