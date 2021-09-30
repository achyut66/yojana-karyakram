<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$date_selected= $_GET['date_selected'];
$url = get_base_url();
$ward_address=WardWiseAddress();
$address= getAddress();
$user = getUser();
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
if(empty($print_history))
{
    $print_history = new PrintHistory;
}
$print_history->url = get_base_url();
$print_history->nepali_date = $date_selected;
$print_history->english_date = DateNepToEng($date_selected);
$print_history->user_id = $user->id;
//$print_history->plan_id = $_GET['id'];
$print_history->worker1 = $_GET['worker1'];
$print_history->worker2 = $_GET['worker2'];
$print_history->worker3 = $_GET['worker3'];
$print_history->save();
$worker1 = Workerdetails::find_by_id($_GET['worker1']);
if(!empty($_GET['worker1']))
{
$worker1 = Workerdetails::find_by_id($_GET['worker1']);
}
else
{
    $worker1 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker2']))
{
$worker2 = Workerdetails::find_by_id($_GET['worker2']);
}
else
{
    $worker2 = Workerdetails::setEmptyObject();
}

if(!empty($_GET['worker3']))
{
   $worker3 = Workerdetails::find_by_id($_GET['worker3']);
}
else
{
    $worker3 = Workerdetails::setEmptyObject();
}
?>
   <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $investment_data = Contract_total_investment::find_by_plan_id($_GET['id']);
    $data2= Contractmoredetails::find_by_plan_id($_GET['id']);
    $contractor_details=  Contractentryfinal::find_by_status(1,$_GET['id']);
    $data3=  Contractordetails::find_by_id($contractor_details->contractor_id);
    $data4=  Contractamountwithdrawdetails::find_by_plan_id($_GET['id']);
    
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>अन्तिम भुक्तानी सम्बन्धमा ।  print page:: <?php echo SITE_SUBHEADING;?></title>
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
</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             <div class="image-wrapper">
                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                    <div />
                    
                    <div class="image-wrapper">
                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                    <div />
                                    <div style="color:red">
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                    </div>
                                                <div class="myspacer"></div>
                                    <div class="subjectboldright letter_subject">टिप्पणी आदेश</div>
                                    </div>
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										
<div class="chalanino">योजना दर्ता नं :<?php echo convertedcit($_GET['id']);?></div>
										<div class="myspacer"></div>
										
										<div class="subject">   विषय:-अन्तिम भुक्तानी सम्बन्धमा ।</div>
										<div class="myspacer"></div>
										<div class="bankname">श्रीमान् 
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											  यस <?php echo SITE_LOCATION;?>को स्वीकृत वार्षिक कार्यक्रम  
                                                                                         अनुसार मिति <?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> मा यस 
                                                                                         कार्यलय र  <b><u> <?php echo $data3->contractor_name;?></u></b><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)-->
                                                                                         बिच संझौता भई यस गाँउपालिकाको वडा नं <?php echo convertedcit($data1->ward_no);?><!--(योजना संचालन हुने वडा नं)-->  
                                                                                         मा <b><u><?php echo $data1->program_name;?></u></b><!--(योजनाको नाम)--> योजना संचालनको कार्यदेश दिइएकोमा मिति <?php echo convertedcit($data5->evaluated_date);?><!--(योजनाको काम सम्पन्न भएको 
                                                                                         मिति)--> मा तोकिएको कार्य सम्पन्न गरिसकियेकोले विनियोजित रकम भुक्तानी पाउँ भनि सम्बन्धित निर्माण व्यावसायी/ कम्पनी/ फर्मबाट भुक्तानी माग भइ आएको छ| <br>
                                                                                        सो सम्बन्धमा प्राबिधिकबाट सम्बन्धित योजनाको स्थलगत निरिक्षण गरि पेश हुन आएको प्राबिधिक मुल्यांकन प्रतिबेदन, <?php echo SITE_TYPE;?> स्तरीय/ वडा स्तरीय अनुगमन समितिको प्रतिबेदन, सम्बन्धित वडा कार्यालयको सिफारिस, सम्पन्न योजनाको फोटो, कार्यालय प्रमुखको तोक आदेश लगायत निर्माण व्यवसायी/ कम्पनी/ फर्मबाट पेश हुन आएका अन्य संलग्न कागजातहरुको आधारमा खुद भुक्तानी दिनु पर्ने रकममा आय कर/ रिटेन्सन एमाउण्ट/ घर बहाल कर/ मु.अ. कर लगायत नियमानुसार कट्टी गर्नु पर्ने सम्पूर्ण करहरु कट्टी गरि बाँकी रकम मात्र भुक्तानी हुन निर्णयार्थ पेश गरिएको छ|
