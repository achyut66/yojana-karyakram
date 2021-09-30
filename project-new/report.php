<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$user = getUser();
error_reporting(1);
//echo Get_empty_plan();
$type="";
$ward ="";
$max_ward = Ward::find_max_ward_no();


?>
<?php include("menuincludes/header.php"); ?>
<!-- ठेक्का मार्फत  -->
<?php 
if(isset($_POST['submit'])):
$counted_result = getOnlyRegisteredPlans($_POST['ward_no']);
$contract_result=  Contract_total_investment::find_all();
$contract_count= count($contract_result);
$type = $_POST['type'];
$ward = $_POST['ward_no'];
?>
<!--कुल योजना-->
<?php
if(empty($_POST['ward_no']))
{
$kul_yojana_sql ="select * from plan_details1 where type=0";
}
else
{
    $kul_yojana_sql ="select * from plan_details1 where type=0 and ward_no=".$_POST['ward_no'];
}
$kul_yojana_result=  Plandetails1::find_by_sql($kul_yojana_sql);
$kul_yojana_array=array();
foreach($kul_yojana_result as $data)
{
    array_push($kul_yojana_array, $data->id);
   
}
if(!empty($kul_yojana_array))
{
    $kul_yojana_count=count($kul_yojana_array);
    $kul_yojana_total_investment=  Plandetails1::get_total_investment_by_plan_ids(implode(",",$kul_yojana_array));

    $total_kul_yojana_expenditure=0;
    $total_remaining_kul_yojana=0;
    foreach($kul_yojana_array as $data)
    {
        $final_data=  Planamountwithdrawdetails::find_by_plan_id($data);
        $kul_yojana=  Plandetails1::find_by_id($data);
         $contract_result= Contract_total_investment::find_by_plan_id($data);
         $contract_final_data=  Contractamountwithdrawdetails::find_by_plan_id($data);
         if(empty($contract_result))
         {
                if(!empty($final_data))
                       {
                          
                          $kul_yojana_expenditure=get_upobhokta_net_kharcha_amount($data);
                          $remaining_kul_yojana=$kul_yojana->investment_amount - $kul_yojana_expenditure;
                       }
                  else 
                       {
                        $kul_yojana_expenditure=  Planamountwithdrawdetails::get_payement_till_now($data);
                        $remaining_kul_yojana=$kul_yojana->investment_amount - $kul_yojana_expenditure;
                       }
         }
         else
         {
              if(!empty($contract_final_data))
                       {

                          $kul_yojana_expenditure=  get_contract_net_kharcha_amount($data);
                          $remaining_kul_yojana=$kul_yojana->investment_amount - $kul_yojana_expenditure;
                       }
                  else 
                       {
                        $kul_yojana_expenditure= Contractamountwithdrawdetails::get_payement_till_now($data);
                        $remaining_kul_yojana=$kul_yojana->investment_amount - $kul_yojana_expenditure;
                       }
         }
        $total_kul_yojana_expenditure +=$kul_yojana_expenditure;
        $total_remaining_kul_yojana +=$remaining_kul_yojana;
    }
}
else
{
    $kul_yojana_count=0;
    $kul_yojana_total_investment =0;
    $total_kul_yojana_expenditure=0;
    $total_remaining_kul_yojana=0;
}
echo $_POST['ward'];
?>
<!--मुल्यांकनको आधारमा भुक्तानी लागेको योजना संख्या-->
<?php
$analysis_based_plan_array=$counted_result['analysis_count_array'];
if(!empty($analysis_based_plan_array))
{
    $analysis_count=count($analysis_based_plan_array);
    $analysis_total_investment = Plandetails1::get_total_investment_by_plan_ids(implode(",",$analysis_based_plan_array));

    $total_analysis_total_payment=0;
    $total_analysis_remaining_amount=0;
    foreach($analysis_based_plan_array as $data)
        {
            $contract_analysis= Contract_total_investment::find_by_plan_id($data);
            if(empty($contract_analysis))
            {
                $analysis_kul_yojana=  Plandetails1::find_by_id($data);
                $analysis_total_payment=  Planamountwithdrawdetails::get_payement_till_now($data);
                $analysis_remaining_amount=$analysis_kul_yojana->investment_amount - $analysis_total_payment;
                
            }
            else
            {
                $analysis_kul_yojana=  Plandetails1::find_by_id($data);
                $analysis_total_payment= Contractamountwithdrawdetails::get_payement_till_now($data);
                $analysis_remaining_amount=$analysis_kul_yojana->investment_amount - $analysis_total_payment;
            }
            $total_analysis_total_payment +=$analysis_total_payment;
            $total_analysis_remaining_amount +=$analysis_remaining_amount;
        }
}
else
{
    $analysis_count=0;
    $analysis_total_investment=0;
    $total_analysis_total_payment=0;
    $total_analysis_remaining_amount=0;
}
?>
<!--दर्ता भई सम्झौता भएका योजना  -->
<?php
$samjhauta_array=$counted_result['more_detail_count_array'];
if(!empty($samjhauta_array))
{
$samjhauta_count=$counted_result['more_detail_count'];
$samjhauta_total_investment=Plandetails1::get_total_investment_by_plan_ids(implode(",",$samjhauta_array));
}
else
{
    $samjhauta_count=0;
    $samjhauta_total_investment=0;
}
?>
<!--सम्पन्न भएका योजना संख्या-->
<?php
$final_plan_array=$counted_result['final_count_array'];
if(!empty($final_plan_array))
{
$final_plan_count=count($final_plan_array);
$final_plan_total_investment=Plandetails1::get_total_investment_by_plan_ids(implode(",",$final_plan_array));
}
else
{
    $final_plan_count=0;
    $final_plan_total_investment=0;
}
?>
<!--दर्ता भएको तर कुनै विवरण नभरिएको योजना संख्या-->
    <?php
    $darta_array=$counted_result['count_array'];
