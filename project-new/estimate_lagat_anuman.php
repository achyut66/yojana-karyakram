<?php require_once("includes/initialize.php");
error_reporting(1);
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
if (isset($_POST['submit'])) {
    // print_r($_POST);
    // die();
    if ($_POST['update']==1) {
        $invest_details =  Plantotalinvestment::find_by_plan_id($_POST['plan_id']);
        if($invest_details) {
            $invest_details->kul_lagat_anuman = $_POST['sub_total'];
        } else {
            $invest_details = new Plantotalinvestment;
            $invest_details->kul_lagat_anuman = $_POST['sub_total'];
        }
        $invest_details->save();
        $profile = EstimateLagatProfile::find_by_plan_id($_POST['plan_id']);
        $del_lagats = Estimatelagatanuman::find_by_plan_id($_POST['plan_id']);
        foreach ($del_lagats as $del_lagat) {
            $del_lagat->delete();
        }
        $del_break_lagats = Estimatelagatanumanbreak::find_by_plan_id($_POST['plan_id']);
        foreach ($del_break_lagats as $del_break_lagat) {
            $del_break_lagat->delete();
        }
    } else {
        $profile = new EstimateLagatProfile;
    }

    $profile->sub_total         = $_POST['sub_total'];
    $profile->grand_total   = $_POST['grand_total'];
    $profile->plan_id       = $_POST['plan_id'];
    $profile->date_nepali   = $_POST['date_nepali'];
    $profile->date_english  = DateNepToEng($_POST['date_nepali']);
    $profile->save();
    $task_count = count($_POST['main_work_name']);
    $j=1;
    $main_row_index = 0;
    $cross_check = 0;
    for ($i=0; $i<$task_count; $i++) {
        $data = new Estimatelagatanuman;
        $data->break_type = 1;
//        $data->task_id               = $_POST['task_id'][$i];
        $data->main_work_name        = $_POST['main_work_name'][$i];
        $data->total_evaluation      = $_POST['total_evaluation'][$main_row_index];
        $data->unit_id               = $_POST['unit_id'][$i];
        $data->task_rate             = $_POST['task_rate'][$main_row_index];
        $data->total_rate            = $_POST['total_rate'][$main_row_index];
        $data->plan_id               = $_POST['plan_id'];
        $data->sno                   =   $j;
        $lagat_anuman_id = $data->save();
        $break_work_index = "break_work_name-".$j;
        $task_break_index = "task_count-".$j;
        $length_break_index = "length-".$j;
        $breadth_break_index = "breadth-".$j;
        $height_break_index = "height-".$j;
        $total_evaluation_break_index = "total_evaluation-".$j;
        $task_rate_break_index = "task_rate-".$j;
        $total_rate_break_index = "total_rate-".$j;
        $break_no_break_index = "break_no-".$j;
        $unit_id_break_index = "unit_id-".$j;
        $main_row_index++;
        if (isset($_POST[$task_break_index])) {
            $main_row_index--;
            $update_data = Estimatelagatanuman::find_by_id($lagat_anuman_id);
            $update_data->break_type = 2;
            $update_data->save();
            $break_count = count($_POST[$task_break_index]);
            $added_k = 1;
            for ($k=0; $k<$break_count; $k++) {
                $break_data =  new Estimatelagatanumanbreak;
                $break_data->break_work_name         = $_POST[$break_work_index][$k];
                $break_data->task_count              = $_POST[$task_break_index][$k];
                $break_data->length                  = $_POST[$length_break_index][$k];
                $break_data->breadth                 = $_POST[$breadth_break_index][$k];
                $break_data->height                  = $_POST[$height_break_index][$k];
                $break_data->total_evaluation        = $_POST[$total_evaluation_break_index][$k];
                $break_data->task_rate               = $_POST[$task_rate_break_index][$k];
                $break_data->total_rate              = $_POST[$total_rate_break_index][$k];
                $break_data->break_no                = $added_k;
                $break_data->unit_id                 = $_POST[$unit_id_break_index][$k] == '-1' ? $_POST['unit_id'][$i] : $_POST[$unit_id_break_index][$k];
                $break_data->plan_id                 = $_POST['plan_id'];
                $break_data->sno_taken               = $j;
                $break_data->deduct_part             = 0;
                $deduct_break_index = "deduct-".$j."_".$added_k;
                if (isset($_POST[$deduct_break_index])) {
                    $break_data->deduct_part         = 1;
                }
                $break_data->save();
                $added_k++;
            }
        } else {
            $break_data =  new Estimatelagatanumanbreak;
            $break_data->task_count              = $_POST['task_count'][$cross_check];
            $break_data->length                  = $_POST['length'][$cross_check];
            $break_data->breadth                 = $_POST['breadth'][$cross_check];
            $break_data->height                  = $_POST['height'][$cross_check];
            $break_data->total_evaluation        = $_POST['total_evaluation'][$i];
            $break_data->task_rate               = $_POST['task_rate'][$i];
            $break_data->total_rate              = $_POST['total_rate'][$i];
            $break_data->unit_id                 = $_POST['unit_id'][$i];
            $break_data->plan_id                 = $_POST['plan_id'];
            $break_data->sno_taken               = $j;
            $break_data->deduct_part             = 0;
            $break_data->save();

            $cross_check++;
        }

        $j++;
    }
    redirect_to("plan_form1.php");
}
if (!isset($_GET['id']) && isset($_SESSION['set_plan_id'])) {
    redirectUrl();
}

