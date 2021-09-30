<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
    redirectUrl();
}
?>
<?php
if($_GET['id']!=$_SESSION['set_plan_id']):
    die('Invalid Format');
endif;
$user=getUser();
$program_id=$_GET['id'];
$max_id= Programpaymentfinal::getMaxId($program_id);
$program_details = Plandetails1::find_by_id($program_id);
$amount= Programmoredetails::getSum($program_id);
$remaining_amount=($program_details->investment_amount)-($amount);
$program_payment_final_result= Programpaymentfinal::find_by_program_id2($program_id);
// print_r($program_payment_final_result);
if (isset($_POST['submit']))
{

    $program_payment_final= Programpaymentfinal::find_by_program_id_and_sn($program_id,$_POST['sn']);
    if(!empty($program_payment_final))
    {
        echo alertBox("अन्तिम भुक्तानी लगिसकेको ","program_payment_final.php?id=".$program_id);
    }
    else
    {
        for($i=0;$i<count($_POST['topic_name']);$i++) {
            $program_kar = new ProgramKatti();
            $program_kar->program_id = $_POST['program_id'];
            $program_kar->topic_name = $_POST['topic_name'][$i];
            $program_kar->percent = $_POST['percent'][$i];
            $program_kar->kar_katti_amount = $_POST['kar_katti_amount'][$i];
            $program_kar->katti_kar = $_POST['katti_kar'][$i];
            $program_kar->save();
        }

        $program =  new Programpaymentfinal ;
        $paid_date_nepali = $_POST['paid_date'];
        $paid_date_english = DateNepToEng($paid_date_nepali);
        $_POST['paid_date_english'] = $paid_date_english;
        $_POST['program_remaining_amount'] = $remaining_amount;

        if ($program->savePostData($_POST))
        {
            echo alertBox("अन्तिम भुक्तानी राख्न सफल ","program_payment_final.php?id=".$program_id);
        }
    }
}
$enlist_ids = Programmoredetails::find_enlist_ids_by_program_id($program_id);
$sn_result= Programmoredetails::find_by_program_id($program_id);
$sn_result_final= Programpaymentfinal::find_by_program_id1($program_id);
$sn_array= array();
$sn_array_final= array();
foreach ($sn_result as $sn):
    $sn1=$sn->sn;
    array_push($sn_array,$sn1);
endforeach;
foreach ($sn_result_final as $sn):
    $sn2=$sn->sn;
    array_push($sn_array_final,$sn2);
