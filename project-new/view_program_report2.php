<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
 if(empty($_GET['ward_no']))
{
    $program_result3 = Programpayment::find_all();
    $program_result3_1= Programpaymentfinal::find_all();
    
}
else
{
    $program_result3 =  get_wardwise_result_sql_program($_GET['ward_no'],"program_payment");
    $program_result3_1= get_wardwise_result_sql_program($_GET['ward_no'],"program_payment_final");
    
}
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
    $program_result_array2 =  array_unique($program_id_array3);
    $result_program_array=  array_diff($program_result_array2, $program_result_array2_1);
    if(!empty($result_program_array))
    {
         $program_count2 = count($result_program_array);
        $porgram_total_investment2 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $result_program_array));
        $result=  Plandetails1::find_by_plan_id(implode(",", $result_program_array));
    }
    else
    {
        $program_count2 =0;
        $porgram_total_investment2 =0 ;
        $result ="";
        
    }
    
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">पेश्की भुक्तानी लागेको कार्यक्रमको रिपोर्ट हेर्नुहोस | <a href="report.php" class="btn">पछि जानुहोस</a></h2>
           
             <div class="myMessage">   <?php echo $message;?></div>
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
                                    <td class="myCenter"><strong>विवरण हेर्नुहोस</strong> </td>
                                </tr>
                                <?php
                                  $j=1;
                                $total_advance="";
                                $total_remaining_advance="";
                                foreach($result as $data):
                                    if(!empty($budget))
                                     {
                                         $advance_total =$budget->total_expenditure;
//                                         $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                     }
                                     else
                                     {
                                            $max_id=Programpayment::getMaxIds($data->id);
            //                                echo $max_id;exit;
                                            $advance_total="";
                                            for($i=0;$i<=$max_id;$i++)
                                            {
                                                $advance_result=Programpayment::find_by_program_id_and_sn($data->id,$i);

                                                $advance_total += $advance_result->payment_amount;
                                            }
                                     }     
//                                echo $advance_total;exit;
                                            $reamining_advance=$data->investment_amount - $advance_total;
                                            ?>
                                <tr>
                                <td class="myCenter"><?php echo convertedcit($j);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                     <td class="myCenter"><?php echo convertedcit($advance_total);?></td>
                                      <td class="myCenter"><?php echo convertedcit($reamining_advance);?></td>
                                    <td class="myCenter"><a href="program_total_view.php?id=<?=$data->id?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php 
                         $j++;
                         $total_advance +=$advance_total;
                         $total_remaining_advance += $reamining_advance;
                         endforeach;?>
                                <tr>
                                    <td colspan="6">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($porgram_total_investment2)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_advance)); ?></td>
                             <td ><?php echo convertedcit(placeholder($total_remaining_advance)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>