if ($_GET['id']!=$_SESSION['set_plan_id']):
    die('Invalid Format');
endif;
$profile_details = EstimateLagatProfile::find_by_plan_id($_GET['id']);
$sql = "select * from estimate_lagat_anuman where plan_id=".$_GET['id']." order by sno asc";
$lagat_details = Estimatelagatanuman::find_by_sql($sql);
if (!empty($profile_details) || !empty($lagat_details)) {
    $update = 1;
    $date_nepali = $profile_details->date_nepali;
    $save_text = "अपडेट गर्नुहोस";
    $view_link = '<a href="estimate_lagat_anuman_view.php" target="_blank" class="btn">इष्टिमेट हेर्नुहोस</a>';
} else {
    $date_nepali = "";
    $update = 0;
    $save_text = "सेभ गर्नुहोस";
    $view_link = '';
}

$data1 = Plandetails1::find_by_id($_GET['id']);
$estimate_details = Estimateanudandetails::find_by_plan_id($_GET['id']);
$estimate_anudan_result = Estimateanudandetails::find_by_plan_id($_GET['id']);
$added_investment   = $data1->investment_amount + $estimate_details->other_source + $estimate_details->other_agreement;
$con = get_contingency_for_plan($_GET['id']);
$contingency        = $added_investment* $con;
//$public_anudan   = $data1->investment_amount + $estimate_details->other_source +
$other_details      = $estimate_details->other_agreement + $estimate_details->samiti_investment;
$public_anudan = 0;
if (empty($profile_details)) {
    $profile_details = EstimateLagatProfile::setEmptyObjects();
} else {
    $public_anudan =  $profile_details->sub_total -($added_investment-$contingency + $estimate_details->samiti_investment);
}
$postnames          = Postname::find_all();
$units              = Units::find_all();
$work_details       = Worktopic::find_all();
$estimate_adds      = Estimateadd::find_all();
?>
<?php include("menuincludes/calculator_header.php"); ?>
<title>योजनाको कुल लागत अनुमान </title>

<body>

<?php include("menuincludes/topwrap.php"); ?>

