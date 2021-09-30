<?php 
require_once 'includes/initialize.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$id= $_GET['id'];
$sql= "select * from costumer_association_details where plan_id={$id}";
$csd_result= Costumerassociationdetails::find_by_sql($sql);
$sql0= "select * from costumer_association_details_0 where plan_id={$id}";
$csd_result0= Costumerassociationdetails0::find_by_sql($sql0);
$result1= Analysisbasedwithdraw::check_plan_id($id);
$result2= Planamountwithdrawdetails::check_plan_id($id);
$result3= Planstartingfund::check_plan_id($id);
if($result1==1 || $result2==1 || $result3==1)
{
echo    alertBox("हटाउन मिलेन","plan_form_delete_result.php?id=".$id);
}
else
{
    foreach($csd_result as $data):
        $data->delete();
    endforeach;
   
     foreach($csd_result0 as $data):
        $data->delete();
  echo alertBox("हटाउन सफल ","plan_form_delete_result.php?id=".$id);
    endforeach;
    
    
}
  
?>
