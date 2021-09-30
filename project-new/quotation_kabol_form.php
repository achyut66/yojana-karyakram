<?php require_once("includes/initialize.php");
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
if (!isset($_GET['id']) && isset($_SESSION['set_plan_id'])) {
    redirectUrl();
}
$enlist_result = Enlist::find_all();
$contractor_result = Contractordetails::find_all();

$merge_enlist_result = array_merge($enlist_result, $contractor_result);
//echo '<pre>';
//print_r($merge_enlist_result);
//echo '</pre>';exit;
//echo Contingency:: find_by_type(1);

$kabol_result = Quotationenlist::find_by_plan_id($_GET['id']);
$kabol_result_delete = $kabol_result;
//echo '<pre>';
//print_r($kabol_result);
//echo '<pre>';exit;

if ($_GET['id'] != $_SESSION['set_plan_id']):
    die('Invalid Format');
endif;
//save code
if (isset($_POST['submit'])) {
//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre>';exit;

    if (!empty($kabol_result_delete)) {
        foreach ($kabol_result_delete as $kabol):
            $kabol->delete();
        endforeach;
    }

    $i = 0;
    foreach ($_POST['enlist_id'] as $enlist_id) {
        $enlist_array = explode('-', $enlist_id);
        $en_id = $enlist_array[0];
        $en_type = $enlist_array[1];
        $qti = new Quotationenlist();
        $qti->plan_id = $_POST['plan_id'];
        $qti->enlist_id = $en_id;
        $qti->enlist_type = $en_type;
        $qti->amount = $_POST['amount'][$i];
        $qti->extra_amount = $_POST['extra_amount'][$i];
        $qti->is_vat = $_POST['is_vat'][$i];
        $qti->remarks = $_POST['remarks'][$i];
        $qti->save();
        $i++;
    }
    echo alertBox('थप सफल', 'quotation_kabol_form.php?id=' . $_POST['plan_id']);

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
<title>योजना कबोल फारम :: <?php echo SITE_SUBHEADING; ?></title>
<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">
    <div class="maincontent">
        <h2 class="headinguserprofile">योजनाको कुल लागत अनुमान | <a href="quotationDashboard.php" class="btn">पछि
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
                                <h1> योजनाको कोटेसन् कबोल फारम </h1>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>#</th>
                                        <th>कम्पनी / निर्माण निर्माण ब्यवोसायी</th>

                                        <th>कबोल रकम</th>
                                        <th>ढुवानी र अन्य खर्च रकम</th>
                                        <th>मु.अ. कर सहित (हो / होईन )</th>
                                        <th>कैफियत</th>

                                    </tr>
                                    <?php if (empty($kabol_result)) { ?>
                                        <tbody id="detail_add_table">

                                        <tr>
                                            <td>१</td>
                                            <td>

                                                <select name="enlist_id[]" class="select22">
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
                                                </select></td>
                                            <td><input type="text" name="amount[]"/></td>
                                            <td><input type="text" name="extra_amount[]"/></td>
                                            <td>हो : <input type="radio" name="is_vat[0]" value="1"/> होईन : <input
                                                        type="radio" name="is_vat[0]" value="2"/></td>
                                            <td><input type="text" name="remarks[]"/></td>
                                        </tr>

                                        </tbody>

                                    <?php } else { ?>
                                        <tbody id="detail_add_table" >
                                        <?php $i=0; foreach ($kabol_result as $kr): ?>
                                            <tr <?php if($i!=1){?> class="remove_kabol_form" <?php }?>>
                                                <td><?= convertedcit(($i+1)) ?></td>
                                                <td>

                                                    <select name="enlist_id[]" class="select22">
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
                                                            <option <?php if(($kr->enlist_id==$en->id)&&($kr->enlist_type==$save_type)){ echo 'selected="selected"';} ?> value="<?= $en->id ?>-<?= $save_type ?>"><?= $name . ' (' . $type . ') ' ?></option>
                                                        <?php endforeach; ?>
                                                    </select></td>
                                                <td><input value="<?= $kr->amount ?>" type="text" name="amount[]"/></td>
                                                <td><input type="text" value="<?= $kr->extra_amount ?>" name="extra_amount[]"/></td>
                                                <td>हो : <input type="radio" <?php if(($kr->is_vat==1)){ echo 'checked="checked"';} ?> name="is_vat[<?= $i ?>]" value="1"/> होईन : <input
                                                            type="radio" name="is_vat[<?= $i ?>]" value="2" <?php if(($kr->is_vat==2)){ echo 'checked="checked"';} ?> /></td>
                                                <td><input value="<?= $kr->remarks ?>" type="text" name="remarks[]"/></td>
                                            </tr>
                                        <?php $i++; endforeach; ?>

                                        </tbody>
                                    <?php } ?>
                                    <tr>

                                        <th>
                                            <div class="add_plan_form1 btn myWidth100">थप्नुहोस [+]</div>
                                        </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <div class="remove_plan_form1 btn myWidth100">हटाउनुहोस [-]</div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td><input class="btn btn-primary" type="submit" name="submit"
                                                   value="सेभ गर्नुहोस"/></td>
                                        <td colspan="2"></td>

                                    </tr>

                                </table>

                                <input type="hidden" name="plan_id" value="<?= $_GET['id'] ?>">
                                <!-- input wrap 33 ends -->


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
                var num = JQ(".remove_kabol_form").length;
                var counter = num + 2;
                //           alert(counter);return false;
                var param = {};
                param.counter = counter;
                JQ.post('get_quotation_kabol_form.php', param, function (res) {
                    var obj = JSON.parse(res);
                    //alert(obj.html);
                    JQ("#detail_add_table").append(obj.html);
                    //JQ('#interest_amount_'+id).val(obj.interest_amount);

                    // alert(obj.interest_amount);
                    JQ('.select22').select2();
                });

            });

            JQ(document).on("click", ".remove_plan_form1", function () {
                JQ('.remove_kabol_form').last().remove();

            });
            JQ(document).on("click", ".remove_btn", function () {
                JQ(this).closest('tr').remove();
                var i = 1;
                JQ(".sn").each(function () {
                    JQ(this).html(i + 1);
                    i++;
                });


            });
            JQ('.select22').select2();
        </script>
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
