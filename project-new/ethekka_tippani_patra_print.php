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
?>
<title>विषय:- लागत अनुमान स्वीकृत गरि खरिद कार्य अगाडी बढाउने सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?>.</title>
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
            <div class="subject">   <u>वविषय:- लागत अनुमान स्वीकृत गरि खरिद कार्य अगाडी बढाउने सम्बन्धमा ।</u></div>
            <div class="myspacer"></div>
            <div class="bankname">श्रीमान् </div>
            <div class="myspacer"></div>
            <div class="banktextdetails">
                उपरोक्त सम्बन्धमा यस <strong><?php echo SITE_LOCATION;?></strong>को गौरवको
                आयोजनाका रुपमा यस <?php echo SITE_LOCATION;?> <strong><?php echo $data3->place_to_organize;?></strong>
                मा रहेको <strong><?php echo $data1->program_name ?></strong> कार्यका
                लागी <strong><?php echo $thekka_lagat->anya_nikaya?></strong> र यस <strong><?php echo SITE_LOCATION?></strong>को लागत साझेदारीमा आ.व.
                <strong><?php echo convertedcit($fiscal->year)?></strong>
                मा सञ्चालन गर्ने गरि <strong><?php echo $thekka_lagat->anya_nikaya?></strong>
                बाट योजना स्वीकृत भइ बजेट रु. <strong><?php echo convertedcit($thekka_lagat->anya_nikaya_amount)?></strong>
                विनियोजन भएको छ ।
                <strong><?php echo $thekka_lagat->anya_nikaya?></strong> बाट
                <strong>(<?php echo convertedcit($thekka_lagat->anya_nikaya_per)?>%)</strong>
                र <strong><?php echo SITE_LOCATION?></strong> को <strong>(<?php echo convertedcit($thekka_lagat->agreement_gaupalika_per)?>%)</strong>
                को लागत साझेदारीमा आयोजना सञ्चालन गर्नु पर्ने व्यवस्था रहेको हुँदा
                नगरपालिकाको तर्फबाट व्यहोर्नु पर्ने लागतको स्रोतको व्यवस्थापन गर्नुपर्ने देखिन्छ।
                <strong><?php echo $data1->program_name;?></strong> कार्यको नक्सा, तथा डिजाइनका <strong><?php echo convertedcit($thekka_lagat->contract_total_investment)?></strong> (अक्षररुपी एक करोड तित्तीस लाग सत्तसट्ठी हजार
                नौ सय तिस रुपैया पैतालीस पैसा मात्र) को लागत अनुमान तयार भएको छ । सोको लागि यस <strong><?php echo SITE_TYPE;?></strong>को
                <strong><?php echo $data1->parishad_sno;?></strong>
                बाट स्वीकृत आ.व. <strong><?php echo convertedcit($fiscal->year)?>
                </strong> को <strong><?php echo Topicbudget::getName($data1->budget_id)?></strong> कोषबाट रु.
                <strong><?php echo convertedcit($thekka_lagat->agreement_gaupalika)?></strong> व्यहोर्ने गरी स्वीकृत हुन आवश्यक
                देखिन्छ । उक्त योजनाको लागी प्रस्ताव गरिएको लागत अनुमान, नक्सा, डिजाइन, स्वीकृत गरि नेपाल सरकार सार्वजनिक
                खरिद ऐन, २०६३ र सार्वजनिक खरिद नियमावली, २०६४ मा व्यवस्था भए बमोजिम उल्लेखित
                <strong><?php echo $data1->program_name?></strong> गर्न तपसिल बमोजिम विधुतीय शिलवन्दी बोलपत्रको सुचना आह्वान गरि खरिद प्रकृया अगाडी बढाउन मनाशिव देखिएकोले निर्णयार्थ पेश गरेको छु ।                                 </div>
        </div>
            <div class="myspacer20"></div>
        <table class="table table-bordered myWidth100 myHeight30">
            <thead>
            <th>क्र.स.</th>
            <th>आयोजना तथा कार्यक्रमको विवरण</th>
            <th>ठेगाना</th>
            <th>स्वीकृत बजेट</th>
            <th>प्रस्तावित ल.ई. अंक</th>
            <th>खरिद प्रक्रिया</th>
            <th>कैफियत</th>
            </thead>
            <tbody>
            <tr>
                <td>१.</td>
                <td><strong><?php echo $data1->program_name?></strong></td>
                <td><strong><?php echo $data3->place_to_organize?></strong></td>
                <td>
                    <strong><?php echo convertedcit($thekka_lagat->contract_total_investment)?>
                        (<?php echo SITE_LOCATION?></strong> बाट <strong><?php echo convertedcit($thekka_lagat->agreement_gaupalika)?></strong>
                    र <strong><?php echo convertedcit($thekka_lagat->anya_nikaya)?></strong>बाट
                    <strong><?php echo convertedcit($thekka_lagat->anya_nikaya_amount)?>)</strong>
                </td>
                <td><strong><?php echo convertedcit($thekka_lagat->total_investment)?></strong></td>
                <td>बिधुतिय माध्यमबाट बोलपत्रको आह्वान</td>
                <td></td>
            </tr>
            </tbody>
        </table>
            <div class="myspacer20"></div>
            <div class="oursignatureleft mymarginright" style="margin-left:20px">योजना तथा अनुगमन उप-शाखा<br/>
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