if(!empty($darta_array))
{
    $darta_count=$counted_result['count'];
    $darta_total_investment1=Plandetails1::get_total_investment_by_plan_ids(implode(",", $darta_array));
}
else
{
    $darta_count=0;
    $darta_total_investment1=0;
}
    ?>
<!--पेश्की भुक्तानी लागेको योजना संख्या-->
<?php
$advance_plan_array=$counted_result['advance_count_array'];
if(!empty($advance_plan_array))
{
        $advance_array_count=count($advance_plan_array);
        $advance_plan_total_investment=Plandetails1::get_total_investment_by_plan_ids(implode(",",$advance_plan_array)); 
        $total_advance_plan_amount=0;
        $total_remaining_advance_amount=0;
        foreach($advance_plan_array as $data)
        {
            $contract_result= Contract_total_investment::find_by_plan_id($data);
            if(empty($contract_result))
            {
                $advance_kul_yojana=  Plandetails1::find_by_id($data);
                $advance_plan_amount=  Planstartingfund::getAdvanceAmount($data);
                $remaining_advance_plan_amount=$advance_kul_yojana->investment_amount - $advance_plan_amount;
                
            }
            else
            {
                $advance_kul_yojana=  Plandetails1::find_by_id($data);
                $advance_plan_amount= Contractstartingfund::getAdvanceAmount($data);
                $remaining_advance_plan_amount=$advance_kul_yojana->investment_amount - $advance_plan_amount;
            }
            $total_advance_plan_amount +=$advance_plan_amount;
            $total_remaining_advance_amount +=$remaining_advance_plan_amount;
        }
}       
else
{
  $advance_array_count=0;
  $advance_plan_total_investment=0;
  $total_advance_plan_amount=0;
$total_remaining_advance_amount=0;
}

//print_r($data5);exit;
?>
<!--दर्ता भएको कार्यक्रम संख्या-->
<?php
if(empty($_POST['ward_no']))
{
    $program_sql="select * from plan_details1 where type=1";

}
else
{
    $program_sql="select * from plan_details1 where type=1 and ward_no=".$_POST['ward_no'];

}
$program_result=  Plandetails1::find_by_sql($program_sql);
//echo count($program_result);exit;
$program_result_array=array();
foreach($program_result as $data)
{
    array_push($program_result_array, $data->id);
}
if(!empty($program_result_array))
{
    $program_count=count($program_result);
    $program_total_investment = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_result_array));
}
 else
     {
        $program_count=0;
    $program_total_investment =0;

    }
