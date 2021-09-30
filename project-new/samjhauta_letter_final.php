<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
	
	$datas=Samiticostumerassociationdetails::find_by_plan_id($_GET['id']);
//        print_r($datas);exit;
	$worker=Samitimoreplandetails::find_by_plan_id($_GET['id']);
	
	
	
	?>
   <?php $data1=  Plandetails1::find_by_id($_GET['id']);?>
                     <?php $data=  Plandetails1::find_by_id($_GET['id']);

                            $fiscal = FiscalYear::find_by_id($data->fiscal_id);
							$ward_address=WardWiseAddress();
                            $address= getAddress();
                        ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>योजना संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>
<style>
                          table {

                            width: 100%;
                            border: none;
                          }
                          th, td {
                            padding: 8px;
                            text-align: left;
                            border-bottom: 3px solid #ddd;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                    <div class="myspacer"></div>
                    <div class="printContent">
                        <div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
                        <div class="patrano">आर्थिक वर्ष : <?php echo convertedcit($fiscal->year); ?></div>
                        <div class="patrano"> योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?>	</div>
                       
                        <div class="myspacer"></div>
										
			<div class="banktextdetails1 ">
                            <div class="subject myFont1">योजना संझौता फाराम</div>
                                <div class="mycontent">
                     <table class="table-bordered myWidth100 myFont1">
                                        
                                      <tr>
                                            <td class="myWidth50">योजनाको नाम : </td><td><?php echo $data->program_name;?></td>
                                          </tr>
                                      <tr>
                                      <tr>
                                            <td>आयोजना सचालन हुने स्थान / वार्ड नं :  </td><td> <?php echo SITE_LOCATION;?><?php echo convertedcit($data->ward_no);?></td>
                                          </tr>
                                      <tr>
                                                <td>योजनाको बिषयगत क्षेत्रको नाम : </td><td><?php echo Topicarea::getName($data->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>योजनाको  शिर्षकगत नाम : </td><td><?php echo Topicareatype::getName($data->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>योजनाको  उपशिर्षकगत नाम : </td><td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                           <tr>
                                               <td>योजनाको अनुदानको किसिम : </td><td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></td>
                                          </tr> 
                                          <tr>
                                               <td>योजनाको विनियोजन किसिम : </td><td><?php echo Topicareainvestment::getName($data->topic_area_agreement_id); ?></td>
                                          </tr>
                                          
                                           
                                           
                                           <tr>
                                            <td> अनुदान रकम  : </td><td>रु. <?php echo convertedcit($data->investment_amount);?></td>
                                           </tr>
                       </table>
                     </div>
                                                <?php $data=Samitiplantotalinvestment::find_by_plan_id($data->id);
                                                if(empty($data))
                                                {?>
                                                  <div class="subject"> योजनाको कुल लागत अनुमान भरिएको छैन</div>
                                                  
                                                <?php exit; }
                                                else
                                                {
                                                ?>
                                              <div class="subject myFont1"> योजनाको कुल लागत अनुमान </div>
                                              <div class="mycontent" >

                                                  
                                            <table class="table-bordered myWidth100 myFont1">
                                                    <?php 
                                                       
                                                        $unit = Units::find_by_id($data->unit_id);
                                                    ?>
                                                     <tr>
                                                        <td class="myWidth50">भौतिक ईकाईको  परिणाम : </td><td><?=convertedcit($data->unit_total)?> <?=$unit->name?></td>
                                                      <tr>
                                                      <td ><?php echo SITE_TYPE;?>बाट अनुदान रकम : रु.  </td><td><?php echo convertedcit($data->agreement_gauplaika);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td >अन्य निकायबाट प्राप्त अनुदान रकम : </td><td>रु. <?php echo convertedcit($data->agreement_other);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td >संस्था / समितिबाट नगद साझेदारी रकम : </td><td>रु. <?php echo convertedcit($data->costumer_agreement);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td>अन्य साझेदारी रकम : </td><td>रु. <?php echo convertedcit($data->other_agreement);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td>संस्था / समितिबाट जनश्रमदान रकम : </td><td>रु. <?php echo convertedcit($data->costumer_investment);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td>कुल लागत अनुमान जम्मा  रकम : </td><td>रु. <?php echo convertedcit($data->total_investment);?></td>
                                                    </tr>
                                                   
                                                  </table>
                                                </div>
                                                <?php } ?>
                                              <?php 
                                              $data2=Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
                                              if(empty($data2)){?>
                                                  <div class="subject myFont1">संस्था / समिति  सम्बन्धी विवरण भरिएको छैन </div>
                                             <?php
                                              }
                                              else
                                              {
                                              ?>
                                              <div class="subject myFont1">संस्था / समिति  सम्बन्धी विवरण </div>
                                              <div class="mycontent">
                                                    <table class="table-bordered myWidth100 myFont1">
                                                        <?php 
                                                        $data3=Samiticostumerassociationdetails::find_by_plan_id($_GET['id']);?>
                                                        <tr>
                                                            <td>योजनाको संचालन गर्ने संस्था / समितिको नाम: <u><?php echo $data2->program_organizer_group_name;?> </u></td>
                                                            
                                                    </tr>
                                                    <tr>
                                                    <td>ठेगाना: <u><?php echo SITE_NAME. convertedcit($data2->program_organizer_group_address);?></u></td>
                                                    </tr>
                                                    </table>
                                                    <table class="table-bordered myWidth100 myFont1">
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
                                                         if($data->gender==1){
                                                             $gender="पुरुष ";
                                                         }
                                                         elseif($data->gender==2)
                                                         {
                                                              $gender="महिला";
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
                                               <?php $data4=Samitiinvestigationassociationdetails::find_by_plan_id($_GET['id']);
                                               if(empty($data4)){?>
                                              <div class="subject myFont1">अनुगमन समिति सम्बन्धी विवरण भरिएको छैन</div>
                                               <?php } else {?>
                                              <div class="subject myFont1">अनुगमन समिति सम्बन्धी विवरण</div>
                                              <div class="mycontent">
                                                    <table class="table-bordered myWidth100 myFont1">
                                                        <?php $data4=  Samitiinvestigationassociationdetails::find_by_plan_id($_GET['id']);?>
                                                        <tr>
                                                            <th>सिनं</th>
                                                            <th>पद</th>
                                                            <th>नामथर</th>
                                                            <th>ठेगाना</th>
                                                            <th>लिगं</th>
                                                            <th>मोवायल नं</th>                                    
                                                        </tr>
                                                 <?php $i=1;foreach($data4 as $data):
                                                     if($data->gender==1){
                                                             $gender="पुरुष ";
                                                         }
                                                         elseif($data->gender==2)
                                                         {
                                                              $gender="महिला";
                                                         }?>
                                                        <tr>
                                                            <td><?php echo convertedcit($i);?></td>
                                                            <td><?php echo Postname::getName($data->post_id);?></td>
                                                            <td><?php echo $data->name;?></td>
                                                            <td><?php echo SITE_NAME.convertedcit($data->address);?></td>
                                                             <td><?php echo $gender;?> </td>
                                                            <td><?php echo convertedcit($data->mobile_no);?></td>
                                                         </tr>
                                                         <?php $i++ ; endforeach; ?>
                                                    </table>
                                                </div>
                                              <?php }?>
                                              <?php $data= Samitimoreplandetails::find_by_plan_id($_GET['id']); 
                                              if(empty($data)){?>
                                                <div class="subject myFont1">योजना सम्बन्धी अन्य विवरण भरिएको छैन</div>
                                              <?php }else{?>

                                              <div class="subject myFont1">योजना सम्बन्धी अन्य विवरण</div>
                                              
                                              <table class="table-bordered myWidth100 myFont1">
                                                      <?php $data= Samitimoreplandetails::find_by_plan_id($_GET['id']); ?>
                                                      <tr>
                                                            <td class="myWidth50">संस्था / समिति गठन भएको मिति : </td><td><?php echo convertedcit($data->samiti_gathan_date);?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>संस्था / समिति भेलामा उपस्थिति संख्या : </td><td><?php echo convertedcit($data->costumer_total_population);?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>योजना शुरु हुने मिति : </td><td><?php echo convertedcit($data->yojana_start_date);?></td>
                                                          </tr>
                                                          <tr>
                                                            <td>योजना सम्पन्न हुने मिति : </td><td><?php echo convertedcit($data->yojana_sakine_date);?></td>
                                                          </tr>
                                                          
                                                   </table>
                                                   
                            	<div class="subject myFont1"> योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण</div>
                              <table class="table-bordered myWidth100 myFont1">
                                    <tr>
                                     <td colspan="5" style="text-align:center myFont1">लाभान्वित जनसंख्या</td>
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
                                              <?php }?>
                                              <div class="subject">सम्झौताका शर्तहरु</div>
                                            <div class="">
                                                <div>                                              
<ul>
                                                 <li>सम्झौतामा उल्लेख भएको म्याद भित्र संस्था / समितिले योजना सम्पन्न गरिसक्नु पर्ने छ । कुनै कारणवश योजना सम्पन्न हुन नसकेमा सम्पन्न हुन नसक्नुको कारण सहित म्याद सकिने अबधि भन्दा ७ दिन अगाबै संस्था / समितिलिे सम्बन्धित स्थानिय तहमा निबेदन दिनु पर्नेछ ।निबेदन प्राप्त भएपछि औचित्यको आधारमा निर्णय गरी सम्झौताको म्याद थप गर्न सकिनेछ । यसरी म्याद थप नगरी भुक्तानी उपलब्ध हुने छैन ।</li>
                                                 <li>योजनाको भुक्तानी स्थानीय तहले प्राबिधिक रनिङ बिलको आधारमा किस्ताको रुपमा वा काम सम्पन्न भएपछि संस्था / समितिले खर्चको विवरण मुल समिति र अनुगमन समितिको बैठक बसी  आम्दानी खर्च  सार्बजनिक गरी अनुमोदन गरेपछि मात्र  उपलब्ध गराइने छ ।</li>
        <li>
        तोकिएको काम भन्दा कम काम गर्ने वा काम नै नगरी वा वास्तविक काम भन्दा बढी काम गरेको देखाई अथवा कुनै आइटमको सट्टा अर्को आइटमको कार्य पूरा गरेको देखाई लागत अनुमानभन्दा फरक काम गरी  रकम माग्ने संस्था / समितिलाई उक्त रकम भुक्तानी नदिई कालो सूचीमा राखी  कारवाही गरिनेछ ।</li>
        <li>
        योजना संग सम्बन्धित प्राप्त नगद⁄जिन्सी संस्था / समितिले सम्बन्धित योजनामा मात्र खर्च गर्नु पर्नेछ र प्राप्त नगद⁄जिन्सीको दुरुपयोग, हिनामिना वा हानी नोक्सानी गरेमा प्रचलित कानुन बमोजिम कारवाही हुनेछ ।</li>
        <li>
        संस्था / समितिले काम सम्पन्न गरिसकेपछि बाँकि रहन गएका खप्ने सामानहरु मर्मत सम्भार समिति गठन भएको भए सो समितिलाई र सो नभए सम्बन्धित स्थानीय तहलाई बुझाउनु पर्नेछ । तर मर्मत सम्भार समितिलाई बुझाएको सामानको विवरणको एक प्रति सम्बन्धित <?php echo SITE_TYPE;?>मा बुझाउनु पर्नेछ ।</li>
        <li>
        संस्था / समितिले योजनासंग सम्बन्धित विल भर्पाइहरु, डोर हाजिरी फारामहरु, जिन्सी नगदी खाताहरु,समितिको निर्णय पुस्तिका आदि कागजात <?php echo SITE_TYPE;?> वा अन्य सरोकारवाला पदाधिकारीले मागेको बखत उपलब्ध गराउनु पर्ने छ र त्यसको लेखा परीक्षण पनि गराउन सकिनेछ ।</li>
        <li>
        योजनाको सार्वजनिक परीक्षण, सुचना पाटी, आम्दानी खर्चको सार्वजनिकरण, तथा अन्य पारदर्शिता सम्बन्धी प्रावधानको पालना गर्नु पर्नेछ।</li>
        <li>
        संस्था / समितिले कार्यदेश लिएर लामो समय सम्म योजना संचालन नगर्ने, योजनाको आय व्ययको विवरण दुरुस्त नराखी रकमको दुरुपयोग गरेमा सरकारी बाँकि सरह असुल उपर गरिने छ ।</li>
        <li>
        योजना सम्पन्न भएपछि स्थानीय तहबाट जाँच पास गरी फरफारकको प्रमाण पत्र लिनु पर्दछ ।साथै योजना हस्तान्तरण लिई आवश्यक मर्मत संभारको व्यवस्था सम्बन्धित उपभोक्ताहरुले नै गर्नु पर्नेछ।</li>
        <li>यस संझौतामा उल्लेख नभएका कुराहरु प्रचलित कानुन अनुसार हुनेछ।</li>
        <li>योजनाको लागि चाहिने आवश्यक कागजात यसै साथ संलग्न गरिएकोछ ।</li>
        <li>संस्था / समितिको पदाधिकारीहरुको नागरिकताको प्रतिलिपि संलग्न गरेका छौ ।
        </li>
        <li>
            <?php $rule= Rule::find_by_plan_id($_GET['id']);//print_r($rule);?>
            <?php foreach($rule as $rule):?>
            <?php echo $rule->rule;?>
            <?php endforeach;?>
        </li>
                                              </ul>
</div><!-- samjhauta list ends -->
                                            </div>
                                              <div class="subject myFont1">माथि उल्लेख भए बमोजिमका शर्तहरु पालना गर्न हामी निम्न पक्षहरु मन्जुर गर्दछौं ।</div>
                                              <div class="subject myFont1">संस्था / समितिको तर्फबाट </div>
                                              <div class="mycontent ">
                                              	<table class="table-bordered myWidth100 myFont1">
                                              	<tr>
                                                	<th class="myWidth25">सि. नं</th>
                                                    <th class="myWidth25">पद</th>
                                                    <th class="myWidth25">नाम/थर</th>
                                                    <th class="myWidth25">दस्तखत</th>
                                                </tr>
                                                 <?php 
                                               $data1=Samiticostumerassociationdetails::find_by_post_plan_id(1,$_GET['id']);
                                                $data2=Samiticostumerassociationdetails::find_by_post_plan_id(3,$_GET['id']);
                                                $data3=Samiticostumerassociationdetails::find_by_post_plan_id(4,$_GET['id'])
                                              ?>
                                               
                                                <tr>
                                                    <td><?php echo convertedcit(1);?></td>
                                                    <td><?php echo Postname::getName(1);?></td>
                                                    <td><?php echo $data1->name;?></td>
                                                    <td class="myHeight20">&nbsp;</td>                                                    
                                                </tr>
                                                <tr>
                                                    <td><?php echo convertedcit(2);?></td>
                                                    <td><?php echo Postname::getName(3);?></td>
                                                    <td><?php echo $data2->name;?></td>
                                                    <td class="myHeight20">&nbsp;</td>   
                                                </tr>
                                                <td><?php echo convertedcit(3);?></td>
                                                <td><?php echo Postname::getName(4);?></td>
                                                    <td><?php echo $data3->name;?></td>
                                                    <td class="myHeight20">&nbsp;</td>   
                                                
                                             
                                              </table>
                                              </div><!-- upabhokta ends -->
                                              <div class="subject myFont1">स्थानीय तहको तर्फबाट</div>
                                              <div class="mycontent">
                                              	<table class="table-bordered myWidth100 myFont1">
                                                	<tr>
                                                    	<th class="myWidth25">सि.नं</th>
                                                        <th class="myWidth25">पद</th>
                                                        <th class="myWidth25">नामथर</th>
                                                        <th class="myWidth25">दस्तखत</th>
                                                    </tr>
                                                    <tr>
                                                    	<td>१</td>
                                                        <td><?php echo $worker->post_id_3;?></td>
                                                        <td><?php echo Workerdetails::getName($worker->samjhauta_party);?></td>
                                                        <td class="myHeight20">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                    	<td colspan="2">मिति</td>
                                                        <td colspan="2"><?php echo convertedcit(generateCurrDate()); ?></td>
                                                    </tr>
                                                </table>
                                              </div>
                                              
											
										</div><!-- bank details ends -->
										<div class="myspacer"></div>
										
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->
