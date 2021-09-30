<?php require_once("includes/initialize.php");
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
if (!isset($_GET['id']) && isset($_SESSION['set_plan_id'])) {
    redirectUrl();
}
//echo Contingency:: find_by_type(1);
if ($_GET['id'] != $_SESSION['set_plan_id']):
    die('Invalid Format');
endif;
//save code
if (isset($_POST['submit'])) {
    $qti = new Quotationtotalinvestment();
    $qti->plan_id= $_POST['plan_id'];
    $qti->unit_id= $_POST['unit_id'];
    $qti->contigency_amount = $_POST['contigency_amount'];
    $qti->gaupalika_anudan = $_POST['gaupalika_anudan'];
    $qti->unit_total = $_POST['unit_total'];
    $qti->kul_lagat_anudan = $_POST['kul_lagat_anudan'];
    if($qti->save())
    {
        echo alertBox('थप सफल','quotation_lagat.php?id='.$_POST['plan_id']);
    }
}
//save code ends
if (isset($_POST['search'])) {
    if (empty($_POST['sn'])) {
        $sql = "select * from plan_details1 where program_name LIKE '%" . $_POST['program'] . "%'";
    } else {
        $sql = "select * from plan_details1 where id='" . $_POST['sn'] . "'";

    }
    $results = Plandetails1::find_by_sql($sql);

//print_r($result);exit;
}
$data1 = Plandetails1::find_by_id($_GET['id']);
$postnames = Postname::find_all();
$units = Units::find_all();
$settingbhautikPariman = SettingbhautikPariman::find_all();
?>

<?php include("menuincludes/header.php"); ?>
<title>योजनाको कुल लागत अनुमान :: <?php echo SITE_SUBHEADING; ?></title>
<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">
    <div class="maincontent">
        <h2 class="headinguserprofile">योजनाको कुल लागत अनुमान | <a href="quotation_lagat_dashboard.php" class="btn">पछि
                जानुहोस</a></h2>
        <div class="OurContentFull">
            <div class="myMessage"><?php echo $message; ?></div>
            <h1 class="myHeading1">दर्ता न :<?= convertedcit($_GET['id']) ?></h1>
            <div class="userprofiletable">

                <?php $data = Plandetails1::find_by_id($_GET['id']);

//                print_r($data);exit;
                ?>
                <?php $invest_details = Quotationtotalinvestment::find_by_plan_id($_GET['id']);
                if (empty($invest_details)) {
                    $invest_details = Quotationtotalinvestment::setEmptyObjects();
                }
                !empty($invest_details->id) ? $value = "अपडेट गर्नुहोस" : $value = "सेभ गर्नुहोस";

                $bhautik_details = Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'], 1);
                ?>
                <div>
                    <h3><?php echo $data->program_name; ?></h3>
                    <form method="post" enctype="multipart/form_data">


                        <table class="table table-bordered">
                            <div class="inputWrap100">
                                <h1> योजनाको कुल लागत अनुमान </h1>
                                <div class="inputWrap33 inputWrapLeft">
                                    <div class="titleInput">भौतिक परिणाम:</div>
                                    <div class="newInput"><input type="text" required name="unit_total"
                                                                 value="<?= $invest_details->unit_total ?>"/></div>
                                    <div class="titleInput">भौतिक ईकाई:</div>
                                    <div class="newInput"><select name="unit_id">
                                            <option value="">--छान्नुहोस् --</option>
                                            <?php foreach ($units as $unit): ?>
                                                <option value="<?= $unit->id ?>" <?php if ($invest_details->unit_id == $unit->id) { ?> selected="selected" <?php } ?> ><?= $unit->name ?></option>
                                            <?php endforeach; ?>
                                        </select></div>
                                    <div class="titleInput"><?php echo SITE_TYPE; ?>बाट अनुदान :</div>
                                    <div class="newInput"><input type="text" readonly="true" name="gaupalika_anudan"
                                                                 id="gaupalika_anudan"
                                                                 value="<?= $data->investment_amount ?>"/></div>
                                </div><!-- input wrap 33 ends -->
                                <!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                    <div class="titleInput">कन्टेन्जेन्सी रकम :</div>
                                    <div class="newInput"><input type="text"  name="contigency_amount"
                                                                 id="contigency_amount"
                                                                 value="<?= $invest_details->contigency_amount ?>"/>
                                    </div>
                                    <div class="titleInput">कुल लागत अनुमान जम्मा :</div>
                                    <div class="newInput"><input type="text" name="kul_lagat_anudan"
                                                                 id="kul_lagat_anudan"
                                                                 value="<?= $invest_details->kul_lagat_anudan ?>"/>
                                    </div>
                                    <div class="saveBtn myCenter myWidth100"><input type="hidden" name="create_id"
                                                                                    value="<?= $invest_details->id ?>"
                                                                                    class="btn"/>
                                        <input type="hidden" name="plan_id" id="plan_id" value="<?= $_GET['id'] ?>"
                                               class="btn"/>
                                        <input type="hidden" name="create_id" id="plan_id"
                                               value="<?= $invest_details->id ?>" class="btn"/>
                                        <input type="submit" name="submit" value="<?= $value ?>" class="submit btn">
                                    </div>
                                </div>


                                <!-- input wrap 33 ends -->
                                <div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->

                    </form>


                </div>
            </div>
        </div><!-- main menu ends -->
        <script>
            var JQ = jQuery.noConflict();
            JQ(document).on("click", ".add_plan_form1", function () {
                var num = JQ(".remove_plan_form_details").length;
                var counter = num + 2;
                //           alert(counter);return false;
                var param = {};
                param.counter = counter;
                JQ.post('get_bhautik_pariman_details.php', param, function (res) {
                    var obj = JSON.parse(res);
                    //alert(obj.html);
                    JQ("#join_table_plan_form_1").append(obj.html);
                    //JQ('#interest_amount_'+id).val(obj.interest_amount);

                    // alert(obj.interest_amount);
                });
            });

            JQ(document).on("click", ".remove_plan_form1", function () {
                JQ('.remove_plan_form_details').last().remove();

            });
            JQ(document).on("click", ".remove_btn", function () {
                JQ(this).closest('tr').remove();
                var i = 1;
                JQ(".sn").each(function () {
                    JQ(this).html(i + 1);
                    i++;
                });


            });
        </script>
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
