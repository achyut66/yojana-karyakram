<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}

 $data1=  Plandetails1::find_by_id($_GET['id']);
 $data2=  Moreplandetails::find_by_plan_id($_GET['id']);
$data3=  Costumerassociationdetails0::find_by_plan_id($_GET['id']);
$data4=Plantotalinvestment::find_by_plan_id($_GET['id']);
 $fiscal = FiscalYear::find_by_id($data1->fiscal_id);
 $id=$_GET['detail_id'];
// echo $program_id;exit;
 $program_more_details=Programmoredetails::find_by_id($id); 
  if($program_more_details->type_id == 5)
                       {
                           $u_samiti = Upabhoktasamitiprofile::find_by_id($program_more_details->enlist_id);
                           $name= $u_samiti->program_organizer_group_name;
                       }
                       else
                       {
                             $name =Enlist::getName1($program_more_details->enlist_id);   
                       }    
$date_selected= $_GET['date_selected'];
 $ward_address=WardWiseAddress();
 $address= getAddress();
?>
<?php include("menuincludes/header1.php"); ?>
<!-- js ends -->
<title>कार्यादेश  पत्र  print page:: <?php echo SITE_SUBHEADING;?></title>

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
									<div class="subjectbold letter_subject">टिप्पणी आदेश</div>
									<div class="printContent">
										<div class="mydate">मिति : <?php echo convertedcit(($date_selected)); ?></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">कार्यक्रम दर्ता नं : <?php echo convertedcit($_GET['id'])?></div></div>
									
                                                                        <div class="myspacer20"></div>
										
										<div class="subject"> विषय:- कार्यादेश सम्बन्धमा  ।</div>
										<div class="myspacer20"></div>
                                                                     
                                                                               <div class="bankname">श्रीमान् </div>
										<div class="banktextdetails"  >
											  यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार देहायको कार्यक्रम संचालन गर्न श्री  <?= $name ?>ले यस कार्यालयमा दिएको निबेदन अनुसार  <?= $program_more_details->venue ?>मा  मिति <?= convertedcit($program_more_details->start_date) ?> देखि कार्यक्रम शुरु गरि मिति  <?= convertedcit($program_more_details->completion_date) ?>  भित्र कार्यक्रम सम्पन्न गर्ने गरि कार्यदेश दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । 
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table-bordered myWidth100">
                                            <tr>
			     <td class="myWidth50">आर्थिक बर्ष :</td>
			     <td><?php echo convertedcit(Fiscalyear::getName($data1->fiscal_id));?></td>
			</tr>
			<tr>
			     <td>कार्यदेश नं :</td>
			     <td><?php echo  convertedcit($program_more_details->sn);?></td>
			</tr>
			<tr>
			     <td>कार्यदेशको नाम :</td>
			     <td><?php echo  convertedcit($program_more_details->work_name);?></td>
			</tr>
			<tr>
			     <td>कार्यक्रमको नाम :</td>
			     <td><?php echo $data1->program_name; ?></td>
			</tr>
			<tr>
			     <td>कार्यक्रम संचालन हुने स्थान :</td>
			     <td><?= $program_more_details->venue ?></td>
			</tr>
			<tr>
			     <td>बिषयगत क्षेत्र किसिम :</td>
			     <td><?php echo Topicarea::getName($data1->topic_area_id); ?></td>
			</tr>
			<tr>
			     <td>शिर्षकगत किसिम :</td>
			     <td><?php echo Topicareatype::getName($data1->topic_area_type_id); ?></td>
			</tr>
			<tr>
			     <td>उपशिर्षकगत किसिम:</td>
			     <td><?php echo Topicareatypesub::getName($data1->topic_area_type_sub_id);?></td>
			</tr>
			<tr>
			     <td>अनुदानको किसिम :</td>
			     <td><?php echo Topicareaagreement::getName($data1->topic_area_agreement_id);?></td>
			</tr>
			<tr>
			     <td>विनियोजन किसिम :</td>
			     <td><?php echo Topicareainvestment::getName($data1->topic_area_investment_id);?></td>
			</tr>
			<tr>
			     <td>कार्यादेश  रकम  :</td>
			     <td>रु.<?php echo convertedcit(placeholder($program_more_details->work_order_budget));?></td>
			</tr>
                                                
                                                

                                            </table>
                                        </div>
										<div class="myspacer30"></div>
                                        	
                                        <div class="oursignature mymarginright"> सदर गर्ने </div>
                                        <div class="oursignatureleft mymarginright">तयार गर्ने  </div>
                                        
                                        <div class="oursignatureleft mymarginright"> पेश गर्ने  </div>
                                        
                                        <div class="oursignatureleft margin4"> चेक/सिफारिस गर्ने       </dv>
                                        <div class="myspacer"></div>

									</div><!-- print page ends -->
                            </div><!-- userprofile table ends -->
                        </div><!-- my print final ends -->