?>
<!--दर्ता भएको तर कुनै विवरण नभरिएको कार्यक्रम संख्या-->
<?php
//    $sql1="select * from plan_details1 where type=1";
    if(empty($_POST['ward_no']))
{
    $sql1="select * from plan_details1 where type=1";

}
else
{
    $sql1="select * from plan_details1 where type=1 and ward_no=".$_POST['ward_no'];

}
    $program_result1=  Plandetails1::find_by_sql($sql1);
//    echo count($program_result1);exit;
    if(empty($_POST['ward_no']))
    {
        $program_result2 = Programmoredetails::find_all();
    }
    else
    {
        $program_result2 = get_wardwise_result_sql_program($_POST['ward_no'],"program_more_details");
    }
    
//    echo count($program_result2);exit;
//    print_r($program_result2);exit;
    $program_id_array1=array();
    $program_id_array2=array();
    foreach($program_result1 as $data)
    {
        array_push($program_id_array1,$data->id);
    }
    foreach($program_result2 as $data)
    {
         array_push($program_id_array2,$data->program_id);
    }
    $program_result_array1 =  array_unique($program_id_array2);
//    echo count($program_result_array1);exit;
    $program_result_array_not = array_diff($program_id_array1,$program_result_array1);
//    print_r($program_result_array_not);exit;
    $program_final_array = array_unique($program_result_array_not);
//    print_r($program_final_array);exit;
    if(!empty($program_result_array_not))
    {
      $program_count1 = count($program_final_array);
    $porgram_total_investment1 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_final_array));
  
    }
    else
    {
      $program_count1 =0;
    $porgram_total_investment1 = 0;
  
    }
?>
<!--पेश्की भुक्तानी लागेको कार्यक्रम संख्या-->
<?php
if(empty($_POST['ward_no']))
{
    $program_result3 = Programpayment::find_all();
    $program_result3_1= Programpaymentfinal::find_all();
    
}
else
{
    $program_result3 =  get_wardwise_result_sql_program($_POST['ward_no'],"program_payment");
    $program_result3_1= get_wardwise_result_sql_program($_POST['ward_no'],"program_payment_final");
    
}
    $program_id_array3=array();
    $program_id_array3_1=array();
    foreach($program_result3 as $data)
    {
         array_push($program_id_array3,$data->program_id);
    }
    foreach($program_result3_1 as $data)
    {
         array_push($program_id_array3_1,$data->program_id);
    }
    $program_result_array2_1=  array_unique($program_id_array3_1);
//    print_r($program_result_array2_1);
    $program_result_array2 =  array_unique($program_id_array3);
    $result_program_array=  array_diff($program_result_array2, $program_result_array2_1);
    if(!empty($result_program_array))
    {
                    $program_count2 = count($result_program_array);
               $porgram_total_investment2 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $result_program_array));
                $result=  Plandetails1::find_by_plan_id(implode(",", $result_program_array));
                $total_advance=0;
               $total_remaining_advance=0;
               foreach($result as $data):
                      $budget=  Ekmustabudget::find_by_plan_id($data->id);
                       if(!empty($budget))
                       {
                           $advance_total =$budget->total_expenditure;
           //                  $remaining_amount= $data->investment_amount - $net_payable_amount; 
                       }
                       else
                       {
                           $max_id=Programpayment::getMaxIds($data->id);
                           //                                echo $max_id;exit;
                           $advance_total=0;
                           for($i=1;$i<=$max_id;$i++)
                           {
                               $advance_result=Programpayment::find_by_program_id_and_sn($data->id,$i);


                               $advance_total += $advance_result->payment_amount;
                           }
                       }   
                       //                                echo $advance_total;exit;
                                   $reamining_advance=$data->investment_amount - $advance_total;
                                    $total_advance +=$advance_total;
                       $total_remaining_advance += $reamining_advance;
           endforeach;
    }
    else
    {
      $total_advance=0;
    $total_remaining_advance=0;
     $program_count2 = 0;
    $porgram_total_investment2 =0;
      
    }
    
