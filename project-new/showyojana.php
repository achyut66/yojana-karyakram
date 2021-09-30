<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}?>
<?php include("menuincludes/header.php"); ?>

<!--कुल योजना-->
<?php

$sql="select * from plan_details1 where type=0 or type=''";
$result1=  Plandetails1::find_by_sql($sql);
$result1_array=array();
foreach($result1 as $data)
{
    array_push($result1_array, $data->id);
}
//echo "<pre>";print_r($result1_array);echo "</pre>";exit;
$count0=count($result1);
$total_investment0 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $result1_array));
?>
<!--मुल्यांकनको आधारमा भुक्तानी लागेको योजना संख्या-->
<?php
$result10=Analysisbasedwithdraw::find_all();
//print_r($result10);exit;
$result10_array=array();
foreach($result10 as $data)
{
    array_push($result10_array, $data->plan_id);
}
$result_array10= array_unique($result10_array);
$count5 = count($result_array10);
//echo $count5;exit;
$total_investment5 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $result_array10));
?>
<!--दर्ता भई सम्झौता भएका योजना  -->
<?php
$result2=Moreplandetails::find_all();
$result2_array=array();
foreach($result2 as $data)
{
    array_push($result2_array, $data->plan_id);
}
$array_final=  array_unique($result2_array);
$count3=count($array_final);
$total_investment3 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $array_final));

?>
<!--सम्पन्न भएका योजना संख्या-->
<?php 
$data=  Publicinvestigationdetails::find_all();
$data1= Planamountwithdrawdetails::find_all();
$plan_id_array=array();
foreach($data1 as $data)
{
    array_push($plan_id_array, $data->plan_id);
}
$final_array=  array_unique($plan_id_array);
$count=count($final_array);
$total_investment = Plandetails1::get_total_investment_by_plan_ids(implode(",", $final_array));
?>
<!--दर्ता भएको तर कुनै विवरण नभरिएको योजना संख्या-->
    <?php
    $sql1="select * from plan_details1 where type=0";
    $result=  Plandetails1::find_by_sql($sql);
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
<!--अन्तिम भुक्तानी लिन बाकि योजना संख्या-->
<?php
 $sql2="select * from plan_details1 where type=0";
$datas0= Plandetails1::find_by_sql($sql2);
$datas= Moreplandetails::find_all();
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
 $result_arrays=array_diff($plan_id_arrays1,$plan_id_arrays2);
// $result_arrays1=array_diff($result_arrays,$final_array1);
 $final_array2=  array_unique($result_arrays);
$count2=count($final_array2);
$total_investment2=Plandetails1::get_total_investment_by_plan_ids(implode(",", $result_arrays));

?>
<!--पेश्की भुक्तानी लागेको योजना संख्या-->
<?php
$data5= Planstartingfund::find_all();

//print_r($data5);exit;
?>
<!--दर्ता भएको कार्यक्रम संख्या-->
<?php
$program_sql="select * from plan_details1 where type=1";
$program_result=  Plandetails1::find_by_sql($program_sql);
//echo count($program_result);exit;
$program_result_array=array();
foreach($program_result as $data)
{
    array_push($program_result_array, $data->id);
}
$program_count=count($program_result);
$program_total_investment = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_result_array));
?>
<!--दर्ता भएको तर कुनै विवरण नभरिएको कार्यक्रम संख्या-->
<?php
    $sql1="select * from plan_details1 where type=1";
    $program_result1=  Plandetails1::find_by_sql($sql1);
//    echo count($program_result1);exit;
    $program_result2 = Programmoredetails::find_all();
//    echo count($program_result2);exit;
//    print_r($program_result2);exit;
    $program_id_array1=array();
    $program_id_array2=array();
    foreach($program_result1 as $data)
    {
        array_push($program_id_array1,$data->id);
    }
    foreach($program_result2 as $data)
    {
         array_push($program_id_array2,$data->program_id);
    }
    $program_result_array1 =  array_unique($program_id_array2);
//    echo count($program_result_array1);exit;
    $program_result_array = array_diff($program_id_array1,$program_result_array1);
    $program_final_array = array_unique($program_result_array);
    $program_count1 = count($program_final_array);
    $porgram_total_investment1 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_final_array));
