<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();
$base_url = get_base_url(1);
$print_date = PrintDetails::get_max_date($base_url,$_GET['id']);
$max_date   = DateEngToNep($print_date);
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $result = Plantotalinvestment::find_by_plan_id($_GET['id']);
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
    $link = get_return_url($_GET['id']);
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
                    <h2 class="headinguserprofile">विषय:- योजना संझौता कार्यादेश | <a href="<?=$link?>" class="btn">पछि जानुहोस </a></h2>
                    
                    <div class="OurContentFull" >
                    	<form method="get" action="print_bank_report_05_final.php?>" target="_blank" >
                            <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
									<h5 class="margin1em letter_title_three"><?php echo $ward_address;?></h5>
                                    
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($print_date)){echo $max_date;
                                                                                                    }else{ echo generateCurrDate();}?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        
										
										<div class="subject">विषय:- योजना संझौता कार्यादेश |</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo $data3->program_organizer_group_name;?><br/>
                                       <?php echo SITE_NAME.convertedcit($data3->program_organizer_group_address);?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम अनुसार  तपशिलको विवरणमा उल्लेख बमोजिमको योजना संचालन गर्न मिति ‍<?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> यस <?php echo SITE_TYPE;?>सँग भएको संझौता अनुसार योजनाको काम शुरु गर्न यो कार्यादेश दिईएको छ । तोकिएको समयमा काम सम्पन्न गरी योजनाको प्राबिधिक मुल्यांकन गराइ उक्त योजनामा भएको यथार्थ खर्चको विवरण उपभोक्ता समिति तथा अनुगमन समितिको बैठकबाट अनुमोदन गराइ खर्चको बिल भरपाईतथा योजनाको  फोटो सहित यस <?php echo SITE_TYPE;?>मा पेश गरी भुक्तानी लिनहुन जानकारी गराइन्छ । 
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table table-bordered table-responsive myWidth100">
                                            	<tr>
                                                	<td class="myWidth50 myTextalignRight">योजनाको नाम : </td>
                                                    <td><?php echo $data1->program_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">ठेगाना : </td>
                                                    <td><?php echo SITE_NAME. convertedcit($data1->ward_no);?></td>
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
                                                	<td class="myTextalignRight">अनुदानको किसिम : </td>
                                                    <td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">विनियोजन किसिम : </td>
                                                    <td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td class="myTextalignRight"><?php echo SITE_TYPE;?>बाट अनुदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">अन्य निकायबाट प्राप्त अनुदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->agreement_other);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight"><?=$name?> नगद साझेदारी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->costumer_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">अन्य साझेदारी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->other_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight"><?=$name?> जनश्रमदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">कुल लागत अनुमान जम्मा रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->total_investment);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignRight">कार्यदेश दिएको  रकम</td>
                                                    <td>रु.<?php echo convertedcit($data4->bhuktani_anudan);?></td>
                                                  </tr>
                                                <tr>
                                                	<td class="myTextalignRight">योजना शुरु हुने मिति : </td>
                                                    <td><?php echo convertedcit($data2->yojana_start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">योजना सम्पन्न हुने मिति : </td>
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