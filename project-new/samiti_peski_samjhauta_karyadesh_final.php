<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

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
}?>
     <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data2=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
$data5=Samitiplanstartingfund::find_by_plan_id($_GET['id']);    
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
	$ward_address=WardWiseAddress();
$address= getAddress();  
	?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>पेश्की संझौता कार्यादेश । print page:: <?php echo SITE_SUBHEADING;?></title>
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
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>                                    
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										<!--<div class="chalanino">चलानी नं :</div>-->
<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="myspacer20"></div>
										
										<div class="subject">   विषय:- योजना संझौता कार्यादेश |</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo $data3->program_organizer_group_name;?><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--><br/>
                                        <?php echo SITE_NAME.convertedcit($data3->program_organizer_group_address);?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम अनुसार  तपशिलको विवरणमा उल्लेख बमोजिमको योजना संचालन गर्न मिति ‍<?php echo convertedcit($data2->miti);?> यस <?php echo SITE_TYPE;?> सँग भएको संझौता अनुसार योजनाको काम शुरु गर्न यस कार्यालयको निर्णय अनुसार मिति <?php echo convertedcit($data5->advance_return_date);?><!--(पेश्की फर्छ्यौट गर्नु पर्ने मिति)--> भित्रमा पेश्की फर्छयौट गर्ने गरी उक्त योजना संचालनका लागी रु <?php echo convertedcit($data5->advance);?><!--पेश्की दिएको रकम)--> पेश्की उपलब्ध गराइको छ । तोकिएको समयमा काम सम्पन्न गरी योजनाको प्राबिधिक मुल्यांकन गराइ उक्त योजनामा भएको यथार्थ खर्चको विवरण संस्था / समिति तथा अनुगमन समितिको बैठकबाट अनुमोदन गराइ खर्चको बिल भरपाईतथा योजनाको  फोटो सहित यस <?php echo SITE_TYPE;?>मा पेश गरी भुक्तानी लिनहुन जानकारी गराइन्छ । 
						</div>				
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table-bordered myWidth100">
                                            	<tr>
                                                	<td class="myWidth50">योजनाको नाम : </td><td><?php echo $data1->program_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td>ठेगाना : </td><td><?php echo SITE_NAME. convertedcit($data1->ward_no);?></td>
                                                </tr>
                                                <tr>
                                                	<td>विषयगत क्षेत्र किसिम : </td><td><?php echo Topicareatype::getName($data1->topic_area_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td>शिर्षकगत किसिम : </td><td><?php echo Topicareatype::getName($data1->topic_area_type_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td>अनुदानको किसिम : </td><td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td>विनियोजन किसिम  : </td><td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td><?php echo SITE_TYPE;?>बाट अनुदान रकम  : </td><td>रु. <?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td>अन्य निकायबाट प्राप्त अनुदान रकम  : </td><td> रु. <?php echo convertedcit($data4->agreement_other);?></td>
                                                </tr>
                                                <tr>
                                                	<td>संस्था / समितिबाट नगद साझेदारी रकम  : </td><td> रु. <?php echo convertedcit($data4->costumer_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td>अन्य साझेदारी रकम  : </td><td>रु. <?php echo convertedcit($data4->other_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td>संस्था / समितिबाट जनश्रमदान रकम  : </td><td>रु. <?php echo convertedcit($data4->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td>कुल लागत अनुमान जम्मा रु : </td><td>रु. <?php echo convertedcit($data4->total_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजना शुरु हुने मिति : </td><td><?php echo convertedcit($data2->yojana_start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td>योजना सम्पन्न हुने मिति : </td><td><?php echo convertedcit($data2->yojana_sakine_date);?></td>
                                                </tr>
                                                

                                            </table>
                                            
                                        </div>
										<div class="myspacer30"></div>
                                    	
                                   <div class="oursignature">सदर गर्ने <br>
                                                                                        <?php 
                                                                                            if(!empty($worker1))
                                                                                            {
                                                                                                echo $worker1->authority_name."<br/>";
                                                                                                echo $worker1->post_name;
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
                                    <div class="myspacer"></div>
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->