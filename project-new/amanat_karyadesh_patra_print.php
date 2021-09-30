<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();
?>
<?php $data1=  Plandetails1::find_by_id($_GET['id']);
$data2= AmanatLagat::find_by_plan_id($_GET['id']);
$data3= Amanat_more_details::find_by_plan_id($_GET['id']);   
$data4= Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
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
$print_history->worker3 = $_GET['worker3'];
$print_history->worker4 = $_GET['worker4'];
$print_history->worker5 = $_GET['worker5'];
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
if(!empty($_GET['worker5']))
{
    $worker5 = Workerdetails::find_by_id($_GET['worker5']);
}
else
{
    $worker5 = Workerdetails::setEmptyObject();
}
?>
<?php $invest_details =  Plantotalinvestment::find_by_plan_id($_GET['id']); 
if(empty($invest_details))
{
    $invest_details = Plantotalinvestment::setEmptyObjects();
}
!empty($invest_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस";
?>
<?php include("menuincludes/header1.php"); ?>
<?php $data=  Plandetails1::find_by_id($_GET['id']); 

?>
<title>विषय:- कायदिश दिईएको सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?>.</title>
</head>
<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
           <div class="printPage">
               <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                          <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                           <h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                           <h5 class="margin1em letter_title_three"><?php echo SITE_FIRST_NAME?>, <?php echo SITE_ZONE?></h5>
                           <h5 class="margin1em letter_title_four"><?php echo SITE_SECONDSUBHEADING?></h5>
               <div class="myspacer"></div>
               <div class="subjectbold letter_subject style="margin-left:2px"></div>
               <div class="myspacer"></div>
               <div class="printContent">
                  <div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
                  <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
                  <div class="myspacer20"></div>
                  <div class="subject">   <u>विषय:- कायदिश दिईएको सम्बन्धमा ।</u></div>
                  <div class="myspacer"></div>
                  <div class="bankname">श्रीमान् </div>
                  <div class="myspacer"></div>
                  <div class="banktextdetails">
                              प्रस्तुत विषयमा <strong><?php echo SITE_LOCATION;?></strong> वडा नं. <strong><?php echo convertedcit($data1->ward_no)?></strong> स्थित <strong><?php echo $data1->program_name;?></strong> कार्य योजनाको लागि लागत अनुमान तयार गर्दा रू.<strong><?php echo convertedcit($data2->total_investment);?></strong> भएकोमा मिति <strong><?php echo convertedcit($data3->yojana_samjhauta_date)?></strong> गतेको निर्णयानुसार सो कार्य गर्न <strong><?php echo SITE_LOCATION;?></strong>को तर्फबाट रू. <strong><?php echo convertedcit($data2->agreement_gauplaika)?></strong> व्यहोर्ने गरि कार्य गर्नु हुन र भुक्तानीका लागि <strong><?php echo convertedcit($data3->yojana_sakine_date)?></strong> सम्ममा नियमानुसारको बिल भरपाई, सार्वजनिक परिक्षण, वडा कार्यालयको कार्य सम्पन्न सिफारिस र फोटो समेत संलग्न राखि पेश गर्नु हुन लागत अनुमान पाना थान १ यसै पत्रसाथ राखी तपाईलाई यो कायदिश दिईएको छ ।
                              </div>
                            <div class="myspacer20"></div>
                            <div>
                                कार्य सम्पन्न गर्नुपर्ने मिति : <strong><?php echo convertedcit($data3->yojana_sakine_date);?></strong>
                              </div>
                           <div class="myspacer30"></div>
                           <div class="oursignature mymarginright" style="margin-right:35px" > सदर गर्ने <br>
                              <?php 
                              if(!empty($worker1))
                              {
                                  echo $worker1->authority_name."<br/>";
                                  echo $worker1->post_name;
                              }
                              ?>
                          </div>
                           <div>
                            <div class="myspacer20"></div>
                          <strong>
                            <u>बोधार्थः</u>
                          </strong>
                          <p>१). श्री आर्थिक प्रशासन शाखा, 
                                <strong><?php echo SITE_LOCATION;?></strong>। <span>(जानकारी तथा भुक्तानीका लागी)</span>
                          </p>
                          <p>२) श्री <strong><?php echo convertedcit($data1->ward_no)?></strong> नं. वडा कार्यालय, 
                                <strong><?php echo SITE_LOCATION;?></strong>। <span>(जानकारीको लागि) </span>
                          </p>
                          <p>३).
                            <label>
                              <?php 
                              if(!empty($worker2))
                              {
                                  echo $worker2->authority_name;
                              }
                              ?>
                          </label>
                            (<strong><?php echo $worker2->post_name;?></strong>) <span>(आवश्यक सुपरभिजन गर्नहुन)</span>
                          </p>
                          <p>४).
                            <label>
                              <?php 
                              if(!empty($worker3))
                              {
                                  echo $worker3->authority_name;                                  
                              }
                              ?>
                          </label>
                            (<strong><?php echo $worker3->post_name;?></strong>) <span>(आवश्यक सुपरभिजन गर्नहुन)</span>
                          </p>
                        </div>
</div>
</div>
</div>
