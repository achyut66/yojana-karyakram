<?php require_once("includes/initialize.php"); ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>विषय:- ।
    <?php echo SITE_SUBHEADING;?>
</title>
<?php 
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$workers = Workerdetails::find_by_id(1);
//print_r($workers);
$url = get_base_url(1);
//print_r($url);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
$ward_address=WardWiseAddress();
$address= getAddress();
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
$ward_address = WardWiseAddress();
$address = getAddress();
$fiscal = Fiscalyear::find_current_id();
$fiscal_selected = Fiscalyear::find_by_id($fiscal);
$customer=Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$customer_details=Costumerassociationdetails::find_by_plan_id($_GET['id']);
$plan_details = Plandetails1::find_by_id($_GET['id']);
$more_details = MorePlanDetails::find_by_plan_id($_GET['id']);
$details_letter = LetterBill::find_by_plan_id($_GET['id']);
if(empty($details_letter->id))
  {
      $details_letter = LetterBill::SetEmptyObj();
      $date = generateCurrDate();
      $paper_array = array();
  }
 else 
  {
        $date = DateEngToNep($details_letter->date);     
        $paper_array = explode('-',$details_letter->documents);
  }
  //print_r($more_details); exit;
?>
<body>
     <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                                    	<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="marginright1 letter_title_two"><?php echo $address;?></h4>
									<h5 class="marginright1 letter_title_three"><?php echo $ward_address;?></h5>
									<div class="myspacer"></div>
									<div class="printContent">
    <form method="post" action="print_bank_report_bhuktani_final.php" target="_blank">
         <div class="mydate">मिति : <input type="text" name="date_selected" value="<?php echo $date ;?>" id="nepaliDate5" /></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal_selected->year); ?></div>
										 <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino">चलानी नं: </div>
                                        <div class="myPrint"><button name="submit">प्रिन्ट गर्नुहोस</button></div>
                            <div class="subject"> विषय:- प्राविधिक मूल्याकनको आधारमा रनिङ बिल र अन्तिम विल भुक्तानी गर्ने सम्बन्धमा ।</div><br>
                            <div> श्रीमान् </div>
                            <div class="banktextdetails">
                                यस कार्यालयको स्वीकृत वार्षिाक कार्यक्रम अनुसार मिति <?=convertedcit($more_details->miti)?> मा यस कार्यालय र गजुरी गाउँपालिका वडा नं. <?= convertedcit($customer->program_organizer_group_address) ?> को <?= convertedcit($customer->program_organizer_group_name) ?> विच सम्झौता भई कार्यादेश दिईएकोमा निम्नानुसारका आवश्यक कागजातहरु सलग्न रहेको हुदा रनिङ विल भुक्तानी / अन्तिम विल भुक्तानीको लागि निर्णयार्थ पेश गरेको छु । 
                            </div>
                            <div>
                                <table class="table myWidth100 table-bordered">
                                    <tr>
                                        <td style="width:90%;"><b> आवश्यक कागजातहरु </b></td>
                                        <td> <b> संलग्न / भएको नभएको</b> </td>
                                    </tr>
                                    <tr>
                                        <td> उपभोक्ता समिति गठनको निर्णय :</td>
                                        <td> <input <?php if(in_array('1', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td> स्वीकृत स्पेसिफिकेशन तथा लागत अनुमान र नक्सा :</td>
                                        <td> <input <?php if(in_array('2', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="2"> </td>
                                    </tr>
                                    <tr>
                                        <td> ठेका बिल  </td>
                                        <td> <input <?php if(in_array('3', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="3"> </td>
                                    </tr>
                                    <tr>
                                        <td> अनुगमन प्रतिवेदन :</td>
                                        <td> <input <?php if(in_array('4', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="4"> </td>
                                    </tr>
                                    <tr>
                                        <td> सामाग्रि खरिदको रित पुर्वकको विल :</td>
                                        <td> <input <?php if(in_array('5', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="5"></td>
                                    </tr>
                                    <tr>
                                        <td> उपभोक्ता समितिको निवेदन :</td>
                                        <td> <input <?php if(in_array('6', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="6"></td>
                                    </tr>
                                    <tr>
                                        <td> डोर हाजिर फाराम :</td>
                                        <td> <input <?php if(in_array('7', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="7"> </td>
                                    </tr>
                                    <tr>
                                        <td> सार्वजनिक परिक्षणको प्रतिवेदन </td>
                                        <td> <input <?php if(in_array('8', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="8"></td>
                                    </tr>
                                    <tr>
                                        <td> निर्माण पुर्व  संचालन चरण कार्यसम्पन्न पश्चातको अवस्थाको निमार्ण स्थलमा प्राविधिकको उपस्थिति सहितको फोटो</td>
                                        <td> <input <?php if(in_array('9', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="9"> </td>
                                    </tr>
                                    <tr>
                                        <td> कार्यसम्पन्न भएको भनि सम्बन्धित वडाको सिफारिस पत्र </td>
                                        <td> <input <?php if(in_array('10', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="10"> </td>
                                    </tr>
                                    <tr>
                                        <td> म्याद थप गर्नु पर्नेमा म्याद थपको पत्र संलग्न भएको  नभएको </td>
                                        <td> <input <?php if(in_array('11', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="11"> </td>
                                    </tr>
                                    <tr>
                                        <td> योजना सम्पन्न गनु पर्ने म्याद भित योजना सम्पन्न भएको नभएको </td>
                                        <td> <input <?php if(in_array('12', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="12"> </td>
                                    </tr>
                                    <tr>
                                        <td> भवन, ट्रस्ट, मठ, मन्दिर, विद्यालय, भ्यु टावर आदी जस्ता नक्सा पास तथा निर्माण कार्यको अनुमति लिनु पर्ने प्रकृतिका कार्यहरुमा नक्सा पास भएको र निर्माण कार्यको अनुमति लिएको प्रमाण </td>
                                        <td> <input <?php if(in_array('13', $paper_array)){echo 'checked="checked"';} ?> type="checkbox" name="paper[]" value="13"> </td>
                                    </tr>
                                </table>
                            </div>
                        </form>      
                            <div class="myspacer20"></div>
                            <div class="oursignature" style="margin-left:245px"><br/>
                            <?php echo $workers->post_name?></br>
                            <?php echo $workers->authority_name?>
                                                                                        
                            </div>
                        </div>
                        <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                    </div>
                </div>
            </div>
        </div><!-- main menu ends -->
    </div><!-- top wrap ends -->
   