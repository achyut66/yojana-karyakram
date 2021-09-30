<?php
//include_once 'includes/functions.php';
error_reporting(0);
function get_type_nepali($type)
{
    if($type==0)
    {
        $output="योजनाहरु";
    }
    else
    {
        $output = "कार्यक्रमहरु";
    }
    return $output;
}
function get_net_total_amount_sum_for_all_programs($ward)
{
    global $database;
    $sql= "select SUM(a.net_total_amount) from program_payment_final as a INNER JOIN plan_details1 as b on a.program_id=b.id where b.ward_no=".$ward;
    $result_set = $database->query($sql);
    $row = $database->fetch_array($result_set);
    $total =  array_shift($row);
    if(empty($total))
    {
        $total = 0;
    }
    return $total;
    
}
function get_total_payment_amount_for_all_programs($ward)
{
    global $database;
     $sql= "select SUM(a.payment_amount) from program_payment as a INNER JOIN plan_details1 as b on a.program_id=b.id where b.ward_no=".$ward;
    $result_set = $database->query($sql);
    $row = $database->fetch_array($result_set);
    $total =  array_shift($row);
    if(empty($total))
    {
        $total = 0;
    }
    return $total;
}
function get_wardwise_result_sql($ward,$table)
{
    global $database;
    $array = array();
    $sql="select * from ".$table." as a LEFT JOIN plan_details1 as b on a.plan_id = b.id where b.ward_no=".$ward; 
    $result = $database->query($sql);
    while ($obj = mysqli_fetch_object($result))
    {
        array_push($array,$obj);
    }
    return $array;
}
function get_wardwise_result_sql_program($ward,$table)
{
    global $database;
    $array = array();
    $sql="select * from ".$table." as a LEFT JOIN plan_details1 as b on a.program_id = b.id where b.ward_no=".$ward; 
//    echo $sql;exit;
    $result = $database->query($sql);
    while ($obj = mysqli_fetch_object($result))
    {
        array_push($array,$obj);
    }
//    echo "<pre>";
//    print_r($array);
//    echo "</pre>";exit;
    return $array;
}
function get_final_payed_program($ward)
{
    $final_array=array();
    $array=get_final_paid_program_ids($ward);
    $result_array=$array["selected_id"];
//    print_r($result_array);exit;
    foreach($result_array as $data)
    {
        $max_count=  Programpaymentfinal::getMaxIds($data);
//        echo $max_count;exit;
        $final_data= Programpaymentfinal::find_by_program_id_and_sn($data,$max_count);
        array_push($final_array, $final_data->id);
    }
//    print_r($final_array);exit;
    return $final_array;
}
function Get_empty_plan($ward)
{
    if(empty($ward))
    {
         $sql = "select id from plan_details1 where type=0";
    }
    else
    {
         $sql = "select id from plan_details1 where type=0 and ward_no=".$ward;
    }
    
    $all_plans = Plandetails1::find_by_sql($sql);
    $empty_array=array();
    foreach($all_plans as $plan)
    {
        $more_plan_details  = Moreplandetails::find_by_plan_id($plan->id);
        $plan_total_investment  =  Plantotalinvestment::find_by_plan_id($plan->id);
        $samiti_total_investment= Samitiplantotalinvestment::find_by_plan_id($plan->id);
        $contract_total_investment= Contractinfo::find_by_plan_id($plan->id);
        if(empty($contract_total_investment) && empty($samiti_total_investment) && empty($more_plan_details))
        {
            array_push($empty_array,$plan->id);
        }
    }

    return $empty_array;
    
}
function Samiti_plan($ward)
{
    if(empty($ward))
    {
        $all_plans = Samitiplantotalinvestment::find_all();
    }
    else
    {
        $all_plans= get_wardwise_result_sql($ward,"samiti_plan_total_investment");
    }
    

    $samiti_count=0;
    $samiti_count_array=array();
   
    $samiti_more_details_count=0;
    $samiti_more_details_array=array();
    
    $advance_count = 0;
    $advance_count_array = array();
    
    $analysis_count = 0;
    $analysis_count_array = array();
    
    $final_count = 0;
    $final_count_array = array();
    
    foreach($all_plans as $plan)
    {   
        $samiti_more_details=  Samitimoreplandetails::find_by_plan_id($plan->plan_id);
        $advance = Planstartingfund::find_by_plan_id($plan->plan_id);
         $analysis = Analysisbasedwithdraw::find_by_plan_id($plan->plan_id);
         $final = Planamountwithdrawdetails::find_by_plan_id($plan->plan_id);
        
           if(!empty($samiti_more_details))
           {

               if(empty($advance) && empty($analysis) && empty($final))
              {
                  $samiti_more_details_count++;
                  array_push($samiti_more_details_array, $plan->plan_id);
              }
           }
         
     if(!empty($advance))
        {
            if(empty($analysis) && empty($final))
            {
                $advance_count++;
                array_push($advance_count_array, $plan->plan_id);
            }
        }
           if(!empty($analysis))
           {
               if(empty($final))
               {
                   $analysis_count++;
                   array_push($analysis_count_array, $plan->plan_id);
               }
           }
            if(!empty($final))
           {
               $final_count++;
               array_push($final_count_array, $plan->plan_id);
           }
           
    }
//      echo "<pre>"; print_r($samiti_more_details_array); echo "</pre>";exit;
           $result["samiti_count_array"]        = $samiti_count_array;
           $result["advance_count_array"]       = $advance_count_array;
           $result["analysis_count_array"]      = $analysis_count_array;
           $result["final_count_array"]         = $final_count_array;
           $result["samiti_more_details_array"] =$samiti_more_details_array;
            $result["samiti_count"]             =$samiti_count;
            $result["advance_count"]            = $advance_count;
           $result["analysis_count"]            = $analysis_count;
           $result["final_count"]               = $final_count;
           $result["samiti_more_details_count"] = $samiti_more_details_count;
           return $result;
}
function Contract_plans($ward)
{
  
  if(empty($ward))
    {
        $all_plans = Contract_total_investment::find_all();
    }
    else
    {
        $all_plans= get_wardwise_result_sql($ward,"contract_total_investment");
//        print_r($all_plans);exit;
    }
//     echo "<pre>";
//     print_r($all_plans);
//     echo "</pre>";
    $contract_count=0;
    $contract_count_array=array(); 
    
    
    $contract_more_details_count=0;
    $contract_more_details_array=array();
    
    $contract_advance_count=0;
    $contract_advance_array=array();
    
    $contract_anlaysis_count=0;
    $contract_analysis_array=array();
    
    $contract_final_count=0;
    $contract_final_array=array();
    
   
    
    $contract_total_investment_count=0;
    $contract_total_investment_array=array();
     foreach($all_plans as $plan)
    {
//         print_r($plan);exit;
         $contract_more_details=  Contractmoredetails::find_by_plan_id($plan->plan_id);
        $contract_advance=  Contractstartingfund::find_by_plan_id($plan->plan_id);
        $contract_analysis=  Contractanalysisbasedwithdraw::find_by_plan_id($plan->plan_id);
        $contract_final=  Contractamountwithdrawdetails::find_by_plan_id($plan->plan_id);
       $contract_total_investment=  Contract_total_investment::find_by_plan_id($plan->plan_id);
        
       if(!empty($contract_total_investment))
       {
           array_push($contract_total_investment_array,$plan->plan_id);
           $contract_total_investment_count++;
       }
        if(!empty($contract_more_details))
           {

               if(empty($contract_advance) && empty($contract_analysis) && empty($contract_final))
              {
                  $contract_more_details_count++;
                  array_push($contract_more_details_array, $plan->plan_id);
              }
           }
           else
          {
               array_push($contract_count_array,$plan->plan_id);
               $contract_count++;
           }
         
            if(!empty($contract_advance))
        {
            if(empty($contract_analysis) && empty($contract_final))
            {
                $contract_advance_count++;
                array_push($contract_advance_array, $plan->plan_id);
            }
        }
         if(!empty($contract_analysis))
           {
               if(empty($contract_final))
               {
                   $contract_anlaysis_count++;
                   array_push($contract_analysis_array, $plan->plan_id);
               }
           }
            if(!empty($contract_final))
           {
               $contract_final_count++;
               array_push($contract_final_array,$plan->plan_id);
           }
           

    }
//             echo "<pre>"; print_r($contract_more_details_array);echo "</pre>";exit;
           $result["contract_count"]=$contract_count;
           $result["contract_more_details_count"]=$contract_more_details_count;
           $result["contract_advance_count"] = $contract_advance_count;
           $result["contract_analysis_count"] = $contract_anlaysis_count;
           $result["contract_final_count"] = $contract_final_count;
           $result["contract_count_array"] = $contract_count_array;
           $result["contract_advance_array"] = $contract_advance_array;
           $result["contract_analysis_array"] = $contract_analysis_array;
           $result["contract_final_array"] = $contract_final_array;
           $result["contract_more_details_array"]=$contract_more_details_array;
           
           return $result;
}
function get_amanat_plan_id($ward)
{
     if(empty($ward))
    {
        $all_plans = AmanatLagat::find_all();
    }
    else
    {
        $all_plans= get_wardwise_result_sql($ward,"amanat_lagat");
    }
   
    
    $result = array();
    $count = 0;
    $count_array = array();
  
    $more_detail_count = 0;
    $more_detail_count_array = array();
    
    $advance_count = 0;
    $advance_count_array = array();
    
    $analysis_count = 0;
    $analysis_count_array = array();
    
    $final_count = 0;
    $final_count_array = array();
    
    $my_count = 0;
    foreach($all_plans as $plan)
    {
        $total_investment_filled_plans = AmanatLagat::find_by_plan_id($plan->plan_id);
        $more_plan_details = Amanat_more_details::find_by_plan_id($plan->plan_id);
        $advance = Planstartingfund::find_by_plan_id($plan->plan_id);
        $analysis = Analysisbasedwithdraw::find_by_plan_id($plan->plan_id);
        $final = Planamountwithdrawdetails::find_by_plan_id($plan->plan_id);
        if(!empty($more_plan_details))
           {

               if(empty($advance) && empty($analysis) && empty($final))
              {
                  $more_detail_count++;
                  array_push($more_detail_count_array, $plan->plan_id);
              }
           }
           else
           {
               array_push($count_array,$plan->plan_id);
               $count++;
           }
       
        if(!empty($advance))
        {
            if(empty($analysis) && empty($final))
            {
                $advance_count++;
                array_push($advance_count_array, $plan->plan_id);
            }
        }
           if(!empty($analysis))
           {
               if(empty($final))
               {
                   $analysis_count++;
                   array_push($analysis_count_array, $plan->plan_id);
               }
           }
            if(!empty($final))
           {
               $final_count++;
               array_push($final_count_array, $plan->plan_id);
           }
    }
      $result["count_array"]        = $count_array;
           $result["advance_count_array"]       = $advance_count_array;
           $result["analysis_count_array"]      = $analysis_count_array;
           $result["final_count_array"]         = $final_count_array;
           $result["more_detail_count_array"] =$more_detail_count_array;
            $result["count"]             =$count;
            $result["advance_count"]            = $advance_count;
           $result["analysis_count"]            = $analysis_count;
           $result["final_count"]               = $final_count;
           $result["more_detail_count"] = $more_detail_count;
           return $result;
}

