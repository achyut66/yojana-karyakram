<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
	$datas= Bankinformation::find_all();
        $data=Plandetails1::find_by_id($_GET['id']);
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
        $date_selected= $_GET['date_selected'];
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
	?>
  
<?php include("menuincludes/header1.php"); ?>

<title>पेश्की संझौताको टिप्पणी print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    	<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="marginright1 letter_title_two"><?php echo SITE_HEADING;?> </h4>
									<h5 class="marginright1 letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                                   
									<div class="myspacer"></div>
									<div class="subjectboldright letter_subject">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate">मिति :<?php echo convertedcit($date_selected); ?> </div>
										<div class="patrano">पत्र संख्या : </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
<div class="myspacer20"></div>
										<div class="subject">विषय:- योजना संझौता गरी पेश्की उपलब्ध गराउने सम्बन्धमा ।</div>
<div class="myspacer20"></div>
										<div class="bankname">श्रीमान्</div>
										
										<div class="banktextdetails">
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार <?php echo SITE_LOCATION;?> वडा नं.<?php echo convertedcit($data->ward_no);?> मा <?php echo convertedcit($data->program_name);?> स्वीकृत भइ उक्त योजनामा प्राबिधिकबाट रु <?php echo convertedcit($data3->total_investment  );?> बराबरको लगत ईस्टमेट पेश भइ स्वीकृत भएकोमा मिति <?php echo convertedcit($data1->samiti_gathan_date);?> मा उपभोक्ता समिति गठन भइ समितिको तर्फबाट  बैठकको निर्णय प्रतिलिपी,निबेदन लगायत अन्य कागज पत्र सहित योजना संझौताका लागी माग भई आएकाले योजनाको कुल लागत रु <?php echo convertedcit($data3->total_investment);?> मा <?php echo SITE_TYPE;?>बाट अनुदान रु <?php echo convertedcit($data3->agreement_gauplaika);?>  तथा अन्य निकायबाट अनुदान रु <?php echo convertedcit($data3->agreement_other);?> र उपभोक्ताबाट नगद साझेदारी रु  <?php echo convertedcit($data3->costumer_agreement);?> तथा  अन्य साझेदारी रु <?php echo convertedcit($data3->other_agreement);?> र  उपभोक्ताबाट जनश्रमदान रु <?php echo convertedcit($data3->costumer_investment);?> भएकोमा मिति <?php echo convertedcit($data1->yojana_start_date);?> देखी काम सुरु गरी मिति <?php echo convertedcit($data1->yojana_sakine_date);?> भित्रमा योजनाको काम  सम्पन्न गर्नेगरी यस कार्यालयको निर्णय अनुसार मिति <?php echo convertedcit($data4->advance_return_date);?> भित्रमा पेश्की फर्छयौट गर्ने गरी उक्त योजना संचालनका लागी माथी उल्लेखित उपभोक्ता समिति सँग सम्झौता गरी रु <?php echo convertedcit($data4->advance);?> पेश्की उपलब्ध गराइ योजनाको कार्यदेश दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । श्रीमानको जो आदेश । 
										</div> 
										<div class="myspacer30"></div>
										<div class="oursignature"> सदर गर्ने </div>
										<div class="oursignatureleft">पेस गर्ने </div>
										<div class="myspacer"></div>
									</div><!-- print content ends -->
                                
                            </div>
                        </div>
                  </div>
</div>
            


                