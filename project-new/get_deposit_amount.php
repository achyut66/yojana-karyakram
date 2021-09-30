<?php
require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$res=array();
$program_id= $_POST['program_id'];
$id=$_POST['id'];
$amount=0;
$inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ",
    6=>"छैठो",
);
$total_period = Programpaymentdepositreturn::maxPeriodForProgram($program_id,$id);
if(empty($total_period))
{
    $total_period=0;
}
$program_payment_final= Programpaymentfinal::find_by_program_id_and_sn($program_id, $id);
$sql="select * from  program_payment_final_deposit_return where program_id={$program_id} and sn={$id}";
$result= Programpaymentdepositreturn::find_by_sql($sql);
if(!empty($result))
{
        foreach($result as $data)
        {
            $amount+=$data->deposit_amount;
        }
}
$deposit_amount= $program_payment_final->deposit_amount-$amount;
$output=$deposit_amount;                                     
$res['html']=$output; 
$res['period_no']=$total_period+1;
$res['period']= $inst_array[$total_period+1];
$res['enlist_id']= $program_payment_final->enlist_id;
echo json_encode($res);exit;
?>
