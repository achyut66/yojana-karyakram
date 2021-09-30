<?php
function replace_all_text_between($str, $start, $end, $replacement) {

    $replacement =  $replacement ;

    $start = preg_quote($start, '/');
    $end = preg_quote($end, '/');
    $regex = "/({$start})(.*?)({$end})/";
    return preg_replace($regex,$replacement,$str);
}




function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function get_investment_amount($plan_id)
{
    $details_one = Plantotalinvestment::find_by_plan_id($plan_id);
    $detail_two = Samitiplantotalinvestment::find_by_plan_id($plan_id);
    $detail_three = AmanatLagat::find_by_plan_id($plan_id);
    $plan_selected = Plandetails1::find_by_id($plan_id);
    if(!empty($details_one))
    {
            $investment_amount = $details_one->agreement_gauplaika + $details_one->agreement_other + $details_one->other_agreement + $details_one->costumer_agreement;
    }
    else if(!empty($detail_two))
    {
            $investment_amount = $detail_two->agreement_gauplaika + $detail_two->agreement_other + $detail_two->other_agreement + $detail_two->costumer_agreement;
    
    }
    else if(!empty($detail_three))
    {
            $investment_amount = $detail_three->agreement_gauplaika + $detail_three->agreement_other + $detail_three->other_agreement + $detail_three->costumer_agreement;
    
    }
    else
    {
            $investment_amount= $plan_selected->investment_amount;
    }
    return $investment_amount;
}

function get_kar_katti_rakam($plan_id)
{
    $contract_result= Contract_total_investment::find_by_plan_id($plan_id);
    if(empty($contract_result))
    {
        $con_analysis= Analysisbasedwithdraw::getTotalContngencyAmount($plan_id);
        $con_final = Planamountwithdrawdetails::find_by_plan_id($plan_id);
        $total_contingency = $con_analysis + $con_final->final_contengency_amount;
        
        $aanya_analysis = Analysisbasedwithdraw::getTotalaAnyaKatti($plan_id);
        $aanya_final = Planamountwithdrawdetails::find_by_plan_id($plan_id);
        $total_aanya = $aanya_analysis + $aanya_final->final_renovate_amount + $aanya_final->final_dpr_amount + $aanya_final->final_due_amount + $aanya_final->final_disaster_management_amount;
        
        $total_kar = 0;
    }
 else
    {
        $kar_analysis= Contractanalysisbasedwithdraw::getTotalakar($plan_id);
        $total_kar  = $kar_analysis;
        
        $aanya_analysis = Contractanalysisbasedwithdraw::getTotalaAnyaKatti($plan_id);
        $aanya_final = Contractanalysisbasedwithdraw::find_by_plan_id($plan_id);
        $total_aanya = $aanya_analysis + $aanya_final->final_renovate_amount  + $aanya_final->final_due_amount ;
        
        $total_contingency = 0;
    }
    $result = array(
        "total_contingency"=>$total_contingency,
        "total_aanya"=> $total_aanya,
        "total_kar"=>$total_kar
    );
    return $result;
}
function getStartEndDates($fiscal_id,$month)
{
        $month_range = new Nepali_Calendar();
        $month_get = $month;
        $fiscal_get = Fiscalyear::find_by_id($fiscal_id);
        $fiscal_array = explode(".", $fiscal_get->year);

   
        
    if($month_get==1||$month_get==2||$month_get==3)
    {
      $start_date_nepali = "2".$fiscal_array[1]."-".$month_get."-"."01";
      $year_get = intval($fiscal_array[1]);

      $month_get_strip = intval($month_get);
      $end_day = $month_range->month_date_range[$year_get][$month_get_strip];
      //$end_day = $month_range->month_date_range[strip_zeros_from_month($fiscal_array[1])] ;
      
      $end_date_nepali = "2".$fiscal_array[1]."-".$month_get."-".$end_day;
      $sel_year = "2".$fiscal_array[1];
    }
    else
    {
      //DateNepToEng(
      $start_date_nepali = $fiscal_array[0]."-".$month_get."-"."01";
      $year_get = intval($fiscal_array[0]);
      $year_get = substr($year_get,2,2);
      $month_get_strip = intval($month_get);
      $end_day = $month_range->month_date_range[$year_get][$month_get_strip];
      //$end_day = $month_range->month_date_range[strip_zeros_from_month($fiscal_array[1])] ;
      
      $end_date_nepali = $fiscal_array[0]."-".$month_get."-".$end_day;  
      $sel_year = $fiscal_array[0];
    }
      
    //echo $start_date_nepali." ".$end_date_nepali; exit;
     $start_date = DateNepToEng($start_date_nepali);
    $end_date  = DateNepToEng($end_date_nepali);
   $start_end_array = array($start_date,$end_date,$sel_year);
   return $start_end_array;
}
function get_contingency_for_plan($plan_id)
{
    $result = Contingency::find_by_plan_id($plan_id);
if(!empty($result))
{
    $html = $result;
}
else
{
    $html= Contingency::find_by_type(1);
}
return $html;
}

function savechildplan($plan_id,$parent_plan_id,$investment_amount)
{
    $child_plan                  = new Childplandetails();
    $child_plan->plan_id         = $plan_id;
    $child_plan->parent_plan_id  =$parent_plan_id;
    $child_plan->added_date      =date('Y-m-d', time());
    if($child_plan->save())
        {
         $parent_plan= Plandetails1::find_by_id($parent_plan_id);
         $parent_plan->investment_amount = ($parent_plan->investment_amount-$investment_amount);
         $parent_plan->save();
        }
    
   
}

function find_all_child_plan_by_parent_id($parent_id)
{
    $result_array= array();
    $result = Childplandetails::find_plan_ids_by_parent_plan_id($parent_id);
    if(!empty($result))
    {
        foreach($result as $data)
        {
           $plan_details = Plandetails1::find_by_id($data->plan_id);
           array_push($result_array, $plan_details);
           
        }
    }
    return $result_array;
}



