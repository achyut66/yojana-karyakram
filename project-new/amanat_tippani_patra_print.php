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
<title>विषय:- अमानतवाट कार्य गराउने सम्वन्धमा । print page:: <?php echo SITE_SUBHEADING;?>.</title>
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
               <div class="subjectbold letter_subject style="margin-left:2px"><h4><strong>टिप्पणी आदेश</strong></h4></div>
               <div class="myspacer"></div>
               <div class="printContent">
                  <div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
                  <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
                  <div class="myspacer20"></div>
                  <div class="subject">   <u>विषय:- अमानतवाट कार्य गराउने सम्वन्धमा ।</u></div>
                  <div class="myspacer"></div>
                  <div class="bankname">श्रीमान् </div>
                  <div class="myspacer"></div>
                  <div class="banktextdetails">
                               <strong><?php echo SITE_LOCATION;?></strong> <strong><?php echo convertedcit($data1->ward_no)?></strong> नं वडा कार्यालयको च.नं. <strong><?php echo convertedcit($data3->chalani_no)?></strong> मिति <strong><?php echo convertedcit($data3->yojana_samjhauta_date)?></strong> को पत्रानुसार सो <strong><?php echo $data1->program_name;?></strong> कार्यको लागि लागत अनुमान सहित रकम उपलब्ध गराई दिन हुन अनुरोध भई आएकोमा <strong><?php echo $data3->aadesh_per_post;?></strong>वाट <strong><?php echo Topicbudget::getName($data1->budget_id);?></strong>वाट कार्य गराउने आदेश भए वमोजिम उक्त कार्यको लागी तयार भएको लागत अनुमान रू.<strong><?php echo convertedcit($data2->total_investment);?></strong> स्विकृत गरी चालु आर्थिक वर्ष <strong><?php echo convertedcit($fiscal->year)?></strong>  को वार्षिक कार्यक्रमको <strong><?php echo Topicareatype::getName($data1->topic_area_type_id)?></strong> को <strong><?php echo Topicbudget::getName($data1->budget_id);?></strong>वाट खर्च लेख्ने गरी सार्वजनिक खरीद नियमावली २०६४ को नियम ९८ (३) वमोजिम अमानतवाट स्विकृत लागत अनुमान वमोजिम कार्य गर्ने गरी <strong><?php echo $data3->organizer_name;?></strong>लाई कायदिश दिने सम्वन्धमा निर्णयार्थ पेश गर्दछु ।
                              </div>
                            <div class="myspacer20"></div>
                            
     <div class="myspacer30"></div>
     <div class="oursignature mymarginright" style="margin-right:60px" > सदर गर्ने <br>
        <?php 
        if(!empty($worker1))
        {
            echo $worker1->authority_name."<br/>";
            echo $worker1->post_name;
        }
        ?>
    </div>
    <div class="oursignatureleft mymarginright" style="margin-left:20px"> आर्थिक प्रशासन शाखा   <br/>
        <?php 
        if(!empty($worker2))
        {
            echo $worker2->authority_name."<br/>";
            echo $worker2->post_name;
        }
        ?>
    </div>
</div>
</div>
</div>
