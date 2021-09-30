<?php 
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$program_id=$_GET['program_id'];
$id=$_GET['id'];
//print_r($program_id);exit;
$program_payment_final  = Programpaymentfinal::find_by_id($id);
$program_katti = ProgramKatti::find_by_plan_id($program_id);

foreach($program_katti as $pk):
//print_r($program_katti);exit;
  $pk->delete_data($program_id);
endforeach;
  if($program_payment_final->delete())
  {
    echo   alertBox("हटाउन सफल ", "program_payment_final.php?id=".$program_id);
  }
?>
