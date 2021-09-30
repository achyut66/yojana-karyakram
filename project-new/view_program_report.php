<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(empty($_GET['ward_no']))
{
    $program_sql="select * from plan_details1 where type=1";

}
else
{
    $program_sql="select * from plan_details1 where type=1 and ward_no=".$_GET['ward_no'];

}
$program_result=  Plandetails1::find_by_sql($program_sql);
//echo count($program_result);exit;
$program_result_array=array();
foreach($program_result as $data)
{
    array_push($program_result_array, $data->id);
}
//$program_count=count($program_result);
$program_total_investment = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_result_array));
$result=  Plandetails1::find_by_plan_id(implode(",", $program_result_array));
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">दर्ता भएको कार्यक्रमको रिपोर्ट हेर्नुहोस | <a href="report.php" class="btn">पछि जानुहोस </a></h2>
            
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  
                                  <div class="myPrint"><a target="_blank" href="program_report_print.php">प्रिन्ट गर्नुहोस</a></div>
                     <table class="table table-bordered table-hover">
                           <tr>   
                           		<td class="myCenter"><strong>सि.नं.</strong></td>
                                <td class="myCenter"><strong>दर्ता नं</strong></td>
                                <td class="myCenter"><strong>कार्यक्रमको नाम</strong></td>
                                <td class="myCenter"><strong>कार्यक्रमको  बिषयगत क्षेत्रको किसिम</strong></td>
                                <td class="myCenter"><strong>कार्यक्रमको शिर्षकगत किसिम</strong></td>
                                <td class="myCenter"><strong>कार्यक्रमको  विनियोजन किसिम</strong></td>
                                <td class="myCenter"><strong>वार्ड नं</strong></td>
                                <td class="myCenter"><strong>अनुदान रु</strong></td>
                                <td class="myCenter"><strong>हाल सम्मको खर्च</strong></td>
                                <td class="myCenter"><strong>बाँकी रकम</strong></td>
                                <td class="myCenter"><strong>विवरण हेर्नुहोस </strong></td>
                            </tr>
                                <?php 
                                $i=1;
                                $total_investment_amount = 0;
                                $total_expendiutre_till_now=0;
                                $total_remaining_program_budget=0;
                                
                                foreach($result as $data):
                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                if(!empty($budget))
                                     {
                                         $expenditure_amount =$budget->total_expenditure;
//                                         $remaining_amount= $data->investment_amount - $net_payable_amount; 
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
                                ?>
                                <tr>
                                    <td  class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit($expenditure_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit($rem_budget);?></td>
                                    <td class="myCenter"><a href="program_total_view.php?id=<?=$data->id?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php 
                        $i++;
                         endforeach;
                         ?>
                                <tr>
                                    <td colspan="6">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total_investment_amount)); ?></td>
                              <td ><?php echo convertedcit(placeholder($total_expendiutre_till_now)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_remaining_program_budget)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>