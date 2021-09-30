<?php
require_once("includes/initialize.php");
$res = array();
$html = "";
$budget_id = $_POST['budget_id'];
$fiscal_id=$_POST['fiscal_id'];
$total_investment = Plandetails1::get_total_investment_by_budget_id($fiscal_id,$budget_id);
$budget_result =  Topicbudgetprofile::find_by_budget_topic_id($budget_id);
$remaining_amount = $budget_result->amount - $total_investment;
if(empty($budget_result))
{
    $budget_amount=0;
}
else
{
    $budget_amount=$budget_result->amount;
}
$html .= "बजेट शिर्षकमा बाकी रकम: ";
$html .= convertedcit(placeholder($remaining_amount));
$res['total_investment']=$total_investment;
$res['remaining_amount'] = $html;
$res['budget_amount']=$budget_amount;
$res['total_amount'] = "बजेट शिर्षकमा जम्मा रकम: ".convertedcit(placeholder($budget_amount));
echo json_encode($res);exit;