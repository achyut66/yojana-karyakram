<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$mode=getUserMode();
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
?>
<?php include("menuincludes/header.php"); ?>
<?php
    $result=  Plandetails1::find_all();
    $result1=Plantotalinvestment::find_all();
    $plan_id_array1=array();
    $plan_id_array2=array();
    foreach($result as $data)
    {
        array_push($plan_id_array1,$data->id);
    }
    foreach($result1 as $data)
    {
        array_push($plan_id_array2,$data->plan_id);
    }
    $result_array1=  array_unique($plan_id_array2);
    $result_array=array_diff($plan_id_array1,$result_array1);
    $final_array1=array_unique($result_array);
    $count1=count($final_array1);
    $total_investment1=Plandetails1::get_total_investment_by_plan_ids(implode(",", $final_array1));
    ?>
<?php
$datas0= Plandetails1::find_all();
$datas=$result = Moreplandetails::find_all();
$datas1 = Planamountwithdrawdetails::find_all();
$plan_id_arrays0=array();
$plan_id_arrays1=array();
$plan_id_arrays2=array();
foreach($datas0 as $data)
    {
        array_push($plan_id_arrays0,$data->id);
    }
foreach($datas as $data)
{
    array_push($plan_id_arrays1,$data->plan_id);
}
//echo count(array_unique($plan_id_arrays1));exit;
foreach($datas1 as $data)
{
    array_push($plan_id_arrays2,$data->plan_id);
}
//echo count(array_unique($plan_id_arrays2));exit;
 $result_arrays=array_diff($plan_id_arrays0,$plan_id_arrays2);
 $result_arrays1=array_diff($result_arrays,$final_array1);
 $final_array2=  array_unique($result_arrays1);
$count2=count($final_array2);
$total_investment2=Plandetails1::get_total_investment_by_plan_ids(implode(",", $final_array2));
$result=  Plandetails1::find_by_plan_id(implode(",",$final_array2));
?>
<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">अन्तिम भुक्तानी लिन बाकि योजनाको रिपोर्ट हेर्नुहोस  | <a href="report.php" class="btn">पछि जानुहोस </a></h2>
            	
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  
                     <table class="table table-bordered table-hover">
                           <tr>   
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>दर्ता नं</strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>योजनाको बिषयगत क्षेत्रको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको शिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको उपशिर्षकगत किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको विनियोजन किसिम</strong></td>
                                    <td class="myCenter"><strong>वार्ड नं</strong></td>
                                    <td class="myCenter"><strong>अनुदान रु</strong></td>
                                    <td class="myCenter"><strong>हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"><strong>कुल बाँकी रकम</strong></td>
                                    <td class="myCenter"><strong>विवरण हेर्नुहोस </strong></td>
                                </tr>
                                <?php $i=1; 
                                  $total_net_payable_amount="";
                                $total_remaining_amount="";
                                foreach($result as $data):
                                     $net_payable_amount=Planamountwithdrawdetails::get_payement_till_now($data->id);
                                $remaining_amount=$data->investment_amount - $net_payable_amount;?>
                                <tr>
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit($net_payable_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit($remaining_amount);?></td>
                                    <td class="myCenter"><a href="view_plan_form.php?id=<?=$data->id?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php $i++; 
                         $total_net_payable_amount +=$net_payable_amount;
                         $total_remaining_amount +=$remaining_amount;
                         endforeach;?>
                                <tr>
                                    <td colspan="7">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total_investment2));?></td>
                           <td ><?php echo convertedcit(placeholder($total_net_payable_amount)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_remaining_amount)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>