<?php 
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id= $_GET['id'];
print_r($id);exit;
$sql= "select * from plan_total_investment where plan_id={$id}";
$csd_result= Plantotalinvestment::find_by_sql($sql);

$result1= Analysisbasedwithdraw::check_plan_id($id);
$result2= Planamountwithdrawdetails::check_plan_id($id);
$result3= Planstartingfund::check_plan_id($id);
if($result1==1 || $result2==1 || $result3==1)
{
    echo alertBox("हटाउन मिलेन","plan_form_delete_result.php?id=".$id);
}
else
{
foreach($csd_result as $data):
$data->delete();
echo alertBox("हटाउन सफल ","plan_form_delete_result.php?id=".$id);
endforeach;
}
  