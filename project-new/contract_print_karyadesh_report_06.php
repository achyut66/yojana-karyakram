<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data2= Contractmoredetails::find_by_plan_id($_GET['id']);
    $investment_data = Contract_total_investment::find_by_plan_id($_GET['id']);
    $contractor_details=  Contractentryfinal::find_by_status(1,$_GET['id']);
    $data3= Contractordetails::find_by_id($contractor_details->contractor_id);
    $fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
    $data4= Contractanalysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
    $data5=  Contractanalysisbasedwithdraw::find_by_max($data4,$_GET['id']);
    $workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
}
else
{
    $print_history = PrintHistory::setEmptyObject();
    if(empty($worker1))
    {
        $worker1 = Workerdetails::setEmptyObject();
    }
    if(empty($worker2))
    {
        $worker2 = Workerdetails::setEmptyObject();
    }
    
}
$ward_address=WardWiseAddress();
$address= getAddress();
    ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>मुल्यांकनको आधारमा भुक्तानीको टिप्पणी । print page:: <?php echo SITE_SUBHEADING;?></title>
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
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                
                <div class="maincontent" >
                    <form method="get" action="contract_print_karyadesh_report_06_final.php?>">
                    <h2 class="headinguserprofile">विषय:- मुल्यांकनको आधारमा रकम भुक्तानी सम्बन्धमा | <a class="btn" href="contract_letter_dashboard.php"> पछी  जानुहोस </a></h2>
                   
                    <div class="OurContentFull" >
                    	<h2>विषय:- रकम भुक्तानी सम्बन्धमा । 
                    		<div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट" name="submit" /></div></h2>
                        
                        <!--<div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>-->
                      <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                    </div>
									<div class="myspacer"></div>
									<div class="subjectbold letter_subject">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate">मिति : <input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="myspacer20"></div>
										
										<div class="subject"> <u> विषय:- मुल्यांकनको आधारमा रकम भुक्तानी सम्बन्धमा ।</u></div>
										<div class="myspacer20"></div>
										<div class="bankname">श्रीमान् </div>
                                                                               
										<div class="banktextdetails"  >
											 यस <?php echo SITE_LOCATION;?>को स्वीकृत वार्षिक कार्यक्रम  
                                                                                         अनुसार मिति <?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> मा यस 
                                                                                         कार्यलय र  <b><u> <?php echo $data3->contractor_name;?></u></b><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)-->
                                                                                         बिच संझौता भई यस गाँउपालिकाको वडा नं <?php echo convertedcit($data1->ward_no);?><!--(योजना संचालन हुने वडा नं)-->  
                                                                                         मा <b><u><?php echo $data1->program_name;?></u></b><!--(योजनाको नाम)--> योजना संचालनको कार्यदेश दिइएकोमा मिति <?php echo convertedcit($data5->evaluated_date);?><!--(योजनाको काम सम्पन्न भएको 
                                                                                         मिति)--> मा प्राबिधिक मुल्याकन गरि नियमानुसारको रकम भुक्तानी गर्न प्राबिधिकबाट प्रतिबेदन पेश हुन आएको हुँदा उक्त प्राबिधिक प्रतिबेदन, कार्यालय प्रमुखको तोक आदेश, सम्बन्धित निर्माण ब्यवसायी/ कम्पनि/ फर्मको रकम भुक्तानीको माग निबेदन एबं अन्य संलग्न कागजातहरुको आधारमा खुद भुक्तानी दिनु पर्ने रकममा आय कर/ रिटेन्सन एमाउण्ट/ घर बहाल कर/ मु.अ. कर लगायत नियमानुसार कट्टी गर्नु पर्ने सम्पूर्ण करहरु कट्टी गरि बाँकी रकम मात्र भुक्तानी हुन निर्णयार्थ पेश गरिएको छ|   
                                        </div>                          
                                        	<div class="subject">तपशिल</div>
                                            <table class="table-bordered myWidth100">
                                               
                                                        <?php 
                                                        if($data5->payment_evaluation_count==1)
                                                        {
                                                            $period="पहिलो";
                                                        }
                                                        if($data5->payment_evaluation_count==2)
                                                        {
                                                            $period="दोस्रो";
                                                        }
                                                        if($data5->payment_evaluation_count==3)
                                                        {
                                                            $period="तेस्रो";
                                                        }
                                                         if($data5->payment_evaluation_count==4)
                                                        {
                                                            $period="चौथो";
                                                        }
                                                         if($data5->payment_evaluation_count==5)
                                                        {
                                                            $period="पाचौ";
                                                        }
                                                         if($data5->payment_evaluation_count==5)
                                                        {
                                                            $period="छैठो";
                                                        }
                                                    ?>
                                                    <?php $vat_with = $data5->evaluated_amount + ($data5->evaluated_amount*13/100);?>
                                               <tr>
                                                    <td class="myWidth50">बिनियोजन श्रोत र व्याख्या: </td>
                                                    <td> <?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myWidth50">अनुदानको किसिम / बिषयगत क्षेत्र : </td>
                                                    <td> <?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?> / <?php echo Topicarea::getName($data1->topic_area_id);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myWidth50">कार्यदेश दिएको रकम: </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($investment_data->bhuktani_anudan));?>/-</td>
                                                </tr>
                                            	<tr>
                                                    <td class="myWidth50">योजनाको मुल्यांकन किसिम : </td>
                                                    <td> <?php echo $period;?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजनाको मुल्यांकन मिति : </td>
                                                    <td><?php echo convertedcit($data5->evaluated_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजनाको मुल्यांकन रकम(भ्याट सहित) : </td>
                                                    <td>रु. <?php echo convertedcit($vat_with);?>/-</td>
                                                </tr>
                                                <tr>
                                                	<td>योजनाको मुल्यांकन रकम(भ्याट बाहेक ) : </td>
                                                    <td>रु.<?php echo convertedcit($data5->evaluated_amount);?>/-</td>
                                                </tr>
                                                <?php if(!empty($data5->contingency)){?>
                                                <tr>
                                                	<td>कन्टिनजेन्सि कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->contingency);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <?php if(!empty($data5->bipat)){?>
                                                <tr>
                                                	<td>विपत व्यवस्थापन कर कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->bipat);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <?php if(!empty($data5->marmat)){?>
                                                <tr>
                                                	<td>मर्मत कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->marmat);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <tr>
                                                	<td>मुल्य अभिवृद्धि कर रकम (<?php echo convertedcit(13);?>% ) : </td>
                                                    <td>रु.<?php echo convertedcit($data5->vat_amt);?>/-</td>
                                                </tr>
                                                <?php if(!empty($data5->dharauti_per)){?>
                                                <tr>
                                                	<td>धरौटी कर कट्टी रकम (<?php echo convertedcit($data5->dharauti_per);?>% ) : </td>
                                                    <td>रु.<?php echo convertedcit($data5->dharauti);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <tr>
                                                	<td>मूल्य अभिव्रिधि कर (६.५%) : </td>
                                                    <td>रु.<?php echo convertedcit($data5->vat_per);?>/-</td>
                                                </tr>
                                                <?php if(!empty($data5->agrim_kar_per)){?>
                                                <tr>
                                                	<td>अग्रिम आय कर रकम (<?php echo convertedcit($data5->agrim_kar_per);?>% ) : </td>
                                                    <td>रु.<?php echo convertedcit($data5->agrim_kar_amt);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <!--<tr>-->
                                                <!--	<td>बहाल कर रकम (<?php echo convertedcit($data5->bahal_per);?>% ) : </td>-->
                                                <!--    <td>रु.<?php echo convertedcit($data5->bahal_amt);?></td>-->
                                                <!--</tr>-->
                                                <!--<tr>-->
                                                <!--	<td>पारिश्रमीक कर कट्टी रकम (<?php echo convertedcit($data5->paris_per);?>% ) : </td>-->
                                                <!--    <td>रु.<?php echo convertedcit($data5->paris_amt);?></td>-->
                                                <!--</tr>-->
                                                <!--<tr>-->
                                                <!--	<td>सामाजिक सुरक्षा कर रकम (<?php echo convertedcit($data5->samajik_per);?>% ) : </td>-->
                                                <!--    <td>रु.<?php echo convertedcit($data5->samajik_amt);?></td>-->
                                                <!--</tr>-->
                                                <?php if(!empty($data5->advance_payment)){?>
                                                <tr>
                                                	<td>पेश्की भुक्तानी लगेको कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->advance_payment);?>/-</td>
                                                </tr>
                                                <?php }else{?>
                                                <?php }?>
                                                <tr>
                                                	<td>जम्मा कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit(placeholder($data5->total_amount_deducted));?>/-</td>
                                                </tr>
                                                <tr>
                                                	<td>हाल भुक्तानी दिनु पर्ने खुद रकम : </td>
                                                    <td>रु.<?php echo convertedcit(placeholder($data5->total_paid_amount));?>/-</td>
                                                </tr>
                                                <tr>
                                                	<td>निर्माण ब्याबसायी फर्मको विवरण : </td>
                                                    <td><?php echo $data3->contractor_name;?>,<?php echo $data3->contractor_address;?>-<?php echo convertedcit($data3->contractor_contact);?></td>
                                                </tr>
                                            </table>
                                        </div>
										
										
<div class="myspacer20"></div>
                                                    				<div class="oursignature">सदर गर्ने <br> 
                                                                                    <select name="worker1" class="form-control worker" id="worker_1" required >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                                                </div>
                                                                                  <div class="oursignature" style="margin-right: 200px;">लेखा शाखा<br/>
                                                                                    <select name="worker3" class="form-control worker" id="worker_3" required >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker3 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_3" value="<?=$worker3->post_name?>">
                                                                                </div>
										<div class="oursignatureleft">पेस गर्ने <br/>
                                                                                    <select name="worker2" class="form-control worker" id="worker_2" required >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                                                                                </div>
										<div class="myspacer"></div>
									</div>
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>