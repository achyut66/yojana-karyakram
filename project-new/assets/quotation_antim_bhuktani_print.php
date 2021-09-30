<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$date_selected= $_GET['date_selected'];
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
     $investment_data = Plantotalinvestment::find_by_plan_id($_GET['id']);
    $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
    
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id);
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
$print_history->plan_id = $_GET['id'];
$print_history->worker1 = $_GET['worker1'];
$print_history->worker2 = $_GET['worker2'];
$print_history->worker3 = $_GET['worker3'];

$print_history->save();
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

        $katti_bibaran_payment = KattiDetails::find_by_plan_id_and_type($_GET['id'],2);
?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>अन्तिम भुक्तानी सम्बन्धमा ।  print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="printlogo"><img src="images/janani.png" alt="Logo"></div>
                                    	<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="marginright1 letter_title_two"><?php echo SITE_HEADING;?> </h4>
									<h5 class="marginright1 letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                                                <div class="myspacer"></div>
                                    <div class="subjectboldright letter_subject">टिप्पणी आदेश</div>
                                    </div>
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										
<div class="chalanino">योजना दर्ता नं :<?php echo convertedcit($_GET['id']);?></div>
<div class="chalanino"> चलानी नं . : </div>
										<div class="myspacer"></div>
										 
										<div class="subject">   विषय:-अन्तिम भुक्तानी सम्बन्धमा ।</div>
										<div class="myspacer"></div>
										<div class="bankname">श्रीमान् 
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस <?php echo SITE_LOCATION;?>को स्वीकृत वार्षिक  कार्यक्रम अनुसार मिति <?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> मा यस कार्यलय र  <b><u> <?php echo $data3->program_organizer_group_name;?></u></b><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--> बिच संझौता भई यस <?php echo SITE_TYPE;?>को वडा नं <?php echo convertedcit($data3->program_organizer_group_address);?><!--(योजना संचालन हुने वडा नं)-->  मा <b><u><?php echo $data1->program_name;?></u></b><!--(योजनाको नाम)-->
                                                                                        योजना संचालनको कार्यदेश दिइएकोमा मिति <?php echo convertedcit($data2->yojana_sakine_date);?><!--(योजनाको काम सम्पन्न भएको मिति)--> मा तोकिएको कार्य सम्पन्न गरिसकिएकोले उपभोक्ता
                                                                                        समितिको मिति <?php echo convertedcit($data4->upabhokta_aproved_date);?><!--(उपभोक्ता समितिको बैठक बसी खर्च स्वीकृत गरेको मिति)--> मा बसेको बैठकबाट उक्त योजनाको आम्दानी तथा खर्चको अनुमोदन गरि सार्बजनिक 
                                                                                       परिक्षण समेत गरिसकेको र अनुगमन समितको मिति <?php echo convertedcit($data4->expenditure_approved_date);?><!--(अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति)--> मा बैठक 
                                                                                        बसी योजनाको अन्तिम भुक्तानीको लागि सिफारिस गरिसकेको हुँदा विनियोजित रकम भुक्तानी पाउँ भनि उपभोक्ता समिति बाट भुक्तानी माग भई आएको छ|<br>
                                                                                        सो सम्बन्धमा प्राबिधिकबाट सम्बन्धित योजनाको स्थलगत निरिक्षण गरि पेश हुन आएको प्राबिधिक मुल्यांकन प्रतिबेदन, <?php echo SITE_TYPE;?> स्तरीय/ वडा स्तरीय अनुगमन समितिको प्रतिबेदन, सम्बन्धित वडा कार्यालयको सिफारिस, सम्पन्न योजनाको फोटो, कार्यालय प्रमुखको तोक आदेश लगायत उपभोक्ता समिति बाट पेश हुन आएको अन्य संलग्न कागजातहरुको आधारमा खुद भुक्तानि दिनु पर्ने रकममा आय कर/ घर बहाल कर/ मु.अ. कर लगायत नियमानुसार कट्टी गर्नु पर्ने सम्पूर्ण करहरु कट्टी गरि बाँकि रकम मात्र भुक्तानी हुन निर्णयार्थ पेश गरिएको छ| 
