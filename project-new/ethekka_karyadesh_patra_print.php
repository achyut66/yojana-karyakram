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
$data1=  Plandetails1::find_by_id($_GET['id']);
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
<?php
$data1 =  Plandetails1::find_by_id($_GET['id']);
$thekka_lagat = Ethekka_lagat::find_by_plan_id($_GET['id']);
$ethekka_info = Ethekkainfo::find_by_plan_id($_GET['id']);
?>
<title>विषय:- कार्यादेश दिईएको बारे । print page:: <?php echo SITE_SUBHEADING;?>.</title>
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
            <div class="myspacer"></div>
            <div class="printContent">
                <div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
                <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
                <div class="chalanino">पत्र संख्या : <?php echo convertedcit($fiscal->year)?></div>
                <div class="chalanino">चलानी नं :</div>
                <div class="myspacer20"></div>
                <div class="subject">   <u>बिषय:- कार्यादेश दिईएको बारे ।</u></div>
                <div class="bankname">श्री, <strong><?php echo $ethekka_info->firm_name?></strong></div>
                <div class="bankname"><strong><?php echo $ethekka_info->firm_address.','?></strong></div>
                <div class="myspacer"></div>
                <div class="banktextdetails">
                    उपरोक्त सम्बन्धमा <strong><?php echo $thekka_lagat->anya_nikaya.' '.'र'.' '.SITE_LOCATION;?></strong>को साझेदारी लागत कार्यक्रम
                    <strong>(<?php echo Topicbudget::getName($data1->budget_id)?>)</strong>
                    अन्तर्गत <strong><?php echo SITE_LOCATION;?></strong>मा आ.व. <strong><?php echo convertedcit($fiscal->year)?></strong> मा सञ्चालन हुने देहाय बमोजिम आयोजनाको तोकिएको अवधि भित्र
                    गुणस्तरिय कार्य सम्पन्न गरी नगर कार्यपालिका कार्यालयमा नियमानुसार प्रकृया पुरा गरी भुक्तानी माग गर्नुहुन यो कार्यादेश दिइएको छ ।
                </div>
                <div class="myspacer20"></div>
                <div class="text-left"><u><strong>तपशिल</strong></u></div>
                <div class="myspacer"></div>
                <table class="table table-bordered myWidth100">
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
                <div class="oursignature mymarginright" style="margin-left:20px">सदर गर्ने<br/>
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
