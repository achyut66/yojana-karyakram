<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
 if(empty($_GET['ward_no']))
{
    $sql1="select * from plan_details1 where type=1";

}
else
{
    $sql1="select * from plan_details1 where type=1 and ward_no=".$_GET['ward_no'];

}
    $program_result1=  Plandetails1::find_by_sql($sql1);
   
    if(empty($_GET['ward_no']))
    {
        $program_result2 = Programmoredetails::find_all();
    }
    else
    {
        $program_result2 = get_wardwise_result_sql_program($_GET['ward_no'],"program_more_details");
    }
//    $sql1="select * from plan_details1 where type=1";
    $program_result1=  Plandetails1::find_by_sql($sql1);
//    echo count($program_result1);exit;
//    $program_result2 = Programmoredetails::find_all();
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
//    print_r($program_result_array);exit;
    $program_final_array = array_unique($program_result_array);
//    $program_count1 = count($program_final_array);
    $porgram_total_investment1 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_final_array));
    $result=  Plandetails1::find_by_plan_id(implode(",", $program_final_array));
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">दर्ता भएको तर कुनै विवरण नभरिएको कार्यक्रमको रिपोर्ट हेर्नुहोस | <a href="report.php" class="btn">पछि जानुहोस</a></h2>
            	
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable"> 
                    
                     <table class="table table-bordered table-hover">
                           <tr>   
                                <td class="myCenter"><strong>सि.नं.</strong></td>
                                <td class="myCenter"><strong>दर्ता नं</strong></td>
                                <td class="myCenter"><strong>कार्यक्रमको नाम</strong></td>
                                <td class="myCenter"><strong>कार्यक्रमको  बिषयगत क्षेत्रको किसिम</strong></td>
                                <td class="myCenter"><strong>कार्यक्रमको शिर्षकगत किसिम</strong></td>
                                <td class="myCenter"><strong>कार्यक्रमको  विनियोजन किसिम</strong></td>
                                <td class="myCenter"><strong>वार्ड नं</strong></td>
                                <td class="myCenter"><strong>अनुदान रु</strong></td>
                                <td class="myCenter"><strong>हाल सम्मको खर्च</strong></td>
                                <td class="myCenter"><strong>बाँकी रकम</strong></td>
                                <td class="myCenter"><strong>विवरण हेर्नुहोस </strong></td>
                            </tr>
                                <?php 
                                $i=1;
                                foreach($result as $data):?>
                                <tr>
                                   <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                    <td class="myCenter"><?php echo convertedcit(0);?></td>
                                      <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                    <td class="myCenter"><a href="program_total_view.php?id=<?=$data->id?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php 
                           $i++;
                         endforeach;?>
                                <tr>
                                    <td colspan="6">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($porgram_total_investment1)); ?></td>
                              <td ><?php echo convertedcit(placeholder(0)); ?></td>
                             <td ><?php echo convertedcit(placeholder($porgram_total_investment1)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>