endforeach;
$sn_result1= array_diff($sn_array,$sn_array_final);
$sn_result2 = array_unique($sn_result1);
$budget_result= KattiWiwarn::find_by_sql("select * from settings_katti_wiwarn where what_is = 2");
$cont = Contingency::find_by_sql("select * from contingency where type=1");
foreach($cont as $cont):
endforeach;
//print_r($cont);
$marmat = Marmatsamhar::find_all();
foreach($marmat as $marmat):
endforeach;
//print_r($marmat);
$bipat = Bipat::find_all();
foreach($bipat as $bipat):
endforeach;
//print_r($bipat);
?>
<?php
include("menuincludes/header.php");
include("menu/header_script.php");
?>
<!-- js ends -->
<title>अन्तिम भुक्तानी :: <?php echo SITE_SUBHEADING;?></title>
</head>
<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">
    <div class="">
        <div class="">
            <div class="maincontent">
                <h2 class="headinguserprofile">अन्तिम भुक्तानी / <a href="program_dashboard.php?id=<?= $program_id ?>" class="btn">पछी जानुहोस </a></h2>
                <div class="OurContentFull">
                    <?php if(!empty($program_payment_final_result)):?>
                        <?php foreach($program_payment_final_result as $program_payment_final) :
                            $program_more_details1 = Programmoredetails::find_by_program_id_and_sn($program_id, $program_payment_final->sn);
                            ?>
                            <h2 class="header1"> <?php if($program_more_details1->type_id == 5)
                                {
                                    $up_sam = Upabhoktasamitiprofile::find_by_id($program_payment_final->enlist_id);
                                    echo $up_sam->program_organizer_group_name." द्वारा लागिएको";
                                }
                                else
                                {
                                    echo Enlist::getName1($program_payment_final->enlist_id)." द्वारा लागिएको";
                                }  ?> </h2>
                            <div style="display: none;" class="userprofiletable">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>कर्यादेस न:</td>
                                        <td><?= convertedcit(placeholder($program_payment_final-> sn)) ?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">कार्यक्रमको बाँकी रकम</td>
                                        <td><?php echo convertedcit(placeholder($program_payment_final-> program_remaining_amount));?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">भुक्तानी दिएको मिती</td>
                                        <td><?php echo convertedcit($program_payment_final-> paid_date);?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                        <td><?php echo convertedcit(placeholder($program_payment_final-> total_payment_amount));?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">भुक्तानी दिनु पर्ने कुल  रकम</td>
                                        <td><?php echo convertedcit(placeholder($program_payment_final-> total_payment_amount));?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                        <td><?php echo convertedcit(placeholder($program_payment_final-> payment_taken_amount));?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">धरौटी कट्टी रकम</td>
                                        <td><?php echo convertedcit(placeholder($program_payment_final-> deposit_amount));?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">जम्मा कट्टी रकम</td>
                                        <td><?php echo convertedcit(placeholder($program_payment_final-> total_amount));?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">भुक्तानी दिनु पर्ने खुद रकम</td>
                                        <td><?php echo convertedcit(placeholder($program_payment_final->net_total_amount)) ;?></td>
                                    </tr>
                                    <?php if($program_payment_final->id==$max_id || $user->mode=="superadmin"):?>
                                        <tr>
                                            <a href="program_payment_final_edit.php?id=<?php echo $program_payment_final->id; ?>"> <button class="submithere" onclick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')">सच्याउनु होस्</button></a> <a href="program_payment_final_delete.php?id=<?php echo $program_payment_final->id; ?>&program_id=<?= $program_id ?>"> <button class="submithere" onclick="return confirm('के तपाईँ निश्चित हुनुहुन्छ?')">हटाउनु होस्</button></a>
                                        </tr>
                                    <?php endif;?>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div class="userprofiletable">
                        <?php if (!empty($sn_result2)) : ?>
                            <h3>अन्तिम भुक्तानी थप्नुहोस + </h3>
                            <form method="POST" enctype="multipart/form-data">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>कर्यादेस न:</td>
                                        <td>
                                            <select class="sn5" name="sn">
                                                <option value="">--छान्नुहोस्--</option>
                                                <?php foreach($sn_result2 as $sn):?>
                                                    <option value="<?= $sn ?>"><?= $sn ?></option>
                                                <?php endforeach; ?>
                                                <input type="hidden" value="<?= $program_id ?>" class="program_id">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="enlist5">
                                    </tr>
                                    <tr>
                                        <td width="238">कार्यक्रमको बाँकी रकम</td>
                                        <td><?= $remaining_amount ?></td>
                                    </tr>
                                    <tr>
                                        <td width="238">मिती</td>
                                        <td><input type="text" id="nepaliDate5" name="paid_date" ></td>
                                    </tr>
                                    <tr>
                                        <td width="238">कुल बजेट </td>
                                        <td>
                                            <input type="text" class="work_order_budget" value="0" name="total_payment_amount" readonly="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">कुल रकम प्यान बिल हुँदा (भ्याट बाहेक )</td>
                                        <td>
                                            <input type="text"  value="0" name="pan_total_amt" class="bill_amount">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">TDS(15%)</td>
                                        <td>
                                            <input type="text"  value="0" name="pan_tds" class="tds_amount">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">कुल रकम भ्याट बिल हुँदा (भ्याट बाहेक )</td>
                                        <td>
                                            <input type="text"  value="0" name="vat_total_amt" class="vat_bill_amount">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">Vat Amount (13%)</td>
                                        <td>
                                            <input type="text"  value="0" name="vat_amount" class="vat_amount">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">TDS (1.5%)</td>
                                        <td>
                                            <input type="text"  value="0" name="vat_tds" class="t_vat_amount">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">Total Bill</td>
                                        <td>
                                            <input type="text"  value="0" name="total_bill" class="total_bill_amount">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">Tax</td>
                                        <td>
                                            <input type = "text" name="tax_tot" class="tax_amount">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">घटी / बढी रकम</td>
                                        <td>
                                            <input type = "text" name="more_less" class="ghati_amt" readonly="readonly">
                                        </td>
                                    </tr>
                                </table>
                                <div class="myspacer"></div>
                                <h1 class="myHeading1">कर कट्टी सम्बन्धि विवरण</h1>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-bordered table_1">
                                                <?php foreach ($budget_result as $br):?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $br->topic.' '.'('.$br->percent.')'.'%'?>
                                                            <input type="hidden" name="topic_name[]" value="<?=$br->id?>">
                                                            <input type="hidden" name="percent[]" class="percent" value="<?=$br->percent?>">
                                                        </td>
                                                        <td>
                                                            <label>
                                                                <input type="text" width="50%" name="kar_katti_amount[]" class="kar_katti_amount" id="kar_katti_amount" />
                                                            </label><span>
                                                            <label>
                                                                <input type="text" readonly="true" width="50%" name="katti_kar[]" class="katti_kar" id="katti_kar" />
                                                            </label></span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>कन्टिनजेंसी (<?php echo $cont->percent?>)%</td>
                                                    <input type="hidden" id="cont_per" value="<?=$cont->percent?>">
                                                    <td>
                                                        <input type="text" name="cont" id="cont">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>मर्मत (<?php echo $marmat->percent?>)%</td>
                                                    <input type="hidden" id="mar_per" value="<?=$marmat->percent?>">
                                                    <td>
                                                        <input type="text" name="marmat" id="marmat">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>बिपत (<?php echo $bipat->percent?>)%</td>
                                                    <input type="hidden" id="bip_per" value="<?=$bipat->percent?>">
                                                    <td>
                                                        <input type="text" name="bipat" id="bipat">
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="myspacer">
                                                जम्मा कर कट्टी <label><input type="text" id="total_kar" readonly="true" /></label><br>
                                                जम्मा कोष कट्टी<label><input type="text" id="kos_katti" readonly="true" /></label>
