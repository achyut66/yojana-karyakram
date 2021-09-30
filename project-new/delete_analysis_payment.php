<?php
require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$plan_id=$_GET['plan_id'];
$result= Analysisbasedwithdraw::find_by_plan_id($plan_id);
$bhautik_details = Bhautik_lakshya::find_by_sql("select * from bhautik_lakshya where plan_id=$plan_id and type=2");
$katti_details = KattiDetails::find_by_sql("select * from katti_details where plan_id=$plan_id and type=1");
$kar_bibaran = Kar_Bibran::find_by_sql("select * from kar_bibaran where darta_id =".$plan_id);
foreach($katti_details as $aa)
{
    $aa->delete();
}
foreach($bhautik_details as $a)
{
    $a->delete();
}
foreach($result as $data)
{
    $data->delete();
}
foreach($kar_bibaran as $kr)
{
    $kr->delete();
}
redirect_to("plan_form4.php");