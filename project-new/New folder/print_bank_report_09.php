<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$base_url = get_base_url(1);
$print_date = PrintDetails::get_max_date($base_url,$_GET['id']);
$max_date   = DateEngToNep($print_date);
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
    $data4= Analysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
    $data5=  Analysisbasedwithdraw::find_by_max($data4,$_GET['id']);
    $result = Plantotalinvestment::find_by_plan_id($_GET['id']);
     if(!empty($result))
        {
           $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
            $investment_data=Plantotalinvestment::find_by_plan_id($_GET['id']);
             $name = "उपभोक्ताबाट";
             
        }
        else
        {
            $investment_data= AmanatLagat::find_by_plan_id($_GET['id']);
            $data2= Amanat_more_details::find_by_plan_id($_GET['id']);
             $name = "";
             
        }
    $link = get_return_url($_GET['id']);
    ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>मुल्यांकनको आधारमा भुक्तानीको टिप्पणी :: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
         <div class="maincontent" >
                    <h2 class="headinguserprofile"> मुल्यांकनको आधारमा रकम भुक्तानी सम्बन्धमा | <a href="<?=$link?>" class="btn">पछि जानुहोस</a></h2>
                  
                    <div class="OurContentFull" >
                    <form method="get" action="print_bank_report_09_final.php" target="_blank" >
                         <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                       <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
									<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
									<div class="myspacer"></div>
									<div class="subjectbold letter_subject">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($print_date)){echo $max_date;
                                                                                                    }else{ echo generateCurrDate();}?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="myspacer20"></div>
										
										<div class="subject">   विषय:- मुल्यांकनको आधारमा रकम भुक्तानी सम्बन्धमा ।</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्रीमान् </div>
                                                                               
										<div class="banktextdetails"  >
											 यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम 
                                                                                         अनुसार मिति <?php echo convertedcit($data2->miti);?><!--(योजना संझौताको मिति)--> मा यस 
                                                                                         कार्यलय र  <b><u> <?php echo $data3->program_organizer_group_name;?></u></b><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)-->
                                                                                         बिच संझौता भई यस <?php echo SITE_TYPE;?>को वडा नं <?php echo convertedcit($data3->program_organizer_group_address);?><!--(योजना संचालन हुने वडा नं)-->  
                                                                                         मा <b><u><?php echo $data1->program_name;?></u></b><!--(योजनाको नाम)--> योजना संचालनको कार्यदेश दिइएकोमा मिति <?php echo convertedcit($data5->evaluated_date);?><!--(योजनाको काम सम्पन्न भएको 
                                                                                         मिति)--> मा प्राबिधिक मुल्याकन गर्दा तपशिल अनुसारको रकम
                                                                                         दिन मनासिब देखिएकाले श्रीमान् समक्ष निणयार्थ यो 
                                                                                         टिप्पणी पेश गरको छु । 
</div>                          
										
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table table-bordered table-responsive myWidth100">
                                               
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
  <?php   $datas=Plantotalinvestment::find_by_plan_id($_GET['id']);
                    $add=$datas->agreement_gauplaika+$datas->agreement_other+$datas->costumer_agreement+$datas->other_agreement;?>

                                            	<tr>
                                                    <td class="myWidth50 myTextalignRight">बिनियोजन श्रोत र व्याख्या: </td>
                                                    <td> <?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">योजनाको कुल अनुदान रकम</td>
                                                	<td>रु. <?php echo convertedcit($add); ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td  class="myTextalignRight">योजनाको कुल लागत अनुमान : </td>
                                                    <td> <?php echo convertedcit($investment_data->total_investment);?></td>
                                                </tr>
                                                <tr>
                                                    <td  class="myTextalignRight">कार्यदेश दिएको रकम: </td>
                                                    <td> <?php echo convertedcit($investment_data->bhuktani_anudan);?></td>
                                                </tr>
                                            	<tr>
                                                    <td  class="myTextalignRight">योजनाको मुल्यांकन किसिम : </td>
                                                    <td> <?php echo $period;?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">योजनाको मुल्यांकन मिति : </td>
                                                    <td><?php echo convertedcit($data5->evaluated_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">योजनाको मुल्यांकन रकम : </td>
                                                    <td><?php echo convertedcit($data5->evaluated_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">भुक्तानी दिनु पर्ने कुल  रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->payable_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">कन्टेन्जेन्सी  कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->contengency_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">पेश्की भुक्तानी लगेको कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->advance_payment);?></td>
                                                </tr>
                                                <tr>
                                                	<td  class="myTextalignRight">मर्मत सम्हार कोष कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->renovate_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">धरौटी कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->due_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">काम घटी भई कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->disaster_management_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">जम्मा कट्टी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->total_amount_deducted);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">हाल भुक्तानी दिनु पर्ने खुद रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data5->total_paid_amount);?></td>
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
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>