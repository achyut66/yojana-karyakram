<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
  $program_result4 = Programpaymentfinal::find_all();
    $program_id_array4=array();
    foreach($program_result4 as $data)
    {
         array_push($program_id_array4,$data->program_id);
    }
    $program_result_array3 =  array_unique($program_id_array4);
     $program_count3 = count($program_result_array3);
    $porgram_total_investment3 = Plandetails1::get_total_investment_by_plan_ids(implode(",", $program_result_array3));
      $result=  Plandetails1::find_by_plan_id(implode(",", $program_result_array3));
?>

<?php include("menuincludes/header.php"); ?>

<body>
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
				  <h3>अन्तिम भुक्तानी  लागेको आथवा सम्पन्न भएका कार्यक्रमको रिपोर्ट हेर्नुहोस </h3>
                     <table class="table table-bordered table-responsive">
                           <tr>   
                                    <th>सि.न </th>
                                    <th >दर्ता नं</th>
                                    <th>कार्यक्रमको नाम</th>
                                    <th>कार्यक्रमको  बिषयगत क्षेत्रको किसिम</th>
                                    <th>कार्यक्रमको शिर्षकगत किसिम:</th>
                                    <th>कार्यक्रमको  विनियोजन किसिम:</th>
                                    <th>वार्ड नं :</th>
                                    <th>अनुदान रु :</th>
                                    <th>हाल सम्मको खर्च</th>
                                    <th>बाँकी रकम</th>
                                    <th>विवरण हेर्नुहोस </th>
                                </tr>
                                <?php
                                $i=1;
                                $total_budget="";
                                $remaining_budget="";
                                $remaining_net_payment="";
                                foreach($result as $data):
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
                                    
                                    if($net_payable_amount!=0)
                                    {
                                        continue;
                                    }
                                    ?>
                                
                                <tr>
                                     <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareatype::getName($data->topic_area_type_id);?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td><?php echo convertedcit($data->investment_amount);?></td>
                                     <td><?php echo convertedcit($remaining_amount);?></td>
                                      <td><?php echo convertedcit($net_payable_amount);?></td>
                                    <td><a href="program_total_view.php?id=<?=$data->id?>">पुरा विवरण हेर्नुहोस</a></td>
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
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>