?>
<!--अन्तिम भुक्तानी  लागेको कार्यक्रम संख्या-->
<?php
    
    if(empty($_POST['ward_no']))
    {
        $program_result4 = Programpaymentfinal::find_all();
    }
    else
    {
        $program_result4 = get_wardwise_result_sql_program($_POST['ward_no'],"program_payment_final");
    }
    $program_id_array4=array();
    foreach($program_result4 as $data)
    {
         array_push($program_id_array4,$data->program_id);
    }
    $program_result_array3 =  array_unique($program_id_array4);
    if(!empty($program_result_array3))
    {
        $program_count3 = count($program_result_array3);
        // changes from function getting the count and all the invesment and rem budget info

            $no_budget_rem_details = get_final_paid_program_ids($_POST['ward_no']);

            $porgram_total_investment3 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_result_array3));
        $result_program=  Plandetails1::find_by_plan_id(implode(",", $program_result_array3));
            $remaining_budget=0;
            $remaining_net_payment=0;
            foreach($result_program as $data):
                $max_id=Programmoredetails::getMaxInsallmentByPlanId($data->id);
            if(empty($max_id))
            {
                $remaining_amount=$data->investment_amount;
                $net_payable_amount3=0;
            }
            else
                {
                        $program_result = Programmoredetails::find_by_program_id_and_sn($data->id,$max_id);
                       $remaining_amount = $program_result->budget-$program_result->remaining_budget;
                       $net_payable_amount3 = $data->investment_amount - $remaining_amount ;
                }

                if($net_payable_amount3!=0)
                {
                  $remaining_budget +=$remaining_amount;
    //            $remaining_net_payment +=$net_payable_amount;
                }
                endforeach;
                $remaining_net_payment=$porgram_total_investment3 - $remaining_budget;
    }
    else
    {
        $remaining_budget=0;
        $remaining_net_payment=0;
        $program_count3=0;
        $porgram_total_investment3=0;
    }
?>
<?php
if(empty($_POST['ward_no']))
{
    $total_budget1=  Programpaymentfinal::get_net_total_amount_sum_for_all_programs() + Programpayment::get_total_payment_amount_for_all_programs() + get_budget_expenditure_in_program($_POST['ward_no']);

}
else
{
    $total_budget1 = get_net_total_amount_sum_for_all_programs($_POST['ward_no']) + get_total_payment_amount_for_all_programs($_POST['ward_no']) + get_budget_expenditure_in_program($_POST['ward_no']);

}
$total_remaining_budget=$program_total_investment - $total_budget1;
?>
<?php
//खर्च भएको तर सम्पन्न नभएको कार्यक्रम
if(empty($_POST['ward_no']))
{
    $program_payment_final=  Programpaymentfinal::find_all();
}
else
{
    $program_payment_final= get_wardwise_result_sql_program($_POST['ward_no'],"program_payment_final");
}
foreach($program_payment_final as $final)
{
        $program_result=Programpaymentfinal::find_by_program_id1($data->id);
        $advance_total = Programpayment::get_total_payment_amount($data->id);
        $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
        $expenditure_amount = $advance_total + $net_total_amount_total;
        $rem_budget = $data->investment_amount - $expenditure_amount;
}
endif;
?>
<style>
                          table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">आन्तरिक रिपोर्ट हेर्नुहोस | <a href="report_dashboard.php" class="btn">पछि जानुहोस </a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                
                <div class="userprofiletable">
				  
                                  <form method="post" onsubmit="form.submit()" >
                                  <div class="inputWrap">
                                  		<h1>आन्तरिक रिपोर्ट हेर्नुहोस</h1>
                                        <div class="titleInput">योजना / कार्यक्रम  खोज्नुहोस:</div>
                                        <div class="newInput"><select name="type"  onchange="form.submit();">
                                                <option value="">-छान्नुहोस्-</option>
                                                <option value="0" <?php if($type==0){ echo 'selected="selected"';}?>>योजना</option>
                                    		<option value="1" <?php if($type==1){ echo 'selected="selected"';}?>>कार्यक्रम</option>
                                            </select></div>
                                         <div class="titleInput">वार्ड छान्नुहोस् :</div>
                                         <?php if($mode=="user"):?> 
                                          <div class="newInput"><select name="ward_no">
                                               
                                               <option value="<?=$user->ward?>"><?=convertedcit($user->ward)?></option>
                                    		</select></div>
                                         <?php else:?>
                                        <div class="newInput"><select name="ward_no">
                                                <option value="">-छान्नुहोस्-</option>
                                                <option value="0">नगरपालिका</option>
                                               <?php for($i=1;$i<=$max_ward;$i++):?>
                                                <option value="<?=$i?>" <?php if($ward==$i){ echo 'selected="selected"';}?>><?=convertedcit($i)?></option>
                                    		<?php endfor;?>
                                            </select></div>
                                            <?php endif;?>
                                         <div class="saveBtn myWidth100"><input type="submit" class="btn" name="submit" value="खोज्नुहोस"/></div>   
                                        <div class="myspacer"></div>    	
                                  </div><!-- input wrap ends -->
                                  
                                      
                                  </form>
                                  <?php $nagar_plans = Plandetails1::find_by_sql("select * from plan_details1 where ward_no = 0");//echo "<pre>";print_r($nagar_plans);?>
                                  <?php if(isset($_POST['submit'])):
                                  $type=$_POST['type'];    
                                  ?>
        <div class="myPrint"><a target="_blank" href="report_print.php?type=<?= $type ?>&ward_no=<?=$ward?>">प्रिन्ट गर्नुहोस</a></div><div class="myPrint"><a class="" href="report_excel.php?type=<?php echo $type;?>&ward_no=<?=$ward?>">Export to EXCEL</a></div>
        <div class="exporte"></div><br> 
         <?php if(!empty($ward)){
                                          echo "<h2>".convertedcit($ward)." नं वार्ड को ".get_type_nepali($type)." हेर्नुहोस </h2>";
                                      }
