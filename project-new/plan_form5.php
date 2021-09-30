<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
    redirectUrl();
}
$setting =KattiWiwarn::find_by_sql("select * from settings_katti_wiwarn where what_is = 1");
// echo Analysisbasedwithdraw::getevaluated_Amount($_SESSION['set_plan_id']);exit;
error_reporting(0);
//get_access_form($_GET['id']);
$units = Units::find_all();
$settingbhautikPariman = SettingbhautikPariman::find_all();
$bhautik_details = Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'],1);
//print_r($bhautik_details);
$mode=getUserMode();
$units = Units::find_all();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$inst_array = array(
    1=>"पहिलो",
    2=>"दोस्रो",
    3=>"तेस्रो",
    4=>"चौथो",
    5=>"पाचौ",
    6=>"छैठो",
);
//$data = new Planamountwithdrawdetails;
//print_r($data); exit;
if(isset($_POST['submit']))
{
//    print_r($_POST);exit;
//  if(strtotime(DateNepToEng($_POST['plan_end_date'])) > strtotime(date("Y-m-d",time())))
//  {
//     $link="plan_form5.php";
//      echo alertBox("तपाईले छान्नुभएको मिति आजको मिति भन्दा धेरै भयो ..!!!", $link);
//      return false; 
//  }
    if(strtotime(DateNepToEng($_POST['plan_end_date'])) > strtotime(DateNepToEng($_POST['yojana_sakine_date'])))
    {
        $link="plan_form5.php";
        echo alertBox("योजनाको काम सम्पन्न भएको मिति योजना सम्पन्न हुने मिति भन्दा धेरै भयो , कृपया म्याद थप गरि आउनु होला...!!!", $link);
        return false;
    }
    else
    {

        for($i=0;$i<count($_POST['topic']);$i++)
        {
            $kar_bibran = new Kar_Bibran();
            $kar_bibran->darta_id = $_GET['id'];
            $kar_bibran->kar_rakam = $_POST['karrakam'][$i];
            $kar_bibran->kar_percent = $_POST['precent'][$i];
            $kar_bibran->total_kar_amount = $_POST['total_amt'][$i];
            $kar_bibran->kar_topic = $_POST['topic'][$i];
            $kar_bibran->save();
        }
        $data = new Publicinvestigationdetails();
        $data->survey_date=$_POST['survey_date'];
        $data->survey_date_english = DateNepToEng($data->survey_date);
        $data->population=$_POST['population'];
        $data->plan_id=$_POST['plan_id'];
        $data->save();

        $data = new Planamountwithdrawdetails();
        $data->get_qty=$_POST['get_qty'];
        $data->doc_name=$_POST['doc_name'];
        $data->other_kaifiyet=$_POST['other_kaifiyet'];
        $data->get_unit_id=$_POST['get_unit_id'];
        $data->plan_end_date = $_POST['plan_end_date'];
        $data->yojana_sakine_date=$_POST['yojana_sakine_date'];
        $data->yojana_sakine_date_english=$_POST['yojana_sakine_date_english'];
        $data->upabhokta_aproved_date=$_POST['upabhokta_aproved_date'];
        $data->upabhokta_aproved_date_english = DateNepToEng($_POST['upabhokta_aproved_date']);
        $data->expenditure_approved_date = $_POST['expenditure_approved_date'];
        $data->expenditure_approved_date_english = DateNepToEng($_POST['expenditure_approved_date']);
        $data->plan_evaluated_date=$_POST['plan_evaluated_date'];
        $data->plan_evaluated_date_english = DateNepToEng($_POST['plan_evaluated_date']);
        $data->plan_evaluated_amount=$_POST['plan_evaluated_amount'];
        $data->final_bhuktani_ghati_amount = $_POST['final_bhuktani_ghati_amount'];
        $data->final_payable_amount=$_POST['final_payable_amount'];
        $data->payment_till_now=$_POST['payment_till_now'];
        $data->advance_payment=$_POST['advance_payment'];
        $data->remaining_payment_amount=$_POST['remaining_payment_amount'];
        $data->final_contengency_amount=$_POST['final_contengency_amount'];
        $data->final_renovate_amount=$_POST['final_renovate_amount'];
        $data->final_due_amount=$_POST['final_due_amount'];
        $data->final_disaster_management_amount=$_POST['final_disaster_management_amount'];
        $data->final_total_amount_deducted=$_POST['final_total_amount_deducted'];
        $data->final_total_paid_amount=$_POST['final_total_paid_amount'];
        $data->final_dpr_amount = $_POST['final_dpr_amount'];
        $data->estimated_amount = $_POST['estimated_amount'];
        $data->plan_id=$_POST['plan_id'];
        $data->created_date =$_POST['created_date'];
        $data->bank_acc = $_POST['bank_acc'];
        $data->chalani_no = $_POST['chalani_no'];
        $data->us_bank_acc = $_POST['us_bank_acc'];
        $data->bank_lagat_date = $_POST['bank_lagat_date'];
        $data->us_bank_name = $_POST['us_bank_name'];
        $data->created_date_english=DateNepToEng($_POST['created_date']);
        // calculated amount 
        $data->agreement_gauplaika_calc = $_POST['agreement_gauplaika_calc'];
        $data->agreement_other_calc     = $_POST['agreement_other_calc'];
        $data->other_agreement_calc     = $_POST['other_agreement_calc'];
        $data->customer_agreement_calc  = $_POST['customer_agreement_calc'];
        $data->save();
        for($i=0;$i<count($_POST['qty']);$i++)
        {
            $detail = new Bhautik_lakshya();
            $detail->details_id = $_POST['details_id'][$i];
            $detail->prev_qty = $_POST['prev_qty'][$i];
            $detail->qty = $_POST['qty'][$i];
            $detail->unit_id = $_POST['unit_id'][$i];
            $detail->plan_id = $_POST['plan_id'];
            $detail->type = 3;
            $detail->miti=$_POST['created_date'];
            $detail->miti_english=DateNepToEng($_POST['created_date']);
            $detail->save();
        }
        for($i=0;$i<count($_POST['katti']);$i++)
        {
            $data= new KattiDetails();
            $data->plan_id = $_POST['plan_id'];
            $data->created_date = $_POST['created_date'];
            $data->created_date_english = DateNepToEng($_POST['created_date']);
            $data->katti_id = $_POST['katti_id'][$i];
            $data->katti_amount = $_POST['katti'][$i];
            $data->type = 2;
            $data->save();
        }

        echo alertBox("भुक्तानी गर्न सफल ","plan_form5.php");
    }

}
$plan_total = Plantotalinvestment::find_by_plan_id($_GET['id']);
$data_selected_public = Publicinvestigationdetails::find_by_plan_id($_GET['id']);
$data_selected_final = Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
//print_r($data_selected_final);
$plan_selected = Plandetails1::find_by_id($_GET['id']);
$total_investment = Plantotalinvestment::find_by_plan_id($_GET['id']);
//print_r($total_investment);
$total_investment1=  Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
// echo $completion_date = getSamitiCompletiondate($_GET['id']);exit;
if(!empty($total_investment))
{
    $net_investment = $total_investment->agreement_gauplaika + $total_investment->agreement_other + $total_investment->other_agreement;
    $hid_agreement_other = $total_investment->agreement_other;
    $hid_other_agreement = $total_investment->other_agreement;
    $hid_costumer_agreement = $total_investment->costumer_agreement;
    $hid_agreement_gauplaika = $total_investment->agreement_gauplaika;

//    $unit_id = $total_investment->unit_id;
    $completion_date=getcompletiondate($_GET['id']);
    $costumer_agreement = $total_investment->costumer_agreement;
    if(!empty($plan_total->marmat_new)){
    $karyadesh = $total_investment->bhuktani_anudan + $plan_total->marmat_new;
    }else{
    $karyadesh = $total_investment->bhuktani_anudan;
    }
//  $lakshya = $total_investment->unit_total;
    $estimated_amount = $total_investment->total_investment;
    //print_r($estimated_amount);
    $hid_agreement_other = $total_investment->agreement_other;
    $hid_other_agreement = $total_investment->other_agreement;
    $hid_costumer_agreement = $total_investment->costumer_agreement;
    $hid_agreement_gauplaika = $total_investment->agreement_gauplaika;

    $link="bhuktani_select.php";
    $name = "उपभोक्ताबाट";
    $name1="उपभोक्ताको";
}
elseif(!empty($total_investment1))
{
    $net_investment = $total_investment1->agreement_gauplaika + $total_investment1->agreement_other +   $total_investment1->other_agreement;
    $completion_date = getSamitiCompletiondate($_GET['id']);
    $costumer_agreement = $total_investment1->costumer_agreement;
    $karyadesh = $total_investment1->bhuktani_anudan;
//        $lakshya = $total_investment1->unit_total;
//        $unit_id = $total_investment1->unit_id;
    $estimated_amount = $total_investment1->total_investment;
    $hid_agreement_other = $total_investment1->agreement_other;
    $hid_other_agreement = $total_investment1->other_agreement;
    $hid_costumer_agreement = $total_investment1->costumer_agreement;
    $hid_agreement_gauplaika = $total_investment1->agreement_gauplaika;
    $link="samiti_bhuktani_select.php";
    $name= "संस्था /समिति बाट";
    $name1 ="संस्था /समितिको";
}
else
{
    $amanat_lagat = AmanatLagat::find_by_plan_id($_GET['id']);
    $net_investment = $amanat_lagat->agreement_gauplaika + $amanat_lagat->agreement_other+ $amanat_lagat->other_agreement;
    $completion_date = getamanatcompletiondate($_GET['id']);
    $karyadesh = $amanat_lagat->bhuktani_anudan;
//   $lakshya = $amanat_lagat->unit_total;
    $customer  = $amanat_lagat->costumer_agreement;
    $estimated_amount = $amanat_lagat->total_investment;
//      $unit_id = $amanat_lagat->unit_id;
    $hid_agreement_other = $amanat_lagat->agreement_other;
    $hid_other_agreement = $amanat_lagat->other_agreement;
    $hid_costumer_agreement = $amanat_lagat->costumer_agreement;
    $hid_agreement_gauplaika = $amanat_lagat->agreement_gauplaika;
    $link = "amanat_bhuktani_dashboard.php";
    $name= "";
    $var = 1;
}
$advance = Planstartingfund::find_by_plan_id($_GET['id']);
if(!empty($advance))
{
    $advance_amount = $advance->advance;
}
else
{
    $advance_amount = 0;
}
$net_payable_amount = $net_investment;
$inst_count = Analysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
empty($inst_count)? $inst_count=0 : '';
$total_paid_amount = array();
if(empty($advance))
{
    $advance = Planstartingfund::setEmptyObjects();
}
if($inst_count==0)
{
    $check_advance =1;
    $net_payable_amount-= $advance_amount;
}

