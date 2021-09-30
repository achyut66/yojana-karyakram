<?php require_once("includes/initialize.php");
//include("menuincludes/header.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
  $mode=getUserMode();
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
if(empty($_GET['ward_no']))
{
$sql ="select * from plan_details1 where type=0";
}
else
{
    $sql ="select * from plan_details1 where type=0 and ward_no=".$_GET['ward_no'];
}
//$sql ="select * from plan_details1 where type=0";
$result=  Plandetails1::find_by_sql($sql);
$plan_array=array();
foreach($result as $data)
{
    array_push($plan_array, $data->id);
   
}

$count0=count($plan_array);
$total_investment0 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $plan_array));
$result=  Plandetails1::find_by_plan_id(implode(",", $plan_array));
$output="";
$output.='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
    

$output.='<table border="2">
                            <tr>
                            <td colspan="11" style="text-align:center;">कुल योजना </td>
                            </tr>
                           <tr>   
                                    <td class="myCenter"><strong>सि.न </strong></td>
                                    <td class="myCenter"><strong>दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको उपशिर्षकगत किसिम</strong></t>
                                    <td class="myCenter"><strong>योजनाको विनियोजन किसिम</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं </strong></td>
                                    <td class="myCenter"><strong>अनुदान रु </strong></td>
                                    <td class="myCenter"><strong>हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"><strong> कुल बाँकी रकम</strong></td>
                                   </tr>';
                                 $i=1; 
                                $total_net_payable_amount=0;
                                $total_remaining_amount=0;
                                    foreach($result as $data):
                                    $samiti_plan_total=Samitiplantotalinvestment::find_by_plan_id($data->id);
                                   $contract_plan_total=  Contract_total_investment::find_by_plan_id($data->id);    
                                     $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                     $amanat_lagat = AmanatLagat::find_by_plan_id($data->id);
                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                   if(!empty($budget))
                                   {
                                       $net_payable_amount =$budget->total_expenditure;
                                       $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                   }
                                   else{ 
                                            if(empty($contract_result))
                                                 {
                                                         if(in_array($data->id, $final_array))
                                                             {
                                                                  $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                                  $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                             }
                                                             else
                                                             {

                                                                  $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                                  $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                             } 
                                                 }
                                                 else
                                                 {
                                                    if(in_array($data->id, $final_array))
                                                         {
                                                             $net_payable_amount=get_contract_net_kharcha_amount($data->id);
                                                             $remaining_amount=$data->investment_amount - $payable_amount; 
                                                             
                                                         }
                                                         else
                                                         {

                                                              $net_payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                              $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                         }  
                                                         
                                                          
                                                 }
                                          }   
                            if($data->type==1)
                                {
                                    $link = "program_total_view.php?id=".$data->id;
                                }
                                elseif($data->type==0 && !empty($samiti_plan_total))
                                {
                                    $link="view_samiti_plan_form.php?id=".$data->id; 
                                }
                                 elseif($data->type==0 && !empty($contract_plan_total))
                                {
                                    $link="view_all_contract.php?id=".$data->id; 
                                }
                                 elseif($data->type==0 && !empty($amanat_lagat))
                                {
                                    $link= "view_all_amanat.php?id=".$data->id;
                                }
                                else
                                {
                                 $link="view_plan_form.php?id=".$data->id;   
                                }
                             
                             $output.='<tr>
                                    <td class="myCenter">'.convertedcit($i).'</td>
                                    <td class="myCenter">'.convertedcit($data->id).'</td>
                                    <td class="myCenter">'.$data->program_name.'</td>
                                    <td class="myCenter">'.Topicarea::getName($data->topic_area_id).'</td>
                                    <td class="myCenter">'.Topicareatype::getName($data->topic_area_type_id).'</td>
                                    <td class="myCenter">'.Topicareatypesub::getName($data->topic_area_type_sub_id).'</td>
                                    <td class="myCenter">'.Topicareainvestment::getName($data->topic_area_investment_id).'</td>
                                    <td class="myCenter">'.convertedcit($data->ward_no).'</td>
                                    <td class="myCenter">'.convertedcit(placeholder($data->investment_amount)).'</td>
                                    <td class="myCenter">'.convertedcit(placeholder($net_payable_amount)).'</td>
                                      <td class="myCenter">'.convertedcit(placeholder($remaining_amount)).'</td>
                                     </tr>';
                          $i++; 
                          $total_net_payable_amount +=$net_payable_amount;
                         $total_remaining_amount +=$remaining_amount;
                         endforeach;
                               $output.=' <tr>
                                    <td colspan="7">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td >'.convertedcit(placeholder($total_investment0)).'</td>
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