?>
                                 <?php if($_POST['type']==0):?>
                                  <table class="table table-bordered table-hover">
                                          
                                      <tr>
                                            <td class="myCenter"><strong>योजना  रिपोर्ट </strong></td>
                                            <td class="myCenter"><strong>जम्मा योजना</strong></td>
                                            <td class="myCenter"><strong>जम्मा अनुदान </strong></td>
                                             <td class="myCenter"><strong>हाल सम्मको खर्च </strong></td>
                                            <td class="myCenter"><strong>बाँकी रकम </strong></td>
                                            <td class="myCenter"><strong>विवरण हेर्नुहोस </strong></td>
                                      </tr>
                                      
                                       <tr>
                                          <td class="myCenter">कुल योजना </td>
                                        <td class="myCenter"><?php echo convertedcit($kul_yojana_count); ?> </td>
                                        <td class="myCenter">रु. <?php  echo convertedcit(placeholder($kul_yojana_total_investment)); ?> </td>
                                         <td class="myCenter">रु.<?php echo convertedcit(placeholder($total_kul_yojana_expenditure)); ?></td>
                                         <td class="myCenter">रु.<?php echo convertedcit(placeholder($total_remaining_kul_yojana)); ?></td>
                                        <td class="myCenter"><a href="view_report0.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                      </tr>
                                       <tr>
                                          <td class="myCenter">दर्ता भएको तर कुनै विवरण नभरिएको </td>
                                        <td class="myCenter"><?php echo convertedcit($darta_count); ?> </td>
                                        <td class="myCenter">रु. <?php  echo convertedcit(placeholder($darta_total_investment1)); ?> </td>
                                         <td class="myCenter">रु.<?php echo convertedcit(placeholder(0)); ?></td>
                                         <td class="myCenter">रु.<?php echo convertedcit(placeholder($darta_total_investment1)); ?></td>
                                        <td class="myCenter"><a href="view_report1.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                      </tr>
                                      
                                      <tr>
                                          <td class="myCenter">दर्ता भई सम्झौता भएका योजना </td>
                                        <td class="myCenter"><?php echo convertedcit($samjhauta_count); ?> </td>
                                        <td class="myCenter">रु. <?php  echo convertedcit(placeholder($samjhauta_total_investment)); ?> </td>
                                        <td class="myCenter">रु.<?php echo convertedcit(0);?></td>
                                         <td class="myCenter">रु.<?php  echo convertedcit(placeholder($samjhauta_total_investment)); ?></td>
                                        <td class="myCenter"><a href="view_report3.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                      </tr>
                                       <tr>
                                          <td class="myCenter">मुल्यांकनको आधारमा भुक्तानी लागेको योजना संख्या</td>
                                        <td class="myCenter"><?php echo convertedcit($analysis_count); ?> </td>
                                        <td class="myCenter">रु. <?php echo convertedcit(placeholder($analysis_total_investment)); ?> </td>
                                        <td class="myCenter">रु.<?php echo convertedcit(placeholder($total_analysis_total_payment)); ?></td>
                                         <td class="myCenter">रु.<?php echo convertedcit(placeholder($total_analysis_remaining_amount)); ?></td>
                                        <td class="myCenter"><a href="view_report5.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                       </tr>    
                                       
                                        <tr>
                                          <td class="myCenter">पेश्की भुक्तानी लागेको योजना संख्या</td>
                                        <td class="myCenter"><?php echo convertedcit($advance_array_count); ?> </td>
                                        <td class="myCenter">रु. <?php echo convertedcit(placeholder($advance_plan_total_investment)); ?> </td>
                                       <td class="myCenter">रु.<?php echo convertedcit(placeholder($total_advance_plan_amount)); ?></td>
                                        <td class="myCenter">रु.<?php echo convertedcit(placeholder($total_remaining_advance_amount)); ?></td>
                                        <td class="myCenter"><a href="view_report4.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                       </tr>
                                      <tr>
                                          <td class="myCenter">अन्तिम भुक्तानी  लागेको आथवा सम्पन्न भएका योजना संख्या</td>
                                        <td class="myCenter"><?php echo convertedcit($final_plan_count); ?> </td>
                                        <td class="myCenter">रु. <?php  echo convertedcit(placeholder($final_plan_total_investment)); ?> </td>
                                        <td class="myCenter">रु.<?php  echo convertedcit(placeholder($final_plan_total_investment)); ?></td>
                                         <td class="myCenter">रु.<?php echo convertedcit(0);?></td>
                                        <td class="myCenter"><a href="view_report.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                      </tr>
                                      <tr>
                                          <td colspan="6"><div align="center"><strong>जम्मा सम्झौता</strong></div></td>
                                      </tr>
                                      <tr>
                                         <td class="myCenter">सझौता भएका कुल योजना </td>
                                        <td class="myCenter"><?php echo convertedcit($samjhauta_count + $analysis_count + $advance_array_count + $final_plan_count); ?> </td>
                                        <td class="myCenter">रु. <?php  echo convertedcit(placeholder($samjhauta_total_investment+$analysis_total_investment+$advance_plan_total_investment+$final_plan_total_investment)); ?> </td>
                                         <td class="myCenter">रु.<?php echo convertedcit(placeholder($total_analysis_total_payment+$total_advance_plan_amount+$final_plan_total_investment)); ?></td>
                                         <td class="myCenter">रु.<?php echo convertedcit(placeholder($darta_total_investment1+$samjhauta_total_investment+$total_analysis_remaining_amount+$total_remaining_advance_amount)); ?></td>
                                        <td class="myCenter"><a href="view_report_0_1.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td> 
                                      </tr>
