<?php require_once("includes/initialize.php");
//error_reporting(1);
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(empty($_GET['plan_id']))
{
    alertBox("कार्य असफल","napi_lagat_dashboard.php");
}
else
{
    $profile = NapiLagatProfile::find_by_plan_id_period($_GET['plan_id'],$_GET['period']);
        $del_lagats = Napilagatanuman::find_by_plan_id_period($_GET['plan_id'],$_GET['period']);
        foreach($del_lagats as $del_lagat)
        {
            $del_lagat->delete();
        }
        $del_break_lagats = Napilagatanumanbreak::find_by_plan_id_period($_GET['plan_id'],$_GET['period']);
        foreach($del_break_lagats as $del_break_lagat)
        {
            $del_break_lagat->delete();
        }
        $profile->delete();
        echo alertBox("कार्य सफल","napi_lagat_dashboard.php");
}
        