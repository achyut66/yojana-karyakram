<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();
$data=  Contractbidfinal::find_by_status(1,$_GET['id']);
$contractor_details=  Contractordetails::find_by_id($data->contractor_id);
$contract_miti=  Contractinfo::find_by_plan_id($_GET['id']);
$data1=  Plandetails1::find_by_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता कार्यादेश । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">विषय:- योजना संझौता कार्यादेश |</h2>
                   
                    <div class="OurContentFull" >
                    	<h2>विषय:- योजना संझौता कार्यादेश । </h2> 
                      <div class="myPrint"><a href="print_bank_report_05_final.php" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
								<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
	                                <h4 class="marginright1 letter_title_two"><?php echo SITE_HEADING;?> </h4>
								    <h5 class="marginright1 letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                                    
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        <div class="myspacer20"></div>
										
										<div class="subject">विषय:- जानकारी सम्बन्धमा  |</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo $contractor_details->contractor_name;?><br/>
                                       <?php echo $contractor_details->contractor_address;?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम अनुसार देहायको योजना ठेक्का मार्फत संचालन गर्न मिति  <?php echo convertedcit($contract_miti->created_date);?> को सूचना अनुसार पेश  भएको बोलपत्र दर्ताहरुको बोलपत्र मध्ये तपाइँले पेश गरेको बोलपत्र स्वीकृत भएकाले ७ दिन भित्र सम्झौता गर्न आउनुहुन जानकारी गराईन्छ | 
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
                                                	<td>थप धरौटी जम्मा </td>
                                                    <td>रु.<?php echo convertedcit($data1->investment_amount);?></td>
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