// check for installment amount and calculating the total paid amount i.e. payable amount without contingency amount
// but including advance amount in the first installment
$inst_amount = array();
$inst_selected = array();
$payable_amount = array();

$inst_selected = array();
$check_inst = 0;
if($inst_count>0):
    $check_inst = 1;
    for($i=1; $i<=$inst_count; $i++):
        $inst_data = Analysisbasedwithdraw::find_by_payment_count($i,$_GET['id']);
        array_push($inst_amount, $inst_data->total_paid_amount);
        array_push($payable_amount, $inst_data->payable_amount);
        array_push($inst_selected, $inst_array[$i]);
        $net_payable_amount -= $inst_data->payable_amount;
    endfor;
endif;
if($inst_count==0)
{
    $contingency = get_contingency_for_plan($_GET['id']);
    $final_total_deducted_amount = ($net_payable_amount * $contingency)+$advance->advance;
    $final_total_paid_amount = $net_payable_amount +$costumer_agreement - $final_total_deducted_amount;
}
else
{
    $contingency = get_contingency_for_plan($_GET['id']);
    $final_total_deducted_amount = ($net_payable_amount * $contingency);
    $final_total_paid_amount = $net_payable_amount +$costumer_agreement- $final_total_deducted_amount;
}

$data_1 = Analysisbasedwithdraw::find_by_plan_id($_GET['id']); //print_r($data_1);
$invest_details =  Plantotalinvestment::find_by_plan_id($_GET['id']); //print_r($invest_details);
?>
<?php include("menuincludes/header.php"); ?>

