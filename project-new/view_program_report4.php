<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
 $result=count_program_by_budget_remaining($_GET['ward_no']);
 $datas = $result['selected_id'];
 $data1=$result['total_expenditure_amount'];
 $data2=$result['total_rem_budget'];
?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
            <h2 class="headinguserprofile">खर्च भएको तर सम्पन्न नभएको कार्यक्रमको रिपोर्ट हेर्नुहोस | <a href="report.php" class="btn">पछि जानुहोस </a></h2>
            	
            <div class="myMessage"><?php echo $message;?></div>
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
                                $total_investment=0;
                                foreach($datas as $result):
                                    $data=  Plandetails1::find_by_id($result);
                                    if(!empty($budget))
                                     {
                                         $expenditure_amount =$budget->total_expenditure;
//                                         $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                     }
                                     else
                                     {
                                        $advance_total = Programpayment::get_total_payment_amount($result);
                                        $net_total_amount_total = Programpaymentfinal::get_net_total_amount_sum($result);
                                        $expenditure_amount = $advance_total + $net_total_amount_total;
                                     }   
                                    $rem_budget = $data->investment_amount - $expenditure_amount;
                                    ?>
                                <tr>
                                 <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                    <td class="myCenter"><?php echo $data->program_name;?></td>
                                    <td class="myCenter"><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td class="myCenter"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                    <td class="myCenter"><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->investment_amount);?></td>
                                     <td class="myCenter"><?php echo convertedcit($expenditure_amount);?></td>
                                      <td class="myCenter"><?php echo convertedcit($rem_budget);?></td>
                                    <td class="myCenter"><a href="program_total_view.php?id=<?=$result?>" class="btn">पुरा विवरण हेर्नुहोस</a></td>
                                </tr>
                       <?php
                       $i++;
                       $total_investment +=$data->investment_amount;
                       endforeach;?>
                                <tr>
                                    <td colspan="6">&nbsp; </td>     
                             <td>जम्मा </td>
                             <td ><?php echo convertedcit(placeholder($total_investment)); ?></td>
                             <td ><?php echo convertedcit(placeholder($data1)); ?></td>
                             <td ><?php echo convertedcit(placeholder($data2)); ?></td>
                         </tr>
                     </table>

                </div>
                  </div>
                </div><!-- main menu ends -->
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>