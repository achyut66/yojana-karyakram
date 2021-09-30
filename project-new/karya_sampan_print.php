<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
error_reporting(1);
$ward_address=WardWiseAddress();
$address= getAddress();
$date_selected= $_GET['date_selected'];
$url = get_base_url();
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

$print_history->save();
if(!empty($_GET['worker1']))
{
$worker1 = Workerdetails::find_by_id($_GET['worker1']);
}
else
{
    $worker1 = Workerdetails::setEmptyObject();
}


?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
     $result = Plantotalinvestment::find_by_plan_id($_GET['id']);
     if(!empty($result))
        {
            $data4=  Plantotalinvestment::find_by_plan_id($_GET['id']);
            $data2= Moreplandetails::find_by_plan_id($_GET['id']);
             $name = "उपभोक्ताबाट";
             
        }
        else
        {
            $data4= AmanatLagat::find_by_plan_id($_GET['id']);
            $data2= Amanat_more_details::find_by_plan_id($_GET['id']);
             $name = "";
             
        }
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $fiscal = FiscalYear::find_by_id($data1->fiscal_id); ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>योजनाको कार्य सम्पन्न भएको भुक्तानी पाउँ   । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
                                 <div class="myspacer"></div>
										<div class="printContent">
										<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
											<div class="myspacer30"></div>
											
									<div class="subject"><u>विषय:- योजनाको कार्य सम्पन्न भएको भुक्तानी पाउँ |</u></div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री श्रीमान् प्रमुख प्रशासकीय अधिकृत ज्यू, ,<br>
                                        <div class="bankname"><?php echo SITE_FIRST_NAME.' '.SITE_HEADING?>,<br>	
									    <?php echo SITE_ADDRESS;?>   | <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                        <div class="myspacer"></div>                                       
										<div class="banktextdetails"  >
										प्रस्तुत विषयमा यस नगरपालिका अन्तर्गत वडा नं    <strong><u><?php echo convertedcit($data3->program_organizer_group_address);?></u></strong>  टोलमा संचालित  <strong><u><?php echo $data3->program_organizer_group_name;?></u></strong>  योजनाको कार्य सम्पन्न भएकोले निम्न कागजात सहित पेश गरेको छु। पेश गरेको विल, भरपाई,कागजात, फोटो यथार्थ, सही,सत्य छन्। भएका दस्तखत तथा ल्याप्चे सहिछाप सम्बन्धित व्यक्तिकै हुन् यसमा झुठा ठहरिएमा म स्वयं जिम्मेवार भई प्रचलित कानुन बमोजिम वुझाँउला। कुनै निकायबाट निरीक्षण वा पुन: मुल्यांकन हुँदा प्राविधिक मुल्यांकन भन्दा परिमाण तथा गुणस्तरमा फरक परेको तथा रकम हिनामिना प्रमाणित भएमा कानुन बमोजिम सहुला वुझाँउला।</div>
                                       <span>
                                           
                                          		<div class="myspacer20"></div>
                                          	<div class="mymarginright"></div>	
                                		  <b>पेश भएका कागजातहरु :</b><br>
                                           <div class="myspacer20"></div>
                                           <b>
                                           १. नगरपालिका संग भएको योजना सम्झौता ।<br>
                                           २. वडा कार्यलयको कार्य सम्पन्न भएको सिफारिस ।<br>
                                           ३. उपभोक्ता समितिको कार्य सम्पन्न भएको निर्णयको माइन्यूटको प्रमाणित फोटोकपी ।<br>
                                           ४. उपभोक्ता समितिबाट प्रमाणित खर्चको विल, भरपाई ।<br>
                                           ५. योजनाको खर्च सार्वजिनक फारम ।<br>
                                           ६. वडा स्तरीय/नगर स्तरीय अनुगमन समितिको सिफारिस ।<br>
                                           ७. काम शुरु हुनु भन्दा अगाडिको फोटो, काम हुँदै गर्दाको फोटो, कार्य सम्पन्न भईसकेपछिको फोटो । <br>
                                           ८. प्राविधिक लागत अनुमान, प्राविधिक मूल्यांकन (नापी किताब), एवं कार्य सम्पन्न प्रतिवेदन ।<br>
                                           ९. योजना शाखाको भुक्तानी  सिफारिस टिप्पणी ।<br>
    </b>                                 
                                           		<div class="myspacer30"></div>
                                                                                  <div class="row">
                                                <div class="col-4 offset text-center">
                                                    औठाको छाप
                                                    <table class="finger-table table">
                                                        <tr>
                                                            <td> दायाँ </td>
                                                            <td> बायाँ </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="height: 100px;"> </td>
                                                            <td style="height: 100px;"> </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-4 offset-4 mt-5">
                                               	<span>
                                              
                                  <u> निवेदकको  </u> <br> नाम   :<br> उपभोक्ता समितिमा पद:  :<br>दस्तखत:
                                  </div>
								</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->