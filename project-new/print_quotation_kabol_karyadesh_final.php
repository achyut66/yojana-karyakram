<?php require_once("includes/initialize.php");
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
if (!isset($_GET['id']) && isset($_SESSION['set_plan_id'])) {
    redirectUrl();
}
$ward_address = WardWiseAddress();
$address = getAddress();
$datas = Bankinformation::find_all();
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
$quotation_total_investment = Quotationtotalinvestment::find_by_plan_id($_GET['id']);
$quotation_more_details = Quotationmoredetails::find_by_plan_id($_GET['id']);
$quotation_enlist = Quotationenlist::find_by_plan_id($_GET['id']);
$count = count($quotation_enlist);
$date_selected= $_GET['date_selected'];
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
$print_history->save();
if (!empty($print_history)) {
    $worker1 = Workerdetails::find_by_id($print_history->worker1);

} else {
    $print_history = PrintHistory::setEmptyObject();
    if (empty($worker1)) {
        $worker1 = Workerdetails::setEmptyObject();
    }

}
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
?>
<?php include("menuincludes/header1.php"); ?>

<!-- js ends -->
<title>कोटेसन् :: <?php echo SITE_SUBHEADING; ?></title>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</head>

<body>

<div id="body_wrap_inner">
    <div class="maincontent">
        <div class="OurContentFull">


            <?php

            $data = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
            $data1 = Plandetails1::find_by_id($_GET['id']);
            //print_r($data1);exit;
            $data2 = Moreplandetails::find_by_plan_id($_GET['id']);
            $data3 = Costumerassociationdetails::find_by_post_plan_id(1, $_GET['id']);
            $data3_1 = Costumerassociationdetails::find_by_post_plan_id(2, $_GET['id']);
            $data3_2 = Costumerassociationdetails::find_by_post_plan_id(4, $_GET['id']);
            $fiscal = FiscalYear::find_by_id($data1->fiscal_id);

            foreach ($quotation_enlist as $enlist):
                if ($enlist->enlist_type == 10) {
                    $en = Contractordetails::find_by_id($enlist->enlist_id);
                    $name = $en->contractor_name;
                    $type = 'निर्माण ब्यवोसायी';

                } else {
                    $en = Enlist::find_by_id($enlist->enlist_id);
                    $name_type = 'name' . $enlist->enlist_type;
                    $name = $en->$name_type;
                    switch ($en->type) {
                        case 0:
                            $type = 'फर्म/कम्पनी';
                            break;
                        case 1:
                            $type = 'कर्मचारी';
                            break;
                        case 2:
                            $type = 'संस्था';
                            break;
                        case 3:
                            $type = 'पदाधिकारी';
                            break;
                        case 4:
                            $type = 'अन्य समूह ';
                            break;
                        case 5:
                            $type = 'उपभोक्ता समिति';
                            break;
                        default:
                            $type = "";
                    }

                }
                if ($enlist->is_vat == 1) {
                    $vat = $enlist->amount - ($enlist->amount / 1.13);
                } else {
                    $vat = ($enlist->amount * 1.13) - ($enlist->amount);
                }
                $sum = $enlist->amount + $enlist->extra_amount;
                $sum_array[$enlist->id] = $sum;
                ?>

            <?php endforeach;

            $maxs = array_keys($sum_array, min($sum_array));
            //print_r($maxs);exit;
            $max_id = $maxs[0];
            $max_value = min($sum_array);
            $max_enlist = Quotationenlist::find_by_id($max_id);
            //new
            if ($max_enlist->enlist_type == 10) {
                $en1 = Contractordetails::find_by_id($max_enlist->enlist_id);
                $name1 = $en1->contractor_name;
                $address1 = $en1->contractor_address;
                $type1 = 'निर्माण ब्यवोसायी';

            } else {
                $en1 = Enlist::find_by_id($max_enlist->enlist_id);
                $name_type1 = 'name' . $max_enlist->enlist_type;
                $address_type1 = 'address' . $max_enlist->enlist_type;
                $name1 = $en1->$name_type;
                $address1 = $en1->$address_type1;
                switch ($en1->type) {
                    case 0:
                        $type1 = 'फर्म/कम्पनी';
                        break;
                    case 1:
                        $type1 = 'कर्मचारी';
                        break;
                    case 2:
                        $type1 = 'संस्था';
                        break;
                    case 3:
                        $type1 = 'पदाधिकारी';
                        break;
                    case 4:
                        $type1 = 'अन्य समूह ';
                        break;
                    case 5:
                        $type1 = 'उपभोक्ता समिति';
                        break;
                    default:
                        $type1 = "";
                }

            }
            $print_history = PrintHistory::find_by_url_plan_id_and_letter_type(6, $_GET['id'], 'दररेट पेश गर्न कम्पनी/निर्माण व्यवसायीलाई लेखेको पत्र');
            //            echo '<pre>';
            //            print_r($print_history);
            //            echo '</pre>';exit;
            ?>
             <div class=""><input type="hidden" name="id" value="<?= $_GET['id'] ?>"/>
                    <input type="hidden" name="bank_id" value="<?= $_GET['bank_id'] ?>"/>
                    
                <div class="userprofiletable">
                    <div class="printPage">
                        <div class="printlogo"><img src="images/janani.png" alt="Logo"></div>

                        <h1 class="margin1em letter_title_one" style="margin-left:30"><?php echo SITE_LOCATION; ?></h1>
                        <h4 class="margin1em letter_title_two"><?php echo $address; ?></h4>
                        <h5 class="margin1em letter_title_three"><?php echo $ward_address; ?></h5>
                        <div class="myspacer"></div>
                        <div class="printContent">
                            <div class="mydate">मिति <?php echo convertedcit($date_selected); ?>
                            </div>
                            <div class="patrano">पत्र संख्या :<?= convertedcit($fiscal->year) ?> </div>
                            <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?></div>
                            <div class="chalanino">च न. :</div>
                            <div class="subject"><u>विषय:- कार्यादेश दिएको सम्बन्धमा ।</u></div>
                            <div class="myspacer20"></div>
                            <div class="bankname"> श्री <?= $name1 ?>,
                            </div>
                            <div class="bankaddress"><?= $address1 ?>,</div>
                            <div class="banktextdetails">

                                प्रस्तुत विषयमा यस <?php echo SITE_LOCATION;?>, नगर कार्यपालिकाको कार्यालय र तहाँ निर्माण व्यवसायी/कम्पनी/फर्मबीच देहाय बमोजिमको योजना/कार्यक्रम/खरीद कार्य गर्न सम्झौता भएको हुँदा सम्झौता बमोजिम तोकिएको समयसीमाभित्र कार्य सम्पन्न गर्नेगरी यो कार्यादेश दिएको व्यहोरा अनुरोध छ ।

                                <div class="myspacer20"></div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>योजनाको नाम</th>
                                        <td><?= $data1->program_name ?></td>
                                    </tr>
                                    <tr>
                                        <th>कार्यादेश रकम</th>
                                        <td>रु. <?= convertedcit($enlist->amount); ?></td>
                                    </tr>
                                    <tr>
                                        <th>आयोजना स्थल</th>
                                        <td><?= convertedcit($quotation_more_details->yojana_place) ?></td>
                                    </tr>
                                    <tr>
                                        <th>आयोजना शुरु मिति</th>
                                        <td><?= convertedcit($quotation_more_details->yojana_start_date) ?></td>
                                    </tr>
                                    <tr>
                                        <th>आयोजना सम्पन्न गर्नुपर्ने मिति</th>
                                        <td><?= convertedcit($quotation_more_details->yojana_end_date) ?></td>
                                    </tr>

                                </table>
                                <?php echo SITE_LOCATION;?>
                                <strong><?php echo convertedcit($data1->ward_no);?> </strong> नं. वडा कार्यालय- आवश्यक सहयोग गर्नुहुन ।


                            </div>
                            <div class="myspacer30"></div>
                            <div class="myspacer30"></div>

                            <div class="oursignature mymarginright" > सदर गर्ने <br>
                                <?php
                                if(!empty($worker1))
                                {
                                    echo $worker1->authority_name."<br/>";
                                    echo $worker1->post_name;
                                }
                                ?>

                            </div>
                            <div class="oursignatureleft mymarginright"> तयार गर्ने  <br/>
                                <?php
                                if(!empty($worker2))
                                {
                                    echo $worker2->authority_name."<br/>";
                                    echo $worker2->post_name;
                                }
                                ?>
                            </div>
                            <div class="oursignatureleft mymarginright" style="margin-left: 7em;"> योजना शाखा   <br/>
                                <?php
                                if(!empty($worker3))
                                {
                                    echo $worker3->authority_name."<br/>";
                                    echo $worker3->post_name;
                                }
                                ?>
                            </div>
                    <div class="myspacer"></div>
</div>
<!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
</div>
</div>
</div>
</div><!-- main menu ends -->
</div><!-- top wrap ends -->


