<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$counted_result = getOnlyRegisteredPlans();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$sql ="select * from Plan_details1 where type=0";
$result=  Plandetails1::find_by_sql($sql);
$plan_array=array();
foreach($result as $data)
{
    array_push($plan_array, $data->id);
   
}

$count0=count($plan_array);
$total_investment0 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $plan_array));
$result=  Plandetails1::find_by_plan_id(implode(",", $plan_array));
//echo "<pre>";print_r($result);echo "</pre>";exit;
//print_r($result);exit;
//print_r($result);exit;

?>
<?php

$final_array=$counted_result['final_count_array'];
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
				  <h3>कुल योजनाको रिपोर्ट हेर्नुहोस</h3>
                                   
                     <table class="table table-bordered table-responsive">
                           <tr>   
                                    <th>सि.न </th>
                                    <th >दर्ता नं</th>
                                    <th>योजनाको नाम</th>
                                    <th>योजनाको बिषयगत क्षेत्रको किसिम</th>
                                    <th>योजनाको शिर्षकगत किसिम:</th>
                                    <th>योजनाको उपशिर्षकगत किसिम:</th>
                                    <th>योजनाको विनियोजन किसिम:</th>
                                    <th>वार्ड नं :</th>
                                    <th>अनुदान रु :</th>
                                      <th>हाल सम्म लागेको भुक्तानी</th>
                                    <th> कुल बाँकी रकम</th>
                                    
                                </tr>
                                <?php $i=1; 
                                $total_net_payable_amount=0;
                                $total_remaining_amount=0;
                                    foreach($result as $data):
                                            // भुक्तानी दिन बाँकी रकम
//                                        echo $data->id;exit;
                                        if(in_array($data->id, $final_array))
                                        {
//                                            echo $data->id;
                                            $net_payable_amount=$data->investment_amount;
                                             $remaining_amount=0; 
                                        }
                                        else
                                        {
                                            
                                             $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
//                                             echo $net_payable_amount;exit;
                                            $remaining_amount=$data->investment_amount - $net_payable_amount; 
                                        }
                               ?>
                                <tr>
                                      <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td><?php echo convertedcit($data->investment_amount);?></td>
                                    <td><?php echo convertedcit($net_payable_amount);?></td>
                                      <td><?php echo convertedcit($remaining_amount);?></td>
                                 
                                </tr>
                         <?php $i++; 
                          $total_net_payable_amount +=$net_payable_amount;
                         $total_remaining_amount +=$remaining_amount;
                         endforeach;?>
                                <tr>
                                    <td colspan="7">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total_investment0)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_net_payable_amount)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_remaining_amount)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
