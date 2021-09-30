<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
 $ward_address=WardWiseAddress();
 $address= getAddress();

?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Plantotalinvestment::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
     $program_more_details= Programmoredetails::find_by_id($_GET['detail_id']);
   $program_additional_date= Programtimeadditionaffiliation::find_by_id($_GET['additional_id']);
   $date_selected= $_GET['date_selected'];
        ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>कार्यादेश सम्बन्धमा  । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
             	<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
												<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
												<h5 class="margin1em letter_title_three"><?php echo $ward_address;?></h5>
                                    
									<div class="myspacer"></div>
									<div class="subjectboldright">टिप्पणी आदेश</div>
                    <div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">कार्यक्रम दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        <div class="myspacer20"></div>
										
										<div class="subject">विषय:-  म्याद थप सम्बन्धमा  ।</div>
										<div class="myspacer20"></div>
										
                                                                   
										<div class="bankname">श्रीमान्
                                       
                                        </div>
                                                                                				<?php if($program_additional_date->period==1)
 {
        $period="पहिलो";
    }
    if($program_additional_date->period==2)
    {
        $period="दोस्रो";
    }
    if($program_additional_date->period==3)
    {
        $period="तेस्रो";
    }
     if($program_additional_date->period==4)
    {
        $period="चौथो";
    }
     if($program_additional_date->period==5)
    {
        $period="पाचौ";
    }
     if($program_additional_date->period==6)
    {
        $period="छैठो";
    }
		?>	
                                                                               
										<div class="banktextdetails "  >
										 यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम अनुसार  <?php echo $data1->program_name; ?><!--(योजनाको नाम) --> 
                                                                                          कार्यक्रम स्वीकृत भइ मिती <?php echo convertedcit($program_more_details->work_order_date);?><!--(योजना संझौताको मिति) --> 
                                                                                          मा यस <?php echo SITE_TYPE;?>सँग भएको संझौता अनुसार उक्त कार्यक्रम मिति <?php echo convertedcit($program_more_details->start_date);?><!--(योजना शुरु हुने मिति)--> देखी काम सुरु गरी मिती <?php echo convertedcit($program_more_details->completion_date);?><!--(योजना सम्पन्न हुने मिति)--> भित्रमा  काम
                                                                                          सम्पन्न गर्ने गरी तोकिएको म्याद भित्र काम  नसकिएको भनि म्याद थपका लागी निबेदन दिएकाले 
                                                                                          नियम अनुसार <?php echo $period;?> पटक मिति <?php echo convertedcit($program_additional_date->extended_date);?><!--(थपिएको म्यादको अबधी)--> सम्मका लागी  योजना संचालनको समय थप गर्नका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । 
                                        
                                            
										
										<div class="myspacer30"></div>
										<div class="oursignature">
सदर गर्ने </div>
										<div class="oursignatureleft">पेस गर्ने </div>
										<div class="myspacer"></div>

									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->