function get_budget_expenditure_in_program($ward)
{
    if(empty($ward))
    {
        $result=  Plandetails1::find_by_sql("select * from plan_details1 where type=1");
    }
    else
    {
        $result=  Plandetails1::find_by_sql("select * from plan_details1 where type=1 and ward_no=".$ward);
    }
    
    $net_expenditure=0;
    foreach($result as $data)
    {
        $budget=  Ekmustabudget::find_by_plan_id($data->id);
        if(!empty($budget))
        {
            $net_payable_amount =$budget->total_expenditure;
        }
        else
        {
            $net_payable_amount=0;
        }
        $net_expenditure +=$net_payable_amount;
    }
    return $net_payable_amount;
}
function get_upobhokta_net_kharcha_amount($plan_id)
{
    $data= Planamountwithdrawdetails::find_by_plan_id($plan_id);
     
        $kharcha_amount=$data->final_payable_amount + $data->payment_till_now;
        if(!empty($data->final_bhuktani_ghati_amount)|| $data->final_bhuktani_ghati_amount!=0)
        {
            $deducted_amount=$data->final_bhuktani_ghati_amount ;
        }
        else
        {
            $deducted_amount=0;
        }
        $net_payable=$kharcha_amount;
        return $net_payable;
}
function get_contract_net_kharcha_amount($plan_id)
{
        $data=  Contractamountwithdrawdetails::find_by_plan_id($plan_id);
        $contingency_expenditure= Contingencyexenditure::getTotalPayableAmount($plan_id);
        $kharcha_amount=$data->final_payable_amount;
        if(!empty($data->final_disaster_management_amount)|| $data->final_disaster_management_amount!=0)
        {
            $deducted_amount=$data->final_disaster_management_amount;
        }
        else
        {
            $deducted_amount=0;
        }
        $payable=$kharcha_amount - $deducted_amount;
        $net_payable=$contingency_expenditure + $payable;
//       echo $payable;exit;
        return $net_payable;
}
function get_total_expenditure_from_ekmusta_budget($clause,$string,$fiscal_id,$ward)
{
    if(empty($ward))
    {
     $sql="select * from plan_details1 where $clause=".$string." and fiscal_id=".$fiscal_id;
        
    }
    else
    {
        $sql="select * from plan_details1 where $clause=".$string." and ward_no=".$ward." and fiscal_id=".$fiscal_id;
     
    }
     $result=Plandetails1::find_by_sql($sql);
      $counted_result = getOnlyRegisteredPlans($_POST['ward_no']);
      $final_array    = $counted_result['final_count_array'];
    $total_expenditure=0;
     foreach($result as $data)
     {
             if($data->type==0)
                        {   
                                $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                {
                                    $net_payable_amount =$budget->total_expenditure;
                                 }
                                 else
                                 {
                                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                                    if(empty($contract_result))
                                                    {   
                                                            $data->investment_amount = get_investment_amount($data->id);
                                                            if(in_array($data->id, $final_array))
                                                                {
                                                                    $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                                     $remaining_amount=0; 
                                                                }
                                                                else
                                                                {

                                                                     $net_payable_amount    = Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                                     $remaining_amount      = $data->investment_amount - $net_payable_amount; 
                                                                } 
                                                    }
                                                    else
                                                    {
                                                       if(in_array($data->id, $final_array))
                                                                {
                                                                    $payable_amount=get_contract_net_kharcha_amount($data->id);
                                                                     $remaining_amount=0; 
                                                                }
                                                                else
                                                                {

                                                                     $payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                                     $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                }  
                                                                 $contingency_expenditure=  Contingencyexenditure::getTotalPayableAmount($data->id);
                                                                 $net_payable_amount=$contingency_expenditure + $payable_amount;
                                                    }
                                 }
                        }
                        else
                        {
                            $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                {
                                    $net_payable_amount =$budget->total_expenditure;
                                 }
                                 else
                                 {
                                    $program_result=Programpaymentfinal::find_by_program_id1($data->id);
                                    $advance_total = Programpayment::get_total_payment_amount($data->id);
                                    $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
                                    $net_payable_amount = $advance_total + $net_total_amount_total;
                                    $rem_budget = $data->investment_amount - $expenditure_amount;
                                 }

                        }
                        $total_expenditure +=$net_payable_amount;
         }
         
    
     return $total_expenditure;
}
function getPlanArrayForAnudanExpenditure($topic_area_agreement_id,$fiscal_id,$ward)
{
    $topic_area = Topicarea::find_all();
    $split_array = array();
    foreach($topic_area as $topic)
    {
        $split_array[$topic->id] = array();
    }
    foreach($topic_area as $topic)
    {
        if(empty($ward))
        {
            $sql="select * from plan_details1 where topic_area_agreement_id=$topic_area_agreement_id  and fiscal_id=$fiscal_id and topic_area_id=$topic->id";
        
        }
        else
        {
            $sql="select * from plan_details1 where ward_no=".$ward." and topic_area_agreement_id=$topic_area_agreement_id  and fiscal_id=$fiscal_id and topic_area_id=$topic->id";
        
        }
        $result=Plandetails1::find_by_sql($sql);
        foreach ($result as $res)
        {
            array_push($split_array[$topic->id], $res->id);
        }
    } 
    return $split_array;
}
function get_total_expenditure_in_all_plans($clause,$string,$fiscal_id)
{
    $counted_result = getOnlyRegisteredPlans();
    $final_array    = $counted_result['final_count_array'];
    $sql="select * from plan_details1 where $clause=".$string." and fiscal_id=".$fiscal_id;
//    echo $sql;exit;
    $result=  Plandetails1::find_by_sql($sql);
    $total_net_payable_amount=0;
    foreach($result as $data)
    {
         if($data->type==0)
                        {   
                                $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                {
                                    $net_payable_amount =$budget->total_expenditure;
                                 }
                                 else
                                 {
                                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                                    if(empty($contract_result))
                                                    {
                                                            if(in_array($data->id, $final_array))
                                                                {
                                                                    $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                                     $remaining_amount=0; 
                                                                }
                                                                else
                                                                {

                                                                     $net_payable_amount    = Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                                     $remaining_amount      = $data->investment_amount - $net_payable_amount; 
                                                                } 
                                                    }
                                                    else
                                                    {
                                                       if(in_array($data->id, $final_array))
                                                                {
                                                                    $payable_amount=get_contract_net_kharcha_amount($data->id);
                                                                     $remaining_amount=0; 
                                                                }
                                                                else
                                                                {

                                                                     $payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                                     $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                                                }  
                                                                 $contingency_expenditure=  Contingencyexenditure::getTotalPayableAmount($data->id);
                                                                 $net_payable_amount=$contingency_expenditure + $payable_amount;
                                                    }
                                 }
                        }
                        else
                        {
                            $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                {
                                    $net_payable_amount =$budget->total_expenditure;
                                 }
                                 else
                                 {
                                    $program_result=Programpaymentfinal::find_by_program_id1($data->id);
                                    $advance_total = Programpayment::get_total_payment_amount($data->id);
                                    $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
                                    $net_payable_amount = $advance_total + $net_total_amount_total;
                                    $rem_budget = $data->investment_amount - $expenditure_amount;
                                 }

                        }
        $total_net_payable_amount +=$net_payable_amount;
    }
    return $total_net_payable_amount;
}
function DateEngToNep1($eng_date)
{
	$cal = new Nepali_Calendar();
	$eng_date = explode("/",$eng_date);
	
	$nep_date = $cal->eng_to_nep($eng_date[0],$eng_date[1],$eng_date[2]);
	return $nep_date["year"]."/".$nep_date["month"]."/".$nep_date["date"];
	
}
function DateEngToNep($eng_date)
{
	$cal = new Nepali_Calendar();
	$eng_date = explode("-",$eng_date);
	
	$nep_date = $cal->eng_to_nep($eng_date[0],$eng_date[1],$eng_date[2]);
	return $nep_date["year"]."-".$nep_date["month"]."-".$nep_date["date"];
	
}

