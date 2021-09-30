<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
$address= getAddress();	
	$datas=Costumerassociationdetails::find_by_plan_id($_GET['id']);
//        print_r($datas);exit;
	$worker=Moreplandetails::find_by_plan_id($_GET['id']);
	$rules_result = Rule::find_by_plan_id($_GET['id']);
	$date_selected= $_GET['date_selected'];
	$base_url = get_base_url();
        $plan_id  = $_GET['id'];
        $user     = getUser();
        $max_count = PrintDetails::find_max_counter($base_url,$plan_id);
        $print_details  = new PrintDetails;
        $print_details->url  = $base_url;
        $print_details->plan_id = $plan_id;
        $print_details->user_id = $user->id;
        $print_details->nepali_date = $_GET['date_selected'];
        $print_details->english_date = DateNepToEng($_GET['date_selected']);
        $print_details->counter       = $max_count + 1;
        $print_details->save();
	?>
   <?php $data1=  Plandetails1::find_by_id($_GET['id']);?>
                     <?php $data=  Plandetails1::find_by_id($_GET['id']);

                            $fiscal = FiscalYear::find_by_id($data->fiscal_id);
							
                        ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>योजना संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
             	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1 letter_title_two"><?php echo $address;?></h4>
                    <h5 class="marginright1 letter_title_three"><?php echo $ward_address;?></h5>
                    <div class="myspacer"></div>
                    <div class="printContent">
                        <div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
                        <div class="patrano">आर्थिक वर्ष : <?php echo convertedcit($fiscal->year); ?></div>
                        <div class="patrano"> योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?>	</div>
                       
                        <div class="myspacer"></div>
										
			<div class="banktextdetails1 ">
                            <div class="subject myFont1">योजना संझौता फाराम</div>
                                <div class="mycontent">
                     <table class="table-bordered myWidth100 myFont1">
                                        
                                      <tr>
                                            <td class="myWidth50 myTextalignRight">योजनाको नाम : </td><td><?php echo $data->program_name;?></td>
                                          </tr>
                                      <tr>
                                      <tr>
                                            <td class="myTextalignRight">आयोजना सचालन हुने स्थान / वार्ड नं :  </td><td> <?php echo SITE_LOCATION;?><?php echo convertedcit($data->ward_no);?></td>
                                          </tr>
                                      <tr>
                                                <td class="myTextalignRight">योजनाको बिषयगत क्षेत्रको नाम : </td><td><?php echo Topicarea::getName($data->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td class="myTextalignRight">योजनाको  शिर्षकगत नाम : </td><td><?php echo Topicareatype::getName($data->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td class="myTextalignRight">योजनाको  उपशिर्षकगत नाम : </td><td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                           <tr>
                                               <td class="myTextalignRight">योजनाको अनुदानको किसिम : </td><td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></td>
                                          </tr> 
                                          <tr>
                                               <td class="myTextalignRight">योजनाको विनियोजन किसिम : </td><td><?php echo Topicareainvestment::getName($data->topic_area_agreement_id); ?></td>
                                          </tr>
                                          
                                           
                                           
                                           <tr>
                                            <td class="myTextalignRight"> अनुदान रकम  : </td><td>रु. <?php echo convertedcit($data->investment_amount);?></td>
                                           </tr>
                       </table>
                     </div>
                                                <?php $data=Plantotalinvestment::find_by_plan_id($data->id);
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
                                                        <td class="myWidth50 myTextalignRight">भौतिक ईकाईको  परिणाम : </td><td><?=convertedcit($data->unit_total)?> <?=$unit->name?></td>
                                                      <tr>
                                                      <td class="myTextalignRight" ><?php echo SITE_TYPE;?>बाट अनुदान रकम : रु.  </td><td><?php echo convertedcit($data->agreement_gauplaika);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignRight">अन्य निकायबाट प्राप्त अनुदान रकम : </td><td>रु. <?php echo convertedcit($data->agreement_other);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignRight" >उपभोक्ताबाट नगद साझेदारी रकम : </td><td>रु. <?php echo convertedcit($data->costumer_agreement);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignRight">अन्य साझेदारी रकम : </td><td>रु. <?php echo convertedcit($data->other_agreement);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignRight">उपभोक्ताबाट जनश्रमदान रकम : </td><td>रु. <?php echo convertedcit($data->costumer_investment);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignRight">कुल लागत अनुमान जम्मा  रकम : </td><td>रु. <?php echo convertedcit($data->total_investment);?></td>
                                                    </tr>
                                                   
                                                  </table>
                                                </div>
                                                <?php } ?>
                                              <?php 
                                              $data2=Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                                              if(empty($data2)){?>
                                                  <div class="subject myFont1">उपभोक्ता समिति  सम्बन्धी विवरण भरिएको छैन </div>
                                             <?php
                                              }
                                              else
                                              {
                                              ?>
                                              <div class="subject myFont1">उपभोक्ता समिति  सम्बन्धी विवरण </div>
                                              <div class="mycontent">
                                                    <table class="table-bordered myWidth100 myFont1">
                                                        <?php 
                                                        $data3=Costumerassociationdetails::find_by_plan_id($_GET['id']);?>
                                                        <tr>
                                                            <td>योजनाको संचालन गर्ने उपभोक्ता समितिको नाम: <u><?php echo $data2->program_organizer_group_name;?> </u></td>
                                                            
                                                    </tr>
                                                    <tr>
                                                    <td>योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना: <u><?php echo SITE_NAME. convertedcit($data2->program_organizer_group_address);?></u></td>
                                                    </tr>
                                                    </table>
                                                    <table class="table-bordered myWidth100 myFont1">
                                                        <tr>
                                                            <th class="myCenter"><strong>सि.नं.</strong></th>
                                                            <th class="myCenter"><strong>पद</strong></th>
                                                            <th class="myCenter"><strong>नामथर</strong></th>
                                                            <th class="myCenter"><strong>ठेगाना</strong></th>
                                                            <th class="myCenter"><strong>लिगं</strong></th>
                                                            <th class="myCenter"><strong>नागरिकता नं</strong></th>
                                                            <th class="myCenter"><strong>जारी जिल्ला</strong></th>
                                                            <th class="myCenter"><strong>मोवायल नं</strong></th>
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
                                                            <td class="myCenter"><?php echo convertedcit($i);?></td>
                                                            <td class="myCenter"><?php echo Postname::getName($data->post_id);?> </td>
                                                            <td class="myCenter"><?php echo $data->name;?></td>
                                                            <td class="myCenter"><?php echo SITE_NAME.convertedcit($data->address);?></td>
                                                             <td class="myCenter"><?php echo $gender;?> </td>
                                                            <td class="myCenter"><?php echo convertedcit($data->cit_no);?></td>
                                                            <td class="myCenter"><?php echo $data->issued_district;?></td>
                                                            <td class="myCenter"><?php echo convertedcit($data->mobile_no);?></td>
                                                        </tr>
                                                        <?php $i++; endforeach;?>
                                                    </table>
                                                </div>
                                              <?php } ?>
                                               <?php $data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);
                                               if(empty($data4)){?>
                                              <div class="subject myFont1">अनुगमन समिति सम्बन्धी विवरण भरिएको छैन</div>
                                               <?php } else {?>
                                              <div class="subject myFont1">अनुगमन समिति सम्बन्धी विवरण</div>
                                              <div class="mycontent">
                                                    <table class="table-bordered myWidth100 myFont1">
                                                        <?php $data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);?>
                                                        <tr>
                                                            <td class="myCenter"><strong>सि. नं.</strong></th>
                                                            <td class="myCenter"><strong>पद</strong></td>
                                                            <td class="myCenter"><strong>नामथर</strong></td>
                                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                                            <td class="myCenter"><strong>लिगं</strong></td>
                                                            <td class="myCenter"><strong>मोवायल नं</strong></td>                                    
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
                                                            <td class="myCenter"><?php echo convertedcit($i);?></td>
                                                            <td class="myCenter"><?php echo Postname::getName($data->post_id);?></td>
                                                            <td class="myCenter"><?php echo $data->name;?></td>
                                                            <td class="myCenter"><?php echo SITE_NAME.convertedcit($data->address);?></td>
                                                             <td class="myCenter"><?php echo $gender;?> </td>
                                                            <td class="myCenter"><?php echo convertedcit($data->mobile_no);?></td>
                                                         </tr>
                                                         <?php $i++ ; endforeach; ?>
                                                    </table>
                                                </div>
                                              <?php }?>
                                              <?php $data= Moreplandetails::find_by_plan_id($_GET['id']); 
                                              if(empty($data)){?>
                                                <div class="subject myFont1">योजना सम्बन्धी अन्य विवरण भरिएको छैन</div>
                                              <?php }else{?>

                                              <div class="subject myFont1">योजना सम्बन्धी अन्य विवरण</div>
                                              
                                              <table class="table-bordered myWidth100 myFont1">
                                                      <?php $data= Moreplandetails::find_by_plan_id($_GET['id']); ?>
                                                      <tr>
                                                            <td class="myWidth50 myTextalignRight">उपभोक्ता समिति गठन भएको मिति : </td><td><?php echo convertedcit($data->samiti_gathan_date);?></td>
                                                          </tr>
                                                          <tr>
                                                            <td class="myTextalignRight">उपभोक्ता भेलामा उपस्थिति संख्या : </td><td><?php echo convertedcit($data->costumer_total_population);?></td>
                                                          </tr>
                                                          <tr>
                                                            <td class="myTextalignRight">योजना शुरु हुने मिति : </td><td><?php echo convertedcit($data->yojana_start_date);?></td>
                                                          </tr>
                                                          <tr>
                                                            <td class="myTextalignRight">योजना सम्पन्न हुने मिति : </td><td><?php echo convertedcit($data->yojana_sakine_date);?></td>
                                                          </tr>
                                                          
                                                   </table>
                                                   
                            	<div class="subject myFont1"> योजनाबाट लाभान्वित घरधुरी तथा परिबारको विबरण</div>
                              <table class="table-bordered myWidth100 myFont1">
                                    <tr>
                                     <td colspan="5" class="myCenter myFont1">लाभान्वित जनसंख्या</td>
                                    </tr>
                                    <tr>
                                        
                                            <td class="myCenter"><strong>घर परिवार संख्या</strong></td>
                                          <td class="myCenter">महिला</td>
                                          <td  class="myCenter">पुरुष</td>
                                          <td class="myCenter" >जम्मा</td>
                                        </tr>
                                        <?php $data= Profitablefamilydetails::find_by_type_id(0,$_GET['id']);?>
                                     <tr>
    
                                          <td class="myCenter"><?php echo convertedcit($data->pariwar_population);?></td>
                                         <td  class="myCenter"><?php echo convertedcit($data->female);?></td>
                                          <td class="myCenter"><?php echo convertedcit($data->male);?></td>
                                          <td class="myCenter"><?php echo convertedcit($data->total);?></td>
                                      </tr>
                              </table>
                                              <?php }?>
                              
                               <div class="" style="margin-left:5px;">
   <h4>सम्झौताका शर्तहरु</h4>
    <ul>
        <li>सम्झौतामा उल्लेख भएको म्याद भित्र उपभोक्ता समितिले योजना सम्पन्न गरिसक्नु पर्ने छ । कुनै कारणवश योजना सम्पन्न हुन नसकेमा सम्पन्न हुन नसक्नुको कारण सहित म्याद सकिने अबधि भन्दा ७ दिन अगाबै उपभोक्ता समितलिे सम्बन्धित स्थानिय तहमा निबेदन दिनु पर्नेछ ।निबेदन प्राप्त भएपछि औचित्यको आधारमा निर्णय गरी सम्झौताको म्याद थप गर्न सकिनेछ । यसरी म्याद थप नगरी भुक्तानी उपलब्ध हुने छैन ।</li>
        <li>योजनाको भुक्तानी स्थानीय तहले प्राबिधिक रनिङ बिलको आधारमा किस्ताको रुपमा वा काम सम्पन्न भएपछि उपभोक्ता समितिले खर्चको विवरण मुल समिति र अनुगमन समितिको बैठक बसी  आम्दानी खर्च  सार्बजनिक गरी अनुमोदन गरेपछि मात्र  उपलब्ध गराइने छ ।</li>
        <li>
        तोकिएको काम भन्दा कम काम गर्ने वा काम नै नगरी वा वास्तविक काम भन्दा बढी काम गरेको देखाई अथवा कुनै आइटमको सट्टा अर्को आइटमको कार्य पूरा गरेको देखाई लागत अनुमानभन्दा फरक काम गरी  रकम माग्ने उपभोक्ता समितिलाई उक्त रकम भुक्तानी नदिई कालो सूचीमा राखी  कारवाही गरिनेछ ।</li>
        <li>
        योजना संग सम्बन्धित प्राप्त नगद⁄जिन्सी उपभोक्ता समितिले सम्बन्धित योजनामा मात्र खर्च गर्नु पर्नेछ र प्राप्त नगद⁄जिन्सीको दुरुपयोग, हिनामिना वा हानी नोक्सानी गरेमा प्रचलित कानुन बमोजिम कारवाही हुनेछ ।</li>
        <li>
        उपभोक्ता समितिले काम सम्पन्न गरिसकेपछि बाँकि रहन गएका खप्ने सामानहरु मर्मत सम्भार समिति गठन भएको भए सो समितिलाई र सो नभए सम्बन्धित स्थानीय तहलाई बुझाउनु पर्नेछ । तर मर्मत सम्भार समितिलाई बुझाएको सामानको विवरणको एक प्रति सम्बन्धित <?php echo SITE_TYPE;?>मा बुझाउनु पर्नेछ ।</li>
        <li>
        उपभोक्ता समितिले योजनासंग सम्बन्धित विल भर्पाइहरु, डोर हाजिरी फारामहरु, जिन्सी नगदी खाताहरु,समितिको निर्णय पुस्तिका आदि कागजात <?php echo SITE_TYPE;?> वा अन्य सरोकारवाला पदाधिकारीले मागेको बखत उपलब्ध गराउनु पर्ने छ र त्यसको लेखा परीक्षण पनि गराउन सकिनेछ ।</li>
        <li>
        योजनाको सार्वजनिक परीक्षण, सुचना पाटी, आम्दानी खर्चको सार्वजनिकरण, तथा अन्य पारदर्शिता सम्बन्धी प्रावधानको पालना गर्नु पर्नेछ।</li>
        <li>
        उपभोक्ता समितिले कार्यदेश लिएर लामो समय सम्म योजना संचालन नगर्ने, योजनाको आय व्ययको विवरण दुरुस्त नराखी रकमको दुरुपयोग गरेमा सरकारी बाँकि सरह असुल उपर गरिने छ ।</li>
        <li>
        योजना सम्पन्न भएपछि स्थानीय तहबाट जाँच पास गरी फरफारकको प्रमाण पत्र लिनु पर्दछ ।साथै योजना हस्तान्तरण लिई आवश्यक मर्मत संभारको व्यवस्था सम्बन्धित उपभोक्ताहरुले नै गर्नु पर्नेछ।</li>
        <li>यस संझौतामा उल्लेख नभएका कुराहरु प्रचलित कानुन अनुसार हुनेछ।</li>
        <li>योजनाको लागि चाहिने आवश्यक कागजात यसै साथ संलग्न गरिएकोछ ।</li>
        <li>उपभोक्ता समितिको पदाधिकारीहरुको नागरिकताको प्रतिलिपि संलग्न गरेका छौ ।
    
        <?php  if(!empty($rules_result)):
        foreach($rules_result as $data):?>
    <li> <?=$data->rule?> </li>
        <?php  endforeach;endif;?>