</div>
										
                                        
                                        	<div class="subject">तपशिल</div>
                                                <table class="table table-bordered myWidth100">
                                                    <tr>
                                                    <td class="myWidth50">बिनियोजन श्रोत र व्याख्या: </td>
                                                    <td> <?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myWidth50">योजनाको नाम / ठेक्का नं : </td>
                                                    <td> <?php echo $data1->program_name;?> / <?php echo convertedcit($contract_info->thekka_no);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myWidth50">योजना सम्पन्न हुने मिति : </td>
                                                    <td><?php echo convertedcit($data4->yojana_sakine_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myWidth50">योजनाको काम सम्पन्न भएको मिति : </td>
                                                    <td><?php echo convertedcit($data4->plan_end_date);?></td>
                                                </tr>
                                            	<tr>
                                                	<td class="myWidth50">योजनाको मुल्यांकन मिति : </td>
                                                    <td><?php echo convertedcit($data4->plan_evaluated_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजनाको सम्झौता रकम (भ्याट बाहेक) : </td>
                                                    <td>रु. <?php echo convertedcit($data4->remaining_payment_amount);?>/-</td>
                                                </tr>
                                                <?php $with_vat = $data4->remaining_payment_amount+($data4->remaining_payment_amount*13/100);?>
                                                <tr>
                                                	<td>योजनाको सम्झौता रकम (भ्याट सहित) : </td>
                                                    <td>रु. <?php echo convertedcit($with_vat);?>/-</td>
                                                </tr>
                                                <tr>
                                                	<td>योजनाको मुल्यांकन रकम (भ्याट बाहेक): </td>
                                                    <td>रु. <?php echo convertedcit($data4->plan_evaluated_amount);?>/-</td>
                                                </tr>
                                                <tr>
                                                	<td>योजनाको मुल्यांकन रकम (भ्याट सहित) : </td>
                                                    <td>रु. <?php echo convertedcit($data4->final_payable_amount);?>/-</td>
                                                </tr>
                                                <tr>
                                                	<td>भुक्तानी दिनु पर्ने कुल बाँकी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->remaining_payment_amount);?>/-</td>
                                                </tr>
                                                <?php if(!empty($data4->payment_till_now)){?>
                                                <tr>
                                                	<td>मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->payment_till_now);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <?php if(!empty($data4->advance_payment)){?>
                                                <tr>
                                                	<td>पेश्की भुक्तानी लगेको कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->advance_payment);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <?php if(!empty($data4->contingency)){?>
                                                <tr>
                                                    <td>कन्टिनजेन्सि कट्टी रकम </td>
                                                    <td>रु. <?php echo convertedcit($data4->contingency);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <?php if(!empty($data4->bipat)){?>
                                                <tr>
                                                    <td>विपत व्यवस्थापन कर कट्टी रकम</td>
                                                    <td>रु. <?php echo convertedcit($data4->bipat);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <?php if(!empty($data4->marmat)){?>
                                                <tr>
                                                    <td>मर्मत कट्टी रकम </td>
                                                    <td>रु. <?php echo convertedcit($data4->marmat);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <!-- change made-->
                                                <tr>
                                                    <td>मुल्य अभिवृद्धि कर कट्टी रकम (<?php echo convertedcit(13);?>%)</td>
                                                    <td>रु. <?php echo convertedcit($data4->vat_amt);?>/-</td>
                                                </tr>
                                                <?php if(!empty($data4->dharauti_per)){?>
                                                <tr>
                                                    <td style="color:red">धरौटी कर कट्टी रकम (<?php echo convertedcit($data4->dharauti_per);?>%)</td>
                                                    <td style="color:red">रु. <?php echo convertedcit($data4->dharauti);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <?php if(!empty($data4->agrim_kar_per)){?>
                                                <tr>
                                                    <td style="color:red">अग्रिम आय कर रकम (<?php echo convertedcit($data4->agrim_kar_per);?>%)</td>
                                                    <td style="color:red">रु. <?php echo convertedcit($data4->agrim_kar_amt);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <!--<tr>-->
                                                <!--    <td style="color:red">बहाल कर रकम (<?php echo convertedcit($data4->bahal_per);?>%)</td>-->
                                                <!--    <td style="color:red">रु. <?php echo convertedcit($data4->bahal_amt);?></td>-->
                                                <!--</tr>-->
                                                <!--<tr>-->
                                                <!--    <td style="color:red">पारिश्रमीक कर कट्टी रकम (<?php echo convertedcit($data4->paris_per);?>%)</td>-->
                                                <!--    <td style="color:red">रु. <?php echo convertedcit($data4->paris_amt);?></td>-->
                                                <!--</tr>-->
                                                <!--<tr>-->
                                                <!--    <td style="color:red">सामाजिक सुरक्षा कर रकम (<?php echo convertedcit($data4->samajik_per);?>%)</td>-->
                                                <!--    <td style="color:red">रु. <?php echo convertedcit($data4->samajik_amt);?></td>-->
                                                <!--</tr>-->
                                                <?php $mul = $data4->vat_amt*50/100;?>
                                                <tr>
                                                    <td style="color:red">मुल्य अभिवृद्धि कर कट्टी (६.५%)</td>
                                                    <td style="color:red">रु. <?php echo convertedcit($mul);?>/-</td>
                                                </tr>
                                                <tr>
                                                	<td>काम घटी बढी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->final_disaster_management_amount);?>/-</td>
                                                </tr>
                                                 <!-- change made-->
                                                <tr>
                                                	<td>जम्मा कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit(round($data4->final_total_amount_deducted,2));?>/-</td>
                                                </tr>
                                                <tr>
                                                	<td>हाल भुक्तानी दिनु पर्ने खुद रकम : </td>
                                                    <td> रु.<?php echo convertedcit($data4->final_total_paid_amount);?>/-</td>
                                                </tr>
                                                <tr>
                                                    <td>भुक्तानी भएको मिति : </td>
                                                    <td><?php echo convertedcit($data4->created_date);?></td>
                                                </tr>
                                            </table>
                                        </div>
										<div class="myspacer"></div>
										<div class="oursignature">सदर गर्ने <br>
                                                                                    <?php 
                                                                                        if(!empty($worker1))
                                                                                        {
                                                                                            echo $worker1->authority_name."<br/>";
                                                                                            echo $worker1->post_name;
                                                                                        }
                                                                                    ?>

                                                                                </div>
                                                                                 <div class="oursignature" style="margin-right:150px">लेखा शाखा <br/>
                                                                                    <?php 
                                                                                        if(!empty($worker3->authority_name))
                                                                                        {
                                                                                            echo $worker3->authority_name."<br/>";
                                                                                            echo $worker3->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
										<div class="oursignatureleft">पेस गर्ने<br>
                                                                                    <?php 
                                                                                        if(!empty($worker2))
                                                                                        {
                                                                                            echo $worker2->authority_name."<br/>";
                                                                                            echo $worker2->post_name;
                                                                                        }
                                                                                    ?>

                                                                                </div>
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->