?>
<!--पेश्की भुक्तानी लागेको कार्यक्रम संख्या-->
<?php
    $program_result3 = Programpayment::find_all();
    $program_result3_1= Programpaymentfinal::find_all();
    $program_id_array3=array();
    $program_id_array3_1=array();
    foreach($program_result3 as $data)
    {
         array_push($program_id_array3,$data->program_id);
    }
    foreach($program_result3_1 as $data)
    {
         array_push($program_id_array3_1,$data->program_id);
    }
    $program_result_array2_1=  array_unique($program_id_array3_1);
//    print_r($program_result_array2_1);
    $program_result_array2 =  array_unique($program_id_array3);
    $result_program_array=  array_diff($program_result_array2, $program_result_array2_1);
     $program_count2 = count($result_program_array);
    $porgram_total_investment2 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $result_program_array));
?>
<!--अन्तिम भुक्तानी  लागेको कार्यक्रम संख्या-->
<?php
    $program_result4 = Programpaymentfinal::find_all();
    $program_id_array4=array();
    foreach($program_result4 as $data)
    {
         array_push($program_id_array4,$data->program_id);
    }
    $program_result_array3 =  array_unique($program_id_array4);
     $program_count3 = count($program_result_array3);
    $porgram_total_investment3 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_result_array3));
?>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">रिपोर्ट हेर्नुहोस </h2>
            <div class="OurContentLeft">
                  <?php include("menuincludes/settingsmenu.php");?>
            </div>	
                <?php echo $message;?>
            <div class="OurContentRight">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  <h3>रिपोर्ट हेर्नुहोस  </h3>
                                  <form method="post" onsubmit="form.submit()" action="showyojana.php">
                                      योजना / कार्यक्रम  खोज्नुहोस:
                                            <select name="type"  onchange="form.submit();">
                                                <option value="">-छान्नुहोस्-</option>
                                                <option value="0">योजना</option>
                                    		<option value="1">कार्यक्रम</option>
                                            </select>
                                      &nbsp;&nbsp;
                                      <input type="submit" class="submithere" name="submit" value="खोज्नुहोस"/>
                                      
                                  </form>
                                 
                                  <table class="table table-bordered">
                                      <tr>
                                            <th>योजना / कार्यक्रमको  रिपोर्ट </th>
                                            <th>जम्मा योजना / कार्यक्रम </th>
                                            <th>जम्मा अनुदान </th>
                                            <th>विवरण हेर्नुहोस </th>
                                      </tr>
                                      <?php if($_POST['type']==0):?>
                                       <tr>
                                          <td>कुल योजना </td>
                                        <td><?php echo convertedcit($count0); ?> </td>
                                        <td>रु. <?php  echo convertedcit(placeholder($total_investment0)); ?> </td>
                                        <td><a href="view_report0.php">थप विवरण</a></td>
                                      </tr>
                                      
                                      <tr>
                                          <td>दर्ता भई सम्झौता भएका योजना </td>
                                        <td><?php echo convertedcit($count3); ?> </td>
                                        <td>रु. <?php  echo convertedcit(placeholder($total_investment3)); ?> </td>
                                        <td><a href="view_report3.php">थप विवरण</a></td>
                                      </tr>
                                       <tr>
                                          <td>मुल्यांकनको आधारमा भुक्तानी लागेको योजना संख्या</td>
                                        <td><?php echo convertedcit($count5); ?> </td>
                                        <td>रु. <?php echo convertedcit(placeholder($total_investment5)); ?> </td>
                                        <td><a href="view_report5.php">थप विवरण</a></td>
                                       </tr>    
                                       <tr>
                                          <td>अन्तिम भुक्तानी लिन बाकि योजना संख्या</td>
                                        <td><?php echo convertedcit($count2); ?> </td>
                                        <td>रु. <?php echo convertedcit(placeholder($total_investment2)); ?> </td>
                                        <td><a href="view_report2.php">थप विवरण</a></td>
                                       </tr>
                                        <tr>
                                          <td>पेश्की भुक्तानी लागेको योजना संख्या</td>
                                        <td><?php echo convertedcit($count5); ?> </td>
                                        <td>रु. <?php echo convertedcit(placeholder($total_investment5)); ?> </td>
                                        <td><a href="view_report4.php">थप विवरण</a></td>
                                       </tr>
                                      <tr>
                                          <td>अन्तिम भुक्तानी  लागेको आथवा सम्पन्न भएका योजना संख्या</td>
                                        <td><?php echo convertedcit($count); ?> </td>
                                        <td>रु. <?php  echo convertedcit(placeholder($total_investment)); ?> </td>
                                        <td><a href="view_report.php">थप विवरण</a></td>
                                      </tr>
                                      
                                  <?php endif;?>
					
                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>