<!--                                                <span>कुल कट्टी <label><input class="text" name="kul_katti" id="kul_katti" /></label></span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="myspacer"></div>
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="238">पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                        <td>
                                            <input type="text" class="program_payment" value="0" name="payment_taken_amount"  readonly="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">धरौटी कट्टी रकम</td>
                                        <td><input type="text" class="deposit_amount" value="0" name="deposit_amount" ></td>
                                    </tr>
                                    <tr>
                                        <td width="238">जम्मा कट्टी रकम</td>
                                        <td><input type="text"  value="0" name="katti_amt" class="jamma_katti" readonly="true"></td>
                                    </tr>
                                    <tr>
                                        <td width="238">भुक्तानी दिनु पर्ने खुद रकम</td>
                                        <td>
                                            <input type="text" name="net_total_amount" class="net_total_amount"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="238">&nbsp;</td>
                                        <td><input type="submit" name="submit" value="सेभ गर्नुहोस" class="submithere"></td>
                                    </tr>
                                </table>
                                <input type="hidden" name="program_id" value="<?=(int) $_GET['id']?>" />
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- main menu ends -->
        </div>
    </div>
</div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>
<script>
    $(document).ready(function(){
        $(document).on('input','.bill_amount', function(){
            var t_tax = '';
            var total_net = '';
            var bill_rakam = $(this).val();
            var work_budget = $('.work_order_budget').val();
            var tds = bill_rakam * 0.15;
            $('.tds_amount').val(tds);
            var vt_amount = $('.t_vat_amount').val();
            var tt_amount = parseFloat(tds) + parseFloat(vt_amount);
            $('.tax_amount').val(tt_amount);
            var total_bill_amount = parseFloat($('.bill_amount').val()) + parseFloat($('.vat_bill_amount').val()) + parseFloat($('.vat_amount').val());
            var peski = $('.program_payment').val();
            var total_amount_bill = parseFloat(total_bill_amount)-parseFloat(peski);
            $('.total_bill_amount').val(total_bill_amount);
            $('.jamma_katti').val(parseFloat(peski) + parseFloat(tt_amount));
            if(work_budget < total_amount_bill ) {
                $('.net_total_amount').val(parseFloat(work_budget)-parseFloat(peski)-parseFloat(tt_amount));
            } else {
                $('.net_total_amount').val(parseFloat(total_amount_bill)-parseFloat(tt_amount));
            }
            var cont_per = $("#cont_per").val()||0;
            var mar_per = $("#mar_per").val()||0;
            var bip_per = $("#bip_per").val()||0;
            var contingency = parseFloat(bill_rakam)*cont_per/100;
            var marmat = parseFloat(bill_rakam)*mar_per/100;
            var bipat = parseFloat(bill_rakam)*bip_per/100;
            $("#cont").val(contingency)||0;
            $("#marmat").val(marmat)||0;
            $("#bipat").val(bipat)||0;
            // contingency katti + marmat + bipat ko lagi
            var contingency = JQ("#cont").val();
            // console.log(contingency);
            var marmat = JQ("#marmat").val();
            // console.log(marmat);
            var bipat = JQ("#bipat").val();
            // console.log(bipat);
            var total_kar = parseFloat(contingency)+parseFloat(marmat)+parseFloat(bipat);
            JQ("#total_kar").val(total_kar);
        });
        $(document).on('input','.vat_bill_amount', function(){
            var t_tax = '';
            var bill_rakam = $(this).val();
            var tds = bill_rakam * 0.13;
            var v_amount = parseFloat(bill_rakam);
            var v_vamount = v_amount * 0.015;
            var ghati_badhi_amt = parseFloat($('.total_bill_amount').val()) - parseFloat($('.work_order_budget').val());
            console.log($('.total_bill_amount').val());
            var work_budget = $('.work_order_budget').val();
            $('.ghati_amt').val(ghati_badhi_amt );
            //var vb_amount = v_vamount - (v_vamount * 0.015);
            var tt_amount = parseFloat(tds) + parseFloat(v_vamount);
            $('.vat_amount').val(tds);
            $('.t_vat_amount').val(v_vamount );
            var tds_amount = $('.tds_amount').val();
            var ttt_amount = parseFloat(tds_amount) + parseFloat($('.t_vat_amount').val());
            $('.tax_amount').val(ttt_amount);
            var total_bill_amount = parseFloat($('.bill_amount').val()) + parseFloat($('.vat_bill_amount').val()) + parseFloat($('.vat_amount').val());
            $('.total_bill_amount').val(total_bill_amount);
            var ghati_badhi_amt = parseFloat($('.total_bill_amount').val()) - parseFloat($('.work_order_budget').val());
            console.log($('.total_bill_amount').val());
            $('.ghati_amt').val(ghati_badhi_amt );
            var peski = $('.program_payment').val();
            var total_amount_bill = parseFloat(total_bill_amount)-parseFloat(peski);
            // $('.net_total_amount').val(total_amount_bill);
            $('.jamma_katti').val(parseFloat(peski) + parseFloat(ttt_amount ));
            if(work_budget < total_amount_bill ) {
                $('.net_total_amount').val(parseFloat(work_budget)-parseFloat(peski)-parseFloat(ttt_amount));
            } else {
                $('.net_total_amount').val(parseFloat(total_bill_amount)-parseFloat(peski)-parseFloat(ttt_amount ));
            }
        });
        JQ(document).on("input",".kar_katti_amount",function (){
            var value= JQ(this).closest('.kar_katti_amount').val();
            var value_new = JQ(this).closest('tr').find('.percent').val();
            var new_amount = parseFloat(value)*value_new/100;
            JQ(this).closest('tr').find('#katti_kar').val(new_amount);
            var sum = 0;
            JQ(".katti_kar").each(function(){
                var item_val=parseFloat(JQ(this).val());
                // console.log(item_val);
                if(isNaN(item_val)){
                    item_val = 0 ;
                }else{
                    sum += item_val;
                }
                JQ("#kos_katti").val(sum);

                var contingency = JQ("#cont").val();
                var marmat = JQ("#marmat").val();
                var bipat = JQ("#bipat").val();

                var total_kar = parseFloat(contingency)+parseFloat(marmat)+parseFloat(bipat);
                var total_kar_katti = parseFloat(total_kar)+parseFloat(sum);

                JQ("#kul_katti").val(total_kar_katti);
                var a = JQ(".tax_amount").val();
                JQ(".jamma_katti").val(parseFloat(total_kar_katti)+parseFloat(a));
            });
        });
        JQ(document).on("input","#cont,#marmat,#bipat",function(){
            // alert(2);
            var contingency = JQ("#cont").val();
            var marmat = JQ("#marmat").val();
            var bipat = JQ("#bipat").val();

            var total_kar = parseFloat(contingency)+parseFloat(marmat)+parseFloat(bipat);
            JQ("#total_kar").val(total_kar);

            var kos_katti_1 = JQ("#kos_katti").val();
            var kul_katti = parseFloat(total_kar)+parseFloat(kos_katti_1);
            // console.log(kul_katti);
            JQ("#kul_katti").val(kul_katti);
            var a = JQ(".tax_amount").val();
            // console.log(a);
            var t = parseFloat(a)+parseFloat(kos_katti_1)+parseFloat(total_kar);
            JQ(".jamma_katti").val(parseFloat(a)+parseFloat(kos_katti_1)+parseFloat(total_kar));
            var new_b = JQ(".bill_amount").val();
            JQ(".net_total_amount").val(parseFloat(new_b)-parseFloat(t));
        });
    })
</script>