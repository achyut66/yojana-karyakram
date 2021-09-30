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
// print_r($data2);
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
    $worker5 = Workerdetails::find_by_id($print_history->worker6);
    $worker5 = Workerdetails::find_by_id($print_history->worker7);
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
    if(empty($worker6))
    {
        $worker6 = Workerdetails::setEmptyObject();
    }
    if(empty($worker7))
    {
        $worker7 = Workerdetails::setEmptyObject();
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
$time_add = Plantimeadditionaffiliation::find_by_plan_period(1,$_GET['id']);
$final_bhuk = Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
// print_r($final_bhuk);
$analysis_bhuk = Analysisbasedwithdraw::find_by_payment_count(1,$_GET['id']);
// print_r($final_bhuk);
?>
<!-- js ends -->
<title>विषय:- योजना फरफारक गरी भुक्तानी सम्वन्धमा। print page:: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent" >
            <h2 class="headinguserprofile">विषय:- योजना फरफारक गरी भुक्तानी सम्वन्धमा।<a href="<?=$link?>" class="btn">पछि जानुहोस </a></h2>
            <div class="OurContentFull" >
                <form method="get" action="amanat_bhuktani_patra_print.php?>" target="_blank" >
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
                              <div class="subject">   <u>विषय:- योजना फरफारक गरी भुक्तानी सम्वन्धमा।</u></div>
                              <div class="bankname">श्रीमान,</div>
                              <div class="banktextdetails">
                               <strong><?php echo SITE_LOCATION;?></strong>बाट आ.व. <strong><?php echo convertedcit($fiscal->year)?></strong> अन्तर्गत तपशिलमा उल्लेखित योजनाको निर्माण तथा मर्मत कार्य सञ्चालन हुँदै आइरहेकोमा कार्य सम्पन्न भई निम्न कागजात संलग्न राखी प्राविधिकवाट मूल्याङ्कन भई ठेक्का विल साथ कार्य सम्पन्न प्रतिवेदन संलग्न राखी पेश हुन आएको हुँदा विल बमोजिमको रकम भुक्तानी दिने सम्वन्धमा निर्णायार्थ पेश गरेको छु ।
                              </div>
                             </thead> 
                             <div class="myspacer"></div>
                             <div class="text"><strong><u>संलग्न कागजातहरूः</u></strong></div>
                             <div class="text" style="margin-left: 35px;">
                                १. योजनाको स्वीकृत लागत अनुमान, कार्यालय र समिति बिच भएको सम्झौता पत्र । <br>
                                २. कार्य सम्पन्न भएको भनि भुक्तानी माग गर्ने निर्णय र सम्बन्धित वडा कार्यालयको सिफारिस पत्र । <br>
                                ३. सार्वजनिक परीक्षण फाराम एवं कार्य सम्पन्न भएको फोटो। <br>
                                ४. प्राविधिकबाट पेश भएको ठेक्का विल तथा कार्य सम्पन्न मूल्याङ्कन प्रतिवेदन फाराम । <br>
                                ५. म्याद थपको निर्णय तथा म्याद थप पत्रको टिप्पणी (म्याद समाप्त भएकोमा) । <br>
                                ६. अनुगमन तथा फरफारक समितिको निर्णय प्रतिलिपि ।<br>
                             </div>
                          <div class="myspacer"></div>
                          <div class="text-center"><strong>योजना र वजेट सम्बन्धि विवरण:</strong></div>
                          <div class="container">
                            <table class="table table-responsive table-bordered" style="width: 100%;">
                              <tr>
                                <td></td>
                                <td>वजेट उपशिर्षक नं.</td>
                                <td></td>
                              </tr>
                              <tr>
                                <td>१.</td>
                                <td>आ.व.</td>
                                <td><?php echo convertedcit($fiscal->year)?></td>
                              </tr>
                              <tr>
                                <td>२.</td>
                                <td>आयोजनाको नाम</td>
                                <td><?php echo $data1->program_name;?></td>
                              </tr>
                              <tr>
                                <td>३.</td>
                                <td>आयोजना संचालन भएको स्थान</td>
                                <td><?php echo $data3->organizer_name_address;?></td>
                              </tr>
                              <tr>
                                <td>४.</td>
                                <td>अमानतबाट कार्य गर्नेको नाम र पद</td>
                                <td><?php echo $data3->organizer_name.' '.'('.$data3->organizer_name_post.')';?></td>
                              </tr>
                              <tr>
                                <td>५.</td>
                                <td>सम्झौता मिति</td>
                                <td><?php echo convertedcit($data3->yojana_samjhauta_date);?></td>
                              </tr>
                              <tr>
                                <td>६.</td>
                                <td>काम सम्पन्न गर्नु पर्ने मिति</td>
                                <td><?php echo convertedcit($data3->yojana_sakine_date);?></td>
                              </tr>
                              <tr>
                                <td>७.</td>
                                <td>म्याद थप भएको मिति</td>
                                <td><?php echo convertedcit($time_add->extended_date);?></td>
                              </tr>
                              <tr>
                                <td>८.</td>
                                <td>कार्य सम्पन्न भएको मिति</td>
                                <td><?php echo convertedcit($final_bhuk->plan_end_date);?></td>
                              </tr>
                              <tr>
                                <td>९.</td>
                                <td>संझौता वमोजिम लागत अंक</td>
                                <td><?php echo convertedcit($data2->total_investment);?></td>
                              </tr>
                              <tr>
                                <td>१०.</td>
                                <td>विनियोजित रकम</td>
                                <td><?php echo convertedcit($data2->agreement_gauplaika);?></td>
                              </tr>
                              <?php if(!empty($analysis_bhuk)){?>}
                              <tr>
                                <td>११.</td>
                                <td>रनिङ्ग विल भुक्तानी रकम</td>
                                <td><?php echo convertedcit($analysis_bhuk->total_paid_amount);?></td>
                              </tr>
                            <?php }else{}?>
                              <tr>
                                <td>१२.</td>
                                <td>प्राविधिक अन्तिम मुल्यांकन</td>
                                <td>
                                <?php 
                                if (!empty($analysis_bhuk)){
                                  echo convertedcit($analysis_bhuk->evaluated_amount); 
                                }else{
                                  echo convertedcit($final_bhuk->plan_evaluated_amount); 
                                }
                                ?>
                                </td>
                              </tr>
                              <tr>
                                <td>१३.</td>
                                <td>जम्मा भुक्तानी गर्नु पर्ने रकम</td>
                                <td>
                                <?php 
                                   if (!empty($analysis_bhuk)){
                                  echo convertedcit($analysis_bhuk->total_paid_amount); 
                                }else{
                                  echo convertedcit($final_bhuk->final_total_paid_amount); 
                                }
                                ?>
                                </td>
                              </tr>
                              <tr>
                                <td>१४.</td>
                                <td>मुल्यांकन गर्ने प्राविधिक</td>
                                <td>
                                  <select name="worker1" class="form-control worker" id="worker_1" >
                                    <option value="">छान्नुहोस्</option>
                                    <?php foreach($workers as $worker){?>
                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                    <?php }?>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td>१५.</td>
                                <td>सिफारीस तथा रूजु गर्ने ईन्जिनियरको नाम</td>
                                <td>
                                  <select name="worker2" class="form-control worker" id="worker_2" >
                                    <option value="">छान्नुहोस्</option>
                                    <?php foreach($workers as $worker){?>
                                        <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                    <?php }?>
                                  </select>
                                </td>
                              </tr>
                            </table>
                          </div>
                           <div class="myspacer20"></div>
                           <div class="oursignature mymarginright"><br> 
                            <select name="worker3" class="form-control worker" id="worker_3" >
                                <option value="">छान्नुहोस्</option>
                                <?php foreach($workers as $worker){?>
                                    <option value="<?=$worker->id?>" <?php if($print_history->worker3 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="post" class="form-control" id="post_3" value="<?=$worker3->post_name?>">
                        </div>
                        <div class="myspacer"></div>
                        <div class="bankname">श्रीमान,</div>
                              <div class="banktextdetails">
                               उक्त योजना स्वीकृत कार्यक्रम अन्तर्गत सम्झौता र कार्यान्वयन भई कार्य सम्पन्न प्रतिवेदन तथा योजना शाखाको सिफारीस साथ भुक्तानी माग भई आएकोले भुक्तानी दिन सिफारीस गर्दछु ।
                              </div>
                        </div>
                        <div class="myspacer20"></div>
                        <div class="oursignature mymarginright"><br> 
                            <select name="worker4" class="form-control worker" id="worker_4" >
                                <option value="">छान्नुहोस्</option>
                                <?php foreach($workers as $worker){?>
                                    <option value="<?=$worker->id?>" <?php if($print_history->worker4 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="post" class="form-control" id="post_4" value="<?=$worker4->post_name?>">
                        </div>
                        <div class="oursignatureleft">योजना शाखा<br> 
                            <select name="worker5" class="form-control worker" id="worker_5" >
                                <option value="">छान्नुहोस्</option>
                                <?php foreach($workers as $worker){?>
                                    <option value="<?=$worker->id?>" <?php if($print_history->worker5 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="post" class="form-control" id="post_5" value="<?=$worker5->post_name?>">
                        </div>
                        <div class="myspacer"></div>
                        <div class="bankname">श्रीमान,</div>
                              <div class="banktextdetails">
                               आ.व. <strong><?php echo convertedcit($fiscal->year);?></strong> को स्वीकृत बार्षिक कार्यक्रम र वजेट अनुसार कार्यालयले तयार गरेको लागत अनुमानको आधारमा योजना संझौता र कार्य सम्पन्न भएको भनि वडा र प्राविधिक शाखावाट कार्य सम्पन्न प्रतिवेदन साथ भुक्तानीको लागि सिफारीस भएकोले भुक्तानीको लागि सिफारीस गर्दछु ।
                              </div>
                        <div class="myspacer"></div>
                        <div class="oursignature mymarginright">सदर गर्ने<br> 
                            <select name="worker6" class="form-control worker" id="worker_6" >
                                <option value="">छान्नुहोस्</option>
                                <?php foreach($workers as $worker){?>
                                    <option value="<?=$worker->id?>" <?php if($print_history->worker6 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="post" class="form-control" id="post_6" value="<?=$worker6->post_name?>">
                        </div>
                        <div class="oursignatureleft">आर्थिक प्रशासन शाखा<br> 
                            <select name="worker7" class="form-control worker" id="worker_7" >
                                <option value="">छान्नुहोस्</option>
                                <?php foreach($workers as $worker){?>
                                    <option value="<?=$worker->id?>" <?php if($print_history->worker7 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                <?php }?>
                            </select>
                            <input type="text" name="post" class="form-control" id="post_7" value="<?=$worker7->post_name?>">
                        </div>
                    </div>
                    <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                </div>
            </div>
        </div>
    </div><!-- main menu ends -->
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>