function setObjectValuesFromZeroToBlank($obj)
{
    $array = array("task_count","length","breadth","height");
    foreach($array as $arr)
    {
        if($obj->$arr==0)
        {
            $obj->$arr = '';
        }
    }
}
function getPeriodArray()
{
    $inst_array = array(
        1=>"पहिलो",
        2=>"दोस्रो",
        3=>"तेस्रो",
        4=>"चौथो",
        5=>"पाचौ",
        6=>"छैठो",
    );
    return $inst_array;
}
function getBillDashHtml($max_period)
{
    $check_last_napi = NapiLagatProfile::find_by_plan_id_period($_SESSION['set_plan_id'],$max_period);
    $html = '';
        for($i=1;$i<=$max_period;$i++)
        {
            if($i==$max_period && $check_last_napi->antim==1)
            {
              $html .= '<a href="bill.php?id='.$_SESSION['set_plan_id'].'&period='.$i.'"><div class="userprofile">
                                <h3>अन्तिम बिल</h3>
                                <div class="dashimg">
                                    <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                                </div>
                            </div></a>';
            }
            else
            {
                $html .= '<a href="bill.php?id='.$_SESSION['set_plan_id'].'&period='.$i.'"><div class="userprofile">
                                <h3>'.getPeriodText($i).' बिल</h3>
                                <div class="dashimg">
                                    <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                                </div>
                            </div></a>';
            }
        }
    
    
    
    return $html;
}
function getNapiDashHtml($max_period)
{
    
    $total_count = $max_period+1;
    $html = '';
    $last_flag = '';
    $check_last_napi = NapiLagatProfile::find_by_plan_id_period($_SESSION['set_plan_id'],$max_period);
    
    if(!empty($check_last_napi) && $check_last_napi->antim==1)
    {
        $last_flag = 1;
        
    }
    if($last_flag==1)
    {
        for($i=1;$i<=$max_period;$i++)
        {
            if($i==$max_period)
            {
              $html .= '<a href="napi_lagat_anuman.php?id='.$_SESSION['set_plan_id'].'&period='.$i.'"><div class="userprofile">
                                <h3>अन्तिम  हेर्नुहोस / सच्याउनुहोस</h3>
                                <div class="dashimg">
                                    <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                                </div>
                            </div></a>';
            }
            else
            {
                $html .= '<a href="napi_lagat_anuman.php?id='.$_SESSION['set_plan_id'].'&period='.$i.'"><div class="userprofile">
                                <h3>'.getPeriodText($i).'  हेर्नुहोस / सच्याउनुहोस</h3>
                                <div class="dashimg">
                                    <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                                </div>
                            </div></a>';
            }
        }
    }
    else
    {
        for($i=1;$i<=$total_count;$i++)
        {
            if($i==$total_count)
            {
              $html .= '<a href="napi_lagat_anuman.php?id='.$_SESSION['set_plan_id'].'&period='.$i.'"><div class="userprofile">
                                <h3>'.getPeriodText($i).' / अन्तिम भर्नुहोस्</h3>
                                <div class="dashimg">
                                    <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                                </div>
                            </div></a>';
            }
            else
            {
                $html .= '<a href="napi_lagat_anuman.php?id='.$_SESSION['set_plan_id'].'&period='.$i.'"><div class="userprofile">
                                <h3>'.getPeriodText($i).'  हेर्नुहोस </h3>
                                <div class="dashimg">
                                    <img src="images/upabhokta-icon.png" alt="Upabhokta Icon" class="dashimg" />
                                </div>
                            </div></a>';
            }
        }
    }
    
    
    return $html;
}
function getPeriodText($period)
{
    $period_array = getPeriodArray();
    $period_text = $period_array[$period];
    return $period_text;
}
function alertBox($alert_msg, $redirect_link)
{
    $alert = '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>';
    $alert .= '<script type="text/javascript">alert("'.$alert_msg.'");';
    if(!empty($redirect_link)):
    $alert .='window.location="'.$redirect_link.'";';
    endif; 
    $alert .='</script>;';
    return $alert;
}
function getPlanArray($topic_area_agreement_id,$ward)
{
    $topic_area = Topicarea::find_all();
    $split_array = array();
    foreach($topic_area as $topic)
    {
        $split_array[$topic->id] = array();
    }
    foreach($topic_area as $topic)
    {
        if(empty($ward))
        {
            $sql="select * from plan_details1 where topic_area_agreement_id=$topic_area_agreement_id  and topic_area_id=$topic->id";
        
        }
        else
        {
            $sql="select * from plan_details1 where ward_no=".$ward." and topic_area_agreement_id=$topic_area_agreement_id  and topic_area_id=$topic->id";
        
        }
        $result=Plandetails1::find_by_sql($sql);
        foreach ($result as $res)
        {
            array_push($split_array[$topic->id], $res->id);
        }
    } 
    return $split_array;
}
function WardWiseAddress()
{
    $user=getUser();
    if($user->mode=="administrator"||$user->mode=="superadmin")
    {
        $address=SITE_ADDRESS;
    }
    else
    {
        $address=getWardAddress($user->ward);
    }
    return $address;
}
function getWardAddress($ward)
{
    switch($ward)
    {
        case 1:
            $address=SITE_ADDRESS;
            break;
          case 2:
            $address=SITE_ADDRESS;
            break;
          case 3:
            $address=SITE_ADDRESS;
            break;
          case 4:
            $address=SITE_ADDRESS;
            break;
          case 5:
            $address=SITE_ADDRESS;
            break;
          case 6:
            $address=SITE_ADDRESS;
            break;
          case 7:
            $address=SITE_ADDRESS;
            break;
    }
    return $address;
}
function getAddress()
{
    $user= getUser();
    $ward=$user->ward;
    if($user->mode=="administrator"||$user->mode=="superadmin")
    {
        $address=SITE_HEADING;
    }
    else
    {
        $address=convertedcit($ward) ." ". SITE_SUBADDRESS;
    }
    return $address;
}
function get_access_to_second_form($plan_id)
{
    $data=  Plantotalinvestment::find_by_plan_id($plan_id);
    if(empty($data))
    {
        $msg="सम्पूर्ण फारम भरेपछि मात्र अगाडी बढ्नु होला ....!!!!";
        redirect_to("upabhoktasamitidashboard.php?msg=".$msg);
    }
}
function get_access_to_third_form($plan_id)
{
    $data=  Plantotalinvestment::find_by_plan_id($plan_id);
    $data1=  Costumerassociationdetails0::find_by_plan_id($plan_id);
   $data2=  Costumerassociationdetails::find_by_plan_id($plan_id);
    if(empty($data) || empty($data1) || empty($data2))
    {
        $msg="सम्पूर्ण फारम भरेपछि मात्र अगाडी बढ्नु होला ....!!!!";
        redirect_to("upabhoktasamitidashboard.php?msg=".$msg);
    }
}
function get_access_to_fourth_form($plan_id)
{
    $data=  Plantotalinvestment::find_by_plan_id($plan_id);
    $data1=  Costumerassociationdetails0::find_by_plan_id($plan_id);
   $data2=  Costumerassociationdetails::find_by_plan_id($plan_id);
   $data3=  investigationassociationdetails::find_by_plan_id($plan_id); 
   if(empty($data) || empty($data1) || empty($data2) || empty($data3))
    {
        $msg="सम्पूर्ण फारम भरेपछि मात्र अगाडी बढ्नु होला ....!!!!";
        redirect_to("upabhoktasamitidashboard.php?msg=".$msg);
    }
}
function get_plan_type($plan_type)
{
    if($plan_type==1)
      {
          $result="दर्ता भई सम्झौता भएका योजना";
      }
      if($plan_type==2)
      {
          $result="मुल्यांकनको आधारमा भुक्तानी लागेको योजना";
      }
      if($plan_type==3)
      {
          $result="सम्पन्न भएका योजना";

      }
      return $result;
    
}
function get_function_by_plan_type($plan_type)
{
    if($plan_type==1)
      {
          $result_array=get_more_plan_details_array();
      }
      if($plan_type==2)
      {
          $result_array=get_analysis_based_plan_array();
      }
      if($plan_type==3)
      {
          $result_array=get_final_payment_plan_array();

      }
      return $result_array;
}