<div class="maincontent">
    <h2 class="headinguserprofile myHeadingone">योजनाको इष्टिमेटको कुल लागत अनुमान | <a class="btn"
                                                                                        href="estimatedashboard.php" class="btn"> पछि जानुहोस </a> || <a href="upload_estimate.php"
                                                                                                                                                         class="btn">EXCEL UPLOAD</a></h2>


    <div class="OurContentFull title_wrap">
        <div class="myMessage"><?php echo $message;?>
        </div>
        <h1 class="myHeading1">दर्ता न :<?=convertedcit($_GET['id'])?>
        </h1>
        <div class="userprofiletable">

            <?php $data = Plandetails1::find_by_id($_GET['id']);?>

            <div>
                <h3 class="myHeading3"><?php echo $data->program_name; ?>
                </h3>
                <form method="post" enctype="multipart/form_data">
                    <h3 class="myHeading3">योजनाको इष्टिमेटको कुल लागत अनुमान | <?=$view_link?>
                    </h3>


                    <table class="table table-fixed table-bordered table-responsive myWidth100 myFont10 "
                           id="tableFixHead">
                        <thead>
                        <tr>
                            <th>सि.नं.</th>
                            <th>&nbsp;</th>
                            <!--                                <th></th>
                        <th></th>-->
                            <th colspan="3">विवरण</th>
                            <th>संख्या</th>
                            <th>लम्बाई</th>
                            <th>चौडाई</th>
                            <th>उचाई</th>
                            <th>परिमाण</th>
                            <th>इकाई</th>
                            <th>दर</th>
                            <th>जम्मा लागत रु.</th>
                            <th></th>
                        </tr>
                        </thead>

                        <?php if (empty($lagat_details)) { ?>
                        <tbody>

                        <tr class="remove_estimate_detail" id="remove_estimate_detail-1">
                            <td>1</td>
                            <td><img id="break-1" class="break" src="images/break.png" width="20px"
                                     height="20px" /></td>
                            <td id="estimate_sub-1" colspan="3"><textarea cols="30" rows="3"
                                                                          name="main_work_name[]"></textarea></td>
                            <td><input type="text" id="task_count-1" name="task_count[]" class="myWidth100" />
                            </td>
                            <td><input type="text" id="length-1" name="length[]" class="myWidth100" /><button
                                        type="button" class="calculator cl_bg" data-toggle="modal"
                                        data-target="#myModal" id="length-1-c"> &nbsp; </button></td>
                            <td><input type="text" id="breadth-1" name="breadth[]" class="myWidth100" /><button
                                        type="button" class="calculator cl_bg" data-toggle="modal"
                                        data-target="#myModal" id="breadth-1-c"> &nbsp; </button></td>
                            <td><input type="text" id="height-1" name="height[]" class="myWidth100" /><button
                                        type="button" class="calculator cl_bg" data-toggle="modal"
                                        data-target="#myModal" id="height-1-c"> &nbsp; </button></td>
                            <td><input type="text" id="total_evaluation-1" name="total_evaluation[]"
                                       class="myWidth100" /></td>
                            <td id="unit-1"><select name="unit_id[]">
                                    <option value="">----</option>
                                    <?php foreach ($units as $unit): ?>
                                        <option
                                                value="<?=$unit->id?>">
                                            <?=$unit->name?>
                                        </option>
                                    <?php endforeach; ?>
                            </td>
                            <td><input type="text" id="task_rate-1" name="task_rate[]" class="myWidth100" />
                            </td>
                            <td><input type="text" id="total_rate-1" name="total_rate[]" class="myWidth100" />
                            </td>
                            <td></td>
                        </tr>



                        <?php } else { ?>
                            <?php  $count = 1; foreach ($lagat_details as $lagat_detail): ?>
                                <?php $break_lagats = ''; if ($lagat_detail->break_type==2) {
                                    $break_lagats = Estimatelagatanumanbreak::find_by_plan_id_sno($_GET['id'], $count);
                                }?>
                                <?php $sql="select * from estimate_add where task_id=".$lagat_detail->task_id;
                                $task_results = Estimateadd::find_by_sql($sql);
                                ?>
                                <?php if (!empty($break_lagats)):// break row starts here?>
                                    <tr class="remove_estimate_detail" id="remove_estimate_detail-<?=$count?>">
                                        <td><?=$count?>
                                        </td>
                                        <td><img id="break-<?=$count?>"
                                                 class="break" src="images/break.png" width="20px" height="20px" /></td>
                                        <td colspan="3"
                                            id="estimate_sub-<?=$count?>">
                                        <textarea cols="30" rows="3"
                                                  name="main_work_name[]"><?=$lagat_detail->main_work_name?></textarea>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="unit-1"><select name="unit_id[]">
                                                <option value="">----</option>
                                                <?php foreach ($units as $unit): ?>
                                                    <option
                                                            value="<?=$unit->id?>"
                                                        <?php if ($lagat_detail->unit_id==$unit->id) {?>
                                                            selected="selected" <?php } ?>><?=$unit->name?>
                                                    </option>
                                                <?php endforeach; ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $j = 1; foreach ($break_lagats as $break_lagat): // populating the breaks
                                        setObjectValuesFromZeroToBlank($break_lagat);
                                        ?>
                                        <tr id="break_row-<?=$count?>_<?=$j?>"
                                            class="break_row-<?=$count?>">
                                            <td></td>
                                            <td><?=$count?>.<?=$j?>
                                            </td>
                                            <td> घटाउने भाग <input class="deduct_part" <?php if ($break_lagat->deduct_part==1) { ?>
                                                    checked="checked" <?php } ?>
                                                                   id="deduct-<?=$count?>_<?=$j?>" type="checkbox"
                                                                   name="deduct-<?=$count?>_<?=$j?>" value="1" /></td>
                                            <td colspan="2"><textarea rows="3"
                                                                      name="break_work_name-<?=$count?>[]"><?=$break_lagat->break_work_name?></textarea>
                                            </td>
                                            <td><input type="text"
                                                       id="task_count-<?=$count?>_<?=$j?>"
                                                       name="task_count-<?=$count?>[]"
                                                       value="<?=$break_lagat->task_count?>"
                                                       class="myWidth100"></td>
                                            <td><input type="text"
                                                       id="length-<?=$count?>_<?=$j?>"
                                                       name="length-<?=$count?>[]"
                                                       value="<?=$break_lagat->length?>"
                                                       class="myWidth100"><button type="button" class="calculator cl_bg"
                                                                                  data-toggle="modal" data-target="#myModal"
                                                                                  id="length-<?= $count ?>_<?=$j?>-c">
                                                    &nbsp;</button></td>
                                            <td><input type="text"
                                                       id="breadth-<?=$count?>_<?=$j?>"
                                                       name="breadth-<?=$count?>[]"
                                                       value="<?=$break_lagat->breadth?>"
                                                       class="myWidth100"><button type="button" class="calculator cl_bg"
                                                                                  data-toggle="modal" data-target="#myModal"
                                                                                  id="breadth-<?= $count ?>_<?=$j?>-c">
                                                    &nbsp;</button></td>
                                            <td><input type="text"
                                                       id="height-<?=$count?>_<?=$j?>"
                                                       name="height-<?=$count?>[]"
                                                       value="<?=$break_lagat->height?>"
                                                       class="myWidth100"><button type="button" class="calculator cl_bg"
                                                                                  data-toggle="modal" data-target="#myModal"
                                                                                  id="height-<?= $count ?>_<?=$j?>-c">
                                                    &nbsp;</button></td>
                                            <td><input type="text"
                                                       id="total_evaluation-<?=$count?>_<?=$j?>"
                                                       name="total_evaluation-<?=$count?>[]"
                                                       value="<?=$break_lagat->total_evaluation?>"
                                                       class="myWidth100"></td>
                                            <td id="unit-<?=$count?>_<?=$j?>"><select name="unit_id-<?=$count?>[]">
                                                    <option value="-1">----</option>
                                                    <?php foreach ($units as $unit): ?>
                                                        <option
                                                            <?php if($break_lagat->unit_id == $unit->id) {echo 'selected';} ?>
                                                                value="<?=$unit->id?>">
                                                            <?=$unit->name?>
                                                        </option>
                                                    <?php endforeach; ?>
                                            </td>
                                            <td><input type="text" id="task_rate-<?=$count?>_<?=$j?>" value="<?=$break_lagat->task_rate?>" name="task_rate-<?=$count?>[]" class="myWidth100" />
                                            </td>
                                            <td><input type="text" id="total_rate-<?=$count?>_<?=$j?>" value="<?=$break_lagat->total_rate?>" name="total_rate-<?=$count?>[]" class="myWidth100" />
                                            </td>
                                            <td><img src="images/cross.png" class="remove_break"
                                                     id="cross-<?=$count?>_<?=$j?>"
                                                     name="cross" width="20px" height="20px" /></td>
                                        </tr>
                                        <?php $j++; endforeach; ?>
                                <?php endif; // break row ends here?>
                                <?php if (empty($break_lagats)):// without break single row starts here
                                    $single_break = Estimatelagatanumanbreak::find_single_row($_GET['id'], $count);
                                    setObjectValuesFromZeroToBlank($single_break);
                                    ?>
                                    <tr id="remove_estimate_detail-<?=$count?>"
                                        class="remove_estimate_detail">
                                        <td><?=$count?>
                                        </td>
                                        <td><img id="break-<?=$count?>"
                                                 class="break" src="images/break.png" width="20px" height="20px" /></td>
                                        <!--                                        <td>
                                             <select name="task_id[]" id="task_id-1">
                                                            <option value="">---छान्नुहोस्---</option>
                                                            <?php foreach ($work_details as $data):?>
                                    <option
                                        value="<?php echo $data->id;?>"
                                        <?php if ($lagat_detail->task_id==$data->id) {?>
                                        selected="selected" <?php } ?>><?php echo $data->work_name;?>
                                    </option>
                                    <?php endforeach; ?>
                                    </select>
                                    </td>
                                    <td id="task_name_column-1"></td>-->
                                        <td id="estimate_sub-1" colspan="3"><textarea cols="30" rows="3"
                                                                                      name="main_work_name[]"><?=$lagat_detail->main_work_name?></textarea>
                                        </td>
                                        <td><input type="text"
                                                   id="task_count-<?=$count?>"
                                                   name="task_count[]" class="myWidth100"
                                                   value="<?=$single_break->task_count?>" />
                                        </td>
                                        <td><input type="text"
                                                   id="length-<?=$count?>"
                                                   name="length[]" class="myWidth100"
                                                   value="<?=$single_break->length?>" /><button
                                                    type="button" class="calculator cl_bg" data-toggle="modal"
                                                    data-target="#myModal"
                                                    id="length-<?= $count ?>-c">
                                                &nbsp; </button></td>
                                        <td><input type="text"
                                                   id="breadth-<?=$count?>"
                                                   name="breadth[]" class="myWidth100"
                                                   value="<?=$single_break->breadth?>" /><button
                                                    type="button" class="calculator cl_bg" data-toggle="modal"
                                                    data-target="#myModal"
                                                    id="breadth-<?= $count ?>-c">&nbsp;
                                            </button></td>
                                        <td><input type="text"
                                                   id="height-<?=$count?>"
                                                   name="height[]" class="myWidth100"
                                                   value="<?=$single_break->height?>" /><button
                                                    type="button" class="calculator cl_bg" data-toggle="modal"
                                                    data-target="#myModal"
                                                    id="height-<?= $count ?>-c">
                                                &nbsp;</button></td>
                                        <td><input type="text"
                                                   id="total_evaluation-<?=$count?>"
                                                   name="total_evaluation[]"
                                                   value="<?=$lagat_detail->total_evaluation?>"
                                                   class="myWidth100" /></td>
                                        <td id="unit-1"><select name="unit_id[]">
                                                <option value="">----</option>
                                                <?php foreach ($units as $unit): ?>
                                                    <option
                                                            value="<?=$unit->id?>"
                                                        <?php if ($lagat_detail->unit_id==$unit->id) {?>
                                                            selected="selected"<?php } ?>><?=$unit->name?>
                                                    </option>
                                                <?php endforeach; ?>
                                        </td>
                                        <td><input type="text"
                                                   id="task_rate-<?=$count?>"
                                                   name="task_rate[]" class="myWidth100"
                                                   value="<?=$lagat_detail->task_rate+0?>" />
                                        </td>
                                        <td><input type="text"
                                                   id="total_rate-<?=$count?>"
                                                   name="total_rate[]" class="myWidth100"
                                                   value="<?=$lagat_detail->total_rate+0?>" />
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php endif;// without break single row ends here?>
                                <?php $count++; endforeach; ?>
                        <?php } ?>
                        <tbody id="estimate_add_more_table">

                        </tbody>
                    </table>
                    <table class="myWidth100">
                        <tr>
                            <td class="myCenter">
                                <div class="add btn">थप्नुहोस </div>
                            </td>
                            <td class="myCenter">
                                <div class="remove btn">हटाउनुहोस् </div>
                                <input type="hidden" name="update"
                                       value="<?=$update?>" />
                                <input type="hidden" name="plan_id"
                                       value="<?=$_GET['id']?>" />
                            </td>
                            <td class="myCenter"><input type="submit" name="submit"
                                                        value="<?=$save_text?>"
                                                        class="btn"></td>
                            <td class="myCenter"><input type="text" name="date_nepali"
                                                        value="<?=$date_nepali?>"
                                                        id="nepaliDate3" required /></td>
                        </tr>
                    </table>

                    <table class="table table-bordered table-responsive myWidth100 myFont10">
                        <tr>
                            <td colspan="10" id="task_name-1" style="text-align: right;">जम्मा</td>
                            <td>
                                <input
                                        type="text"
                                        readonly="true"
                                        name="sub_total"
                                        value="<?=$profile_details->sub_total?>"
                                        id="sub_total"
                                />
                            </td>
                        </tr>
                        </tr>
                    </table>

                </form>
            </div>

        </div>
    </div>