<style>
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }
    .borderless table {
        border-top-style: none;
        border-left-style: none;
        border-right-style: none;
        border-bottom-style: none;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">

    <div class="maincontent">
        <h2 class="headinguserprofile"><?=$plan_selected->program_name?> , दर्ता न :<?=convertedcit($_GET['id'])?> | <a href="<?=$link?>" class="btn">पछि जानुहोस </a></h2>
        <h2 class="headinguserprofile">योजनाको कुल भुक्तानी दिनु पर्ने रकम: रु <span id="net_investment"><?php echo convertedcit($net_investment); ?></span></h2>

        <?php echo $message;?>
        <div class="OurContentFull">

            <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
            <div class="userprofiletable">
                <?php if(!empty($data_selected_public) && !empty($data_selected_final)):?>


                <div class="myCenter">
                    <h3>योजनाको अन्तिम भुक्तानी </h3>
                    <?php
                    if($mode=="superadmin"){?>
                        <a onClick="return confirm('के तपाई डेटा हाटाउन चाहनुहुन्छ ?');" href="delete_final_payment.php?plan_id=<?php echo $_GET['id'];?>"><button class="btn">अन्तिम भुक्तानी हटाउनु होस्</button></a>
                    <?php }
                    $katti_bibaran_payment = KattiDetails::find_by_plan_id_and_type($_GET['id'],2);
                    //                               print_r($katti_bibaran_payment);exit;
                    ?>
                    <table id="plan_amount_withdraw" class="table table-bordered table-hover">
                        <tr>
                            <td class="myWidth50 myTextalignRight">वडाबाट सार्बजनिक परिक्षण भएको मिति</td>
                            <td><?=convertedcit($data_selected_public->survey_date)?></td>
                        </tr>
                        <tr>
                            <td class="myWidth50 myTextalignRight">चलानी नं</td>
                            <td><?=convertedcit($data_selected_final->chalani_no)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">सार्बजनिक परिक्षण भेलमामा उपस्थित संख्या</td>
                            <td><?=convertedcit($data_selected_public->population)?></td>
                        </tr>

                        <!--<tr>-->
                        <!--<td class="myTextalignRight">उपभोक्ता समितिको बैंक खाता नम्बर:</td>-->
                        <!--<td><?=convertedcit($data_1->bank_acc);?></td>-->
                        <!--</tr>-->
                        <tr>
                            <td class="myTextalignRight">योजना सम्पन्न हुने मिति</td>
                            <td><?=convertedcit($data_selected_final->yojana_sakine_date);?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">योजनाको काम सम्पन्न भएको मिति</td>
                            <td><?=convertedcit($data_selected_final->plan_end_date)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight"><?php if($var!=1){ ?><?=$name1?> बैठक बसी<?php } ?> खर्च स्वीकृत गरेको मिति</td>
                            <td><?=convertedcit($data_selected_final->upabhokta_aproved_date)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति</td>
                            <td><?=convertedcit($data_selected_final->expenditure_approved_date)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">योजनाको मुल्यांकन मिति</td>
                            <td><?=convertedcit($data_selected_final->plan_evaluated_date)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">योजनाको मुल्यांकन रकम</td>
                            <td><?=convertedcit($data_selected_final->plan_evaluated_amount)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight"> भुक्तानी दिनु पर्ने कुल  रकम</td>
                            <td ><?=convertedcit($data_selected_final->final_payable_amount)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight"> मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम <?=getInstText($inst_selected)?></td>
                            <td ><?=convertedcit($data_selected_final->payment_till_now)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">पेश्की भुक्तानी लगेको कट्टी रकम</td>
                            <td><?=convertedcit($data_selected_final->advance_payment)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">भुक्तानी दिनु पर्ने कुल बाँकी  रकम</td>
                            <td><?=convertedcit($data_selected_final->remaining_payment_amount)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">भुक्तानी घटी कट्टी रकम</td>
                            <td><?=convertedcit($data_selected_final->final_bhuktani_ghati_amount)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">कन्टेन्जेन्सी  कट्टी रकम</td>
                            <td><?=convertedcit($data_selected_final->final_contengency_amount)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">मर्मत सम्हार कोष / सूचना पाटी कट्टी रकम</td>
                            <td><?php echo convertedcit($invest_details->marmat_new);?></td>
                        </tr>

                        <tr>
                            <td class="myTextalignRight">जम्मा कट्टी रकम</td>
                            <td><?=convertedcit($data_selected_final->final_total_amount_deducted)?></td>
                        </tr>
                        <tr>
                            <td class="myTextalignRight">भुक्तानी दिइएको खुद रकम</td>
                            <td><?=convertedcit($data_selected_final->final_total_paid_amount)?></td>
                        </tr>
                    </table>
                    <?php endif;?>
                </div>
                <?php $data=  Plandetails1::find_by_id($_GET['id']);
                $datas=Plantotalinvestment::find_by_plan_id($_GET['id']);
                if(!empty($datas))
                {
                    $add=$datas->agreement_gauplaika+$datas->agreement_other+$datas->other_agreement;
                    $costumer= $datas->costumer_agreement;
                }
                else
                {
                    $datas=  Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
                    $add=$datas->agreement_gauplaika+$datas->agreement_other+$datas->costumer_agreement+$datas->other_agreement;
                    $costumer= $datas->costumer_agreement;
                }
                ?>
                <div <?php if(!empty($data_selected_final)): ?> style="display:none;" <?php endif; ?>>
                    <form method="post" enctype="multipart/form-data" >
                        <h3>योजनाको अन्तिम भुक्तानी </h3>
                        <div class="inputWrap33 inputWrapLeft">



                            <input type="hidden" name="plan_id" id="plan_id" value="<?php echo $_GET['id'];?>"/>
                            <input type="hidden" name="marmat_rate" id="marmat_rate" value="<?=Marmatsamhar::get_marmat_samhar_percent();?>"/>
                            <?php if(empty($amanat_lagat)){?>
                            <div class="titleInput">वडाबाट सार्बजनिक परिक्षण भएको मिति</div>
                            <div class="newInput"><input type="text" name="survey_date" id="nepaliDate3"></div>
                            <?php }else{}?>
                            <?php if(empty($amanat_lagat)){?>
                            <div class="titleInput">चलानी नं</div>
                            <div class="newInput"><input type="text" name="chalani_no" id="chalani_no"></div>

                            <div class="titleInput">सार्बजनिक परिक्षण भेलमा उपस्थित संख्या</div>
                            <div class="newInput"><input type="text" name="population"/></div>

                            <?php foreach($data_1 as $d1):
                            endforeach;
                            ?>
                            <div class="titleInput">उपभोक्ता समितिको बैंक खाता नम्बर:</div>
                            <div class="newInput"><input type="text" name="bank_acc" value="<?php
                                if(!empty($d1->bank_acc)){
                                    echo convertedcit($d1->bank_acc);
                                }else{

                                }?>
                                "/></div>
                            <?php }else{}?>
                            <div class="titleInput">योजना सम्पन्न हुने मिति</div>
                            <div class="newInput"><input type="text" class="yojana_sakine_date" name="yojana_sakine_date" value="<?=$completion_date;?>" readonly="true"/></div>

                            <div class="titleInput">योजनाको काम सम्पन्न भएको मिति</div>
                            <div class="newInput"><input type="text" class="plan_end_date" name="plan_end_date" id="nepaliDate5"/></div>
                            <?php if(empty($amanat_lagat)){?>
                            <div class="titleInput"><?php if($var!=1){ ?><?=$name1?> बैठक बसी<?php } ?> खर्च स्वीकृत गरेको मिति</div>
                            <div class="newInput"><input type="text" name="upabhokta_aproved_date" id="nepaliDate10"/></div>

                            <div class="titleInput">अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति</div>
                            <div class="newInput"><input type="text" name="expenditure_approved_date" id="nepaliDate11"/></div>
                            <?php }else{}?>
                            <div class="titleInput">योजनाको मुल्यांकन मिति</div>
                            <div class="newInput"><input type="text" name="plan_evaluated_date" id="nepaliDate12"/></div>

                            <div class="titleInput">इष्टिमेट भएको रकम </div>
                            <div class="newInput"><input type="text" id="estimated_amount" name="estimated_amount" value="<?= $estimated_amount ?>"/></div>
                            <?php if(!empty($amanat_lagat)){?>
                            <div class="titleInput">संलग्न कागजातहरू:</div>
                           <textarea type="text" id="doc_name" name="doc_name" value="<?php ?>"></textarea>
                           <div class="titleInput">अन्य खुलाउनुपर्ने विवरणः</div>
                           <textarea type="text" id="other_kaifiyet" name="other_kaifiyet" value="<?php ?>"></textarea>
                           <?php }else{}?>
                            

                        </div>
                        <div class="inputWrap33 inputWrapLeft">


                            <div class="titleInput">योजनाको हाल  मुल्यांकन रकम</div>
                            <div class="newInput"><input type="text" id="haal_mulyankan" name="haal_mulyankan"/></div>

                            <div class="titleInput">योजनाको खुद मुल्यांकन रकम</div>
                            <div class="newInput"><input readonly="true" type="text" id="plan_evaluated_amount" name="plan_evaluated_amount"/></div>

                            <div class="titleInput">भुक्तानी दिनु पर्ने कुल  अनुदान रकम </div>
                            <div class="newInput"><input   type="text" name="final_payable_amount" id="final_payable_amount" value="<?php echo $add;?>"/></div>
                            
                            <div class="titleInput"> मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम <?=getInstText($inst_selected)?></div>
                            <div class="newInput"><input type="text" id="payment_till_now" name="payment_till_now" readonly="true" value="<?=array_sum($payable_amount)?>" /></div>

                            <div class="titleInput">पेश्की भुक्तानी लगेको कट्टी रकम</div>
                            <div class="newInput"><input type="text" name="advance_payment" id="advance_payment" readonly="true" value="<?=$advance_amount?>" /></div>

                            <!--                             <div class="titleInput">भुक्तानी दिनु पर्ने कुल बाँकी अनुदान  रकम</div>
 <div class="newInput"><input type="text" name="remaining_payment_amount" id="remaining_payment_amount" readonly="true" value="<?=$net_payable_amount?>" /></div>-->

                            <div class="titleInput">भुक्तानी घटी कट्टी रकम</div>
                            <div class="newInput"><input type="text" name="final_bhuktani_ghati_amount"  id="final_bhuktani_ghati_amount" required  value="0"/></div>

                            <div class="titleInput">जम्मा भुक्तानी रकम</div>
                            <div class="newInput"><input type="text" name="kaam_ghati_katti_rakam"  id="kaam_ghati_katti_rakam" /></div>
                            <div class="titleInput">कन्टेन्जेन्सी  कट्टी रकम</div>
                            <div class="newInput"><input type="text" name="final_contengency_amount" id="final_contengency_amount" /></div>
                            <?php if(empty($amanat_lagat)){?>
                            <div class="titleInput">लागत साझेदारी रकम (रु. <?php echo convertedcit($total_investment->costumer_agreement);?>)/-</div>
                            <hr><hr>
                            <div class="newInput">
                                <label>बैंक नाम:<input type="text" id="us_bank_name" name="us_bank_name" /></label>
                                <label>खा.नं:<input type="text" id="us_bank_acc" name="us_bank_acc" /></label>
                            </div>
                            <?php }else{}?>
<!--                            <div class="titleInput">कन्टेन्जेन्सी  कट्टी रकम</div>-->
<!--                            <div class="newInput"><input type="text" name="final_contengency_amount" id="final_contengency_amount" /></div>-->
                        </div>
                        <div class="inputWrap33 inputWrapLeft">

                            <?php if(empty($amanat_lagat)){?>
                            <div class="titleInput">मर्मत सम्हार कोष कट्टी रकम</div>
                            <div class="newInput"><input type="text"  name="final_renovate_amount" id="final_renovate_amount" value="<?php echo $invest_details->marmat_new;?>"  /></div>

                            <div class="titleInput">विपद कोष कट्टी रकम</div>
                            <div class="newInput"><input type="text"  name="bipat_katti_rakam" id="bipat_katti_rakam" value="<?php echo $invest_details->bipat_new;?>"  /></div>
                            

                            <div class="titleInput">जम्मा कट्टी रकम</div>
                            <div class="newInput"><input type="text" name="final_total_amount_deducted" id="final_total_amount_deducted" value="<?=$final_total_deducted_amount?>" /></div>
                            <?php }else{}?>
                            <div class="titleInput">हाल भुक्तानी दिनु पर्ने खुद रकम</div>
                            <div class="newInput"><input type="text" name="final_total_paid_amount" id="final_total_paid_amount"  value="<?=$final_total_paid_amount?>"/>
                                <a id="final_check" class="btn check_final"> CACULATE</a>
                            </div>

                            <div class="titleInput">भुक्तानी भएको मिति </div>
                            <div class="newInput"><input type="text" name="created_date" id="nepaliDate9" value="<?=DateEngToNep(date("Y-m-d",time()))?>"  readonly="true"/></div>
                            <hr><hr>
                            <?php if(empty($amanat_lagat)){?>
                            <div class="titleInput">लागत साझेदारी रकम जम्मा गरेको मिति </div>
                            <div class="newInput">
                                <label><input type="text" name="bank_lagat_date" id="nepaliDate15" value="<?=DateEngToNep(date("Y-m-d",time()))?>"  readonly="true"/></label></div>
                            <?php }else{}?>
                            <?php
                            $group_details = Costumerassociationdetails::find_by_plan_id($_GET['id']);
                                    ?>
                        </div>
                        <div class="myspacer"></div>
                        <?php if(empty($amanat_lagat)){?>
                        <table class="table borderless">
                            <thead>
                            <tr>
                                <th class="myCenter" style="border:3px double black;"><strong>सी.न </th>
                                <th class="myCenter" style="border:3px double black;"><strong>शिर्षक</th>
                                <th class="myCenter" style="border:3px double black;"><strong>कर योग्य रकम</strong></th>
                                <th class="myCenter" style="border:3px double black;"><strong>कर(%)</strong></th>
                                <th class="myCenter" style="border:3px double black;"><strong>कर रकम</strong></th>
                            <tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            if(!empty($setting)) :
                                foreach ($setting as $key => $value) :?>
                                    <tr>
                                        <td><?php echo convertedcit($i++)?></td>
                                        <td><?php echo $value->topic?>
                                            <input type = "hidden" name="topic[]" value="<?php echo $value->topic?>">
                                        </td>
                                        <td><input type="text" name="karrakam[]
              " value=""  class="form-control karrakam"></td>
                                        <td><input type="text" name="precent[]"  class="percent" value="<?php echo $value->percent?>" readonly="true" style="background: #e5e5e5;"></td>
                                        <td><input type="text" name="total_amt[]" value="" class="form-control sum_item"></td>
                                    </tr>
                                <?php endforeach;endif;?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><input type="text" value="<?=$final_total_paid_amount?>" name= "final_t_amount" id="final_t_amount" readonly="readonly"> </td>
                                <td colspan =2></td>
                                <td>
                                    <input type="text" name="total_kar_rakam"  id = "total" readonly="true" style="background: #e5e5e5;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">करपछि भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><input type="text" name="f_amount_after_tax" id="f_amount_after_tax" readonly="true" style="background: #e5e5e5"></td>
                            </tr>
                            </tfoot>
                        </table>
                        <?php }else{}?>
                        <div>
                            <?php $bhautik = Bhautik_lakshya::find_by_plan_id_and_type_payment_count($_GET['id'],2,1);
                                foreach($bhautik as $bhautik):
                                // echo "<pre>";
                                // print_r($bhautik);
                                endforeach;
                            
                            ?>
                            <h2>प्राप्त भौतिक लक्ष्य भर्नुहोस्</h2>
                            <table class="table table-bordered">
                                <tr>
                                    <th>सि. नं </th>
                                    <th> भौतिक लक्ष्यको शिर्षक </th>
                                    <th>अनुमानित लक्ष्य </th>
                                    <?php if(!empty($data_1)){?>
                                        <th>मुल्यांकन सम्मको प्राप्त लक्ष्य</th>    
                                    <?php }else{}?>
                                    <th>कुल प्राप्त लक्ष्य </th>
                                    <th>भौतिक इकाई </th>
                                </tr>
                                <?php
                                $i=1;
                                foreach($bhautik_details as $result):
                                    //foreach($bhautik as $bhautik):
                                    ?>
                                    <tr <?php if($i!=1){?>class="remove_plan_form_details"<?php }?>>
                                        <td><?=convertedcit($i)?></td>
                                        <td>
                                            <select name="details_id[]" readonly="true">
                                                <option value="">--------</option>
                                                <?php foreach($settingbhautikPariman as $data):?>
                                                    <option value="<?=$data->id?>" <?php if($data->id==$result->details_id){ echo 'selected="selected"';}?>><?=$data->name?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </td>
                                        <td><input type="text" name="prev_qty[]" value="<?=$result->qty?>" readonly="true"/></td>
                                        <?php if(!empty($data_1)){?>
                                        <td><input type="text" name="mul_qty[]" value="<?php echo $bhautik->qty;?>" readonly="true"></td>
                                        <?php }else{}?>
                                        <td><input type="text" name="qty[]"  /></td>
                                        <td>
                                            <select name="unit_id[]" readonly="true">
                                                <option value="">--छान्नुहोस् --</option>
                                                <?php foreach($units as $unit): ?>
                                                    <option value="<?=$unit->id?>" <?php if($unit->id==$result->unit_id){ echo 'selected="selected"';}?>><?=$unit->name?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php $i++;endforeach;?>
                            </table>
                        </div>
                        <center>
                            <input type="submit"  name="submit" onClick="return confirm('कृपया पुनः डेटा आवलोकन गर्नुहोस हालिएको  डेटा सच्याउन  मिल्दैन');" value="सेभ गर्नुहोस"  id="final_date_check" class="submit btn btn-info">
                        </center>
                        <!--<div class="titleInput">भुक्तानी दिनुपर्ने <?=$name?> नगद साझेदारी रकम</div>-->
                        <input type="hidden" name="customer_agreement" id="customer_agreement" value="<?php echo $costumer;?>" readonly="true"/>
                        <input type="hidden" name="karyadesh_amount" id="karyadesh_amount" value="<?php echo $karyadesh;?>" readonly="true"/>
                        <input type="hidden" name="hid_agreement_gauplaika" id="hid_agreement_gauplaika" value="<?php echo $hid_agreement_gauplaika;?>" readonly="true"/>
                        <input type="hidden" name="hid_agreement_other" id="hid_agreement_other" value="<?php echo $hid_agreement_other;?>" readonly="true"/>
                        <input type="hidden" name="hid_other_agreement" id="hid_other_agreement" value="<?php echo $hid_other_agreement;?>" readonly="true"/>
                        <input type="hidden" name="analysis_total_evaluated_amount" id="analysis_total_evaluated_amount" value="<?php echo Analysisbasedwithdraw::getevaluated_Amount($_SESSION['set_plan_id']);?>" readonly="true"/>
                        <input type="hidden" name="check_inst" value="<?=$check_inst?>" id="check_inst" />
                        <input type="hidden" name="check_advance" value="<?=$check_advance?>" id="check_advance" />
                        <!-- for calculated values -->
                        <input type="hidden" name="agreement_gauplaika_calc" value="<?=$total_investment->agreement_gauplaika?>" id="agreement_gauplaika_calc" />
                        <input type="hidden" name="agreement_other_calc" value="<?=$total_investment->agreement_other?>" id="agreement_other_calc" />
                        <input type="hidden" name="other_agreement_calc" value="<?=$total_investment->other_agreement?>" id="other_agreement_calc" />
                        <input type="hidden" name="customer_agreement_calc" value="<?=$total_investment->costumer_agreement?>" id="customer_agreement_calc" />
                    </form>
                </div>
            </div>
        </div>
    </div><!-- main menu ends -->
    <script src="js/bhuktani.js"></script>
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('keyup change','.karrakam',function(){
            var karrakam = $(this).val();
            if(karrakam == '' || isNaN(karrakam)) {
                karrakam = 0;
                $(this).closest('tr').find('.karrakam').val(0);
            }
            var unit_other = $(this).closest('tr').find('.percent').val();
            var total_karRakam = unit_other*karrakam/100;
            if(total_karRakam != '' && total_karRakam !=NaN) {
                $(this).closest('tr').find('.sum_item').val(total_karRakam);
            }
            var sum = 0;
            $('.sum_item').each(function(){
                var item_val=parseFloat($(this).val());
                if(isNaN(item_val)){
                    item_val = 0 ;
                }
                sum+= item_val;
                $('#total').val(sum.toFixed(2));
            });
            var amount_final = $('#final_total_amount_deducted').val();
            var final_amt = $('#final_total_amount_deducted').val();
            var final_t_amount = amount_final - final_amt;
            //console.log(final_t_amount);
            var final_t_amount = $('#final_t_amount').val();
            if(isNaN(final_t_amount)) {
                final_t_amount = 0;
            }
            var final_amount_after_tax = parseFloat(final_t_amount)-parseFloat(sum);
            $('#f_amount_after_tax').val(final_amount_after_tax);
        });
        $(document).on('change','#final_total_paid_amount',function(){
            var t_amt = JQ("#final_total_paid_amount").val();
            //console.log(t_amt);
            JQ("#final_t_amount").val(t_amt);
        });

        $(document).on('click','.check_final', function(){
            var  con = JQ("#final_contengency_amount").val();
            //console.log(con);
            var  ren = JQ("#final_renovate_amount").val();
            //console.log(ren);
            var bipat = JQ("#bipat_katti_rakam").val();
            //console.log(bipat);
            JQ("#final_renovate_amount").val(ren);
            //JQ("#")
            //console.log(ren);
            var total_amt_checked = parseFloat(con) + parseFloat(ren) + parseFloat(bipat);
            //console.log(total_amt_checked);
            JQ("#final_total_amount_deducted").val(total_amt_checked);
        });
        JQ(document).on("input","#final_contengency_amount,#final_renovate_amount",function(){
           
           var cont = JQ("#final_contengency_amount").val()||0;
           var katti = JQ("#final_renovate_amount").val()||0;
           
           var jamma_katti = parseFloat(cont)+parseFloat(katti);
           JQ("#final_total_amount_deducted").val(jamma_katti);
           
           var bhuk_amt = JQ("#kaam_ghati_katti_rakam").val()||0;
           var bhuk_after_katti = parseFloat(bhuk_amt)-parseFloat(jamma_katti);

        });
    });//end dom
</script>