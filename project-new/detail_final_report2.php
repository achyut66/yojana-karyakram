<?php require_once("includes/initialize.php");
if (!$session->is_logged_in()) {
    redirect_to("logout.php");
}
$mode = getUserMode();
$max_ward = Ward::find_max_ward_no();
error_reporting(0);
$user = getUser();
$topic_area = Topicarea::find_all();

$format = "";
$type = "";
$fiscal_id = Fiscalyear::find_current_id();
$error_id = array();
$counted_result = getOnlyRegisteredPlans();
//echo $fiscal_id;
if (isset($_POST['submit'])) {
    ini_set('max_execution_time', 300);
    $counted_result = getOnlyRegisteredPlans($_POST['ward_no']);
    $type = $_POST['type'];

    //$topic_area_type_id=$_POST['topic_area_type_id'];


}
$final_plan_array = $counted_result['final_count_array'];
//echo count($final_plan_array);exit;
$plan_id_string = implode(",", $final_plan_array);
include("menuincludes/header.php"); ?>
<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">

    <div class="maincontent">
        <h2 class="headinguserprofile"> बिस्तृत रिपोर्ट हेर्नुहोस | <a href="report_dashboard.php" class="btn">पछि
                जानुहोस</a></h2>


        <div class="OurContentFull">

            <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
            <div class="userprofiletable">

                <form method="post">

                        <div class="inputWrap">
                            <h1>बिस्तृत रिपोर्ट हेर्नुहोस </h1>
                            <div class="titleInput">किसिम छान्नुहोस्:</div>
                            <div class="newInput"><select name="type" required>
                                    <option value="">--छान्नुहोस्--</option>
                                    <option value="0"<?php if ($type == 0) {
                                        echo 'selected="selected"';
                                    } ?>>योजना
                                    </option>
                                    <option value="1"<?php if ($type == 1) {
                                        echo 'selected="selected"';
                                    } ?>>कार्यक्रम
                                    </option>
                                </select></div>

                            <div class="titleInput">वार्ड छान्नुहोस् :</div>
                            <?php if ($mode == "user"): ?>
                                <div class="newInput"><select name="ward_no">
                                        <option value="<?= $user->ward ?>"><?= convertedcit($user->ward) ?></option>
                                    </select></div>
                            <?php else: ?>
                                <div class="newInput"><select name="ward_no">
                                        <option value="">-छान्नुहोस्-</option>
                                        <?php for ($i = 1; $i <= $max_ward; $i++): ?>
                                            <option value="<?= $i ?>" <?php if ($ward == $i) {
                                                echo 'selected="selected"';
                                            } ?>><?= convertedcit($i) ?></option>
                                        <?php endfor; ?>
                                    </select></div>
                            <?php endif; ?>
                            <div class="titleInput" id="topic_area_type_id">
                            </div>
                            <div class="saveBtn myWidth100 "><input type="submit" name="submit" value="खोज्नुहोस"
                                                                    class="btn"></div>
                            <div class="myspacer"></div>
                        </div><!-- input wrap ends -->


                </form>


                <?php $fiscal_id = Fiscalyear::find_current_id(); ?>
                <div style="" class="myPrint"><a
                            href="detail_final_report2_excel.php?ward_no=<?= $_POST['ward_no']; ?>">Export to excel</a>
                    <span onClick="printdiv('div_print');">प्रिन्ट गर्नुहोस </i></span>
                </div>
                <br>
                <div id="div_print">
                    <div style="text-align:center;">
                        <span style="text-align:center;"><?php echo SITE_LOCATION; ?></span><br>
                        <span style="text-align:center;"><?= SITE_ADDRESS ?></span><br>
                        <span style="text-align:center;">आ.व. २०७६.०७७ को बार्षिक प्रगति प्रतिबेदन</span>

                    </div>
                    <div class="subjectboldright"></div>
                    <?php
                    $topic_area_copy = $topic_area;
                    $plan_id_string_copy = $plan_id_string;
                    $final_topic_area = array();
                    foreach ($topic_area as $da):
                        $plans_check = Plandetails1::find_by_sql('select id, program_name, type, investment_amount  from plan_details1 where id in(' . $plan_id_string_copy . ') and type=0 and topic_area_id=' . $da->id);
                        if (!empty($plans_check)):
                            array_push($final_topic_area, $da);
                        endif;
                    endforeach;
                    ?>
                    <?php $z = 1;
                    $total1= 0 ;
                    $total2= 0;
                    $total3=0 ;
                    $total4 =0;
                    $total5=0;
                    $total6=0;
                    $suchak_bhar_percent_total = 0;
                    $suchak_bhautik_percent_total = 0;
                    ?>
                    <table class="table table-bordered table-hovtoer">
                    <?php
                     foreach ($final_topic_area

                    as $topic){
                    $i = 1;
                    ?>
                    <tr>
                        <td colspan="16"> <h2><?= $topic->name ?></h2></td>
                    </tr>


                        <tr class="title_wrap">
                            <td class="myCenter" rowspan="2"><strong>सि.नं.</strong></td>
                            <td class="myCenter" rowspan="2"><strong>दर्ता.नं.</strong></td>
                            <td class="myCenter" rowspan="2"><strong>कार्यक्रम / क्रियाकलाप </strong></td>
                            <td class="myCenter" rowspan="2"><strong>इकाई</strong></td>
                            <td class="myCenter" colspan="3"><strong>वार्षिक लक्ष्य</strong></td>
                            <td class="myCenter" colspan="3"><strong>यस अवधिसम्मको लक्ष्य</strong></td>
                            <td class="myCenter" colspan="3"><strong>यस अवधिसम्मको भौतिक प्रगति</strong></td>
                            <td class="myCenter" colspan="2"><strong>यस अवधिसम्मको खर्च</strong></td>
                            <td class="myCenter"><strong>कैफियत</strong></td>

                        </tr>
                        <tr>
                            <td>सूचक</td>
                            <td>भार</td>
                            <td>बजेट</td>
                            <td>सूचक</td>
                            <td>भार</td>
                            <td>बजेट</td>
                            <td>सूचक</td>
                            <td>भार</td>
                            <td>प्रतिशत</td>
                            <td>रकम रु</td>
                            <td>प्रतिशत</td>
                            <td></td>
                        </tr>


                        <tr>
                            <td></td>
                            <td>१</td>
                            <td>२</td>
                            <td>३</td>
                            <td>४</td>
                            <td>५</td>
                            <td>६</td>
                            <td>७</td>
                            <td>८</td>
                            <td>९</td>
                            <td>१०</td>
                            <td>११</td>
                            <td>१२</td>
                            <td>१३</td>
                            <td>१४</td>
                            <td>१५</td>
                        </tr>
                        <?php

                        $karikram_contribution = 0;
                        $plans = Plandetails1::find_by_sql('select id, program_name, type, investment_amount  from plan_details1 where id in(' . $plan_id_string . ') and type=0 and topic_area_id=' . $topic->id);

                        $sql_extra_total = 'select  sum(pt.agreement_other + pt.other_agreement + pt.costumer_agreement  ) as extraTotal from plan_details1 as pd   
                                    join plan_total_investment as pt on pt.plan_id = pd.id
                                   
                                    where pd.topic_area_id =' . $topic->id;
                        //echo $sql_extra_total; exit;
                        $extra_total_result = $database->query($sql_extra_total);
                        $extra_total_arr = mysqli_fetch_assoc($extra_total_result);

                        $sql_extra_total = 'select  sum(am.agreement_other + am.other_agreement + am.costumer_agreement  ) as extraTotal from plan_details1 as pd   
                                    join amanat_lagat as am on am.plan_id = pd.id
                                   
                                    where pd.topic_area_id =' . $topic->id;
                        //echo $sql_extra_total; exit;
                        $extra_total_result = $database->query($sql_extra_total);
                        $extra_total_amanat_arr = mysqli_fetch_assoc($extra_total_result);


                        $sql1 = 'select sum(investment_amount) as totalTopicAmount from plan_details1 where topic_area_id=' . $topic->id;
                        $result1 = $database->query($sql1);
                        $totalTopicAmount = mysqli_fetch_assoc($result1);

                        //$total_amount_on_topic_id =

                        foreach ($plans as $plan) {

                            if ($plan->program_name == '0') {
                                continue;
                            }
                            // contribution calculation first investment
                            $upabhokta_inv_sql = 'select sum(agreement_gauplaika + agreement_other + other_agreement + costumer_agreement) as contribution , unit_id, unit_total from plan_total_investment where plan_id=' . $plan->id;

                            $upabhokta_inv_result = $database->query($upabhokta_inv_sql);
                            $upabhokta_inv_contribution_result = mysqli_fetch_assoc($upabhokta_inv_result);
                            $unit_name = '';
                            if (!empty($upabhokta_inv_contribution_result['unit_id'])) {
                                $unit_name = Units::getName($upabhokta_inv_contribution_result['unit_id']);
                            }
                            $unit_total = '';
                            if (!empty($upabhokta_inv_contribution_result['unit_total'])) {
                                $unit_total = $upabhokta_inv_contribution_result['unit_total'];
                            }


                            // contribution calculation in case of amanat
                            $amanat_inv_sql = 'select sum(agreement_gauplaika + agreement_other + other_agreement + costumer_agreement) as contribution, unit_id  from amanat_lagat where plan_id=' . $plan->id;
                            $amanat_inv_result = $database->query($amanat_inv_sql);
                            $amanat_inv_contribution_result = mysqli_fetch_assoc($amanat_inv_result);
                            if (!empty($amanat_inv_contribution_result['unit_id'])) {
                                $unit_name = Units::getName($amanat_inv_contribution_result['unit_id']);
                            }
                            if (!empty($amanat_inv_contribution_result['unit_total'])) {
                                $unit_total = $amanat_inv_contribution_result['unit_total'];
                            }

                            // contribution calculation in case of samiti
                            $samiti_inv_sql = 'select sum(agreement_gauplaika + agreement_other + other_agreement + costumer_agreement) as contribution, unit_id  from samiti_plan_total_investment where plan_id=' . $plan->id;
                            $samiti_inv_result = $database->query($samiti_inv_sql);
                            $samiti_inv_contribution_result = mysqli_fetch_assoc($samiti_inv_result);

                            if (!empty($samiti_inv_contribution_result['unit_id'])) {
                                $unit_name = Units::getName($samiti_inv_contribution_result['unit_id']);
                            }
                            if (!empty($samiti_inv_contribution_result['unit_total'])) {
                                $unit_total = $samiti_inv_contribution_result['unit_total'];
                            }
                            // incase of karikram

                            if ($plan->type == 1) {
                                $max_sn = 'select max(sn) as maxSn from program_more_details where program_id=' . $plan_id;
                                $max_sn_result = $database->query($max_sn);
                                $max_sn_output = mysqli_fetch_assoc($max_sn_result);
                                $unit_total = $max_sn_output['maxSn'];

                                if (empty($unit_total)) {
                                    $unit_total = 0;
                                }
                                $karikram_contribution = $plan->investment_amount;
                            }
                            if (empty($samiti_inv_contribution_result['contribution']) && empty($upabhokta_inv_contribution_result['contribution'])) {

                            }

                            $total_contribution = $upabhokta_inv_contribution_result['contribution'] + $amanat_inv_contribution_result['contribution'] + $samiti_inv_contribution_result['contribution'] + $karikram_contribution;
                            if (empty($total_contribution)) {
                                $total_contribution = $plan->investment_amount;
                            }
                            //if(empty($total_contribution)){ $total_contribution =  $plan->investment_amount; }
                            //kharcha calculation for karikram
                            $karikram_kharcha_sql = 'select total_payment_amount from program_payment_final as karikramFinalPayment where program_id=' . $plan->id;
                            $karikram_kharcha_result = $database->query($karikram_kharcha_sql);
                            $karikram_kharcha = mysqli_fetch_assoc($karikram_kharcha_result);

                            $karikram_adv_kharcha_sql = 'select payment_amount from program_payment as karikramAdvancePayment where program_id=' . $plan->id;
                            $karikram_adv_kharcha_result = $database->query($karikram_adv_kharcha_sql);
                            $karikram_adv_kharcha = mysqli_fetch_assoc($karikram_adv_kharcha_result);
                            if ($karikram_kharcha['karikramFinalPayment'] != 0) {
                                $karikram_total_kharcha = $karikram_kharcha['karikramFinalPayment'];
                            } else {
                                $karikram_total_kharcha = $karikram_adv_kharcha['karikramAdvancePayment'];
                            }
                            // kharcha calculation from upabhokta
                            $upabhokta_adv_sql = 'select sum(advance) as advance from plan_starting_fund where plan_id=' . $plan->id;
                            $upabhokta_adv_result = $database->query($upabhokta_adv_sql);
                            $upabhokta_adv_kharcha = mysqli_fetch_assoc($upabhokta_adv_result);

                            $upabhokta_inst_sql = 'select sum(total_amount_deducted + total_paid_amount) as installmentAmount from   analysis_based_withdraw where plan_id=' . $plan->id;
                            $upabhokta_final_sql = 'select sum(final_total_paid_amount + final_total_amount_deducted  ) as finalAmount, get_qty from plan_amount_withdraw_details where plan_id=' . $plan->id;
                            $upabhokta_inst_result = $database->query($upabhokta_inst_sql);
                            $upabhokta_inst_kharcha = mysqli_fetch_assoc($upabhokta_inst_result);

                            $contract_final_sql = 'select sum(final_total_paid_amount) as finalAmount from contract_amount_withdraw_details where plan_id=' . $plan->id;
                            $contract_final_result = $database->query($contract_final_sql);
                            $contract_final_kharcha = mysqli_fetch_assoc($contract_final_result);

                            $upabhokta_final_result = $database->query($upabhokta_final_sql);
                            $upabhokta_final_kharcha = mysqli_fetch_assoc($upabhokta_final_result);
                            if (empty($upabhokta_final_kharcha['finalAmount']) && empty($upabhokta_inst_kharcha['installmentAmount']) && empty($karikram_total_kharcha) && empty($contract_final_kharcha['finalAmount'])) {
                                $total_aggregate_kharcha = $upabhokta_adv_kharcha['advance'];
                            } else {
                                $total_aggregate_kharcha = $upabhokta_final_kharcha['finalAmount'] + $upabhokta_inst_kharcha['installmentAmount'] + $karikram_total_kharcha + $contract_final_kharcha['finalAmount'];
                            }


                            //echo $total_aggregate_kharcha; exit;

                            $get_gty = $upabhokta_final_kharcha['get_qty'];
                            // kharcha calculation from amanat
                            // advance calculation not required plant_starting_fund used for amanat also
                            // amanat installment calculation not required same table used analysis_based_withdraw
                            // $amanat_inst_sql = 'select sum(payable_amount) as installmentAmount from   analysis_based_withdraw where plan_id='.$plan->id;
                            // amanat final calculation  not required same table used plan_amount_withdrawal_details
                            // $amanat_final_sql = 'select sum(final_total_paid_amount + final_total_amount_deducted  ) as finalAmount from plan_amount_withdraw_details where plan_id='.$plan->id;
                            //$amanat_inst_result = $database->query($amanat_inst_sql);
                            //$amanat_inst_kharcha = mysqli_fetch_assoc($amanat_inst_result);

                            //$amanat_final_result = $database->query($amanat_final_sql);
                            // $amanat_final_kharcha = mysqli_fetch_assoc($amanat_final_result);
                            $totalTopicAmount['totalTopicAmount'] = $totalTopicAmount['totalTopicAmount'] + $extra_total_arr['extraTotal'] + $extra_total_amanat_arr['extraTotal'];
                            $total_contribution_percent = ($total_contribution / $totalTopicAmount['totalTopicAmount']) * 100;

                            $total_contribution_percent = number_format((float)$total_contribution_percent, 4, '.', '');
                            $total_kharcha_percent = ($total_aggregate_kharcha / $total_contribution) * 100;
                            $total_kharcha_percent = number_format((float)$total_kharcha_percent, 2, '.', '');
                            //$get_gty = number_format((float)$get_gty, 4, '.', '');
                            $get_gty = ($unit_total * $total_kharcha_percent) / 100;
                            $get_gty = number_format((float)$get_gty, 2, '.', '');
                            //$unit_total = number_format((float)$unit_total, 4, '.', '');
                            $suchak_bhar_percent = ($total_contribution_percent * $get_gty) / $unit_total;
                            $suchak_bhar_percent = number_format((float)$suchak_bhar_percent, 5, '.', '');
                            $sucha_bhautik_percent = ($suchak_bhar_percent * 100) / $total_contribution_percent;
                            $sucha_bhautik_percent = number_format((float)$sucha_bhautik_percent, 5, '.', '');
                            $total2+=$totalTopicAmount['totalTopicAmount'];

                            $total4+=$get_gty;
                            $total5+=$unit_total;
                            ?>
                            <tr>
                                <td><?= convertedcit($z) ?></td>
                                <td><?= convertedcit($plan->id) ?></td>
                                <td><?= $plan->program_name ?></td>
                                <td><?= $unit_name ?></td>
                                <td><?= convertedcit(substr($unit_total, 0, 5)) ?></td>
                                <td><?= convertedcit($total_contribution_percent) ?></td>
                                <td><?= convertedcit($total_contribution) ?></td>
                                <td><?= convertedcit(substr($unit_total, 0, 5)) ?></td>
                                <td><?= convertedcit($total_contribution_percent) ?></td>
                                <td><?= convertedcit($total_contribution) ?></td>
                                <td><?= convertedcit($get_gty) ?></td>
                                <td><?php echo convertedcit($suchak_bhar_percent); ?></td>
                                <td><?php echo convertedcit($sucha_bhautik_percent); ?></td>
                                <td><?= convertedcit($total_aggregate_kharcha) ?></td>
                                <td><?= convertedcit($total_kharcha_percent) ?></td>
                                <td></td>
                            </tr>
                            <?php $z++;
                            $total1+=$total_contribution;
                            $total3+=$total_aggregate_kharcha;
                        } }

                     $last_percent = ($total3/$total1)*100;
                     $first_percent = ($total1/$total2)*100;
                     $var3 = ($first_percent*$total4)/$total5;
                     $var4= ($var3*100)/$first_percent;
                     ?>
                        <tr>
                            <td colspan="5">कुल जम्मा</td>
                            <td><?= convertedcit(round($first_percent,5)) ?></td>
                            <td><?= convertedcit($total1) ?></td>
                            <td></td>
                            <td><?= convertedcit(round($first_percent,5)) ?></td>
                            <td><?= convertedcit($total1) ?></td>
                            <td></td>
                            <td><?= convertedcit(round($var3,5)) ?></td>
                            <td ><?= convertedcit(round($var4,5)) ?></td>
                            <td><?= convertedcit($total3) ?></td>
                            <td><?= convertedcit(round($last_percent,5)) ?></td>
                            <td></td>
                        </tr>
                    </table>

                        <?php $arr_new = array_unique($error_id);
                        sort($arr_new);
                        echo "<pre>";
                        echo implode(",", $arr_new);
                        echo "</pre>"; ?>
                </div>
            </div><!-- main menu ends -->
        </div>
    </div><!-- top wrap ends -->
    <?php // include("menuincludes/footer.php"); ?>

    <script>
        JQ(document).on("click", "#print", function () {
            JQ.print("#print_content");


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

    </script>

