<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$base_url = get_base_url(1);
$print_date = PrintDetails::get_max_date($base_url,$_GET['id']);
$max_date   = DateEngToNep($print_date);
$ward_address=WardWiseAddress();
$address= getAddress();
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data2=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता कार्यादेश । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">विषय:- सिफारिस सम्बन्धमा | <a class="btn" href="dashboard_samiti_bhuktani.php"> पछी  जानुहोस </a></h2>
                   
                   
                    <div class="OurContentFull" >
                    	<h2>विषय:- सिफारिस सम्बन्धमा । </h2> 
                      <form method="get" action="samiti_print_bank_report_13_final.php?id=<?=$_GET['id']?>" target="_blank" >
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
	
<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
									
<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                                    
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($print_date)){echo $max_date;
                                                                                                    }else{ echo generateCurrDate();}?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        <div class="myspacer20"></div>
										
										<div class="subject">विषय:- सिफारिस सम्बन्धमा |</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo SITE_LOCATION;?><br/>
                                       <?php echo SITE_ADDRESS;?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											उपरोक्त बिषयमा श्री <b><u> <?php echo $data3->program_organizer_group_name;?></u></b>ले यस वडा कार्यालयमा <b><u><?php echo $data1->program_name;?></u></b> योजना   आंशिक काम सम्पन्न भएकाले  मुल्यांकनको आधारमा भुक्तानीको लागि सिफारिस पाऊं भनि दिएको निबेदन अनुसार यस वडा कार्यालयबाट ऊक्त योजनाको स्थल गत निरीक्षण गर्दा योजनाको  आंशिक काम सम्पन्न  भएको देखिएकोले नियम अनुसार प्राविधिक मुल्यांकनको आधारमा  भुक्तानी  दिनुहुन अनुरोध छ |
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table table-bordered table-responsive myWidth100">
                                            	<tr>
                                                	<td class="myWidth50">योजनाको नाम : </td>
                                                    <td><?php echo $data1->program_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td>ठेगाना : </td>
                                                    <td><?php echo SITE_NAME. convertedcit($data1->ward_no);?></td>
                                                </tr>
                                                <tr>
                                                <td>योजनाको बिषयगत क्षेत्रको नाम</td>
                                                <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>योजनाको  शिर्षकगत नाम</td>
                                               <td><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>योजनाको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($data1->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                         
                                                <tr>
                                                	<td>अनुदानको किसिम : </td>
                                                    <td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td>विनियोजन किसिम : </td>
                                                    <td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td><?php echo SITE_TYPE;?>बाट अनुदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td>अन्य निकायबाट प्राप्त अनुदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->agreement_other);?></td>
                                                </tr>
                                                <tr>
                                                	<td>संस्था / समितिबाट नगद साझेदारी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->costumer_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td>अन्य साझेदारी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->other_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td>संस्था / समितिबाट जनश्रमदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td>कुल लागत अनुमान जम्मा रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->total_investment);?></td>
                                                </tr>
                                                <tr>
                                                    <td>कार्यदेश दिएको  रकम</td>
                                                    <td>रु.<?php echo convertedcit($data4->bhuktani_anudan);?></td>
                                                  </tr>
                                                <tr>
                                                	<td>योजना शुरु हुने मिति : </td>
                                                    <td><?php echo convertedcit($data2->yojana_start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजना सम्पन्न हुने मिति : </td>
                                                    <td><?php echo convertedcit($data2->yojana_sakine_date);?></td>
                                                </tr>
                                                

                                            </table>
                                        </div>
										
										<div class="myspacer"></div>
									</div>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>