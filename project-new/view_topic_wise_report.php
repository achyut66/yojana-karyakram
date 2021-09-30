<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$user = getUser();
$counted_result=  getOnlyRegisteredPlans(0);
$final_array=$counted_result['final_count_array'];
$search_ward="";

if(isset($_GET['submit']))
{

    $type=$_GET['type'];
    $search_ward =$_GET['search_ward'];

    if(!empty($_GET['topic_area_id']) && !empty($_GET['topic_area_type_id']) && empty($search_ward))
    {
        $sql ="select * from plan_details1 where type=$type and  topic_area_id=".$_GET['topic_area_id']." and topic_area_type_id=".$_GET['topic_area_type_id'];

    }
    if(!empty($_GET['topic_area_id']) && !empty($_GET['topic_area_type_id']) && !empty($search_ward))
    {
        $sql ="select * from plan_details1 where type=$type and ward_no=$search_ward and topic_area_id=".$_GET['topic_area_id']." and topic_area_type_id=".$_GET['topic_area_type_id'];

    }
    if(!empty($_GET['topic_area_id']) && empty($_GET['topic_area_type_id']) && empty($search_ward))
    {
        $sql ="select * from plan_details1 where type=$type and  topic_area_id=".$_GET['topic_area_id'];

    }
    if(!empty($_GET['topic_area_id']) && empty($_GET['topic_area_type_id']) && !empty($search_ward))
    {
        $sql ="select * from plan_details1 where type=$type and ward_no=$search_ward and  topic_area_id=".$_GET['topic_area_id'];

    }

    $datas = Plandetails1::find_by_sql($sql);

}
//echo count($datas);exit;
$fiscals=  Fiscalyear::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area=  Topicarea::find_all();
$ward_result = Ward::find_max_ward_no();
?>
<?php include("menuincludes/header.php"); ?>

    <body>
