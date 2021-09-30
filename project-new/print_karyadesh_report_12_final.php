<?php require_once("includes/initialize.php");
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$program_id= $_GET['id'];
$ward_address=WardWiseAddress();
$address= getAddress();
$date_selected= $_GET['date_selected'];
?>
    <?php
          $program_details=  Plandetails1::find_by_id($_GET['id']);
          $fiscal = FiscalYear::find_by_id($program_details->fiscal_id); 
          $program_more_details= Programmoredetails::find_by_program_id_and_sn($program_id, $_GET['sn']);
           if($program_more_details->type_id == 5)
                       {
                           $u_samiti = Upabhoktasamitiprofile::find_by_id($program_more_details->enlist_id);
                        //   print_r($u_samiti);exit;
                           $name= $u_samiti->program_organizer_group_name;
                            $address1 = SITE_LOCATION.', वडा न: '.convertedcit($u_samiti->program_organizer_group_address);
                       }
                       else
                       {
                             $name =Enlist::getName1($program_more_details->enlist_id);  
                             $address1 = Enlist::getAddress($program_more_details->enlist_id);
                       }  
          $program_payment= Programpayment::find_by_program_id_and_sn($program_id, $_GET['sn']);
          $program_payment_final = Programpaymentfinal::find_by_program_id_and_sn($program_id, $_GET['sn']);
          if(!empty($program_payment))
          {
            $program_peski= convertedcit($program_payment->payment_amount);
          }
          else
          {
            $program_peski= convertedcit(0);
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
?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>कार्यक्रम संझौता कार्यादेश । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    
   <div class="myPrintFinal">
<div class="userprofiletable">
             <div class="printPage">
   <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
                    <h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
												<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
												<h5 class="margin1em letter_title_three"><?php echo $ward_address;?></h5>
                    
                    <div class="myspacer"></div>
									
									
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit($date_selected); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">कार्यक्रम दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        <div class="myspacer20"></div>
										
										<div class="subject">विषय:- सिफारिस सम्बन्धमा |</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री <?php echo SITE_LOCATION;?><br/>
                                       <?php echo SITE_ADDRESS;?> <!--(कार्यक्रमको संचालन गर्ने उपभोक्ता समितिको ठेगाना)-->
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											उपरोक्त बिषयमा श्री <b><u> <?= $name  ?></u></b> ले यस वडा कार्यालयमा <b><u><?php echo $program_details->program_name;?></u></b> कार्यक्रम  सम्पन्न भएकाले अन्तिम भुक्तानीको लागि सिफारिस पाऊं भनि दिएको निबेदन अनुसार यस वडा कार्यालयबाट ऊक्त कार्यक्रमको स्थल गत निरीक्षण गर्दा कार्यक्रमको काम सम्पन्न भएको देखिएकोले नियम अनुसार अन्तिम भुक्तानी  दिनुहुन अनुरोध छ |
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table-bordered  myWidth100">
                                            	<tr>
                                                	<td class="myWidth50">कार्यक्रमको नाम : </td>
                                                    <td><?php echo $program_details->program_name;?></td>
                                                </tr>
                                                <tr>
                                                	<td>ठेगाना : </td>
                                                    <td><?php echo SITE_NAME. convertedcit($program_details->ward_no);?></td>
                                                </tr>
                                                <tr>
                                                <td>कार्यक्रमको बिषयगत क्षेत्रको नाम</td>
                                                <td><?php echo Topicarea::getName($program_details->topic_area_id); ?></td>
                                          </tr>
                                           <tr>
                                               <td>कार्यक्रमको  शिर्षकगत नाम</td>
                                               <td><?php echo Topicareatype::getName($program_details->topic_area_type_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td>कार्यक्रमको  उपशिर्षकगत नाम</td>
                                               <td><?php echo Topicareatypesub::getName($program_details->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                         
                                                <tr>
                                                	<td>अनुदानको किसिम : </td>
                                                    <td><?php echo Topicareaagreement::getName($program_details->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td>विनियोजन किसिम : </td>
                                                    <td><?php echo Topicareainvestment::getName($program_details->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                 <tr>
                                                	<td><?php echo SITE_TYPE;?>बाट अनुदान रकम : </td>
                                                    <td>रु.<?php echo convertedcit($program_details->investment_amount);?></td>
                                                 </tr>
                                                <tr>
                                                    <td>कार्यदेश दिएको  रकम</td>
                                                    <td>रु.<?php echo convertedcit($program_more_details->work_order_budget);?></td>
                                                  </tr>
                                                <tr>
                                                	<td>पेस्की  दिएको  रकम </td>
                                                    <td><?= $program_peski ?></td>
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
                                 </div>
                            </div>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->

