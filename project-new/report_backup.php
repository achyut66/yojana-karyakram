<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>

<!--कुल योजना-->
<?php

$sql="select * from plan_details1 where type=0 or type=''";
$result1=  Plandetails1::find_by_sql($sql);
$result1_array=array();
foreach($result1 as $data)
{
    array_push($result1_array, $data->id);
}
//echo "<pre>";print_r($result1_array);echo "</pre>";exit;
$count0=count($result1);
$total_investment0 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $result1_array));
$expenditure=  Plandetails1::find_by_plan_id(implode(",", $result1_array));
$data1_0= Planamountwithdrawdetails::find_all();
$final_array1_0=array();
foreach($data1_0 as $data)
{
    array_push($final_array1_0, $data->plan_id);
}
$total_net_payable_amount="";
$total_remaining_amount="";
foreach($expenditure as $data):
        // भुक्तानी दिन बाँकी रकम
    if(in_array($data->id, $final_array1_0))
    {
        $net_payable_amount=$data->investment_amount;
         $remaining_amount=0; 
    }
    else
    {
         $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
        $remaining_amount=$data->investment_amount - $net_payable_amount; 
    }
$total_net_payable_amount +=$net_payable_amount;
$total_remaining_amount +=$remaining_amount;
endforeach;?>
                               
                                

<!--मुल्यांकनको आधारमा भुक्तानी लागेको योजना संख्या-->
<?php
$result10=Analysisbasedwithdraw::find_all();
//print_r($result10);exit;
$result10_array=array();
foreach($result10 as $data)
{
    array_push($result10_array, $data->plan_id);
}
$result_array10= array_unique($result10_array);
$count10 = count($result_array10);
//echo $count5;exit;
$total_investment10 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $result_array10));
$expenditure1=  Plandetails1::find_by_plan_id(implode(",", $result_array10));
 $total_net_payable_amount1="";
$total_remaining_amount1="";
foreach($expenditure1 as $data):
    $net_payable_amount1=Planamountwithdrawdetails::get_payement_till_now($data->id);
    $remaining_amount1=$data->investment_amount - $net_payable_amount1;
    $total_net_payable_amount1 +=$net_payable_amount1;
    $total_remaining_amount1 +=$remaining_amount1;
    endforeach;
?>
<!--दर्ता भई सम्झौता भएका योजना  -->
<?php
$result2=Moreplandetails::find_all();
$result2_array=array();
foreach($result2 as $data)
{
    array_push($result2_array, $data->plan_id);
}
$array_final=  array_unique($result2_array);
$count3=count($array_final);
$total_investment3 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $array_final));

?>
<!--सम्पन्न भएका योजना संख्या-->
<?php 
$data=  Publicinvestigationdetails::find_all();
$data1= Planamountwithdrawdetails::find_all();
$plan_id_array=array();
foreach($data1 as $data)
{
    array_push($plan_id_array, $data->plan_id);
}
$final_array=  array_unique($plan_id_array);
$count=count($final_array);
$total_investment = Plandetails1::get_total_investment_by_plan_ids(implode(",", $final_array));
?>
<!--दर्ता भएको तर कुनै विवरण नभरिएको योजना संख्या-->
    <?php
    $sql1="select * from plan_details1 where type=0";
    $result=  Plandetails1::find_by_sql($sql);
    $result1=Plantotalinvestment::find_all();
    $plan_id_array1=array();
    $plan_id_array2=array();
    foreach($result as $data)
    {
        array_push($plan_id_array1,$data->id);
    }
    foreach($result1 as $data)
    {
        array_push($plan_id_array2,$data->plan_id);
    }
    $result_array1=  array_unique($plan_id_array2);
    $result_array=array_diff($plan_id_array1,$result_array1);
    $final_array1=array_unique($result_array);
    $count1=count($final_array1);
    $total_investment1=Plandetails1::get_total_investment_by_plan_ids(implode(",", $final_array1));
    ?>
