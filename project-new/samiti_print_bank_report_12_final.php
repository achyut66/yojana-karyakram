<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
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
$ward_address=WardWiseAddress();
$address= getAddress();
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data2=  Samitimoreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Samiticostumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Samitiplantotalinvestment::find_by_plan_id($_GET['id']);
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
									<h1 class="marginright1.5 letter-title-one"><?php echo SITE_LOCATION;?></h1>
									<h5 class="marginright1.5 letter-title-two"><?php echo $address;?></h5>
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
                                   
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
										 <div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
										<div class="chalanino">चलानी नं: </div>
                                                                                 <div class="myspacer20"></div>
										
										<div class="subject">   विषय:-  सिफारिस सम्बन्धमा |</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo SITE_LOCATION;?><!--(योजनाको संचालन गर्ने उपभोक्ता समितिको नाम)--><br>
                                       <?php echo SITE_ADDRESS;?> <!--(योजनाको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											उपरोक्त बिषयमा श्री <b><u> <?php echo $data3->program_organizer_group_name;?></u></b> ले यस वडा कार्यालयमा <b><u><?php echo $data1->program_name;?></u></b> योजना  सम्पन्न भएकाले अन्तिम भुक्तानीको लागि सिफारिस पाऊं भनि दिएको निबेदन अनुसार यस वडा कार्यालयबाट ऊक्त योजनाको स्थल गत निरीक्षण गर्दा योजनाको काम सम्पन्न भएको देखिएकोले नियम अनुसार अन्तिम भुक्तानी  दिनुहुन अनुरोध छ |
										</div>
										
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table-bordered myWidth100">
                                            	<tr>
                                                	<td class="myWidth50">योजनाको नाम : </td><td> <?php echo $data1->program_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td >ठेगाना : </td><td><?php echo SITE_NAME. convertedcit($data1->ward_no);?></td>
                                                </tr>
                                               <tr>
                                                <td>योजनाको बिषयगत क्षेत्रको नाम</td>
                                                <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>योजनाको  शिर्षकगत नाम</td>
                                               <td><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>योजनाको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($data1->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                         
                                                <tr>
                                                	<td >अनुदानको किसिम : </td><td> <?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td >विनियोजन किसिम : </td><td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td >संस्था / समितिबाट अनुदान रु : </td><td>रु.<?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td >अन्य निकायबाट प्राप्त अनुदान रु : </td><td> रु.<?php echo convertedcit($data4->agreement_other);?></td>
                                                </tr>
                                                <tr>
                                                	<td >संस्था / समितिबाट नगद साझेदारी रु : </td><td> रु.<?php echo convertedcit($data4->costumer_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td >अन्य साझेदारी रु : </td><td> रु.<?php echo convertedcit($data4->other_agreement);?></td>
                                                </tr>
                                                <tr>
                                                	<td >संस्था / समितिबाट जनश्रमदान रु : </td><td> रु.<?php echo convertedcit($data4->costumer_investment);?></td>
                                                </tr>
                                                <tr>
                                                	<td >कुल लागत अनुमान जम्मा रु : </td><td> रु.<?php echo convertedcit($data4->total_investment);?></td>
                                                </tr>
                                                 <tr>
                                                    <td>कार्यदेश दिएको  रकम</td>
                                                    <td>रु.<?php echo convertedcit($data4->bhuktani_anudan);?></td>
                                                  </tr>
                                                <tr>
                                                	<td >योजना शुरु हुने मिति : </td><td> <?php echo convertedcit($data2->yojana_start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td >योजना सम्पन्न हुने मिति : </td><td> <?php echo convertedcit($data2->yojana_sakine_date);?></td>
                                                </tr>
                                                

                                            </table>
                                        </div>
										<div class="myspacer30"></div>
	
                                            <div class="oursignature mymarginright" > सदर गर्ने <br>
                                                                                        <?php 
                                                                                            if(!empty($worker1))
                                                                                            {
                                                                                                echo $worker1->authority_name."<br/>";
                                                                                                echo $worker1->post_name;
                                                                                            }
                                                                                        ?>
                                                                                        
                                                                                    </div>
                                                                               
                                                                                <div class="oursignatureleft mymarginleft" style="margin-left:10px;"> योजना शाखा   <br/>
                                                                                        <?php 
                                                                                            if(!empty($worker3))
                                                                                            {
                                                                                                echo $worker3->authority_name."<br/>";
                                                                                                echo $worker3->post_name;
                                                                                            }
                                                                                        ?>
                                                                                </div>
                                            <div class="myspacer"></div>
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->