function get_more_plan_details_array()
{
    $result=getOnlyRegisteredPlans();
    return $result['more_detail_count_array'];
}
function get_analysis_based_plan_array()
{
    $result=getOnlyRegisteredPlans();
    $final_array= $result['analysis_count_array'];
    return $final_array;
}
function get_final_payment_plan_array()
{
     $result=getOnlyRegisteredPlans();
    $final_array= $result['final_count_array'];
    return $final_array;
}
function get_remaining_amount_mainreport1($topic_area_id,$topic_area_type_id,$type,$ward)
{
    if(empty($ward))
    {
         $sql="select * from plan_details1 where type=".$type." and topic_area_id=".$topic_area_id." and topic_area_type_id=".$topic_area_type_id;
   
    }
    else
    {
         $sql="select * from plan_details1 where ward_no=".$ward." and type=".$type." and topic_area_id=".$topic_area_id." and topic_area_type_id=".$topic_area_type_id;
   
    }
    
    $result=  Plandetails1::find_by_sql($sql);
    $total_investment_amount=0;
    $total_expendiutre_till_now=0;
    $total_remaining_program_budget=0;
    $expenditure_amount=0;
    $rem_budget=0;
    foreach($result as $data):
        $budget=  Ekmustabudget::find_by_plan_id($data->id);
            if(!empty($budget))
            {
                $expenditure_amount =$budget->total_expenditure;
            }
            else
            {
                $program_result=Programpaymentfinal::find_by_program_id1($data->id);
                $advance_total = Programpayment::get_total_payment_amount($data->id);
                $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
                $expenditure_amount = $advance_total + $net_total_amount_total;
            }   
        $rem_budget = $data->investment_amount - $expenditure_amount;

        $total_investment_amount += $data->investment_amount;
        $total_expendiutre_till_now += $expenditure_amount;
        $total_remaining_program_budget += $rem_budget;
     endforeach;
     $data_array=array(
                    "expenditure_amount"=>$expenditure_amount,
                     "rem_budget"=>$rem_budget,
                     "total_expenditure_till_now"=>$total_expendiutre_till_now,
                     "total_remaining_program_budget"=>$total_remaining_program_budget
             );
        return $data_array;
}
function get_remaining_amount_mainreport($topic_area_id,$topic_area_type_id,$type,$ward)
{
    $counted_result = getOnlyRegisteredPlans($ward);
    $final_array    = $counted_result['final_count_array'];
if(empty($ward))
{
      $sql="select * from plan_details1 where type=".$type." and topic_area_id=".$topic_area_id." and topic_area_type_id=".$topic_area_type_id;
    
}
else
{
      $sql="select * from plan_details1 where ward_no=".$ward." and type=".$type." and topic_area_id=".$topic_area_id." and topic_area_type_id=".$topic_area_type_id;
    
}
  $result=  Plandetails1::find_by_sql($sql);
    $total_net_payable_amount=0;
    foreach($result as $data):
                    
                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                      if($data->type==0)
                     {  
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
                     }
                     else
                     {
                                $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                {
                                    $net_payable_amount =$budget->total_expenditure;
                                    $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                }
                                else
                                {
                                    $program_more_details= Programmoredetails::find_single_by_program_id($data->id);
                                    $net_payable_amount= Programmoredetails::getSum($data->id);
                                    if(empty($amount))
                                    {
                                        $remaining_amount=$data->investment_amount;
                                    }
                                    else
                                    {
                                        $remaining_amount=($data->investment_amount)-($net_payable_amount);

                                    }
                                }

                     }
                        $total_net_payable_amount +=$net_payable_amount;
          
             endforeach;
        return $total_net_payable_amount;
}
function get_access_form($plan_id)
{
    $data = Plantotalinvestment::find_by_plan_id($plan_id);
    $data1 = Costumerassociationdetails0::find_by_plan_id($plan_id);
    $data2 = Costumerassociationdetails::find_by_plan_id($plan_id);
    $data3 =  Investigationassociationdetails::find_by_plan_id($plan_id);
    $data4 = Moreplandetails::find_by_plan_id($plan_id);
    $data5= Samitiplantotalinvestment::find_by_plan_id($plan_id);
    $data7=  Samiticostumerassociationdetails::find_by_plan_id($plan_id);
    $data8= Samiticostumerassociationdetails0::find_by_plan_id($plan_id);
    $data9=  Samitiinvestigationassociationdetails::find_by_plan_id($plan_id);
    $data6=Samitimoreplandetails::find_by_plan_id($plan_id);
    if(!empty($data))
    {
            if(empty($data) || empty($data1) || empty($data2) || empty($data3) || empty($data1))
              {
                  $msg="उपोभोक्ता समिति सम्मको फारम भरेपछि मात्र अगाडी बढ्नु होला...!!!";
                  redirect_to("upabhoktasamitidashboard.php?msg=".$msg);
              }
    }
    elseif(!empty($data5))
    {
                    if(empty($data5) || empty($data7) || empty($data8) || empty($data9) || empty($data6))
              {
                  $msg="संस्था / समिति सम्मको फारम भरेपछि मात्र अगाडी बढ्नु होला...!!!";
                  redirect_to("anyasamitidasboard.php?msg=".$msg);
              }
    }
    else
    {
         $msg="सम्पूर्ण फारम भरेपछि मात्र अगाडी बढ्नु होला...!!!";
         redirect_to("yojanasanchalandash.php?msg=".$msg);
    }
}
function get_all_program_ids($ward)
{
    if(empty($ward))
    {
        $sql = "select id from plan_details1 where type=1 ";
    
    }
    else
    {
        $sql = "select id from plan_details1 where type=1 and ward_no=".$ward;
    
    }
    $datas = Plandetails1::find_by_sql($sql);
    $ids = array();
    foreach ($datas as $data )
    {
        array_push($ids, $data->id);
    }
    return $ids;
    
}
function get_all_final_program_id($ward)
{
    $array=array();
     if(empty($ward))
    {
         $datas=  Programpaymentfinal::find_all();
    }
    else
    {
        $datas= get_wardwise_result_sql_program($_POST['ward_no'],"program_payment_final");
    }
    
    foreach($datas as $data)
    {
        array_push($array, $data->program_id);
    }
    return array_unique($array);
}
function count_program_by_budget_remaining($ward)
{
    $count = 0;
    $ids = get_all_program_ids($ward);
    $total_investment_amount = 0;
    $total_expenditure_amount = 0;
    $total_rem_budget = 0;
    $selected_id = array();
    foreach($ids as $id)
    {
        $program_selected = Plandetails1::find_by_id($id);
       $budget=  Ekmustabudget::find_by_plan_id($id);
        if(!empty($budget))
        {
            $expenditure_amount =$budget->total_expenditure;
            
        }
        else
        {
        $advance_total = Programpayment::get_total_payment_amount($id);
        $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($id);
        $expenditure_amount = $advance_total + $net_total_amount_total;
        }
        
        $rem_budget = $program_selected->investment_amount - $expenditure_amount;
        if($rem_budget !=0 && $rem_budget<$program_selected->investment_amount)
        {
            array_push($selected_id, $program_selected->id);
            $count++;
             $total_investment_amount += $program_selected->investment_amount;
            $total_expenditure_amount += $expenditure_amount;
            $total_rem_budget += $rem_budget;
        }
       
    }
    $return_array = array(
                    "count"=>$count,
                    "total_investment_amount"=>$total_investment_amount,
                    "total_expenditure_amount"=>$total_expenditure_amount,
                    "total_rem_budget"=>$total_rem_budget,
                    "selected_id" =>$selected_id
        );
    return $return_array;
}
function get_final_paid_program_ids($ward)
{
	$count = 0;
	$ids = get_all_program_ids($ward);
	$total_investment_amount = 0;
    $total_expenditure_amount = 0;
    $total_rem_budget = 0;
    $selected_id = array();
    foreach($ids as $id)
	{
		$program_selected = Plandetails1::find_by_id($id);
                $budget=  Ekmustabudget::find_by_plan_id($id);
                 if(!empty($budget))
                 {
                    $expenditure_amount =$budget->total_expenditure;
                 }
                else
                {
                $advance_total = Programpayment::get_total_payment_amount($id);
		$net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($id);
		$expenditure_amount = $advance_total + $net_total_amount_total;
                }
                
		$rem_budget = $program_selected->investment_amount - $expenditure_amount;
		if($rem_budget==0)
		{
			array_push($selected_id, $program_selected->id);
            $count++;
             $total_investment_amount += $program_selected->investment_amount;
            $total_expenditure_amount += $expenditure_amount;
            $total_rem_budget += $rem_budget;
		}
	}
	$return_array = array(
                    "count"=>$count,
                    "total_investment_amount"=>$total_investment_amount,
                    "total_expenditure_amount"=>$total_expenditure_amount,
                    "total_rem_budget"=>$total_rem_budget,
                    "selected_id" =>$selected_id
        );
       
    return $return_array;
	
        
}
function placeholder($data)
{
    $result="";
    $num =  explode(".",$data);
    $length = strlen($num[0]);
    if($length==1)
    {
        $result=$num[0];
    }
     if($length==2)
    {
        $result=$num[0];
    }
     if($length==3)
    {
        $result=$num[0];
    }
    if($length==4)
    {
        $result.=substr($num[0],0,1);
        $result.=",";
        $result.=substr($num[0],1,3);
        
    }
    if($length==5)
    {
       $result.=substr($num[0],0,2);
        $result.=",";
        $result.=substr($num[0],2,3);
         
    }
     if($length==6)
    {
       $result.=substr($num[0],0,1);
        $result.=",";
        $result.=substr($num[0],1,2);
        $result.=",";
        $result.=substr($num[0],3,3);
         
    }
      if($length==7)
    {
       $result.=substr($num[0],0,2);
        $result.=",";
      $result.=substr($num[0],2,2);
        $result.=",";
        $result.=substr($num[0],4,3);
    }
     if($length==8)
    {
        $result.=substr($num[0],0,1);
        $result.=",";
        $result.=substr($num[0],1,2);
        $result.=",";
        $result.=substr($num[0],3,2);
        $result.=",";
        $result.=substr($num[0],5,3);
    }
      if($length==9)
    {
        $result.=substr($num[0],0,2);
        $result.=",";
        $result.=substr($num[0],2,2);
        $result.=",";
        $result.=substr($num[0],4,2);
        $result.=",";
        $result.=substr($num[0],6,3);
        
    }
     if($length==10)
    {
        $result.=substr($num[0],0,1);
        $result.=",";
        $result.=substr($num[0],1,2);
        $result.=",";
        $result.=substr($num[0],3,2);
        $result.=",";
        $result.=substr($num[0],5,2);
        $result.=",";
        $result.=substr($num[0],7,3);
    }
    if(empty($num[1]))
    {
    	$number=$result;
    }
    else
    {
    	$number=$result.".".$num[1];
   }
    return $number;
}
function calcTotalLpltr($up, $ltr)
{
	return $ltr * ((100-$up)/100); 
	
}
function getUpId($uptype)
{
	$up_info = UpInfo::find_by_up_type($uptype);
	return $up_info->id;
}
function setPlanId($id)
{
	$_SESSION['set_plan_id']=$id;
}

