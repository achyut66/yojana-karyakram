<?php 
include 'includes/initialize.php';
$final_data = Contractamountwithdrawdetails::find_by_plan_id($_GET['id']);
if($final_data->delete())
{
   $katti_bibaran_payment = KattiDetails::find_by_plan_id_and_type($_GET['id'],2); 
   foreach($katti_bibaran_payment as $kbp)
   {
       $kbp->delete();
   }
  // echo $_GET['id'];exit;
   
   echo alertBox('हटाउन सफल ','contract_final.php?id='.$_GET['id']);
}


?>