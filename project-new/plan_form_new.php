<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
//if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
//{
//redirectUrl();
//}
$mode=getUserMode();
$shrot_result= ShrotDetails::find_all();
//print_r($shrot_result);
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
$a=0;
if(isset($_GET['break_plan_id']))
{
    $a=1;
    $parent_plan_id = $_GET['break_plan_id'];
}
if(isset($_POST['submit_bisayaghat']))
{
    $data=new Topicarea();
    //$data->sn= $_POST['sn'];
    $data->name= $_POST['name'];
    $data->budget= $_POST['budget'];
    $topic_id=$data->save();
    for($i=0;$i<count($_POST['budgets']);$i++)
    {
        $result = new TopicAreaBudgetShrot();
        $result->shrot_id = $_POST['shrot_id'][$i];
        $result->budget = $_POST['budgets'][$i];
        $result->topic_area_id = $topic_id;
        $result->save();
    }

}
if(isset($_POST['submit']))
{
    $data=new Plandetails1();
    //$data->sn=$_POST['sn'];
    //$data->budget_id = implode(",", $_POST['budget_id']);
    $data->fiscal_id=$_POST['fiscal_id'];
    $data->budget_id = implode(",", $_POST['budget_id']);
    $data->type=$_POST['type'];
    $data->expenditure_type=$_POST['expenditure_type'];
    $data->parishad_sno=$_POST['parishad_sno'];
    $data->topic_area_id=$_POST['topic_area_id'];
    $data->topic_area_type_id=$_POST['topic_area_type_id'];
    $data->topic_area_type_sub_id=$_POST['topic_area_type_sub_id'];
    $data->topic_area_agreement_id=$_POST['topic_area_agreement_id'];
    $data->topic_area_investment_id=$_POST['topic_area_investment_id'];
    $data->ward_no=$_POST['ward_no'];
    $data->program_name=$_POST['program_name'];
    $data->investment_amount=$_POST['investment_amount'];
    $data->first=$_POST['first'];
    $data->second=$_POST['second'];
    $data->third=$_POST['third'];
    if($plan_id=$data->save())
    {
        for($k=0;$k < count($_POST['budget_id']);$k++) {
            $dn = new Extrainvestment();
            $dn->amount    = $_POST['amount'][$k];
            $dn->topic_id  = $_POST['topic_id'];
            $dn->budget_id = $_POST['budget_id'][$k];
            $dn->plan_id   = $plan_id;
            $dn->save();
        };
      
        if(isset($_POST['break_plan_id']))
        {
            savechildplan($plan_id, $_POST['break_plan_id'],$_POST['investment_amount']);
        }

        $session->message("नया योजना दर्ता न० ".$plan_id);
        redirect_to("plan_form_new.php");
    }

}
$postnames = Postname::find_all();
$topic_area=  Topicarea::find_all();
$topic_area_type=Topicareatype::find_all();
$topic_area_agreement= Topicareaagreement::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area_investment_source= Topicareainvestmentsource::find_all();
$bank_details=  Bankinformation::find_all();
$fiscals=  Fiscalyear::find_all();
$budget_result= Topicbudget::find_all();
//$topic_result = Topicareatype::find_all();
//echo "<pre>";print_r($budget_result);echo "</pre>";exit;
$expenditure_type=1;
?>

<?php include("menuincludes/header.php");
include("menuincludes/calculator_header.php");?>