</div><!-- top wrap ends -->
<script src="js/calculator.js"></script>
<?php include("menuincludes/footer.php"); ?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:295px !important; top:20%;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Calculator</h4>
            </div>
            <div class="modal-body">
                <form name="scientific_calculator">
                    <table class="mycaltabe" cellspacing="0" cellpadding="1">

                        <tr>
                            <td colspan="3" align="center"><input name="display" class="sc" id="display_cacl_value"
                                                                  onkeydown="if (event.keyCode == 13){
                                                    document.getElementById('calc').click();  event.preventDefault();}"
                                                                  value="0" size="44" maxlength="25"></td>
                        </tr>

                        <tr>
                            <td align="center"><input type="button" value="Clear"
                                                      onclick="this.form.display.value = 0 ">
                                <span id="textbox_id" class="hidden"></span>
                                <span id="hidden_id" class="hidden"></span>
                            </td>
                            <td align="center"><input type="button" value=" Cancel "
                                                      onclick="deleteChar(this.form.display)"></td>
                            <td align="center"><input type="button" id="calc" value=" Ok  " NAME="Enter"
                                                      onclick="if (checkNum(this.form.display.value)) { compute(this.form) }"></td>
                        </tr>
                        <tr>
                            <td align="center"><input type="button" value=" exp "
                                                      onclick="if (checkNum(this.form.display.value)) { exp(this.form) }"></td>
                            <td align="center"><input type="button" value="  ln   "
                                                      onclick="if (checkNum(this.form.display.value)) { ln(this.form) }"></td>
                            <td align="center"><input type="button" value=" sqrt "
                                                      onclick="if (checkNum(this.form.display.value)) { sqrt(this.form) }"></td>

                        </tr>
                        <tr>
                            <td align="center"><input type="button" value="  sq  "
                                                      onclick="if (checkNum(this.form.display.value)) { square(this.form) }"></td>
                            <td align="center"><input type="button" value="cos"
                                                      onclick="if (checkNum(this.form.display.value)) { cos(this.form) }"></td>
                            <td align="center"><input type="button" value=" sin "
                                                      onclick="if (checkNum(this.form.display.value)) { sin(this.form) }"></td>
                        </tr>
                        <tr>
                            <td align="center"><input type="button" value="   (    "
                                                      onclick="add_value(this.form.display, '(')"></td>


                            <td align="center"><input type="button" value=" tan"
                                                      onclick="if (checkNum(this.form.display.value)) { tan(this.form) }"></td>
                            <td align="center"><input type="button" value="   )   "
                                                      onclick="add_value(this.form.display, ')')"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default calculator_modal" id="calc_close"
                        data-dismiss="modal">Transfer</button>
            </div>
        </div>

    </div>
</div>