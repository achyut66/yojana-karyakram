<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
 $data1=  Plandetails1::find_by_id($_GET['id']);
 $fiscal = FiscalYear::find_by_id($data1->fiscal_id);
$data=  Contractentryfinal::find_by_status(1,$_GET['id']);
$contractor_details=  Contractordetails::find_by_id($data->contractor_id);
$result= Contractmoredetails::find_by_plan_id($_GET['id']);
 $ward_address=WardWiseAddress();
        $address= getAddress();
        $date_selected= $_GET['date_selected'];
$url = get_base_url();
$user = getUser();
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
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>कार्यादेश  पत्र  print page:: <?php echo SITE_SUBHEADING;?></title>
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
									
									<h5 class="marginright1.5 letter-title-four"><?php echo $ward_address;?></h5>
									<h5 class="marginright1.5 letter-title-three"><?php echo SITE_SECONDSUBHEADING;?></h5>
									</div>
                    <div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino"> योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        <div class="myspacer20"></div>
										
										<div class="subject"><u>विषय:- कार्यादेश दिईएको बारे ।</u></div>
										<div class="myspacer20"></div>
                                                                               <div class="bankname">श्री <?php echo $contractor_details->contractor_name; ?><br/>
                                                                                  <?= $contractor_details->contractor_address?>
                                       
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											
                                                                                          यस कार्यालयको स्वीकृत बार्षिक योजना अनुसार तपशिलको विवरणमा उल्लेख भए बमोजिमको योजना संचालन गर्न  मिति <?=  convertedcit($result->miti) ?> गते तपाई सँग भएको संझौतामा उल्लिखत शर्तहरु लागु हुने गरी यस कार्यालयको मिति <?=  convertedcit($result->work_order_date) ?> को निर्णय अनुसार यो कार्यादेश दिईएको छ । 
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table-bordered myWidth100">
                                            	<tr>
                                                	<td class="myWidth50">आर्थिक बर्ष : </td>
                                                    <td><?php echo convertedcit(Fiscalyear::getName($data1->fiscal_id));?></td>
                                                </tr>
                                                <tr>
                                                <td> योजनाको नाम : </td>
                                                <td><?php echo $data1->program_name; ?></td>
                                          </tr>
                                           <tr>
                                               <td>बिषयगत क्षेत्र किसिम : </td>
                                               <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>शिर्षकगत किसिम : </td>
                                               <td><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></td>
                                           </tr>                                       
                                         
                                                <tr>
                                                	<td>उपशिर्षकगत किसिम :  </td>
                                                    <td><?php echo Topicareatypesub::getName($data1->topic_area_type_sub_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td>अनुदानको किसिम : </td>
                                                    <td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td>विनियोजन किसिम : </td>
                                                    <td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                <tr>	
                                                	<td>कार्यादेश दिईएको रकम रु : </td>
                                                    <td>रु.<?php echo convertedcit(placeholder($result->work_order_budget));?></td>
                                                </tr>
                                                <tr>
                                                	<td> योजना संचालन हुने स्थान :  </td>
                                                    <td><?php echo convertedcit($result->venue);?></td>
                                                </tr>
                                                <tr>
                                                	<td> योजना शुरु हुने मिति : </td>
                                                    <td><?php echo convertedcit($result->start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td> योजना सम्पन्न हुने मिति : </td>
                                                    <td><?php echo convertedcit($result->completion_date);?></td>
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