function redirectUrl()
{
  if(isset($_SESSION['set_plan_id']))
  {
    $link = $_SERVER['PHP_SELF']."?id=".$_SESSION['set_plan_id'];
    redirect_to($link);
  }
}
function redirectplan()
{
  if(isset($_SESSION['set_program_id']))
  {
    $link = $_SERVER['PHP_SELF']."?id=".$_SESSION['set_program_id'];
    redirect_to($link);
  }
}
 function folder_exist($folder)
{
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it's a directory
    return ($path !== false AND is_dir($path)) ? $path : false;
}
function dir_is_empty($dir) {
  if(folder_exist($dir))
  {
  
  $handle = opendir($dir);
  while (false !== ($entry = readdir($handle))) {
    if ($entry != "." && $entry != "..") {
      return FALSE;
    }
  }
  return TRUE;
 }
}
function getUserType()
{
	if(isset($_SESSION[KEYMODE]))
		{
			return $_SESSION[KEYMODE];	
		}
		else
		{
			return false;
		}
}

function getUser()
{
	if(isset($_SESSION[KEYID]))
		{
			$user = User1::find_by_id($_SESSION[KEYID]);
			return $user;	
		}
		else
		{
			return false;
		}
}
function getInstString($inst_array)
{
    if(!empty($inst_array))
    {
        $text = implode(" + ", $inst_array);
        $text .= " धरौटी फिर्ता ";
        return "( ".$text." )";
    }
    return "";
}
function getInstText($inst_array)
{
    if(!empty($inst_array))
    {
        $text = implode(" + ", $inst_array);
        $text .= " भुक्तानी";
        return "( ".$text." )";
    }
    return "";
}
 function getSamitiCompletiondate($plan_id=0)
{
        $result=Plantimeadditionaffiliation::maxPeriodForPlan($_GET['id']);
        $result1=Plantimeadditionaffiliation::find_by_max($result, $_GET['id']);
        $sampanna_miti=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
        if(empty($result1) & !empty($sampanna_miti))
        {
            $yojana_sakine_date=$sampanna_miti->yojana_sakine_date;
        }
        elseif(!empty($result1))
        {
            $yojana_sakine_date=$result1->extended_date;
        }
        return $yojana_sakine_date;
}

