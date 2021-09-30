<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
?>
<?php 
    $topic_area_id=$_GET['topic_area_id'];
    $topic_area_type_id=$_GET['topic_area_type_id'];
    $sql="select * from plan_details1 where topic_area_id=$topic_area_id and topic_area_type_id=$topic_area_type_id";
    $result=  Plandetails1::find_by_sql($sql);
    ?> 
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>मुख्य रिपोर्ट  सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
       <div class="userprofiletable">
                        	<div class="printPage">
                                  <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    
									  <div style="text-align:center;">
                                  <span style="text-align:center;"><?php echo SITE_LOCATION;?></span><br>
                    <span  style="text-align:center;">गाँउ कार्यपालिकाको कार्यालय</span><br>
                          <span  style="text-align:center;"><?=SITE_ADDRESS?></span><br>
                           <span  style="text-align:center;">योजनाको प्रगती विवरण</span><br>
                         <span  style="text-align:center;">बिषयगत क्षेत्र- <?php echo Topicarea::getName($topic_area_id);?></span><br>
                        <span  style="text-align:center;"><?php echo Topicareatype::getName($topic_area_type_id);?></span>
                                  </div>
                 <table class="table-bordered table-responsive">
                        <tr>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td >&nbsp;</td>
                          <td colspan="4">योजना संचालन प्रकिया</td>
                          <td colspan="5">योजना</td>
                          <td colspan="2">भुक्तानीको अबस्था</td>
                          <td colspan="2">लाभान्भित जनसंख्या </td>
                        </tr>
                        <tr>
                          <td>सिनं</td>
                          <td>योजनाको नाम</td>
                          <td>वडा नं</td>
                          <td>अनुदानको किसिम</td>
                          <td>योजनाको कुल लागत</td>
                          <td>उपभोक्ता समति </td>
                          <td>ठेक्का</td>
                          <td>संध संस्था</td>
                          <td>अमानत</td>
                          <td>संझौता मिति</td>
                          <td>संम्पन्न हुने मिति</td>
                          <td>संम्पन्न मिति</td>
                          <td>योजनाको भौतिक लक्ष्य</td>
                          <td>योजनाको भौतिक प्रगति</td>
                          <td>हाल सम्मको भुक्तानी</td>
                          <td>भुक्तानी दिन बाँकी रकम</td>
                          <td>पुरुष</td>
                          <td>महिला</td>
                        </tr>
                        <?php
                       
                        $total="";
                        $total1="";
                        $total2="";
                         $j = 1;
                        foreach($result as $data){
//                         echo "<pre>";     print_r($data);echo "</pre>";
                                    $data1=  Plantotalinvestment::find_by_plan_id($data->id);
                                    $data2= Moreplandetails::find_by_plan_id($data->id);
                                    $data3= Profitablefamilydetails::find_by_plan_id($data->id);
                                    $data4=Planamountwithdrawdetails::find_by_plan_id($data->id);
                                    $data6=Plantotalinvestment::find_by_plan_id($data->id);
                                    // भुक्तानी दिन बाँकी रकम
                                    if(empty($data4->remaining_payment_amount))
                                    {
                                        $data5=Analysisbasedwithdraw::getMaxInsallmentByPlanId($data->id);
                                         $total_amount1="";
                                         for($i=1;$i<=$data5;$i++)
                                            {
                                               $data5_0=  Analysisbasedwithdraw::find_by_max($i, $data->id);

                                                $total_amount1 += $data5_0->payable_amount;
                                            }
                                        $amount= $data1->total_investment - $total_amount1;
                                        if(empty($amount))
                                        {
                                            $net_payable_amount=$data->investment_amount;
                                        }
                                        else
                                        {
                                            $net_payable_amount = $amount;
                                        }
                                    }
                                    else
                                    {
                                        $net_payable_amount=$data4->remaining_payment_amount;
                                    }
                                    // हाल सम्मको भुक्तानी
                                     if(empty($data4->payment_till_now))
                                    {
                                            $data6=Analysisbasedwithdraw::getMaxInsallmentByPlanId($data->id);
        //                                    echo $data5;
                                            $total_amount="";
                                            for($i=1;$i<=$data6;$i++)
                                            {
                                                $data6_0=  Analysisbasedwithdraw::find_by_max($i, $data->id);

                                                $total_amount += $data5_0->payable_amount;
                                            }

                                            if(!empty($total_amount))
                                            {
                                                $net_taken_amount=$total_amount;
                                            }
                                            else
                                            {
                                                $net_taken_amount=0;
                                            }
        //                                    echo $total_amount;exit;
                                    }

                                    else
                                    {
                                        $net_taken_amount=$data4->payment_till_now;
                                    }

                                ?>
                                <tr>
                                  <td><?php echo convertedcit($j);?></td>
                                  <td><?php echo $data->program_name; ?></td>
                                  <td><?php echo convertedcit($data->ward_no);?></td>
                                  <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                  <td><?php echo convertedcit($data1->total_investment);?></td>
                                  <td><?php echo "उपभोक्ता समति ";?></td>
                                  <td><?php ?></td>
                                  <td><?php ?></td>
                                  <td><?php ?></td>
                                  <td><?php  echo convertedcit($data2->miti); ?></td>
                                  <td><?php echo convertedcit($data2->yojana_sakine_date);?></td>
                                  <td><?php echo convertedcit($data4->plan_end_date);?></td>
                                  <td><?php ?></td>
                                  <td><?php ?></td>
                                  <td><?php echo convertedcit($net_taken_amount);?></td>
                                  <td><?php echo convertedcit($net_payable_amount);?></td>
                                  <td><?php echo convertedcit($data3->male);?></td>
                                  <td><?php echo convertedcit($data3->female);?></td>
                                </tr>
                                <?php $j++ ;
                                $total += $data1->total_investment;
                                $total1 +=$net_taken_amount;
                                $total2 +=$net_payable_amount;
                        }
                        
                         ?>  
                         <tr>
                          <td>&nbsp;</td>
                          <td>जम्मा</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><?php echo convertedcit($total);?></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><?php echo convertedcit($total1);?></td>
                          <td><?php echo convertedcit($total2);?></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                  </table>
                    
										<div class="myspacer30"></div>
										
										
										<div class="myspacer"></div>
									</div>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->