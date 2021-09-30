<?php require_once("includes/initialize.php");
error_reporting(E_ALL);
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
$fiscal_year_all= Fiscalyear::find_all();
include 'Classes/PHPExcel/IOFactory.php';
if (isset($_POST['submit'])) {
    // print_r($_FILES);exit;
    $file = $_FILES['estimate']['name'];
    //$random = mt_rand(10, 999);
    move_uploaded_file($_FILES['estimate']['tmp_name'], 'estimate_excel/'.$_FILES['estimate']['name']);
    $filename  = 'estimate_excel/'.$_FILES['estimate']['name'];
    $inputFileName = $filename;
    //  $inputFileName = $_FILES['estimate']['tmp_name'];
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    //print_r($allDataInSheet); exit;
    $arrayCount = count($allDataInSheet);

    $del_lagats = Estimatelagatanuman::find_by_plan_id($_SESSION['set_plan_id']);
    foreach ($del_lagats as $del_lagat) {
        $del_lagat->delete();
    }
    $del_break_lagats = Estimatelagatanumanbreak::find_by_plan_id($_SESSION['set_plan_id']);
    foreach ($del_break_lagats as $del_break_lagat) {
        $del_break_lagat->delete();
    }


    $subtotal =0;
    $main_row_index = 1;
    $sub_row_index = 1;
    // preserve main row data
    $main_task_rate = 0;
    $hasEmptyUnit = false;
    // start for loop
    for ($i=2;$i<=($arrayCount);$i++) {
        // check if A, B, C, D, are empty : if empty do nothing
        if (empty(($allDataInSheet[$i]["A"]).($allDataInSheet[$i]["B"]).($allDataInSheet[$i]["C"]).($allDataInSheet[$i]["D"]))) {
            continue;
        }

        //check for i[A] === counter :
        if ($allDataInSheet[$i]["A"] == $main_row_index) {
            // preserving
            $main_task_rate = trim($allDataInSheet[$i]["I"]);
            // row 2, row 3 are not empty
            if (!empty($allDataInSheet[$i]["C"]) && !empty($allDataInSheet[$i]["D"])) {
                // i[C] and i[D] not empty => main index without subindex
                $data = new Estimatelagatanuman();
                $data->break_type = 1;
                $data->main_work_name        = trim($allDataInSheet[$i]["B"]);
                $data->total_evaluation      = trim($allDataInSheet[$i]["G"]);
                $data->unit_text             = trim($allDataInSheet[$i]["H"]);
                $unit_id = Units::get_id_by_name_or_alias(trim($allDataInSheet[$i]["H"]));
                if (!empty($unit_id)) {
                    $data->unit_id           = $unit_id;
                } else {
                    $hasEmptyUnit = true;
                }
                $data->task_rate             = trim($allDataInSheet[$i]["I"]);
                $data->total_rate            = trim($allDataInSheet[$i]["G"]) * trim($allDataInSheet[$i]["I"]);
                $data->plan_id               = $_SESSION['set_plan_id'];
                $data->sno                   =   $main_row_index;
                $data->save();
                $subtotal += (float)(trim($allDataInSheet[$i]["J"]));
                $break_data =  new Estimatelagatanumanbreak();
                $break_data->task_count              = trim($allDataInSheet[$i]["C"]);
                $break_data->length                  = trim($allDataInSheet[$i]["D"]);
                $break_data->breadth                 = trim($allDataInSheet[$i]["E"]);
                $break_data->height                  = trim($allDataInSheet[$i]["F"]);
                $break_data->total_evaluation        = trim($allDataInSheet[$i]["G"]);
                $break_data->break_work_name         = trim($allDataInSheet[$i]["B"]);
                $break_data->plan_id                 = $_SESSION['set_plan_id'];
                $break_data->sno_taken               = $main_row_index;
                $break_data->break_no                = 1;

                if (empty(trim($allDataInSheet[$i]["K"]))) {
                    $break_data->deduct_part             = 0;
                } else {
                    $break_data->deduct_part             = 1;
                }
                $break_data->save();
            } else {
                $data = new Estimatelagatanuman();
                $data->break_type = 2;
                $data->main_work_name        = trim($allDataInSheet[$i]["B"]);
                $data->unit_text             = trim($allDataInSheet[$i]["H"]);
                $unit_id = Units::get_id_by_name(trim($allDataInSheet[$i]["H"]));
                if (!empty($unit_id)) {
                    $data->unit_id           = $unit_id;
                } else {
                    $hasEmptyUnit = true;
                }
                $data->task_rate             = trim($allDataInSheet[$i]["I"]);
                $data->plan_id               = $_SESSION['set_plan_id'];
                $data->sno                   =   $main_row_index;
                $data->save();
                // end
            }

            $main_row_index++;
            $sub_row_index = 1;
        } elseif ($allDataInSheet[$i]["A"] != $main_row_index) {
            // subindex
            if (empty($allDataInSheet[$i]["B"]) || empty($allDataInSheet[$i]["C"]) || empty($allDataInSheet[$i]["D"])) {
                continue;
            }
            // do subindex work
            $break_data =  new Estimatelagatanumanbreak;
            $break_data->task_count              = trim($allDataInSheet[$i]["C"]);
            $break_data->length                  = trim($allDataInSheet[$i]["D"]);
            $break_data->breadth                 = trim($allDataInSheet[$i]["E"]);
            $break_data->height                  = trim($allDataInSheet[$i]["F"]);
            $break_data->total_evaluation        = trim($allDataInSheet[$i]["G"]);
            $break_data->break_work_name         = trim($allDataInSheet[$i]["B"]);
            $break_data->plan_id                 = $_SESSION['set_plan_id'];
            $break_data->sno_taken               = $main_row_index - 1;
            $break_data->break_no                = $sub_row_index;
            if (empty(trim($allDataInSheet[$i]["I"]))) {
                $break_data->task_rate = $main_task_rate;
            } else {
                $break_data->task_rate = trim($allDataInSheet[$i]["I"]);
            }
            if (empty(trim($allDataInSheet[$i]["H"]))) {
                $break_data->unit_id = $data->unit_id;
            } else {
                $unit_id = Units::get_id_by_name_or_alias(trim($allDataInSheet[$i]["H"]));
                if (!empty($unit_id)) {
                    $break_data->unit_id           = $unit_id;
                } else {
                    $hasEmptyUnit = true;
                }
            }

            if (empty(trim($allDataInSheet[$i]["J"]))) {
                $break_data->total_rate = trim($allDataInSheet[$i]["G"]) * $main_task_rate;
            } else {
                $break_data->total_rate = trim($allDataInSheet[$i]["J"]);
            }
            if (empty(trim($allDataInSheet[$i]["K"]))) {
                $break_data->deduct_part             = 0;
            } else {
                $break_data->deduct_part             = 1;
            }
            $break_data->save();
            $sub_row_index++;

            $qty_sum = 0;
            if (empty(trim($allDataInSheet[$i]["K"]))) {
                $qty_sum += (float)(trim($allDataInSheet[$i]["G"]));
            } else {
                $qty_sum -= (float)(trim($allDataInSheet[$i]["G"]));
            }
            $estimate_lagat_anuman = Estimatelagatanuman::find_by_plan_id_sno($_SESSION['set_plan_id'], $main_row_index - 1);
            $estimate_lagat_anuman->total_evaluation += $qty_sum;
            $estimate_lagat_anuman->total_rate += trim($allDataInSheet[$i]["G"]) * $estimate_lagat_anuman->task_rate;
            $estimate_lagat_anuman->save();
            $subtotal += trim($allDataInSheet[$i]["G"]) * $estimate_lagat_anuman->task_rate;
        }
    }
    $profile = EstimateLagatProfile::find_by_plan_id( $_SESSION['set_plan_id']);
//    $profile->delete();
    $estimate_lagat_profile = new EstimateLagatProfile();
    $estimate_lagat_profile->sub_total = $subtotal;
    $estimate_lagat_profile->plan_id   = $_SESSION['set_plan_id'];
    $estimate_lagat_profile->date_nepali = $_POST['date_nepali'];
    $estimate_lagat_profile->date_english  = DateNepToEng($_POST['date_nepali']);
    $estimate_lagat_profile->save();
    if($hasEmptyUnit) {
        $session->message("युनिट अपडेट गर्नुहोस। ");
    }
    redirect_to("estimate_lagat_anuman.php");

}


