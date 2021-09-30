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
//print_r($data2);
$data3= Ethekkainfo::find_by_plan_id($_GET['id']);
//print_r($data3);
$fiscal = Fiscalyear::find_by_sql("select * from fiscal_year where is_current=1");
//print_r($fiscal->year);
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
$thekka_lagat = Ethekka_lagat::find_by_plan_id($_GET['id']);
$ethekka_info = Ethekkainfo::find_by_plan_id($_GET['id']);
//print_r($thekka_lagat);
//print_r($data1);
?>
    <!-- js ends -->
    <title>विषय:- कार्यादेश दिईएको बारे । print page:: <?php echo SITE_SUBHEADING;?></title>
    </head>
    <body>
<?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">
        <div class="maincontent" >
            <h2 class="headinguserprofile">विषय:- कार्यादेश दिईएको बारे ।<a href="<?=$link?>" class="btn">पछि जानुहोस </a></h2>
            <div class="OurContentFull" >
                <form method="get" action="ethekka_karyadesh_patra_print.php?>" target="_blank" >
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
                                <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
                                <div class="chalanino">पत्र संख्या : <?php echo convertedcit($fiscal->year)?></div>
                                <div class="chalanino">चलानी नं :</div>
                                <div class="myspacer20"></div>
                                <div class="subject">   <u>विषय:- कार्यादेश दिईएको बारे ।</u></div>
                                <div class="bankname">श्री, <strong><?php echo $ethekka_info->firm_name?></strong></div>
                                <div class="bankname"><strong><?php echo $ethekka_info->firm_address.','?></strong></div>
                                <div class="banktextdetails"  >
                                    उपरोक्त सम्बन्धमा <strong><?php echo $thekka_lagat->anya_nikaya.' '.'र'.' '.SITE_LOCATION;?></strong>को साझेदारी लागत कार्यक्रम
                                    <strong>(<?php echo Topicbudget::getName($data1->budget_id)?>)</strong>
                                    अन्तर्गत <strong><?php echo SITE_LOCATION;?></strong>मा आ.व. <strong><?php echo convertedcit($fiscal->year)?></strong> मा सञ्चालन हुने देहाय बमोजिम आयोजनाको तोकिएको अवधि भित्र
                                    गुणस्तरिय कार्य सम्पन्न गरी नगर कार्यपालिका कार्यालयमा नियमानुसार प्रकृया पुरा गरी भुक्तानी माग गर्नुहुन यो कार्यादेश दिइएको छ ।
                                </div>
                                <div class="myspacer20"></div>
                                <div class="text-left"><u><strong>तपशिल</strong></u></div>
                                <div class="myspacer"></div>
                                    <table class="table table-bordered table-responsive myWidth100">
                                        <tr>
                                            <td>स्वीकृत कार्यक्रम</td>
                                            <td><strong><?php echo $thekka_lagat->anya_nikaya.' '.'र'.' '.SITE_LOCATION;?></strong>को लागत साझेदारी</td>
                                        </tr>
                                        <tr>
                                            <td>आयोजना स्वीकृत आ.व.	</td>
                                            <td><strong><?php echo convertedcit($fiscal->year)?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>आयोजना / कार्यक्रमको नाम </td>
                                            <td><strong><?php echo $data1->program_name.','.' '.$ethekka_info->thekka_no?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>आयोजना स्थल	</td>
                                            <td><strong><?php echo $ethekka_info->place_to_organize?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>आयोजना सञ्चालनहुने आ .व. </td>
                                            <td><strong><?php echo convertedcit($fiscal->year)?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>आयोजना सम्झौता मिति</td>
                                            <td><strong><?php echo convertedcit($thekka_lagat->yojanaa_samjhauta_date)?></strong></td>

                                        <tr>
                                            <td>आयोजना शुरु हुने मिति</td>
                                            <td><strong><?php echo convertedcit($thekka_lagat->yojana_start_date)?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>आयोजना सम्पन्न हुने मिति</td>
                                            <td><strong><?php echo convertedcit($thekka_lagat->yojana_end_date)?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>कन्टेन्जेन्सी</td>
                                            <td>
                                                <strong>
                                                 <?php
                                                 if(!empty($thekka_lagat->cont)){
                                                     echo convertedcit($thekka_lagat->cont.'/-');
                                                 }else{
                                                     echo "नियमानुसार";
                                                 }?>
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>कुल लागत ईस्टिमेट</td>
                                            <td><strong><?php echo convertedcit($thekka_lagat->total_investment.'/-')?></strong></td>
                                        </tr>
                                        <tr>
                                            <td>न.पा ले व्यहोर्ने (ठेक्का सम्झौता रकम)</td>
                                            <td><strong><?php echo convertedcit($thekka_lagat->agreement_gaupalika.'/-')?></strong></td>
                                        </tr>
                                    </table>
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