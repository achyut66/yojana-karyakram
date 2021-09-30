<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}	$ward_address=WardWiseAddress();
	$address= getAddress();
	$datas=Costumerassociationdetails::find_by_plan_id($_GET['id']);
//        print_r($datas);exit;
	$worker=Moreplandetails::find_by_plan_id($_GET['id']);
	$rules_result = Rule::find_by_plan_id($_GET['id']);
	$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
$workers = Workerdetails::find_all();
if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
    $worker5 = Workerdetails::find_by_id($print_history->worker5);
}
else
{
    $print_history = PrintHistory::setEmptyObject();
    if(empty($worker1))
    {
        $worker1 = Workerdetails::setEmptyObject();
    }
    if(empty($worker2))
    {
        $worker2 = Workerdetails::setEmptyObject();
    }
    if(empty($worker3))
    {
        $worker3 = Workerdetails::setEmptyObject();
    }
    if(empty($worker4))
    {
        $worker4 = Workerdetails::setEmptyObject();
    }
     if(empty($worker5))
    {
        $worker5 = Workerdetails::setEmptyObject();
    }
}
$date = !empty($print_history)? $print_history->nepali_date : generateCurrDate();
	?>
   <?php $data1=  Plandetails1::find_by_id($_GET['id']);?>
                     <?php $data=  Plandetails1::find_by_id($_GET['id']);
                            $fiscal = FiscalYear::find_by_id($data->fiscal_id);
                        ?>
                        <?php $profitable_family= Profitablefamilydetails::find_by_plan_id($_GET['id']); 
                        $group_heading = Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                        $more_plan_details = Moreplandetails::find_by_plan_id($_GET['id']); print_r($more_plan_details);
$result = Plantotalinvestment::find_by_plan_id($_GET['id']);
                        ?>
