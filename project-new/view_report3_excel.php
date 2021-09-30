<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
 $mode=getUserMode();
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
$samjhauta_array=$counted_result['more_detail_count_array'];
$total_investment3 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $samjhauta_array));
$result=  Plandetails1::find_by_plan_id(implode(",", $samjhauta_array));

$output="";
$output.='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
    

$output.='<table border="2">
                            <tr>
                            <td colspan="11" style="text-align:center;">दर्ता भई सम्झौता भएका योजना </td>
                            </tr>
                            <tr>   
                                    <td class="myCenter"><strong>सि.न </strong></td>
                                    <td class="myCenter"><strong>दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको उपशिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको विनियोजन किसिम</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं</strong></td>
                                    <td class="myCenter"><strong>अनुदान रु</strong></td>
                                    <td class="myCenter"><strong>हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"><strong>कुल बाँकी रकम</strong></td>
                                       </tr>';
                              $i=1; 
                                $total_net_payable_amount="";
                                $total_remaining_amount="";
                                foreach($result as $data):
                                    $samiti_plan_total=Samitiplantotalinvestment::find_by_plan_id($data->id);
                                $contract_plan_total=  Contract_total_investment::find_by_plan_id($data->id);
                                $amanat_lagat = AmanatLagat::find_by_plan_id($data->id);
                                $net_payable_amount=0;
                                $remaining_amount=$data->investment_amount;
                                 
                              $output.='  <tr>
                                    <td class="myCenter">'.convertedcit($i).'</td>
                                    <td class="myCenter">'.convertedcit($data->id).'</td>
                                    <td class="myCenter">'.$data->program_name.'</td>
                                    <td class="myCenter">'.Topicarea::getName($data->topic_area_id).'</td>
                                    <td class="myCenter">'.Topicareatype::getName($data->topic_area_type_id).'</td>
                                    <td class="myCenter">'.Topicareatypesub::getName($data->topic_area_type_sub_id).'</td>
                                    <td class="myCenter">'.Topicareainvestment::getName($data->topic_area_investment_id).'</td>
                                    <td class="myCenter">'.convertedcit($data->ward_no).'</td>
                                    <td class="myCenter">'.convertedcit($data->investment_amount).'</td>
                                    <td class="myCenter">'.convertedcit($net_payable_amount).'</td>
                                    <td class="myCenter">'.convertedcit($remaining_amount).'</td>
                                   </tr>';
                          $i++;
                           $total_net_payable_amount +=$net_payable_amount;
                         $total_remaining_amount +=$remaining_amount;
                         endforeach;
                    $output.='<tr>
                                    <td colspan="7">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td >'.convertedcit(placeholder($total_investment3)).'</td>
                               <td >'.convertedcit(placeholder($total_net_payable_amount)).'</td>
                             <td >'.convertedcit(placeholder($total_remaining_amount)).'</td>
                         </tr>
                     </table>';            
                               $output.='</body></html>';
?>

<?php
 header("Content-Type: application/xls");
header("Content-Disposition: application; filename=report0.xls");
echo $output;
?>	