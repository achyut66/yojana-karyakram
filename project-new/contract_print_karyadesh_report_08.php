<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$two_digit=array(0=>"",1=>"एक",2=>"दुइ",3=>"तीन",4=>"चार",5=>"पाच",6=>"छ",7=>"सात",8=>"आठ",9=>"नौ",10=>"दश",11=>"एघार",12=>"बाह्र",13=>"तेह्र",14=>"चौध",15=>"पन्ध्र" ,16=>"सोह्र",
    17=>"सत्र",18=>"अठार",19=>"उन्नाइस",20=>"बिस",21=>"एक्काइस", 22=>"बाइस", 23=>"तेईस", 24=>"चौविस", 25=>"पच्चिस", 26=>"छब्बिस", 27=>"सत्ताइस", 28=>"अठ्ठाईस", 29=>"उनन्तिस", 
    30=>"तिस", 31=>"एकत्तिस", 32=>"बत्तिस", 33=>"तेत्तिस" ,34=>"चौँतिस", 35=>"पैँतिस", 36=>"छत्तिस", 37=>"सैँतीस", 38=>"अठतीस", 39=>"उनन्चालीस", 
    40=>"चालीस", 41=>"एकचालीस", 42=>"	बयालीस", 43=>"त्रियालीस", 44=>"चवालीस", 45=>"पैँतालीस", 46=>"छयालीस", 47=>"सच्चालीस", 48=>"अठचालीस", 49=>"उनन्चास", 
    50=>"पचास", 51=>"एकाउन्न", 52=>"बाउन्न", 53=>"त्रिपन्न", 54=>"चउन्न", 55=>"पचपन्न", 56=>"छपन्न", 57=>"सन्ताउन्न", 58=>"अन्ठाउन्न", 59=>"उनन्साठी", 
    60=>"साठी", 61=>"एकसट्ठी", 62=>"बयसट्ठी", 63=>"त्रिसट्ठी", 64=>"चौंसट्ठी", 65=>"पैंसट्ठी", 66=>"छयसट्ठी", 67=>"सतसट्ठी", 68=>"अठसट्ठी", 69=>"उनन्सत्तरी", 
    70=>"सत्तरी", 71=>"एकहत्तर", 72=>"बहत्तर", 73=>"त्रिहत्तर", 74=>"चौहत्तर", 75=>"पचहत्तर", 76=>"छयहत्तर", 77=>"सतहत्तर", 78=>"अठहत्तर", 79=>"उनासी", 
    80=>"असी", 81=>"एकासी", 82=>"बयासी", 83=>"त्रियासी", 84=>"चौरासी", 85=>"पचासी", 86=>"छयासी", 87=>"सतासी", 88=>"अठासी", 89=>"उनान्नब्बे", 
    90=>"नब्बे", 91=>"एकान्नब्बे", 92=>"बयानब्बे", 93=>"त्रियान्नब्बे", 94=>"चौरान्नब्बे", 95=>"पन्चानब्बे", 96=>"छयान्नब्बे", 97=>"सन्तान्नब्बे", 98=>"अन्ठान्नब्बे", 99=>"उनान्सय");
$matra="मात्र |";

       $result_data=  Contractmoredetails::find_by_plan_id($_GET['id']);
	if(!empty($result_data))
        {
            $worker=  Contractmoredetails::find_by_plan_id($_GET['id']);
	}
        else
     {
            $worker=  Contractmoredetails::setEmptyObjects();
     }
	
	
$ward_address=WardWiseAddress();
$address= getAddress();	
$plan_selected=Plandetails1::find_by_id($_GET['id']);
$contract_details=  Contractinfo::find_by_plan_id($_GET['id']);
$contract_amount=round($contract_details->contract_amount, 2, PHP_ROUND_HALF_UP);
$contract_amount1 =round($contract_details->contract_amount_, 2, PHP_ROUND_HALF_UP);
$contract_bid_final= Contractentryfinal::find_by_status(1,$_GET['id']);
//print_r($contract_bid_final);exit;
if(!empty($contract_bid_final))
{
    $contractor_details=  Contractordetails::find_by_id($contract_bid_final->contractor_id);
}
else
{
    $contractor_details=  Contractordetails::setEmptyObjects();
}
 $contract_ti  = Contract_total_investment::find_by_plan_id($_GET['id']);
 
