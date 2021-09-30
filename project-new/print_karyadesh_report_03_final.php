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
$date_selected= $_GET['date_selected'];
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Plantotalinvestment::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
     $program_more_details= Programmoredetails::find_by_id($_GET['detail_id']);
       if($program_more_details->type_id == 5)
                       {
                           $u_samiti = Upabhoktasamitiprofile::find_by_id($program_more_details->enlist_id);
                           $name= $u_samiti->program_organizer_group_name;
                       }
                       else
                       {
                             $name =Enlist::getName1($program_more_details->enlist_id);   
                       }   
$program_payment= Programpayment::find_by_id($_GET['payment_id']);
        ?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>कार्यादेश सम्बन्धमा  । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
    	<div class="userprofiletable">
             <div class="printPage">
<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
             	<h1 class="marginright1 letter_title_one"><?php echo SITE_LOCATION;?></h1>
                    <h4 class="marginright1 letter_title_two"><?php echo $address;?> </h4>
                    <h5 class="marginright1 letter_title_three"><?php echo $ward_address;?></h5>
                                    
									<div class="myspacer"></div>
									<div class="subjectboldright letter_subject">टिप्पणी आदेश</div>
                    <div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">कार्यक्रम दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									
                                    
										<div class="subject">विषय:- कार्यादेश सम्बन्धमा  ।</div>
										<div class="myspacer20"></div>
										
                                                                   
										<div class="bankname">श्रीमान्
                                       
                                        </div>
                                                                               
										<div class="banktextdetails "  >
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार देहायको कार्यक्रम संचालन गर्न श्री <?= $name ?>ले यस कार्यालयमा दिएको निबेदन अनुसार  <?=$program_more_details->venue ?>मा  मिति <?= convertedcit($program_more_details->start_date)?> देखि कार्यक्रम शुरु गरि मिति <?= convertedcit($program_more_details->completion_date)?> भित्र कार्यक्रम सम्पन्न गर्ने गरि कार्यदेश दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । </div>
										
                                        
                                        	<div class="subject">तपशिल</div>
                                             <table class="table-bordered  myWidth100">
                                            		<tr>
                                                	<td class="myWidth50">आर्थिक बर्ष : </td>
                                                    <td><?php echo convertedcit(Fiscalyear::getName($data1->fiscal_id));?></td>
                                                </tr>
                                                <tr>
                                                    <td class="myWidth50">बिनियोजन श्रोत र व्याख्या: </td>
                                                    <td> <?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                	<td>कार्यादेश नं : </td>
                                                    <td><?php echo  convertedcit($program_more_details->sn);?></td>
                                                </tr>
                                                 <tr>
                                                <td>कार्यक्रमको नाम : </td>
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
                                                    <td>रु.<?php echo convertedcit(placeholder($program_more_details->work_order_budget));?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td>पेश्की  दिईएको रकम रु : </td>
                                                    <td>रु.<?php echo convertedcit(placeholder($program_payment->payment_amount));?></td>
                                                </tr>
                                                <tr>
                                                	<td>कार्यक्रम संचालन हुने स्थान :  </td>
                                                    <td><?php echo convertedcit($program_more_details->venue);?></td>
                                                </tr>
                                                <tr>
                                                	<td>कार्यक्रम शुरु हुने मिति : </td>
                                                    <td><?php echo convertedcit($program_more_details->start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td>कार्यक्रम सम्पन्न हुने मिति : </td>
                                                    <td><?php echo convertedcit($program_more_details->completion_date);?></td>
                                                </tr>
                                                
                                                

                                            </table>
                                        </div>
										<div class="myspacer30"></div>
                                        <div class="oursignature mymarginright"> सदर गर्ने <br>
                                            <?php 
                                            if(!empty($worker1))
                                            {
                                                echo $worker1->authority_name."<br/>";
                                                echo $worker1->post_name;
                                            }
                                            ?>
                                        </div>
                                        <div class="oursignatureleft mymarginright"> पेस गर्ने  <br/>
                                            <?php 
                                            if(!empty($worker2))
                                            {
                                                echo $worker2->authority_name."<br/>";
                                                echo $worker2->post_name;
                                            }
                                            ?>
                                        </div>
                                        <div class="myspacer"></div>
                                        <hr>
                                        <hr>
									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->