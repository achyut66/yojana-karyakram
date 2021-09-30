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
$ward_address=WardWiseAddress();
$address= getAddress(); 
?>
  
<?php include("menuincludes/header1.php"); ?>

<title>पेश्की संझौताको टिप्पणी print page:: <?php echo SITE_SUBHEADING;?></title>

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
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                   
									<div class="myspacer"></div>
									<div class="subject"><u>टिप्पणी आदेश </u></div>
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
<div class="myspacer20"></div>
										<div class="subject"><u>विषय:- योजना संझौता गरी पेश्की उपलब्ध गराउने सम्बन्धमा ।</u></div>
<div class="myspacer20"></div>
										<div class="bankname">श्रीमान्</div>
										
										<div class="banktextdetails">
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार <?php echo SITE_LOCATION;?> वडा नं.<?php echo convertedcit($data->ward_no);?> मा <?php echo convertedcit($data->program_name);?> स्वीकृत भइ उक्त योजनामा प्राबिधिकबाट रु <?php echo convertedcit($data3->total_investment  );?> बराबरको लगत ईस्टमेट पेश भइ स्वीकृत भएकोमा मिति <?php echo convertedcit($data1->samiti_gathan_date);?> मा संस्था / समिति गठन भइ समितिको तर्फबाट  बैठकको निर्णय प्रतिलिपी,निबेदन लगायत अन्य कागज पत्र सहित योजना संझौताका लागी माग भई आएकाले योजनाको कुल लागत रु <?php echo convertedcit($data3->total_investment);?> मा <?php echo SITE_TYPE;?>बाट अनुदान रु <?php echo convertedcit($data3->agreement_gauplaika);?>  तथा अन्य निकायबाट अनुदान रु <?php echo convertedcit($data3->agreement_other);?> र संस्था / समितिबाट नगद साझेदारी रु  <?php echo convertedcit($data3->costumer_agreement);?> तथा  अन्य साझेदारी रु <?php echo convertedcit($data3->other_agreement);?> र  संस्था / समितिबाट जनश्रमदान रु <?php echo convertedcit($data3->costumer_investment);?> भएकोमा मिति <?php echo convertedcit($data1->yojana_start_date);?> देखी काम सुरु गरी मिति <?php echo convertedcit($data1->yojana_sakine_date);?> भित्रमा योजनाको काम  सम्पन्न गर्नेगरी यस कार्यालयको निर्णय अनुसार मिति <?php echo convertedcit($data4->advance_return_date);?> भित्रमा पेश्की फर्छयौट गर्ने गरी उक्त योजना संचालनका लागी माथी उल्लेखित संस्था / समिति सँग सम्झौता गरी रु <?php echo convertedcit($data4->advance);?> पेश्की उपलब्ध गराइ योजनाको कार्यदेश दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । श्रीमानको जो आदेश । 
										</div> 
										<div class="myspacer30"></div>
										<div class="oursignature">सदर गर्ने <br>
                                                                                        <?php 
                                                                                            if(!empty($worker1))
                                                                                            {
                                                                                                echo $worker1->authority_name."<br/>";
                                                                                                echo $worker1->post_name;
                                                                                            }
                                                                                        ?>

                                                                                </div>
										<div class="oursignatureleft">पेस गर्ने<br>
                                                                                    <?php 
                                                                                        if(!empty($worker2))
                                                                                        {
                                                                                            echo $worker2->authority_name."<br/>";
                                                                                            echo $worker2->post_name;
                                                                                        }
                                                                                    ?>

                                                                                 </div>
										<div class="myspacer"></div>
									</div><!-- print content ends -->
                                
                            </div>
                        </div>
                  </div>
</div>
            


                