//print_r($contractor_details);exit;
?>
                     <?php $data=  Plandetails1::find_by_id($_GET['id']);

                            $fiscal = FiscalYear::find_by_id($data->fiscal_id);
						
                        ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>ठेक्का  संझौता फाराम print page:: <?php echo SITE_SUBHEADING;?></title>
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
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                <div class="maincontent">
                    <h2 class="headinguserprofile">ठेक्का संझौता फाराम <a class="btn" href="contract_letter_dashboard.php"> पछी  जानुहोस </a></h2>
                   
                    <div class="OurContentFull">
                        <form method="get" action="contract_print_karyadesh_report_08_final.php">
                    	<h2>ठेक्का संझौता फाराम 
                        <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div></h2>
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
                                        <h4>ठेक्का संझौता फाराम</h4><br>
										
										<div class="banktextdetails1">
                                                                                    यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार देहायको योजना संचालन गर्न आज भएको यस संझौता पत्र अनुसार पहिलो पक्ष श्री  <?php echo SITE_LOCATION;?> र दोश्रो पक्ष श्री <?php echo $contractor_details->contractor_name;?> विच देहाय शर्तहरु पालना गर्ने गरी यो संझौता गरि लियौं दियौं । 
                                        	
                                              <div class="mycontent" >
                     <table class="table table-bordered table-responsive">
                                        
                                      <tr>
                                            <td class="myWidth50">योजनाको नाम</td>
                                            <td><?php echo $data->program_name;?></td>
                                          </tr>
                                      <tr>
                                      <tr>
                                            <td>आयोजना सचालन हुने स्थान / वार्ड नं</td>
                                            <td><?php echo SITE_LOCATION;?> - <?php echo convertedcit($data->ward_no);?></td>
                                          </tr>
                                      <tr>
                                                <td>योजनाको बिषयगत क्षेत्रको नाम</td>
                                                <td><?php echo Topicarea::getName($data->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>योजनाको  शिर्षकगत नाम </td>
                                               <td><?php echo Topicareatype::getName($data->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>योजनाको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($data->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                           <tr>
                                               <td>योजनाको अनुदानको किसिम</td>
                                               <td><?php echo Topicareaagreement::getName($data->topic_area_agreement_id); ?></td>
                                          </tr> 
                                          <tr>
                                               <td>योजनाको विनियोजन किसिम</td>
                                               <td><?php echo Topicareainvestment::getName($data->topic_area_investment_id); ?></td>
                                          </tr>
                                          <tr>
                                            <td>अनुदान रु</td>
                                            <td>रु. <?php echo convertedcit($data->investment_amount);?></td>
                                           </tr>
                       </table>
                     </div>
                                               <?php $data= Contractmoredetails::find_by_plan_id($_GET['id']); ?>
                            <?php if(empty($data)){?><h3  class="myheader">ठेक्का संचालन विवरण भरिएको छैन...!! </h3><?php }else{?>
                         <h3 class="myheader">ठेक्का संचालन विवरण </h3>
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
                             </div>
                             <?php $final_result= Rule::find_by_plan_id($_GET['id']);?>
                            </div><!-- yojana ends -->
                            				  <h4>सम्झौताका शर्तहरु</h4>
                                            <ul style="list-style-type: circle;">
                                                <li style="list-style-type: circle"><b><?php echo $plan_selected->program_name;?> </b>योजनाको काम सम्पन्न भएपछि पहिलो पक्षले दोश्रो पक्षलाई जम्मा रु ‍<?php echo convertedcit(placeholder($contract_ti->contract_total_amount));?> अक्षरुपी <?php echo convert($contract_ti->contract_total_amount);?> मात्र भुत्तानी दिनेछ ।</li>
                                                <li><b><?php echo $plan_selected->program_name;?></b> योजना मिति <?php echo convertedcit($worker->start_date);?>देखि शुरु गरी मिति <?php echo convertedcit($worker->completion_date);?> सम्ममा पुरा गर्नु पर्नेछ ।</li>
                                                <li>दोश्रो पक्षले निर्माणकार्य गर्दा लाग्ने सम्पुण गुणस्तरिय समानहरुको प्रयोग प्राबिधिकबाट जचाँएर मात्र प्रयोग गर्नु पर्नेछ ।</li>
                                                <li>दोश्रो पक्षले काम सम्पन्न भएपछि फाईनल विल र कार्यसम्पन्न प्रतिबेदन  वा रनिङ विलको आधारमा मात्र पहिलो पक्षले भुक्तानी दिनेछ ।</li>
                                                <li>दोश्रो पक्षले निर्माण कार्यमा बाल श्रमिकको प्रयोग गर्न पाईने छैन ।</li>
                                                <li>यस संझौता अबधिमा काममा कुनै समस्या उत्पन्न भएमा दुबै पक्षको सहमितमा समाधान गरिने छ ।</li>
                                                <li>दोश्रो पक्षले काममा पेशकी माग गरेमा बैंक ग्यारेन्टी पेश गरेपछि मात्र भ्याट बाहेकको रकमको २० प्रतिशत सम्म पहिलो पक्षले उपलब्ध गराउने छ ।</li>
                                                <li>पेश्की लिएर लामो समयसम्म योजना संचालन नभएमा कार्यालयले नियम अनुसार कारवाही गर्नेछ ।</li>
                                                <li>यस संझौतामा उल्लेख नभएका कुराहरु प्रचलित कानून वमोजिम हुनेछ ।</li>
                                                <?php  if(!empty($final_result)):
                                                    foreach($final_result as $data):?>
                                                     <li> <?=$data->rule?> </li>
                                                    <?php  endforeach;endif;?>
                                            </ul><!-- samjhauta list ends -->
                                            <a href = "settings_rules.php" class="btn btn-success" target="_blank" >सर्त थप्नुहोस</a>
                                            <h4>माथि उल्लेख भए बमोजिमका शर्तहरु पालना गर्न हामी निम्न पक्षहरु मन्जुर गर्दछौं ।</h4><br><br>
                                              <h4>ठेकदारको तर्फबाट </h4>
                                              <div class="mycontent">
                                              <table class="table table-bordered table-responsive">
                                                    <tr>
                                                      <td>योजना/    कार्यक्रमको  संचालन गर्ने</td>
                                                      <td>निर्माण ब्यवोसायी</td>
                                                    </tr>
                                                    <tr>
                                                      <td>नाम</td>
                                                      <td ><?php echo $contractor_details->contractor_name;?></td>
                                                    </tr>
                                                    <tr>
                                                      <td>ठेगाना</td>
                                                      <td><?php echo $contractor_details->contractor_address;?></td>
                                                    </tr>
                                                    <tr>
                                                      <td>दस्तखत</td>
                                                      <td>&nbsp; </td>
                                                    </tr>
                                                    <tr>
                                                      <td>मिति</td>
                                                      <td><?php echo convertedcit($worker->miti);?></td>
                                                    </tr>

                                                  </table>

                                              </div><!-- upabhokta ends -->
                                              <h4>स्थानीय तहको तर्फबाट</h4>
                                              <div class="mycontent">
                                              	<table class="table table-bordered table-responsive">
                                                	<tr>
                                                    	<th class="myWidth25 text-center">सि.नं</th>
                                                        <th class="myWidth25 text-center">पद</th>
                                                        <th class="myWidth25 text-center">नामथर</th>
                                                        <th class="myWidth25 text-center">दस्तखत</th>
                                                    </tr>
                                                    <tr>
                                                    	<td>१</td>
                                                         <td><?php echo $worker->post_id_3;?></td>
                                                       <td><?php echo Workerdetails::getName($worker->samjhauta_party);?></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                    	<td colspan="2" class="text-right">मिति</td>
                                                        <td colspan="2"><?php echo convertedcit(generateCurrDate()); ?></td>
                                                    </tr>
                                                </table>
                                                </form>
                                              </div>
                                              
											
										</div><!-- bank details ends -->
										<div class="myspacer"></div>
										
									</div>
                                <!--<div class="settingsMenu1"><a href="settings_topic_add_sub.php">सह शिर्षक थप्नुहोस +</a></div>-->
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
          
           
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>
    <script>
        JQ(document).ready(function(){
           JQ(document).on("click","#sarta",function(){
               var id = JQ("#sarta").val();
                $.ajax({
                    url: 'settings_rules.php',
                    type: 'POST',
                    data: {id:id},
                    contentType: 'application/json; charset=utf-8',
                    success: function (response) {
                        console.log(response);
                        //alert(response.status);
                                                 }
                       }); 

           }); 
        });
    </script>