<?php include("menuincludes/header.php"); ?>
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
                          input {
                              background-color: #eee;
                          }

                          tr:nth-child(even) {background-color: #f2f2f2;}
                          tr:hover {background-color:#f5f5f5;}
                        </style>
</head>
<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
                <div class="maincontent">
                    <form method="get" action="print_bank_report02_final.php?>">
                    <h2 class="headinguserprofile">योजना संझौता फाराम | <a href="letters_select.php" class="btn">पछि जानुहोस </a>

                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>

                    </h2>
                    <div class="OurContentFull">
                    	                        <!--<div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट" name="submit" /></div>-->
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
                                         <div class="mydate">
                                         <input type="text" name="date_selected" value="<?php echo convertedcit($more_plan_details->miti); ?>" id="nepaliDate5" /></form></div>
                                        <div class="patrano">आर्थिक वर्ष : <?php echo convertedcit($fiscal->year); ?></div>
										<div class="patrano"> योजना दर्ता नं : <?php echo convertedcit($_GET['id']) ?>	</div>
										<div class="banktextdetails1">
                                            <div class="subject" border="none">
                                                <u>बिषय :- <label style="margin-left: 5px;">
                                                        <input type="text" style="border:none" class="no-outline" name="subject" value="योजना सम्झौता पत्र"/></label></u>
                                            </div>
                                              <div class="mycontent" >
                                        <table class="table table-bordered table-responsive">
                                      <tr>
                                            <td class="myWidth50 myTextalignLeft ">योजनाको नाम :</td>
                                            <td><?php echo $data->program_name;?></td>
                                          </tr>

                                            <tr>
                                                <td class="myWidth50 myTextLeft">बिनियोजन श्रोत र ब्याख्या :</td>
                                                <td><?php echo $data1->parishad_sno;?></td>
                                            </tr>

                                      <tr>
                                      <tr>
                                            <td class="myTextalignLeft">आयोजना सचालन हुने स्थान / वार्ड नं :</td>
                                            <td><?php echo SITE_LOCATION;?>-<?php echo convertedcit($group_heading->program_organizer_group_address);?></td>
                                          </tr>
                                      <tr>
                                                <td class="myTextalignLeft">योजनाको बिषयगत क्षेत्रको नाम :</td>
                                                <td><?php echo Topicarea::getName($data->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td class="myTextalignLeft">योजनाको  शिर्षकगत नाम </td>
                                               <td ><?php echo Topicareatype::getName($data->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td class="myTextalignLeft">योजनाको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                           <tr>
                                               <td class="myTextalignLeft">योजनाको अनुदानको किसिम</td>
                                               <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></td>
                                          </tr> 
                                          <tr>
                                               <td class="myTextalignLeft">योजनाको विनियोजन किसिम</td>
                                               <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id); ?></td>
                                          </tr>
                                           <tr>
                                            <td class="myTextalignLeft">अनुदान रु</td>
                                            <td>रु. <?php echo convertedcit($data->investment_amount);?></td>
                                           </tr>
                                           </table>
                                         </div>
                                                <?php $data=Plantotalinvestment::find_by_plan_id($data->id);
                                                if(empty($data))
                                                {?>
                                                  <h4> योजनाको कुल लागत अनुमान भरिएको छैन</h4>
                                                  
                                                <?php exit; }
                                                else
                                                {
                                                ?>
                                              <h4> योजनाको कुल लागत अनुमान </h4>
                                              <div class="mycontent" >
                                                  <table class="table table-bordered table-responsive">
                                                     <tr>
                                                        <td class="myWidth50 myTextalignLeft">भौतिक ईकाईको  परिणाम</td>
                                                        <td><?=convertedcit($data->unit_total)?> <?=$unit->name?></td>
                                                      <tr>
                                                          <?php
                                                          $con = Contingency::find_by_sql("select * from contingency where type=1");
                                                          foreach($con as $con):
                                                          endforeach;
                                                          //print_r($con);
                                                          $cont = ($result->agreement_gauplaika) * $con->amount;
                                                          //print_r($cont);
                                                          ?>
                                                      <tr>
                                                          <td class="myTextalignLeft">कन्टेन्जेन्सी
                                                              (<?php echo convertedcit($con->percent)?>)%
                                                          </td>
                                                          <td>रु. <?php echo convertedcit($cont);?></td>
                                                      </tr>
                                                      <tr>
                                                          <td class="myTextalignLeft">मर्मत
                                                              (<?php echo convertedcit($result->marmat_old)?>%)</td>
                                                          <td>रु. <?php echo convertedcit($result->marmat_new);?></td>
                                                      </tr>
                                                      <td class="myTextalignLeft"><?php echo SITE_TYPE;?>बाट अनुदान</td>
                                                      <td>रु.  <?php echo convertedcit($data->agreement_gauplaika);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignLeft">अन्य निकायबाट प्राप्त अनुदान</td>
                                                      <td>रु. <?php echo convertedcit($data->agreement_other);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignLeft">उपभोक्ताबाट नगद साझेदारी</td>
                                                      <td>रु. <?php echo convertedcit($data->costumer_agreement);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignLeft">अन्य साझेदारी</td>
                                                      <td>रु. <?php echo convertedcit($data->other_agreement);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignLeft">उपभोक्ताबाट जनश्रमदान</td>
                                                      <td>रु. <?php echo convertedcit($data->costumer_investment);?></td>
                                                    </tr>
                                                    <tr>
                                                      <td class="myTextalignLeft">कुल लागत अनुमान जम्मा </td>
                                                      <td>रु. <?php echo convertedcit($data->total_investment);?></td>
                                                    </tr>
                                                   
                                                  </table>
                                                </div>
                                                <?php } ?>
                                              <?php 
                                              $data2=Costumerassociationdetails0::find_by_plan_id($_GET['id']);
                                              if(empty($data2)){?>
                                                  <h4>उपभोक्ता समिति  सम्बन्धी विवरण भरिएको छैन </h4>
                                             <?php
                                              }
                                              else
                                              {
                                              ?>
                                              <p style="text-align:center;font-size:18;">भौतिक परिमाणको शिर्षक</p>
                                              <table class="table table-bordered table-responsive">
                                                  <th>सी.नं</th>
                                                  <th>परिमाणको शिर्षक</th>
                                                  <th>परिमाण</th>
                                                  <th>भौतिक इकाई</th>
                                                  <?php 
                                                  $b_l = Bhautik_lakshya::find_by_plan_id_and_type($_GET['id'],1);//print_r($b_l);
                                                  $i = 1; foreach($b_l as $b_l):
                                                  //print_r($b_l);  
                                                  ?>
                                                  <tr>
                                                      <td><?php echo convertedcit($i);?></td>
                                                      <td><?php echo SettingbhautikPariman::getName($b_l->details_id);?></td>
                                                      <td><?php echo convertedcit($b_l->qty);?></td>
                                                      <td><?php echo Units::getName($b_l->details_id);?></td>
                                                  </tr>
                                                  <?php $i++;endforeach;?>
                                              </table>
                                              <h4>उपभोक्ता समिति  सम्बन्धी विवरण </h4>
                                              <div class="mycontent">
                                                    <table class="table table-bordered table-responsive">
                                                        <?php 
                                                        $data3=Costumerassociationdetails::find_by_plan_id($_GET['id']);?>
                                                        <tr>
                                                            <td> योजनाको संचालन गर्ने उपभोक्ता समितिको नाम:<u><?php echo $data2->program_organizer_group_name;?> </u></td>  
</tr> 
                                                            
<tr>
<td>योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना: <u> <?php echo SITE_NAME. convertedcit($data2->program_organizer_group_address);?></u></td>
                                                    </tr>
                                                    </table>
                                                    <table class="table table-bordered table-responsive">
                                                        <tr>
                                                            <td class="myCenter">सि.नं.</td>
                                                            <td class="myCenter">पद</td>
                                                            <td class="myCenter">नामथर</td>
                                                            <td class="myCenter">ठेगाना</td>
                                                            <td class="myCenter">लिगं</td>
                                                            <td class="myCenter">नागरिकता नं</td>
                                                            <td class="myCenter">जारी जिल्ला</td>
                                                            <td class="myCenter">मोबाइल नं</td>
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
                                                            <td ><?php echo convertedcit($i);?></td>
                                                            <td><?php echo Postname::getName($data->post_id);?> </td>
                                                            <td><?php echo $data->name;?></td>
                                                            <td><?php echo SITE_NAME?> <?php echo convertedcit($data->address);?></td>
                                                             <td><?php echo $gender;?> </td>
                                                            <td><?php echo convertedcit($data->cit_no);?></td>
                                                            <td><?php echo $data->issued_district;?></td>
                                                            <td><?php echo convertedcit($data->mobile_no);?></td>
                                                        </tr>
                                                        <?php $i++; endforeach;?>
                                                    </table>
                                                </div>
                                              <?php } ?>
                                               <?php $data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);
                                               if(empty($data4)){?>
                                              <h4>अनुगमन समिति सम्बन्धी विवरण भरिएको छैन</h4>
                                               <?php } else {?>
                                              <h4>अनुगमन समिति सम्बन्धी विवरण</h4>
                                              <div class="mycontent">
                                                    <table class="table table-bordered table-responsive">
                                                        <?php $data4=  Investigationassociationdetails::find_by_plan_id($_GET['id']);
                                                        $data5 = Anugamansamitibibaran
                                                        ?>
                                                        <tr>
                                                            <td class="myCenter" ><strong>सि.नं</strong>.</td>
                                                            <td class="myCenter"><strong>पद</strong></td>
                                                            <td class="myCenter"><strong>नामथर</strong></td>
                                                            <td class="myCenter"><strong>ठेगाना</strong></td>
                                                            <td class="myCenter"><strong>पदनाम</strong></td>
                                                            <td class="myCenter"><strong>लिगं</strong></td>
                                                            <td class="myCenter"><strong>मोबाइल नं</strong></td>                                    
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
                                                            <td class="myCenter"><?php echo $data->post_name;?></td>
                                                             <td class="myCenter"><?php echo $gender;?> </td>
                                                            <td class="myCenter"><?php echo convertedcit($data->mobile_no);?></td>
                                                         </tr>
                                                         <?php endforeach; ?>
                                                    </table>
                                                </div>
                                              <?php }?>
                                              <?php $data= Moreplandetails::find_by_plan_id($_GET['id']); 
                                              if(empty($data)){?>
                                                <h4 >योजना सम्बन्धी अन्य विवरण भरिएको छैन</h4>
                                              <?php }else{?>
                                              <h4 >योजना सम्बन्धी अन्य विवरण</h4>
                                              <div class="mycontent">
                                                  <table class="table table-bordered table-responsive">
                                                      <?php $data= Moreplandetails::find_by_plan_id($_GET['id']); ?>
                                                      <tr>
                                                            <td class=" myWidth50 myTextalignLeft">उपभोक्ता समिति गठन भएको मिति</td>
                                                            <td ><?php echo convertedcit($data->samiti_gathan_date);?></td>
                                                          </tr>
                                                          <tr>
                                                            <td class="myTextalignLeft">उपभोक्ता भेलामा उपस्थिति संख्या</td>
                                                            <td><?php echo convertedcit($data->costumer_total_population);?></td>
                                                          </tr>
                                                          <tr>
                                                            <td class="myTextalignLeft">योजना शुरु हुने मिति</td>
                                                            <td><?php echo convertedcit($data->yojana_start_date);?></td>
                                                          </tr>
                                                          <tr>
                                                            <td class="myTextalignLeft">योजना सम्पन्न हुने मिति</td>
                                                            <td><?php echo convertedcit($data->yojana_sakine_date);?></td>
                                                          </tr>
                                                       </table>
                                                   </div>
                            <h3> योजनाबाट लाभान्वित घरधुरी तथा परिवारको विवरण </h3>
                            	<table class="table table-bordered table-hover table-responsive">
                       <tr>
                        <td colspan="11" class="myCenter">लाभान्वित जनसंख्या</td>
                      </tr>
                      <tr>
                        <td class="myCenter" colspan="2">घर परिवार संख्या</td>
                        <td class="myCenter">महिला</td>
                        <td class="myCenter">पुरुष</td>
                        <td class="myCenter">जम्मा</td>
                      </tr>
                      <tr>
                        <td>दलित</td>
                        <input type ="hidden" value="<?php echo $profitable_family->id?>" name="profit_family_id">
                        <td><?php echo convertedcit($profitable_family->dalit_ghar);?></td>
                        <td><?php echo convertedcit($profitable_family->dalit_mahila);?></td>
                        <td><?php echo convertedcit($profitable_family->dalit_purush);?></td>
                        <td><?php echo convertedcit($profitable_family->total);?></td>
                      </tr>
                      <tr>
                        <td>आदीबासी जनजाती</td>
                        <td><?php echo convertedcit($profitable_family->aadhibasi_ghar);?></td>
                        <td><?php echo convertedcit($profitable_family->aadhibasi_mahila);?></td>
                        <td><?php echo convertedcit($profitable_family->aadhibasi_purush);?></td>
                        <td><?php echo convertedcit($profitable_family->total1);?></td>
                      </tr>
                      <tr>
                        <td>अन्य घर परिबार</td>
                        <td><?php echo convertedcit($profitable_family->anya_ghar);?></td>
                        <td><?php echo convertedcit($profitable_family->anya_mahila);?></td>
                        <td><?php echo convertedcit($profitable_family->anya_purush);?></td>
                        <td><?php echo convertedcit($profitable_family->total2);?></td>
                      </tr>
                      <tr>
                        <td>कुल जम्मा </td>
                        <td><?php echo convertedcit($profitable_family->kul1);?></td>
                        <td><?php echo convertedcit($profitable_family->kul2);?></td>
                        <td><?php echo convertedcit($profitable_family->kul3);?></td>
                        <td><?php echo convertedcit($profitable_family->total6);?></td>
                      </tr>
                     </table>
                <?php }?>
                             </div>
                            </div><!-- yojana ends -->
<div class="" style="margin-left:15px; ">
   <h4><u>उपभोक्ता समितिको जिम्मेवारी तथा पालना गरिने शर्तहरु:</u></h4>

        <span>१). सम्झौतामा उल्लेख भएको म्याद भित्र उपभोक्ता समितिले योजना सम्पन्न गरिसक्नु पर्ने छ । कुनै कारणवश योजना सम्पन्न हुन नसकेमा सम्पन्न हुन नसक्नुको कारण सहित म्याद सकिने अबधि भन्दा ७ दिन अगाबै उपभोक्ता समितलिे सम्बन्धित स्थानिय तहमा निबेदन दिनु पर्नेछ ।निबेदन प्राप्त भएपछि औचित्यको आधारमा निर्णय गरी सम्झौताको म्याद थप गर्न सकिनेछ । यसरी म्याद थप नगरी भुक्तानी उपलब्ध हुने छैन ।</li>
        <br><span>२). योजनाको भुक्तानी स्थानीय तहले प्राबिधिक रनिङ बिलको आधारमा किस्ताको रुपमा वा काम सम्पन्न भएपछि उपभोक्ता समितिले खर्चको विवरण मुल समिति र अनुगमन समितिको बैठक बसी  आम्दानी खर्च  सार्बजनिक गरी अनुमोदन गरेपछि मात्र  उपलब्ध गराइने छ ।</li>
        <br><span>
        ३). तोकिएको काम भन्दा कम काम गर्ने वा काम नै नगरी वा वास्तविक काम भन्दा बढी काम गरेको देखाई अथवा कुनै आइटमको सट्टा अर्को आइटमको कार्य पूरा गरेको देखाई लागत अनुमानभन्दा फरक काम गरी  रकम माग्ने उपभोक्ता समितिलाई उक्त रकम भुक्तानी नदिई कालो सूचीमा राखी  कारवाही गरिनेछ ।</li>
        <br><span>
        ४). योजना संग सम्बन्धित प्राप्त नगद⁄जिन्सी उपभोक्ता समितिले सम्बन्धित योजनामा मात्र खर्च गर्नु पर्नेछ र प्राप्त नगद⁄जिन्सीको दुरुपयोग, हिनामिना वा हानी नोक्सानी गरेमा प्रचलित कानुन बमोजिम कारवाही हुनेछ ।</li>
        <br><span>
        ५). उपभोक्ता समितिले काम सम्पन्न गरिसकेपछि बाँकि रहन गएका खप्ने सामानहरु मर्मत सम्भार समिति गठन भएको भए सो समितिलाई र सो नभए सम्बन्धित स्थानीय तहलाई बुझाउनु पर्नेछ । तर मर्मत सम्भार समितिलाई बुझाएको सामानको विवरणको एक प्रति सम्बन्धित <?php echo SITE_TYPE;?>मा बुझाउनु पर्नेछ ।</li>
        <br><span>
        ६). उपभोक्ता समितिले योजनासंग सम्बन्धित विल भर्पाइहरु, डोर हाजिरी फारामहरु, जिन्सी नगदी खाताहरु,समितिको निर्णय पुस्तिका आदि कागजात <?php echo SITE_TYPE;?> वा अन्य सरोकारवाला पदाधिकारीले मागेको बखत उपलब्ध गराउनु पर्ने छ र त्यसको लेखा परीक्षण पनि गराउन सकिनेछ ।</li>
        <br><span>
        ७). योजनाको सार्वजनिक परीक्षण, सुचना पाटी, आम्दानी खर्चको सार्वजनिकरण, तथा अन्य पारदर्शिता सम्बन्धी प्रावधानको पालना गर्नु पर्नेछ।</li>
        <br><span>
        ८). उपभोक्ता समितिले कार्यदेश लिएर लामो समय सम्म योजना संचालन नगर्ने, योजनाको आय व्ययको विवरण दुरुस्त नराखी रकमको दुरुपयोग गरेमा सरकारी बाँकि सरह असुल उपर गरिने छ ।</li>
        <br><span>
        ९). योजना सम्पन्न भएपछि स्थानीय तहबाट जाँच पास गरी फरफारकको प्रमाण पत्र लिनु पर्दछ ।साथै योजना हस्तान्तरण लिई आवश्यक मर्मत संभारको व्यवस्था सम्बन्धित उपभोक्ताहरुले नै गर्नु पर्नेछ।</li>
        <br>१०). यस संझौतामा उल्लेख नभएका कुराहरु प्रचलित कानुन अनुसार हुनेछ।</li>
        <br>११). योजनाको लागि चाहिने आवश्यक कागजात यसै साथ संलग्न गरिएकोछ ।</li>
        <br>१२). उपभोक्ता समितिको पदाधिकारीहरुको नागरिकताको प्रतिलिपि संलग्न गरेका छौ ।</li>
        <br>१३). कुनै सामाग्री खरिद गर्दा आन्तरिक राजस्व कार्यालयबाट स्थायी लेखा नम्वर र मुल्य अभिबृद्धि कर दर्ता प्रमाण पत्र प्राप्त व्यक्ति वा फर्म संस्था वा कम्पनीबाट खरिद गरी सोही अनुसारको विल भरपाई आधिकारीक व्यक्तिबाट प्रमाणित गरी पेश गर्नु पर्नेछ ।</li>
        <br>१४). मूल्य अभिबृद्धि कर (VAT) लाग्ने बस्तु तथा सेवा खरिद गर्दा रु २०,०००।– भन्दा बढी मूल्यको सामाग्रीमा अनिवार्य रुपमा मूल्य अभिबृद्धि कर दर्ता प्रमाणपत्र प्राप्त गरेका व्यक्ति फर्म संस्था वा कम्पनीबाट खरिद गर्नु पर्नेछ । साथै उक्त विलमा उल्लिखित मु.अ.कर बाहेकको रकममा १.५% अग्रीम आयकर बापत करकट्टि गरी बाँकी रकम मात्र सम्वन्धित सेवा प्रदायकलाई भुक्तानी हुनेछ । रु २०,०००।– भन्दा कम मूल्यको सामाग्री खरिदमा पान नम्वर लिएको व्यक्ति वा फर्मबाट खरिद गर्नु पर्नेछ । अन्यथा खरिद गर्ने पदाधिकारी स्वयम् जिम्मेवार हुनेछ ।</li>
        <br>१५). डोजर रोलर लगायतका मेशिनरी सामान भाडामा लिएको एवम् घर बहालमा लिई विल भरपाई पेश भएको अवस्थामा १०% प्रतिशत घर भाडा कर एबम् बहाल कर तिर्नु पर्नेछ ।</li>
        <br>१६). प्रशिक्षकले पाउने पारिश्रमिक एवम् सहभागीले पाउने भत्तामा प्रचलित नियमानुसार कर लाग्नेछ ।</li>
        <br>१७). निर्माण कार्यको हकमा शुरु लागत अनुमानका कुनै आईटमहरुमा परिर्वतन हुने भएमा अधिकार प्राप्त व्यक्ति÷कार्यालयबाट लागत अनुमान संसोधन गरे पश्चात मात्र कार्य गराउनु पर्नेछ । यसरी लागत अुनमान संशोधन नगरी कार्य गरेमा उपभोक्ता समिति÷समुहनै जिम्मेवार हुनेछ ।</li>
        <br>१८). उपभोक्ता समितिले काम सम्पन्न गरिसकेपछि बाँकी रहन गएका खप्ने सामानहरु मर्मत संभार समिति गठन भएको भए सो समितिलाई र सो नभए सम्वन्धित कार्यालयलाई बुझाउनु पर्नेछ । तर मर्मत समितिलाई बुझाएको सामानको विवरण एक प्रति सम्वन्धित कार्यालयलाई जानकारीको लागि बुझाउनु पर्नेछ ।</li>
        <br>१९). भवन ट्रष्ट जस्ता भौतिक संरचना निर्माणको लागि सम्झौता गर्न आउदा भवन ट्रष्टको नक्सा पास गरेको प्रमाण पेश गर्न पर्नेछ ।</li>
        <?php  if(!empty($rules_result)):
        foreach($rules_result as $data):?>
    <li> <?=$data->rule?> </li>
        <?php  endforeach;endif;?>

 </div>