if (!isset($_GET['id']) && isset($_SESSION['set_plan_id'])) {
    redirectUrl();
}
$check_plan = isset($_SESSION['check_type']) && $_SESSION['check_type'];
$date_nepali = isset($_POST['date_nepali']) && $_POST['date_nepali'];
//echo $check_plan; exit;
if ($_GET['id']!=$_SESSION['set_plan_id']):
    die('Invalid Format');
endif;

?>
<?php include("menuincludes/header.php"); ?>
    <title>योजनाको कुल लागत अनुमान </title>

    <body>

<?php include("menuincludes/topwrap.php"); ?>

    <div class="maincontent">
        <h2 class="headinguserprofile myHeadingone">योजनाको इष्टिमेटको कुल लागत अनुमान | <a class="btn"
                                                                                            href="estimatedashboard.php" class="btn"> पछि जानुहोस </a></h2>


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
                    <form method="post" enctype="multipart/form-data">
                        <h3 class="myHeading3">योजनाको इष्टिमेटको कुल लागत अनुमान
                        </h3>
                        <table class="table table-hover">
                            <tr>
                                <th>मिति</th>
                                <td>
                                    <input type="text" name="date_nepali"
                                           value="<?=$date_nepali?>"
                                           id="nepaliDate3" required />
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    इष्टिमेटको Excel
                                </th>
                                <td>
                                    <input type="file" name="estimate" required>
                                </td>
                                <td>
                                    <input class="btn" type="submit" name="submit" value="अप्लोड">
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="type"
                               value="<?= $check_plan ?>">
                    </form>
                    <span><a href="sample/book.xlsx" type="download" class="btn">Download Sample</a></span><br>
                    <center><b>NOTE:</b> <b><u></ब> कृपया ध्यान दिनुहोस ....यदि घटाउने भाग भएमा Remarks मा 1 लेख्नु होला
                                |</u></b></center>
                </div>
                <div id="dialog_show" class="modal show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                </div><!-- main menu ends -->
            </div>
        </div>
    </div><!-- top wrap ends -->
<?php include("menuincludes/footer.php");
