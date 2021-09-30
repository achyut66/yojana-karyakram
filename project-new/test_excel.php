<?php
require_once 'includes/initialize.php';
include "menuincludes/header.php";
$datas=  Plandetails1::find_by_sql("select * from plan_details1 where type=0");
$output="";
$output.='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
$output.='<table class="table table-bordered">
    <tr>
        <th> योजनाको नाम </th>
        <th> वडा नं </th>
        <th>बजेट </th>
        <th>घर संख्या </th>
        <th>स्वीकृत मिति </th>
        <th>सुरु मिति </th>
        <th>पुरा हुने मिति </th>
        <th>उपोवोक्ता नाम </th>
        <th> ठेक्का नाम </th>
    </tr>';
   foreach($datas as $data):
        $profitable_family=  Profitablefamilydetails::find_by_plan_id($data->id);
    $more_plan=  Moreplandetails::find_by_plan_id($data->id);
    $costumer=  Costumerassociationdetails0::find_by_plan_id($data->id);
    //$bid_result= Contractbidfinal::find_by_plan_id_and_status($data->id, 1);
   // $name=  Contractinvitationforbid::find_by_id($bid_result->id);
   $output.=' <tr>
        <td>'.$data->program_name.'</td>
        <td>'.$data->ward_no.'</td>
        <td>'.$data->investment_amount.'</td>
        <td>'.$profitable_family->pariwar_population.'</td>
        <td>'.$more_plan->miti.'</td>
        <td>'.$more_plan->yojana_start_date.'</td>
        <td>'.$more_plan->yojana_sakine_date.'</td>
        <td>'.$costumer->program_organizer_group_name.'</td>
        <td></td>
    </tr>';
    endforeach;
$output.='</table>';
$output.='</body></html>';
header("Content-Type: application/xls");
header("Content-Disposition: application; filename=test.xls");
echo $output;
?>