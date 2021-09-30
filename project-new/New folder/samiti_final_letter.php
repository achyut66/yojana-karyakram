<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$base_url = get_base_url(1);
$max_date   = DateEngToNep(PrintDetails::get_max_date($base_url,$_GET['id']));
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $investment_data = Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
    $data2=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
    
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>रकम भुक्तानी सम्बन्धमा ।  print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">विषय:- अन्तिम रकम भुक्तानी सम्बन्धमा   ।  <a class="btn" href="samiti_letters_select.php"> पछी  जानुहोस </a></h2>
                  
                   
                    <div class="OurContentFull" >
                    	<h2>विषय:- रकम भुक्तानी सम्बन्धमा ।</h2> 
                        <div class="myPrint">  <a href="print_details_view.php?id=<?=$_GET['id']?>&page=<?=$base_url?>" class="btn" target="_blank">प्रिन्ट विवरण</a>&nbsp;</div><br/><br/>
                        <form method="get" action="samiti_final_letter_final.php?id=<?=$_GET['id']?>" target="_blank" >
                        <?php if(!empty($max_date)){?>
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" onclick="return confirm('के तपाई मिति सच्याउन चाहनुहुन्छ?');" name="submit" /></div>
                        <?php }else{?>
                         <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <?php }?>
                         <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                                       <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
	
<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
									
<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>>
                                    <div class="subjectbold letter_subject">टिप्पणी आदेश</div>
                                    </div>
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($max_date)){echo $max_date;
                                                                                                    }else{ echo generateCurrDate();}?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										
<div class="chalanino">योजना दर्ता नं :<?php echo convertedcit($_GET['id']);?></div>
										<div class="myspacer20"></div>
										
										<div class="subject letter_subject">   विषय:- अन्तिम किस्ता रकम भुक्तानी सम्बन्धमा ।</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्रीमान् 
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत वार्षिक  कार्यक्रम अनुसार मिति <?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> मा यस कार्यलय र   <b><u><?php echo $data3->program_organizer_group_name;?></u></b><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--> बिच संझौता भई यस <?php echo SITE_TYPE;?>को वडा नं <?php echo convertedcit($data3->program_organizer_group_address);?><!--(योजना संचालन हुने वडा नं)-->  मा <?php echo $data1->program_name;?><!--(योजनाको नाम)-->
                                                                                        योजना संचालनको कार्यदेश दिइएकोमा मिति <?php echo convertedcit($data2->yojana_sakine_date);?><!--(योजनाको काम सम्पन्न भएको मिति)--> मा तोकिएको काम सम्पन्न गरी संस्था / समितिको मिति <?php echo convertedcit($data4->upabhokta_aproved_date);?><!--(उपभोक्ता समितिको बैठक बसी खर्च स्वीकृत गरेको मिति)--> मा बैठक बसी आम्दानी खर्च अनुमोदन तथा सार्बजनिक 
                                                                                        गरी सार्बजनिक परिक्षण समेत गरेको र अनुगमन समितको मिति <?php echo convertedcit($data4->expenditure_approved_date);?><!--(अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति)--> मा बैठक 
                                                                                        बसी योजनाको अन्तिम भुक्तानीको लागि सिफारिस गरेको र संस्था / समितिले योजनाको बिल भरपाई प्राबिधिक मुल्यांकन तथा योजनाको
                                                                                        फोटोसहित यस <?php echo SITE_TYPE;?>मा पेश गरी उक्त योजनाको भुक्तानीका लागि माग भई आएकाले तपशिल अनुसारको रकम भुक्तानी दिन मनासिब 
                                                                                        देखिएकाले श्रीमान् समक्ष निणयार्थ यो टिप्पणी पेश गरको छु । 
</div>
										
                                        
                                        	<div class="subject">तपशिल</div>
                                             <?php   $datas=Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
                    $add=$datas->agreement_gauplaika+$datas->agreement_other+$datas->costumer_agreement+$datas->other_agreement;?>
                                            <table class="table table-bordered table-responsive myWidth100">
                                            	<tr>
                                                    <td class="myWidth50">गाउँसभाको बिनियोजीत सि.न० : </td>
                                                    <td> <?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजनाको कुल अनुदान रकम : </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($add));?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myWidth50">योजनाको कुल लागत अनुमान : </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($investment_data->total_investment));?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myWidth50">कार्यदेश दिएको रकम: </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($investment_data->bhuktani_anudan));?></td>
                                                </tr>
                                            	<tr>
                                                	<td class="myWidth50">योजनाको मुल्यांकन मिति : </td>
                                                    <td><?php echo convertedcit($data4->plan_evaluated_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजनाको मुल्यांकन रकम : </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($data4->plan_evaluated_amount));?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td>मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम : </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($data4->payment_till_now));?></td>
                                                </tr>
                                                <tr>
                                                	<td>पेश्की भुक्तानी लगेको कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($data4->advance_payment));?></td>
                                                </tr>
                                                <tr>
                                                	<td>भुक्तानी दिनु पर्ने कुल बाँकी  रकम : </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($data4->remaining_payment_amount));?></td>
                                                </tr>
                                                <!-- change made-->
                                                 <tr>
                                                    <td>भुक्तानी घटी कट्टी रकम</td>
                                                    <td><?=convertedcit(placeholder($data4->final_bhuktani_ghati_amount))?></td>
                                                </tr>
                                                <tr>
                                                    
                                                	<td>कन्टेन्जेन्सी  कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->final_contengency_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td>मर्मत सम्हार कोष कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->final_renovate_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td>धरौटी कट्टी रकम : </td>
                                                    <td> रु. <?php echo convertedcit($data4->final_due_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td>विपद व्यबसथापन कोष कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit($data4->final_disaster_management_amount);?></td>
                                                </tr>
                                                 <!-- change made-->
                                                <tr>
                                                	<td>जम्मा कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($data4->final_total_amount_deducted));?></td>
                                                </tr>
                                                <tr>
                                                	<td>हाल भुक्तानी दिनु पर्ने खुद रकम : </td>
                                                    <td> रु.<?php echo convertedcit(placeholder($data4->final_total_paid_amount));?></td>
                                                </tr>
                                                

                                            </table>
                                        </div>
										
										<div class="myspacer20"></div>
										<div class="oursignature">
सदर गर्ने </div>
										<div class="oursignatureleft">पेस गर्ने </div>
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