function getcontractcompletiondate($plan_id=0)
{
        $result=Contracttimeadditionaffiliation::maxPeriodForPlan($_GET['id']);
        $result1= Contracttimeadditionaffiliation::find_by_max($result, $_GET['id']);
        $sampanna_miti=Contractmoredetails::find_by_plan_id($_GET['id']);
        if(empty($result1) & !empty($sampanna_miti))
        {
            $yojana_sakine_date=$sampanna_miti->completion_date;
        }
        elseif(!empty($result1))
        {
            $yojana_sakine_date=$result1->extended_date;
        }
        return $yojana_sakine_date;
}
function getcompletiondate($plan_id=0)
{
        $result=Plantimeadditionaffiliation::maxPeriodForPlan($_GET['id']);
        $result1= Plantimeadditionaffiliation::find_by_max($result, $_GET['id']);
        $sampanna_miti=Moreplandetails::find_by_plan_id($_GET['id']);
        if(empty($result1) & !empty($sampanna_miti))
        {
            $yojana_sakine_date=$sampanna_miti->yojana_sakine_date;
        }
        elseif(!empty($result1))
        {
            $yojana_sakine_date=$result1->extended_date;
        }
        return $yojana_sakine_date;
}
function getamanatcompletiondate($plan_id=0)
{
        $result=Plantimeadditionaffiliation::maxPeriodForPlan($_GET['id']);
        $result1= Plantimeadditionaffiliation::find_by_max($result, $_GET['id']);
        $sampanna_miti=  Amanat_more_details::find_by_plan_id($_GET['id']);
        if(empty($result1) & !empty($sampanna_miti))
        {
            $yojana_sakine_date=$sampanna_miti->yojana_sakine_date;
        }
        elseif(!empty($result1))
        {
            $yojana_sakine_date=$result1->extended_date;
        }
        return $yojana_sakine_date;
}
function getExtendedDate($plan_id=0)
{
    // get the completion date for the selected plan
    $more_details = Moreplandetails::find_by_plan_id($plan_id);
    $plan_selected = Plandetails1::find_by_id($plan_id);
    $current_date = date("Y-m-d",time());
    
    $max_period=  Plantimeadditionaffiliation::maxPeriodForPlan($plan_id);
    if(!empty($max_period))
    {
        $extended_date = Plantimeadditionaffiliation::getExtendedDate($plan_id,$max_period);
    }
    else
    {
        $extended_date = $more_details->yojana_sakine_date;
    }
    return $extended_date;
}
function getQuestionGroup($user)
{
	$student = Students::find_by_id($user->student_id);
	
	$group_id = $student->group_id;
	
	$question_group = Qgroups::find_by_group_id_status($group_id);
	return $question_group;
}
function startTimer()
{
	$basename = basename($_SERVER['PHP_SELF']);
	if($basename==="entrance.php")
	{
		return true;
	}
	return false; 
}

