<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}

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
            <h2 class="headinguserprofile">योजना विवरण दर्ता फाराम</h2>
            <div class="OurContentLeft">
                  <?php include("menuincludes/settingsmenu.php");?>
            </div>	
                <?php echo $message;?>
            <div class="OurContentRight">

                <!--<h2>बिषयगत क्षेत्रको नाम </h2>-->
                <div class="userprofiletable">

                    <h3>योजनाको विवरण भर्नुहोस</h3>
                     <table class="table table-bordered" border="2">
                                        
                                        <tr>
                                            <td>आ=ब</td>
                                            <td><?php echo Fiscalyear::getName($result->fiscal_id); ?></td>
                                        </tr> <tr>
                                            <td>दर्ता नं</td>
                                            <td><?php echo $result->id;?></td>
                                          </tr>
                                         <tr>
                                                <td>योजनाको बिषयगत क्षेत्रको नाम</td>
                                                <td><?php echo Topicarea::getName($result->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>योजनाको  शिर्षकगत नाम</td>
                                               <td><?php echo Topicareatype::getName($result->topic_area_type_id);  ?></td>
                                           </tr>                                          
                                           <tr>
                                               <td>योजनाको अनुदानको किसिम</td>
                                               <td><?php echo Topicareaagreement::getName($result->topic_area_agreement_id); ?></td>
                                          </tr> 
                                          <tr>
                                               <td>योजनाको विनियोजन किसिम</td>
                                               <td><?php echo Topicareainvestment::getName($result->topic_area_agreement_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>योजनाको विनियोजन श्रोत</td>
                                               <td><?php echo Topicareainvestmentsource::getName($result->topic_area_investment_source_id); ?></td>
                                           </tr>
                                           <tr>
                                            <td>योजनाको नाम</td>
                                            <td><?php echo $result->program_name;?></td>
                                          </tr>
                                           <tr>
                                            <td>आयोजना सचालन हुने स्थान</td>
                                            <td><b><?php echo SITE_LOCATION;?></b></td>
                                            <td><?php echo $result->ward_no; ?></td>
                                           </tr>
                                          <tr>
                                            <td>टोल बस्तीको नाम</td>
                                            <td><?php echo $result->tole_name;?></td>
                                          </tr>
                                           <tr>
                                            <td> अनुदान रु</td>
                                            <td><?php echo $result->investment_amount;?></td>
                                           </tr>
                       </table> </br></br>
                      <h3> योजनाको कुल लागत अनुमान </h3>
                      
                        <table class="table table-bordered">
                          <?php 
                             $data=Plantotalinvestment::find_by_plan_id($result->id);
                           
                          ?>
                            
                            <tr>
                            <th width="176" scope="row"><?php echo SITE_TYPE;?>बाट अनुदान</th>
                            <td> <?php echo $data->agreement_gauplaika;?></td>
                          </tr>
                          <tr>
                            <th scope="row">अन्य निकायबाट प्राप्त अनुदान</th>
                            <td><?php echo $data->agreement_other;?></td>
                          </tr>
                          <tr>
                            <th scope="row">उपभोक्ताबाट नगद साझेदारी</th>
                            <td><?php echo $data->costumer_agreement;?></td>
                          </tr>
                          <tr>
                            <th scope="row">अन्य साझेदारी</th>
                            <td><?php echo $data->other_agreement;?></td>
                          </tr>
                          <tr>
                            <th scope="row">उपभोक्ताबाट जनश्रमदान</th>
                            <td><?php echo $data->costumer_investment;?></td>
                          </tr>
                          <tr>
                            <th scope="row">कुल लागत अनुमान जम्मा </th>
                            <td><?php echo $data->total_investment;?></td>
                          </tr>
                         
                        </table></br></br>
                     <h3>उपभोक्ता समिति  सम्बन्धी विवरण </h3>
                         <table class="table table-bordered">
                              <?php
                          
                              $datas= Costumerassociationdetails::find_by_plan_id($result->id);
                              
                              $data1=Costumerassociationdetails0::find_by_plan_id($result->id);?>
                             <tr>
                                 <td><b>योजनाको संचालन गर्ने उपभोक्ता समितिको नाम</b></td><td><?php echo $data1->program_organizer_group_name;?></td>
                                 <td><b>योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना</b></td><td><?php echo $data1->program_organizer_group_address;?></td>
                         </tr>    
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
                                <?php $i=1; foreach($datas as $data):
                                    ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo Postname::getName($data->post_id);?></td>
                                    <td><?php echo $data->name; ?></td>
                                    <td><?php echo $data->address;?></td>
                                    <td> <?php echo $data->gender;?></td> 
                                    <td><?php echo $data->cit_no;?></td>
                                    <td><?php echo $data->issued_district;?></td>
                                    <td><?php echo $data->mobile_no; ?></td>
                                 </tr>
                                 <?php  $i++; endforeach;?>
                         </table></br></br>
                         <h3>अनुगमन समिति सम्बन्धी विवरण </h3>
                          <table class="table table-bordered">
                                <?php $datas= investigationassociationdetails::find_by_plan_id($result->id);?>
                              <tr>
                                    <th>सिनं</th>
                                    <th>पद</th>
                                    <th>नामथर</th>
                                    <th>ठेगाना</th>
                                    <th>लिगं</th>
                                    <th>मोवायल नं</th>
                                </tr>
                                <?php  $i=1; foreach($datas as$data):?>
                                <tr>
                                    <td><?php echo $i ;?></td>
                                     <td><?php echo Postname::getName($data->post_id);?></td>
                                     <td><?php echo $data->name; ?></td>
                                    <td><?php echo $data->address;?></td>
                                    <td> <?php echo $data->gender;?></td> 
                                    <td><?php echo $data->mobile_no; ?></td>
                                 </tr>
                                <?php $i++;endforeach;?>
                                
                          </table></br></br></br>
                          <h3>योजना सम्बन्धी अन्य विवरण</h3>
                          <table class="table table-bordered">
                              <?php $data= Moreplandetails::find_by_plan_id($result->id); ?>
                              <tr>
                                    <td width="178">उपभोक्ता समिति गठन भएको मिति</td>
                                    <td width="250"><?php echo $data->samiti_gathan_date;?></td>
                                  </tr>
                                  <tr>
                                    <td>उपभोक्ता भेलामा उपस्थिति संख्या</td>
                                    <td><?php echo $data->costumer_total_population;?></td>
                                  </tr>
                                  <tr>
                                    <td>योजना शुरु हुने मिति</td>
                                    <td><?php echo $data->yojana_start_date;?></td>
                                  </tr>
                                  <tr>
                                    <td>योजना सम्पन्न हुने मिति</td>
                                    <td><?php echo $data->yojana_sakine_date;?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo SITE_TYPE;?>को तर्फबाट संझौता गर्नेको नाम</td>
                                    <td><?php echo $data->samjhauta_date;?></td>
                                  </tr>
                                  <tr>
                                    <td>पद</td>
                                    <td><?php  echo Postname::getName($data->post_id_3);?></td>
                                  </tr>
                                  <tr>
                                    <td>मिती</td>
                                    <td><?php echo $data->miti;?></td>
                                  </tr>
                           </table></br></br>
                          <h3> योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण</h3>
                          <table class="table table-bordered">
                             <tr>
                                  <td width="163" rowspan="2">घर परिवारको विवरण</td>
                                  <td width="133" rowspan="2">घर परिवार संख्या</td>
                                  <td colspan="8">लाभान्वित जनसंख्या</td>
                                </tr>
                                <tr>
                                  <td width="43">अपांगता</td>
                                  <td width="51">बाल बालिका</td>
                                  <td>जेष्ठ नागरिक</td>
                                  <td>अन्य</td>
                                  <td width="49">महिला</td>
                                  <td width="67">पुरुष</td>
                                  <td width="37">तेश्रो लिंगी</td>
                                  <td width="95">जम्मा</td>
                                </tr>
                                <?php
                                   $datas= Profitablefamilydetails::find_by_plan_id($result->id);
                                   //print_r($datas);exit;?> 
                                <tr>
                                  <td height="38">मदेशी, मुश्लिम, पिछडा वर्ग </td>
                                  <td><?php echo $data->pariwar_population;?></td>
                                  <td><?php echo $data->appangata;?></td>
                                  <td><?php echo $data->childrens;?></td>
                                  <td width="52"><?php echo $data->older_people;?></td>
                                  <td><?php echo $data->aanya;?></td>
                                  <td width="31"><?php echo $data->female;?></td>
                                  <td><?php echo $data->male?></td>
                                  <td><?php echo $data->other;?></td>
                                  <td><?php echo $data->total;?></td>
                                 
                                </tr>
                                <tr>
                                  <td>दलित</td>
                                  <td><?php echo $data->pariwar_population;?></td>
                                  <td><?php echo $data->appangata;?></td>
                                  <td><?php echo $data->childrens;?></td>
                                  <td><?php echo $data->older_people;?></td>
                                  <td><?php echo $data->aanya;?></td>
                                  <td><?php echo $data->female;?></td>
                                  <td><?php echo $data->male?></td>
                                  <td><?php echo $data->other;?></td>
                                  <td><?php echo $data->total;?></td>
                                </tr>
                                <tr>
                                  <td>आदीबासी जनजाती</td>
                                  <td><?php echo $data->pariwar_population;?></td>
                                  <td><?php echo $data->appangata;?></td>
                                  <td><?php echo $data->childrens;?></td>
                                  <td><?php echo $data->older_people;?></td>
                                  <td><?php echo $data->aanya;?></td>
                                  <td><?php echo $data->female;?></td>
                                  <td><?php echo $data->male?></td>
                                  <td><?php echo $data->other;?></td>
                                  <td><?php echo $data->total;?></td>
                                </tr>
                                <tr>
                                  <td>अन्य घर परिबार</td>
                                  <td><?php echo $data->pariwar_population;?></td>
                                  <td><?php echo $data->appangata;?></td>
                                  <td><?php echo $data->childrens;?></td>
                                  <td><?php echo $data->older_people;?></td>
                                  <td><?php echo $data->aanya;?></td>
                                  <td><?php echo $data->female;?></td>
                                  <td><?php echo $data->male?></td>
                                  <td><?php echo $data->other;?></td>
                                  <td><?php echo $data->total;?></td>
                                </tr>
                                
                          </table></br></br>
                            <h3>योजना संचालनमा पेश्की दिनु पर्ने अत्याबश्यक भएमा </h3>
                                <table class="table table-bordered">
                                  <?php
                                   $sql="select * from plan_starting_fund where plan_id=".$result->id;
                                   $datas= Planstartingfund::find_by_sql($sql);
                                  foreach($datas as $data):?> 
                                  <tr>
                                    <td width="177">पेश्की  रकम</td>
                                    <td width="162"><?php echo $data->advance;?></td>
                                  </tr>
                                  <tr>
                                    <td>पेश्की दिएको मिती</td>
                                    <td><?php echo $data->advance_taken_date;?></td>
                                  </tr>
                                  <tr>
                                    <td>पेश्की लिने उपभोक्ता समितिको नाम</td>
                                    <td><?php echo $data->advance_taken_group;?></td>
                                  </tr>
                                  <tr>
                                    <td>पेश्की लिने उपभोक्ता समितिको ठेगाना</td>
                                    <td><?php echo $data->advance_taken_group_address;?></td>
                                  </tr>
                                  <tr>
                                    <td>पेश्की फर्छ्यौट गर्नु पर्ने मिति</td>
                                    <td><?php echo $data->advance_return_date;?></td>
                                  </tr>
                                  <tr>
                                    <td>पेश्की दिनु पर्ने कारण</td>
                                    <td><?php echo $data->advance_reason;?></td>
                                  </tr>
                                  <?php endforeach;?>
                                </table></br></br></br>
                           <h3>मुल्यांकन को आधारमा भुक्तानी दिनु पर्ने भएमा</h3>
                            <table class="table table-bordered">
                               <?php foreach($results as $result):
                                   $sql="select * from analysis_based_withdraw where plan_id=".$result->id;
                                   $datas= Analysisbasedwithdraw::find_by_sql($sql);
                               endforeach;
                    foreach($datas as $data):?>
                             <tr>
                                <td width="176">हाल भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td width="243"><?php echo $data->payment_amount1;?></td>
                              </tr>
                              <tr>
                                <td width="176">मुल्यांकन  रकम</td>
                                <td width="243"><?php echo $data->analysis1;?></td>
                              </tr>
                               <tr>
                                <td width="176">मुल्यांकन  मिती</td>
                                <td width="243"><?php echo $data->analysis_date1;?></td>
                              </tr>
                              <tr>
                                <td>कन्टेन्जेन्सी  कट्टी रकम</td>
                                <td><?php echo $data->contengency_amount1;?></td>
                              </tr>
                              <tr>
                                <td>पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                <td><?php echo $data->advance_payment1;?></td>
                              </tr>
                              <tr>
                                <td>मर्मत सम्हार कोष कट्टी रकम</td>
                                <td><?php echo $data->renovate_amount1;?></td>
                              </tr>
                              <tr>
                                <td>धरौटी कट्टी रकम</td>
                                <td><?php echo $data->due_amount1;?></td>
                              </tr>
                              <tr>
                                <td>विपद व्यबसथापन कोष कट्टी रकम</td>
                                <td><?php echo $data->disaster_management_amount1;?></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><?php echo $data->total_amount1;?></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><?php echo $data->total_payment1;?></td>
                              </tr>
                              <?php endforeach;?>
                            </table></br></br>

                              <h3>सार्बजनिक परिक्षण सम्बन्धी विवरण</h3>
                              <table class="table table-bordered">
                                   <?php foreach($results as $result):
                                   $sql="select * from public_investigation_details where plan_id=".$result->id;
                                   $datas= Publicinvestigationdetails::find_by_sql($sql);
                               endforeach;
                    foreach($datas as $data):?> 
                                  <tr>
                                      <td width="178">सार्बजनिक परिक्षण भएको मिति</td>
                                      <td width="117"><?php echo $data->survey_date;?></td>
                                    </tr>
                                    <tr>
                                      <td>सार्बजनिक परिक्षण भेलमामा उपस्थित संख्या</td>
                                      <td><?php echo $data->population;?></td>
                                    </tr>
                                    <?php endforeach;?>
                              </table></br></br>
                              <h3>योजना भुक्तानी सम्बन्धी विवरण</h3>
                            <table class="table table-bordered">
                               <?php foreach($results as $result):
                                   $sql="select * from plan_amount_withdraw_details where plan_id=".$result->id;
                                   $datas= Planamountwithdrawdetails::find_by_plan_id($sql);
                               endforeach;
                    foreach($datas as $data):?>
                               <tr>
                                <td width="178">योजनाको काम सम्पन्न भएको मिति</td>
                                <td width="190"><?php echo $data->program_end_time;?></td>
                              </tr>
                              <tr>
                                <td>उपभोक्ता समितिको बैठक बसी खर्च स्वीकृत गरेको मिति</td>
                                <td><?php echo $data->expenditure_approved_time_costumer;?></td>
                              </tr>
                              <tr>
                                <td>अनुगमन समितिको बैठक बसी खर्च स्वीकृत गरेको मिति</td>
                                <td><?php echo $data->expenditure_approved_time_group;?></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन मिति</td>
                                <td><?php echo $data->program_analysis_time;?></td>
                              </tr>
                              <tr>
                                <td>योजनाको मुल्यांकन रकम</td>
                                <td><?php echo $data->program_analysis_amount;?></td>
                              </tr>
                              <tr>
                                <td>योजनाको फोटो</td>
                                <td><?php echo $data->program_picture;?></td>
                              </tr>
                              <?php endforeach;?>
                            </table></br></br>
                             <h3>अन्तिम भुक्तानी सम्बन्धि व्यबस्था</h3>
                            <table class="table table-bordered">
                               <?php foreach($results as $result):
                                   $sql="select * from last_withdraw_provision where plan_id=".$result->id;
                                   $datas= Lastwithdrawprovision::find_by_sql($sql);
                               endforeach;
                    foreach($datas as $data):?>
                                <tr>
                                <td width="176"> भुक्तानी दिनु पर्ने कुल  रकम</td>
                                <td width="243"><?php echo $data->payment_amount;?></td>
                              </tr>
                              <tr>
                                <td>कन्टेन्जेन्सी  कट्टी रकम</td>
                                <td><?php echo $data->contengency_amount;?></td>
                              </tr>
                              <tr>
                                <td>पेश्की भुक्तानी लगेको कट्टी रकम</td>
                                <td><?php echo $data->advance_payment;?></td>
                              </tr>
                              <tr>
                                <td>हाल सम्म भुक्तानी लगेको कट्टी रकम</td>
                                <td><?php echo $data->advance_payment_till_now;?></td>
                              </tr>
                              <tr>
                                <td>मर्मत सम्हार कोष कट्टी रकम</td>
                                <td><?php echo $data->renovate_amount;?></td>
                              </tr>
                              <tr>
                                <td>धरौटी कट्टी रकम</td>
                                <td><?php echo $data->due_amount;?></td>
                              </tr>
                              <tr>
                                <td>विपद व्यबसथापन कोष कट्टी रकम</td>
                                <td><?php echo $data->disaster_management_amount;?></td>
                              </tr>
                              <tr>
                                <td>जम्मा कट्टी रकम</td>
                                <td><?php echo $data->total_amount;?></td>
                              </tr>
                              <tr>
                                <td>हाल भुक्तानी दिनु पर्ने खुद रकम</td>
                                <td><?php echo $data->total_payment;?></td>
                              </tr>
                              <?php endforeach;?>
                            </table></br></br>
                            
                           
                                        
     


                </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>