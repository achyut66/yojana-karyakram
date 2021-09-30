<?php require_once("includes/initialize.php");
$output ="";
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
    $final_array=$counted_result['final_count_array'];
$fiscals=  Fiscalyear::find_all();
$topic_area=  Topicarea::find_all();
    $plan_type=$_GET['plan_type'];
    $fiscal_id=$_GET['fiscal_id'];
    $type=$_GET['type'];
    $topic_area_id=$_GET['topic_area_id'];
   
   $output.='<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body><div style="text-align:center;">
                                      <span style="text-align:center;">'.SITE_LOCATION.'</span><br>
                          <span  style="text-align:center;">'.SITE_ADDRESS.'</span><br>
                           <span  style="text-align:center;">योजनाको प्रगती विवरण</span><br>
                       
                                  </div>';
                                $plan_type_name=get_plan_type($plan_type);
                                 $result_array=get_function_by_plan_type($plan_type);
                                  $output.='<h3>';if(!empty($_GET['ward_no'])){$output.= "वार्ड नं ".convertedcit($_GET['ward_no'])." को ". $plan_type_name;}else{ $output.=$plan_type_name ;} $output.='</h3><br>';
if($topic_area_id!="all"){
                              $output.='
                                  <h3 style="text-align: left;"><strong>'.Topicarea::getName($topic_area_id).'</strong></h3>
                                   <table class="table-bordered table-responsive mytable" border="2">';
                   $output.='<tr>
                           <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td colspan="5" class="myCenter"><strong>योजना</strong></td>
                          <td colspan="3" class="myCenter"><strong>भुक्तानीको अबस्था</strong></td>
                          <td colspan="2" class="myCenter"><strong>लाभान्वित जनसंख्या </strong></td>
                        </tr>
                        <tr>
                          <td class="myCenter" rowspan="2"><strong>सि.नं.</strong></td>
                          <td class="myCenter" rowspan="2"><strong>दर्ता नं </strong></td>
                          <td class="myCenter" rowspan="2"><strong>योजनाको नाम</strong></td>
                          <td class="myCenter" rowspan="2"><strong>वडा नं</strong></td>
                          <td class="myCenter" rowspan="2"><strong>अनुदानको किसिम</strong></td>
                          <td class="myCenter" rowspan="2"><strong>योजनाको कुल अनुदान </strong></td>
                          <td class="myCenter" rowspan="2"><strong>संचालन प्रकिया</strong></td>
                          <td class="myCenter" rowspan="2"><strong>संझौता मिति</strong></td>
                          <td class="myCenter" rowspan="2"><strong>कार्य संम्पन्न गर्नुपर्ने मिति</strong></td>
                          <td class="myCenter" rowspan="2"><strong>कार्य संम्पन्न भएको मिति</strong></td>
                          <td class="myCenter" rowspan="2"> <strong>भुक्तानी घटी रकम   </strong></td>
                          <td class="myCenter" rowspan="2"><strong>हाल सम्मको भुक्तानी</strong></td>
                         <td class="myCenter" rowspan="2"><strong>भुक्तानी दिन बाँकी रकम</strong></td>
                          <td class="myCenter" rowspan="2"><strong>पुरुष</strong></td>
                          <td class="myCenter" rowspan="2"><strong>महिला</strong></td>
                        </tr>';
                     if($type==0): 
                          $topic_area_type_ids =  Plandetails1::find_distinct_topic_area_type_id($topic_area_id,0,$_GET['ward_no']);
                         foreach($topic_area_type_ids as $topic_area_selected){ 
                                 $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($_GET['topic_area_id'],$topic_area_selected,0,$_GET['ward_no']);
 $output.=' <tr>
                              <td colspan="15"><div style="text-align:center;">
                            
                            <strong> <span>'.Topicareatype::getName($topic_area_selected).'</span></strong><br>
                            </td>
                        </tr>';
                        
                           foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
                                          if(empty($_GET['ward_no']))
                               {
                                   $sql = "select * from plan_details1 where type=0 and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;   
                               }
                               else
                               {
                                   $sql = "select * from plan_details1 where ward_no=".$_GET['ward_no']." and type=0 and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;   
                               }  
                                                $result =  Plandetails1::find_by_sql($sql);
            
                          $output.='<tr> <td colspan="15"> <b>'.Topicareatypesub::getName($topic_area_type_sub_id).'</b></td></tr>'; 
                        $total_male=0;
                        $total_female=0;
                        $total=0;
                        $total1=0;
                        $total2=0;
                         $j = 1;
                        foreach($result as $data){
                        $katti_result = get_kar_katti_rakam($data->id);
                        if(in_array($data->id,$result_array))
                        
                            {
                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                    $data1=  Plantotalinvestment::find_by_plan_id($data->id);
                                    $data2= Moreplandetails::find_by_plan_id($data->id);
                                    $contract_total = Contract_total_investment::find_by_plan_id($data->id);
                                    $samiti_total = Samitiplantotalinvestment::find_by_plan_id($data->id);
                                    $contract_data =  Contractmoredetails::find_by_plan_id($data->id);
                                    $samiti_data= Samitimoreplandetails::find_by_plan_id($data->id);
                                    $data3= Profitablefamilydetails::find_by_plan_id($data->id);
                                    $data4=Planamountwithdrawdetails::find_by_plan_id($data->id);
                                    $contract_final = Contractamountwithdrawdetails::find_by_plan_id($data->id);
                                    $samti_profitable=  Samitiprofitablefamilydetails::find_by_plan_id($data->id);
                                    $data6=Plantotalinvestment::find_by_plan_id($data->id);
                                    // भुक्तानी दिन बाँकी रकम
                                    if(!empty($final_amount_result))
                                      {
                                          $ghati_amount = $final_amount_result->final_bhuktani_ghati_amount;
                                      }
                                      else
                                      {
                                           $ghati_amount =0;
                                      }
                                        
                                    if(!empty($data2)|| !empty($data3) || !empty($data4))
                                    {
                                        $miti= $data2->miti;
                                        $yojana_sakine_date=$data2->yojana_sakine_date;
                                        $plan_end_date=$data4->plan_end_date;
                                        $male  = $data3->male;
                                        $female = $data3->female;
                                    }
                                    elseif(!empty($contract_data) ||  !empty($contract_final))
                                    {
                                        $miti= $contract_data->miti;
                                        $yojana_sakine_date=$contract_data->completion_date;
                                        $plan_end_date=$contract_final->plan_end_date;
                                        $male= $contract_data->male;
                                        $female= $contract_data->female;
                                    }
                                    else
                                    {
                                        $miti= $samiti_data->miti;
                                        $yojana_sakine_date=$samiti_data->yojana_sakine_date;
                                        $plan_end_date=$data4->plan_end_date;
                                        $male=  $samti_profitable->male;
                                        $female= $samti_profitable->female;
                                    }
                                    if(!empty($data2))
                                            {
                                                $name="उपभोक्ता समति";
                                            }
                                     elseif(!empty($contract_data))
                                            {
                                                $name="ठेक्का मार्फत  ";
                                            }
                                      else
                                            {
                                                 $name="संस्था /समिति ";
                                            }
                                          
                                    if(!empty($data1))
                                    {
                                            if(empty($data1->unit_id)&& empty($data1->unit_total))
                                                {
                                                    $unit=0;
                                                }
                                            else
                                                {
                                                    $unit=convertedcit($data1->unit_total)." ".Units::getName($data1->unit_id);
                                            }
                                    }
                                    elseif(!empty($contract_total))
                                    {
                                            if(empty($contract_total->unit_id)&& empty($contract_total->unit_total))
                                                {
                                                    $unit=0;
                                                }
                                            else
                                                {
                                                    $unit=convertedcit($contract_total->unit_total)." ".Units::getName($contract_total->unit_id);
                                                }
                                    }
                                    else
                                    {
                                            if(empty($samiti_total->unit_id)&& empty($samiti_total->unit_total))
                                                {
                                                    $unit=0;
                                                }
                                            else
                                                {
                                                    $unit=convertedcit($samiti_total->unit_total)." ".Units::getName($samiti_total->unit_id);
                                                }
                                    }
                                    
                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                       $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                      if(!empty($budget))
                                      {
                                          $net_payable_amount =$budget->total_expenditure;
                                          $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                      }
                                      else{ 
                                               if(empty($contract_result))
                                                    {
                                                            $data->investment_amount = get_investment_amount($data->id);
                                                            if(in_array($data->id, $final_array))
                                                                {
                                                                     $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                                     $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                }
                                                                else
                                                                {

                                                                     $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                        //                                             echo $net_payable_amount;exit;
                                                                    $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                } 
                                                    }
                                                    else
                                                    {
                                                       if(in_array($data->id, $final_array))
                                                            {
                                                                $net_payable_amount=get_contract_net_kharcha_amount($data->id);
                                                                 $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                            }
                                                            else
                                                            {

                                                                 $net_payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                                 $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                            }  

                                                    }
                                             }   

                              
                               $output.='<tr>
                                  <td>'.convertedcit($j).'</td>
                                      <td>'.convertedcit($data->id).'</td>
                                  <td>'.$data->program_name.'</td>
                                  <td>'.convertedcit($data->ward_no).'</td>
                                  <td>'.Topicareaagreement::getName($data->topic_area_agreement_id).'</td>
                                  <td>'.convertedcit(get_investment_amount($data->id)).'</td>
                                  <td>'.$name.'</td>
                                 <td>'.convertedcit($miti).'</td>
                                  <td>'.convertedcit($yojana_sakine_date).'</td>
                                  <td>'.convertedcit($plan_end_date).'</td>
                                <td class="myCenter">'.convertedcit(placeholder($ghati_amount)).'</td>
                                  <td>'.convertedcit($net_payable_amount).'</td>
                                  <td>'.convertedcit($remaining_amount).'</td>
                                  <td>'.convertedcit($male).'</td>
                                  <td>'.convertedcit($female).'</td>
                                </tr>';
                                 $j++ ;
                                $total += get_investment_amount($data->id);
                                $total1 +=$net_payable_amount;
                                $total2 +=$remaining_amount;
                                $total3+=$ghati_amount;
                                $total_male +=$male;
                                $total_female +=$female;
                                 $total4+=$katti_result['total_contingency'];
                                $total4+=$katti_result['total_kar'];
                                $total4+=$katti_result['total_aanya'];
                        }
                        }
                        if(empty($total))
                            {
                                        continue;
                            }
                   
                    $output.='<tr>
                          <td>&nbsp;</td>
                          <td>जम्मा</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>'.convertedcit($total).'</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>'.convertedcit($total3).'</td>
                          <td>'.convertedcit($total1).'</td>
                          <td>'.convertedcit($total2).'</td>
                          <td>'.convertedcit($total_male).'</td>
                          <td>'.convertedcit($total_female).'</td>
                        </tr>';
                   endforeach;}  
                     $output.='</table>';
                endif;
}
else
{
    $topic_area_result = Topicarea::find_all();
//    print_r($topic_area_result);exit;
    foreach($topic_area_result as $topic_id)
    {
        $area_id= $topic_id->id;
        $topic_area_type_ids =  Plandetails1::find_distinct_topic_area_type_id($area_id,0,$_GET['ward_no']);
     $output.='
                                  <h3 style="text-align: left;"><strong>'.Topicarea::getName($area_id).'</strong></h3>
                                   <table class="table-bordered table-responsive mytable" border="2">';
                   $output.='<tr>
                           <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td colspan="5" class="myCenter"><strong>योजना</strong></td>
                          <td colspan="3" class="myCenter"><strong>भुक्तानीको अबस्था</strong></td>
                          <td colspan="2" class="myCenter"><strong>लाभान्वित जनसंख्या </strong></td>
                        </tr>
                        <tr>
                          <td class="myCenter" rowspan="2"><strong>सि.नं.</strong></td>
                          <td class="myCenter" rowspan="2"><strong>दर्ता नं </strong></td>
                          <td class="myCenter" rowspan="2"><strong>योजनाको नाम</strong></td>
                          <td class="myCenter" rowspan="2"><strong>वडा नं</strong></td>
                          <td class="myCenter" rowspan="2"><strong>अनुदानको किसिम</strong></td>
                          <td class="myCenter" rowspan="2"><strong>योजनाको कुल अनुदान </strong></td>
                          <td class="myCenter" rowspan="2"><strong>संचालन प्रकिया</strong></td>
                          <td class="myCenter" rowspan="2"><strong>संझौता मिति</strong></td>
                          <td class="myCenter" rowspan="2"><strong>कार्य संम्पन्न गर्नुपर्ने मिति</strong></td>
                          <td class="myCenter" rowspan="2"><strong>कार्य संम्पन्न भएको मिति</strong></td>
                        <td class="myCenter" rowspan="2"> <strong>भुक्तानी घटी रकम   </strong></td>
                          <td class="myCenter" rowspan="2"><strong>हाल सम्मको भुक्तानी</strong></td>
                         <td class="myCenter" rowspan="2"><strong>भुक्तानी दिन बाँकी रकम</strong></td>
                          <td class="myCenter" rowspan="2"><strong>पुरुष</strong></td>
                          <td class="myCenter" rowspan="2"><strong>महिला</strong></td>
                        </tr>';
                     if($type==0): foreach($topic_area_type_ids as $topic_area_selected){ 
                                 $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($area_id,$topic_area_selected,0,$_GET['ward_no']);
 $output.=' <tr>
                              <td colspan="15"><div style="text-align:center;">
                            
                            <strong> <span>'.Topicareatype::getName($topic_area_selected).'</span></strong><br>
                            </td>
                        </tr>';
                        
                           foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
                                          if(empty($_GET['ward_no']))
                               {
                                   $sql = "select * from plan_details1 where type=0 and topic_area_id=".$area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;   
                               }
                               else
                               {
                                   $sql = "select * from plan_details1 where ward_no=".$_GET['ward_no']." and type=0 and topic_area_id=".$area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;   
                               }  
                                                $result =  Plandetails1::find_by_sql($sql);
            
                          $output.='<tr> <td colspan="15"> <b>'.Topicareatypesub::getName($topic_area_type_sub_id).'</b></td></tr>'; 
                        $total_male=0;
                        $total_female=0;
                        $total=0;
                        $total1=0;
                        $total2=0;
                         $j = 1;
                        foreach($result as $data){
                        $katti_result = get_kar_katti_rakam($data->id);
                        if(in_array($data->id,$result_array))
                        
                            {
                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                    $data1=  Plantotalinvestment::find_by_plan_id($data->id);
                                    $data2= Moreplandetails::find_by_plan_id($data->id);
                                    $contract_total = Contract_total_investment::find_by_plan_id($data->id);
                                    $samiti_total = Samitiplantotalinvestment::find_by_plan_id($data->id);
                                    $contract_data =  Contractmoredetails::find_by_plan_id($data->id);
                                    $samiti_data= Samitimoreplandetails::find_by_plan_id($data->id);
                                    $data3= Profitablefamilydetails::find_by_plan_id($data->id);
                                    $data4=Planamountwithdrawdetails::find_by_plan_id($data->id);
                                    $contract_final = Contractamountwithdrawdetails::find_by_plan_id($data->id);
                                    $samti_profitable=  Samitiprofitablefamilydetails::find_by_plan_id($data->id);
                                    $data6=Plantotalinvestment::find_by_plan_id($data->id);
                                    // भुक्तानी दिन बाँकी रकम
                                    if(!empty($final_amount_result))
                                      {
                                          $ghati_amount = $final_amount_result->final_bhuktani_ghati_amount;
                                      }
                                      else
                                      {
                                           $ghati_amount =0;
                                      }
                                        
                                    if(!empty($data2)|| !empty($data3) || !empty($data4))
                                    {
                                        $miti= $data2->miti;
                                        $yojana_sakine_date=$data2->yojana_sakine_date;
                                        $plan_end_date=$data4->plan_end_date;
                                        $male  = $data3->male;
                                        $female = $data3->female;
                                    }
                                    elseif(!empty($contract_data) ||  !empty($contract_final))
                                    {
                                        $miti= $contract_data->miti;
                                        $yojana_sakine_date=$contract_data->completion_date;
                                        $plan_end_date=$contract_final->plan_end_date;
                                        $male= $contract_data->male;
                                        $female= $contract_data->female;
                                    }
                                    else
                                    {
                                        $miti= $samiti_data->miti;
                                        $yojana_sakine_date=$samiti_data->yojana_sakine_date;
                                        $plan_end_date=$data4->plan_end_date;
                                        $male=  $samti_profitable->male;
                                        $female= $samti_profitable->female;
                                    }
                                    if(!empty($data2))
                                            {
                                                $name="उपभोक्ता समति";
                                            }
                                     elseif(!empty($contract_data))
                                            {
                                                $name="ठेक्का मार्फत  ";
                                            }
                                      else
                                            {
                                                 $name="संस्था /समिति ";
                                            }
                                          
                                    if(!empty($data1))
                                    {
                                            if(empty($data1->unit_id)&& empty($data1->unit_total))
                                                {
                                                    $unit=0;
                                                }
                                            else
                                                {
                                                    $unit=convertedcit($data1->unit_total)." ".Units::getName($data1->unit_id);
                                            }
                                    }
                                    elseif(!empty($contract_total))
                                    {
                                            if(empty($contract_total->unit_id)&& empty($contract_total->unit_total))
                                                {
                                                    $unit=0;
                                                }
                                            else
                                                {
                                                    $unit=convertedcit($contract_total->unit_total)." ".Units::getName($contract_total->unit_id);
                                                }
                                    }
                                    else
                                    {
                                            if(empty($samiti_total->unit_id)&& empty($samiti_total->unit_total))
                                                {
                                                    $unit=0;
                                                }
                                            else
                                                {
                                                    $unit=convertedcit($samiti_total->unit_total)." ".Units::getName($samiti_total->unit_id);
                                                }
                                    }
                                    
                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                       $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                      if(!empty($budget))
                                      {
                                          $net_payable_amount =$budget->total_expenditure;
                                          $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                      }
                                      else{ 
                                               if(empty($contract_result))
                                                    {       $data->investment_amount = get_investment_amount($data->id);
                                                            if(in_array($data->id, $final_array))
                                                                {
                                                                     $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                                     $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                }
                                                                else
                                                                {

                                                                     $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                        //                                             echo $net_payable_amount;exit;
                                                                    $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                } 
                                                    }
                                                    else
                                                    {
                                                       if(in_array($data->id, $final_array))
                                                            {
                                                                $net_payable_amount=get_contract_net_kharcha_amount($data->id);
                                                                 $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                            }
                                                            else
                                                            {

                                                                 $net_payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                                 $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                            }  

                                                    }
                                             }   

                              
                               $output.='<tr>
                                  <td>'.convertedcit($j).'</td>
                                      <td>'.convertedcit($data->id).'</td>
                                  <td>'.$data->program_name.'</td>
                                  <td>'.convertedcit($data->ward_no).'</td>
                                  <td>'.Topicareaagreement::getName($data->topic_area_agreement_id).'</td>
                                  <td>'.convertedcit(get_investment_amount($data->id)).'</td>
                                  <td>'.$name.'</td>
                                 <td>'.convertedcit($miti).'</td>
                                  <td>'.convertedcit($yojana_sakine_date).'</td>
                                  <td>'.convertedcit($plan_end_date).'</td>
                                 <td class="myCenter">'.convertedcit(placeholder($ghati_amount)).'</td>
                                  <td>'.convertedcit($net_payable_amount).'</td>
                                  <td>'.convertedcit($remaining_amount).'</td>
                                  <td>'.convertedcit($male).'</td>
                                  <td>'.convertedcit($female).'</td>
                                </tr>';
                                 $j++ ;
                                $total += get_investment_amount($data->id);
                                $total1 +=$net_payable_amount;
                                $total2 +=$remaining_amount;
                                $total3+=$ghati_amount;
                                $total_male +=$male;
                                $total_female +=$female;
                                 $total4+=$katti_result['total_contingency'];
                                $total4+=$katti_result['total_kar'];
                                $total4+=$katti_result['total_aanya'];
                        }
                        }
                        if(empty($total))
                            {
                                        continue;
                            }
                   
                    $output.='<tr>
                          <td>&nbsp;</td>
                          <td>जम्मा</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>'.convertedcit($total).'</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>'.convertedcit($total3).'</td>
                          <td>'.convertedcit($total1).'</td>
                          <td>'.convertedcit($total2).'</td>
                          <td>'.convertedcit($total_male).'</td>
                          <td>'.convertedcit($total_female).'</td>
                        </tr>';
                   endforeach;}  
                     $output.='</table>';
                endif;
    }
}
$output.="</body></html>";
header("Content-Type: application/xls");
header("Content-Disposition: application; filename=mainreport1.xls");
echo $output; ?>