</div>
										
                                        
                                        	<div class="subject">तपशिल</div>
                                                 <?php   $datas=Plantotalinvestment::find_by_plan_id($_GET['id']);
                    $add=$datas->agreement_gauplaika+$datas->agreement_other+$datas->costumer_agreement+$datas->other_agreement;?>
                                            <table class="table table-bordered  myWidth100">
                                            	<tr>
                                                    <td class="myWidth50 myTextalignRight">बिनियोजन श्रोत र व्याख्या: </td>
                                                    <td> <?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">योजनाको कुल अनुदान रकम : </td>
                                                    <td>रु. <?php echo convertedcit($add);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignRight">योजनाको कुल लागत अनुमान : </td>
                                                    <td> <?php echo convertedcit($investment_data->total_investment);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignRight">कार्यदेश दिएको रकम: </td>
                                                    <td> <?php echo convertedcit($investment_data->bhuktani_anudan);?></td>
                                                </tr>
                                            	<tr>
                                                	<td class="myTextalignRight">योजनाको मुल्यांकन मिति : </td>
                                                    <td><?php echo convertedcit($data4->plan_evaluated_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">योजनाको मुल्यांकन रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->plan_evaluated_amount);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td class="myTextalignRight">मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->payment_till_now);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">पेश्की भुक्तानी लगेको कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->advance_payment);?></td>
                                                </tr>
                                                <tr style="display:none;">
                                                	<td class="myTextalignRight">भुक्तानी दिनु पर्ने कुल बाँकी  रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->remaining_payment_amount);?></td>
                                                </tr>
                                                <!-- change made-->
                                                <tr>
                                                    <td class="myTextalignRight">भुक्तानी घटी कट्टी रकम</td>
                                                    <td><?=convertedcit(placeholder($data4->final_bhuktani_ghati_amount))?></td>
                                                </tr>
                                                <tr>
                                                    
                                                	<td class="myTextalignRight">कन्टेन्जेन्सी  कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->final_contengency_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">मर्मत सम्हार कोष कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->final_renovate_amount);?></td>
                                                </tr>
                                               <?php foreach($katti_bibaran_payment as $sa):?>
                                                    <tr><td  class="myTextalignRight"><?=  KattiWiwarn::getName($sa->katti_id)?></td>
                                                        <td><?= convertedcit($sa->katti_amount+0)?></td></tr>
                                                     <?php endforeach;?>
                                                 <!-- change made-->
                                                <tr>
                                                	<td class="myTextalignRight">जम्मा कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->final_total_amount_deducted);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">हाल भुक्तानी दिनु पर्ने खुद रकम : </td>
                                                    <td> रु.<?php echo convertedcit($data4->final_total_paid_amount);?></td>
                                                </tr>
                                                

                                            </table>
                                   </div>
										
									<div class="myspacer20"></div>

                                                                        <div class="oursignature">सदर गर्ने <br/>
                                                                        
                                                                            <?php 
                                                                                if(!empty($worker1))
                                                                                {
                                                                                    echo $worker1->authority_name."<br/>";
                                                                                    echo $worker1->post_name;
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                        <div class="oursignature" style="margin-right:150px">योजना शाखा <br/>
                                                                                    <?php 
                                                                                        if(!empty($worker3))
                                                                                        {
                                                                                            echo $worker3->authority_name."<br/>";
                                                                                            echo $worker3->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
										<div class="oursignatureleft">पेस गर्ने<br/>
                                                                                    <?php 
                                                                                        if(!empty($worker2))
                                                                                        {
                                                                                            echo $worker2->authority_name."<br/>";
                                                                                            echo $worker2->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
										<div class="myspacer"></div>

									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->