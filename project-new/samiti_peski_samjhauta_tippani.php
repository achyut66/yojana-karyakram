<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
	$datas= Bankinformation::find_all();
        $data=Plandetails1::find_by_id($_GET['id']);
        $data1=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
//        print_r($data1);exit;
        $data3=Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
        
        $data4=Samitiplanstartingfund::find_by_plan_id($_GET['id']);
//        print_r($data4);exit;
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
$ward_address=WardWiseAddress();
$address= getAddress();    
    ?>
  
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>पेश्की संझौताको टिप्पणी print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <form method="get" action="samiti_peski_samjhauta_tippani_final.php?>">
                    <h2 class="headinguserprofile">पेश्की संझौताको टिप्पणी <a class="btn" href="samiti_letters_select.php"> पछी  जानुहोस </a></h2> 
                     
                    <div class="OurContentFull">
                    	<h2>पेश्की संझौताको टिप्पणी  
                    	<div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट" name="submit" /></div>
                    	</h2>
                        
                        <!--<div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>-->
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
									<div class="subject"><u>टिप्पणी आदेश</u></div>
									<div class="printContent">
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></div>
										<div class="patrano">पत्र संख्या : </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="subject"><u>विषय:- योजना संझौता गरी पेश्की उपलब्ध गराउने सम्बन्धमा ।</u></div>
										<div class="bankname">श्रीमान्</div>
										
										<div class="banktextdetails">
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार <?php echo SITE_LOCATION;?> वडा नं.<?php echo convertedcit($data->ward_no);?> मा <?php echo convertedcit($data->program_name);?> स्वीकृत भइ उक्त योजनामा प्राबिधिकबाट रु <?php echo convertedcit($data3->total_investment  );?> बराबरको लगत ईस्टमेट पेश भइ स्वीकृत भएकोमा मिति <?php echo convertedcit($data1->samiti_gathan_date);?> मा संस्था / समिति गठन भइ समितिको तर्फबाट  बैठकको निर्णय प्रतिलिपी,निबेदन लगायत अन्य कागज पत्र सहित योजना संझौताका लागी माग भई आएकाले योजनाको कुल लागत रु <?php echo convertedcit($data3->total_investment);?> मा <?php echo SITE_TYPE;?>बाट अनुदान रु <?php echo convertedcit($data3->agreement_gauplaika);?>  तथा अन्य निकायबाट अनुदान रु <?php echo convertedcit($data3->agreement_other);?> र संस्था / समितिबाट नगद साझेदारी रु  <?php echo convertedcit($data3->costumer_agreement);?> तथा  अन्य साझेदारी रु <?php echo convertedcit($data3->other_agreement);?> र  संस्था / समितिबाट जनश्रमदान रु <?php echo convertedcit($data3->costumer_investment);?> भएकोमा मिति <?php echo convertedcit($data1->yojana_start_date);?> देखी काम सुरु गरी मिति <?php echo convertedcit($data1->yojana_sakine_date);?> भित्रमा योजनाको काम  सम्पन्न गर्नेगरी यस कार्यालयको निर्णय अनुसार मिति <?php echo convertedcit($data4->advance_return_date);?> भित्रमा पेश्की फर्छयौट गर्ने गरी उक्त योजना संचालनका लागी माथी उल्लेखित संस्था / समिति सँग सम्झौता गरी रु <?php echo convertedcit($data4->advance);?> पेश्की उपलब्ध गराइ योजनाको कार्यदेश दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । श्रीमानको जो आदेश । 
										</div> 
										<div class="myspacer20"></div>
										<div class="oursignature">सदर गर्ने <br> 
                                                                                    <select name="worker1" class="form-control worker" id="worker_1" >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                                                </div>
										<div class="oursignatureleft">पेस गर्ने  <br/>
                                                                                    <select name="worker2" class="form-control worker" id="worker_2">
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($workers as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                                                                                </div>
										<div class="myspacer"></div>
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>