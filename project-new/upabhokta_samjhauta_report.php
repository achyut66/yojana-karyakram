<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
// if(empty($_GET['ward_no']))
// {
// $sql ="select * from plan_details1 where type=0";
// //print_r($sql);
// }
// else
// {
// $sql ="select * from plan_details1 where type=0 and ward_no=".$_GET['ward_no'];
// }
//$sql ="select * from plan_details1 where type=0";
$upabhokta_result= Plantotalinvestment::find_all();
//print_r($upabhokta_result);
$plan_array=array();
foreach($upabhokta_result as $data1)
//echo "<pre>";
//print_r($data1);
{
    array_push($plan_array, $data1->plan_id);
}
$count0=count($plan_array);
$result=  Plandetails1::find_by_plan_id(implode(",", $plan_array));
?>
<?php
$final_array=$counted_result['final_count_array'];
?>
<?php include("menuincludes/header.php"); ?>
<title>
<?php echo "उपभोक्ता सम्झौता योजनाहरु !!!";?>
</title>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
        <div class="maincontent">
            <h2 class="headinguserprofile">उपभोक्ता समिति मार्फत सम्झौता भएका योजनाहरु | <a href="report.php" class="btn">पछि जानुहोस</a> |<a target="_blank" href="upabhokta_samjhauta_report_print.php" class="btn">Print</a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				     <div class="myPrint"></div><br>
                     <table class="table table-bordered table-responsive table-striped">
                           <tr>   
                                    <td class="myCenter"><strong>सि.न </strong></td>
                                    <td class="myCenter"><strong>दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको उपशिर्षकगत किसिम</strong></t>
                                    <td class="myCenter"><strong>योजनाको विनियोजन किसिम</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं </strong></td>
                                    <td class="myCenter"><strong>अनुदान रु </strong></td>
                                    <td class="myCenter"><strong>हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"><strong> कुल बाँकी रकम</strong></td>
                                </tr>
                                <?php $i=1; 
                                foreach ($result as $re):
                                    $baki = $re->investment_amount-$data1->bhuktani_anudan;
                               ?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($re->id);?></td>
                                    <td class="myCenter"><?php echo $re->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($re->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($re->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareatypesub::getName($re->topic_area_type_sub_id); ?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($re->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($re->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit(placeholder($re->investment_amount));?></td>
                                    <td class="myCenter"><?php echo convertedcit(placeholder($data1->bhuktani_anudan));?></td>
                                    <td class="myCenter"><?php echo convertedcit(placeholder($baki));?></td>
                                </tr>
                                <?php $amount_total += $re->investment_amount;
                                $total_bhuktani += $data1->bhuktani_anudan;
                                $total_baki += $baki;
                                $i++; endforeach;?>
                        <tr>
                               
                             <td colspan="8" style="text-right">जम्मा</td>
                             <td ><?php echo convertedcit(placeholder($amount_total)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_bhuktani)); ?></td>
                             <td colspan="2"><?php echo convertedcit(placeholder($total_baki)); ?></td>
                        </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>