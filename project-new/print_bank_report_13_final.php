<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$user = getUser();
$ward_address=WardWiseAddress();
$address= getAddress();
$date_selected= $_GET['date_selected'];
$url = get_base_url();
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
if(empty($print_history))
{
    $print_history = new PrintHistory;
}
$print_history->url = get_base_url();
$print_history->nepali_date = $date_selected;
$print_history->english_date = DateNepToEng($date_selected);
$print_history->user_id = $user->id;
$print_history->plan_id = $_GET['id'];
$print_history->worker1 = $_GET['worker1'];
$print_history->worker2 = $_GET['worker2'];
$print_history->worker3 = $_GET['worker3'];
$print_history->worker4 = $_GET['worker4'];
$print_history->save();
if(!empty($_GET['worker1']))
{
$worker1 = Workerdetails::find_by_id($_GET['worker1']);
}
else
{
    $worker1 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker2']))
{
$worker2 = Workerdetails::find_by_id($_GET['worker2']);
}
else
{
    $worker2 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker3']))
{
$worker3 = Workerdetails::find_by_id($_GET['worker3']);
}
else
{
    $worker3 = Workerdetails::setEmptyObject();
}
if(!empty($_GET['worker4']))
{
$worker4 = Workerdetails::find_by_id($_GET['worker4']);
}
else

{
    $worker4 = Workerdetails::setEmptyObject();
}
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Plantotalinvestment::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title> सिफारिस सम्बन्धमा | print page:: <?php echo SITE_SUBHEADING;?></title>
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
             	
                                <div style="color:red">
                                    <h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>

                                    <h5 class="marginright1.5 letter-title-four">
                                        <?php
                                        if($user->mode==user){
                                            echo $user->ward_add;
                                        }else {
                                            echo $ward_address;
                                        }
                                        ?>
                                    </h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                </div> 
                                   
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										 <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino">चलानी नं: </div>
                                                                                
										<div class="subject">   विषय:-  रनिंग विल भुक्तानी सम्बन्धमा |</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo SITE_LOCATION;?><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--><br>
                                       <?php echo SITE_ADDRESS;?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस <strong><?php echo SITE_TYPE;?></strong> वडा नं. <strong><?php echo convertedcit($data1->ward_no)?></strong> मा संचालित <strong><?php echo $data1->program_name?></strong> योजनाको लागि यस
											<strong><?php echo SITE_TYPE;?></strong>को <strong><?php echo $data3->program_organizer_group_name?></strong>बाट विनियोजित रकम रु. 
											<strong><?php echo convertedcit($data1->investment_amount);?></strong>  
											बाट मिति <strong><?php echo convertedcit($data2->yojana_sakine_date)?></strong> मा सम्पन्न भएको योजनाको कार्य सम्पन्न गरि भुक्तानीको 
											लागी मिति <strong><?php echo convertedcit($data2->miti);?></strong> मा <strong><?php echo $data3->program_organizer_group_name;?></strong> उपभोक्ता समितिबाट अनुरोध भइ आएकोमा सो योजना सार्वजनिक खरिद नियमावली २०६४ को नियम ९७ को उपनियम ९ मा व्यवस्था भए अनुसार उपभोक्ता समिति वा लाभग्राही समुदायबाट संचालित हुने निर्माण कार्यमा लोडर, ऐक्साभेटर, डोजर, ग्रेडर विटुमिन डिस्ट्रीव्युटर, विटुमिन व्याइलर जस्ता हेव्वी मेसिनहरु प्रयोग नगरि श्रममुलक प्राविधिबाट कार्य गराउने गरी लागत अनुमान स्वीकृत गराई सोही बमोजिम सम्झौता गरी मेशिनरी उपकरणको प्रयोग र उपनियम १० वमोजिम कुनै निर्माण व्यवसायी वा सव–कन्ट्राक्टरबाट कार्य नगरेको पाईएकोले उक्त योजनाको रकम 
											मुल्यांकनले भुक्तानी दिनहुन हाम्रो सिफारिस मन्जुर छ । 
										
										</div>
										
                                        	<div class="subject">तपशिल</div>
                                            <table class="table-bordered myWidth100">
                                            	<tr>
                                                	<td class="myWidth50 myTextalignLeft">योजनाको नाम : </td><td> <?php echo $data1->program_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft" >ठेगाना : </td><td><?php echo SITE_NAME; ?>-<?php echo  convertedcit($data3->program_organizer_group_address);?></td>
                                                </tr>
                                               <tr>
                                                <td class="myTextalignLeft">योजनाको बिषयगत क्षेत्रको नाम</td>
                                                <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td class="myTextalignLeft">योजनाको  शिर्षकगत नाम</td>
                                               <td><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td class="myTextalignLeft">योजनाको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($data1->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                         
                                                <tr>
                                                	<td class="myTextalignLeft">अनुदानको किसिम : </td><td> <?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">विनियोजन किसिम : </td><td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td class="myTextalignLeft"><?php echo SITE_TYPE;?>बाट अनुदान रु : </td><td>रु.<?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <?php if($data4->agreement_other!=0){?>
                                                <tr>
                                                	<td class="myTextalignLeft">अन्य निकायबाट प्राप्त अनुदान रु : </td><td> रु.<?php echo convertedcit($data4->agreement_other);?></td>
                                                </tr>
                                                <?php }else{}?>
                                                
                                                <?php if($data4->costumer_agreement!=0){?>
                                                <tr>
                                                	<td class="myTextalignLeft">उपभोक्ताबाट नगद साझेदारी रु : </td><td> रु.<?php echo convertedcit($data4->costumer_agreement);?></td>
                                                </tr>
                                                <?php }else{}?>
                                                
                                                <?php if($data4->other_agreement!=0){?>
                                                <tr>
                                                	<td class="myTextalignLeft">अन्य साझेदारी रु : </td><td> रु.<?php echo convertedcit($data4->other_agreement);?></td>
                                                </tr>
                                                <?php }else{}?>
                                                <tr>
                                                	<td class="myTextalignLeft">उपभोक्ताबाट जनश्रमदान रु : </td><td> रु.<?php echo convertedcit($data4->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">कुल लागत अनुमान जम्मा रु : </td><td> रु.<?php echo convertedcit($data4->total_investment);?></td>
                                                </tr>
                                                 <tr>
                                                    <td class="myTextalignLeft">कार्यदेश दिएको  रकम</td>
                                                    <td>रु.<?php echo convertedcit($data4->bhuktani_anudan);?></td>
                                                  </tr>
                                                <tr>
                                                	<td class="myTextalignLeft" >योजना शुरु हुने मिति : </td><td> <?php echo convertedcit($data2->yojana_start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजना सम्पन्न हुने मिति : </td><td> <?php echo convertedcit($data2->yojana_sakine_date);?></td>
                                                </tr>
                                                

                                            </table>
                                        </div>
										<div class="myspacer20"></div>
										<div class="oursignatureleft mymarginright" style="margin-right: 5%;">वडा प्राबिधिक<br/>
                                                                                    <?php 
                                                                                        if(!empty($worker1))
                                                                                        {
                                                                                            echo $worker1->authority_name."<br/>";
                                                                                            echo $worker1->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
										<div class="oursignature mymarginright">वडाध्यक्ष<br>
                                                                                    <?php 
                                                                                        if(!empty($worker2))
                                                                                        {
                                                                                            echo $worker2->authority_name."<br/>";
                                                                                            echo $worker2->post_name;
                                                                                        }
                                                                                    ?>
                                                                                </div>
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->