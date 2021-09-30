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
if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
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
}
?>
<?php include("menuincludes/header.php"); ?>

<!-- js ends -->
<title>कोटेसन् :: <?php echo SITE_SUBHEADING; ?></title>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</head>

<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">
    <div class="maincontent">
        <h2 class="headinguserprofile">बैंक रेकोर्ड | <a href="quotationDashboard.php" class="btn">पछि जानुहोस</a></h2>

        <div class="OurContentFull">


            <?php

            $data = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
            $data1 = Plandetails1::find_by_id($_GET['id']);
            $data2 = Moreplandetails::find_by_plan_id($_GET['id']);
            $data3 = Costumerassociationdetails::find_by_post_plan_id(1, $_GET['id']);
            $data3_1 = Costumerassociationdetails::find_by_post_plan_id(2, $_GET['id']);
            $data3_2 = Costumerassociationdetails::find_by_post_plan_id(4, $_GET['id']);
            $fiscal = FiscalYear::find_by_id($data1->fiscal_id);
            $print_history = PrintHistory::find_by_url_plan_id_and_letter_type(6,$_GET['id'],'दररेट पेश गर्न कम्पनी/निर्माण व्यवसायीलाई लेखेको पत्र');

            ?>
            <form method="get" action="print_quotation_kabol_final.php?id=<?= $_GET['id'] ?>" target="_blank">
                <div class=""><input type="hidden" name="id" value="<?= $_GET['id'] ?>"/>
                    <input type="hidden" name="bank_id" value="<?= $_GET['bank_id'] ?>"/>
                    <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit"/></div>
                <div class="userprofiletable">
                    <div class="printPage">
                        <div class="printlogo"><img src="images/janani.png" alt="Logo"></div>

                        <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION; ?></h1>
                        <h4 class="margin1em letter_title_two"><?php echo $address; ?></h4>
                        <h5 class="margin1em letter_title_three"><?php echo $ward_address; ?></h5>
                        <div class="myspacer"></div>
                        <div class="printContent">
                            <div class="mydate">मिति <input type="text" name="date_selected"
                                                            value="<?php echo generateCurrDate(); ?>" id="nepaliDate5"/>
                            </div>
                            <div class="patrano">पत्र संख्या :<?= convertedcit($fiscal->year) ?> </div>
                            <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?></div>
                            <div class="chalanino">च न. :</div>
                            <div class="subject"><u>विषय:- दरभाउ पत्र छनौट सम्बन्धमा ।</u></div>
                            <div class="myspacer20"></div>
                            <div class="bankname"> श्रीमान्</div>
                            <div class="bankaddress"></div>
                            <div class="banktextdetails">

                                <strong><?= SITE_LOCATION; ?> </strong>को मिति <?= convertedcit($print_history->nepali_date) ?> मा माग गरेको कोटेसन पत्र
                                बमोजिम <strong><?= $data1->program_name ?> </strong>योजना/सामग्री खरीद गर्न/कार्य गर्न सम्बन्धित निर्माण
                                व्यवसायी/कम्पनी/फर्मबाट देहाय बमोजिमको कोटेसन यस कार्यालयमा प्राप्त भयो ।
                                <table class="table-bordered table">
                                    <tr>
                                        <th rowspan="2">विवरण</th>
                                        <th colspan="5" style="text-align: center;">पेश भएको दररेट रु.
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>जम्मा मूल्य रु.</th>
                                        <th>मू.अ. कर रु.</th>
                                        <th>कन्टेन्जेन्सी/ढुवानी रु.</th>
                                        <th>कूल जम्मा रु.</th>
                                        <th>कैफियत</th>
                                    </tr>
                                    <?php foreach ($quotation_enlist as $enlist):
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
                                        <tr>
                                            <th><?= $name . '( ' . $type . ' )' ?></th>
                                            <th><?= convertedcit(placeholder($enlist->amount)) ?></th>
                                            <th><?= convertedcit(placeholder(round($vat,2))) ?></th>
                                            <th><?= convertedcit(placeholder($enlist->extra_amount)) ?></th>
                                            <th><?= convertedcit(placeholder($sum)) ?></th>
                                            <th><?= $enlist->remarks ?></th>

                                        </tr>
                                    <?php endforeach;
                                    $maxs = array_keys($sum_array, min($sum_array));
                                    $max_id = $maxs[0];
                                    $max_enlist = Quotationenlist::find_by_id($max_id);
                                    //new
                                    if ($max_enlist->enlist_type == 10) {
                                        $en1 = Contractordetails::find_by_id($max_enlist->enlist_id);
                                        $name1 = $en1->contractor_name;
                                        $type1 = 'निर्माण ब्यवोसायी';

                                    } else {
                                        $en1 = Enlist::find_by_id($max_enlist->enlist_id);
                                        $name_type1 = 'name' . $max_enlist->enlist_type;
                                        $name1 = $en1->$name_type;
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
                                    ?>
                                </table>

                               श्रीमान्
                                माथि उल्लिखित कोटेसनमध्ये <?= $name1.'( '.$type1.') ' ?> बाट पेश हुनआएको कोटेसन अन्य निर्माण
                                व्यवसायी / कम्पनी / फर्मबाट पेश भएको कोटेसनभन्दा कम रहेको र सार्वजनिक खरीद ऐन, २०६३ तथा
                                सार्वजनिक खरीद नियमावली, २०६४ र अन्य प्रचलित ऐन, नियमानुसार शारभूत रुपमा ग्राह्य देखिएको
                                हुँदा <?= $name1.'( '.$type1.') ' ?> को दर रेट स्वीकृत गरी खरीद गर्न मनासिब देखिएको हुँदा निर्णयार्थ पेश गरिएको छ ।

                            </div>
                            <div class="myspacer30"></div>

                            <div class="oursignature mymarginright"> सदर गर्ने <br>
                                <select name="worker1" class="form-control worker" id="worker_1">
                                    <option value="">छान्नुहोस्</option>
                                    <?php foreach ($workers as $worker) { ?>
                                        <option value="<?= $worker->id ?>" <?php if ($print_history->worker1 == $worker->id) {
                                            echo 'selected="selected"';
                                        } ?>><?= $worker->authority_name ?></option>
                                    <?php } ?>
                                </select>
                                <input type="text" name="post" class="form-control" id="post_1"
                                       value="<?= $worker1->post_name ?>">
                            </div>
                            <div class="oursignatureleft mymarginright"> तयार गर्ने <br/>
                                <select name="worker2" class="form-control worker" id="worker_2">
                                    <option value="">छान्नुहोस्</option>
                                    <?php foreach ($workers as $worker) { ?>
                                        <option value="<?= $worker->id ?>" <?php if ($print_history->worker2 == $worker->id) {
                                            echo 'selected="selected"';
                                        } ?>><?= $worker->authority_name ?></option>
                                    <?php } ?>
                                </select>
                                <input type="text" name="post" class="form-control" id="post_2"
                                       value="<?= $worker2->post_name ?>">
                            </div>
                            <div class="oursignatureleft mymarginright" style="margin-left:150px"> योजना शाखा <br/>
                                <select name="worker3" class="form-control worker" id="worker_3">
                                    <option value="">छान्नुहोस्</option>
                                    <?php foreach ($workers as $worker) { ?>
                                        <option value="<?= $worker->id ?>" <?php if ($print_history->worker3 == $worker->id) {
                                            echo 'selected="selected"';
                                        } ?>><?= $worker->authority_name ?></option>
                                    <?php } ?>
                                </select>
                                <input type="text" name="post" class="form-control" id="post_3"
                                       value="<?= $worker3->post_name ?>">
                            </div>
                            
            </form>
        </div>
        <div class="myspacer"></div>
        </form>
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

