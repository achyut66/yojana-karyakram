<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$datas = Plandetails1::find_all();
$fiscals=  Fiscalyear::find_all();
$topic_area_investment= Topicareainvestment::find_all();
$topic_area=  Topicarea::find_all();
$counted_result = getOnlyRegisteredPlans();
$final_array = $counted_result['final_count_array'];
$analysis_result = $counted_result['analysis_count_array'];
//echo count($analysis_result)."<br>";
$advance_result = $counted_result['advance_count_array'];
//echo count($advance_result)."<br>";
$more_details_result = $counted_result['more_detail_count_array'];
//echo count($more_details_result)."<br>";
$budget_rem_details = count_program_by_budget_remaining();
$program_result = $budget_rem_details['selected_id'];
//echo count($program_result)."<br>";
$total_array = array_merge($analysis_result,$advance_result,$more_details_result,$program_result);
$total_programs_array = array_unique($total_array);
asort($total_programs_array);
//echo count($total_programs_array);

?>
<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile">जिम्मेवारी सार्नुहोस / <a href="index.php">ड्यासबोर्डमा जानुहोस </a></h2>
            <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
				  <div class="ourHeader">जिम्मेवारी सार्नुहोस  </div>
                                 
            
                                  <form method="post" action="transfer_action.php">
                                      <input type="submit" name="submit" value="जिम्मेवारी सर्नुहोस" class="btn"/><br>
                     <table class="table table-bordered table-responsive">
                           <tr>   
                                    
                                    <th>दर्ता नं</th>
                                    <th>योजना / कार्यक्रमको नाम</th>
                                    <th>बिषयगत क्षेत्रको किसिम</th>
                                    <th>अनुदानको किसिम</th>
                                    <th>विनियोजन किसिम</th>
                                    <th>वार्ड नं</th>
                                    <th>अनुदान रकम (रु.)</th>
                                    <th>खर्च रकम</th>
                                    <th>बाँकि रकम</th>
                                    <th>छान्नुहोस</th>
                                </tr>
                                <?php 
                                 $total_net_payable=0;
                                 $total_remaining=0;
                                 $i=1;
                                 foreach($total_programs_array as $id):
                                     $data= Plandetails1::find_by_id($id);
                                                            
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
                                ?>
                                <tr>
                                    
                                    <td><?php echo convertedcit($data->id);?></td>
                                    <td><?php echo $data->program_name;?></td>
                                    <td><?php echo Topicarea::getName($data->topic_area_id) ;?></td>
                                    <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                    <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id);?></td>
                                    <td><?php echo convertedcit($data->ward_no);?></td>
                                    <td style="width:10%"><?php echo convertedcit(placeholder($data->investment_amount));?></td>
                                    <td><?php echo convertedcit(placeholder($net_payable_amount));?></td>
                                    <td><?php echo convertedcit(placeholder($remaining_amount));?></td>
                                    <td><input type="checkbox" name="selected_plan_id[]" value="<?=$data->id?>"/></td>
                                </tr>
                         <?php $i++;
                         endforeach;?>
                         ‍
                     </table>
                                  </form>
                    
                        


                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>