<?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner">

        <div class="maincontent">
            <h2 class="headinguserprofile">योजना विवरण हेर्नुहोस | <a href="view_plan_dashboard.php" class="btn">पछि जानुहोस</a></h2>
            <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <div class="ourHeader">योजना हेर्नुहोस </div>

                    <form method="get" >
                        <div class="inputWrap100 ">
                            <div class="inputWrap33 inputWrapLeft">
                                <div class="titleInput">किसिम छान्नुहोस्</div>
                                <div class="newInput">  <select name="type" required >
                                        <option value="" >--छान्नुहोस्--</option>
                                        <option value="0"  >योजना</option>
                                        <option value="1" >कार्यक्रम</option>
                                    </select>
                                </div>


                                <div class="titleInput"> योजनाको बिषयगत क्षेत्रको किसिम:
                                </div>
                                <div class="newInput"><select name="topic_area_id" id="topic_area_id"  >
                                        <option value="">--छान्नुहोस्--</option>
                                        <?php foreach($topic_area as $topic): ?>
                                            <option value="<?php echo $topic->id?>" <?php if($topic->id==$topic_area_investment_id){?> selected="selected"<?php } ?>><?php echo $topic->name;  ?></option>
                                        <?php endforeach; ?>
                                    </select></div>
                            </div>
                            <div class="inputWrap33 inputWrapLeft">
                                <div id="topic_area_type_id"></div>           </td>
                                <div class="titleInput">वार्ड नं :</div>
                                <div class="newInput">
                                    <select name="search_ward" >
                                        <option value="">--छान्नुहोस्--</option>
                                        <?php for($i=1;$i<=$ward_result;$i++): ?>
                                            <option value="<?php echo $i?>"><?php echo convertedcit($i);  ?></option>
                                        <?php endfor; ?>
                                    </select></div>
                                <div class="saveBtn myWidth100"><input type="submit" name="submit" value="खोज्नुहोस" class="btn-success"></div>
                                <div class="saveBtn myWidth100"><a href="view_topic_wise_report.php"><input type="button" value="रद्द गर्नुहोस" class="btn-danger"></a></div>
                            </div>  </div>
                    </form>

                    <?php if($user->mode=="section" || $user->mode=="superadmin" || $user->mode=="administrator"):?>
                        <td><div class="saveBtn myWidth100">
                            <a href="print_view_all_plans.php?type=<?=$_GET['type']?>&topic_area_investment_id=<?=$_GET['topic_area_investment_id']?>&search_text=<?=$_GET['search_text']?>&ward=<?=$_GET['search_ward']?>&topic_area_id=<?=$_GET['topic_area_id']?>&topic_area_type_id=<?=$_GET['topic_area_type_id']?>" target="_blank">
                                <input type="button" class="buutton btn-primary" value="प्रिन्ट गर्नुहोस">
                            </a></div>
                        </td><?php endif;?>
                    <?php if(isset($_GET['submit'])):?>
                        <table class="table table-bordered table-hover">
                            <tr>

                                <th class="myCenter">सि नं </th>
                                <th class="myCenter">दर्ता नं</th>
                                <th class="myCenter">योजना / कार्यक्रमको नाम</th>
                                <th class="myCenter">बिषयगत क्षेत्रको किसिम</th>
                                <th class="myCenter">अनुदानको किसिम</th>
                                <th class="myCenter">विनियोजन किसिम</th>
                                <th class="myCenter">वार्ड नं</th>
                                <th class="myCenter">अनुदान रकम (रु.)</th>
                                <th class="myCenter">खर्च रकम</th>
                                <th class="myCenter">बाँकि रकम</th>
                                <th class="myCenter">विवरण हेर्नुहोस</th>
                            </tr>
                            <?php
                            $total_net_payable=0;
                            $total_remaining=0;
                            $i=1;
                            foreach($datas as $data):


                                if($data->type==0)
                                {
                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                    if(!empty($budget))
                                    {
                                        $net_payable_amount =$budget->total_expenditure;
                                        $remaining_amount= $data->investment_amount - $net_payable_amount;
                                    }
                                    else{
                                        $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                        if(empty($contract_result))
                                        {
                                            if(in_array($data->id, $final_array))
                                            {
                                                $net_payable_amount=get_upobhokta_net_kharcha_amount($data->id);
                                                $remaining_amount=$data->investment_amount - $net_payable_amount;
                                            }
                                            else
                                            {

                                                $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                                //                                             echo $net_payable_amount;exit;
                                                $remaining_amount= $data->investment_amount - $net_payable_amount;
                                            }
                                        }
                                        else
                                        {
                                            if(in_array($data->id, $final_array))
                                            {
                                                $net_payable_amount=get_contract_net_kharcha_amount($data->id);

                                                $remaining_amount=$data->investment_amount - $net_payable_amount;
                                            }
                                            else
                                            {

                                                $net_payable_amount=  Contractamountwithdrawdetails::get_payement_till_now($data->id);
                                                $remaining_amount=$data->investment_amount - $net_payable_amount;
                                            }

                                        }
                                    }
                                }
                                else
                                {
                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                    if(!empty($budget))
                                    {
                                        $net_payable_amount =$budget->total_expenditure;
                                        $remaining_amount= $data->investment_amount - $net_payable_amount;
                                    }
                                    else
                                    {
                                        $program_result=Programpaymentfinal::find_by_program_id1($data->id);
                                        $advance_total = Programpayment::get_total_payment_amount($data->id);
                                        $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($data->id);
                                        $net_payable_amount = $advance_total + $net_total_amount_total;
                                        if(empty($net_payable_amount))
                                        {
                                            $remaining_amount=$data->investment_amount;
                                        }
                                        else
                                        {
                                            $remaining_amount=($data->investment_amount)-($net_payable_amount);

                                        }
                                    }

                                }
                                $samiti_plan_total=Samitiplantotalinvestment::find_by_plan_id($data->id);
                                $contract_plan_total= Contractinfo::find_by_plan_id($data->id);
                                $amanat_lagat = AmanatLagat::find_by_plan_id($data->id);
                                if($data->type==1)
                                {
                                    $link = "program_total_view.php?id=".$data->id;
                                }
                                elseif($data->type==0 && !empty($samiti_plan_total))
                                {
                                    $link="view_samiti_plan_form.php?id=".$data->id;
                                }
                                elseif($data->type==0 && !empty($contract_plan_total))
                                {
                                    $link="view_all_contract.php?id=".$data->id;
                                }
                                elseif($data->type==0 && !empty($amanat_lagat))
                                {
                                    $link= "view_all_amanat.php?id=".$data->id;
                                }
                                else
                                {
                                    $link="view_plan_form.php?id=".$data->id;
                                }
                                ?>
                                <tr>
                                    <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td style="width:10%"><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                                    <td><?php echo convertedcit(placeholder($net_payable_amount));?></td>
                                    <td><?php echo convertedcit(placeholder($remaining_amount));?></td>
                                    <td><a href="<?php echo $link; ?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                                <?php $i++;
                                $total_net_payable +=$net_payable_amount;
                                $total_remaining +=$remaining_amount;
                            endforeach;?>
                            <?php
                            $total=0;
                            foreach($datas as $data):
                                $total+=$data->investment_amount;

                            endforeach;?>
                            <tr>
                                <td colspan="7" class="text-center">जम्मा रकम </td>

                                <td>रु.<?php echo convertedcit(placeholder($total));?></td>
                                <td>रु.<?php echo convertedcit(placeholder($total_net_payable));?></td>
                                <td>रु.<?php echo convertedcit(placeholder($total_remaining));?></td>

                            </tr>
                        </table>
                    <?php endif;?>




                </div>
            </div>
        </div><!-- main menu ends -->

    </div><!-- top wrap ends -->
<?php include("menuincludes/footer.php"); ?>