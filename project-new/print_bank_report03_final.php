<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
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
$fiscal = FiscalYear::find_by_id(1); //print_r($fiscal);
$ward_address=WardWiseAddress();
$address= getAddress();
$ward1 = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
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
										<div class="mydate">मिति :<?php echo convertedcit($date_selected); ?> </div>
										<div class="patrano">पत्र संख्या: <?php echo convertedcit($fiscal->year);?> </div>
										<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino"> चलानी नं . : </div>
                                        <div class="subject">
                                            <u>विषय:-
                                                <?php if(!empty($_GET['subject'])){
                                                    echo $_GET['subject'];
                                                }else{
                                                    echo "योजना संझौता गरी पेश्की उपलब्ध गराउने सम्बन्धमा ।";
                                                }?>
                                            </u>
                                        </div>
										<div class="bankname">श्रीमान्</div>
										
										<div class="banktextdetails">
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार <b><?php echo SITE_LOCATION;?></b> वडा नं.<b><?php echo convertedcit($ward1->program_organizer_group_address);?></b> मा <b><?php echo convertedcit($data->program_name);?></b> स्वीकृत भइ उक्त योजनामा प्राबिधिकबाट रु <b><?php echo convertedcit($data3->total_investment  );?></b> बराबरको लगत ईस्टमेट पेश भइ स्वीकृत भएकोमा मिति <b><?php echo convertedcit($data1->samiti_gathan_date);?></b> मा उपभोक्ता समिति गठन भइ समितिको तर्फबाट  बैठकको निर्णय प्रतिलिपी,निबेदन लगायत अन्य कागज पत्र सहित योजना संझौताका लागी माग भई आएकाले योजनाको कुल लागत रु <b><?php echo convertedcit($data3->total_investment);?></b> मा <b><?php echo SITE_TYPE;?></b>बाट अनुदान रु <b><?php echo convertedcit($data3->agreement_gauplaika);?></b>  तथा अन्य निकायबाट अनुदान रु <b><?php echo convertedcit($data3->agreement_other);?></b> र उपभोक्ताबाट नगद साझेदारी रु  <b><?php echo convertedcit($data3->costumer_agreement);?></b> तथा  अन्य साझेदारी रु <b><?php echo convertedcit($data3->other_agreement);?></b> र  उपभोक्ताबाट जनश्रमदान रु <b><?php echo convertedcit($data3->costumer_investment);?></b> भएकोमा मिति <b><?php echo convertedcit($data1->yojana_start_date);?></b> देखी काम सुरु गरी मिति <b><?php echo convertedcit($data1->yojana_sakine_date);?></b> भित्रमा योजनाको काम  सम्पन्न गर्नेगरी यस कार्यालयको निर्णय अनुसार मिति <b><?php echo convertedcit($data4->advance_return_date);?></b> भित्रमा पेश्की फर्छयौट गर्ने गरी उक्त योजना संचालनका लागी माथी उल्लेखित उपभोक्ता समिति सँग सम्झौता गरी रु <b><?php echo convertedcit($data4->advance);?></b> पेश्की उपलब्ध गराइ योजनाको कार्यदेश दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । श्रीमानको जो आदेश । 
										</div> 
										<div style="margin-top:50px;"> </div>
										<div class="myspacer30"></div>
                                                                                <div class="oursignature"> सदर गर्ने <br/>
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
									</div><!-- print content ends -->
                                
                            </div>
                        </div>
                  </div>
</div>
            


                