<body>
<?php include("menuincludes/topwrap.php"); ?>
<div id="body_wrap_inner">

    <div class="maincontent">
        <h2 class="headinguserprofile"> नया योजनाको विवरण | <a href="index.php" class="btn">पछि जानुहोस </a></h2>

        <div class="OurContentFull">
            <div class="myMessage"> <?php echo $message;?></div>
            <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->

            <div class="userprofiletable">
                <h3 id="total_topic_budget" style="display: none;"></h3><h3 id="remaining_budget_show" style="display: none;" ></h3>

                <form method="post" enctype="multipart/form_data" >

                    <div class="inputWrap2">
                        <?php if($a==1)
                        {
                            $parent_plan = Plandetails1::find_by_id($parent_plan_id);
                            $child_sum_amount=0;
                            $child_result = Childplandetails::find_plan_ids_by_parent_plan_id($parent_plan_id);
                            ?>
                            <?php if(empty($child_result))
                        {
                            $parent_investment_amount = $parent_plan->investment_amount;

                            ?>
                            <h3>मुख्य योजना: <?= $parent_plan->program_name ?> ||  विनियोजित बजेट : रु. <?= convertedcit(placeholder($parent_plan->investment_amount)) ?></h3>
                            <?php
                        }
                        else
                        {
                            $all_child  = find_all_child_plan_by_parent_id($parent_plan_id);
                            foreach($all_child as $child):
                                $child_sum_amount+=$child->investment_amount;
                                ?>
                            <?php endforeach; ?>
                            <h3>मुख्य योजना: <?= $parent_plan->program_name ?> ||  विनियोजित बजेट : रु. <?= convertedcit(placeholder($parent_plan->investment_amount +$child_sum_amount)) ?></h3>
                            <?php
                            foreach($all_child as $child):
                                ?>
                                <h3>योजना : <?= $child->program_name ?> || विनियोजित रकम : रु. <?= convertedcit(placeholder($child->investment_amount)) ?></h3>
                            <?php endforeach;
                            $parent_investment_amount = $parent_plan->investment_amount + $child_sum_amount;
                        }

                            $remaining_amount = $parent_investment_amount - $child_sum_amount;
                            ?>
                            <h3>मुख्य योजनाको  बाकी विनियोजित रकम : रु. <?= convertedcit(placeholder($remaining_amount)) ?> </h3>
                            <h3>माथीको योजनाको भित्रको नया योजनाको विवरण भर्नुहोस</h3>
                        <?php }

                        else { ?>
                            <h3>नया योजनाको विवरण भर्नुहोस </h3>
                        <?php } ?>

                        <h1>नया योजनाको विवरण भर्नुहोस</h1>
                        <div class="inputWrap33 inputWrapLeft">
                            <div class="titleInput">आर्थिक वर्ष :</div>
                            <div class="newInput">
                                <select id="fiscal_id"  name="fiscal_id">
                                    <option value="">--छान्नुहोस्--</option>
                                    <?php foreach($fiscals as $data):?>
                                        <option value="<?php echo $data->id;?>" <?php if($data->is_current==1){?> selected="selected" <?php }?>><?php echo convertedcit($data->year);?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            
                            <div class="titleInput">बिनियोजन श्रोत र व्याख्या:  :</div>
                            <div class="newInput"><textarea  id="parishad_sno"  name="parishad_sno" ></textarea></div>
                            <div class="titleInput">खर्च किसिम छान्नुहोस् :</div>
                            <div class="newInput"><select name="expenditure_type  " >
                                    <option value="">--छान्नुहोस्--</option>
                                    <option value="1" <?php if($expenditure_type==1){ echo 'selected="selected"';}?>>पुँजीगत खर्च </option>
                                    <option value="2" <?php if($expenditure_type==2){ echo 'selected="selected"';}?>>चालु खर्च </option>
                                </select></div>
                            <div class="titleInput">किसिम छान्नुहोस् :</div>
                            <div class="newInput"><select name="type" required>
                                    <?php if($a==1)
                                    { ?>
                                        <option value="0">योजना</option>
                                    <?php } else
                                    {?>
                                        <option value="">--छान्नुहोस्--</option>
                                        <option value="0">योजना</option>
                                        <option value="1">कार्यक्रम</option>
                                    <?php } ?>

                                </select></div>
                        </div><!-- input wrap 33 ends -->
                        <div class="inputWrap33 inputWrapLeft">
                            <div class="titleInput">योजना / कार्यक्रमको नाम :</div>
                            <div class="newInput"><textarea id="topic_name" name="program_name" ></textarea></div>
                            <div class="titleInput"> योजना / कार्यक्रमको बिषयगत क्षेत्रको किसिम:  <button style="float:right: margin-top:-2px;" type="button" class=" cl_bg" data-toggle="modal" data-target="#myModal" id="length-1-c" > + </button></div>
                            <div class="newInput" id="append_bisayaghat"><select name="topic_area_id" id="topic_area_id" >
                                    <option value="">--छान्नुहोस्--</option>
                                    <?php foreach($topic_area as $topic): ?>
                                        <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <!--<div class="myfloatright marginminus5">  </div>-->
                            <!--<div class="myclear"></div>-->
                            <div id="topic_area_type_id" class="append_sirsagat" ></div>
                            <div id="topic_area_type_sub_id" class="append_upasirsagat"></div>
                            <div class="titleInput">योजना / कार्यक्रमको बजेट उपशिर्षक  :
                                <button style="float:right; margin-top:-3px;" type="button" class="cl_bg" data-toggle="modal" data-target="#exampleModal">+</button></button>
                              </div>


                            <div class="newInput" id="appent_anudan_kisim">
                                <table class="table table-bordered">
                                    <tbody id="detail_add_table">
                                    <tr>
                                        <td>१</td>
                                        <td> <select name="budget_id[]" >
                                                <option value="">--छान्नुहोस्--</option>
                                                <?php foreach($budget_result as $topic): ?>
                                                    <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <input type="text" name="amount[]" placeholder="रकम">
                                        </td>
                                        <td></td>
                                        <!--<td>-->
                                        <!--    कन्टेनजेन्सी:  <input type="checkbox" value="1" name="is_c[]">-->
                                        <!--</td>-->
                                        <!--<td>-->
                                        <!--    <input type="text" name="c_percent[]" placeholder="प्रतिशत">-->
                                        <!--</td>-->
                                    </tr>
                                    </tbody>
                                    <tr>
                                        <td>
                                            <span class="btn btn-info" id="add"><i class="fa fa-plus"></i></span>
                                        </td>
                                        <td colspan="3"></td>
                                        <td>
                                            <span class="btn btn-info" id="remove"><i class="fa fa-minus"></i></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div><!-- input wrap 33 ends -->
                        <div class="inputWrap33 inputWrapLeft">
                            <div class="titleInput">योजना / कार्यक्रमको विनियोजन किसिम:</div>
                            <div class="newInput">
                                <select name="topic_area_investment_id" class="select2" >
                                    <option value="">--छान्नुहोस्--</option>
                                    <?php foreach($topic_area_investment as $topic): ?>
                                        <option value="<?php echo $topic->id?>"><?php echo $topic->name;  ?></option>
                                    <?php endforeach; ?>
                                </select></div>
                            <div class="titleInput">वार्ड नं :</div>
                            <div class="newInput"><input type="text" id="topic_name"  name="ward_no" ></div>
                            <div class="titleInput">अनुदान रु :</div>
                            <div class="newInput"><input type="text"  name="investment_amount" id="investment_first" ></div>
                            <div class="titleInput">पहिलो चौमासिक: </div>
                            <div class="newInput"><input type="text"  name="first" id="first" value="0" ></div>
                            <div class="titleInput">दोस्रो चौमासिक:</div>
                            <div class="newInput"><input type="text"  name="second" id="second" value="0" ></div>
                            <div class="titleInput">तेस्रो चौमासिक:</div>
                            <div class="newInput"><input type="text"  name="third" id="third" value="0" ></div>
                            <div class="saveBtn myCenter"><input type="submit" id="first_check" name="submit" value="सेभ गर्नुहोस" class="btn"></div>
                        </div><!-- input wrap 33 ends -->
                        <div class="myspacer"></div>

                    </div><!-- input wrap ends -->
                    <?php if($a==1):  ?>
                        <input type="hidden" name="break_plan_id" value="<?= $_GET['break_plan_id'] ?>">
                        <input type="hidden" class="remaining_amount_check" value="<?= $remaining_amount ?>">
                    <?php endif; ?>

                </form>

                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog" style=" top:20%;">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">बिषयगत क्षेत्र थप्नुहोस</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" >
                                    <div class="">
                                        <h1 style="font-size:18px; font-weight:bold; margin-bottom:25px;">बिषयगत क्षेत्र थप्नुहोस </h1>
                                        <div class="titleInput">बिषयगत क्षेत्रको नाम</div>
                                        <div class="newInput"><input type="text" id="topic_name_add" name="name" required></div>
                                        <div class="titleInput">बजेट रकम </div>
                                        <div class="newInput"><input type="text" id="budget_add" name="budget" required></div>
                                        <!--<div class="inputWrap33 inputWrapLeft"><input type="submit" name="submit_bisayaghat" value="सेभ गर्नुहोस" class="btn"></div>-->
                                    </div><!-- input wrap ends -->

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" style="color: #fff; background: #6c757d; border-color: #6c757d;" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="bisyaghat_chhetra">Save</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal fade" id="myModal1" role="dialog">
                    <div class="modal-dialog" style=" top:20%;">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">योजनाको शिर्षकगत किसिम  थप्नुहोस</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" >
                                    <div class="">
                                        <h1 style="font-size:18px; font-weight:bold; margin-bottom:25px;">योजनाको शिर्षकगत किसिम  थप्नुहोस </h1>
                                        <div class="titleInput">बिषयगत क्षेत्रको नाम:</div>
                                        <div class="newInput"><select name="topic_id" id="topic_id_add" required>
                                                <option value="">--छान्नुहोस्--</option>
                                                <?php foreach($topic_area as $data): ?>
                                                    <option value="<?php echo $data->id;?>"><?php echo $data->name;?></option>
                                                <?php endforeach; ?>
                                            </select></div>
                                        <div class="titleInput">आयोजनाको शिर्षकगत किसिम:</div>
                                        <div class="newInput"><input type="text" id="topic_shirsagat_name_add" name="name" required></div>
                                        <div class="titleInput">बजेट रकम </div>
                                        <div class="newInput"><input type="text" id="budget_shirsagat_add" name="budget" required></div>
                                    </div><!-- input wrap ends -->

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" style="color: #fff; background: #6c757d; border-color: #6c757d;" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="shirhagat_kisim">Save</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal fade" id="myModal2" role="dialog">
                    <div class="modal-dialog" style=" top:20%;">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">योजनाको उपशिर्षकगत किसिम  थप्नुहोस</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" >
                                    <div class="">
                                        <h1 style="font-size:18px; font-weight:bold; margin-bottom:25px;">योजनाको उपशिर्षक शिर्षक थप्नुहोस </h1>
                                        <div class="titleInput">योजनाको उपशिर्षक किसिम : </div>
                                        <div class="newInput"><input type="text" id="topic_area_type_sub_name" name="topic_area_type_sub" required></div>
                                    </div><!-- input wrap ends -->

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" style="color: #fff; background: #6c757d; border-color: #6c757d;" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="upashirhagat_kisim">Save</button>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal fade" id="myModal3" role="dialog">
                    <div class="modal-dialog" style=" top:20%;">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">योजना / कार्यक्रमको अनुदानको किसिम:   थप्नुहोस</h4>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data" >
                                    <div class="">
                                        <h1 style="font-size:18px; font-weight:bold; margin-bottom:25px;">योजनाको अनुदानको किसिम  थप्नुहोस [+]</h1>
                                        <div class="titleInput">अनुदानको नाम : </div>
                                        <div class="newInput"><input type="text" id="anudan_name" name="name" required></div>
                                    </div><!-- input wrap ends -->

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" style="color: #fff; background: #6c757d; border-color: #6c757d;" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="anudan_kisim">Save</button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- बजेट उपशिर्ष  Popup Module -->
                <div style="z-index:9999;" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel"> <b>  बजेट उपशिर्षक थप्नुहोस  </b></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="">
                                        <div class="titleInput">बजेट उपशिर्षकको नाम:</div>
                                        <div class="newInput"><input type="text" id="topic_name" name="name" value="<?php echo $data->name;?>" required></div>
                                        <div class="myspacer"></div>
                                    </div><!-- input wrap ends -->
                                </form>
                            </div>
                            <div class="modal-footer myCenter">
                                <button type="button" class="btn" style="color: #fff; background: #6c757d; border-color: #6c757d;" data-dismiss="modal">Close</button>
                                <input type="submit" name="submit" value="सेभ गर्नुहोस" class="btn">
                                <input  type="hidden" name="update_id" value="<?=$data->id?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- बजेट उपशिर्ष  Popup Modue  Close-->


            </div>
        </div>
    </div>
