<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$max_id=$_GET['max_id'];
?>
<?php
$user = getUser();
$data1=  Plandetails1::find_by_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
$data2=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$data3=  Moreplandetails::find_by_plan_id($_GET['id']);
$data4=Plantimeadditionaffiliation::find_by_max($max_id,$_GET['id']);
$date_selected= $_GET['date_selected'];
$url = get_base_url();
$user = getUser();
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
}
$address= getAddress();
  $ward_address=WardWiseAddress();
?>
    
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>विषय:- म्याद थप सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>

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
                                    <div style="color:red">
                                    <h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>

                                        <h5 class="marginright1.5 letter-title-four">
                                            <?php
                                            if($user->mode==user){
                                                echo $user->ward_add;
                                            }else {
                                                echo $ward_address;
                                            }
                                            ?>
                                        </h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
									</div>
									<div class="myspacer"></div>
									<div class="subjectboldright letter_subject">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या :<?php echo convertedcit($fiscal->year);?> </div>
                                                                                <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
                                                                                <div class="chalanino"> चलानी नं . : </div>
										
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
                                                                                          सम्पन्न गर्ने गरी उपभोक्ता समिति सँग सम्झौता गरी योजनाको कार्यदेश दिइएकोमा उपभोक्ता समितिले मिति <?php echo convertedcit($data4->letter_date);?><!--(म्याद थपको लागी उपभोक्ता समितिले निबेदन दिएको मिती)-->
                                                                                          मा यस कार्यालयमा <?php echo $data4->program_problem_reason;?><!--(योजना म्याद भित्र नसकिनुको कारण)-->  कारणले तोकिएको समयमा योजना सम्पन्न गर्न नसकिएको भनि म्याद थपका लागी निबेदन दिएकाले 
                                                                                          नियम अनुसार <?php echo $period;?> पटक मिति <?php echo convertedcit($data4->extended_date);?><!--(थपिएको म्यादको अबधी)--> सम्मका लागी  योजना संचालनको समय थप गर्नका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । 
										</div>
										<div class="myspacer30"></div>
                                                                                <div class="oursignature">सदर गर्ने <br/>
                                                                                    <?php 
                                                                                        if(!empty($worker1))
                                                                                        {
                                                                                            echo $worker1->authority_name."<br/>";
                                                                                            echo $worker1->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                                <div class="oursignatureleft">पेस गर्ने <br/>
                                                                                    <?php 
                                                                                        if(!empty($worker2))
                                                                                        {
                                                                                            echo $worker2->authority_name."<br/>";
                                                                                            echo $worker2->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
										<div class="myspacer"></div>
 </div>
                        </div>
                  </div> 