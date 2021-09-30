<?php require_once("includes/initialize.php"); ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>विषय:- ।
    <?php echo SITE_SUBHEADING;?>
</title>
<?php 
if(!isset($_SESSION['set_plan_id']))
{
    die("कृपया योजनासंचालन मार्फत पत्र प्रिन्ट गर्नुहोस");
}
$workers = Workerdetails::find_by_id(1);
$date_selected= $_GET['date_selected'];
//$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
//print_r($print_history);
if(empty($print_history))
{
    $print_history = new PrintHistory;
}
// $print_history->url = get_base_url();
// $print_history->nepali_date = $date_selected;
$print_history->english_date = DateNepToEng($date_selected);
$print_history->user_id = $user->id;
$print_history->plan_id = $_GET['id'];
$print_history->worker1 = $_GET['worker1'];
$print_history->worker2 = $_GET['worker2'];

$print_history->worker3 = $_GET['worker3'];
$print_history->worker4 = $_GET['worker4'];

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
if(!empty($_GET['worker3']))
{
$worker3 = Workerdetails::find_by_id($_GET['worker3']);
}
else
{
    $worker3 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker4']))
{
$worker4 = Workerdetails::find_by_id($_GET['worker4']);
}
else
{
    $worker4 = Workerdetails::setEmptyObject();
}
$_GET['id']= $_SESSION['set_plan_id'];
$ward_address = WardWiseAddress();
$address = getAddress();
$fiscal = Fiscalyear::find_current_id();
$fiscal_selected = Fiscalyear::find_by_id($fiscal);
  $customer=Costumerassociationdetails0::find_by_plan_id($_GET['id']);
  $customer_details=Costumerassociationdetails::find_by_plan_id($_GET['id']);
  $plan_details = Plandetails1::find_by_id($_GET['id']);
  $more_details = MorePlanDetails::find_by_plan_id($_GET['id']);
  //print_r($more_details); exit;
 // print_r($_POST['paper']);exit;

if(isset($_POST['submit']) && !empty($_POST['paper']))
{
    $_POST['paper'] = $_POST['paper'];
    $plan_id = $_SESSION['set_plan_id'];
    $document_all = implode("-",$_POST['paper']);
    $bill_details = new LetterBill();
    $bill_details->date = date('Y-m-d',time());
    $bill_details->plan_id = $plan_id;
    $bill_details->documents= $document_all;
    $bill_details->save();
   // print_r($_POST['paper']);exit;
}
 elseif(empty ($_POST['paper'])) 
{
       die('कृपया कागजात छानेर मात्र प्रिन्ट गर्नुहोस');    
}
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
         <div class="mydate">मिति : <?= convertedcit($_POST['date_selected'])  ?> </div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal_selected->year); ?></div>
										 <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino">चलानी नं: </div>
                            <div class="subject"> विषय:- प्राविधिक मूल्याकनको आधारमा रनिङ बिल र अन्तिम विल भुक्तानी गर्ने सम्बन्धमा ।</div><br>
                            <div> श्रीमान्  </div>
                            <div class="banktextdetails">
                              यस कार्यालयको स्वीकृत वार्षिाक कार्यक्रम अनुसार मिति  <?=convertedcit($more_details->miti)?> मा यस कार्यालय र गजुरी गाउँपालिका वडा नं. <?= convertedcit($customer->program_organizer_group_address) ?> को <?= convertedcit($customer->program_organizer_group_name) ?> विच सम्झौता भई कार्यादेश दिईएकोमा निम्नानुसारका आवश्यक कागजातहरु सलग्न रहेको हुदा रनिङ विल भुक्तानी / अन्तिम विल भुक्तानीको लागि निर्णयार्थ पेश गरेको छु । 
                            </div>
                            <div>
                                 <table class="table myWidth100 table-bordered">
                                    <tr>
                                        <td style="width:90%;"><b> आवश्यक कागजातहरु </b></td>
                                        <td> <b> संलग्न / भएको नभएको</b> </td>
                                    </tr>
                                    <tr>
                                        <td> उपभोक्ता समिति गठनको निर्णय :</td>
                                        <td> <input type="checkbox" <?php if(in_array("1",$_POST['paper'])){echo 'checked="checked"';} ?> name="paper[]" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td> स्वीकृत स्पेसिफिकेशन तथा लागत अनुमान र नक्सा :</td>
                                        <td> <input type="checkbox" <?php if(in_array("2",$_POST['paper'])){echo 'checked="checked"';} ?> name="paper[]" value="2"> </td>
                                    </tr>
                                    <tr>
                                        <td> ठेका बिल  </td>
                                        <td> <input type="checkbox" <?php if(in_array("3",$_POST['paper'])){echo 'checked="checked"';} ?> name="paper[]" value="3"> </td>
                                    </tr>
                                    <tr>
                                        <td> अनुगमन प्रतिवेदन :</td>
                                        <td> <input type="checkbox" <?php if(in_array("4",$_POST['paper'])){echo 'checked="checked"';} ?> name="paper[]" value="4"> </td>
                                    </tr>
                                    <tr>
                                        <td> सामाग्रि खरिदको रित पुर्वकको विल :</td>
                                        <td> <input type="checkbox" name="paper[]" <?php if(in_array("5",$_POST['paper'])){echo 'checked="checked"';} ?> value="5"></td>
                                    </tr>
                                    <tr>
                                        <td> उपभोक्ता समितिको निवेदन :</td>
                                        <td> <input type="checkbox" name="paper[]" <?php if(in_array("6",$_POST['paper'])){echo 'checked="checked"';} ?> value="6"></td>
                                    </tr>
                                    <tr>
                                        <td> डोर हाजिर फाराम :</td>
                                        <td> <input type="checkbox" name="paper[]" <?php if(in_array("7",$_POST['paper'])){echo 'checked="checked"';} ?> value="7"> </td>
                                    </tr>
                                    <tr>
                                        <td> सार्वजनिक परिक्षणको प्रतिवेदन </td>
                                        <td> <input type="checkbox" name="paper[]" <?php if(in_array("8",$_POST['paper'])){echo 'checked="checked"';} ?> value="8"></td>
                                    </tr>
                                    <tr>
                                        <td> निर्माण पुर्व  संचालन चरण कार्यसम्पन्न पश्चातको अवस्थाको निमार्ण स्थलमा प्राविधिकको उपस्थिति सहितको फोटो</td>
                                        <td> <input type="checkbox" name="paper[]" <?php if(in_array("9",$_POST['paper'])){echo 'checked="checked"';} ?> value="9"> </td>
                                    </tr>
                                    <tr>
                                        <td> कार्यसम्पन्न भएको भनि सम्बन्धित वडाको सिफारिस पत्र </td>
                                        <td> <input type="checkbox" name="paper[]" <?php if(in_array("10",$_POST['paper'])){echo 'checked="checked"';} ?> value="10"> </td>
                                    </tr>
                                    <tr>
                                        <td> म्याद थप गर्नु पर्नेमा म्याद थपको पत्र संलग्न भएको  नभएको </td>
                                        <td> <input type="checkbox" name="paper[]" <?php if(in_array("11",$_POST['paper'])){echo 'checked="checked"';} ?> value="11"> </td>
                                    </tr>
                                    <tr>
                                        <td> योजना सम्पन्न गनु पर्ने म्याद भित योजना सम्पन्न भएको नभएको </td>
                                        <td> <input type="checkbox" name="paper[]" <?php if(in_array("12",$_POST['paper'])){echo 'checked="checked"';} ?> value="12"> </td>
                                    </tr>
                                    <tr>
                                        <td> भवन, ट्रस्ट, मठ, मन्दिर, विद्यालय, भ्यु टावर आदी जस्ता नक्सा पास तथा निर्माण कार्यको अनुमति लिनु पर्ने प्रकृतिका कार्यहरुमा नक्सा पास भएको र निर्माण कार्यको अनुमति लिएको प्रमाण </td>
                                        <td> <input type="checkbox" name="paper[]" <?php if(in_array("13",$_POST['paper'])){echo 'checked="checked"';} ?> value="13"> </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="myspacer"></div><br><br>
                            <div class="oursignature" style="margin-right:11px"><br/>
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