<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
$topic_area=  Topicarea::find_all();
$mode=getUserMode();
$counted_result = getOnlyRegisteredPlans($_GET['ward_no']);
if($mode!="administrator" && $mode!="superadmin")
{
    die("ACCESS DENIED");
}
?>
<?php include("menuincludes/header1.php"); ?>    

<?php
              $type=$_GET['type'];
              $fiscal_id= Fiscalyear::find_current_id();
             if($_GET['type']==1)
                     {
                        $name="कार्यक्रमको ";
                    }
                    else
                    {
                        $name="योजनाको ";
                    }
            // $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,0);
     ?>
                
                    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	
                <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1 letter_title_two"><?php echo SITE_HEADING;?> </h4>
                    <h5 class="marginright1 letter_title_three"><?php echo SITE_ADDRESS;?></h5>
                    <div class="myspacer"></div>
									
									<div class="printContent">
                     <div class="subjectboldright"><b><?php if(!empty($_GET['ward_no'])){ echo "वडा नं ". convertedcit($_GET['ward_no']). " को  ".$name." बिस्तृत रिपोर्ट हेर्नुहोस ";}else{ echo $name." बिस्तृत रिपोर्ट हेर्नुहोस ";};?></b></div>
                 <br><?php foreach($topic_area as $topic){
                      $topic_area_id= $topic->id;?>
                 <h5 class="myCenter"><b><?=$topic->name?></b></h5>
                  <table class="table table-bordered table-hovtoer"> 
                      <tr class="title_wrap">
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>दर्ता नं </strong></td>
                                    <td class="myCenter"><strong>योजनाको नाम</strong></td>
                                    <td class="myCenter"><strong>वडा नं</strong></td>
                                    <td class="myCenter"><strong>अनुदानको किसिम</strong></td>
                                    <td class="myCenter"><strong>योजनाको अनुदान रु</strong></td>
                                     <td class="myCenter"> <strong>भुक्तानी घटी रकम   </strong></td>
                                    <td class="myCenter"><strong>योजनाको हाल सम्म लागेको भुक्तानी</strong></td>
                                    <td class="myCenter"><strong>योजनाको कुल बाँकी रकम</strong></td>

                              </tr>

                       <?php 
                        $total_investment_array=array();
                         $total_net_payable_array=array();
                         $total_remaining_amount_array=array();
                          $ghati_amount_array = array();
                     $topic_area_type_ids = Plandetails1::find_distinct_topic_area_type_id($topic_area_id,$type,$_GET['ward_no']);
//                     if(empty($topic_area_type_ids))
//                     {
//                         continue;
//                     }
                     foreach($topic_area_type_ids as $topic_area_selected)
//                           echo $topic_area_selected;exit;
                                     { ?>
                              <tr>            
                                    <td colspan="9" class="myCenter" >
                                    <strong><?php echo Topicareatype::getName($topic_area_selected); ?></strong>
                                    
                                    </td>
                              </tr>
                                       <?php $topic_area_type_sub_ids = Plandetails1::find_distinct_topic_area_sub_id($topic_area_id, $topic_area_selected,$type,$_GET['ward_no']);  
                          if(empty($topic_area_type_sub_ids))
                     {
                         continue;
                     }
                         ?>
                               <?php foreach($topic_area_type_sub_ids as $topic_area_type_sub_id):
                                   if(empty($_GET['ward_no']))
                                   {
                                       $sql = "select * from plan_details1 where type=$type and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;  
                                   }
                                   else
                                   {
                                       $sql = "select * from plan_details1 where ward_no=".$_GET['ward_no']." and type=$type and topic_area_id=".$topic_area_id." 
                                                    and topic_area_type_id=".$topic_area_selected
                                         .          " and topic_area_type_sub_id=".$topic_area_type_sub_id
                                         .          " and fiscal_id=".$fiscal_id;  
                                   }
                                         
                                                $result =  Plandetails1::find_by_sql($sql);
                 if(empty($result))
                     {
                         continue;
                     }
                                                $total_amount=0;
                                                $total_remaining_amount=0;
                                                $total_investment_amount=0;
                                                
                                                ?>

                                <?php if(!empty($result)):  
                                             $final_array=$counted_result['final_count_array'];?>

                                                          <tr> <td colspan="9" class="myCenter"> <b><?php echo Topicareatypesub::getName($topic_area_type_sub_id);?></b></td></tr> 
                                                      <?php
                                                        $j=1;  
                                                        $total_investment=0;
                                                        $total_net_payable_amount=0;
                                                         $total_remaining_amount=0;
                                                         $net_total_investment=0;
                                                         $net_total_payable_amount=0;
                                                         $net_total_remaining_amount=0;
                                                         $total3=0;
                                                        foreach($result as $data)
                                                        { 
                                                             $final_amount_result= Planamountwithdrawdetails::find_by_plan_id($data->id);
                                                            
                                                            if(!empty($final_amount_result))
                                                            {
                                                                $ghati_amount = $final_amount_result->final_bhuktani_ghati_amount;
                                                            }
                                                            else
                                                            {
                                                                 $ghati_amount =0;
                                                            }
                                                            $contract_result= Contract_total_investment::find_by_plan_id($data->id);
                                                            
                                                         if($data->type==0)
                                                         {  
                                                                    $budget=  Ekmustabudget::find_by_plan_id($data->id);
                                                                    if(!empty($budget))
                                                                    {
                                                                        $net_payable_amount =$budget->total_expenditure;
                                                                        $remaining_amount= $data->investment_amount - $net_payable_amount; 
                                                                    }
                                                                    else{ 
                                                                             if(empty($contract_result))
                                                                                  {
                                                                                        $data->investment_amount = get_investment_amount($data->id);
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
                                                                        $program_more_details= Programmoredetails::find_single_by_program_id($data->id);
                                                                        $net_payable_amount= Programmoredetails::getSum($data->id);
                                                                        if(empty($amount))
                                                                        {
                                                                            $remaining_amount=$data->investment_amount;
                                                                        }
                                                                        else
                                                                        {
                                                                            $remaining_amount=($data->investment_amount)-($net_payable_amount);

                                                                        }
                                                                    }
                                                                
                                                         }
                                                                     $total_investment+=get_investment_amount($data->id);
                                                                        $total_net_payable_amount +=$net_payable_amount;
                                                                        $total_remaining_amount +=$remaining_amount;
                                                                        $total3+=$ghati_amount;
                                                            ?>

                                                                            <tr>

                                                                              <td class="myCenter"><?php echo convertedcit($j);?></td>
                                                                              <td class="myCenter"><?php echo convertedcit($data->id);?></td>
                                                                              <td class="myCenter"><?php echo $data->program_name; ?></td>
                                                                              <td class="myCenter"><?php echo convertedcit($data->ward_no);?></td>
                                                                              <td class="myCenter"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id);?></td>
                                                                              <td class="myCenter"><?php echo convertedcit(placeholder(get_investment_amount($data->id)));?></td>
                                                                              <td class="myCenter"><?=convertedcit(placeholder($ghati_amount))?></td>
                                                                              <td class="myCenter"><?php echo convertedcit(placeholder($net_payable_amount));?></td>
                                                                              <td class="myCenter"><?php echo convertedcit(placeholder($remaining_amount));?></td>

                                                                            </tr>

                                                                            <?php

                                                                        $j++ ; 
                                                                        
                                                        }
                                                                          
                                      endif;
                                                                      
                                                        ?>  

                                                                  <tr>
                                                                     <td colspan="5">जम्मा</td>
                                                                     <td><?= convertedcit(placeholder($total_investment)) ?></td>
                                                                     <td><?= convertedcit(placeholder($total3 )) ?></td>
                                                                     <td><?= convertedcit(placeholder($total_net_payable_amount )) ?></td>
                                                                     <td><?= convertedcit(placeholder($total_remaining_amount)) ?></td>
                                                                  </tr>                 
                              <?php 
                                              array_push($total_investment_array,$total_investment);
                                              array_push($total_net_payable_array,$total_net_payable_amount);
                                              array_push($total_remaining_amount_array,$total_remaining_amount);
                                              array_push($ghati_amount_array,$ghati_amount);
                              
                              endforeach;
                             
                              }
                              $add1=array_sum($total_investment_array);
                             $add2=array_sum($total_net_payable_array);
                             $add3=array_sum($total_remaining_amount_array);
                             $add4=array_sum($ghati_amount_array);
                           ?>
                                                              
                            <tr>
                                 <td colspan="5"><strong>कुल जम्मा</stong></td>
                                 <td><?= convertedcit(placeholder($add1)) ?></td>
                                 <td><?= convertedcit(placeholder($add4)) ?></td>
                                 <td><?= convertedcit(placeholder($add2)) ?></td>
                                 <td><?= convertedcit(placeholder($add3)) ?></td>
                              </tr> 
                  </table>


                        
                  <?php } ?>
                  </div>
                  </div>
                  </div>
                  </div>

