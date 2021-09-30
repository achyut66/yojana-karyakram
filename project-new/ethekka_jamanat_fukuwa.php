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
$data2= Ethekka_lagat::find_by_plan_id($_GET['id']);
$data3= Ethekkainfo::find_by_plan_id($_GET['id']);
$fiscal = Fiscalyear::find_by_sql("select * from fiscal_year where is_current=1");
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
$thekka_lagat = Ethekka_lagat::find_by_plan_id($_GET['id']);
$ethekka_info = Ethekkainfo::find_by_plan_id($_GET['id']);
//echo "<pre>";
//print_r($ethekka_info);
?>
    <!-- js ends -->
    <title>विषय:- कार्य सम्पादन जमानत फुकुवा सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>
    </head>
    <body>
<?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
        <div class="maincontent" >
            <h2 class="headinguserprofile">विषय:- कार्य सम्पादन जमानत फुकुवा सम्बन्धमा ।<a href="<?=$link?>" class="btn">पछि जानुहोस </a></h2>
            <div class="OurContentFull" >
                <form method="get" action="ethekka_jamanat_fukuwa_print.php?>" target="_blank" >
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
                                <div class="chalanino">योजना दर्ता नं : <strong><?php echo convertedcit($_GET['id'])?></strong></div>
                                <div class="chalanino">पत्र संख्या :<strong><?php echo convertedcit($fiscal->year)?></strong></div>
                                <div class="chalanino">चलानी नं :</div><br>
                                <br>
                                <div class="chalanino">श्री <strong><?php echo $ethekka_info->bank_name?></strong>
                                </div>
                                <div>शाखा कार्यालय , <strong><?php echo $ethekka_info->bank_address?></strong>।</div>
                                <div class="myspacer20"></div>
                                <div class="subject">   <u>विषय:- कार्य सम्पादन जमानत फुकुवा सम्बन्धमा ।</u></div>
                                <div class="banktextdetails">
                                    प्रस्तुत विषयमा यस <strong><?php echo SITE_LOCATION;?></strong> को बोलपत्र सुचना नं. <strong><?php echo $ethekka_info->thekka_no;?></strong>
                                    <strong><?php echo $data1->program_name?>, <?php echo $ethekka_info->place_to_organize;?></strong> खरिद कार्यको
                                    ठेक्का सम्झौता प्रक्रियामा गईसकेकोले सो कार्यका लागी त्यस बैंक मार्फत जारी भएको कार्य सम्पादन बैंक जमानत नम्बर
                                    <strong><?php echo $ethekka_info->dharauti_no?></strong>,रु. <strong><?php echo convertedcit($ethekka_info->dharauti_amt)?></strong>।- को श्री <strong><?php echo $ethekka_info->firm_name?>,<?php echo $ethekka_info->firm_address?></strong>
                                    को Performance Bank Guarantee
                                    फुकुवा गरिदिनुहुन अनुरोध छ ।
                                </div>
                                <div class="myspacer30"></div>
                                <div class="oursignature mymarginright">सदर गर्ने<br/>
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