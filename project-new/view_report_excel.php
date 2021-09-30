<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
  $counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
$final_plan_array = $counted_result['final_count_array'];

if(!empty($final_plan_array))
{
    $total_investment = Plandetails1::get_total_investment_by_plan_ids(implode(",",$final_plan_array));
   $result =  Plandetails1::find_by_plan_id(implode(",",$final_plan_array));
}
else
{
    $total_investment=0;
    $result='';
}
$output="";
$output.='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
    

$output.='<table border="2">
                            <tr>
                            <td colspan="11" style="text-align:center;">अन्तिम भुक्तानी लागेको आथवा सम्पन्न भएका योजना संख्या</td>
                            </tr>
                            <tr>       <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं </strong></td>
                                    <td class="myCenter"><strong>अनुदान रु</strong></td>
                                    <td class="myCenter"><strong>हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"><strong>कुल बाँकी रकम</strong></td>
                                    <td class="myCenter"><strong>भुक्तानी भएको मिति </strong></td>
                                     </tr>';
                                 $i=1;
                                $total_net_payable=0;
                                $total_remaining=0;
                                foreach($result as $data):
                                  $samiti_plan_total=  Samitiplantotalinvestment::find_by_plan_id($data->id);
                                  $contract_plan_total=  Contractinfo::find_by_plan_id($data->id);
                                  $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                  $amanat_lagat = AmanatLagat::find_by_plan_id($data->id);
                                   $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                  if(!empty($contract_plan_total))
                                  {
                                      $final_date=  Contractamountwithdrawdetails::find_by_plan_id($data->id);
                                      $date=$final_date->created_date;
                                  }
                                  else
                                  {
                                      $final_date= Planamountwithdrawdetails::find_by_plan_id($data->id);
                                      $date=$final_date->created_date;
                                  }
                                  
                                  if(!empty($budget))
                                   {
                                       $net_payable_amount =$budget->total_expenditure;
                                       $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                   }
                                   else
                                       {
                                            if(empty($contract_result))
                                                 {
                                                    $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                    $remaining_amount=$data->investment_amount - $net_payable_amount;
                                                  }
                                                  else
                                                  {
                                                      $net_payable_amount=get_contract_net_kharcha_amount($data->id);
                                                      $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                  }
                                       }
                                  
                                 
                                  
                                $output.='<tr>
                                     <td class="myCenter">'.convertedcit($i).'</td>
                                    <td class="myCenter">'.convertedcit($data->id).'</td>
                                    <td class="myCenter">'.$data->program_name.'</td>
                                    <td class="myCenter">'.Topicarea::getName($data->topic_area_id).'</td>
                                    <td class="myCenter">'.Topicareatype::getName($data->topic_area_type_id).'</td>
                                    <td class="myCenter">'.convertedcit($data->ward_no).'</td>
                                    <td class="myCenter">'.convertedcit($data->investment_amount).'</td>
                                     <td class="myCenter">'.convertedcit($net_payable_amount).'</td>
                                      <td class="myCenter">'.convertedcit($remaining_amount).'</td>
                                      <td class="myCenter">'.convertedcit($date).'</td>
                                     </tr>';
                       $i++; 
                         $total_net_payable+=$net_payable_amount;
                                $total_remaining+=$remaining_amount;
                         endforeach;
                             $output.='   <tr>
                                    <td colspan="5">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td >'.convertedcit(placeholder($total_investment)).'</td>
                             <td >'.convertedcit(placeholder($total_net_payable)).'</td>
                             <td >'.convertedcit(placeholder($total_remaining)).'</td>
                                </tr>
                     </table>';            
                               $output.='</body></html>';
?>

<?php
 header("Content-Type: application/xls");
header("Content-Disposition: application; filename=report0.xls");
echo $output;
?>	