<!--पेश्की भुक्तानी लागेको योजना संख्या-->
<?php
$data5= Planstartingfund::find_all();
if(empty($data5))
{
    $count5=0;
    $total_investment5=0;
}
else
{
    $plan_id_array5=array();
foreach($data5 as $data)
{
    array_push($plan_id_array5, $data->plan_id);
}
//echo "<pre>";
//print_r($plan_id_array5);echo "</pre>";exit;
$final_array5=  array_unique($plan_id_array5);
$count5=count($final_array5);
$total_investment5= Plandetails1::get_total_investment_by_plan_ids(implode(",", $final_array5));
$expenditure2=  Plandetails1::find_by_plan_id(implode(",", $final_array5));
$total_net_payable_amount2="";
$total_remaining_amount2="";
foreach($expenditure2 as $data):

            // भुक्तानी दिन बाँकी रकम
        $net_payable_amount2=Planamountwithdrawdetails::get_payement_till_now($data->id);
        $remaining_amount2=$data->investment_amount - $net_payable_amount; 
         $total_net_payable_amount2 +=$net_payable_amount2;
        $total_remaining_amount2 +=$remaining_amount2;
        endforeach;
        
}
//print_r($data5);exit;
?>
<!--दर्ता भएको कार्यक्रम संख्या-->
<?php
$program_sql="select * from plan_details1 where type=1";
$program_result=  Plandetails1::find_by_sql($program_sql);
//echo count($program_result);exit;
$program_result_array=array();
foreach($program_result as $data)
{
    array_push($program_result_array, $data->id);
}
$program_count=count($program_result);
$program_total_investment = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_result_array));

?>
<!--दर्ता भएको तर कुनै विवरण नभरिएको कार्यक्रम संख्या-->
<?php
    $sql1="select * from plan_details1 where type=1";
    $program_result1=  Plandetails1::find_by_sql($sql1);
//    echo count($program_result1);exit;
    $program_result2 = Programmoredetails::find_all();
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
    $program_result_array = array_diff($program_id_array1,$program_result_array1);
    $program_final_array = array_unique($program_result_array);
    $program_count1 = count($program_final_array);
    $porgram_total_investment1 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_final_array));
?>
<!--पेश्की भुक्तानी लागेको कार्यक्रम संख्या-->
<?php
    $program_result3 = Programpayment::find_all();
    $program_result3_1= Programpaymentfinal::find_all();
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
     $program_count2 = count($result_program_array);
    $porgram_total_investment2 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $result_program_array));
     $result=  Plandetails1::find_by_plan_id(implode(",", $result_program_array));
     $total_advance="";
    $total_remaining_advance="";
    foreach($result as $data):
            $max_id=Programpayment::getMaxIds($data->id);
            //                                echo $max_id;exit;
            $advance_total="";
            for($i=0;$i<=$max_id;$i++)
            {
                $advance_result=Programpayment::find_by_program_id_and_sn($data->id,$i);

                $advance_total += $advance_result->payment_amount;
            }
            //                                echo $advance_total;exit;
                        $reamining_advance=$data->investment_amount - $advance_total;
                         $total_advance +=$advance_total;
            $total_remaining_advance += $reamining_advance;
endforeach;
?>
<!--अन्तिम भुक्तानी  लागेको कार्यक्रम संख्या-->
<?php
    $program_result4 = Programpaymentfinal::find_all();
    $program_id_array4=array();
    foreach($program_result4 as $data)
    {
         array_push($program_id_array4,$data->program_id);
    }
    $program_result_array3 =  array_unique($program_id_array4);
     $program_count3 = count($program_result_array3);
    $porgram_total_investment3 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_result_array3));
      $result_program=  Plandetails1::find_by_plan_id(implode(",", $program_result_array3));
        $remaining_budget="";
        $remaining_net_payment="";
        foreach($result_program as $data):
            $max_id=Programmoredetails::getMaxInsallmentByPlanId($data->id);
        if(empty($max_id))
        {
            $remaining_amount=$data->investment_amount;
            $net_payable_amount=0;
        }
        else
            {
                    $program_result = Programmoredetails::find_by_program_id_and_sn($data->id,$max_id);
                   $remaining_amount = $program_result->budget-$program_result->remaining_budget;
                   $net_payable_amount = $data->investment_amount - $remaining_amount ;
            }

            if($net_payable_amount!=0)
            {
              $remaining_budget +=$remaining_amount;
//            $remaining_net_payment +=$net_payable_amount;
            }
            endforeach;
            $remaining_net_payment=$porgram_total_investment3 - $remaining_budget;
            
