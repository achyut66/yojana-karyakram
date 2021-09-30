<?php require_once("includes/initialize.php"); 
require_once("zonelist.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$bhautik_details = Bhautik_lakshya::find_by_plan_id_and_type($_POST['plan_id'],1);

for($i=0;$i<count($_POST['details_id']);$i++)
{
    $detail = new Bhautik_lakshya();
    $detail->details_id = $_POST['details_id'][$i];
    $detail->qty = $_POST['qty'][$i];
    $detail->unit_id = $_POST['unit_id'][$i];
    $detail->plan_id = $_POST['plan_id'];
    $detail->miti    = DateEngToNep(date("Y-m-d",  time()));
    $detail->miti_english    = (date("Y-m-d",  time()));
    $detail->type = 1;
    $detail->save();
}
error_reporting(1);
if(!empty($_POST['create_id']))
{
	$data = Samitiplantotalinvestment::find_by_id($_POST['create_id']);	
}
else
{
	$data = new Samitiplantotalinvestment();
}
$data->unit_total=$_POST['unit_total'];
$data->unit_id=$_POST['unit_id'];
$data->agreement_gauplaika=$_POST['agreement_gauplaika'];
$data->agreement_other=$_POST['agreement_other'];
$data->costumer_agreement=$_POST['costumer_agreement'];
$data->other_agreement=$_POST['other_agreement'];
$data->bhuktani_anudan=$_POST['bhuktani_anudan'];
$data->costumer_investment =$_POST['costumer_investment'];
$data->total_investment=$_POST['total_investment'];
$data->plan_id=$_POST['plan_id'];

//$data->created_date=date("Y-m-d",time());
if($data->save())
{
    //echo 'done';exit;
   $link= "samiti_plan_form1_1.php?id=".$_POST['plan_id'];
echo alertBox("अपडेट सफल भयो", $link);


}