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
<?php include("menuincludes/header.php"); ?>
<?php   
$data=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$data1=  Plandetails1::find_by_id($_GET['id']);
$data2=  Moreplandetails::find_by_plan_id($_GET['id']);
$data3_1=Plantimeadditionaffiliation::maxPeriodForPlan($_GET['id']);
$link = get_return_url($_GET['id']);

if(isset($_POST['submit']))
{
    $max_id=$_POST['max_id'];
    $data3=Plantimeadditionaffiliation::find_by_max($max_id,$_GET['id']);
    
}
?>
<!-- js ends -->
<title>विषय:- म्याद थप सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	
                <div class="maincontent">
                    <h2 class="headinguserprofile">म्याद थप सम्बन्धमा । <a href="<?=$link?>" class="btn">पछि जानुहोस</a></h2>
                    
                 
                    <div class="OurContentFull">
                    	
                        <div class="bankReport">
                        <form method="post">
                        <div class="inputWrap">
                       	 	<h1>भुक्तानी छान्नुहोस् </h1>
                            <div class="newInput">
                        		<select name="max_id">
                            <option value="">छान्नुहोस्</option>
                            <?php for($i=1;$i<=$data3_1;$i++):
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
                        </select>
                        </div>
                        <div class="saveBtn myWidth100">
                        	<input type="submit" name="submit" class="btn"  value="खोज्नुहोस"/>
                        </div>
                        </div>
                        </form>
                    </div>   <?php if(isset($_POST['submit'])):?>
                    <form method="get" action="print_bank_report06_final.php?id=<?=$_GET['id']?>" target="_blank" >
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" />
                        <div class="myPrint"><input type="hidden" name="max_id" value="<?=$max_id?>" />
                        <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                    
									<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em"><?php echo SITE_HEADING;?> </h4>
									<h5 class="margin1em"><?php echo SITE_ADDRESS;?></h5>
									<div class="myspacer"></div>
									<div class="subjectBold"></div>
									<div class="printContent">
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($print_date)){echo $max_date;
                                                                                                    }else{ echo generateCurrDate();}?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?></div>
										<div class="chalanino">चलानी नं :</div>
                                                                                <div class="subject">विषय:- म्याद थप सम्बन्धमा ।</div>
										<div class="bankname">श्री <?php echo $data->program_organizer_group_name;?><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--></div>
										<div class="bankaddress"><?php echo SITE_NAME.convertedcit($data->program_organizer_group_address);?><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)--></div>
										<?php if($data3->period==1)
 {
        $period="पहिलो";
    }
    if($data3->period==2)
    {
        $period="दोस्रो";
    }
    if($data3->period==3)
    {
        $period="तेस्रो";
    }
     if($data3->period==4)
    {
        $period="चौथो";
    }
     if($data3->period==5)
    {
        $period="पाचौ";
    }
     if($data3->period==6)
    {
        $period="छैठो";
    }
		?>
										<div class="banktextdetails">
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार <?php echo SITE_LOCATION;?> वडा नं.<?php echo convertedcit($data->program_organizer_group_address);?><!--(योजनाको ठेगाना भएको वडा न)--> मा <?php echo $data1->program_name;?><!--(योजनाको नाम) -->
                                                                                        योजना स्वीकृत भइ मिती <?php echo convertedcit($data2->miti);?> <!-- (योजना संझौताको मिति)-->  मा यस <?php echo SITE_TYPE;?> सँग भएको संझौता 
                                                                                        अनुसार उक्त योजना मिति <?php echo convertedcit($data2->yojana_start_date);?><!--(योजना शुरु हुने मिति)--> देखी काम सुरु गरी मिती <?php echo convertedcit($data2->yojana_sakine_date);?><!--(योजना सम्पन्न हुने मिति)-->
                                                                                        भित्रमा  काम  सम्पन्न गर्ने गरी योजनाको कार्यदेश दिइएकोमा 
                                                                                        उपभोक्ता समितिले मिति <?php echo convertedcit($data3->letter_date);?><!--(म्याद थपको लागी उपभोक्ता समितिले निबेदन दिएको मिती)--> मा यस
                                                                                        कार्यालयमा <?php echo $data3->program_problem_reason;?><!--(योजना म्याद भित्र नसकिनुको कारण)-->  कारणले तोकिएको समयमा योजना सम्पन्न
                                                                                        गर्न नसकिएको भनि म्याद थपका लागी निबेदन दिएकाले यस कार्यालयको निर्णय अनुसार <?php echo $period; ?>पटक  मिति <?php echo convertedcit($data3->extended_date);?><!--(थपिएको म्यादको अबधी)--> सम्मका लागी 
                                                                                        योजना संचालनको म्याद थप गरिएको जानकारी गराइन्छ ।
										</div>
										<div class="myspacer20"></div>
										<div class="oursignature">
</div>
										
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