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
// print_r($data3);
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
<?php 
$advance = Planstartingfund::find_by_plan_id($_GET['id']);
// print_r($advance);
$antim_bhuk = Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
// print_r($antim_bhuk);
$mul_bhuk = Analysisbasedwithdraw::find_by_payment_count(1,$_GET['id']);
// print_r($mul_bhuk);
?>
<?php if(!empty($mul_bhuk)){
  $noti = "सम्पन्न";
}elseif(!empty($antim_bhuk)){
  $noti = "सम्पन्न";
}else{
  $noti = "सम्पन्न";
} 
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>विषय:- रकम निकासा सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>
<style type="text/css">
  ::placeholder{
    color:red;
  }
</style>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent" >
            <h2 class="headinguserprofile">विषय:- रकम निकासा सम्बन्धमा ।<a href="<?=$link?>" class="btn">पछि जानुहोस </a></h2>
            <div class="OurContentFull" >
                <form method="get" action="amanat_rakam_nikasa_patra_print.php?>" target="_blank" >
                    <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                    <div class="userprofiletable" id="div_print">
                       <div class="printPage">
                           <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                           <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
                           <h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
                           <h5 class="margin1em letter_title_three"><?php echo SITE_FIRST_NAME?>, <?php echo SITE_ZONE?></h5>
                           <h5 class="margin1em letter_title_four"><?php echo SITE_SECONDSUBHEADING?></h5>
                           <div class="myspacer"></div>
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
                              <div class="chalanino">श्री <strong><?php echo SITE_LOCATION;?></strong>,</div>
                              <div class="chalanino"><strong><?php echo SITE_HEADING;?></strong>,</div>
                              <div class="chalanino"><strong><?php echo SITE_FIRST_NAME;?>, <?php echo SITE_ZONE;?></strong></div>
                              <div class="myspacer20"></div>
                              <div class="subject">   <u>विषय:- रकम निकासा सम्बन्धमा ।</u></div>
          
                              <div class="banktextdetails">
                                निम्न विवरण खुलाई माग पत्र पेश गरेको छु । माग बमोजिम नियमानुसार रकम निकासाको लागि अनुरोध गर्दछु ।
                                <div class="myspacer20"></div>
                                <div>
                                  १)  योजनाको नामः <strong><?php echo $data1->program_name;?></strong> गर्ने कार्य वडा नं.:- <strong><?php echo convertedcit($data1->ward_no)?></strong> स्थानः- <strong><?php echo $data3->place_to_organize;?></strong> आ.व.: <strong><?php echo convertedcit($fiscal->year)?></strong> ल.ई. अङ्क: रु. <strong><?php echo convertedcit($data2->total_investment)?></strong> न.पा. बाटः रू. <strong><?php echo convertedcit($data2->agreement_gauplaika)?></strong> उपभोक्ता लागत सहभागिता <strong><?php echo convertedcit($data2->costumer_agreement)?></strong> जनश्रमदानः रू. <strong><?php echo convertedcit($data2->costumer_investment)?></strong>
                                </div>
                                <div>
                                  २)  हालसम्म निकासा भएको रकम रु. <strong>
                                    <?php if(!empty($mul_bhuk)){?>
                                      <?php echo convertedcit($mul_bhuk->total_paid_amount)?>
                                        <?php }else{
                                      echo convertedcit($advance->advance);
                                }?>
                                </strong> 
                                <?php if(!empty($advance)){?>
                                  (<?php echo convertedcit($advance->advance).' '.'पेस्की रकम'?>)   
                                <?php }else{

                                }?>
                                 जम्मा स्विकृत रकम रु. <strong><?php echo convertedcit($data2->total_investment)?></strong> माग गरेको रकम रु. 
                                 <strong>
                                  <?php 
                                  if(!empty($mul_bhuk)){
                                      echo convertedcit($data2->total_investment-$mul_bhuk->total_paid_amount);
                                  }else{
                                      echo convertedcit($data2->total_investment-$advance->advance);
                                  }?>   
                                  </strong> 
                                  यसपछि बाँकी रहन जाने रकम छैन।
                                </div> 
                                <div>
                                  ३)  हालसम्म योजनाको प्रगति विवरणः- <strong>"<?php echo $noti;?>"</strong>
                                </div>
                                <div class="myspacer"></div>
                                  <div>
                                  ४).संलग्न कागजातहरू:- <strong><?php echo $antim_bhuk->doc_name?></strong></div>  
                                  <div>
                                  ५).अन्य खुलाउनुपर्ने विवरणः- <strong><?php echo $antim_bhuk->other_kaifiyet?></strong>
                                  </div>
                              <div class="myspacer20"></div>
                              <div class="oursignature mymarginright">
                              <u>निवेदक</u><br>
                              नाम, थर:- <strong><?php echo $data3->organizer_name?></strong><br>
                              ठेगानाः- <strong><?php echo $data3->organizer_name_address?></strong><br>
                              दर्जाः- <strong><?php echo $data3->organizer_name_post?></strong>
                              </div>
                              <div class="myspacer20"></div>
                              <hr>
                              <div class="text">श्रीमान्,</div>
                              <p class="banktextdetails">
                                मिति <strong><?php echo convertedcit($data3->yojana_samjhauta_date)?></strong> गतेको निर्णय अनुसार <strong><?php echo $data1->program_name;?></strong> योजनाको लागि रू. <strong><?php echo convertedcit($data2->total_investment)?></strong> छुट्टिएकोमा स्थलगत निरीक्षण गरी मूल्याङ्कन गर्दा रू.<strong>
                                  <?php if(!empty($mul_bhuk)){
                                      echo convertedcit($mul_bhuk->evaluated_amount);
                                    }else{
                                      echo convertedcit($antim_bhuk->plan_evaluated_amount);
                                    }
                                    ?>
                                </strong> हुन आएको र संलग्न प्रतिवेदन / विल बमोजिम 
                                <strong>
                                  <?php if(!empty($mul_bhuk)){
                                    echo convertedcit(number_format($mul_bhuk->evaluated_amount/$data2->total_investment*100),2).'%';
                                  } else{
                                    echo convertedcit(number_format($antim_bhuk->plan_evaluated_amount/$data2->total_investment*100),2).'%';
                                  }?>
                                </strong>
                                 प्रतिशत काम भएको, मनासिव नै देखिएकाले <strong><?php echo $data3->organizer_name_post?></strong> श्री <strong><?php echo $data3->organizer_name?></strong>लाई भुक्तानी गर्नुपर्ने रू.
                                    <strong><?php if(!empty($mul_bhuk)){
                                      echo convertedcit($mul_bhuk->total_paid_amount);
                                    }else{
                                      echo convertedcit($antim_bhuk->final_total_paid_amount);
                                    }?></strong>
                                  (नियमानुसार लाग्ने कर कट्टा गर्न बाँकी) निकासाको लागि सिफारिस गर्दछु ।
                              </p>
                              <div class="myspacer20"></div>
                              <div><u>थप विवरण:-</u></div>
                              <form method="get" action="amanat_rakam_nikasa_patra_print.php">
                              <div>
                                श्रीमान्,<br>
                                <div class="banktextdetails">
                                  सामान निकासा <span><label><input type="text" name="jinsi_item" placeholder="यहाँ लेख्नुहोस" /></label></span>
                                  ____<span>भएकोले सिफारिस गर्दछु । </span>
                                </div>
                              </div>
                            </form>
                              <div class="oursignature mymarginright">जिन्सी शाखा<br> 
                                <select name="worker2" class="form-control worker" id="worker_2" >
                                    <option value="">छान्नुहोस्</option>
                                    <?php foreach($workers as $worker){?>
                                        <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                    <?php }?>
                                </select>
                                <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                            </div>
                            <div class="myspacer20"></div>
                            <div>
                                श्रीमान्,<br>
                                <div class="banktextdetails">
                                  यस योजनाको लागि छुट्टिएको रकम रू <strong><?php echo convertedcit($data2->total_investment)?></strong> मध्ये हालसम्म निकासा भएको रू 
                                    <strong><?php if(!empty($mul_bhuk)){
                                      echo convertedcit($mul_bhuk->total_paid_amount);
                                    }else{
                                      echo convertedcit($antim_bhuk->final_total_paid_amount);
                                    }?></strong>
                                   कटाई  अब बाँकी रू  
                                   <strong>
                                  <?php 
                                    echo convertedcit($data2->total_investment-$mul_bhuk->total_paid_amount-$antim_bhuk->final_total_paid_amount);
                                  ?>   
                                  </strong> 
                                   प्राविधिक शाखाबाट सिफारिस भै आएको संलग्न कागजातको आधारमा भुक्तानी गर्न मनासिव देखिएकोले पेश गर्दछु ।
                                </div>
                              </div>
                             </thead> 
                           <div class="myspacer20"></div>
                           <div class="oursignature mymarginright">आर्थिक प्रशासन शाखा<br> 
                            <select name="worker1" class="form-control worker" id="worker_1" >
                                <option value="">छान्नुहोस्</option>
                                <?php foreach($workers as $worker){?>
                                    <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                        </div>
                        <div class="myspacer20"></div>
                        <div class="oursignature mymarginright">सदर गर्ने<br> 
                            <select name="worker4" class="form-control worker" id="worker_4" >
                                <option value="">छान्नुहोस्</option>
                                <?php foreach($workers as $worker){?>
                                    <option value="<?=$worker->id?>" <?php if($print_history->worker4 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="post" class="form-control" id="post_4" value="<?=$worker4->post_name?>">
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