<?php 
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$program_id=$_GET['program_id'];
$id=$_GET['id'];
  $program_payment_final  = Programpaymentdepositreturn::find_by_id($id);
  if($program_payment_final->delete())
  {
    echo   alertBox("हटाउन सफल ", "program_payment_deposit_return.php?id=".$program_id);
  }
?>

