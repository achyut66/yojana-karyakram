<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
//$sql="select * from plan_details1 where sn='".$_POST['name']."' limit 1";
$result= Plandetails1::find_by_id($_GET['id']);

?>

<?php include("menuincludes/header.php"); ?>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 

        <div class="maincontent">
                        <h2 class="headinguserprofile">तपाई आहिले <span class="underline"><?php echo $result->program_name;?></span>को  विवरण  हेर्दै हुनुहुन्छ | <a href="view_all_plans.php" class="btn">पछि जानुहोस 
</a></h2>
            
                <?php echo $message;?>
            <div class="OurContentFull">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">
  <?php $data1=  Plandetails1::find_by_id($_GET['id']);?>
                     <?php $data=  Plandetails1::find_by_id($_GET['id']);
                            $fiscal = FiscalYear::find_by_id($data->fiscal_id);
                            
                        ?>
                      
                     <h3 class="myheader"> योजनाको अनुदान विवरण </h3>
                    <div class="mycontent">
                        <div class="inputWrap100">
                        	<div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">आर्थिक बर्ष : <span class="underline"><?php echo convertedcit($fiscal->year); ?></span></div>
                                <div class="titleInput">दर्ता नं : <span class="underline"><?php echo convertedcit($data->id);?></span></div>
                                <div class="titleInput">योजनाको नाम : <span class="underline"><?php echo $data->program_name;?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">संचालन  हुने स्थान : <span class="underline"><?php echo SITE_NAME.' - '.convertedcit($data->ward_no); ?></span></div>
                                <div class="titleInput">बिषयगत क्षेत्रको किसिम : <span class="underline"><?php echo Topicarea::getName($data->topic_area_id); ?></span></div>
                                <div class="titleInput">शिर्षकगत किसिम : <span class="underline"><?php echo Topicareatype::getName($data->topic_area_type_id); ?></span></div>
                                <div class="titleInput">बिनियोजन श्रोत : <span class="underline"><?php echo ($data->parishad_sno); ?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="inputWrap33 inputWrapLeft">
                            	<div class="titleInput">योजनाको  उपशिर्षकगत किसिम : <span class="underline"><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></span></div>
                                <div class="titleInput">योजनाको अनुदानको किसिम : <span class="underline"><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></span></div>
                                <div class="titleInput">योजनाको विनियोजन किसिम : <span class="underline"><?php echo Topicareainvestment::getName($data->topic_area_agreement_id); ?></span></div>
                                <div class="titleInput">अनुदान रकम : रु. <span class="underline"><?php echo convertedcit(placeholder($data->investment_amount));?></span></div>
                            </div><!-- input wrap 33 ends -->
                            <div class="myspacer"></div>
                        </div><!-- input wrap 2 ends -->
                        <div class="myspacer"></div>
                     </div><!-- my content ends -->
                 
                     <?php   $data=Plantotalinvestment::find_by_plan_id($data->id);?>
                     <?php if(empty($data)){?><h3 class="myheader">  योजनाको कुल लागत अनुमान थप विवरण भरिएको छैन  </h3><?php }else{?>
                       <h3  class="myheader"> योजनाको कुल लागत अनुमान </h3>
                        <div class="mycontent" >
                        	<div class="inputWrap100">
                            	<div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">भौतिक ईकाईको  परिणाम : <span class="underline"><?=convertedcit($data->unit_total)?> <?=$unit->name?></span> <?php $unit = Units::find_by_id($data->unit_id); ?></div>
                                    <div class="titleInput"><?php echo SITE_TYPE;?>बाट अनुदान रकम : रु. <span class="underline"><?php echo convertedcit($data->agreement_gauplaika);?></span></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">अन्य निकायबाट प्राप्त अनुदान रकम : रु. <span class="underline"><?php echo convertedcit(placeholder($data->agreement_other));?></span></div>
                                    <div class="titleInput">समितिबाट नगद साझेदारी रकम :रु. <span class="underline"><?php echo convertedcit(placeholder($data->costumer_agreement));?></span></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">अन्य साझेदारी रकम : रु. <span class="underline"><?php echo convertedcit(placeholder($data->other_agreement));?></span></div>
                                    <div class="titleInput">समितिबाट जनश्रमदान रकम  : रु. <span class="underline"><?php echo convertedcit(placeholder($data->costumer_investment));?></span></div>
                                    <div class="titleInput">कुल लागत अनुमान जम्मा रकम : रु. <span class="underline"><?php echo convertedcit(placeholder($data->total_investment));?></span></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                         
                        </div><!-- my content ends -->
                     <?php } ?>
                       <?php $data2=Costumerassociationdetails0::find_by_plan_id($_GET['id']);?>
                        <?php if(empty($data2)){?><h3  class="myheader"> उपभोक्ता समिति  सम्बन्धी विवरण भरिएको छैन  </h3><?php }else{?>
                         <h3  class="myheader">उपभोक्ता समिति सम्बन्धी विवरण </h3>
                        <div class="mycontent"><?php 
                                $data3=Costumerassociationdetails::find_by_plan_id($_GET['id']);?>
                            <div class="inputWrap100">
                            	<div class="inputWrap50 inputWrapLeft">
                                	<div class="titleInput">योजनाको संचालन गर्ने समितिको नाम: <span class="underline"><?php echo $data2->program_organizer_group_name;?></span></div>
                                </div><!-- input wrap 50 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">ठेगाना: <span class="underline"><?php echo SITE_NAME." - ".convertedcit($data2->program_organizer_group_address);?></span></div>
                                </div><!-- input wrap 50 ends -->
                                <div class="myspacer"></div>
                            </div><!-- input wrap 100 ends -->
                            
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>पद</strong></td>
                                    <td class="myCenter"><strong>नामथर</strong></td>
                                    <td class="myCenter"><strong>ठेगाना</strong></td>
                                    <td class="myCenter"><strong>लिगं</strong></td>
                                    <td class="myCenter"><strong>नागरिकता नं</strong></td>
                                    <td class="myCenter"><strong>जारी जिल्ला</strong></td>
                                    <td class="myCenter"><strong>मोबाइल नं</strong></td>
                                    
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
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"> <?php echo Postname::getName($data->post_id);?> </td>
                                    <td class="myCenter"><?php echo $data->name;?></td>
                                    <td class="myCenter"><?php echo SITE_NAME.' - '.convertedcit($data->address);?></td>
                                     <td class="myCenter"><?php echo $gender;?> </td>
                                    <td class="myCenter"><?php echo convertedcit($data->cit_no);?></td>
                                    <td class="myCenter"><?php echo $data->issued_district;?></td>
                                    <td class="myCenter"><?php echo convertedcit($data->mobile_no);?></td>
                                </tr>
                                <?php $i++; endforeach;?>
                            </table>
                        </div>
                        <?php } ?>
                         <?php $data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);?>
                          <?php if(empty($data4)){?><h3  class="myheader"> अनुगमन समिति सम्बन्धी थप विवरण भरिएको छैन   </h3><?php }else{?>
                          <h3  class="myheader">अनुगमन समिति सम्बन्धी विवरण </h3>
                        <div class="mycontent" >
                            <table class=" table table-bordered table-hover">
                                
                                <tr>
                                    <td class="myCenter"><strong>सि.नं.</strong></td>
                                    <td class="myCenter"><strong>पद</strong></td>
                                    <td class="myCenter"><strong>नामथर</strong></td>
                                    <td class="myCenter"><strong>ठेगाना</strong></td>
                                    <td class="myCenter"><strong>लिगं</strong></td>
                                    <td class="myCenter"><strong>मोबाइल नं</strong></td>
                                    
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
                                    <td class="myCenter"><?php echo convertedcit($i);?></td>
                                    <td class="myCenter"><?php echo Postname::getName($data->post_id);?></td>
                                    <td class="myCenter"><?php echo $data->name;?></td>
                                    <td class="myCenter"><?php echo SITE_NAME.' - '.convertedcit($data->address);?></td>
                                     <td class="myCenter"><?php echo $gender;?> </td>
                                    <td class="myCenter"><?php echo convertedcit($data->mobile_no);?></td>
                                 </tr>
                                 <?php  $i++; endforeach; ?>
                            </table>
                        </div>
                          <?php } ?>
                          <?php $data= Moreplandetails::find_by_plan_id($_GET['id']); ?>
                            <?php if(empty($data)){?><h3  class="myheader">योजना सम्बन्धी अन्य विवरण भरिएको छैन  </h3><?php }else{?>
                         <h3 class="myheader">योजना सम्बन्धी अन्य विवरण</h3>
                          <div class="mycontent" >
                          	<div class="inputWrap100">
                            	<div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">उपभोक्ता समिति गठन भएको मिति : <span class="underline"><?php echo convertedcit($data->samiti_gathan_date);?></span></div>
                                    <div class="titleInput">उपभोक्ता भेलामा उपस्थिति संख्या : <span class="underline"><?php echo convertedcit($data->costumer_total_population);?></span></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput">योजना शुरु हुने मिति : <span class="underline"><?php echo convertedcit($data->yojana_start_date);?></span></div>
                                    <div class="titleInput">योजना सम्पन्न हुने मिति : <span class="underline"><?php echo convertedcit($data->yojana_sakine_date);?></span></div>
                                </div><!-- input wrap 33 ends -->
                                <div class="inputWrap33 inputWrapLeft">
                                	<div class="titleInput"><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम : <span class="underline"><?php echo  Workerdetails::getName($data->samjhauta_party);?></span></div>
                                    <div class="titleInput">पद : <span class="underline"><?php  echo  $data->post_id_3;?></span></div>
                                    <div class="titleInput">मिती : <span class="underline"><?php echo convertedcit($data->miti);?></span></div>
                                </div><!-- input wrap 33 ends -->
                            	<div class="myspacer"></div>
                            </div><!-- input wrap ends -->
                          
                           </div><!-- my content ends -->
                          
                          <h3 class="myheader"> योजनाबाट लाभान्वित घरधुरी तथा परिवारको विवरण</h3>
                            <div class="mycontent" >
                          <table class="table table-bordered table-hover">
                            <tr>
                                 
                                  <td colspan="5" class="myCenter"><strong>लाभान्वित जनसंख्या</strong></td>
                                </tr>
                                <tr>
                                	
                                        <td class="myCenter"><strong>घर परिवार संख्या</strong></td>
                                      <td class="myCenter"><strong>महिला</strong></td>
                                      <td class="myCenter" ><strong>पुरुष</strong></td>
                                      <td class="myCenter" ><strong>जम्मा</strong></td>
                                    </tr>
                                    <?php $data= Profitablefamilydetails::find_by_type_id(0,$_GET['id']);?>
                                 <tr>

                                      <td class="myCenter"><?php echo convertedcit($data->pariwar_population);?></td>
                                     <td  class="myCenter"><?php echo convertedcit($data->female);?></td>
                                      <td class="myCenter"><?php echo convertedcit($data->male);?></td>
                                      <td class="myCenter"><?php echo convertedcit($data->total);?></td>
                                  </tr>
                          </table>
                             </div>
                            <?php } ?>
                           <?php $data = Planstartingfund::find_by_plan_id($_GET['id']);
                                                                  //print_r($data);exit;
                               ?>
                          <?php if(empty($data)){?><h3  class="myheader">पेश्की भुक्तानी विवरण भरिएको छैन </h3><?php }else{?>
                            <h3 class="myheader">पेश्की भुक्तानी विवरण </h3>
                          <div class="mycontent">
                              <div>
                                  <div class="">
                                	<div class="inputWrap50 inputWrapLeft">
                                    	<div class="titleInput">
                                        	पेश्की  रकम: <span class="underline"><?php echo convertedcit(placeholder($data->advance));?></span>
                                        </div>
                                        <div class="titleInput">
                                        	पेश्की दिएको मिती: <span class="underline"><?php echo convertedcit($data->advance_taken_date);?></span>
                                        </div>
                                    </div><!-- input wrap 50 ends -->
                                    <div class="inputWrap50 inputWrapLeft">
                                    	<div class="titleInput">
                                        	पेश्की फर्छ्यौट गर्नु पर्ने मिति: <span class="underline"><?php echo convertedcit($data->advance_return_date);?></span>
                                        </div>
                                        <div class="titleInput">
                                        	पेश्की दिनु पर्ने कारण: <span class="underline"><?php echo $data->advance_reason;?></span>
                                        </div>
                                    </div><!-- input wrap 50 ends -->
                                </div><!-- input wrap 100 ends -->
                              </div>
                          </div><!-- my content ends --><br>
                          <?php }?>  
                                
                                 <?php
                                   $inst_count = Analysisbasedwithdraw::getMaxInsallmentByPlanId($_GET['id']);
                                 if(empty($inst_count)){?><h3  class="myheader"> मुल्यांकन को आधारमा भुक्तानी  विवरण भरिएको छैन </h3><?php }else{?><br>
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
                                        <div class="inputWrap100">
                                        	<div class="inputWrap50 inputWrapLeft">
                                            	<div class="titleInput">योजनाको मुल्यांकन किसिम : <span class="underline"><?php echo $inst_array[$i]; ?></span></div>
                                                <div class="titleInput">योजनाको मुल्यांकन  मिती: <span class="underline"><?php echo convertedcit($inst_data->evaluated_date); ?></span></div>
                                            </div><!-- input wrap 50 ends -->
                                            <div class="inputWrap50 inputWrapLeft">
                                            	<div class="titleInput">योजनाको मुल्यांकन  रकम: <span class="underline"><?php echo convertedcit(placeholder($inst_data->evaluated_amount)); ?></span></div>
                                                <div class="titleInput">भुक्तानी दिनु पर्ने कुल  रकम: <span class="underline"><?php echo convertedcit(placeholder($inst_data->payable_amount)); ?></span></div>
                                            </div><!-- input wrap 50 ends -->
                                            <div class="myspacer"></div>
                                        </div><!-- input wrap 100 ends -->
                            
                                
                             
                            <table class="table table-bordered table-hover">
                              <tr>
                                <td class="myCenter">पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                <td class="myCenter">कन्टेन्जेन्सी  कट्टी रकम</td>
                                <td class="myCenter">मर्मत सम्हार कोष कट्टी रकम</td>
                                <td class="myCenter">धरौटी कट्टी रकम</td>
                                <td class="myCenter">विपद व्यबसथापन कोष कट्टी रकम</td>
                               </tr>
                               <tr>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->advance_payment)); ?></td>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->contengency_amount)); ?></td>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->renovate_amount)); ?></td>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->due_amount)); ?></td>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->disaster_management_amount)); ?></td>
                              </tr>
                              <tr>
                                <td class="myCenter">जम्मा कट्टी रकम</td>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->total_amount_deducted)); ?></td>
                              </tr>
                              <tr>
                                <td class="myCenter">हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td class="myCenter"><?php echo convertedcit(placeholder($inst_data->total_paid_amount)); ?></td>
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
                                <?php if(empty($data_selected_public)&& empty($data_selected_final)){?><h3 class="myheader">अन्तिम भुक्तानीको विवरण भरिएको छैन </h3><?php }else{?>
                            <h3 class="myheader" >अन्तिम भुक्तानी विवरण</h3 >
                           <div class="mycontent">
                           		<div class="inputWrap100">
                                	<div class="inputWrap33 inputWrapLeft">
                                    	<div class="titleInput">सार्बजनिक परिक्षण भएको मिति : <span class="underline"><?=convertedcit($data_selected_public->survey_date)?></span></div>
                                        <div class="titleInput">सार्बजनिक परिक्षण भेलमामा उपस्थित संख्या : <span class="underline"><?=convertedcit($data_selected_public->population)?></span>
                             </div>
                                        <div class="titleInput">योजनाको काम सम्पन्न भएको मिति : <span class="underline"><?=convertedcit($data_selected_final->plan_end_date)?></span></div>
                                        <div class="titleInput">उपभोक्ता समितिको बैठक बसी खर्च स्वीकृत गरेको मिति : <span class="underline"><?=convertedcit($data_selected_final->upabhokta_aproved_date)?></span></div>
                                        <div class="titleInput">अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति : <span class="underline"><?=convertedcit($data_selected_final->expenditure_approved_date)?></span></div>
                                        <div class="titleInput">योजनाको मुल्यांकन मिति : <span class="underline"><?=convertedcit($data_selected_final->plan_evaluated_date)?></span></div>
                                    </div><!-- input wrap 33 ends -->
                                    <div class="inputWrap33 inputWrapLeft">
                                    	<div class="titleInput">योजनाको मुल्यांकन रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->plan_evaluated_amount))?></span></div>
                                        <div class="titleInput">भुक्तानी दिनु पर्ने कुल  रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->final_payable_amount))?></span></div>
                                        <div class="titleInput">मुल्यांकन अनुसार हाल सम्म भुक्तानी लगेको कुल  रकम : <span class="underline">रु. <?=convertedcit($data_selected_final->payment_till_now)?></span></div>
                                        <div class="titleInput">पेश्की भुक्तानी लगेको कट्टी रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->advance_payment))?></span></div>
                                        <div class="titleInput">भुक्तानी दिनु पर्ने कुल बाँकी  रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->remaining_payment_amount))?></span></div>
                                        <div class="titleInput">कन्टेन्जेन्सी  कट्टी रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->final_contengency_amount))?></span></div>
                                    </div><!-- input wrap 33 ends -->
                                    <div class="inputWrap33 inputWrapLeft">
                                    	<div class="titleInput">मर्मत सम्हार कोष कट्टी रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->final_renovate_amount))?></span></div>
                                        <div class="titleInput">धरौटी कट्टी रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->final_due_amount))?></span></div>
                                        <div class="titleInput">विपद व्यबसथापन कोष कट्टी रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->final_disaster_management_amount))?></span></div>
                                        <div class="titleInput">जम्मा कट्टी रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->final_total_amount_deducted))?></span></div>
                                        <div class="titleInput">भुक्तानी लगिएको खुद रकम : <span class="underline">रु. <?=convertedcit(placeholder($data_selected_final->final_total_paid_amount))?></span></div>
                                        <div class="titleInput"></div>
                                    </div><!-- input wrap 33 ends -->
                                    <div class="myspacer"></div>
                                </div><!-- input wrap 100 ends -->
                            </div><!-- my content ends -->   
                                <?php }?>
                            <h3>के तपाई फोटो हेर्न चाहनुहुन्छ? <a href="photo_view.php?id=<?php echo $_GET['id'];?>" class="btn">हेर्नुहोस</a></h3>

                </div>
                  </div>
                </div><!-- main menu ends -->
            
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>