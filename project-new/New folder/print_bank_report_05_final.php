<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();
$date_selected= $_GET['date_selected'];
$base_url = get_base_url();
$plan_id  = $_GET['id'];
$user     = getUser();
$max_count = PrintDetails::find_max_counter($base_url,$plan_id);
$print_details  = new PrintDetails;
$print_details->url  = $base_url;
$print_details->plan_id = $plan_id;
$print_details->user_id = $user->id;
$print_details->nepali_date = $_GET['date_selected'];
$print_details->english_date = DateNepToEng($_GET['date_selected']);
$print_details->counter       = $max_count + 1;
$print_details->save();
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
     if(!empty($result))
        {
            $data4=  Plantotalinvestment::find_by_plan_id($_GET['id']);
            $data2= Moreplandetails::find_by_plan_id($_GET['id']);
             $name = "उपभोक्ताबाट";
             
        }
        else
        {
            $data4= AmanatLagat::find_by_plan_id($_GET['id']);
            $data2= Amanat_more_details::find_by_plan_id($_GET['id']);
             $name = "";
             
        }
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $fiscal = FiscalYear::find_by_id($data1->fiscal_id); ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>योजना संझौता कार्यादेश । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    	<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="marginright1 letter_title_two"><?php echo $address;?></h4>
									<h5 class="marginright1 letter_title_three"><?php echo $ward_address;?></h5>
                                   
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										 <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino">चलानी नं: </div>
                                                                                 
										
										<div class="subject">   विषय:- योजना संझौता कार्यादेश |</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo $data3->program_organizer_group_name ;?><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)-->
                                       <?php echo SITE_NAME.convertedcit($data3->program_organizer_group_address);?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails "  >
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार  तपशिलको विवरणमा उल्लेख बमोजिमको योजना संचालन गर्न मिति ‍<?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> यस <?php echo SITE_TYPE;?>सँग भएको संझौता अनुसार योजनाको काम शुरु गर्न यो कार्यादेश दिईएको छ । तोकिएको समयमा काम सम्पन्न गरी योजनाको प्राबिधिक मुल्यांकन गराइ उक्त योजनामा भएको यथार्थ खर्चको विवरण उपभोक्ता समिति तथा अनुगमन समितिको बैठकबाट अनुमोदन गराइ खर्चको बिल भरपाईतथा योजनाको  फोटो सहित यस <?php echo SITE_TYPE;?>मा पेश गरी भुक्तानी लिनहुन जानकारी गराइन्छ ।
</div> 
										
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table-bordered myWidth100">
                                            	<tr>
                                                	<td class="myWidth50 myTextalignRight">योजनाको नाम : </td><td> <?php echo $data1->program_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">ठेगाना : </td><td><?php echo SITE_NAME. convertedcit($data1->ward_no);?></td>
                                                </tr>
                                               <tr>
                                                <td class="myTextalignRight">योजनाको बिषयगत क्षेत्रको नाम</td>
                                                <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td class="myTextalignRight">योजनाको  शिर्षकगत नाम</td>
                                               <td><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td class="myTextalignRight">योजनाको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($data1->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                         
                                                <tr>
                                                	<td  class="myTextalignRight">अनुदानको किसिम : </td><td> <?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">विनियोजन किसिम : </td><td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td  class="myTextalignRight"><?php echo SITE_TYPE;?>बाट अनुदान रु : </td><td>रु.<?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">अन्य निकायबाट प्राप्त अनुदान रु : </td><td> रु.<?php echo convertedcit($data4->agreement_other);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight"><?=$name?> नगद साझेदारी रु : </td><td> रु.<?php echo convertedcit($data4->costumer_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight" >अन्य साझेदारी रु : </td><td> रु.<?php echo convertedcit($data4->other_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight" ><?=$name?> जनश्रमदान रु : </td><td> रु.<?php echo convertedcit($data4->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">कुल लागत अनुमान जम्मा रु : </td><td> रु.<?php echo convertedcit($data4->total_investment);?></td>
                                                </tr>
                                                 <tr>
                                                    <td class="myTextalignRight">कार्यदेश दिएको  रकम</td>
                                                    <td>रु.<?php echo convertedcit($data4->bhuktani_anudan);?></td>
                                                  </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">योजना शुरु हुने मिति : </td><td> <?php echo convertedcit($data2->yojana_start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight" >योजना सम्पन्न हुने मिति : </td><td> <?php echo convertedcit($data2->yojana_sakine_date);?></td>
                                                </tr>
                                                

                                            </table>
                                        </div>
										
										<div class="myspacer30"></div>
										
									
										<div class="oursignature mymarginright"> सदर गर्ने </div>
										<div class="oursignatureleft mymarginright">तयार गर्ने  </div>
                                        <div class="oursignatureleft mymarginright"> पेश गर्ने  </div>
                                        <div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने       </div>
										<div class="myspacer"></div>


									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->