function getTickImageForRightChoice($data)
{
	$result_array = array();
	$option_array = array('opt1','opt2','opt3','opt4');
	foreach ($option_array as $option)
	{
		//$result_array[$option] = '';
		if($data->correct===$option)
		{
			$result_array[$option] = '<span><img src="images/right.png" width="40" height="40"></a></span>';
		}
		else
		{
			$result_array[$option] = '';
		}
	}
	return $result_array; 
}
function setAnswerSession()
{
	$_SESSION['answers'] = array();
}

//function getStartEndMonth()
//{

//}
function updateIsCurrent()
{
	$fiscals = Fiscalyear::find_all();
	foreach($fiscals as $fiscal)
	{
		$fiscal->is_current = 0;
		$fiscal->save();
	}
}

function getVendorId()
{
	$user = User::find_by_id($_SESSION['auth_id']);
	return $user->vendor_id;
}
function getUserMode()
{
   
    $user = User1::find_by_id($_SESSION[KEYID]);
	return $user->mode;
}

/*function createPrevStockPostData($post)
{	
	$stock_array = array('prev_stock_L','prev_stock_Q','prev_stock_P','prev_stock_N','prev_stock_D');
	foreach ($stock_array as $stock) {
		
		if(!isset($post[$stock]))
		{
			$post[$stock] = 0;
		}
	}
	return $post;
	
}
*/
function generateCurrDate(){
	$cal = new Nepali_Calendar();
	$nepdate = $cal->eng_to_nep(date("Y", time()), date("m", time()), date("d", time()));
     $curr_date = $nepdate['year'].'-'.$nepdate['month'].'-'.$nepdate['date'];
     return $curr_date;
}
function DateNepToEng($nep_date)
{
	$cal = new Nepali_Calendar();
	$nep_date = explode("-",$nep_date);
	
	$eng_date = $cal->nep_to_eng($nep_date[0],$nep_date[1],$nep_date[2]);
	return $eng_date["year"]."-".$eng_date["month"]."-".$eng_date["date"];
	
}
function total_letters(){
	$letter1 = Taxcert::count_all();
    $letter2 = Taxpersonal::count_all();
    $letter3 = Taxlabour::count_all();
    $letter4 = Taxrenewal::count_all();
    $total_letters = $letter1 + $letter2 + $letter3 +$letter4;
    return $total_letters;
}

function getMaxLetterNo($cert){
	if($cert==1)
	{
		 $letter = Taxcert::count_all(); 
		 $letter = $letter+1; 
		 
	}
	if($cert==2){ $letter = Taxlabour::count_all(); $letter=$letter+1; }
	if($cert==3){ $letter = Taxpersonal::count_all();  $letter=$letter+1; }
	if($cert==4){ $letter = Taxrenewal::count_all(); $letter=$letter+1; }
	if($cert==5){ $letter = Taxdisc::count_all(); $letter=$letter+1; }
    return $letter;
  }
