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
                                            <td>रु. <?php echo convertedcit($data->investment_amount);?></td>
                                           </tr>
                       </table>
                     </div>
                 
                     <?php   $data=Samitiplantotalinvestment::find_by_plan_id($data->id);?>
                     <?php if(empty($data)){?><h3 class="myheader">  योजनाको कुल लागत अनुमान थप विवरण भरिएको छैन  </h3><?php }else{?>
                       <h3  class="myheader"> योजनाको कुल लागत अनुमान 
                       <form method="get" action="samiti_kul_lagat_delete.php">
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
                              <td>रु. <?php echo convertedcit($data->agreement_gauplaika);?></td>
                            </tr>
                            <tr>
                              <td>अन्य निकायबाट प्राप्त अनुदान रकम :</td>
                              <td>रु. <?php echo convertedcit($data->agreement_other);?></td>
                            </tr>
                            <tr>
                              <td>संस्था / समितिबाट नगद साझेदारी रकम :</td>
                              <td>रु. <?php echo convertedcit($data->costumer_agreement);?></td>
                            </tr>
                            <tr>
                              <td>अन्य साझेदारी रकम :</td>
                              <td>रु. <?php echo convertedcit($data->other_agreement);?></td>
                            </tr>
                            <tr>
                              <td>संस्था / समितिबाट जनश्रमदान रकम  :</td>
                              <td>रु. <?php echo convertedcit($data->costumer_investment);?></td>
                            </tr>
                            <tr>
                              <td>कुल लागत अनुमान जम्मा रकम :</td>
                              <td>रु. <?php echo convertedcit($data->total_investment);?></td>
                            </tr>
                           
                          </table>
                        </div>
                     <?php } ?>
                       <?php $data2=Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);?>
                        <?php if(empty($data2)){?><h3  class="myheader">संस्था समिति  सम्बन्धी विवरण भरिएको छैन  </h3><?php }else{?>
                         <h3  class="myheader">संस्था समिति  सम्बन्धी विवरण  
                         <form method="get" action="samiti_upabhokta_delete.php">
                           <button class="button btn-danger" name="plan_id" value="<?php echo $_GET['id']?>">विवरण हटाउनुहोस</button>
                       </form>
                         </h3>
                        <div class="mycontent"  ><?php 
                                $data3=Samiticostumerassociationdetails::find_by_plan_id($_GET['id']);?>
                            <table class="table table-bordered">
                                
                                <tr><td class="myWidth50">योजनाको संचालन गर्ने संस्था / समितिको नाम:</td><td><?php echo $data2->program_organizer_group_name;?></td></tr>
                                <tr><td>ठेगाना:</td><td><?php echo SITE_NAME.convertedcit($data2->program_organizer_group_address);?></td></tr>
                            </table>
                            <table class=" table table-bordered">
                                <tr>
                                    <th>सिनं</th>
                                    <th>पद</th>
                                    <th>नामथर</th>
                                    <th>ठेगाना</th>
                                    <th>लिगं</th>
                                    <th>नागरिकता नं</th>
                                    <th>जारी जिल्ला</th>
                                    <th>मोवायल नं</th>
                                    
                                </tr>
                             <?php $i=1;foreach($data3 as $data):
                                 if($data->gender==1)
                                        {
                                            $gender = "पुरुष";
                                        }
                                        elseif ($data->gender==2) 
                                        {
                                            $gender = "महिला";
                                        }
                                        else
                                        {
                                            $gender = "अन्य";
                                        }
                                 
                                 ?>
                                <tr>
                                    <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo Postname::getName($data->post_id);?> </td>
                                    <td><?php echo $data->name;?></td>
                                    <td><?php echo SITE_NAME.convertedcit($data->address);?></td>
                                     <td><?php echo $gender;?> </td>
                                    <td><?php echo convertedcit($data->cit_no);?></td>
                                    <td><?php echo $data->issued_district;?></td>
                                    <td><?php echo convertedcit($data->mobile_no);?></td>
                                </tr>
                                <?php $i++; endforeach;?>
                            </table>
                        </div>
                        <?php } ?>
                         <?php $data4=  Samitiinvestigationassociationdetails::find_by_plan_id($_GET['id']);?>
                          <?php if(empty($data4)){?><h3  class="myheader"> अनुगमन समिति सम्बन्धी थप विवरण भरिएको छैन   </h3><?php }else{?>
                          <h3  class="myheader">अनुगमन समिति सम्बन्धी विवरण  
                          <form method="get" action="samiti_anugaman_delete.php">
                           <button class="button btn-danger" name="plan_id" value="<?php echo $_GET['id']?>">विवरण हटाउनुहोस</button>
                       </form>
                          </h3>
                        <div class="mycontent" >
                            <table class=" table table-bordered">
                                
                                <tr>
                                    <th>सिनं</th>
                                    <th>पद</th>
                                    <th>नामथर</th>
                                    <th>ठेगाना</th>
                                    <th>लिगं</th>
                                    <th>मोवायल नं</th>
                                    
                                </tr>
                         <?php $i=1;foreach($data4 as $data):
                             if($data->gender==1)
                                        {
                                            $gender = "पुरुष";
                                        }
                                        elseif ($data->gender==2) 
                                        {
                                            $gender = "महिला";
                                        }
                                        else
                                        {
                                            $gender = "अन्य";
                                        }
                             
                             ?>
                                <tr>
                                    <td><?php echo convertedcit($i);?></td>
                                    <td><?php echo Postname::getName($data->post_id);?></td>
                                    <td><?php echo $data->name;?></td>
                                    <td><?php echo SITE_NAME.convertedcit($data->address);?></td>
                                     <td><?php echo $gender;?> </td>
                                    <td><?php echo convertedcit($data->mobile_no);?></td>
                                 </tr>
                                 <?php  $i++; endforeach; ?>
                            </table>
                        </div>
                          <?php } ?>
                          <?php $data= Samitimoreplandetails::find_by_plan_id($_GET['id']); ?>
                            <?php if(empty($data)){?><h3  class="myheader">योजना सम्बन्धी अन्य विवरण भरिएको छैन  </h3><?php }else{?>
                         <h3 class="myheader">योजना सम्बन्धी अन्य विवरण 
                         <form method="get" action="samiti_more_details_delete.php">
                           <button class="button btn-danger" name="plan_id" value="<?php echo $_GET['id']?>">विवरण हटाउनुहोस</button>
                        </form>
                         </h3>
                          <div class="mycontent" >
                          <table class="table table-bordered">
                              
                             
                                  <tr>
                                    <td>योजना शुरु हुने मिति :</td>
                                    <td><?php echo convertedcit($data->yojana_start_date);?></td>
                                  </tr>
                                  <tr>
                                    <td>योजना सम्पन्न हुने मिति :</td>
                                    <td><?php echo convertedcit($data->yojana_sakine_date);?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम :</td>
                                    <td><?php echo  Workerdetails::getName($data->samjhauta_party);?></td>
                                  </tr>
                                  <tr>
                                    <td>पद :</td>
                                    <td><?php  echo  $data->post_id_3;?></td>
                                  </tr>
                                  <tr>
                                    <td>मिती :</td>
                                    <td><?php echo convertedcit($data->miti);?></td>
                                  </tr>
                           </table>
                           </div>
                          
                          <h3 class="myheader"> योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण
                          </h3>
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
                                    <?php $data= Samitiprofitablefamilydetails::find_by_type_id(0,$_GET['id']);?>
                                 <tr>

                                      <td><?php echo convertedcit($data->pariwar_population);?></td>
                                     <td ><?php echo convertedcit($data->female);?></td>
                                      <td><?php echo convertedcit($data->male);?></td>
                                      <td><?php echo convertedcit($data->total);?></td>
                                  </tr>
                          </table>
                             </div>
                            <?php } ?>
                           <?php $data =Planstartingfund::find_by_plan_id($_GET['id']);
                                                                  //print_r($data);exit;
                               ?>
                          <?php if(empty($data)){?><h3  class="myheader">पेश्की भुक्तानी विवरण भरिएको छैन </h3><?php }else{?>
                            <h3 class="myheader">पेश्की भुक्तानी विवरण </h3>
                          <div class="mycontent" >
                            
                             <table class="table table-bordered">
                                     <tr>
                                    <td class="myWidth50" >पेश्की  रकम</td>
                                    <td ><?php echo convertedcit($data->advance);?></td>
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
                                   $inst_count = Analysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
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
                                 $inst_count = Analysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
                                 for($i=1; $i<=$inst_count; $i++)
                                 {
                                        $inst_data = Analysisbasedwithdraw::find_by_payment_count($i,$_GET['id']);
                                
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
                                <td ><?php echo convertedcit($inst_data->evaluated_amount); ?></td>
                              </tr>

                              <tr>
                                <td >भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td ><?php echo convertedcit($inst_data->payable_amount); ?></td>
                              </tr>
                            </table>
                            <table class="table table-bordered">
                              <tr>
                                <th>पेश्की भुक्तानी लगेको कट्टी रकम</th>
                                <th>कन्टेन्जेन्सी  कट्टी रकम</th>
                                <th>मर्मत सम्हार कोष कट्टी रकम</th>
                                <th>धरौटी कट्टी रकम</th>
                                <th>विपद व्यबसथापन कोष कट्टी रकम</th>
                               </tr>
                               <tr>
                                <td><?php echo convertedcit($inst_data->advance_payment); ?></td>
                                <td><?php echo convertedcit($inst_data->contengency_amount); ?></td>
                                <td><?php echo convertedcit($inst_data->renovate_amount); ?></td>
                                <td><?php echo convertedcit($inst_data->due_amount); ?></td>
                                <td><?php echo convertedcit($inst_data->disaster_management_amount); ?></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><?php echo convertedcit($inst_data->total_amount_deducted); ?></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><?php echo convertedcit($inst_data->total_paid_amount); ?></td>
                              </tr>
                       </table>
                                 <?php  
                                 }
                                 } ?>
                               </div> 
                      
                               
                               <?php 
                               $data_selected_public = Publicinvestigationdetails::find_by_plan_id($_GET['id']); 
                                $data_selected_final = Planamountwithdrawdetails::find_by_plan_id($_GET['id']); 
                                ?>
                                <?php if(empty($data_selected_public)& empty($data_selected_final)){?><h3 class="myheader">अन्तिम भुक्तानीको विवरण भरिएको छैन </h3><?php }else{?>
                            <h3 class="myheader" >अन्तिम भुक्तानी विवरण</h3 >
                           <div class="mycontent">
                               <table class="table table-bordered">
                             <tr>
                               <td class="myWidth50">सार्बजनिक परिक्षण भएको मिति :</td>
                               <td><?=convertedcit($data_selected_public->survey_date)?></td>
                             </tr>
                             <tr>
                               <td>सार्बजनिक परिक्षण भेलमामा उपस्थित संख्या :</td>
                               <td><?=convertedcit($data_selected_public->population)?></td>
                             </tr>
                             <tr>
                                <td>योजनाको काम सम्पन्न भएको मिति :</td>
                                <td><?=convertedcit($data_selected_final->plan_end_date)?></td>
                              </tr>
                              <tr>
                                <td>उपभोक्ता समितिको बैठक बसी खर्च स्वीकृत गरेको मिति :</td>
                                <td><?=convertedcit($data_selected_final->upabhokta_aproved_date)?></td>
                              </tr>
                              <tr>
                                <td>अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति :</td>
                                <td><?=convertedcit($data_selected_final->expenditure_approved_date)?></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन मिति :</td>
                                <td><?=convertedcit($data_selected_final->plan_evaluated_date)?></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->plan_evaluated_amount)?></td>
                              </tr>
                               <tr>
                                <td> भुक्तानी दिनु पर्ने कुल  रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->final_payable_amount)?></td>
                              </tr>
                               <tr>
                                <td> मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->payment_till_now)?></td>
                              </tr>
                              <tr>
                                <td>पेश्की भुक्तानी लगेको कट्टी रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->advance_payment)?></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी दिनु पर्ने कुल बाँकी  रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->remaining_payment_amount)?></td>
                              </tr>
                              <tr>
                                <td>कन्टेन्जेन्सी  कट्टी रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->final_contengency_amount)?></td>
                              </tr>
                              <tr>
                                <td>मर्मत सम्हार कोष कट्टी रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->final_renovate_amount)?></td>
                              </tr>
                              <tr>
                                <td>धरौटी कट्टी रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->final_due_amount)?></td>
                              </tr> 
                              <tr>
                                <td>विपद व्यबसथापन कोष कट्टी रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->final_disaster_management_amount)?></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->final_total_amount_deducted)?></td>
                              </tr>
                              <tr>
                                <td>भुक्तानी लगिएको खुद रकम :</td>
                                <td>रु. <?=convertedcit($data_selected_final->final_total_paid_amount)?></td>
                              </tr>  
                 </table>
                               </div>   
                                <?php }?>
     


                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>