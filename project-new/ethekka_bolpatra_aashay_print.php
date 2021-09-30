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
<title>विषय:- बोलपत्र स्वीकृती गर्ने आशयको सूचना । print page:: <?php echo SITE_SUBHEADING;?>.</title>
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
            <div class="chalanino">पत्र संख्या :<strong><?php echo convertedcit($fiscal->year)?></strong></div>
            <div class="chalanino">चलानी नं :</div>
            <div class="myspacer20"></div>
            <div class="subject">   <u>बिषय:- बोलपत्र स्वीकृती गर्ने आशयको सूचना ।</u></div><br>
            <div class="text-center"><u>प्रकाशित मिति : <strong><?php echo convertedcit($ethekka_info->print_date);?></strong></u></div>
            <div class="myspacer"></div>
            <div class="bankname">श्रीमान् </div>
            <div class="myspacer"></div>
            <div class="banktextdetails">
                यस <strong><?php echo SITE_LOCATION;?></strong> <strong><?php echo SITE_HEADING;?></strong>, <strong><?php echo SITE_ADDRESS;?></strong>
                को मिति <strong><?php echo convertedcit($ethekka_info->bolpatra_miti);?></strong> गतेको
                <strong><?php echo $ethekka_info->bolpatra_m?></strong>मा प्रकाशित बोलपत्र आह्वान सम्बन्धी सूचना अनुसार यस कार्यालयद्वारा सम्पादन हुन
                गइरहेको तपसिलको कार्यको लागी दर्ता हुन आएका सिलबन्दी बोलपत्रहरु मध्ये तपसिल बमोजिमको बोलपत्र न्युनतम
                मुल्यांकित तथा सारभुतरुपमा प्रभावग्राही भई स्वीकृतिको लागी छनौट भएको हुँदा सार्वजनिक खरिद ऐन, २०६३ को दफा २७ को उपदफा २ (१) र दफा ४७
                को प्रयोजनार्थ सम्बन्धित सबैको जानकारीको लागी आजैको मिति देखि लागुहुने गरि यो ७ (सात) दिने आशयको सूचना प्रकाशित गरिएकोछ ।
            </div>
            <div class="myspacer20"></div>
            <table class="table table-bordered myWidth100 myHeight30">
                <thead>
                <th>क्र.स.</th>
                <th>कामको विवरण</th>
                <th>बोलपत्रदाताको नाम र ठेगाना</th>
                <th>कबोल गरेको रकम (भ्याट र पि.एस. सहित)</th>
                </thead>
                <tbody>
                <tr>
                    <td>१.</td>
                    <td><strong><?php echo $data1->program_name?> - <?php echo convertedcit($ethekka_info->thekka_no)?></strong></td>
                    <td><strong><?php echo $ethekka_info->firm_name?> - (<?php echo $ethekka_info->firm_address?>)</strong></td>
                    <td>रु. <strong><?php echo convertedcit($ethekka_info->kabol_rakam)?> - ()</strong></td>
                </tr>
                </tbody>
            </table>
            <div class="myspacer20"></div>
            <div class="oursignature mymarginright" style="margin-left:20px"><br/>
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