?>
<?php
$total_budget1=  Programpaymentfinal::get_net_total_amount_sum_for_all_programs() + Programpayment::get_total_payment_amount_for_all_programs();
$total_remaining_budget=$program_total_investment - $total_budget1;
?>
<?php
//खर्च भएको तर सम्पन्न नभएको कार्यक्रम
$program_payment_final=  Programpaymentfinal::find_all();
foreach($program_payment_final as $final)
{
        $program_result=Programpaymentfinal::find_by_program_id1($data->id);
        $advance_total = Programpayment::get_total_payment_amount($data->id);
        $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
        $expenditure_amount = $advance_total + $net_total_amount_total;
        $rem_budget = $data->investment_amount - $expenditure_amount;
}
?>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">रिपोर्ट हेर्नुहोस </h2>
            <div class="OurContentLeft">
                  <?php include("menuincludes/settingsmenu.php");?>
            </div>	
                <?php echo $message;?>
            <div class="OurContentRight">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  <h3>रिपोर्ट हेर्नुहोस  </h3>
                                  <form method="post" onsubmit="form.submit()" >
                                      योजना / कार्यक्रम  खोज्नुहोस:
                                            <select name="type"  onchange="form.submit();">
                                                <option value="">-छान्नुहोस्-</option>
                                                <option value="0">योजना</option>
                                    		<option value="1">कार्यक्रम</option>
                                            </select>
                                      &nbsp;&nbsp;
                                      <input type="submit" class="submithere" name="submit" value="खोज्नुहोस"/>
                                      
                                  </form>
                                  <?php if(isset($_POST['submit'])):?>
                                  <?php if($_POST['type']==0):?>
                                  <table class="table table-bordered table-responsive mytable">
                                      <tr>
                                            <th>योजना  रिपोर्ट </th>
                                            <th>जम्मा योजना</th>
                                            <th>जम्मा अनुदान </th>
                                             <th>हाल सम्मको खर्च </th>
                                            <th>बाँकी रकम </th>
                                            <th>विवरण हेर्नुहोस </th>
                                      </tr>
                                      
                                       <tr>
                                          <td>कुल योजना </td>
                                        <td><?php echo convertedcit($count0); ?> </td>
                                        <td>रु. <?php  echo convertedcit(placeholder($total_investment0)); ?> </td>
                                         <td>रु.<?php echo convertedcit(placeholder($total_net_payable_amount)); ?></td>
                                         <td>रु.<?php echo convertedcit(placeholder($total_remaining_amount)); ?></td>
                                        <td><a href="view_report0.php">थप विवरण</a></td>
                                      </tr>
                                      
                                      <tr>
                                          <td>दर्ता भई सम्झौता भएका योजना </td>
                                        <td><?php echo convertedcit($count3); ?> </td>
                                        <td>रु. <?php  echo convertedcit(placeholder($total_investment3)); ?> </td>
                                        <td>रु.<?php echo convertedcit(0);?></td>
                                         <td>रु.<?php  echo convertedcit(placeholder($total_investment3)); ?></td>
                                        <td><a href="view_report3.php">थप विवरण</a></td>
                                      </tr>
                                       <tr>
                                          <td>मुल्यांकनको आधारमा भुक्तानी लागेको योजना संख्या</td>
                                        <td><?php echo convertedcit($count10); ?> </td>
                                        <td>रु. <?php echo convertedcit(placeholder($total_investment10)); ?> </td>
                                        <td>रु.<?php echo convertedcit(placeholder($total_net_payable_amount1)); ?></td>
                                         <td>रु.<?php echo convertedcit(placeholder($total_remaining_amount1)); ?></td>
                                        <td><a href="view_report5.php">थप विवरण</a></td>
                                       </tr>    
                                       
                                        <tr>
                                          <td>पेश्की भुक्तानी लागेको योजना संख्या</td>
                                        <td><?php echo convertedcit($count5); ?> </td>
                                        <td>रु. <?php echo convertedcit(placeholder($total_investment5)); ?> </td>
                                       <td >रु.<?php echo convertedcit(placeholder($total_net_payable_amount2)); ?></td>
                                        <td >रु.<?php echo convertedcit(placeholder($total_remaining_amount2)); ?></td>
                                        <td><a href="view_report4.php">थप विवरण</a></td>
                                       </tr>
                                      <tr>
                                          <td>अन्तिम भुक्तानी  लागेको आथवा सम्पन्न भएका योजना संख्या</td>
                                        <td><?php echo convertedcit($count); ?> </td>
                                        <td>रु. <?php  echo convertedcit(placeholder($total_investment)); ?> </td>
                                        <td>रु.<?php  echo convertedcit(placeholder($total_investment)); ?></td>
                                         <td>रु.<?php echo convertedcit(0);?></td>
                                        <td><a href="view_report.php">थप विवरण</a></td>
                                      </tr>
                                      </table>
                                      <?php endif;?>
                                      <?php if($_POST['type']==1):?>
                                     <table class="table table-bordered table-responsive mytable">
                                        <tr>
                                            <th> कार्यक्रमको  रिपोर्ट </th>
                                            <th>जम्मा  कार्यक्रम </th>
                                            <th>जम्मा अनुदान </th>
                                            <th>हाल सम्मको खर्च </th>
                                            <th>बाँकी रकम </th>
                                            <th>विवरण हेर्नुहोस </th>
                                      </tr>
                                        <tr>
                                          <td>कुल आथवा दर्ता भएको कार्यक्रम संख्या</td>
                                        <td><?php echo convertedcit($program_count); ?> </td>
                                        <td>रु. <?php  echo convertedcit(placeholder($program_total_investment)); ?> </td>
                                        <td>रु.<?php  echo convertedcit(placeholder($total_budget1)); ?></td>
                                         <td>रु.<?php  echo convertedcit(placeholder($total_remaining_budget)); ?></td>
                                        <td><a href="view_program_report.php">थप विवरण</a></td>
                                      </tr>
                                      <tr>
                                          <td>दर्ता भएको तर कुनै विवरण नभरिएको कार्यक्रम संख्या</td>
                                        <td><?php echo convertedcit($program_count1); ?> </td>
                                        <td>रु. <?php echo convertedcit(placeholder($porgram_total_investment1)); ?> </td>
                                        <td>रु.<?php echo convertedcit(placeholder(0)); ?></td>
                                         <td>रु.<?php echo convertedcit(placeholder($porgram_total_investment1)); ?></td>
                                        <td><a href="view_program_report1.php">थप विवरण</a></td>
                                      </tr>
                                      <tr>
                                          <td>खर्च भएको तर सम्पन्न नभएको कार्यक्रम</td>
                                          <?php $budget_rem_details = count_program_by_budget_remaining();?>
                                          <td><?php echo convertedcit($budget_rem_details["count"]); ?> </td>
                                        <td>रु. <?php echo convertedcit(placeholder($budget_rem_details["total_investment_amount"])); ?> </td>
                                         <td ><?php echo convertedcit(placeholder($budget_rem_details["total_expenditure_amount"])); ?></td>
                                        <td><?php echo convertedcit(placeholder($budget_rem_details["total_rem_budget"])); ?></td>
                                        <td><a href="view_program_report4.php">थप विवरण</a></td>
                                       </tr>
                                      <tr>
                                          <td>पेश्की भुक्तानी लागेको कार्यक्रम संख्या</td>
                                        <td><?php echo convertedcit($program_count2); ?> </td>
                                        <td>रु. <?php echo convertedcit(placeholder($porgram_total_investment2)); ?> </td>
                                        <td><?php echo convertedcit(placeholder($total_advance)); ?></td>
                                        <td><?php echo convertedcit(placeholder($total_remaining_advance)); ?></td>
                                        <td><a href="view_program_report2.php">थप विवरण</a></td>
                                      </tr>
                                       <tr>
                                          <td>अन्तिम भुक्तानी  लागेको आथवा सम्पन्न भएका  कार्यक्रम संख्या</td>
                                        <td><?php echo convertedcit($program_count3); ?> </td>
                                        <td>रु. <?php echo convertedcit(placeholder($porgram_total_investment3)); ?> </td>
                                         <td ><?php echo convertedcit(placeholder($remaining_budget)); ?></td>
                                        <td><?php echo convertedcit(placeholder($remaining_net_payment)); ?></td>
                                        <td><a href="view_program_report3.php">थप विवरण</a></td>
                                       </tr>
                                           <?php endif;?>
                                  </table>  
                                  <?php endif;?>
					
                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>