<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in())
{
    redirect_to("logout.php");
}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
if(!isset($_GET['bank_id']) || empty($_GET['bank_id']))
{
    $bank_selected = Bankinformation::setEmptyObjects();
}
if(isset($_GET['bank_id']) && !empty($_GET['bank_id']))
{
    $bank_selected = Bankinformation::find_by_id($_GET['bank_id']);
}
$postnames = Postname::find_all();

$datas= Bankinformation::find_all();
$plan_selected = Plandetails1::find_by_id($_GET['id']);
$total_investment = Plantotalinvestment::find_by_plan_id($_GET['id']);
$topic_area = Topicarea::find_by_id($plan_selected->topic_area_id);
$topic_area_type = Topicareatype::find_by_id($plan_selected->topic_area_type_id);
$topic_area_type_sub = Topicareatype::find_by_id($plan_selected->topic_area_type_sub_id);
$topic_area_agreement = Topicareaagreement::find_by_id($plan_selected->topic_area_agreement_id);
$topic_area_investment = Topicareainvestment::find_by_id($plan_selected->topic_area_investment_id);
$more_details = Moreplandetails::find_by_plan_id($_GET['id']);

$upabhokta_selected = Costumerassociationdetails0::find_by_plan_id($_GET['id']); 
$upabhokta_members = Costumerassociationdetails::find_by_plan_id($_GET['id']);
$adaksya = Costumerassociationdetails::find_by_plan_id_post_id($_GET['id'], 1);
$sachib = Costumerassociationdetails::find_by_plan_id_post_id($_GET['id'], 3);
$kosadaksya = Costumerassociationdetails::find_by_plan_id_post_id($_GET['id'], 4);
//print_r($upabhokta_selected); exit;

