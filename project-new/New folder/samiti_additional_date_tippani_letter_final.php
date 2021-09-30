<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$max_id=$_GET['max_id'];
?>
<?php
$data1=  Plandetails1::find_by_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
$data2=  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
$data3=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
$data4=  Plantimeadditionaffiliation::find_by_max($max_id,$_GET['id']);
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
$date_selected= $_GET['date_selected'];
?>
    
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>विषय:- म्याद थप सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
     <div class="myPrintFinal" >
                    	
                        
                        <div class="userprofiletable">
                        	<div class="printPage">
                                    <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                                    <h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
                                    <h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
									<div class="myspacer"></div>
									<div class="subjectboldright">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected);  ?></div>
										<div class="patrano">पत्र संख्या :<?php echo convertedcit($fiscal->year);?> </div>
                                                                                <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										
<div class="myspacer20"></div>
										<div class="subject">विषय:- म्याद थप सम्बन्धमा ।</div>
<div class="myspacer20"></div>
										<div class="bankname">श्रीमान् </div>
										<?php if($data4->period==1)
 {
        $period="पहिलो";
    }
    if($data4->period == 2)
    {
        $period="दोस्रो";
    }
    if($data4->period==3)
    {
        $period="तेस्रो";
    }
     if($data4->period==4)
    {
        $period="चौथो";
    }
     if($data4->period==5)
    {
        $period="पाचौ";
    }
     if($data4->period==6)
    {
        $period="छैठो";
    }
		?>	
										<div class="banktextdetails">
											  यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम अनुसार <?php echo SITE_LOCATION;?> वडा नं.<?php echo convertedcit($data2->program_organizer_group_address);?><!--(योजनाको ठेगाना भएको वडा न)--> मा <?php echo $data1->program_name; ?><!--(योजनाको नाम) --> 
                                                                                          योजना स्वीकृत भइ मिती <?php echo convertedcit($data3->miti);?><!--(योजना संझौताको मिति) --> 
                                                                                          मा यस <?php echo SITE_TYPE;?>सँग भएको संझौता अनुसार उक्त योजना मिति <?php echo convertedcit($data3->yojana_start_date);?><!--(योजना शुरु हुने मिति)--> देखी काम सुरु गरी मिती <?php echo convertedcit($data3->yojana_sakine_date);?><!--(योजना सम्पन्न हुने मिति)--> भित्रमा  काम
                                                                                          सम्पन्न गर्ने गरी संस्था / समिति सँग सम्झौता गरी योजनाको कार्यदेश दिइएकोमा संस्था / समितिले मिति <?php echo convertedcit($data4->letter_date);?><!--(म्याद थपको लागी उपभोक्ता समितिले निबेदन दिएको मिती)-->
                                                                                          मा यस कार्यालयमा <?php echo $data4->program_problem_reason;?><!--(योजना म्याद भित्र नसकिनुको कारण)-->  कारणले तोकिएको समयमा योजना सम्पन्न गर्न नसकिएको भनि म्याद थपका लागी निबेदन दिएकाले 
                                                                                          नियम अनुसार <?php echo $period;?> पटक मिति <?php echo convertedcit($data4->extended_date);?><!--(थपिएको म्यादको अबधी)--> सम्मका लागी  योजना संचालनको समय थप गर्नका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । 
										</div>
										<div class="myspacer30"></div>
										<div class="oursignature">
सदर गर्ने </div>
										<div class="oursignatureleft">पेस गर्ने </div>
										<div class="myspacer"></div>
 </div>
                        </div>
                  </div> 