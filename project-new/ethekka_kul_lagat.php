<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
    redirectUrl();
}
$bhautik_lakshya =   Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'],1);
if(isset($_POST['submit']))
{
    if(!empty($_POST['create_id']))
    {
        $data = Ethekka_lagat::find_by_id($_POST['create_id']);
    }
    else
    {
        $data = new Ethekka_lagat();
    }
        $data->plan_id = $_POST['plan_id'];
        $data->agreement_gaupalika = $_POST['agreement_gaupalika'];
        $data->kul_rakam = $_POST['kul_rakam'];
        $data->contract_total_investment = $_POST['contract_total_investment'];
        $data->katti = $_POST['katti'];
        $data->yojana_start_date = $_POST['yojana_start_date'];
        $data->yojana_end_date = $_POST['yojana_end_date'];
        $data->yojanaa_samjhauta_date = $_POST['yojanaa_samjhauta_date'];
        $data->anya_nikaya =$_POST['anya_nikaya'];
        $data->cont = $_POST['cont'];
        $data->lagat_miti = $_POST['lagat_miti'];
        $data->anya_nikaya_amount = $_POST['anya_nikaya_amount'];
        $data->anya_nikaya_per = $_POST['anya_nikaya_per'];
        $data->agreement_gaupalika_per = $_POST['agreement_gaupalika_per'];
        $data->total_investment = $_POST['total_investment'];
        $data->save();

    foreach($bhautik_lakshya as $a)
    {
        $a->delete();
    }
        for($i=0;$i<count($_POST['details_id']);$i++)
        {
            $detail = new Bhautik_lakshya();
            $detail->details_id = $_POST['details_id'][$i];
            $detail->qty = $_POST['qty'][$i];
            $detail->unit_id = $_POST['unit_id'][$i];
            $detail->plan_id = $_POST['plan_id'];
            $detail->miti    = DateEngToNep(date("Y-m-d",time()));
            $detail->miti_english  = (date("Y-m-d",time()));
            $detail->type = 1;
            if($detail->save())
            {
                echo alertBox("थप / सच्याउन  सफल","ethekka_lagat_info_form.php");
            }

        }
    }


$invest_details = Ethekka_lagat::find_by_plan_id($_GET['id']);
                         if(empty($invest_details))
                          {
                            $invest_details = Ethekka_lagat::setEmptyObjects();
                          }
                          !empty($invest_details->id)? $value="अपडेट गर्नुहोस" : $value="सेभ गर्नुहोस";

