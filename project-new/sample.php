<?php
require_once("includes/initialize.php"); 
$datas= Plandetails1::find_all();
foreach($datas as $data)
{
    $result = Plandetails1::find_by_id($data->id);
    $result->investment_amount = $data->investment_amount/1000;
    $result->save();
}
?>