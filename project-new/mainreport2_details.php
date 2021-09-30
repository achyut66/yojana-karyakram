<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$program_id=$_GET['id'];
$program_details= Plandetails1::find_by_id($program_id);

$total_sn= Programmoredetails::countsn($program_id);
$payment_sn= Programpayment::countsn($program_id);
$payment_final_sn= Programpaymentfinal::countsn($program_id);
$time_additional_sn= Programtimeadditionaffiliation::countsn($program_id);
$program_details= Plandetails1::find_by_id($program_id);
$amount= Programmoredetails::getSum($program_id);
if(empty($amount))
{
    $remaining_amount=$program_details->investment_amount;
}
else
{
    $remaining_amount=($program_details->investment_amount)-($amount);
}
$program_more_details= Programmoredetails::find_by_program_id($program_id);
$j=1;
   $total_work_order_budget=0;
                  $total_payment_amount=0;
                  $total_final_paid_amount=0;
include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"> कार्यक्रमको  मुख्य रिपोर्ट हेर्नुहोस / <a href="mainreport2.php">Go Back</a> </h2>
            <div class="OurContentLeft">
                  <?php include("menuincludes/settingsmenu.php");?>
            </div>	
             
            <div class="OurContentRight">
                
                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                      <div style="text-align:center;">
                                  <span style="text-align:center;"><?php echo SITE_LOCATION;?></span><br>
                                  <span  style="text-align:center;">गाँउ कार्यपालिकाको कार्यालय</span><br>
                          <span  style="text-align:center;"><?=SITE_ADDRESS?></span><br>
                           <span  style="text-align:center;">कार्यक्रमको प्रगती विवरण</span><br>
                         <span  style="text-align:center;">बिषयगत क्षेत्र- <?php echo Topicarea::getName($program_details->topic_area_id);?></span><br>
                         <strong> <span  style="text-align:center;"><?php echo Topicareatype::getName($program_details->topic_area_type_id);?></span></strong><br>
                         <b><?php echo Topicareatypesub::getName($program_details->topic_area_type_sub_id); ?></b><br><br>  
                                  </div>
				  <h3> <?= $program_details->program_name?> कार्यक्रमको  मुख्य रिपोर्ट हेर्नुहोस </h3>
                                  <h3> <?="विनियोजित बजेट रु ".convertedcit(placeholder($program_details->investment_amount))." / कार्यक्रमको बाँकी रकम::रु ".convertedcit(placeholder($remaining_amount))?>     </h3>
                    
                    
                    
                   
                                       
                         
                     
                 
                 <table class="table-bordered table-responsive">
                        
                        <tr>
                          <th>सिनं</th>
                          <th>कार्यादेश नं</th>
                          <th>कार्यक्रम संचालन गर्ने </th>
                          <th>कार्यादेश दिने निर्णय भएको मिति</th>
                          <th>कार्यादेश दिईएको रकम</th>
                          <th>कार्यक्रम शुरु हुने मिति</th>
                          <th>कार्यक्रम सम्पन्न हुने मिति</th> 
                          <th>कार्यक्रम संचालन हुने स्थान</th>
                          <th>पेश्की रकम </th>
                          <th> पेश्की दिएको मिती</th>
                          <th>पेश्की लिने मुख्य व्यक्तीको नाम</th>
                          <th>म्यादथप भएको मिति</th>
                          <th>भुक्तानी दिएको मिती</th>
                          <th>भुक्तानी दिइएको खुद रकम </th>
                        </tr>
                       
                       
                        <?php
                       foreach($program_more_details as $details):
                                     if ($details->type_id == '0')
                                        {
                                           $organizer = "फर्म/कम्पनी";

                                        } 
                                    elseif ($details->type_id == '1') 
                                        {
                                           $organizer = "कर्मचारी";
                                        } 
                                    elseif ($details->type_id == '2') 
                                        {
                                           $organizer = "संस्था";
                                        }
                                    elseif ($details->type_id =='3') 
                                        {
                                           $organizer ="पदाधिकारी";
                                        }
                                    else
                                        {
                                           $organizer ="अन्य";
                                        }    
                                    $program_payment= Programpayment::find_by_program_id_and_sn($program_id, $details->sn);
                                    $program_payment_final= Programpaymentfinal::find_by_program_id_and_sn($program_id, $details->sn);
                                    $program_time_addition= Programtimeadditionaffiliation::find_by_program_id_and_sn($program_id,$details->sn); 
                                    if(!empty($program_payment))
                                   {
                                            $payment_amount=convertedcit(placeholder($program_payment->payment_amount));
                                           $paid_date=convertedcit($program_payment->paid_date);
                                           $payment_holder_name=$program_payment->payment_holder_name;
                                   }
                                   else
                                   {
                                            $payment_amount="";
                                            $paid_date="";
                                            $payment_holder_name="";   
                                   }
                                   if(!empty($program_payment_final))
                                   {
                                            $final_paid_date=convertedcit($program_payment_final->paid_date) ;
                                            $final_paid_amount=convertedcit(placeholder($program_payment_final->net_total_amount)) ; 
                                   }
                                   else
                                   {
                                            $final_paid_date="";
                                            $final_paid_amount=""; 
                                   }
                                    if(!empty($program_time_addition))
                                   {
                                            $decsion_date=convertedcit($program_time_addition->decesion_date) ;
                                   }
                                   else
                                   {
                                            $decsion_date="";
                                   }
                                           ?>  
                                    <tr>
                                    <td><?=  convertedcit($j) ?></td>
                                    <td><?=  convertedcit($details->sn) ?></td>
                                    <td><?= Enlist::getName1($details->enlist_id)."(".$organizer.")"  ?></td>
                                    <td><?= convertedcit($details->work_order_date) ?></td>
                                    <td><?= convertedcit(placeholder($details->work_order_budget))?></td>
                                    <td><?= convertedcit($details->start_date) ?></td>
                                    <td><?= convertedcit($details->completion_date)?></td>
                                    <td><?= $details->venue ?></td>
                                    <td><?= $payment_amount ?></td>
                                    <td><?= $paid_date ?></td>
                                    <td><?= $payment_holder_name?></td>
                                    <td><?= $decsion_date?></td>
                                    <td><?= $final_paid_date ?></td>
                                    <td><?= $final_paid_amount?></td>
                                    </tr>

                              <?php  
                              if(!empty($program_more_details))
                              {   
                                 $total_work_order_budget+=$details->work_order_budget;
                              }
                              if(!empty($program_payment))
                              {    
                                 $total_payment_amount+=$program_payment->payment_amount;
                              }
                              if(!empty($program_payment_final))
                              {
                                 $total_final_paid_amount+=$program_payment_final->net_total_amount;
                              }
                              $j++;
                                 ?>   
                        
                <?php endforeach; ?> 
                  <tr> 
                      <td>जम्मा</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><?="रु ".convertedcit(placeholder($total_work_order_budget)) ?></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><?= "रु ".convertedcit(placeholder($total_payment_amount)) ?></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><?= "रु ".convertedcit(placeholder($total_final_paid_amount)) ?></td>
                      
                  
                  </tr>        
                </table>
                                  
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th>कार्यक्रममा भएका कार्यादेशको संख्या</th>
                        <td><?= convertedcit($total_sn) ?></td>
                    </tr>
                    <tr>
                        <th>पेस्की लागिएका कार्यादेशको संख्या</th>
                        <td><?= convertedcit($payment_sn) ?></td>
                    </tr>
                    <tr>
                        <th>भुक्तानी लागिएका कार्यादेशको संख्या</th>
                        <td><?= convertedcit($payment_final_sn) ?></td>
                    </tr>
                    <tr>
                        <th>म्यादथप भएका कार्यादेशको संख्या</th>
                        <td><?= convertedcit($time_additional_sn) ?></td>
                    </tr>
                    
                </table>                     
              
                            
               
            </div>
                
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>