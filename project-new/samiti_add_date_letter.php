<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
  if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
?>
<?php include("menuincludes/header.php"); ?>
<?php   
$data=  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
$data1=  Plandetails1::find_by_id($_GET['id']);
$data2=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
$data3_1=Plantimeadditionaffiliation::maxPeriodForPlan($_GET['id']);
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
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
    if(empty($worker3))
    {
        $worker3 = Workerdetails::setEmptyObject();
    }
    if(empty($worker4))
    {
        $worker4 = Workerdetails::setEmptyObject();
    }
}

if(isset($_POST['submit']))
{
    $max_id=$_POST['max_id'];
    $data3=Plantimeadditionaffiliation::find_by_max($max_id,$_GET['id']);
    
}
$ward_address=WardWiseAddress();
$address= getAddress();
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
                    <form method="get" action="samiti_add_date_letter_final.php?>">
                        
                    <h2 class="headinguserprofile">विषय:- म्याद थप सम्बन्धमा । <a class="btn" href="samiti_letters_select.php"> पछी  जानुहोस </a></h2>
                   
                 
                    <div class="OurContentFull">
                    	<h2>विषय:- म्याद थप सम्बन्धमा । :
                    	<div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" />
                                <input type="hidden" name="max_id" value="<?=$max_id?>" />
                            <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                    	</h2>
                        <div class="bankReport">
                        <form method="post">
                        भुक्तानी छान्नुहोस् :
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
                        </select> &nbsp;&nbsp;
                        <input type="submit" name="submit" class="submithere"  value="खोज्नुहोस"/>
                        </form>
                    </div>   <?php if(isset($_POST['submit'])):?>
                        
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
									<div class="subjectBold"></div>
									<div class="printContent">
										<div class="mydate">मिति : <input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></div>
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
                                                                                        संस्था / समितिले मिति <?php echo convertedcit($data3->letter_date);?><!--(म्याद थपको लागी उपभोक्ता समितिले निबेदन दिएको मिती)--> मा यस
                                                                                        कार्यालयमा <?php echo $data3->program_problem_reason;?><!--(योजना म्याद भित्र नसकिनुको कारण)-->  कारणले तोकिएको समयमा योजना सम्पन्न
                                                                                        गर्न नसकिएको भनि म्याद थपका लागी निबेदन दिएकाले यस कार्यालयको निर्णय अनुसार <?php echo $period; ?>पटक  मिति <?php echo convertedcit($data3->extended_date);?><!--(थपिएको म्यादको अबधी)--> सम्मका लागी 
                                                                                        योजना संचालनको म्याद थप गरिएको जानकारी गराइन्छ ।
										</div>
										<div class="myspacer20"></div>
                                                                                <div class="oursignature mymarginright"> सदर गर्ने<br> 
                                                                                    <select name="worker1" class="form-control worker" id="worker_1" >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                                                 </div>
                                                                                <div class="oursignatureleft mymarginright">तयार गर्ने   <br/>
                                                                                    <select name="worker2" class="form-control worker" id="worker_2">
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                                                                                 </div>

                                                                                <div class="oursignatureleft mymarginright"> पेश गर्ने   <br/>
                                            <select name="worker3" class="form-control worker" id="worker_3">
                                                <option value="">छान्नुहोस्</option>
                                                <?php foreach($workers as $worker){?>
                                                <option value="<?=$worker->id?>" <?php if($print_history->worker3 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                <?php }?>
                                            </select>
                                            <input type="text" name="post" class="form-control" id="post_3" value="<?=$worker3->post_name?>">
                                         </div>                                                                  

                                                                                <div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने <br/> 
                                                                                    <select name="worker4" class="form-control worker" id="worker_4">
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker4 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_4" value="<?=$worker4->post_name?>"></form>
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