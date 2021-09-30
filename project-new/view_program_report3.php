<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
error_reporting(1);
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">अन्तिम भुक्तानी  लागेको आथवा सम्पन्न भएका कार्यक्रमको रिपोर्ट हेर्नुहोस | <a href="report.php" class="btn">पछि जानुहोस </a></h2>
            <div class="myMessage"><?php echo $message;?></div>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  
                       <table class="table table-bordered table-hover">
                           <tr>   
                           	
                                    <td class="myCenter">सि.नं.</td>
                                    <td class="myCenter">दर्ता नं</td>
                                    <td class="myCenter">कार्यक्रमको नाम</td>
                                    <td class="myCenter">कार्यक्रमको  बिषयगत क्षेत्रको किसिम</td>
                                    <td class="myCenter">कार्यक्रमको शिर्षकगत किसिम:</td>
                                    <td class="myCenter">कार्यक्रमको  विनियोजन किसिम:</td>
                                    <td class="myCenter">वार्ड नं :</td>
                                    <td class="myCenter">अनुदान रु :</td>
                                    <td class="myCenter">हाल सम्मको खर्च</td>
                                    <td class="myCenter">बाँकी रकम</td>
                                    <td class="myCenter">अन्तिम भुक्तानी लगीएको मिति </td>
                                    <td class="myCenter">विवरण हेर्नुहोस </td>
                                </tr>
                                <?php
                                $i=1;
                                $result = get_final_payed_program($_GET['ward_no']);
                                if(!empty($result))
                                {
                                    $final_result=  Programpaymentfinal::find_by_plan_array(implode(",",$result));
                                }
                                else
                                {
                                    $final_result= "";
                                }
                                
//                                 print_r($final_result);exit;
                                $total_budget=0;
                                $remaining_budget=0;
                                $remaining_net_payment=0;
                                foreach($final_result as $data1):
                                    $budget=  Ekmustabudget::find_by_plan_id($data1->program_id);
                                       $data = Plandetails1::find_by_id($data1->program_id);
                                    
                                 if(!empty($budget))
                                     {
                                         $net_payable_amount =$budget->total_expenditure;
                                         $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                     }
                                     else
                                     {
                                                $max_id=Programmoredetails::getMaxInsallmentByPlanId($data->id);
                                                
                                            if(empty($max_id))
                                            {
                                                $remaining_amount=$data->investment_amount;
                                                $net_payable_amount=0;
                                            }
                                            else
                                                {
                                                        $program_result = Programmoredetails::find_by_program_id_and_sn($data->id,$max_id);
                                                       $remaining_amount = $program_result->budget-$program_result->remaining_budget;
                                                       $net_payable_amount = $data->investment_amount - $remaining_amount ;
                                                }
                                     }
                                    if($net_payable_amount!=0)
                                    {
                                        continue;
                                    }
                                    ?>
                                
                                <tr>
                                     <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                     <td class="myCenter"><?php echo convertedcit($remaining_amount);?></td>
                                      <td class="myCenter"><?php echo convertedcit($net_payable_amount);?></td>
                                       <td class="myCenter"><?php echo convertedcit($data1->paid_date);?></td>
                                    <td class="myCenter"><a href="program_total_view.php?id=<?=$data->id?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                         <?php 
                         $i++;
                         $total_budget +=$data->investment_amount;
                        $remaining_budget +=$remaining_amount;
                        $remaining_net_payment +=$net_payable_amount;
                           
                            endforeach;?>
                                <tr>
                                    <td colspan="6">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total_budget)); ?></td>
                            <td ><?php echo convertedcit(placeholder($remaining_budget)); ?></td>
                             <td ><?php echo convertedcit(placeholder($remaining_net_payment)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>