<?php require_once("includes/initialize.php"); 
if(!$session->is_logged_in()){ redirect_to("logout.php");}
if(!isset($_GET['id']) && isset($_SESSION['set_plan_id']))
{
  redirectUrl();
}
$ward_address=WardWiseAddress();
        $address= getAddress();
$program_id=$_GET['id'];
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
      $program_more_details= Programmoredetails::find_by_program_id_and_sn($program_id,$_POST['sn']);
                       if($program_more_details->type_id == 5)
                       {
                           $u_samiti = Upabhoktasamitiprofile::find_by_id($program_more_details->enlist_id);
                           $name= $u_samiti->program_organizer_group_name;
                       }
                       else
                       {
                             $name =Enlist::getName1($program_more_details->enlist_id);   
                       }   
     $program_payment= Programpayment::find_by_program_id_and_sn($program_id,$_POST['sn']);	
        }
$print_history = PrintHistory::find_by_url_and_plan_id($url, $_GET['id']);
$date = !empty($print_history)? $print_history->nepali_date : generateCurrDate();
$workers = Workerdetails::find_all();
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
    ?>
<?php include("menuincludes/header.php"); ?>
<!-- js ends -->
<title>कार्यादेश सम्बन्धमा । print page:: <?php echo SITE_SUBHEADING;?></title>

</head>

<body>
    <?php include("menuincludes/topwrap.php"); ?>
    <div id="body_wrap_inner"> 
    	<div class="">
            <div class="">
                
                <div class="maincontent" >
                    <h2 class="headinguserprofile">कार्यादेश सम्बन्धमा  || <a href="letters_select_programs.php" class="btn">पछी जानुहोस </a></h2>
                    
                    <div class="OurContentFull" >
                        <form method="post">
                           <table class="table table-bordered">
                                            <tr>
                                            <td>कार्यादेश नं:</td>
                                            <td>
                                                 <select required class="sn1" name="sn">
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
                                                    <input type="submit" value="खोज्नुहोस" name="submit" class="btn"/>
                                                </td>
                                            </tr>
                                        </table>                           
                        </form>
                        <?php  if (!empty($program_more_details)): ?>
                    	<h2>कार्यादेश सम्बन्धमा  ।</h2> 
                      	<form method="get" action="print_karyadesh_report_03_final.php" target="_blank" >
                            <div class="myPrint"><input type="hidden" name="id" value="<?=$program_id?>" />
                            <input type="hidden" name="detail_id" value="<?=$program_more_details->id?>" />
                            <input type="hidden" name="payment_id" value="<?=$program_payment->id?>" />
                            
                            <input type="submit" value="प्रिन्ट गर्नुहोस" name="submit" /></div>  <div class="userprofiletable" id="div_print">
                        	<div class="printPage">
                                    	<div class="printlogo"><img src="images/emblem_nepal.png" alt="Logo"></div>
									<h1 class="margin1em letter_title_one"><?php echo SITE_LOCATION;?></h1>
												<h4 class="margin1em letter_title_two"><?php echo $address;?></h4>
												<h5 class="margin1em letter_title_three"><?php echo $ward_address;?></h5>
<div class="subjectbold">टिप्पणी आदेश</div>
                                    
									<div class="myspacer"></div>
									
									<div class="printContent">
											<div class="mydate">मिति : <input type="text" name="date_selected" value="<?php echo generateCurrDate(); ?>" id="nepaliDate5" /></form></div>
										<div class="patrano">पत्र संख्या : <?php echo convertedcit($fiscal->year); ?></div>
									<div class="chalanino">कार्यक्रम दर्ता नं : <?php echo convertedcit($_GET['id'])?></div>
									
										
										<div class="subject">विषय:- कार्यादेश सम्बन्धमा  ।</div>
										<div class="myspacer20"></div>
                                                                                <div class="bankname">श्रीमान्
                                       
                                        </div>
                                                                               
										<div class="banktextdetails"  >
											यस कार्यालयको स्वीकृत बार्षिक कार्यक्रम अनुसार देहायको कार्यक्रम संचालन गर्न श्री <?= $name ?>ले यस कार्यालयमा दिएको निबेदन अनुसार  <?=$program_more_details->venue ?>मा  मिति <?= convertedcit($program_more_details->start_date)?> देखि कार्यक्रम शुरु गरि मिति <?= convertedcit($program_more_details->completion_date)?> भित्र कार्यक्रम सम्पन्न गर्ने गरि कार्यदेश दिनका लागी श्रीमान समक्ष यो टिप्पणी पेश गरको छु । 
										</div>
                                        
                                        	<div class="subject">तपशिल</div>
                                            <table class="table table-bordered table-responsive myWidth100">
                                                
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
                                        <div class="myspacer20"></div>
                                        <div class="oursignature mymarginright"> सदर गर्ने <br> 
                                            <select name="worker1" class="form-control worker" id="worker_1">
                                                <option value="">छान्नुहोस्</option>
                                                <?php foreach($workers as $worker){?>
                                                    <option value="<?=$worker->id?>" <?php if($print_history->worker1 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                <?php }?>
                                            </select>
                                            <input type="text" name="post" class="form-control" id="post_1" value="<?=$worker1->post_name?>">
                                        </div>
                                        <div class="oursignatureleft mymarginright"> पेस गर्ने <br/>
                                            <select name="worker2" class="form-control worker" id="worker_2">
                                                <option value="">छान्नुहोस्</option>
                                                <?php foreach($workers as $worker){?>
                                                    <option value="<?=$worker->id?>" <?php if($print_history->worker2 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>
                                                <?php }?>
                                            </select>
                                            <input type="text" name="post" class="form-control" id="post_2" value="<?=$worker2->post_name?>">
                                        </div>
                                        <!--<div class="oursignatureleft margin4" style="margin-left: 245px">सिफारिस गर्ने<br/> -->
                                        <!--    <select name="worker4" class="form-control worker" id="worker_4">-->
                                        <!--        <option value="">छान्नुहोस्</option>-->
                                        <!--        <?php foreach($workers as $worker){?>-->
                                        <!--            <option value="<?=$worker->id?>" <?php if($print_history->worker4 == $worker->id){echo 'selected="selected"';}?>><?=$worker->authority_name?></option>-->
                                        <!--        <?php }?>-->
                                        <!--    </select>-->
                                        <!--    <input type="text" name="post" class="form-control" id="post_4" value="<?=$worker4->post_name?>"></form>-->
                                        <!--</div>-->
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