$postnames=  Postname::find_all();
$units = Units::find_all();
$sql="select * from enlist where type=0";
$enlist=Enlist::find_by_sql($sql);
$contract_info=  Contractinfo::find_by_plan_id($_GET['id']);
$ethekka = Ethekkainfo::find_by_plan_id($_GET['id']);
$results_1= Plandetails1::find_by_id($_SESSION['set_plan_id']);
$bhautik_details = Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'],1);
$SettingbhautikPariman = SettingbhautikPariman::find_all();
?>
<?php include("menuincludes/header.php");?>
    <title>योजनाको कुल लागत अनुमान :: <?php echo SITE_SUBHEADING;?></title>
    <style>
        table {

            width: 100%;
            border: none;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 3px solid #ddd;
        }

        tr:nth-child(even) {background-color: #f2f2f2;}
        tr:hover {background-color:#f5f5f5;}
        ::placeholder{
            color: red;
        }
    </style>
<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">
    <div class="">
        <form method="post" enctype="multipart/form_data" >
            <div class="maincontent">
                <h2 class="headinguserprofile">ठेक्काको कुल लागत अनुमान | <a href="contract_dashboard.php" class="btn">पछि जानुहोस</a></h2>
                <h2 class="headinguserprofile">योजनाको नाम :: <?php echo $results_1->program_name;?> - <?php echo convertedcit($results_1->investment_amount)?></h2>
                <div class="myspacer"></div>
                <div class="inputWrap2">
                    <h2 class="headinguserprofile">ई-ठेक्काको कुल लागत अनुमान भर्नुहोस्</h2>
                    <div class="inputWrap33 inputWrapLeft">
                        <div class="titleInput">गाँउपालिकाबाट अनुदान</div>
                        <div style="color:orangered;">
                            <input type="checkbox" name="cont_check" id="cont_check" <?php if(!empty($invest_details->cont)){ echo
                            "checked";?><?php }?>>कन्टिन्जेन्सी काट्नु पर्ने भए
                        </div>

                        <div class="newInput"><input type="text" id="agreement_gaupalika" readonly="true"  name="agreement_gaupalika"  value="<?php echo $results_1->investment_amount; ?>" />
                            <label><input type="text" name="agreement_gaupalika_per" id="agreement_gaupalika_per" value="<?php echo $invest_details->agreement_gaupalika_per?>" readonly="true" placeholder="प्रतिशद"/>%</label>
                        </div>
                        <!--<div class="titleInput">ठेक्का कबोल गरेको कुल रकम </div>-->
                        <!--<div class="newInput"><input type="text" readonly="true"  name="kul_rakam"  value="<?php echo $ethekka->kabol_rakam?>" /></div>-->
                        कन्टिन्जेन्सी: <input type="text" id="cont" name="cont" value="<?php echo $invest_details->cont?>">

                    </div><!-- inputwrap 33 ends here -->
                <div class="inputWrap33 inputWrapLeft">
                    <div class="titleInput">कुल ल.ई ठेक्का रकम</div>
                    <div class="newInput"><input type="text" name="contract_total_investment" id="contract_total_investment" value="<?php
                        if(empty($invest_details)){
                            echo $ethekka->thekka_rakam;
                        }else{
                            echo $invest_details->contract_total_investment;
                        }
                        ?>"/>
                        <label><input type="text" name="kul_per" readonly="true" value="100"/>% </label></div>
                    <div class="titleInput">अन्य कुनै साझेदारी निकाय भए !! : <label><input type="textarea" name="anya_nikaya" id="anya_nikaya" value="<?php echo $invest_details->anya_nikaya?>" placeholder="निकाएको नाम ??" /></label></div>
                    <!--<div style="color:red;">-->
                    <!--    <input type="checkbox" name="cont_check_1" id="cont_check_1" >कन्टिन्जेन्सी काट्नु पर्ने भए-->
                    <!--</div>-->
                    <div class="newInput"><input type="text" readonly="true" name="anya_nikaya_amount" id="anya_nikaya_amount" value="<?php echo $invest_details->anya_nikaya_amount; ?>" />
                    <label><input type="text" name="anya_nikaya_per" id="anya_nikaya_per" value="<?php echo $invest_details->anya_nikaya_per?>" placeholder="प्रतिशद"/>%</label>
                    </div>
                </div><!-- inputwrap 33 ends here -->
                    <div class="inputWrap33 inputWrapLeft">
                        <div class="titleInput">कट्टी रकम भए (कुनै कर कट्टी)</div>
                        <div class="newInput"><input type="text" name="katti" id="katti" value="<?php echo $invest_details->katti?>"/></div>
                        <div class="titleInput">कार्यदेश दिएको  रकम</div>
                        <div class="newInput">
                            <input type="text" name="total_investment" readonly="true"  id="total_investment" value="<?php echo $invest_details->total_investment?>"/>
                        </div>
                        <div class="titleInput">मिति :</div>
                        <div class="newInput"><input type="text" name="lagat_miti" id="nepaliDate14"  value="<?=($invest_details->lagat_miti)?>" class="datewidth80" /></div>
                    </div><!-- inputwrap 33 ends here -->
            </div>
                <div class="myspacer"></div>
                <div class="inputWrap2">
                    <h1>योजना सम्बन्धि अन्य विवरण</h1>
                    <div class="inputWrap33 inputWrapLeft">
                        <div class="titleInput">योजना सुरु हुने मिति :</div>
                        <div class="newInput"><input type="text"  id="nepaliDate12"  class="datewidth80" name="yojana_start_date" value="<?php echo ($invest_details->yojana_start_date);?>"></div>
                    </div><!-- input wrap 33 ends -->
                    <div class="inputWrap33 inputWrapLeft">
                        <div class="titleInput">योजना सम्पन्न हुने मिति :</div>
                        <div class="newInput"><input type="text"  id="nepaliDate13"  class="datewidth80" name="yojana_end_date" value="<?php echo ($invest_details->yojana_end_date);?>"></div>
                    </div><!-- input wrap 33 ends -->
                    <div class="inputWrap33 inputWrapLeft">
                        <div class="titleInput">योजना सम्झौता मिति :</div>
                        <div class="newInput"><input type="text"  id="nepaliDate15"  class="datewidth80" name="yojanaa_samjhauta_date" value="<?php echo ($invest_details->yojanaa_samjhauta_date);?>"></div>
                    </div><!-- input wrap 33 ends -->
                </div>
                <div class="myspacer20"></div>
                <div class="inputWrap2">
                    <h2 class="headinguserprofile">भौतिक लक्ष्य शिर्षक छानुहोस</h2>
                    <div class="clearfix"></div>
                    <table class="table table-bordered">
                        <tr>
                            <th>सि. नं</th>
                            <th>परिमाणको शिर्षक </th>
                            <th>परिमाण</th>
                            <th>भौतिक इकाई </th>
                            <th style="5%">#</th>
                        </tr>
                        <?php if(empty($bhautik_details)){?>
                            <tr>
                                <td>1</td>
                                <td>
                                    <select name="details_id[]" style="min-width: 94%;">
                                        <option value="">--------</option>
                                        <?php foreach($SettingbhautikPariman as $data):?>
                                            <option value="<?=$data->id?>"><?=$data->name?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <span class="" style="width:4%;"> <button type="button" style="float:right;" class="cl_bg" data-toggle="modal" data-target="#myModal"> + </button> </span>
                                    <!-- <div class="myclear"></div>-->
                                </td>
                                <td><input type="text" name="qty[]"/></td>
                                <td>
                                    <select name="unit_id[]">
                                        <option value="">--छान्नुहोस्--</option>
                                        <?php foreach($units as $unit): ?>
                                            <optio value="<?=$unit->id?>"  ><?=$unit->name?></optio>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                            </tr>
                        <?php }else{
                            $i=1;
                            foreach($bhautik_details as $result):
                                ?>
                            <tr <?php if($i!=1){?>class="remove_plan_form_details"<?php }?>>
                                <td><?=$i?></td>
                                <td>
                                    <select name="details_id[]">
                                        <option value="">--------</option>
                                        <?php foreach($SettingbhautikPariman as $data):?>
                                            <option value="<?=$data->id?>" <?php if($data->id==$result->details_id){ echo 'selected="selected"';}?>><?=$data->name?></option>
                                        <?php endforeach;?>
                                    </select>
                                </td>
                                <td><input type="text" name="qty[]" value="<?=$result->qty?>"/></td>
                                <td>
                                    <select name="unit_id[]">
                                        <option value="">--छान्नुहोस् --</option>
                                        <?php foreach($units as $unit): ?>
                                            <option value="<?=$unit->id?>" <?php if($unit->id==$result->unit_id){ echo 'selected="selected"';}?>><?=$unit->name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <?php
                                if($i!=1){
                                    ?>
                                    <td><button class="remove_btn" id="remove_btn_<?=$i?>"><img src="images/cross.png" style="height: 20px; width: 20px;"></button></td></tr>';
                                <?php }?>
                                </tr>
                                <?php $i++;endforeach;}?>
                        <tbody id="join_table_plan_form_1">
                        </tbody>
                    </table>
                    <label><div class="add_plan_form1 button btn-success myWidth100">थप्नुहोस [+]</div></label>
                    <label><div class="remove_plan_form1 button btn-danger myWidth100">हटाउनुहोस [-]</div></label>
                    <input type="hidden" id="plan_id" name="plan_id" value="<?=$_GET['id']?>" class="btn"/>
                    <input type="hidden" name="create_id" value="<?=$invest_details->id?>" class="btn"/>
                    <div class="myspacer"></div>
        </div><!-- input wrap 100 ends -->
                </div>
            <div class="myspacer"></div>

            <div style="margin-left: 1250px;">
                <input type="submit" name="submit" class="btn-primary" value="<?php echo $value?>"></div>
    </div><!-- input wrap 33 ends -->

    </form>
</div>
        </div>
    </div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>
<script>
    JQ(document).ready(function() {
        JQ(document).on("click", ".add_plan_form1", function () {
            // alert("here");
                var num=JQ(".remove_plan_form_details").length;
                var counter=num+2;
                var param = {};
                param.counter= counter;
                JQ.post('get_bhautik_pariman_details.php',param,function(res){
                    var obj = JSON.parse(res);

                    JQ("#join_table_plan_form_1").append(obj.html);
                });
            });
            JQ(document).on("click",".remove_plan_form1",function() {
                JQ('.remove_plan_form_details').last().remove();
            });
            JQ(document).on("click",".remove_btn",function() {
                JQ(this).closest('tr').remove();
                var i = 1;
                JQ(".sn").each(function(){
                    JQ(this).html(i+1);
                    i++;
                });
        });
            JQ(document).on("input","#katti,#anya_nikaya_per",function(){
               // alert('ssss');
                var katti = JQ("#katti").val()||0;
                var nagar_palika = JQ("#agreement_gaupalika").val()||0;
                var contract_total_investment = JQ("#contract_total_investment").val()||0;
                var anya_sajhe_per = JQ("#anya_nikaya_per").val()||0;
                var anya_nikay_amount = contract_total_investment*anya_sajhe_per/100;
                var total_anudan = parseFloat(contract_total_investment)-parseFloat(anya_nikay_amount);
                //var per = nagar_palika/contract_total_investment*100;
                
                JQ("#anya_nikaya_amount").val(anya_nikay_amount)||0;
                JQ("#agreement_gaupalika_per").val(100-anya_sajhe_per);
                JQ("#agreement_gaupalika").val(total_anudan);
                //var nagar = JQ("#")
                              
                var total_investment = parseFloat(total_anudan)+parseFloat(anya_nikay_amount)-parseFloat(katti);
                
                JQ("#total_investment").val(total_investment);
            });
            JQ(document).on("click","#cont_check",function(){
                var plan_id = JQ("#plan_id").val();
                var param = {};
                param.plan_id= plan_id;
                JQ.post('get_contingency_for_plan.php',param,function(res) {
                    var obj = JSON.parse(res);
                    var nagar_palika = JQ("#agreement_gaupalika").val()||0;

                    var val = parseFloat(obj.html);
                    var con_glob = parseFloat(val);
                    // console.log(con_glob);
                    var with_cont = parseFloat(nagar_palika)*con_glob;
                    if(JQ("#cont_check").prop("checked")){
                        JQ("#cont").val(with_cont)||0;
                    }else{
                        JQ("#cont").val(0);
                    }
                    var total_investment = JQ("#total_investment").val();
                    var with_con_total = parseFloat(total_investment)-parseFloat(with_cont);
                    var with_cont = parseFloat(with_cont);
                    var val = parseFloat(total_investment)+parseFloat(with_cont);
                    if(JQ("#cont_check").prop("checked")){
                        JQ("#total_investment").val(with_con_total);
                    }else{
                        JQ("#total_investment").val(val);
                    }

                });
            });
    });
</script>
