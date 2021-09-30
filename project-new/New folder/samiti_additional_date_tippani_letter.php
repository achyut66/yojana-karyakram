<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
  if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}?>
<?php include("menuincludes/header.php"); ?>
<?php
$base_url = get_base_url(1);
$print_date = PrintDetails::get_max_date($base_url,$_GET['id']);
$max_date   = DateEngToNep($print_date);
$data1=  Plandetails1::find_by_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
$data2=  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
$data3=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
$data4_1 = Plantimeadditionaffiliation::maxPeriodForPlan($_GET['id']);


if(isset($_POST['submit']))
{
    $max_id=$_POST['max_id'];
    $data4=Plantimeadditionaffiliation::find_by_max($max_id,$_GET['id']);
    
}

?>
<!-- js ends -->
<title>विषय:- म्याद थप सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">विषय:- म्याद थप सम्बन्धमा । <a class="btn" href="samiti_letters_select.php"> पछी  जानुहोस </a></h2>
                   
                     
                    <div class="OurContentFull">
                    	<h2>विषय:- म्याद थप सम्बन्धमा । : </h2>
<div class="bankReport">
                        <form method="post">
                        पत्र छान्नुहोस् :
                        <select name="max_id">
                            <option value="">छान्नुहोस्</option>
                            <?php for($i=1;$i<=$data4_1;$i++):
                                if($i==1)
 {
        $period="पहिलो";
    }
    if($i==2)
    {
        $period="दोस्रो";
    }
    if($i==3)
    {
        $period="तेस्रो";
    }
     if($i==4)
    {
        $period="चौथो";
    }
     if($i==5)
    {
        $period="पाचौ";
    }
     if($i==6)
    {
        $period="छैठो";
    }
	
                            
?>
                            <option value="<?php echo $i;?>"><?php echo $period;?></option>
                            <?php endfor;?>
                        </select> &nbsp;&nbsp;
                        <input type="submit" name="submit" class="submithere"  value="खोज्नुहोस"/>
                        </form>
                    </div>
                    <?php if(isset($_POST['submit'])):?>
                        <div class="myPrint">  <a href="print_details_view.php?id=<?=$_GET['id']?>&page=<?=$base_url?>" class="btn" target="_blank">प्रिन्ट विवरण</a>&nbsp;</div><br/><br/>
                        <form method="get" action="samiti_additional_date_tippani_letter_final.php?id=<?=$_GET['id']?>" target="_blank" >
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                    
									<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                                    <h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
                                    <h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
									<div class="myspacer"></div>
									<div class="subject">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate">मिति : <input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($print_date)){echo $max_date;
                                                                                                    }else{ echo generateCurrDate();}?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या :<?php echo convertedcit($fiscal->year);?> </div>
                                                                                <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										
										<div class="subject">विषय:- म्याद थप सम्बन्धमा ।</div>
										<div class="bankname">श्रीमान् </div>
										<?php if($data4->period==1)
 {
        $period="पहिलो";
    }
    if($data4->period==2)
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
		?>								<div class="banktextdetails">
											  यस कार्यालयको स्वीकृत वार्षिक कार्यक्रम अनुसार <?php echo SITE_LOCATION;?> वडा नं.<?php echo convertedcit($data2->program_organizer_group_address);?><!--(योजनाको ठेगाना भएको वडा न)--> मा <?php echo $data1->program_name; ?><!--(योजनाको नाम) --> 
                                                                                          योजना स्वीकृत भइ मिती <?php echo convertedcit($data3->miti);?><!--(योजना संझौताको मिति) --> 
                                                                                          मा यस <?php echo SITE_TYPE;?>सँग भएको संझौता अनुसार उक्त योजना मिति <?php echo convertedcit($data3->yojana_start_date);?><!--(योजना शुरु हुने मिति)--> देखी काम सुरु गरी मिती <?php echo convertedcit($data3->yojana_sakine_date);?><!--(योजना सम्पन्न हुने मिति)--> भित्रमा  काम
                                                                                          सम्पन्न गर्ने गरी संस्था / समिति सँग सम्झौता गरी योजनाको कार्यदेश दिइएकोमा संस्था / समितिले मिति <?php echo convertedcit($data4->letter_date);?><!--(म्याद थपको लागी उपभोक्ता समितिले निबेदन दिएको मिती)-->
                                                                                          मा यस कार्यालयमा <?php echo $data4->program_problem_reason;?><!--(योजना म्याद भित्र नसकिनुको कारण)-->  कारणले तोकिएको समयमा योजना सम्पन्न गर्न नसकिएको भनि म्याद थपका लागी निबेदन दिएकाले 
                                                                                          नियम अनुसार <?php echo $period;?> पटक मिति <?php echo convertedcit($data4->extended_date);?><!--(थपिएको म्यादको अबधी)--> सम्मका लागी  योजना संचालनको समय थप गर्नका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । 
										</div>
										<div class="myspacer20"></div>
										<div class="oursignature">
सदर गर्ने </div>
										<div class="oursignatureleft">पेस गर्ने </div>
										<div class="myspacer"></div>    
									</div>
                                                                        <?php endif;?>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>