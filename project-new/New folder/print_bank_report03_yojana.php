<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$base_url = get_base_url(1);
$print_date = PrintDetails::get_max_date($base_url,$_GET['id']);
$max_date   = DateEngToNep($print_date);
	$datas= Bankinformation::find_all();
        $data=Plandetails1::find_by_id($_GET['id']);
        $result = Plantotalinvestment::find_by_plan_id($_GET['id']);
         if(!empty($result))
        {
            $data3=  Plantotalinvestment::find_by_plan_id($_GET['id']);
            $data1= Moreplandetails::find_by_plan_id($_GET['id']);
             $name = "उपभोक्ताबाट";
             
        }
        else
        {
            $data3= AmanatLagat::find_by_plan_id($_GET['id']);
            $data1= Amanat_more_details::find_by_plan_id($_GET['id']);
             $name = "";
             
        }
       $data4=Planstartingfund::find_by_plan_id($_GET['id']);
//        print_r($data4);exit;
       $link = get_return_url($_GET['id']);
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
                    <h2 class="headinguserprofile">पेश्की संझौताको टिप्प      <a href="<?=$link?>" class="btn">पछि जानु</a></h2>
                    
                    <div class="OurContentFull">
                    	<h2>पेश्की संझौताको टिप्पणी </h2>
                    	<form method="get" action="print_bank_report03_final.php?id=<?=$_GET['id']?>" target="_blank" >
                            
                         <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                                    
									<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
									<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
									<div class="myspacer"></div>
									<div class="subjectBold letter_subject">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php 
                                                                                                    if(!empty($print_date)){echo $max_date;
                                                                                                    }else{ echo generateCurrDate();}?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
                                        <div class="subject">
                                            <u>विषय:-
                                                <?php if(!empty($_GET['subject'])){
                                                    echo $_GET['subject'];
                                                }else{
                                                    echo "संझौता गरी पेश्की उपलब्ध गराउने सम्बन्धमा ।";
                                                }?>
                                            </u>
                                        </div>
										<div class="bankname">श्रीमान्</div>
										<div class="banktextdetails">
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार <?php echo SITE_LOCATION;?> वडा नं.<?php echo convertedcit($data->ward_no);?> मा <?php echo convertedcit($data->program_name);?> स्वीकृत भइ उक्त योजनामा प्राबिधिकबाट रु <?php echo convertedcit($data3->total_investment  );?> बराबरको लगत ईस्टमेट पेश भइ स्वीकृत भएकोमा मिति <?php echo convertedcit($data1->samiti_gathan_date);?> मा उपभोक्ता समिति गठन भइ समितिको तर्फबाट  बैठकको निर्णय प्रतिलिपी,निबेदन लगायत अन्य कागज पत्र सहित योजना संझौताका लागी माग भई आएकाले योजनाको कुल लागत रु <?php echo convertedcit($data3->total_investment);?> मा <?php echo SITE_TYPE;?>बाट अनुदान रु <?php echo convertedcit($data3->agreement_gauplaika);?>  तथा अन्य निकायबाट अनुदान रु <?php echo convertedcit($data3->agreement_other);?> र उपभोक्ताबाट नगद साझेदारी रु  <?php echo convertedcit($data3->costumer_agreement);?> तथा  अन्य साझेदारी रु <?php echo convertedcit($data3->other_agreement);?> र  उपभोक्ताबाट जनश्रमदान रु <?php echo convertedcit($data3->costumer_investment);?> भएकोमा मिति <?php echo convertedcit($data1->yojana_start_date);?> देखी काम सुरु गरी मिति <?php echo convertedcit($data1->yojana_sakine_date);?> भित्रमा योजनाको काम  सम्पन्न गर्नेगरी यस कार्यालयको निर्णय अनुसार मिति <?php echo convertedcit($data4->advance_return_date);?> भित्रमा पेश्की फर्छयौट गर्ने गरी उक्त योजना संचालनका लागी माथी उल्लेखित उपभोक्ता समिति सँग सम्झौता गरी रु <?php echo convertedcit($data4->advance);?> पेश्की उपलब्ध गराइ योजनाको कार्यदेश दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । श्रीमानको जो आदेश । 
										</div> 
										<div class="myspacer20"></div>
										<div class="oursignature">
सदर गर्ने </div>
										<div class="oursignatureleft">पेस गर्ने </div>
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