<!--                                      <tr>
                                          <td>ठेक्का मार्फत संचालन भएका योजना</td>
                                        <td><?php// echo convertedcit($contract_count); ?> </td>
                                        <td>रु. <?php // echo convertedcit(placeholder(0)); ?> </td>
                                        <td>रु.<?php  //echo convertedcit(placeholder(0)); ?></td>
                                         <td>रु.<?php //echo convertedcit(0);?></td>
                                        <td><a href="#">थप विवरण</a></td>
                                      </tr>-->
                                      </table>
                                      <?php endif;?>
                                     
                                      <?php if($_POST['type']==1):?>
                                     <table class="table table-bordered table-hover">
                                        <tr>
                                            <td class="myCenter"> <strong>कार्यक्रमको  रिपोर्ट </strong></td>
                                            <td class="myCenter"><strong>जम्मा  कार्यक्रम </strong></td>
                                            <td class="myCenter"><strong>जम्मा अनुदान </strong></td>
                                            <td class="myCenter"><strong>हाल सम्मको खर्च </strong></td>
                                            <td class="myCenter"><strong>बाँकी रकम</strong> </td>
                                            <td class="myCenter"><strong>विवरण हेर्नुहोस</strong> </td>
                                      </tr>
                                        <tr>
                                          <td class="myCenter">कुल आथवा दर्ता भएको कार्यक्रम संख्या</td>
                                        <td class="myCenter"><?php echo convertedcit($program_count); ?> </td>
                                        <td class="myCenter">रु. <?php  echo convertedcit(placeholder($program_total_investment)); ?> </td>
                                        <td class="myCenter">रु.<?php  echo convertedcit(placeholder($total_budget1)); ?></td>
                                         <td class="myCenter">रु.<?php  echo convertedcit(placeholder($total_remaining_budget)); ?></td>
                                        <td class="myCenter"><a href="view_program_report.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                      </tr>
                                      <tr>
                                          <td class="myCenter">दर्ता भएको तर कुनै विवरण नभरिएको कार्यक्रम संख्या</td>
                                        <td class="myCenter"><?php echo convertedcit($program_count1); ?> </td>
                                        <td class="myCenter">रु. <?php echo convertedcit(placeholder($porgram_total_investment1)); ?> </td>
                                        <td class="myCenter">रु.<?php echo convertedcit(placeholder(0)); ?></td>
                                         <td class="myCenter">रु.<?php echo convertedcit(placeholder($porgram_total_investment1)); ?></td>
                                        <td class="myCenter"><a href="view_program_report1.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                      </tr>
                                      <tr>
                                          <td class="myCenter">खर्च भएको तर सम्पन्न नभएको कार्यक्रम</td>
                                          <?php $budget_rem_details = count_program_by_budget_remaining($_POST['ward_no']);?>
                                          <td class="myCenter"><?php echo convertedcit($budget_rem_details["count"]); ?> </td>
                                        <td class="myCenter">रु. <?php echo convertedcit(placeholder($budget_rem_details["total_investment_amount"])); ?> </td>
                                         <td class="myCenter" ><?php echo convertedcit(placeholder($budget_rem_details["total_expenditure_amount"])); ?></td>
                                        <td class="myCenter"><?php echo convertedcit(placeholder($budget_rem_details["total_rem_budget"])); ?></td>
                                        <td class="myCenter"><a href="view_program_report4.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                       </tr>
                                      <tr>
                                          <td class="myCenter">पेश्की भुक्तानी लागेको कार्यक्रम संख्या</td>
                                        <td class="myCenter"><?php echo convertedcit($program_count2); ?> </td>
                                        <td class="myCenter">रु. <?php echo convertedcit(placeholder($porgram_total_investment2)); ?> </td>
                                        <td class="myCenter"><?php echo convertedcit(placeholder($total_advance)); ?></td>
                                        <td class="myCenter"><?php echo convertedcit(placeholder($total_remaining_advance)); ?></td>
                                        <td class="myCenter"><a href="view_program_report2.php?ward_no=<?=$_POST['ward_no']?>" class="btn" style="text-align:right">थप विवरण</a></td>
                                      </tr>
                                       <tr>
                                          <td class="myCenter">अन्तिम भुक्तानी  लागेको आथवा सम्पन्न भएका  कार्यक्रम संख्या</td>
                                        <td class="myCenter"><?php echo convertedcit($no_budget_rem_details["count"]); ?> </td>
                                        <td  class="myCenter">रु. <?php echo convertedcit(placeholder($no_budget_rem_details["total_investment_amount"])); ?> </td>
                                         <td  class="myCenter"><?php echo convertedcit(placeholder($no_budget_rem_details["total_expenditure_amount"])); ?></td>
                                        <td class="myCenter"><?php echo convertedcit(placeholder($no_budget_rem_details["total_rem_budget"])); ?></td>
                                        <td class="myCenter"><a href="view_program_report3.php?ward_no=<?=$_POST['ward_no']?>" class="btn">थप विवरण</a></td>
                                       </tr>
                                           <?php endif;?>
                                  </table>  
                                  <?php endif;?>
					
                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>