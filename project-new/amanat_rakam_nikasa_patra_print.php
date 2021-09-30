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
<title>विषय:- कायदिश दिईएको सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?>.</title>
</head>
<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
           <div class="printPage">
               <div class="subjectbold letter_subject style="margin-left:2px"></div>
               <div class="myspacer"></div>
               <div class="printContent">
                  <div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
                  <div class="chalanino">श्री <strong><?php echo SITE_LOCATION;?></strong>,</div>
                              <div class="chalanino"><strong><?php echo SITE_HEADING;?></strong>,</div>
                              <div class="chalanino"><strong><?php echo SITE_FIRST_NAME;?>, <?php echo SITE_ZONE;?></strong></div>
                              <div class="myspacer"></div>
                              <div class="subject">   <u>विषय:- रकम निकासा सम्बन्धमा ।</u></div>
          
                              <div class="banktextdetails">
                                निम्न विवरण खुलाई माग पत्र पेश गरेको छु । माग बमोजिम नियमानुसार रकम निकासाको लागि अनुरोध गर्दछु ।
                                <div class="myspacer"></div>
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
                              <div class="myspacer"></div>
                              <div class="oursignature mymarginright" style="margin-top: -65px;">
                              <u>निवेदक</u><br>
                              नाम, थर:- <strong><?php echo $data3->organizer_name?></strong><br>
                              ठेगानाः- <strong><?php echo $data3->organizer_name_address?></strong><br>
                              दर्जाः- <strong><?php echo $data3->organizer_name_post?></strong>
                              </div>
                              <div class="myspacer"></div>
                              <hr>
                              श्रीमान्,<br>
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
                              <div class="myspacer"></div>
                              <div><u>थप विवरण:-</u></div>
                              
                                श्रीमान्,<br>
                                <div class="banktextdetails">
                                  सामान निकासा <strong><?php echo $_GET['jinsi_item']?></strong> भएकोले सिफारिस गर्दछु । </span>
                                </div>
                              </div>
                              <div class="oursignature mymarginright" style="margin-top: -45px;">जिन्सी शाखा<br> 
                                <?php 
                                if(!empty($worker2))
                                {
                                    echo $worker2->authority_name."<br/>";
                                    echo $worker2->post_name;
                                }
                                ?>
                            </div>
                            <div class="myspacer"></div>
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
                            <?php 
                              if(!empty($worker1))
                              {
                                  echo $worker1->authority_name."<br/>";
                                  echo $worker1->post_name;
                              }
                            ?>
                        </div>
                        <div class="myspacer"></div>
                        <div class="oursignature mymarginright"><br> 
                            <?php 
                                if(!empty($worker4))
                                {
                                    echo $worker4->authority_name."<br/>";
                                    echo $worker4->post_name;
                                }
                                ?>                        
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