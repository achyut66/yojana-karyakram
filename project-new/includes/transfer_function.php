<?php
function transfer_plan_details($obj)
{  
//    echo $config;
//    print_r($obj);exit;
//    require_once($config);
    $database = new MySQLDatabase("localhost","root","","sample");
    $data = new Plandetails1();
    $data->budget_id=$obj->budget_id;
    $data->fiscal_id=$obj->fiscal_id;
    $data->type=$obj->type;
    $data->expenditure_type=$obj->expenditure_type;
    $data->parishad_sno=$obj->parishad_sno;
    $data->topic_area_id=$obj->topic_area_id;
    $data->topic_area_type_id=$obj->topic_area_type_id;
    $data->topic_area_type_sub_id=$obj->topic_area_type_sub_id;
    $data->topic_area_agreement_id=$obj->topic_area_agreement_id;
    $data->topic_area_investment_id=$obj->topic_area_investment_id;
    $data->ward_no=$obj->ward_no;
    $data->program_name=$obj->program_name;
    $data->investment_amount=$obj->investment_amount;
    $data->first=$obj->first;
    $data->second=$obj->second;
    $data->third=$obj->third;
    $plan_id=$data->save();
//    redirect_to("transfer_programs.php");
    return $plan_id;
}
