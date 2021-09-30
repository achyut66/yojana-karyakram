<?php 
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id = $_GET['plan_id'];

$csd_result= Contractinfo::find_by_sql("select * from contract_info where plan_id=".$id);
$result = Contractinvitationforbid::find_by_sql("select * from contract_invitation_for_bid where plan_id=".$id);
$result1 = Contractinvitationentry::find_by_sql("select * from contract_invitation_entry where plan_id=".$id);
$result2 = Contractbidfinal::find_by_sql("select * from contract_bid_final where plan_id=".$id);
$result3 = Contractentryfinal::find_by_sql("select * from contract_entry_final where plan_id=".$id);
$result4 = Contract_total_investment::find_by_sql("select * from contract_total_investment where plan_id=".$id);
$result5 = Contractmoredetails::find_by_sql("select * from contract_more_details where plan_id=".$id);


foreach($result as $r):
$r->delete();
endforeach;

foreach($result1 as $r1):
$r1->delete();
endforeach;

foreach($result2 as $r2):
$r2->delete();
endforeach;

foreach($result3 as $r3):
$r3->delete();
endforeach;

foreach($result4 as $r4):
$r4->delete();
endforeach;

foreach($result5 as $r5):
$r5->delete();
endforeach;

foreach($csd_result as $data):
$data->delete();
echo alertBox("हटाउन सफल ","view_samiti_plan_form.php?id=".$id);
endforeach;
?>
  