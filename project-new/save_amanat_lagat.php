<?php require_once("includes/initialize.php"); 
require_once("zonelist.php");
error_reporting(1);
	//print_r($_POST); exit;
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$bhautik_details = Bhautik_lakshya::find_by_plan_id_and_type($_POST['plan_id'],1);
foreach($bhautik_details as $a)
{
    $a->delete();
}
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
if(!empty($_POST['create_id']) && empty($_POST['material_update_id']))
{
	$data = AmanatLagat::find_by_id($_POST['create_id']);
    $material= new Materialanudan();
    $anudan= Estimateanudandetails::find_by_plan_id($_POST['plan_id']);
    
    if(empty($anudan))
    {
        $anudan = new Estimateanudandetails();
    }
}
elseif(empty($_POST['create_id']) && !empty($_POST['material_update_id']))
{
    $data = new AmanatLagat();	
    $material=  Materialanudan::find_by_id($_POST['material_update_id']);
    $anudan= new Estimateanudandetails();
}
else
{
	$data = new AmanatLagat();
    $material=new Materialanudan();
    $anudan =  new Estimateanudandetails();
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
$data->created_date=date("Y-m-d",time());
$data->plan_id = $_POST['plan_id'];
// $_POST['created_date']=date("Y-m-d",time());
if($data->save())
{
    $add = $_POST['agreement_gauplaika'] + $_POST['agreement_other'] +$_POST['other_agreement'];
    $anudan->investment_amount   =  $_POST['agreement_gauplaika'];
    $anudan->other_source        =  $_POST['agreement_other'];
    $anudan->samiti_investment   =  $_POST['costumer_agreement'];
    $anudan->other_agreement     =  $_POST['other_agreement'];
    $anudan->total_investment    =  $add;
    $anudan->plan_id             =  $_POST['plan_id'];
    //print_r($anudan);exit;
    $anudan->save();
}
if(isset($_POST['check']))
   {
       $material->external_source=$_POST['external_source'];
       $material->state_gov=$_POST['state_gov'];
       $material->local_level=$_POST['local_level'];
       $material->sub_gov =$_POST['sub_gov'];
       $material->foreign_gov =$_POST['foreign_gov'];
       $material->other_nikaya =$_POST['other_nikaya'];
       $material->plan_id =$_POST['plan_id'];
       $material->save();
   }
$link= "amanat_more_details.php?id=".$_POST['plan_id'];
echo alertBox("अपडेट सफल भयो ", $link);