/* function max_letter_no(){
    $letter_no1 = Taxcert::find_max_letter_no();
    $letter_no2 = Taxpersonal::find_max_letter_no();
    $letter_no3 = Taxlabour::find_max_letter_no();
    $letter_no4 = Taxrenewal::find_max_letter_no();
    $letter_no5 = Taxdisc::find_max_letter_no();
    $letter_array = array($letter_no1,$letter_no2,$letter_no3,$letter_no4,$letter_no5);
    return max($letter_array);
}*/

function convert_date($date){

    $date = explode("-",$date);
    $final_date = '';
    $i=1;
    $count = count($date);
    foreach($date as $datestring)
    {
        if($i==$count){
            $final_date.= convertedNOs($datestring);    
        }
        else{
        $final_date.= convertedNOs($datestring)."/";
        }
        $i++;
    }
    return $final_date;

}
	function convertNos($nos)
{
    $n = '';
  switch($nos){
    case "०": $n = 0; break;
    case "१": $n = 1; break;
    case "२": $n= 2; break;
    case "३": $n = 3; break;
    case "४": $n = 4; break;
    case "५": $n = 5; break;
    case "६": $n = 6; break;
    case "७": $n = 7; break;
    case "८": $n = 8; break;
    case "९": $n = 9; break;
    case "0": $n = "०"; break;
    case "1": $n = "१"; break;
    case "2": $n = "२"; break;
    case "3": $n = "३"; break;
    case "4": $n = "४"; break;
    case "5": $n = "५"; break;
    case "6": $n = "६"; break;
    case "7": $n = "७"; break;
    case "8": $n = "८"; break;
    case "9": $n = "९"; break;
   }
   return $n;
}

 function convertedcit($string)
    {
        	$string = str_split($string);
        	$out = '';
        	foreach($string as $str)
        	{
        		if(is_numeric($str))
        		{
        			$out .= convertNos($str);	
        		}
        		else
        		{
        			$out .=$str;
        		}
        	}
        	return $out;

    }
    function convertedNos($num)
    {
        $str_num = preg_split('//u', ("". $num), -1); // not explode('', ("". $num))

            // For each item in your exploded string, retrieve the Nepali equivalent or vice versa.
            $out = '';
            $out_arr = array_map('convertNos', $str_num);
            $out = implode('', $out_arr);
            return $out;

    }
	function strip_zeros_from_date($marked_string)
	{
		// first remove the marked zeros
		$no_zeros=str_replace('*0','',$marked_string);
		// then remove any remaining marks
		$cleaned_string=str_replace('*','',$no_zeros);
		return $cleaned_string;
	}
	function strip_zeros_from_month($marked_string)
	{
		// first remove the marked zeros
		$new_string = '';
		$str_len = strlen($marked_string);
		for($i=0; $i<$str_len; $i++)
		{
			if($i==0 && $marked_string[$i]==0)
			{
				$marked_string[$i]='';
			}
			$new_string = $new_string.$marked_string[$i];
		}
		return $new_string;
	}
	function redirect_to($location=NULL)
	{
		if ($location != NULL)
		{
			?>
			 <script>window.location="<?php echo $location; ?>";</script>
			<?php	
		}
	}
	function set_sort()
	{
		if(!isset($_SESSION['sort']))
		{
			$_SESSION['sort'] = 1;
			
			
		}
		if(isset($_GET['sort']))
		{
			if(isset($_GET['sort']) && $_SESSION['sort']==1 )
			{
			
				$_SESSION['sort'] = 2;
				$i=1;
			}
			if(isset($_GET['sort']) && $_SESSION['sort']==2 && $i!=1 )
			{
				
				$_SESSION['sort'] = 1;
				
			}
		}	
		$i='';
	}
	function output_message($message="")
	{
		if (!empty($message))
		{
			return"<p class=\"message\">{$message}</p>";
		}
		else 
		{
			return "";
		}
	}
	/*function __autoload($class_name)
	{
		$class_name = strtolower($class_name);
		$path = "../includes/{$class_name}.php";
		if (file_exists($path))
		{
			require_once($path);
		}
		else
		{
			die("The file {$class_name}.php could not be found.");
		}
	}
	*/	
	function log_action($action, $message="")
	{
		$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
		$new = file_exists($logfile) ? false: true ;
		if ($handle = fopen($logfile, 'a'))//append
		{
			$timestamp = strftime("%Y-%m-%d %H:%M:%S" , time());
			$content = "{$timestamp} | {$action} | {$message}\n";
			fwrite($handle, $content);
			fclose($handle);
			if ($new)
			{
				chmod($logfile, 0755);
			}
			else
			{
				echo "could not open the log file for writing";
			}
		}
	}
	
	function datetime_to_text($datetime="")
	{
		$unixdatetime = strtotime($datetime);
		return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
	}
	function datetime_to_text_nosec($datetime="")
	{
		$unixdatetime = strtotime($datetime);
		return strftime("%B %d, %Y", $unixdatetime);
	}
	function randname($filename)
	{
		$name = explode(".", $filename);
		$ext_index_count = count($name)-1;
		$extension = $name[$ext_index_count];
		$firstname = time()*rand();
		$filename = $firstname.'.'.$extension;
		return $filename;
	}
	function get_base_url($type=0)
        {
            $uri = explode("/",$_SERVER['PHP_SELF']);
            $base_url = $uri[2]; 
            if($type==1)
            {
                
                if($base_url == "print_bank_report03_yojana.php")
                {
                    $base_url = "print_bank_report03_final.php";
                }
                else
                {
                    $temp_url   = explode(".",$base_url);
                    $base_url = $temp_url[0]."_final.php";
                }
            }
            return $base_url;
        }

?>
