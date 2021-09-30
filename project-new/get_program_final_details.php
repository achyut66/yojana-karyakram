<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res=array();
$output="";
 $sn=$_POST['sn'];
 $program_id=$_POST['program_id'];
  $sql="select * from program_more_details where sn={$sn} and program_id={$program_id}";
  $row="select * from program_payment where sn={$sn} and program_id={$program_id}"; 
  $enlist_result= Programmoredetails::find_by_sql($sql);
  $payment_result= Programpayment::find_by_sql($row);
  if(empty($payment_result))
  {
  $program_payment=0;
  }
  else
  {
  foreach ($payment_result as $payment):
      $program_payment=$payment->payment_amount;
  endforeach;
  }
  $payment_amount= Programmoredetails::get_payment_amount($program_id,$sn);
  foreach ($enlist_result as $enlist ):
        $type = $enlist->type_id;
      $enlist_id=$enlist->enlist_id;
  endforeach;
  foreach ($payment_amount as $amount):
      $work_order_budget=$amount->work_order_budget;
  endforeach;
  $net_amount=$work_order_budget-$program_payment;
  $output.="<td>कार्यक्रमको संचालन गर्ने</td>";
   $output.="<td>";
    if($type == 5)
     {
         $u_samiti = Upabhoktasamitiprofile::find_by_id($enlist_id);
         $output .= $u_samiti->program_organizer_group_name;
     }
     else
     {
           $output.=Enlist::getName1($enlist_id);   
     }      
     $output.="</td>";
$output.="<input type='hidden' name='enlist_id' value='".$enlist_id."'>";


$res['html']=$output; 
$res['payment']=$program_payment;
$res['work_order_budget']=$work_order_budget;
$res['net_total_amount']=$net_amount;
$res['total_amount']=$program_payment;

echo json_encode($res);exit;
?>
