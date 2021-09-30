<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$program_id= $_GET['id'];	
 $sn_result= Programmoredetails::find_by_program_id($_GET['id']);	
$datas=Costumerassociationdetails::find_by_plan_id($_GET['id']);
//        print_r($datas);exit;
	$worker=Moreplandetails::find_by_plan_id($_GET['id']);
	
	$rules_result = Rule::find_by_plan_id($_GET['id']);
	
	?>
   <?php $data1=  Plandetails1::find_by_id($_GET['id']);?>
<?php $data=  Plandetails1::find_by_id($_GET['id']);

       $fiscal = FiscalYear::find_by_id($data->fiscal_id);
  if(isset($_POST['submit']))
  {
      $sn= $_POST['sn'];
      $program_more_details= Programmoredetails::find_by_program_id_and_sn($program_id, $sn);
       if($program_more_details->type_id == 5)
                       {
                           $u_samiti = Upabhoktasamitiprofile::find_by_id($program_more_details->enlist_id);
                        //   print_r($u_samiti);exit;
                            $name= $u_samiti->program_organizer_group_name;
                            $address1 = SITE_LOCATION.', वडा न: '.convertedcit($u_samiti->program_organizer_group_address);
                            $details7= Upabhoktasamitidetails::find_adakshya($u_samiti->id);
                            $number1 = convertedcit($details7->mobile_no);
                       }
                       else
                       {
                             $name =Enlist::getName1($program_more_details->enlist_id);  
                             $address1 = Enlist::getAddress($program_more_details->enlist_id);
                             $number1=  convertedcit(Enlist::getNumber($program_more_details->enlist_id));
                       }   
      //print_r($program_more_details);exit;
      if(!empty($program_more_details->worker_id))
      {
      $worker= Workerdetails::find_by_id($program_more_details->worker_id);
      $worker_name= $worker->authority_name;
      $worker_post= $worker->post_name;
      }
      else
      {
       $worker_name="";
       $worker_post="";
      }
     // $program_payment= Programpayment::find_by_program_id_and_sn($program_id, $sn);
     // $program_payment_final= Programpaymentfinal::find_by_program_id_and_sn($program_id, $sn);
      if ($program_more_details->type_id == '0')
            {
            $organizer = "फर्म/कम्पनी";

            } 
        elseif ($program_more_details->type_id == '1') 
            {
            $organizer = "कर्मचारी";
            } 
        elseif ($program_more_details->type_id == '2') 
            {
            $organizer = "संस्था";
            }
        elseif ($program_more_details->type_id =='3') 
        {
            $organizer ="पदाधिकारी";
        }
        elseif( $program_more_details->type_id =='4')
        {
            $organizer ="अन्य समूह";
        } 
        else
         {
           $organizer = "उपभोक्ता समिति";   
        }
        $enlist= Enlist::find_by_id($program_more_details->enlist_id);
             
  }    
   ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">कार्यक्रम संझौता फाराम || <a href="letters_select_programs.php" class="btn">पछी जानुहोस </a></h2>
                    <div class="OurContentFull">
      <form method="post">
                           <table class="table table-bordered">
                                            <tr>
                                            <td>कार्यदेश नं:</td>
                                            <td>
                                                 <select class="sn1" name="sn">
                                                    <option value="">--छान्नुहोस्--</option>
                                                    <?php foreach($sn_result as $sn):?>
                                                    <option value="<?= $sn->sn ?>"><?= $sn->sn ?></option>
                                                    <?php endforeach;?>
                                                    <input type="hidden" value="<?= $program_id ?>" id="program_id1">
                                                </select>   
                                            </td>
                                            </tr>
                                            <tr class="enlist2">
                                                
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <input type="submit" value="खोज्नुहोस" name="submit" class="btn"/>
                                                </td>
                                            </tr>
                                        </table>                           
                        </form>                   
  <?php if(!empty($program_more_details)): ?>    
   	              
                    	<h2>कार्यक्रम संझौता फाराम</h2>
                        <form method="get" action="print_karyadesh_report_13_final.php?id=<?=$_GET['id']?>" target="_blank" >
                            <div class="myPrint"><input type="hidden" name="id" value="<?=$program_id?>" />
                            <input type="hidden" name="detail_id" value="<?=$program_more_details->id?>" />
                            <input type="hidden" name="sn" value="<?= $_POST['sn']?>" />
                            <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                        <div class="userprofiletable">
                        	<div class="printPage">
                       
                                    
									<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
												<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
												<h5 class="margin1em letter_title_three"><?php echo $ward_address;?></h5>
									<div class="myspacer"></div>
									<div class="printContent">
                                            <div class="mydate">मिति : <input type="text" name="date_selected" value="<?php echo generateCurrDate(); ?>" id="nepaliDate5" /></form></div>
                                        <div class="patrano">आर्थिक वर्ष : <?php echo convertedcit($fiscal->year); ?></div>
										<div class="patrano"> योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?>	</div>
                                       
                                        <div class="myspacer"></div>
										
										<div class="banktextdetails1">
                                        	<h4>कार्यक्रम संझौता फाराम</h4>
                                              <div class="mycontent" >
                     <table class="table table-bordered table-responsive">
                                        
                                      <tr>
                                            <td class="myWidth50">कार्यक्रमको नाम</td>
                                            <td><?php echo $data->program_name;?></td>
                                          </tr>
                                      <tr>
                                      <tr>
                                            <td>कार्यक्रमको बिषयगत क्षेत्रको नाम</td>
                                            <td><?php echo SITE_LOCATION;?>- <?php echo convertedcit($data->ward_no);?></td>
                                          </tr>
                                     
                                           <tr>
                                               <td>कार्यक्रमको  शिर्षकगत नाम </td>
                                               <td><?php echo Topicareatype::getName($data->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>कार्यक्रमको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                           <tr>
                                               <td>कार्यक्रमको अनुदानको किसिम</td>
                                               <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></td>
                                          </tr> 
                                          <tr>
                                               <td>कार्यक्रमको विनियोजन किसिम</td>
                                               <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id); ?></td>
                                          </tr>
                                          <tr>
                                            <td>अनुदान रु</td>
                                            <td>रु. <?php echo convertedcit($data->investment_amount);?></td>
                                          </tr>
                       </table>
                     </div>
                                               
                                              <h4> कार्यक्रमको कार्यादेश सम्बन्धी विवरण </h4>
                                              <div class="mycontent" >
                                                  <table class="table table-bordered table-responsive">
                                                     <tr>
                                                        <td class="myWidth50">कार्यादेस न</td>
                                                        <td><?=convertedcit($program_more_details->sn)?> </td>
                                                      <tr>
                                                      <tr>
			     <td>कार्यदेशको नाम :</td>
			     <td><?php echo  convertedcit($program_more_details->work_name);?></td>
			</tr>
                                                      <td scope="row">कार्यादेश दिने निर्णय भएको मिति</td>
                                                      <td><?php echo convertedcit($program_more_details->work_order_date);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td scope="row">कार्यादेश दिईएको रकम रु</td>
                                                      <td>रु. <?php echo convertedcit(placeholder($program_more_details->work_order_budget));?></td>
                                                    </tr>
                                                    <tr>
                                                      <td scope="row">कार्यक्रम संचालन हुने स्थान</td>
                                                      <td> <?php echo $program_more_details->venue;?></td>
                                                    </tr>
                                                    <tr>
                                                      <td scope="row">कार्यक्रमको संचालन गर्ने</td>
                                                      <td> <?php echo $organizer ;?></td>
                                                    </tr>
                                                    <tr>
                                                      <td scope="row">नाम</td>
                                                      <td> <?php echo $name ;?></td>
                                                    </tr>
                                                    <tr>
                                                      <td scope="row">ठेगाना </td>
                                                      <td><?php echo $address1; ?></td>
                                                    </tr>
                                                    <tr>
                                                      <td scope="row">सम्पर्क नं</td>
                                                      <td> <?php echo $number1;?></td>
                                                    </tr>
                                                   
                                                  </table>
                                                    <h3 > कार्यक्रमबाट लाभान्वित घरधुरी तथा परिबारको विबरण</h3>
                          <table class="table table-bordered table-responsive">
                                <tr>
                                 <td colspan="5" style="text-align:center">लाभान्वित जनसंख्या</td>
                                </tr>
                                <tr>
                                	
                                        <th class="text-center">घर परिवार संख्या</th>
                                      <th class="text-center">महिला</th>
                                      <th class="text-center">पुरुष</th>
                                      <th class="text-center">जम्मा</th>
                                    </tr>
                                   
                                 <tr>

                                      <td><?php echo convertedcit($program_more_details->total_family_members);?></td>
                                     <td ><?php echo convertedcit($program_more_details->female);?></td>
                                      <td><?php echo convertedcit($program_more_details->male);?></td>
                                      <td><?php echo convertedcit($program_more_details->total_members);?></td>
                                  </tr>
                          </table>
                                                </div>
                                               
                                            
                             </div>
                            </div><!-- yojana ends -->
                            				  <h4>सम्झौताका शर्तहरु</h4>
                                              <ul>
                                                 <li>१. कार्यक्रम मिति <?= convertedcit($program_more_details->start_date) ?> देखि शुरु गरी मिति <?= convertedcit($program_more_details->completion_date) ?> सम्ममा पुरा गर्नु पर्नेछ ।</li>
                                                 <li>२. कार्यक्रमा प्राप्त रकम  सम्वन्धित कार्यक्रमको उदेश्यका लागि मात्र प्रयोग गर्नुपर्नेछ ।</li>
        <li>
       ३. नगदी, जिन्सी सामानको प्राप्ती, खर्च र बाँकी तथा कार्यक्रमको प्रगति विवरण राख्नु पर्नेछ ।</li>
        <li>
       ४. आम्दानी खर्चको विवरण र कार्यप्रगतिको विवरण पेश गरी अर्को किस्ता माग गर्नु पर्नेछ ।</li>
        <li>
       ५. कुनै सामाग्री खरिद गर्दा आन्तरिक राजस्व कार्यालयबाट स्थायी लेखा नम्वर र मुल्य अभिबृद्धि कर दर्ता प्रमाण पत्र प्राप्त व्यक्ति वा फर्म संस्था वा कम्पनीबाट खरिद गरी सोही अनुसारको विल भरपाई आधिकारीक व्यक्तिबाट प्रमाणित गरी पेश गर्नु पर्नेछ ।</li>
        <li>
        ६. मूल्य अभिबृद्धि कर (VAT)लाग्ने बस्तु तथा सेवा खरिद गर्दा रु २०,०००।– भन्दा बढी मूल्यको सामाग्रीमा अनिवार्य रुपमा मूल्य अभिबृद्धि करदर्ता प्रमाणपत्र प्राप्त गरेका व्यक्ति फर्म संस्था वा कम्पनीबाट खरिद गर्नु पर्नेछ । साथै उक्त विलमा उल्लिखित    मु.अ.कर बाहेकको रकममा १.५%अग्रीम आयकर बापत करकट्टि गरी बाँकी रकम मात्र सम्वन्धित सेवा प्रदायकलाई भुक्तानी हुनेछ । रु २०,०००।– भन्दा कम मूल्यको सामाग्री खरिदमा पान नम्वर लिएको व्यक्ति वा फर्मबाट खरिद गर्नु पर्नेछ । अन्यथा खरिद गर्ने पदाधिकारी स्वयम् जिम्मेवार हुनेछ ।</li>
        <li>
       ७. कार्यक्रम संचालनमा आबश्यक सामानहरु भाडामा लिएको एवम् घर बहालमा लिई विल भरपाई पेश भएको अवस्थामा १०% प्रतिशत घर भाडा कर एबम् बहाल कर तिर्नु पर्नेछ ।</li>
        <li>
       ८. प्रशिक्षकले पाउने पारिश्रमिक एवम् सहभागीले पाउने भत्तामा प्रचलित नियमानुसार कर लाग्नेछ ।</li>
        <li>
      ९. कार्यक्रमको बजेटबाट खरिद गरिएका खप्ने सामानहरु कार्यक्रम सम्पन्न गरिसकेपछि सम्वन्धित कार्यालयलाई बुझाउनु पर्नेछ ।</li>
        <li>१०. सम्झौता बमोजिम कार्यक्रम सम्पन्न भएपछि अन्तिम भुक्तानीको लागि कार्यक्रमको सम्पन्न प्रतिवेदन, प्रमाणित विल भरपाई, कार्यक्रमको फोटो, सार्वजनिक लेखा परीक्षणको निर्णयको प्रतिलिपी तथा सम्वन्धित कार्यालयको वडा कार्यालयको सिफारिस सहित अन्तिम किस्ता भुक्तानीको लागि निवेदन पेश गर्नु पर्नेछ ।</li>
        <li>११  पेश्की लिएर लामो समयसम्म कार्यक्रम संचालन नभएमा कार्यालयले नियम अनुसार कारवाही गर्नेछ ।</li>
        <li>१२. यस संझौतामा उल्लेख नभएका कुराहरु प्रचलित कानून वमोजिम हुनेछ ।
        
        </li>
        <?php $li = 13; if(!empty($rules_result)):
        foreach($rules_result as $data):?>
    <li> <?= convertedcit($li). ". " .$data->rule?> </li>
        <?php  $li++; endforeach;endif;?>
                                              </ul><br><!-- samjhauta list ends -->
                                              <h4>माथि उल्लेख भए बमोजिमका शर्तहरु पालना गर्न हामी निम्न पक्षहरु मन्जुर गर्दछौं ।</h4>
                                              <h4>कार्यक्रम संचालकको तर्फबाट </h4>
                                              <div class="mycontent">
                                              	<table class="table table-bordered table-responsive">
                                                    <tr><th class="myWidth25 text-center">कार्यक्रमको संचालन गर्ने</th><td><?php echo $organizer;?></td></tr>
                                                    <tr><th class="myWidth25 text-center">नाम</th><td><?php echo $name;?></td> </tr>
                                                    <tr><th class="myWidth25 text-center">ठेगाना</th><td><?php echo $address1;?></td> </tr>
                                                    <tr> <th class="myWidth25 text-center">दस्तखत</th><td>&nbsp;</td></tr>
                                                    <tr><th class="myWidth25 text-center">मिति</th><td><?php echo convertedcit(generateCurrDate());?></td> 
                                                </tr>
                                                 
                                               
                                                <tr>
                                                   
                                                   
                                                    
                                                    
                                                    
                                                </tr>
                                              
                                                
                                                
                                             
                                                                                              </table>
                                              </div><!-- upabhokta ends -->
                                              <h4>स्थानीय तहको तर्फबाट</h4>
                                              <div class="mycontent">
                                              	<table class="table table-bordered table-responsive">
                                                    <tr><th class="myWidth25 text-center">पद</th><td><?php echo $worker_post;?></td></tr>
                                                    <tr> <th class="myWidth25 text-center">नामथर</th><td><?= $worker_name ?></td></tr>
                                                    <tr><th class="myWidth25 text-center">दस्तखत</th><td>&nbsp;</td></tr>
                                                    <tr><th class="mywidth25 text-center">मिति</th>
                                                        <td ><?php echo convertedcit(generateCurrDate()); ?></td>
                                                    </tr>
                                                </table>
                                              </div>
     <?php endif; ?>
                                              
											
										</div><!-- bank details ends -->
										<div class="myspacer"></div>
										
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>