<div style="margin-left:10px;">
     <h4><u>कार्यालयको जिम्मेवारी तथा पालना गरिने शर्तहरुः </u> </h4>
     
         १). आयोजनाको वजेट, उपभोक्ता समितिको काम, कर्तव्य तथा अधिकार, खरिद, लेखाङ्कन, प्रतिवेदन आदि विषयमा उपभोक्ता समितिका पदाधिकारीहरुलाई अनुशिक्षण कार्यक्रम सञ्चालन गरिनेछ । </li>
        <br>२). आयोजनामा आवश्यक प्राविधिक सहयोग कार्यालयबाट उपलव्ध गराउन सकिने अवस्थामा गराईनेछ र नसकिने अवस्था भएमा उपभोक्ता समितिले बाह्य बजारबाट सेवा परामर्श अन्तर्गत सेवा लिन सक्नेछ ।</li> 
        <br>३). आयोजनाको प्राविधिक सुपरिवेक्षणका लागि कार्यालयको तर्फबाट प्राविधिक खटाईनेछ । उपभोक्ता समितिबाट भएको कामको नियमित सुपरिवेक्षण गर्ने जिम्मेवारी निज प्राविधिकको हुनेछ ।</li> 
        <br>४). पेश्की लिएर लामो समयसम्म आयोजना संचालन नगर्ने उपभोक्ता समितिलाई कार्यालयले नियम अनुसार कारवाही गर्नेछ ।</li>
        <br>५). श्रममुलक प्रविधिबाट कार्य गराउने गरी लागत अनुमान स्वीकृत गराई सोही बमोजिम सम्झौता गरी मेशिनरी उपकरणको प्रयोगबाट कार्य गरेको पाईएमा त्यस्तो उपभोक्ता समितिसंग सम्झौता रद्ध गरी उपभोक्ता समितिलाई भुक्तानी गरिएको रकम मुल्यांकन गरी बढी भएको रकम सरकारी बाँकी सरह असुल उपर गरिनेछ ।</li>
        <br>६). आयोजना सम्पन्न भएपछि कार्यालयबाट जाँच पास गरी फरफारक गर्नु पर्नेछ ।</li>
        <br>७). आवश्यक कागजात संलग्न गरी भुक्तानी उपलव्ध गराउन सम्वन्धित उपभोक्ता समितिबाट अनुरोध भई आएपछि उपभोक्ता समितिको बैंक खातामा भुक्तानी दिनु पर्नेछ । </li>
        <br>८). यसमा उल्लेख नभएका कुराहरु प्रचलित कानून वमोजिम हुनेछ । </li>
     
 </div>
 
                                              <h4>माथि उल्लेख भए बमोजिमका शर्तहरु पालना गर्न हामी निम्न पक्षहरु मन्जुर गर्दछौं ।</h4>
                                              <h4>उपभोक्ता समितिको तर्फबाट </h4>
                                              <div class="mycontent">
                                              	<table class="table table-bordered table-responsive">
                                              	<tr>
                                                	<th class="myWidth25 text-center">सि. नं</th>
                                                    <th class="myWidth25 text-center">पद</th>
                                                    <th class="myWidth25 text-center">नाम/थर</th>
                                                    <th class="myWidth25 text-center">दस्तखत</th>
                                                </tr>
                                                 <?php 
                                               $data1=Costumerassociationdetails::find_by_post_plan_id(1,$_GET['id']);
                                                $data2=Costumerassociationdetails::find_by_post_plan_id(3,$_GET['id']);
                                                $data3=Costumerassociationdetails::find_by_post_plan_id(4,$_GET['id'])
                                              ?>
                                               
                                                <tr>
                                                    <td><?php echo convertedcit(1);?></td>
                                                    <td><?php echo Postname::getName(1);?></td>
                                                    <td><?php echo $data1->name;?></td>
                                                    <td>&nbsp;</td>                                                    
                                                </tr>
                                                <tr>
                                                    <td><?php echo convertedcit(2);?></td>
                                                    <td><?php echo Postname::getName(3);?></td>
                                                    <td><?php echo $data2->name;?></td>
                                                    <td>&nbsp;</td>   
                                                </tr>
                                                <td><?php echo convertedcit(3);?></td>
                                                <td><?php echo Postname::getName(4);?></td>
                                                    <td><?php echo $data3->name;?></td>
                                                    <td>&nbsp;</td>   
                                                
                                             
                                                 </table>
                                             <h4>कार्यालयको तर्फबाट </h4>
                                                 <div class="mycontent">
                                                   <table class="table table-bordered table-responsive">
                                                     <tr>
                                                       <td class="myWidth25 myCenter">योजना शाखा</td>
                                                       <td class="myWidth25 myCenter">सम्झौता गर्ने अधिकारि</td>
                                                     </tr>
                                                     <tr>
                                                         <td>दस्तखत:</td>
                                                         <td>दस्तखत:</td>
                                                     </tr>
                                                     <tr>
                                                       <td>
                                                           <select name="worker1" class="form-control worker" id="worker_1" >
                                                          <option value="">छान्नुहोस्</option>
                                                          <?php foreach($workers as $worker){?>
                                                            <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                          <?php }?>
                                                        </select>
                                                        <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                      </form></div>
                                                        </td>
                                                       </td>
                                                      </form>
                                              </div>
                                                    <td>नाम : <?php echo $name = Workerdetails::getName($more_plan_details->samjhauta_party);?></td>
                                                     </tr>
                                                     <tr>
                                                         <td>पद:</td>
                                                         <td>पद: <?php echo $more_plan_details->post_id_3;?></td>
                                                     </tr>
                                                     <tr>
                                                          <td>ठेगाना: <?php echo SITE_LOCATION;?>-<?php echo SITE_HEADING;?>  </td>
                                                          <td>ठेगाना: <?php echo SITE_LOCATION;?>-<?php echo SITE_HEADING;?>  </td>
                                                     </tr>
                                                     <tr>
                                                       <td colspan="2" class="text-right">मिति
                                                       <?php echo convertedcit($more_plan_details->miti); ?></td>
                                                     </tr>
                                                   </table>

                                                    <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                                                  </div>
											
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