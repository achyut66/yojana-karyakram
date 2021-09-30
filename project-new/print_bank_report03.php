<?php require_once("includes/initialize.php"); require 'menu/header_script.php';
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$program_id=$_GET['id'];
$user = getUser();
?>
    <?php $data1=  Plandetails1::find_by_id($_GET['id']);
    $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
    $data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
    $data4=Plantotalinvestment::find_by_plan_id($_GET['id']);
	$fiscal = FiscalYear::find_by_id($data1->fiscal_id); 
         $sn_result= Programmoredetails::find_by_program_id($program_id);
        if(isset($_POST['submit']))
        {
     $program_more_details= Programmoredetails::find_by_program_id_and_sn($program_id,$_POST['sn']);	
     $program_payment= Programpayment::find_by_program_id_and_sn($program_id,$_POST['sn']);	
        }
    ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>कार्यादेश  पत्र । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">कार्यादेश पत्र | <a href="letters_select.php" class="btn">पछि जानुहोस</a></h2>
                    
                    <div class="OurContentFull" >
                        <form method="post">
                           <table class="table table-bordered">
                                            <tr>
                                            <td  class="myTextalignRight myWidth50">कार्यादेश न:</td>
                                            <td>
                                                 <select class="sn1" name="sn" required>
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
                                                    <input type="submit" value="submit" name="submit" class="btn"/>
                                                </td>
                                            </tr>
                                        </table>                           
                        </form>
                        <?php  if (!empty($program_more_details)): ?>
                    	<h2>कार्यादेश पत्र  दिईएको बारे ।</h2> 
                      <div class="myPrint"><a href="print_bank_report_05_final.php" target="_blank">प्रिन्ट गर्नुहोस</a></div>
                        <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    <div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
									<h4 class="margin1em letter_title_two"><?php echo SITE_HEADING;?> </h4>
									<h5 class="margin1em letter_title_three"><?php echo SITE_ADDRESS;?></h5>
									<div class="myspacer"></div>
									
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit(generateCurrDate()); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">योजना दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									<div class="chalanino">चलानी नं: </div>
                                                                        <div class="myspacer20"></div>
										
										<div class="subject">विषय:- कार्यादेश दिईएको बारे ।</div>
										<div class="myspacer20"></div>
                                                                                <div class="bankname">श्री <?= Enlist::getName1($program_more_details->enlist_id) ?><br/>
                                                                                    ठेगाना :  <?= Enlist::getAddress($program_more_details->enlist_id) ?>
                                       
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार तपशिलको विवरणमा उल्लेख भए बमोजिमको कार्यक्रम संचालन गर्न यस कार्यालयको मिति <?=  convertedcit($program_more_details->work_order_date) ?> को निर्णय अनुसार यो कार्यादेश दिईएको छ ।
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table table-bordered table-responsive myWidth100">
                                            	<tr>
                                                	<td class="myWidth50 myTextalignRight">आर्थिक बर्ष : </td>
                                                    <td><?php echo convertedcit(Fiscalyear::getName($data1->fiscal_id));?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">कार्यादेश नं : </td>
                                                    <td><?php echo  convertedcit($program_more_details->sn);?></td>
                                                </tr>
                                                <tr>
                                                <td class="myTextalignRight">कार्यक्रमको नाम : </td>
                                                <td><?php echo $data1->program_name; ?></td>
                                          </tr>
                                           <tr>
                                               <td class="myTextalignRight">बिषयगत क्षेत्र किसिम : </td>
                                               <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
                                           </tr>
                                           <tr>
                                               <td class="myTextalignRight">शिर्षकगत किसिम : </td>
                                               <td><?php echo Topicareatypesub::getName($data1->topic_area_type_sub_id); ?></td>
                                           </tr>                                       
                                         
                                                <tr>
                                                	<td class="myTextalignRight">उपशिर्षकगत किसिम :  </td>
                                                    <td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">अनुदानको किसिम : </td>
                                                    <td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td class="myTextalignRight">विनियोजन किसिम : </td>
                                                    <td>रु.<?php echo convertedcit($data1->investment_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">कार्यादेश दिईएको रकम रु : </td>
                                                    <td>रु.<?php echo convertedcit($program_more_details->work_order_budget);?></td>
                                                </tr>
                                                
                                                <tr>
                                                	<td class="myTextalignRight">पेश्की  दिईएको रकम रु : </td>
                                                    <td>रु.<?php echo convertedcit($program_payment->payment_amount);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">कार्यक्रम संचालन हुने स्थान :  </td>
                                                    <td><?php echo convertedcit($program_more_details->venue);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">कार्यक्रम शुरु हुने मिति : </td>
                                                    <td><?php echo convertedcit($program_more_details->start_date);?></td>
                                                </tr>
                                                <tr>
                                                	<td class="myTextalignRight">कार्यक्रम सम्पन्न हुने मिति : </td>
                                                    <td><?php echo convertedcit($program_more_details->completion_date);?></td>
                                                </tr>
                                                
                                                

                                            </table>
                                        </div>
										
										<div class="myspacer"></div>
									</div>
                                
                            </div>
                      <?php endif; ?>
                        </div>
                  </div>
                </div><!-- main menu ends -->
            </div>
         </div>   
    </div><!-- top wrap ends -->
    <?php include("menuincludes/footer.php"); ?>