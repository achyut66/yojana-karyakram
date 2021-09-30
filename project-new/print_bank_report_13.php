<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$user = getUser();
$workers = Workerdetails::find_all();
$url = get_base_url(1);
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);

if(!empty($print_history))
{
    $worker1 = Workerdetails::find_by_id($print_history->worker1);
    $worker2 = Workerdetails::find_by_id($print_history->worker2);
    $worker3 = Workerdetails::find_by_id($print_history->worker3);
    $worker4 = Workerdetails::find_by_id($print_history->worker4);
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
}
$ward_address=WardWiseAddress();
$address= getAddress();
$worker_ward = Workerdetails::find_by_sql("select * from worker_details where authority_ward_no =".$user->ward);
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);//print_r($data1);
    $data2=  Moreplandetails::find_by_plan_id($_GET['id']);//print_r($data2);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']); //print_r($data3);
    $data4=Plantotalinvestment::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
	//$group_heading = Costumerassociationdetails::find_by_plan_id ($_GET['id']);
	?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>योजना संझौता कार्यादेश । print page:: <?php echo SITE_SUBHEADING;?></title>
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
    	<div class="maincontent" >
    	    <form method="get" action="print_bank_report_13_final.php">
                    <h2 class="headinguserprofile">सिफारिस सम्बन्धमा | <a href="dashboard_bhuktani.php" class="btn">पछि जानुहोस</a> 
                    <div class="myPrint"><input type="hidden" name="id" value="<?=$_GET['id']?>" /><input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>
                    </h2>
                    <div class="OurContentFull" >
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="image-wrapper">
                                    <a href="#" ><img src="images/janani.png" align="left" class="scale-image"/></a>
                                    <div />
                                    
                                    <div class="image-wrapper">
                                    <a href="#" target="_blank" ><img src="images/bhaire.png" align="right" class="scale-image"/></a>
                                    <div />
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
                                    
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति :<input type="text" name="date_selected" value="<?php echo generateCurrDate();?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        <div class="myspacer20"></div>
										
										<div class="subject"><u>विषय:- रनिंग विल भुक्तानी सम्बन्धमा |</u></div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo SITE_LOCATION;?><br/>
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
                                            <table class="table table-bordered table-responsive myWidth100">
                                            	<tr>
                                                	<td class="myWidth50 myTextalignLeft">योजनाको नाम : </td>
                                                    <td><?php echo $data1->program_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">ठेगाना : </td>
                                                    <td><?php echo SITE_NAME;?>-<?php echo convertedcit($data3->program_organizer_group_address);?></td>
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
                                                	<td class="myTextalignLeft">अनुदानको किसिम : </td>
                                                    <td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">विनियोजन किसिम : </td>
                                                    <td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td class="myTextalignLeft"><?php echo SITE_TYPE;?>बाट अनुदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">अन्य निकायबाट प्राप्त अनुदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->agreement_other);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">उपभोक्ताबाट नगद साझेदारी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->costumer_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">अन्य साझेदारी रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->other_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">उपभोक्ताबाट जनश्रमदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">कुल लागत अनुमान जम्मा रकम : </td>
                                                    <td>रु.<?php echo convertedcit($data4->total_investment);?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myTextalignLeft">कार्यदेश दिएको  रकम</td>
                                                    <td>रु.<?php echo convertedcit($data4->bhuktani_anudan);?></td>
                                                  </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजना शुरु हुने मिति : </td>
                                                    <td><?php echo convertedcit($data2->yojana_start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignLeft">योजना सम्पन्न हुने मिति : </td>
                                                    <td><?php echo convertedcit($data2->yojana_sakine_date);?></td>
                                                </tr>
                                            </table>
                                        </div>
										
										<div class="myspacer20"></div>
										<div class="oursignatureleft mymarginright">वडा प्राबिधिक<br/>
                                                                                     <select name="worker1" class="form-control worker" id="worker_1" >
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($worker_ward as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                                                                </div>
										<div class="oursignature mymarginright">वडाध्यक्ष<br>
                                                                                    <select name="worker2" class="form-control worker" id="worker_2">
                                                                                        <option value="">छान्नुहोस्</option>
                                                                                        <?php foreach($worker_ward as $worker){?>
                                                                                        <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                    <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                                                                                										
									</div>
									</div>
                                
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
          
    </div><!-- top wrap ends -->