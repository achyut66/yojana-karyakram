<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
 $ward_address=WardWiseAddress();
 $address= getAddress();
$date_selected= $_GET['date_selected'];
?>
    <?php
    $program_id=$_GET['id'];
    $data1= Plandetails1::find_by_id($_GET['id']);
    $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Planamountwithdrawdetails::find_by_plan_id($_GET['id']);
    $sn_result= Programmoredetails::find_by_program_id($program_id);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
         $program_more_details= Programmoredetails::find_by_program_id_and_sn($program_id, $_GET['sn']);
              if($program_more_details->type_id == 5)
                       {
                           $u_samiti = Upabhoktasamitiprofile::find_by_id($program_more_details->enlist_id);
                           $name= $u_samiti->program_organizer_group_name;
                       }
                       else
                       {
                             $name =Enlist::getName1($program_more_details->enlist_id);   
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
$program_payment_final= Programpaymentfinal::find_by_program_id_and_sn($program_id, $_GET['sn']);
$program_payment= Programpayment::find_by_program_id_and_sn($_GET['id'],$_GET['sn']);
?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>रकम भुक्तानी सम्बन्धमा ।  print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <div class="myPrintFinal" > 
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
										
<div class="chalanino">कार्यक्रम दर्ता नं :<?php echo convertedcit($_GET['id']);?></div>
										<div class="myspacer20"></div>
										
										<div class="subject">   विषय:- रकम भुक्तानी सम्बन्धमा ।</div>
										<div class="myspacer20"></div>
										<div class="bankname">श्री आर्थिक प्रशासन शाखा<br/>
                                                                                   <?= SITE_NAME.','.SITE_ZONE ?>
                                       
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											  यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार देहायको कार्यक्रम संचालन गर्न श्री <?= $name ?>लाई मिति  <?= convertedcit($program_more_details->work_order_date)  ?>  मा कार्यदेश दिईएकोमा तोकिएको समय भित्रै काम सम्पन गरि भुक्तानी माग गरेकाले तपशिल बमोजिमको रकम  भुक्तानी दिन हुन अनुरोध छ ।
</div>
										
                                        
                                        	<div class="subject">तपशिल</div>
                                 
                                            <table class=" table-bordered  myWidth100">
                                                <tr>
                                                	<td class="myWidth50">कार्यादेश नं: </td>
                                                    <td> <?php echo convertedcit($program_more_details->sn);?></td>
                                                </tr>                                            	
                                              <tr>
                                                    <td>बिनियोजन श्रोत र व्याख्या: </td>
                                                    <td> <?php echo $data1->parishad_sno;?></td>
                                                </tr>
                                                <tr>
                                                	<td>कार्यक्रमको नाम : </td>
                                                    <td><?php echo convertedcit($data1->program_name);?></td>
                                                </tr>
                                                <tr>
                                                	<td>भुक्तानी पाउनेको नाम: </td>
                                                    <td><?= $name ?></td>
                                                </tr>
                                               
                                                <tr>
                                                	<td>कार्यादेश  दिईएको रकम : </td>
                                                        <td>रु. <?php echo convertedcit(placeholder($program_more_details->work_order_budget));?></td>
                                                </tr>
                                              
                                                <!-- change made-->
                                               
                                               
                                                <tr>
                                                	<td>पेश्की भुक्तानी लगेको कट्टी रकम  : </td>
                                                    <td> रु. <?php echo convertedcit(placeholder($program_payment->payment_amount));?></td>
                                                </tr>
                                               
                                                 <!-- change made-->
                                                <tr>
                                                	<td>धरौटी कट्टी रकम : </td>
                                                    <td>रु. <?php echo convertedcit(placeholder($program_payment_final->deposit_amount));?></td>
                                                </tr>
                                                <tr>
                                                	<td>जम्मा कट्टी रकम  : </td>
                                                    <td> रु.<?php echo convertedcit(placeholder($program_payment_final->total_amount));?></td>
                                                </tr>
<tr>
                                                	<td>हाल भुक्तानी दिनु पर्ने खुद रकम   : </td>
                                                    <td> रु.<?php echo convertedcit(placeholder($program_payment_final->net_total_amount));?></td>
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
               
    </div><!-- top wrap ends -->
   