</div><!-- main menu ends -->
<!--</div><!-- top wrap ends -->-->
<!--<?php include("menuincludes/footer.php"); ?>-->

<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Raleway'>
<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
<link rel="stylesheet" href="multiselect/css/style.css">
<script  src="multiselect/js/index.js"></script>
<script>
    var JQ = jQuery.noConflict();
    JQ(document).on("click","#anudan_kisim",function() {
        var anudan_name= JQ("#anudan_name").val();
        var param = {};
        param.anudan_name= anudan_name;
        JQ.post('add_anudan_kisim.php',param,function(res){
            var obj = JSON.parse(res);
            JQ("#appent_anudan_kisim").html(obj.html);
        });
    });
    JQ(document).on("click","#bisyaghat_chhetra",function() {
        var topic_name_add= JQ("#topic_name_add").val();
        var budget_add= JQ("#budget_add").val();
        var param = {};
        param.budget_add= budget_add;
        param.topic_name_add= topic_name_add;
        JQ.post('add_bisayaghat_chhetra.php',param,function(res){
            var obj = JSON.parse(res);
            JQ("#append_bisayaghat").html(obj.html);
        });
    });
    JQ(document).on("click","#shirhagat_kisim",function() {

        var topic_id_add= JQ("#topic_id_add").val();
        var topic_name_add= JQ("#topic_shirsagat_name_add").val();
        var budget_add= JQ("#budget_shirsagat_add").val();
        var param = {};
        param.budget_add= budget_add;
        param.topic_name_add= topic_name_add;
        param.topic_id= topic_id_add;
        JQ.post('add_shirsagat_kisim.php',param,function(res){
            var obj = JSON.parse(res);
            JQ(".append_sirsagat").html(obj.html);
        });
    });
    JQ(document).on("click","#upashirhagat_kisim",function() {

        var topic_id_add           = JQ("#topic_area_id").val();
        var topic_area_type_id_add = JQ("[name=topic_area_type_id]").val();
        var topic_area_type_sub    = JQ("#topic_area_type_sub_name").val();
//                            alert(topic_id_add +" - "+ topic_area_type_id_add +" - "+topic_area_type_sub);return false;
        var param = {};
        param.topic_id_add            = topic_id_add;
        param.topic_area_type_id_add  = topic_area_type_id_add;
        param.topic_area_type_sub     = topic_area_type_sub;

        JQ.post('add_upashirsagat_kisim.php',param,function(res){
            var obj = JSON.parse(res);
            JQ(".append_upasirsagat").html(obj.html);
        });
    });

    JQ(document).on("click", "#add", function () {
        var num = JQ(".remove_anudan_details").length;
        var counter = num + 2;
        //           alert(counter);return false;
        var param = {};
        param.counter = counter;
        JQ.post('get_anudan_details.php', param, function (res) {
            var obj = JSON.parse(res);
            //alert(obj.html);
            JQ("#detail_add_table").append(obj.html);
            //JQ('#interest_amount_'+id).val(obj.interest_amount);

            // alert(obj.interest_amount);
        });
    });

    JQ(document).on("click", "#remove_topic", function () {
        JQ('.remove_anudan_details_topic').last().remove();

    });

    JQ(document).on("click", "#add_topic", function () {
        var num = JQ(".remove_anudan_details_topic").length;
        var counter = num + 2;
        //           alert(counter);return false;
        var param = {};
        param.counter = counter;
        JQ.post('get_anudan_details_topic.php', param, function (res) {
            var obj = JSON.parse(res);
            //alert(obj.html);
            JQ("#detail_add_table_topic").append(obj.html);
            //JQ('#interest_amount_'+id).val(obj.interest_amount);

            // alert(obj.interest_amount);
        });
        JQ('.select2').select2({
            multiple: true,
            placeholder: 'बजेट उपशिर्षक'
        });
    });

    JQ(document).on("click", "#remove", function () {
        JQ('.remove_anudan_details').last().remove();

    });
</script>

