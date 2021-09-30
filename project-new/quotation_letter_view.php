<?php require_once("includes/initialize.php");
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
if (!isset($_GET['id']) && isset($_SESSION['set_plan_id'])) {
    redirectUrl();
}
$letter_history = PrintHistory::find_by_url_plan_id_and_letter_type(6, 2, 'दररेट पेश गर्न कम्पनी/निर्माण व्यवसायीलाई लेखेको पत्र');

$ward_address = WardWiseAddress();
$address = getAddress();
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

$enlist_result = Enlist::find_all();
$contractor_result = Contractordetails::find_all();

$merge_enlist_result = array_merge($enlist_result, $contractor_result);
?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title> पत्र</title>

</head>

<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">


    <div class="maincontent">
        <h2 class="headinguserprofile"><a href="<?= $link ?>" class="btn">पछि जानुहोस </a></h2>
        <form method="post">
            <div class="OurContentFull">


                योजनाको किसिम : <select name="plan_type" id="plan_type">
                    <option value=""></option>
                    <option value="6">योजना कोटेसन् मार्फत</option>
                </select>

                पत्रको किसिम : <select name="letter_type" id="letter_type">
                    <option value=""></option>

                </select>
                <select name="enlist_id[]" id="enlist_id" class="select22">
                    <option value=""></option>
                    <?php foreach ($merge_enlist_result as $en):
                        if (!empty($en->contractor_name)) {
                            $name = $en->contractor_name;
                            $type = 'निर्माण ब्यवोसायी';
                            $save_type = '10';
                        } else {
                            $name_string = 'name' . $en->type;
                            $name = $en->$name_string;
                            $save_type = $en->type;

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
                        ?>
                        <option value="<?= $en->id ?>-<?= $save_type ?>"><?= $name . ' (' . $type . ') ' ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" id="enlist_id_replaced">
                <input type="hidden" id="enlist_type_replaced">
                <input type="hidden" name="plan_id" id="plan_id" value="<?= $_GET['id'] ?>">


                <a class="btn btn-primary" style="text-align: right;!important;" href="quotation_letter.php">पत्र
                    थप्नुहोस्</a>
                <span type="submit" name="submit" class="btn btn-primary" id="print">प्रिन्ट गर्नुहोस</span>
                <a href="quotation_letter_view.php"></a>


                <div class="userprofiletable" id="letter">
                    <div class="printPage">
                        <div class="printlogo"><img src="images/janani.png" alt="Logo"></div>
                        <h1 class="margin1em letter_title_one"
                            style="margin-right: 100px;"><?php echo SITE_LOCATION; ?></h1>
                        <h4 class="margin1em letter_title_two"><?php echo $address; ?></h4>
                        <h5 class="margin1em letter_title_three"><?php echo $ward_address; ?> </h5>
                        <div class="myspacer"></div>
                        <div class="printContent">
                        </div>
                    </div>
                    <div class="pull-right date_hide" style="text-align: right;">
                        <input type="text" name="english_date" style="text-align: right; !important;"
                               id="nepaliDate4">
                    </div>
                    <div class="pull-right date_show" style="text-align: right;">

                    </div>

                    <div class="ck-content" id="letter_editor">

                    </div>
                    <div class="myspacer30"></div>

                    <div class="oursignature mymarginright worker1_hide">

                        <input type="text" name="type_name1" class="form-control" id="type_name1"
                               value="तयार गर्न">
                        <br/>
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

                    <div class="oursignature mymarginright worker1_show">

                    </div>


                    <div class="oursignatureleft mymarginright worker2_hide">
                        <input type="text" name="type_name2" class="form-control" id="type_name2"
                               value="तयार गर्न">
                        <br/>
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

                    <div class="oursignatureleft mymarginright worker2_show">

                    </div>
                    <div class="oursignatureleft mymarginright worker3_show">
                        <input type="text" name="type_name3" class="form-control" id="type_name3"
                               value="योजना शाखा">

                        <br/>
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

                    <div class="oursignatureleft mymarginright worker3_hide">
                    </div>


                    <div class="oursignatureleft margin4 worker4_hide">
                        <input type="text" name="type_name4" class="form-control" id="type_name4"
                               value="आर्थिक प्रशासन शाखा">

                        <br/>
                        <select name="worker4" class="form-control worker" id="worker_4">
                            <option value="">छान्नुहोस्</option>
                            <?php foreach ($workers as $worker) { ?>
                                <option value="<?= $worker->id ?>" <?php if ($print_history->worker4 == $worker->id) {
                                    echo 'selected="selected"';
                                } ?>><?= $worker->authority_name ?></option>
                            <?php } ?>
                        </select>
                        <input type="text" name="post" class="form-control" id="post_4"
                               value="<?= $worker4->post_name ?>">
                    </div>
                    <div class="oursignatureleft margin4 worker4_show">
                    </div>

                </div>
        </form>
        <div class="myspacer"></div>
        <!--        <div class="userprofiletable" id="div_print">-->
        <!--           -->
        <!--            <div class="myspacer"></div>-->
        <!--        </div>-->
        <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
    </div>
</div>

</div>
</div>
</div>
</div><!-- main menu ends -->

</div><!-- top wrap ends -->
</body>

<?php include("menuincludes/footer.php"); ?>


<script>


    // const items = [
    //     { id: '[[yojana]]', userId: '1', name: 'मन्दिर निर्माण', link: 'https://www.imdb.com/title/tt0460649/characters/nm0000439' },
    //     { id: '[[mulyankanRakam]]', userId: '2', name: '2001', link: 'https://www.imdb.com/title/tt0460649/characters/nm0004989' },
    //     { id: '[[marshmallow]]', userId: '3', name: 'Marshall Eriksen', link: 'https://www.imdb.com/title/tt0460649/characters/nm0781981' },
    //     { id: '[[rsparkles]]', userId: '4', name: 'Robin Scherbatsky', link: 'https://www.imdb.com/title/tt0460649/characters/nm1130627' },
    //     { id: '[[tdog]]', userId: '5', name: 'Ted Mosby', link: 'https://www.imdb.com/title/tt0460649/characters/nm1102140' }
    // ];

    JQ(document).on("change", "#plan_type", function () {
        var param = {};
        var plan_type = JQ(this).val() || 0;
        param.plan_type = plan_type;
        JQ.post('get_letter_type.php', param, function (res) {
            var obj = JSON.parse(res);
//        alert(obj.html);exit;
            JQ('#letter_type').html(obj.html);
        });
    });
    JQ(document).on("change", "#letter_type", function () {
        var param = {};
        var plan_type = JQ('#plan_type').val() || 0;
        var letter_type = JQ('#letter_type').val() || 0
        var plan_id = JQ('#plan_id').val() || 0;
        param.plan_type = plan_type;
        param.letter_type = letter_type;
        param.plan_id = plan_id;
        JQ.post('get_letter.php', param, function (res) {
            var obj = JSON.parse(res);
            //alert(obj.msg);
            JQ('#type_name1').html(obj.type_name1);
            JQ('#type_name2').html(obj.type_name2);
            JQ('#type_name3').html(obj.type_name3);
            JQ('#type_name4').html(obj.type_name4);

            JQ('#worker_1').val(obj.worker_1);
            JQ('#worker_2').val(obj.worker_2);
            JQ('#worker_3').val(obj.worker_3);
            JQ('#worker_4').val(obj.worker_4);

            JQ('#post_1').val(obj.post_1);
            JQ('#post_2').val(obj.post_2);
            JQ('#post_3').val(obj.post_3);
            JQ('#post_4').val(obj.post_4);
            JQ('#nepaliDate4').val(obj.date);




//        alert(obj.html);exit;
            JQ('#letter_editor').html(obj.html);
        });
    });

    JQ(document).on("change", "#enlist_id", function () {
        var param = {};
        var enlist = JQ(this).val() || 0;
        var html = JQ('#letter_editor').html() || '';
       // alert(html);return false;
        var res = enlist.split("-");
        var enlist_type = res[res.length - 1];
        var enlist_id = res[res.length - 2];

        var enlist_type_replaced = JQ('#enlist_type_replaced').val() || 000;
        var enlist_id_replaced = JQ('#enlist_id_replaced').val() || 000;

        param.enlist_type = enlist_type;
        param.enlist_id = enlist_id;
        param.enlist_id_replaced = enlist_id_replaced;
        param.enlist_type_replaced = enlist_type_replaced;
        param.html = html;
        JQ.post('get_enlist_values.php', param, function (res) {
            var obj = JSON.parse(res);
            //  alert(obj.msg);return false;
            //        alert(obj.html);exit;
            //alert(obj.name);return false;

            JQ('#letter_editor').html(obj.new_html);
            JQ('#enlist_id_replaced').val(enlist_id);
            JQ('#enlist_type_replaced').val(enlist_type);

        });
    });


    function printdiv(printpage) {

//    printpage.style.display = "block";
        var headstr = "<html><head><title></title></head><body>";
        var footstr = "</body>";
        var newstr = document.all.item(printpage).innerHTML;
        var oldstr = document.body.innerHTML;
        document.body.innerHTML = headstr + newstr + footstr;
        window.print();
        document.body.innerHTML = oldstr;
//    printpage.style.display = "none";
        return false;
    }

    JQ(document).on("click", "#print", function () {
        JQ(".mention").css("color", "fff");
        var plan_type = JQ('#plan_type').val() || 0;
        var letter_type = JQ('#letter_type').val() || 0;
        var plan_id = JQ('#plan_id').val() || 0;
        var english_date = JQ('#nepaliDate4').val() || 0;
        var type_name1 = JQ('#type_name1').val() || 0;
        var type_name2 = JQ('#type_name2').val() || 0;
        var type_name3 = JQ('#type_name3').val() || 0;
        var type_name4 = JQ('#type_name4').val() || 0;
        var worker1 = JQ('#worker_1').val() || 0;
        var worker2 = JQ('#worker_2').val() || 0;
        var worker3 = JQ('#worker_3').val() || 0;
        var worker4 = JQ('#worker_4').val() || 0;
        var param = {};
        //    alert(type_name1);return  false;
        param.plan_type = plan_type;
        param.letter_type = letter_type;
        param.plan_id = plan_id;
        param.english_date = english_date;
        param.type_name1 = type_name1;
        param.type_name2 = type_name2;
        param.type_name3 = type_name3;
        param.type_name4 = type_name4;
        param.worker1 = worker1;
        param.worker2 = worker2;
        param.worker3 = worker3;
        param.worker4 = worker4;
        // alert(worker1);return  false;
        // alert(type_name1);
        JQ.post('get_letter_print.php', param, function (res) {
            var obj = JSON.parse(res);
            //    alert(obj.w2);return false;
            JQ('.date_hide').hide();
            JQ('.date_show').html(obj.date);

            JQ('.worker1_hide').hide();
            JQ('.worker1_show').html(obj.w1);

            JQ('.worker2_hide').hide();
            JQ('.worker2_show').html(obj.w2);

            JQ('.worker3_hide').hide();
            JQ('.worker3_show').html(obj.w3);

            JQ('.worker4_hide').hide();
            JQ('.worker4_show').html(obj.w4);

            printdiv('letter');
        });


    });
</script>


</body>