?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>बैंक रेकोर्ड print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile"><?=$plan_selected->program_name?></h2>
                    <div class="OurContentLeft">
                   	  <?php include("menuincludes/lettersmenu.php"); ?>
                    </div>
                    <div class="OurContentRight">
                    	<h2>योजना संझौता कार्यादेश : </h2>
                        <div class="userprofiletable">
                            
                            
                            <div class="printPage">
                                    
									<h1><?php echo SITE_LOCATION;?></h1>
									<h4><?php echo SITE_HEADING;?> </h4>
									<h5>वयरवन,</h5>
									<div class="myspacer"></div>
									<div class="printContent">
                                                                            <div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?> </div>
										<div class="patrano">पत्र संख्या : </div>
										<div class="chalanino">चलानी नं :</div>
										<div class="subject">विषय:- योजना संझौता कार्यादेश ।</div>
										<div class="bankname">श्री <?=$bank_selected->name?></div>
										<div class="bankaddress"><?=$bank_selected->address?></div>
										<div class="banktextdetails">
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार तपशिलको विवरणमा उल्लेख बमोजिमको योजना संचालन गर्न
                                                                                        मिति ‍<?= convertedcit($more_details->miti)?> यस <?php echo SITE_TYPE;?> सँग भएको संझौता अनुसार योजनाको काम शुरु गर्न यो कार्यादेश
                                                                                        दिईएको छ । तोकिएको समयमा काम सम्पन्न गरी योजनाको प्राबिधिक मुल्यांकन गराइ उक्त योजनामा भएको
                                                                                        यथार्थ खर्चको विवरण उपभोक्ता समिति तथा अनुगमन समितिको बैठकबाट अनुमोदन गराइ खर्चको बिल,भरपाई,तथा
                                                                                        योजनाको फोटो सहित यस <?php echo SITE_TYPE;?>मा पेश गरी भुक्तानी लिनहुन जानकारी गराइन्छ ।</div>
                                                                                
                                                                                    <h4>तपशिल</h4> 
                                                                                    <table class="table table-bordered">
                                                                                        <tr>
                                                                                            <td>योजनाको नाम</td>
                                                                                            <td><?=$plan_selected->program_name?></td>
                                                                                        </tr>

                                                                                    
                                                                                        <tr>
                                                                                            <td>योजनाको ठेगाना</td>
                                                                                            <td><?=convertedcit($plan_selected->ward_no)?></td>
                                                                                        </tr>
                                                                                    
                                                                                        <tr>
                                                                                            <td>टोल बस्तीको नाम</td>
                                                                                            <td><?=$plan_selected->tole_name?></td>
                                                                                        </tr>
                                                                                    
                                                                                        <tr>
                                                                                            <td>योजनाको बिषयगत क्षेत्रको नाम</td>
                                                                                            <td><?=$topic_area->name?></td>
                                                                                        </tr>
                                                                                    
                                                                                        <tr>
                                                                                            <td>योजनाको शिर्षकगत नाम</td>
                                                                                            <td><?=$topic_area_type->topic_area_type?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>योजनाको उपशिर्षकगत नाम</td>
                                                                                            <td><?=$topic_area_type_sub->topic_area_type_sub?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>योजनाको अनुदानको किसिम</td>
                                                                                            <td><?=$topic_area_agreement->name?></td>
                                                                                        </tr>
                                                                                    
                                                                                        <tr>
                                                                                            <td>योजनाको विनियोजन किसिम</td>
                                                                                            <td><?=$topic_area_investment->name?></td>
                                                                                        </tr>
                                                                                    
                                                                                        <tr>
                                                                                            <td>योजनाको विनियोजन श्रोत</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                    
                                                                                        <tr>
                                                                                            <td><?php echo SITE_TYPE;?>बाट अनुदान रु</td>
                                                                                            <td><?=convertedcit($plan_selected->investment_amount)?></td>
                                                                                        </tr>

                                                                                    
                                                                                        <tr>
                                                                                            <td>अन्य निकायबाट प्राप्त अनुदान रु</td>
                                                                                            <td><?=convertedcit($total_investment->agreement_other)?></td>
                                                                                        </tr>

                                                                                    

                                                                                    <tr>
                                                                                            <td>उपभोक्ताबाट नगद साझेदारी रु</td>
                                                                                            <td><?=convertedcit($total_investment->costumer_agreement)?></td>
                                                                                        </tr>
                                                                                    

                                                                                    <tr>
                                                                                            <td>अन्य साझेदारी रु</td>
                                                                                            <td><?=convertedcit($total_investment->other_agreement)?></td>
                                                                                        </tr>

                                                                                    
                                                                                    <tr>
                                                                                            <td>उपभोक्ताबाट जनश्रमदान रु</td>
                                                                                            <td><?=convertedcit($total_investment->costumer_investment)?></td>
                                                                                        </tr>

                                                                                    
                                                                                    <tr>
                                                                                            <td>योजना शुरु हुने मिति</td>
                                                                                            <td><?=convertedcit($more_details->yojana_start_date)?></td>
                                                                                        </tr>

                                                                                    
                                                                                    <tr>
                                                                                            <td>योजना सम्पन्न हुने मिति</td>
                                                                                            <td><?=convertedcit($more_details->yojana_sakine_date)?></td>
                                                                                        </tr>

                                                                                    
                                                                                    <tr>
                                                                                            <td>कुल लागत अनुमान जम्मा रु</td>
                                                                                            <td><?=convertedcit($total_investment->total_investment)?></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <div>
                                                                                        <h4> सम्झौताका शर्तहरु</h4>
                                                                                        <ul>
                                                                                            
                                                                                       
                                                                                            <li>१ सम्झौतामा उल्लेख भएको म्याद भित्र उपभोक्ता समितिले योजना सम्पन्न गरिसक्नु पर्ने छ । कुनै कारणवश योजना सम्पन्न हुन नसकेमा सम्पन्न हुन नसक्नुको कारण सहित म्याद सकिने अबधि भन्दा ७ दिन अगाबै उपभोक्ता समितलिे सम्बन्धित स्थानिय तहमा निबेदन दिनु पर्नेछ ।निबेदन प्राप्त भएपछि औचित्यको आधारमा निर्णय गरी सम्झौताको म्याद थप गर्न सकिनेछ । यसरी म्याद थप नगरी भुक्तानी उपलब्ध हुने छैन ।</li>
                                                    <li>२ योजनाको भुक्तानी स्थानीय तहले प्राबिधिक रनिङ बिलको आधारमा किस्ताको रुपमा वा काम सम्पन्न भएपछि उपभोक्ता समितिले खर्चको विवरण मुल समिति र अनुगमन समितिको बैठक बसी  आम्दानी खर्च  सार्बजनिक गरी अनुमोदन गरेपछि मात्र  उपलब्ध गराइने छ ।</li>
                                                    <li>३ तोकिएको काम भन्दा कम काम गर्ने वा काम नै नगरी वा वास्तविक काम भन्दा बढी काम गरेको देखाई अथवा कुनै आइटमको सट्टा अर्को आइटमको कार्य पूरा गरेको देखाई लागत अनुमानभन्दा फरक काम गरी  रकम माग्ने उपभोक्ता समितिलाई उक्त रकम भुक्तानी नदिई कालो सूचीमा राखी  कारवाही गरिनेछ ।</li>
                                                    <li>४ योजना संग सम्बन्धित प्राप्त नगद⁄जिन्सी उपभोक्ता समितिले सम्बन्धित योजनामा मात्र खर्च गर्नु पर्नेछ र प्राप्त नगद⁄जिन्सीको दुरुपयोग, हिनामिना वा हानी नोक्सानी गरेमा प्रचलित कानुन बमोजिम कारवाही हुनेछ ।</li>
                                                    <li>५ उपभोक्ता समितिले काम सम्पन्न गरिसकेपछि बाँकि रहन गएका खप्ने सामानहरु मर्मत सम्भार समिति गठन भएको भए सो समितिलाई र सो नभए सम्बन्धित स्थानीय तहलाई बुझाउनु पर्नेछ । तर मर्मत सम्भार समितिलाई बुझाएको सामानको विवरणको एक प्रति सम्बन्धित <?php echo SITE_TYPE;?>मा बुझाउनु पर्नेछ ।</li>
                                                    <li>६ उपभोक्ता समितिले योजनासंग सम्बन्धित विल भर्पाइहरु, डोर हाजिरी फारामहरु, जिन्सी नगदी खाताहरु,समितिको निर्णय पुस्तिका आदि कागजात <?php echo SITE_TYPE;?> वा अन्य सरोकारवाला पदाधिकारीले मागेको बखत उपलब्ध गराउनु पर्ने छ र त्यसको लेखा परीक्षण पनि गराउन सकिनेछ ।</li>
                                                    <li>७ योजनाको सार्वजनिक परीक्षण, सुचना पाटी, आम्दानी खर्चको सार्वजनिकरण, तथा अन्य पारदर्शिता सम्बन्धी प्रावधानको पालना गर्नु पर्नेछ।</li>
                                                    <li>८ उपभोक्ता समितिले कार्यदेश लिएर लामो समय सम्म योजना संचालन नगर्ने, योजनाको आय व्ययको विवरण दुरुस्त नराखी रकमको दुरुपयोग गरेमा सरकारी बाँकि सरह असुल उपर गरिने छ ।</li>
                                                    <li>९ योजना सम्पन्न भएपछि स्थानीय तहबाट जाँच पास गरी फरफारकको प्रमाण पत्र लिनु पर्दछ ।साथै योजना हस्तान्तरण लिई आवश्यक मर्मत संभारको व्यवस्था सम्बन्धित उपभोक्ताहरुले नै गर्नु पर्नेछ।</li>
                                                                                     </ul>
                                                                                    </div>
                                                                                   <div>     
                                                                                </div>
										<div class="myspacer"></div>
										<div class="oursignature">&nbsp;</div>
										<div class="myspacer"></div>
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                            
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>