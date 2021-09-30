<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$program_sql="select * from plan_details1 where type=1";
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

<?php include("menuincludes/header1.php"); ?>

<body>
    
    <div id="body_wrap_inner"> 

<div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>
									
									<div class="printContent">  
				  <h3>दर्ता भएको कार्यक्रमको रिपोर्ट हेर्नुहोस</h3>
                                    
                     <table class="table table-bordered table-responsive">
                           <tr>   
                           		<th>सि.न</th>
                                    <th >दर्ता नं</th>
                                    <th>कार्यक्रमको नाम</th>
                                    <th>कार्यक्रमको  बिषयगत क्षेत्रको किसिम</th>
                                    <th>कार्यक्रमको शिर्षकगत किसिम:</th>
                                    <th>कार्यक्रमको  विनियोजन किसिम:</th>
                                    <th>वार्ड नं :</th>
                                    <th>अनुदान रु :</th>
                                    <th>हाल सम्मको खर्च</th>
                                    <th>बाँकी रकम</th>
                                  
                                </tr>
                                <?php 
                                $i=1;
                                $total_investment_amount = 0;
                                $total_expendiutre_till_now=0;
                                $total_remaining_program_budget=0;
                                
                                foreach($result as $data):
                                    $program_result=Programpaymentfinal::find_by_program_id1($data->id);
                                    $advance_total = Programpayment::get_total_payment_amount($data->id);
                                    $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
                                    $expenditure_amount = $advance_total + $net_total_amount_total;
                                    $rem_budget = $data->investment_amount - $expenditure_amount;
                                    
                                    $total_investment_amount += $data->investment_amount;
                                    $total_expendiutre_till_now += $expenditure_amount;
                                    $total_remaining_program_budget += $rem_budget;
                                ?>
                                <tr>
                                    <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td><?php echo convertedcit($data->investment_amount);?></td>
                                    <td><?php echo convertedcit($expenditure_amount);?></td>
                                    <td><?php echo convertedcit($rem_budget);?></td>
                                  
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
            </div>
         </div>   
</div>
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>