function getOnlyRegisteredPlans($ward="")
{   
    $samiti = Samiti_plan($ward);
    $data=Contract_plans($ward);
    $amanat = get_amanat_plan_id($ward);
//    echo "samiti_final_count:=".$samiti['final_count']."and contraact_final_count:=".$data['contract_final_count'];exit;
    $check_array = array();
//    $sql = "select id from plan_details1 where type=0";
    if(empty($ward))
    {
        $all_plans = Plantotalinvestment::find_all();
    }
    else
    {
        $all_plans= get_wardwise_result_sql($ward,"plan_total_investment");
    }
   
    
    $result = array();
    $count = 0;
    $count_array = array();
    
    $customer_count0 = 0;
    $customer_count0_array = array();
    
    $customer_count = 0;
    $customer_count_array = array();
    
    $more_detail_count = 0;
    $more_detail_count_array = array();
    $public_count = 0;
    
    $advance_count = 0;
    $advance_count_array = array();
    
    $analysis_count = 0;
    $analysis_count_array = array();
    
    $final_count = 0;
    $final_count_array = array();
    
    $my_count = 0;
    foreach($all_plans as $plan)
    {
        $total_investment_filled_plans = Plantotalinvestment::find_by_plan_id($plan->plan_id);
        $customer_details0 =  Costumerassociationdetails0::find_by_plan_id($plan->plan_id);
        $customer_details = Costumerassociationdetails::find_by_plan_id($plan->plan_id);
        $public_details = Publicinvestigationdetails::find_by_plan_id($plan->plan_id);
        $more_plan_details = Moreplandetails::find_by_plan_id($plan->plan_id);
        $advance = Planstartingfund::find_by_plan_id($plan->plan_id);
        $analysis = Analysisbasedwithdraw::find_by_plan_id($plan->plan_id);
        $final = Planamountwithdrawdetails::find_by_plan_id($plan->plan_id);
         $contract_total_investment=  Contract_total_investment::find_by_plan_id($plan->plan_id);
         $samiti_total_investment= Samitiplantotalinvestment::find_by_plan_id($plan->plan_id);
        if(!empty($more_plan_details))
           {

               if(empty($advance) && empty($analysis) && empty($final))
              {
                  $more_detail_count++;
                  array_push($more_detail_count_array, $plan->plan_id);
              }
           }
           else
           {
               array_push($count_array,$plan->plan_id);
               $count++;
           }
       
        if(!empty($advance))
        {
            if(empty($analysis) && empty($final))
            {
                $advance_count++;
                array_push($advance_count_array, $plan->plan_id);
            }
        }
           if(!empty($analysis))
           {
               if(empty($final))
               {
                   $analysis_count++;
                   array_push($analysis_count_array, $plan->plan_id);
               }
           }
            if(!empty($final))
           {
               $final_count++;
               array_push($final_count_array, $plan->plan_id);
           }
    }
    $empty_array = Get_empty_plan($ward);
    $total_more_details_count=$more_detail_count  + $samiti["samiti_more_details_count"]+ $data['contract_more_details_count'] + $amanat['more_detail_count'];
    $total_advance_count = $advance_count + $samiti['advance_count'] + $data['contract_advance_count'] + $amanat['advance_count'];
    $total_analysis_count = $analysis_count + $samiti['analysis_count'] + $data['contract_analysis_count']+ $amanat['analysis_count'];
    $total_final_count=$final_count + $samiti['final_count'] + $data['contract_final_count'] + $amanat['final_count'];
    
    $total_more_details_array  = array();
    $total_advance_array=array();
    $total_analysis_array=array();
    $total_final_array=array();
    foreach($amanat['more_detail_count_array'] as $a)
    {
        array_push($total_more_details_array, $a);
    }
    foreach($more_detail_count_array as $a)
    {
        array_push($total_more_details_array, $a);
    }
    foreach($samiti['samiti_more_details_array'] as $a)
    {
        array_push($total_more_details_array, $a);
    }
    foreach($data['contract_more_details_array'] as $a)
    {
        array_push($total_more_details_array, $a);
    }
    foreach($amanat['advance_count_array'] as $a)
    {
        array_push($total_advance_array, $a);
    }
    foreach($advance_count_array as $a)
    {
        array_push($total_advance_array, $a);
    }
    foreach($samiti['advance_count_array'] as $a)
    {
        array_push($total_advance_array, $a);
    }
    foreach($data['contract_advance_array'] as $a)
    {
        array_push($total_advance_array, $a);
    }
    foreach($amanat['analysis_count_array']  as $b)
    {
        array_push($total_analysis_array, $b);
    }
    foreach($analysis_count_array as $b)
    {
        array_push($total_analysis_array, $b);
    }
    foreach($samiti['analysis_count_array']  as $b)
    {
        array_push($total_analysis_array, $b);
    }
    foreach($data['contract_analysis_array'] as $b)
    {
        array_push($total_analysis_array, $b);
    }
     foreach($amanat['final_count_array'] as $f)
    {
        array_push($total_final_array, $f);
    }
    foreach($final_count_array as $f)
    {
        array_push($total_final_array, $f);
    }
     foreach($samiti['final_count_array'] as $f)
    {
        array_push($total_final_array, $f);
    }
     foreach($data['contract_final_array'] as $f)
    {
        array_push($total_final_array, $f);
    }
//    echo count($total_final_array);exit;
//    echo "<pre>";print_r($result['samiti_more_details_array']);echo "</pre>";exit;
    $final_result["count"] = count($empty_array);
    $final_result["more_detail_count"] = $total_more_details_count;
    $final_result["advance_count"] = $total_advance_count;
    $final_result["analysis_count"] = $total_analysis_count;
    $final_result["final_count"] = $total_final_count;
    $final_result['count_array'] = $empty_array;
    $final_result['more_detail_count_array'] = $total_more_details_array;
    $final_result['advance_count_array'] = $total_advance_array;
    $final_result['analysis_count_array'] = $total_analysis_array;
    $final_result['final_count_array'] = $total_final_array;
    return $final_result;
}
