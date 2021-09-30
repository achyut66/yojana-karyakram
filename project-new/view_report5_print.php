<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
 $counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
$analysis_based_plan_array=$counted_result['analysis_count_array'];
if(!empty($analysis_based_plan_array))
{
    $total_investment10 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $analysis_based_plan_array));
    $result=  Plandetails1::find_by_plan_id(implode(",", $analysis_based_plan_array));
}
else
{
    $total_investment10=0;
    $result='';
}

   ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1"><?php echo SITE_ADDRESS;?></h5>
                      <div class="myspacer"></div>
                    <div class="subject"><b><u>मुल्यांकनको आधारमा भुक्तानी लागेको योजना संख्या</b></u> </div>	
                                <div class="myspacer"></div>
                      <table class="table table-bordered table-hover">
                           <tr>   
                                    <td class="myCenter"><strong>सि.न </strong></td>
                                    <td class="myCenter"><strong>दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको उपशिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको विनियोजन किसिम</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं</strong></td>
                                    <td class="myCenter"><strong>अनुदान रु</strong></td>
                                    <td class="myCenter"><strong>हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"> <strong>कुल बाँकी रकम</strong></td>
                                    </tr>
                                <?php $i=1; 
                                $total_net_payable_amount="";
                                $total_remaining_amount="";
                                foreach($result as $data):
                                    $samiti_plan_total=Samitiplantotalinvestment::find_by_plan_id($data->id);
                                   $contract_plan_total=  Contract_total_investment::find_by_plan_id($data->id);
                                    $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                    $amanat_lagat = AmanatLagat::find_by_plan_id($data->id);
                                    if(empty($contract_result))
                                    {
                                        $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                        $remaining_amount=$data->investment_amount - $net_payable_amount;
                                    }
                                    else
                                    {
                                        $net_payable_amount= Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                        $remaining_amount=$data->investment_amount - $net_payable_amount;
                                    }
                              
                                    ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit($net_payable_amount);?></td>
                                      <td class="myCenter"><?php echo convertedcit($remaining_amount);?></td>
                                     </tr>
                         <?php $i++;
                           $total_net_payable_amount +=$net_payable_amount;
                         $total_remaining_amount +=$remaining_amount;
                         endforeach;?>
                                <tr>
                                    <td colspan="7">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td><?php echo convertedcit(placeholder($total_investment10)); ?></td>
                               <td><?php echo convertedcit(placeholder($total_net_payable_amount)); ?></td>
                             <td><?php echo convertedcit(placeholder($total_remaining_amount)); ?></td>
                         </tr>
                     </table>
									
                    
										<div class="myspacer20"></div>
<div class="oursignature">&nbsp</div><div class="myspacer"></div>

									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->