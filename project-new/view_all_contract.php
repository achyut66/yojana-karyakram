<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
//$sql="select * from plan_details1 where sn='".$_POST['name']."' limit 1";
$result= Plandetails1::find_by_id($_GET['id']);

?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
<div class="">
    <div class="">
        <div class="maincontent">
            <h2 class="headinguserprofile"><a href="view_all_plans.php">योजना विवरणमा जानुहोस</a></h2>
            <h2 class="headinguserprofile">तपाई आहिले <?php echo $result->program_name;?>को  विवरण  हेर्दै हुनुहुन्छ </h2>
            
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
                    <?php $data1=  Plandetails1::find_by_id($_GET['id']);?>
                     <?php $data=  Plandetails1::find_by_id($_GET['id']);
                            $fiscal = FiscalYear::find_by_id($data->fiscal_id);
                            
                        ?>
                      
                     <h3 class="myheader"> योजनाको अनुदान विवरण </h3>
                    <div class="mycontent"  >
                     <table class="table table-bordered" >
                                        
                                        <tr>
                                            <td class="myWidth50">आर्थिक बर्ष :</td>
                                            <td><?php echo convertedcit($fiscal->year); ?></td>
                                        </tr> <tr>
                                            <td>दर्ता नं :</td>
                                            <td><?php echo convertedcit($data->id);?></td>
                                          </tr>
                                          <tr>
                                            <td>योजनाको नाम :</td>
                                            <td><?php echo $data->program_name;?></td>
                                          </tr>
                                          <tr>
                                            <td> संचालन  हुने स्थान :</td>
                                            <td><?php echo SITE_NAME.convertedcit($data->ward_no); ?></td>
                                            
                                           </tr>
                                         <tr>
                                                <td>बिषयगत क्षेत्रको किसिम :</td>
                                                <td><?php echo Topicarea::getName($data->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>शिर्षकगत किसिम :</td>
                                               <td><?php echo Topicareatype::getName($data->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>योजनाको  उपशिर्षकगत किसिम :</td>
                                               <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                           <tr>
                                               <td>योजनाको अनुदानको किसिम :</td>
                                               <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></td>
                                          </tr> 
                                          <tr>
                                               <td>योजनाको विनियोजन किसिम :</td>
                                               <td><?php echo Topicareainvestment::getName($data->topic_area_agreement_id); ?></td>
                                          </tr>
                                          <tr>
                                            <td> अनुदान रकम :</td>
                                            <td>रु. <?php echo convertedcit(placeholder($data->investment_amount));?></td>
                                           </tr>
                       </table>
                     </div>
                 
                    <?php   
                            $data=  Contract_total_investment::find_by_plan_id($data->id);
                            $details=  Contractordetails::find_by_id($data->contractor_id);
                    ?>
                     <?php if(empty($data)){?><h3 class="myheader"> ठेक्काको कुल लागत अनुमान थप विवरण भरिएको छैन  </h3><?php }else{?>
                       <h3  class="myheader"> ठेक्काको कुल लागत अनुमान 
                       <form method="get" action="thekka_kul_lagat_delete.php">
                           <button class="button btn-danger" name="plan_id" value="<?php echo $_GET['id']?>">विवरण हटाउनुहोस</button>
                       </form>
                       </h3>
                        <div class="mycontent" >
                          <table class="table table-bordered">
                            <?php 
                              
                                $unit = Units::find_by_id($data->unit_id);
                            ?>
                             <tr>
                                <td class="myWidth50"> भौतिक ईकाईको  परिणाम :</td>
                                <td><?=convertedcit($data->unit_total)?> <?=$unit->name?></td>
                              <tr>
                              <td><?php echo SITE_TYPE;?>बाट अनुदान रकम :</td>
                              <td>रु. <?php echo convertedcit(placeholder($data->agreement_gaupalika));?></td>
                            </tr>
                            <tr>
                              <td>कुल ठेक्का रकम जम्मा :</td>
                              <td>रु. <?php echo convertedcit(placeholder($data->total_investment));?></td>
                            </tr>
                            <tr>
                              <td>ठेक्का कबोल गरेको कुल रकम :</td>
                              <td>रु. <?php echo convertedcit(placeholder($data->contract_total_amount));?></td>
                            </tr>
                            <tr>
                              <td>कार्यदेश दिएको  रकम:</td>
                              <td>रु. <?php echo convertedcit(placeholder($data->bhuktani_anudan));?></td>
                            </tr>
                            <tr>
                              <td>योजना संचालन गर्ने फर्म/कम्पनी :</td>
                              <td><?php echo $details->contractor_name;?></td>
                            </tr>
                            
                           
                          </table>
                        </div>
                     <?php } ?>
                          <?php $data= Contractmoredetails::find_by_plan_id($_GET['id']); ?>
                            <?php if(empty($data)){?><h3  class="myheader">ठेक्का संचालन विवरण   </h3><?php }else{?>
                         <h3 class="myheader">ठेक्का संचालन विवरण
                         </h3>
                          <div class="mycontent" >
                          <table class="table table-bordered">
                              
                              <tr>
                                    <td class="myWidth50">योजनाको विनियोजित बजेट रु :</td>
                                    <td ><?php echo convertedcit(placeholder($data->budget));?></td>
                                  </tr>
                                  <tr>
                                    <td>कार्यादेश दिने निर्णय भएको मिति:</td>
                                    <td><?php echo convertedcit($data->work_order_date);?></td>
                                  </tr>
                                  <tr>
                                    <td>कार्यादेश दिईएको रकम रु:</td>
                                    <td><?php echo convertedcit(placeholder($data->work_order_budget));?></td>
                                  </tr>
                                   <tr>
                                    <td>योजनाको शुरु हुने मिति:</td>
                                    <td><?php echo convertedcit($data->start_date);?></td>
                                  </tr>
                                  <tr>
                                    <td>योजना सम्पन्न हुने मिति :</td>
                                    <td><?php echo convertedcit($data->completion_date);?></td>
                                  </tr>
                                  <tr>
                                    <td>योजना संचालन हुने स्थान:</td>
                                    <td><?php echo  $data->venue;?></td>
                                  </tr>
                                 
                           </table>
                           </div>
                          
                          <h3 class="myheader"> योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण</h3>
                            <div class="mycontent" >
                          <table class="table table-bordered">
                            <tr>
                                 
                                  <td colspan="5" style="text-align:center">लाभान्वित जनसंख्या</td>
                                </tr>
                                <tr>
                                	
                                        <td>घर परिवार संख्या</td>
                                      <td>महिला</td>
                                      <td >पुरुष</td>
                                      <td >जम्मा</td>
                                    </tr>
                                   
                                 <tr>

                                      <td><?php echo convertedcit($data->total_family_members );?></td>
                                     <td ><?php echo convertedcit($data->female);?></td>
                                      <td><?php echo convertedcit($data->male);?></td>
                                      <td><?php echo convertedcit(placeholder($data-> total_members));?></td>
                                  </tr>
                          </table>
                             </div>
                            <?php } ?>
                           <?php $data = Contractstartingfund::find_by_plan_id($_GET['id']);
                                                                  //print_r($data);exit;
                               ?>
                          <?php if(empty($data)){?><h3  class="myheader">पेश्की भुक्तानी विवरण भरिएको छैन </h3><?php }else{?>
                            <h3 class="myheader">पेश्की भुक्तानी विवरण </h3>
                          <div class="mycontent" >
                            
                             <table class="table table-bordered">
                                     <tr>
                                    <td class="myWidth50" >पेश्की  रकम</td>
                                    <td ><?php echo convertedcit(placeholder($data->advance));?></td>
                                  </tr>
                                  <tr>
                                    <td>पेश्की दिएको मिती</td>
                                    <td><?php echo convertedcit($data->advance_taken_date);?></td>
                                  </tr>
                                 <tr>
                                    <td>पेश्की फर्छ्यौट गर्नु पर्ने मिति</td>
                                    <td><?php echo convertedcit($data->advance_return_date);?></td>
                                  </tr>
                                  <tr>
                                    <td>पेश्की दिनु पर्ने कारण</td>
                                    <td><?php echo $data->advance_reason;?></td>
                                  </tr>
                                  
                                </table>
                          
                          </div>
                          <?php }?>  
                                
                                 <?php
                                   $inst_count = Contractanalysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
                                 if(empty($inst_count)){?><h3  class="myheader"> मुल्यांकन को आधारमा भुक्तानी  विवरण भरिएको छैन </h3><?php }else{?>
                               <h3 class="myheader">मुल्यांकन को आधारमा भुक्तानी विवरण</h3>
                               <div class="mycontent" >
                                   <?php
                                   $inst_array = array(
                                    1=>"पहिलो",
                                    2=>"दोस्रो",
                                    3=>"तेस्रो",
                                    4=>"चौथो",
                                    5=>"पाचौ",
                                    6=>"छैठो",
                                );
                                 $inst_count = Contractanalysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
                                 for($i=1; $i<=$inst_count; $i++)
                                 {
                                        $inst_data = Contractanalysisbasedwithdraw::find_by_payment_count($i,$_GET['id']);
                                
                                        ?>
                            <table class="table table-bordered">
                               <tr>
                                            <td class="myWidth50">योजनाको मुल्यांकन किसिम</td>
                                            <td><?php echo $inst_array[$i]; ?></td>
                                        </tr>
                                        <tr>
                                <td >योजनाको मुल्यांकन  मिती</td>
                                <td ><?php echo convertedcit($inst_data->evaluated_date); ?></td>
                              </tr>
                               <tr>
                                <td >योजनाको मुल्यांकन  रकम</td>
                                <td ><?php echo convertedcit(placeholder($inst_data->evaluated_amount)); ?></td>
                              </tr>

                              <tr>
                                <td >भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td ><?php echo convertedcit(placeholder($inst_data->payable_amount)); ?></td>
                              </tr>
                            </table>
                            <table class="table table-bordered">
                              <tr>
                                <th>पेश्की भुक्तानी लगेको कट्टी रकम</th>
                                <th>मर्मत सम्हार कोष कट्टी रकम</th>
                                <th>धरौटी कट्टी रकम</th>
                                <th>विपद व्यबसथापन कोष कट्टी रकम</th>
                               </tr>
                               <tr>
                                <td><?php echo convertedcit($inst_data->advance_payment); ?></td>
                               <td><?php echo convertedcit($inst_data->renovate_amount); ?></td>
                                <td><?php echo convertedcit($inst_data->due_amount); ?></td>
                                <td><?php echo convertedcit($inst_data->disaster_management_amount); ?></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><?php echo convertedcit(placeholder($inst_data->total_amount_deducted)); ?></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><?php echo convertedcit(placeholder($inst_data->total_paid_amount)); ?></td>
                              </tr>
                       </table>
                                 <?php  
                                 }
                                 } ?>
                               </div> 
                      
                               
                               <?php 
                                $data_selected_final = Contractamountwithdrawdetails::find_by_plan_id($_GET['id']); 
                                ?>
                                <?php if(empty($data_selected_public)& empty($data_selected_final)){?><h3 class="myheader">अन्तिम भुक्तानीको विवरण भरिएको छैन </h3><?php }else{?>
                            <h3 class="myheader" >अन्तिम भुक्तानी विवरण</h3 >
                           <div class="mycontent">
                               <table class="table table-bordered">
                             <tr>
                                <td>योजना सम्पन्न हुने मिति :</td>
                                <td><?=convertedcit($data_selected_final->yojana_sakine_date)?></td>
                              </tr>
                             <tr>
                                <td>योजनाको काम सम्पन्न भएको मिति :</td>
                                <td><?=convertedcit($data_selected_final->plan_end_date)?></td>
                              </tr>
                              
                              <tr>
                                <td>योजनाको मुल्यांकन मिति :</td>
                                <td><?=convertedcit($data_selected_final->plan_evaluated_date)?></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->plan_evaluated_amount))?></td>
                              </tr>
                               <tr>
                                <td> भुक्तानी दिनु पर्ने कुल  रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->final_payable_amount))?></td>
                              </tr>
                               <tr>
                                <td> मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->payment_till_now))?></td>
                              </tr>
                              <tr>
                                <td>पेश्की भुक्तानी लगेको कट्टी रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->advance_payment))?></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी दिनु पर्ने कुल बाँकी  रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->remaining_payment_amount))?></td>
                              </tr>
                              <tr>
                                <td>मर्मत सम्हार कोष कट्टी रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->final_renovate_amount))?></td>
                              </tr>
                              <tr>
                                <td>धरौटी कट्टी रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->final_due_amount))?></td>
                              </tr> 
                              <tr>
                                <td>विपद व्यबसथापन कोष कट्टी रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->final_disaster_management_amount))?></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->final_total_amount_deducted))?></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी लगिएको खुद रकम :</td>
                                <td>रु. <?=convertedcit(placeholder($data_selected_final->final_total_paid_amount))?></td>
                              </tr>  
                 </table>
                               </div>   
                                <?php }?>
<!--                            <h3>के तपाई फोटो हेर्न चाहनुहुन्छ ...!!!?<a href="photo_view.php?id=<?php // echo $_GET['id'];?>"><span style="color:red;">हेर्नुहोस</span> </a></h3>-->

                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>