</ul><!-- samjhauta list ends -->
 </div>
                                              <b>माथि उल्लेख भए बमोजिमका शर्तहरु पालना गर्न हामी निम्न पक्षहरु मन्जुर गर्दछौं ।</b>
                                              <div class="subject myFont1">उपभोक्ता समितिको तर्फबाट </div>
                                              <div class="mycontent ">
                                              	<table class="table-bordered myWidth100 myFont1">
                                              	<tr>
                                                	<td class="myWidth25 myCenter">सि. नं</td>
                                                    <td class="myWidth25 myCenter">पद</td>
                                                    <td class="myWidth25 myCenter">नाम/थर</td>
                                                    <td class="myWidth25 myCenter">दस्तखत</td>
                                                </tr>
                                                 <?php 
                                               $data1=Costumerassociationdetails::find_by_post_plan_id(1,$_GET['id']);
                                                $data2=Costumerassociationdetails::find_by_post_plan_id(3,$_GET['id']);
                                                $data3=Costumerassociationdetails::find_by_post_plan_id(4,$_GET['id'])
                                              ?>
                                               
                                                <tr>
                                                    <td class="myCenter"><?php echo convertedcit(1);?></td>
                                                    <td class="myCenter"><?php echo Postname::getName(1);?></td>
                                                    <td class="myCenter"><?php echo $data1->name;?></td>
                                                    <td class="myCenter myHeight20">&nbsp;</td>                                                    
                                                </tr>
                                                <tr>
                                                    <td class="myCenter"><?php echo convertedcit(2);?></td>
                                                    <td class="myCenter"><?php echo Postname::getName(3);?></td>
                                                    <td class="myCenter"><?php echo $data2->name;?></td>
                                                    <td class="myHeight20 myCenter">&nbsp;</td>   
                                                </tr>
                                                <td class="myCenter"><?php echo convertedcit(3);?></td>
                                                <td class="myCenter"><?php echo Postname::getName(4);?></td>
                                                    <td class="myCenter"><?php echo $data3->name;?></td>
                                                    <td class="myHeight20 myCenter">&nbsp;</td>   
                                                
                                             
                                              </table>
                                              </div><!-- upabhokta ends -->
                                              <div class="subject myFont1">स्थानीय तहको तर्फबाट</div>
                                              <div class="mycontent">
                                              	<table class="table-bordered myWidth100 myFont1">
                                                	<tr>
                                                    	<td class="myWidth25 myCenter">सि.नं</td>
                                                        <td class="myWidth25 myCenter">पद</td>
                                                        <td class="myWidth25 myCenter">नामथर</td>
                                                        <td class="myWidth25 myCenter">दस्तखत</td>
                                                    </tr>
                                                    <tr>
                                                    	<td class="myCenter">१</td>
                                                        <td class="myCenter"><?php echo $worker->post_id_3;?></td>
                                                       <td class="myCenter"><?php echo Workerdetails::getName($worker->samjhauta_party);?></td>
                                                         <td class="myHeight20">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                    	<td colspan="2" class="myTextalignRight">मिति :</td>
                                                        <td colspan="2"><?php echo convertedcit($date_selected); ?></td>
                                                    </tr>
                                                </table>
                                              </div>
                                              
											
										</div><!-- bank details ends -->
										<div class="myspacer"></div>
										
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->
