<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();
?>
<?php 
$data1= Plandetails1::find_by_id($_GET['id']);
$data2= AmanatLagat::find_by_plan_id($_GET['id']);
$data3= Amanat_more_details::find_by_plan_id($_GET['id']);
//print_r($data3);
$name = "";
$link = get_return_url($_GET['id']);
?>
<?php 
$budget = Topicareainvestmentsource::find_all();
$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
    $worker5 = Workerdetails::find_by_id($print_history->worker5);
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
     if(empty($worker5))
    {
        $worker5 = Workerdetails::setEmptyObject();
    }
}
?>
<?php $invest_details =  Plantotalinvestment::find_by_plan_id($_GET['id']); 

      if(empty($invest_details))
      {
        $invest_details = Plantotalinvestment::setEmptyObjects();
      }
      !empty($invest_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस";
      ?>
<?php include("menuincludes/header.php"); ?>
<?php  
$data1 =  Plandetails1::find_by_id($_GET['id']);
//print_r($data1);
?>
<!-- js ends -->
<title>विषय:- अमानतवाट कार्य गराउने सम्वन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent" >
            <h2 class="headinguserprofile">विषय:- अमानतवाट कार्य गराउने सम्वन्धमा ।<a href="<?=$link?>" class="btn">पछि जानुहोस </a></h2>
            <div class="OurContentFull" >
                <form method="get" action="amanat_tippani_patra_print.php?>" target="_blank" >
                    <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                    <div class="userprofiletable" id="div_print">
                       <div class="printPage">
                           <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                           <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                           <h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                           <h5 class="margin1em letter_title_three"><?php echo SITE_FIRST_NAME?>, <?php echo SITE_ZONE?></h5>
                           <h5 class="margin1em letter_title_four"><?php echo SITE_SECONDSUBHEADING?></h5>
                           <div class="myspacer"></div>
                           <div class="subjectbold letter_subject"><h4><strong>टिप्पणी आदेश</strong></h4></div>
                           <div class="printContent">
                              <div class="mydate">मिति : <input type="text" name="date_selected" value="<?php 
                              if(!empty($print_history->nepali_date))
                              {
                                  echo $print_history->nepali_date;
                              }
                              else
                              {
                                  echo generateCurrDate();
                              }?>" id="nepaliDate5" /></div>
                              <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
                              <div class="myspacer20"></div>
                              <div class="subject">   <u>विषय:- अमानतवाट कार्य गराउने सम्वन्धमा ।</u></div>
                              <div class="bankname">श्रीमान प्रमुख प्रशासकीय ज्यू, </div>
                              <div class="banktextdetails"  >
                               <strong><?php echo SITE_LOCATION;?></strong> <strong><?php echo convertedcit($data1->ward_no)?></strong> नं वडा कार्यालयको च.नं. <strong><?php echo convertedcit($data3->chalani_no)?></strong> मिति <strong><?php echo convertedcit($data3->yojana_samjhauta_date)?></strong> को पत्रानुसार सो <strong><?php echo $data1->program_name;?></strong> कार्यको लागि लागत अनुमान सहित रकम उपलब्ध गराई दिन हुन अनुरोध भई आएकोमा <strong><?php echo $data3->aadesh_per_post;?></strong>वाट <strong><?php echo Topicbudget::getName($data1->budget_id);?></strong>वाट कार्य गराउने आदेश भए वमोजिम उक्त कार्यको लागी तयार भएको लागत अनुमान रू.<strong><?php echo convertedcit($data2->total_investment);?></strong> स्विकृत गरी चालु आर्थिक वर्ष <strong><?php echo convertedcit($fiscal->year)?></strong>  को वार्षिक कार्यक्रमको <strong><?php echo Topicareatype::getName($data1->topic_area_type_id)?></strong> को <strong><?php echo Topicbudget::getName($data1->budget_id);?></strong>वाट खर्च लेख्ने गरी सार्वजनिक खरीद नियमावली २०६४ को नियम ९८ (३) वमोजिम अमानतवाट स्विकृत लागत अनुमान वमोजिम कार्य गर्ने गरी <strong><?php echo $data3->organizer_name;?></strong>लाई कायदिश दिने सम्वन्धमा निर्णयार्थ पेश गर्दछु ।
                              </div>
                             </thead> 
                           <div class="myspacer20"></div>
                           <div class="oursignature mymarginright"> सदर गर्ने  <br> 
                            <select name="worker1" class="form-control worker" id="worker_1" >
                                <option value="">छान्नुहोस्</option>
                                <?php foreach($workers as $worker){?>
                                    <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                        </div>
                        <div class="oursignatureleft mymarginright">तयार गर्ने<br/>
                            <select name="worker2" class="form-control worker" id="worker_2">
                                <option value="">छान्नुहोस्</option>
                                <?php foreach($workers as $worker){?>
                                    <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                        </div>
                        
                        </div>
                        <div class="myspacer"></div>
                    </div>
                    <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                </div>
            </div>
        </div>
    </div><!-- main menu ends -->
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>